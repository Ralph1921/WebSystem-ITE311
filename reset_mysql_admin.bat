@echo off
echo === XAMPP MariaDB Password Reset ===
echo This script must be run as Administrator
echo.

REM Check if running as administrator
net session >nul 2>&1
if %errorLevel% == 0 (
    echo Running as Administrator - Good!
) else (
    echo ERROR: This script must be run as Administrator!
    echo Right-click this file and select "Run as administrator"
    pause
    exit /b 1
)

echo.
echo Step 1: Stopping MySQL service...
net stop MySQL92

echo Step 2: Killing any remaining processes...
taskkill /f /im mysqld.exe >nul 2>&1

echo Step 3: Waiting 3 seconds...
timeout /t 3 /nobreak >nul

echo Step 4: Starting MySQL with init file...
start "" "C:\xampp\mysql\bin\mysqld.exe" --defaults-file="C:\xampp\mysql\bin\my.ini" --init-file="C:\xampp\mysql\data\mysql-init.txt" --console

echo Step 5: Waiting 10 seconds for initialization...
timeout /t 10 /nobreak >nul

echo Step 6: Stopping MySQL...
taskkill /f /im mysqld.exe >nul 2>&1

echo Step 7: Cleaning up init file...
del "C:\xampp\mysql\data\mysql-init.txt" >nul 2>&1

echo Step 8: Starting MySQL service normally...
net start MySQL92

echo.
echo Step 9: Testing connection...
"C:\xampp\mysql\bin\mysql.exe" -u root -e "SELECT 'Password reset successful!' as Result;"

if %errorlevel% == 0 (
    echo.
    echo SUCCESS! MySQL root password has been reset to empty.
    echo You can now access phpMyAdmin without a password.
    echo.
    echo Updating phpMyAdmin configuration...
    
    REM Update phpMyAdmin config to use empty password
    powershell -Command "(Get-Content 'C:\xampp\phpMyAdmin\config.inc.php') -replace '\$cfg\[''Servers''\]\[\$i\]\[''password''\] = ''.*'';', '\$cfg[''Servers''][\$i][''password''] = '''';' | Set-Content 'C:\xampp\phpMyAdmin\config.inc.php'"
    
    echo phpMyAdmin configuration updated!
    echo.
    echo You can now access phpMyAdmin at: http://127.0.0.1/phpmyadmin/
) else (
    echo.
    echo Something went wrong. Please try running the script again.
)

echo.
pause