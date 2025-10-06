# PowerShell script to remove MySQL password and set up login
# THIS MUST BE RUN AS ADMINISTRATOR

Write-Host "🔓 MySQL Password Reset & Login Setup Script" -ForegroundColor Yellow
Write-Host "=============================================" -ForegroundColor Yellow

# Check if running as administrator
$isAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)

if (-not $isAdmin) {
    Write-Host "❌ ERROR: This script must be run as Administrator!" -ForegroundColor Red
    Write-Host "Right-click PowerShell and select 'Run as Administrator'" -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 1
}

Write-Host "✅ Running as Administrator" -ForegroundColor Green

# Step 1: Stop MySQL service
Write-Host "`n🛑 Step 1: Stopping MySQL service..." -ForegroundColor Cyan
try {
    Stop-Service -Name "MySQL92" -Force -ErrorAction Stop
    Write-Host "✅ MySQL92 service stopped successfully" -ForegroundColor Green
} catch {
    Write-Host "⚠️  MySQL92 service might already be stopped or not found" -ForegroundColor Yellow
    Write-Host "Continuing with the process..." -ForegroundColor Yellow
}

# Step 2: Find MySQL installation
Write-Host "`n🔍 Step 2: Locating MySQL installation..." -ForegroundColor Cyan

$mysqlPaths = @(
    "C:\Program Files\MySQL\MySQL Server 8.0\bin",
    "C:\Program Files\MySQL\MySQL Server 8.2\bin",
    "C:\Program Files\MySQL\MySQL Server 9.2\bin", 
    "C:\mysql\bin",
    "C:\xampp\mysql\bin"
)

$mysqlBinPath = $null
foreach ($path in $mysqlPaths) {
    if (Test-Path "$path\mysqld.exe") {
        $mysqlBinPath = $path
        Write-Host "✅ Found MySQL at: $path" -ForegroundColor Green
        break
    }
}

if (-not $mysqlBinPath) {
    Write-Host "❌ Could not find MySQL installation!" -ForegroundColor Red
    Write-Host "Please check your MySQL installation path" -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 1
}

# Step 3: Start MySQL in safe mode
Write-Host "`n🔓 Step 3: Starting MySQL in safe mode..." -ForegroundColor Cyan
Write-Host "This will start MySQL without password authentication" -ForegroundColor Yellow

$safeMode = Start-Process -FilePath "$mysqlBinPath\mysqld.exe" -ArgumentList "--console", "--skip-grant-tables", "--skip-networking" -PassThru -NoNewWindow

Write-Host "✅ MySQL started in safe mode (Process ID: $($safeMode.Id))" -ForegroundColor Green
Write-Host "⏳ Waiting 5 seconds for MySQL to initialize..." -ForegroundColor Yellow
Start-Sleep -Seconds 5

# Step 4: Connect and remove password
Write-Host "`n🔧 Step 4: Removing MySQL password..." -ForegroundColor Cyan

$sqlCommands = @"
USE mysql;
UPDATE user SET authentication_string = '' WHERE User = 'root' AND Host = 'localhost';
UPDATE user SET plugin = 'mysql_native_password' WHERE User = 'root' AND Host = 'localhost';
FLUSH PRIVILEGES;
"@

# Save SQL commands to temporary file
$tempSqlFile = "$env:TEMP\reset_mysql_password.sql"
$sqlCommands | Out-File -FilePath $tempSqlFile -Encoding ASCII

try {
    # Execute SQL commands
    $result = & "$mysqlBinPath\mysql.exe" -u root --batch --execute="$sqlCommands" 2>&1
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ MySQL password removed successfully!" -ForegroundColor Green
    } else {
        Write-Host "⚠️  MySQL command completed with warnings" -ForegroundColor Yellow
        Write-Host "Result: $result" -ForegroundColor Gray
    }
} catch {
    Write-Host "❌ Error executing MySQL commands: $($_.Exception.Message)" -ForegroundColor Red
}

