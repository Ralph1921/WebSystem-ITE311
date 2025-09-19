# PowerShell script to fix MySQL conflicts and enable login
# Run this as Administrator

Write-Host "🔧 Fixing MySQL Connection Issues..." -ForegroundColor Yellow

# Stop the conflicting MySQL service
Write-Host "1. Stopping MySQL92 service..." -ForegroundColor Cyan
try {
    Stop-Service -Name "MySQL92" -Force
    Write-Host "✅ MySQL92 service stopped" -ForegroundColor Green
} catch {
    Write-Host "⚠️  Could not stop MySQL92 service (may not be running)" -ForegroundColor Yellow
}

# Set MySQL92 to manual startup to prevent auto-start
Write-Host "2. Setting MySQL92 to manual startup..." -ForegroundColor Cyan
try {
    Set-Service -Name "MySQL92" -StartupType Manual
    Write-Host "✅ MySQL92 set to manual startup" -ForegroundColor Green
} catch {
    Write-Host "⚠️  Could not change MySQL92 startup type" -ForegroundColor Yellow
}

Write-Host "`n3. Current MySQL processes:" -ForegroundColor Cyan
Get-Process | Where-Object {$_.ProcessName -like "*mysql*"} | Format-Table ProcessName, Id, CPU

Write-Host "`n4. Network ports status:" -ForegroundColor Cyan
netstat -an | findstr ":3306"

Write-Host "`n🚀 Next Steps:" -ForegroundColor Yellow
Write-Host "1. Open XAMPP Control Panel as Administrator" -ForegroundColor White
Write-Host "2. Start MySQL in XAMPP" -ForegroundColor White
Write-Host "3. If MySQL won't start in XAMPP, check the port configuration" -ForegroundColor White
Write-Host "4. Once XAMPP MySQL is running, test your login" -ForegroundColor White

Write-Host "`n📋 Alternative: Use the standalone MySQL" -ForegroundColor Yellow
Write-Host "If you prefer to use the standalone MySQL that's already installed:" -ForegroundColor White
Write-Host "- Start the MySQL92 service again: Start-Service MySQL92" -ForegroundColor White
Write-Host "- Set a password for the root user" -ForegroundColor White
Write-Host "- Update your CodeIgniter config with that password" -ForegroundColor White

Write-Host "`n⚠️  Remember: Only one MySQL service should be running at a time!" -ForegroundColor Red