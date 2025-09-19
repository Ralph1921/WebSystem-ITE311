# Comprehensive XAMPP MariaDB Password Reset Script
Write-Host "=== XAMPP MariaDB Password Reset Tool ===" -ForegroundColor Cyan
Write-Host "This script will reset the MariaDB root password to empty" -ForegroundColor Yellow
Write-Host ""

# Check if running as administrator
$currentPrincipal = New-Object Security.Principal.WindowsPrincipal([Security.Principal.WindowsIdentity]::GetCurrent())
$isAdmin = $currentPrincipal.IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)

if (-not $isAdmin) {
    Write-Host "ERROR: This script must be run as Administrator!" -ForegroundColor Red
    Write-Host "Right-click PowerShell and select 'Run as Administrator'" -ForegroundColor Yellow
    pause
    exit 1
}

try {
    Write-Host "Step 1: Stopping MariaDB service..." -ForegroundColor Green
    Stop-Service -Name "MySQL92" -Force -ErrorAction SilentlyContinue
    
    # Kill any remaining processes
    Get-Process -Name "mysqld*" -ErrorAction SilentlyContinue | Stop-Process -Force -ErrorAction SilentlyContinue
    Start-Sleep -Seconds 3
    
    Write-Host "Step 2: Creating password reset file..." -ForegroundColor Green
    $resetFile = "C:\xampp\mysql\data\mysql-init.txt"
    $resetContent = @"
UPDATE mysql.user SET password = PASSWORD('') WHERE User = 'root';
UPDATE mysql.user SET authentication_string = '' WHERE User = 'root';
UPDATE mysql.user SET plugin = 'mysql_native_password' WHERE User = 'root';
FLUSH PRIVILEGES;
"@
    $resetContent | Out-File -FilePath $resetFile -Encoding ASCII
    
    Write-Host "Step 3: Starting MariaDB with init file..." -ForegroundColor Green
    $mysqldPath = "C:\xampp\mysql\bin\mysqld.exe"
    $arguments = @(
        "--defaults-file=C:\xampp\mysql\bin\my.ini",
        "--init-file=$resetFile",
        "--console"
    )
    
    $process = Start-Process -FilePath $mysqldPath -ArgumentList $arguments -PassThru -WindowStyle Hidden
    Start-Sleep -Seconds 10
    
    Write-Host "Step 4: Stopping and cleaning up..." -ForegroundColor Green
    $process | Stop-Process -Force -ErrorAction SilentlyContinue
    Get-Process -Name "mysqld*" -ErrorAction SilentlyContinue | Stop-Process -Force -ErrorAction SilentlyContinue
    
    # Remove the init file
    if (Test-Path $resetFile) {
        Remove-Item $resetFile -Force
    }
    
    Start-Sleep -Seconds 3
    
    Write-Host "Step 5: Starting MariaDB normally..." -ForegroundColor Green
    Start-Service -Name "MySQL92"
    Start-Sleep -Seconds 5
    
    Write-Host "Step 6: Testing connection..." -ForegroundColor Green
    $testResult = & "C:\xampp\mysql\bin\mysql.exe" -u root -e "SELECT 'Connection successful!' as Result;" 2>&1
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "SUCCESS! MariaDB root password has been reset!" -ForegroundColor Green
        Write-Host "You can now access phpMyAdmin without a password." -ForegroundColor Green
    } else {
        Write-Host "Connection test failed. Trying alternative method..." -ForegroundColor Yellow
        
        # Alternative method: Try with common passwords
        $passwords = @("", "root", "admin", "password")
        foreach ($pwd in $passwords) {
            $testCmd = if ($pwd -eq "") { 
                "& `"C:\xampp\mysql\bin\mysql.exe`" -u root -e `"SELECT 'Works!' as Result;`""
            } else {
                "& `"C:\xampp\mysql\bin\mysql.exe`" -u root -p$pwd -e `"SELECT 'Works!' as Result;`""
            }
            
            $result = Invoke-Expression $testCmd 2>$null
            if ($LASTEXITCODE -eq 0) {
                Write-Host "Found working password: '$pwd'" -ForegroundColor Green
                
                # Update phpMyAdmin config with working password
                $configPath = "C:\xampp\phpMyAdmin\config.inc.php"
                $config = Get-Content $configPath
                $config = $config -replace "\$cfg\['Servers'\]\[\$i\]\['password'\] = '.*';", "`$cfg['Servers'][`$i]['password'] = '$pwd';"
                $config | Set-Content $configPath
                
                Write-Host "Updated phpMyAdmin configuration." -ForegroundColor Green
                break
            }
        }
    }
    
} catch {
    Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "Please try running XAMPP Control Panel as Administrator and restart MySQL there." -ForegroundColor Yellow
} finally {
    Write-Host ""
    Write-Host "Script completed. Try accessing phpMyAdmin now:" -ForegroundColor Cyan
    Write-Host "http://127.0.0.1/phpmyadmin/" -ForegroundColor White
    Write-Host ""
    pause
}