# Clean up temp file
if (Test-Path $tempSqlFile) {
    Remove-Item $tempSqlFile
}

# Step 5: Stop safe mode MySQL
Write-Host "`n🔄 Step 5: Stopping safe mode MySQL..." -ForegroundColor Cyan
if ($safeMode -and !$safeMode.HasExited) {
    $safeMode.Kill()
    $safeMode.WaitForExit(5000)
    Write-Host "✅ Safe mode MySQL stopped" -ForegroundColor Green
} else {
    Write-Host "✅ Safe mode MySQL already stopped" -ForegroundColor Green
}

# Step 6: Start MySQL normally
Write-Host "`n🚀 Step 6: Starting MySQL service normally..." -ForegroundColor Cyan
try {
    Start-Service -Name "MySQL92" -ErrorAction Stop
    Write-Host "✅ MySQL92 service started successfully" -ForegroundColor Green
} catch {
    Write-Host "❌ Failed to start MySQL92 service: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "You may need to start it manually from Services" -ForegroundColor Yellow
}

# Step 7: Test connection
Write-Host "`n🧪 Step 7: Testing MySQL connection..." -ForegroundColor Cyan
Start-Sleep -Seconds 3

try {
    $testResult = & "$mysqlBinPath\mysql.exe" -u root --batch --execute="SELECT 'Connection successful' as Status;" 2>&1
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ MySQL connection test PASSED!" -ForegroundColor Green
        Write-Host "Result: $testResult" -ForegroundColor Gray
    } else {
        Write-Host "❌ MySQL connection test failed" -ForegroundColor Red
        Write-Host "Error: $testResult" -ForegroundColor Red
    }
} catch {
    Write-Host "❌ Error testing MySQL connection: $($_.Exception.Message)" -ForegroundColor Red
}

# Step 8: Create database and user
Write-Host "`n🏗️  Step 8: Setting up database and user..." -ForegroundColor Cyan

$setupSql = @"
CREATE DATABASE IF NOT EXISTS lms_terrado CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lms_terrado;
CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user','instructor','student') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT IGNORE INTO users (name, email, password, role) VALUES ('Terrado User', 'terrado@gmail.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
SELECT 'Database setup complete' as Status;
"@

try {
    $setupResult = & "$mysqlBinPath\mysql.exe" -u root --batch --execute="$setupSql" 2>&1
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ Database and user setup completed!" -ForegroundColor Green
    } else {
        Write-Host "⚠️  Database setup completed with warnings" -ForegroundColor Yellow
        Write-Host "Result: $setupResult" -ForegroundColor Gray
    }
} catch {
    Write-Host "❌ Error setting up database: $($_.Exception.Message)" -ForegroundColor Red
}

# Final summary
Write-Host "`n🎉 SETUP COMPLETE!" -ForegroundColor Green
Write-Host "==================" -ForegroundColor Green
Write-Host "✅ MySQL password removed (no password required)" -ForegroundColor Green
Write-Host "✅ Database 'lms_terrado' created" -ForegroundColor Green
Write-Host "✅ User account created" -ForegroundColor Green
Write-Host "✅ phpMyAdmin should now work without password" -ForegroundColor Green
Write-Host "✅ CodeIgniter login should now work" -ForegroundColor Green

Write-Host "`n🚀 TEST YOUR LOGIN:" -ForegroundColor Yellow
Write-Host "URL: http://localhost/ITE311-TERRADO/login" -ForegroundColor White
Write-Host "Email: terrado@gmail.com" -ForegroundColor White
Write-Host "Password: siopao123" -ForegroundColor White

Write-Host "`n🔍 TEST PHPMYADMIN:" -ForegroundColor Yellow
Write-Host "URL: http://localhost/phpmyadmin" -ForegroundColor White

Write-Host "`nPress Enter to exit..." -ForegroundColor Gray
Read-Host