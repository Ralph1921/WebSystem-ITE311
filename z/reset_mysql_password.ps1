# Reset MySQL root password script
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "    MySQL Root Password Reset" -ForegroundColor Cyan  
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$mysqlPath = "C:\Program Files\MySQL\MySQL Server 9.2\bin"

Write-Host "Step 1: Stopping MySQL service..." -ForegroundColor Yellow
try {
    Stop-Service -Name "MySQL92" -Force -ErrorAction SilentlyContinue
    Write-Host "✅ MySQL service stopped" -ForegroundColor Green
} catch {
    Write-Host "⚠️  MySQL service was not running" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "Step 2: Starting MySQL in safe mode..." -ForegroundColor Yellow

# Create init file to reset password
$initFile = "C:\temp_mysql_init.sql"
$initContent = @"
ALTER USER 'root'@'localhost' IDENTIFIED BY '';
FLUSH PRIVILEGES;
"@

$initContent | Out-File -FilePath $initFile -Encoding UTF8

# Start MySQL with init file
$mysqldPath = Join-Path $mysqlPath "mysqld.exe"
Write-Host "Starting MySQL with password reset..." -ForegroundColor Yellow

$process = Start-Process -FilePath $mysqldPath -ArgumentList "--init-file=`"$initFile`"" -PassThru -WindowStyle Hidden

# Wait a few seconds
Start-Sleep -Seconds 10

Write-Host "Step 3: Stopping safe mode MySQL..." -ForegroundColor Yellow
$process.Kill()

# Clean up init file
Remove-Item $initFile -Force -ErrorAction SilentlyContinue

Write-Host ""
Write-Host "Step 4: Starting MySQL service normally..." -ForegroundColor Yellow
try {
    Start-Service -Name "MySQL92"
    Write-Host "✅ MySQL service started" -ForegroundColor Green
} catch {
    Write-Host "❌ Failed to start MySQL service" -ForegroundColor Red
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "    Password Reset Complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "Now try phpMyAdmin with:" -ForegroundColor White
Write-Host "Username: root" -ForegroundColor Yellow
Write-Host "Password: (leave blank)" -ForegroundColor Yellow
Write-Host ""
Write-Host "URL: http://localhost/phpmyadmin" -ForegroundColor Cyan
Write-Host ""

Read-Host "Press Enter to continue..."