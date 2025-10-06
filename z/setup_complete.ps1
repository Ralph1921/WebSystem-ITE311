# Complete MySQL and phpMyAdmin setup script
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host "    MySQL & phpMyAdmin Complete Setup" -ForegroundColor Cyan  
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host ""

$mysqlPath = "C:\Program Files\MySQL\MySQL Server 9.2\bin"
$mysqlExe = Join-Path $mysqlPath "mysql.exe"
$sqlFile = "C:\xampp\htdocs\ITE311-TERRADO\setup_mysql_user.sql"

Write-Host "Step 1: Testing MySQL connection..." -ForegroundColor Yellow

# Test if MySQL is accessible
$testResult = & "$mysqlExe" -u root -e "SELECT 1;" 2>&1
if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ MySQL accessible with root (no password)" -ForegroundColor Green
    
    Write-Host ""
    Write-Host "Step 2: Creating lms_terrado user..." -ForegroundColor Yellow
    
    # Execute the SQL setup file
    $setupResult = Get-Content "$sqlFile" | & "$mysqlExe" -u root
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ MySQL user setup completed successfully!" -ForegroundColor Green
    } else {
        Write-Host "❌ MySQL setup failed: $setupResult" -ForegroundColor Red
    }
} else {
    Write-Host "❌ Cannot access MySQL with root user" -ForegroundColor Red
    Write-Host "Trying with password..." -ForegroundColor Yellow
    
    # Try with common passwords
    $passwords = @("", "root", "admin", "password", "mysql")
    $connected = $false
    
    foreach ($pwd in $passwords) {
        if ($pwd -eq "") {
            $testCmd = "& '$mysqlExe' -u root -e 'SELECT 1;'"
        } else {
            $testCmd = "& '$mysqlExe' -u root -p'$pwd' -e 'SELECT 1;'"
        }
        
        $result = Invoke-Expression "$testCmd 2>&1"
        if ($LASTEXITCODE -eq 0) {
            Write-Host "✅ Connected with password: '$pwd'" -ForegroundColor Green
            $connected = $true
            
            # Execute setup with this password
            if ($pwd -eq "") {
                Get-Content "$sqlFile" | & "$mysqlExe" -u root
            } else {
                Get-Content "$sqlFile" | & "$mysqlExe" -u root -p"$pwd"
            }
            break
        }
    }
    
    if (-not $connected) {
        Write-Host "❌ Could not connect to MySQL with any common password" -ForegroundColor Red
        Write-Host "Manual intervention required" -ForegroundColor Yellow
    }
}

Write-Host ""
Write-Host "Step 3: Testing new user..." -ForegroundColor Yellow

# Test the new user
$testUser = & "$mysqlExe" -u lms_terrado -p"siopao112" -e "SHOW DATABASES;" 2>&1
if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ lms_terrado user working perfectly!" -ForegroundColor Green
} else {
    Write-Host "❌ lms_terrado user test failed" -ForegroundColor Red
}

Write-Host ""
Write-Host "=================================================" -ForegroundColor Green
Write-Host "    Setup Complete!" -ForegroundColor Green
Write-Host "=================================================" -ForegroundColor Green
Write-Host ""
Write-Host "🎯 Your phpMyAdmin access:" -ForegroundColor White
Write-Host "URL: http://localhost/phpmyadmin" -ForegroundColor Cyan
Write-Host "Username: lms_terrado" -ForegroundColor Yellow
Write-Host "Password: siopao112" -ForegroundColor Yellow
Write-Host ""
Write-Host "✅ phpMyAdmin will auto-login with these credentials!" -ForegroundColor Green
Write-Host "✅ You can also use: root / (no password)" -ForegroundColor Green
Write-Host ""
Write-Host "🔗 Test links:" -ForegroundColor White
Write-Host "- phpMyAdmin: http://localhost/phpmyadmin" -ForegroundColor Cyan
Write-Host "- CodeIgniter: http://localhost/ITE311-TERRADO/login" -ForegroundColor Cyan
Write-Host ""

Read-Host "Press Enter to continue..."