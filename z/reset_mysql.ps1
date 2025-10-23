# Reset MySQL/MariaDB root password in XAMPP
Write-Host "Resetting MySQL root password..." -ForegroundColor Yellow

try {
    # Stop MySQL service
    Write-Host "Stopping MySQL service..." -ForegroundColor Green
    Stop-Service -Name "MySQL92" -Force -ErrorAction SilentlyContinue
    Start-Sleep -Seconds 3
    
    # Kill any remaining mysqld processes
    Get-Process -Name "mysqld" -ErrorAction SilentlyContinue | Stop-Process -Force -ErrorAction SilentlyContinue
    
    # Start MySQL in safe mode
    Write-Host "Starting MySQL in safe mode..." -ForegroundColor Green
    $safeMode = Start-Process -FilePath "C:\xampp\mysql\bin\mysqld.exe" -ArgumentList "--skip-grant-tables", "--skip-networking" -PassThru -WindowStyle Hidden
    
    Start-Sleep -Seconds 5
    
    # Reset password
    Write-Host "Resetting root password..." -ForegroundColor Green
    $resetCmd = @"
USE mysql;
UPDATE user SET authentication_string = '', plugin = 'mysql_native_password' WHERE User = 'root';
FLUSH PRIVILEGES;
"@
    
    $resetCmd | & "C:\xampp\mysql\bin\mysql.exe" -u root
    
    # Stop safe mode
    Write-Host "Stopping safe mode..." -ForegroundColor Green
    $safeMode | Stop-Process -Force -ErrorAction SilentlyContinue
    Get-Process -Name "mysqld" -ErrorAction SilentlyContinue | Stop-Process -Force -ErrorAction SilentlyContinue
    
    Start-Sleep -Seconds 3
    
    # Start MySQL normally
    Write-Host "Starting MySQL normally..." -ForegroundColor Green
    Start-Service -Name "MySQL92"
    
    Write-Host "Password reset complete! Root password is now empty." -ForegroundColor Green
    
} catch {
    Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "Please run this script as Administrator" -ForegroundColor Yellow
}