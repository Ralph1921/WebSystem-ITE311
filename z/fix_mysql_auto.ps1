# Self-elevating PowerShell script to reset MySQL password
param([switch]$Elevated)

function Test-Admin {
    $currentUser = [Security.Principal.WindowsIdentity]::GetCurrent()
    $principal = New-Object Security.Principal.WindowsPrincipal($currentUser)
    return $principal.IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)
}

function Reset-MySQLPassword {
    Write-Host "=== MySQL Password Reset Starting ===" -ForegroundColor Cyan
    
    try {
        # Stop MySQL service
        Write-Host "Stopping MySQL service..." -ForegroundColor Yellow
        Stop-Service -Name "MySQL92" -Force -ErrorAction SilentlyContinue
        
        # Kill any remaining processes
        Get-Process -Name "mysqld*" -ErrorAction SilentlyContinue | Stop-Process -Force -ErrorAction SilentlyContinue
        Start-Sleep -Seconds 3
        
        # Create reset file
        $resetFile = "C:\xampp\mysql\data\mysql-reset.sql"
        $resetContent = @"
UPDATE mysql.user SET authentication_string = '', plugin = 'mysql_native_password' WHERE User = 'root';
UPDATE mysql.user SET Password = PASSWORD('') WHERE User = 'root';
FLUSH PRIVILEGES;
"@
        $resetContent | Out-File -FilePath $resetFile -Encoding ASCII -Force
        
        # Start MySQL with init file
        Write-Host "Starting MySQL with reset file..." -ForegroundColor Yellow
        $mysqldProcess = Start-Process -FilePath "C:\xampp\mysql\bin\mysqld.exe" -ArgumentList "--init-file=$resetFile" -PassThru -WindowStyle Hidden
        Start-Sleep -Seconds 10
        
        # Stop the process
        $mysqldProcess | Stop-Process -Force -ErrorAction SilentlyContinue
        Get-Process -Name "mysqld*" -ErrorAction SilentlyContinue | Stop-Process -Force -ErrorAction SilentlyContinue
        
        # Clean up
        Remove-Item $resetFile -Force -ErrorAction SilentlyContinue
        Start-Sleep -Seconds 3
        
        # Start MySQL service normally
        Write-Host "Starting MySQL service normally..." -ForegroundColor Yellow
        Start-Service -Name "MySQL92"
        Start-Sleep -Seconds 5
        
        # Test connection
        Write-Host "Testing connection..." -ForegroundColor Yellow
        $testResult = & "C:\xampp\mysql\bin\mysql.exe" -u root -e "SELECT 'SUCCESS!' as Result;" 2>&1
        
        if ($LASTEXITCODE -eq 0) {
            Write-Host "SUCCESS! MySQL password has been reset!" -ForegroundColor Green
            
            # Update phpMyAdmin config
            $configPath = "C:\xampp\phpMyAdmin\config.inc.php"
            if (Test-Path $configPath) {
                $config = Get-Content $configPath -Raw
                $config = $config -replace "\`$cfg\['Servers'\]\[\`$i\]\['password'\] = '.*?';", "`$cfg['Servers'][`$i]['password'] = '';"
                $config | Set-Content $configPath -Encoding UTF8
                Write-Host "phpMyAdmin configuration updated!" -ForegroundColor Green
            }
            
            Write-Host ""
            Write-Host "You can now access phpMyAdmin at: http://127.0.0.1/phpmyadmin/" -ForegroundColor Cyan
        } else {
            Write-Host "Connection test failed: $testResult" -ForegroundColor Red
        }
        
    } catch {
        Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red
    }
    
    Write-Host ""
    Write-Host "Press any key to exit..."
    $null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
}

# Check if running as admin, if not, restart elevated
if (-not (Test-Admin)) {
    Write-Host "Requesting administrator privileges..." -ForegroundColor Yellow
    try {
        Start-Process PowerShell -Verb RunAs -ArgumentList "-ExecutionPolicy Bypass -File `"$($MyInvocation.MyCommand.Path)`" -Elevated"
    } catch {
        Write-Host "Failed to elevate. Please run PowerShell as Administrator manually." -ForegroundColor Red
        pause
    }
    exit
}

if ($Elevated) {
    Reset-MySQLPassword
} else {
    Write-Host "This script will reset your MySQL root password to empty." -ForegroundColor Yellow
    Write-Host "Press any key to continue or Ctrl+C to cancel..."
    $null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
    Reset-MySQLPassword
}