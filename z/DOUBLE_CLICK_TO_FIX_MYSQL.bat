@echo off
title MySQL Password Reset for phpMyAdmin
color 0A
echo.
echo ===============================================
echo    MYSQL PASSWORD RESET FOR PHPMYADMIN
echo ===============================================
echo.
echo This will reset your MySQL root password to blank
echo and configure phpMyAdmin for automatic login.
echo.
echo Press any key to continue or Ctrl+C to cancel...
pause >nul

echo.
echo [1/6] Requesting Administrator privileges...
net session >nul 2>&1
if %errorLevel% neq 0 (
    echo Requesting administrator access...
    powershell -Command "Start-Process '%~f0' -Verb RunAs"
    exit /b
)

echo [2/6] Stopping MySQL service...
net stop MySQL92 2>nul
timeout /t 2 /nobreak >nul

echo [3/6] Creating password reset script...
echo USE mysql; > "%temp%\mysql_reset.sql"
echo UPDATE user SET authentication_string = '', plugin = 'mysql_native_password' WHERE User = 'root'; >> "%temp%\mysql_reset.sql"
echo UPDATE user SET Password = '' WHERE User = 'root'; >> "%temp%\mysql_reset.sql"
echo FLUSH PRIVILEGES; >> "%temp%\mysql_reset.sql"

echo [4/6] Starting MySQL in safe mode and resetting password...
start "" "C:\xampp\mysql\bin\mysqld.exe" --skip-grant-tables --init-file="%temp%\mysql_reset.sql"
timeout /t 8 /nobreak >nul

echo [5/6] Stopping safe mode and starting normal service...
taskkill /f /im mysqld.exe >nul 2>&1
timeout /t 2 /nobreak >nul
net start MySQL92

echo [6/6] Configuring phpMyAdmin...
powershell -Command ^
"$config = Get-Content 'C:\xampp\phpMyAdmin\config.inc.php' -Raw; ^
$config = $config -replace '\$cfg\[''Servers''\]\[\$i\]\[''auth_type''\] = ''.*'';', '\$cfg[''Servers''][\$i][''auth_type''] = ''config'';'; ^
$config = $config -replace '\$cfg\[''Servers''\]\[\$i\]\[''user''\] = ''.*'';', '\$cfg[''Servers''][\$i][''user''] = ''root'';'; ^
$config = $config -replace '\$cfg\[''Servers''\]\[\$i\]\[''password''\] = ''.*'';', '\$cfg[''Servers''][\$i][''password''] = '''';'; ^
$config | Set-Content 'C:\xampp\phpMyAdmin\config.inc.php'"

echo.
echo Testing connection...
"C:\xampp\mysql\bin\mysql.exe" -u root -e "SELECT 'SUCCESS!' as Status;" 2>nul
if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo          SUCCESS! ALL DONE!
    echo ========================================
    echo.
    echo phpMyAdmin has been configured for automatic login.
    echo You can now access it without entering credentials.
    echo.
    echo Click here to open phpMyAdmin:
    echo http://127.0.0.1/phpmyadmin/
    echo.
    start http://127.0.0.1/phpmyadmin/
) else (
    echo.
    echo Something went wrong. Please try the manual steps.
)

echo.
del "%temp%\mysql_reset.sql" 2>nul
echo Press any key to exit...
pause >nul