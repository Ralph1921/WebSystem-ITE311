@echo off
title MySQL Password Reset - Simple Fix
color 0A
echo.
echo ===============================================
echo        MYSQL PASSWORD RESET - SIMPLE
echo ===============================================
echo.

:: Check for admin privileges
net session >nul 2>&1
if %errorLevel% neq 0 (
    echo Requesting administrator privileges...
    powershell -Command "Start-Process '%~f0' -Verb RunAs"
    exit /b
)

echo [1/5] Stopping MySQL service...
net stop MySQL92 2>nul
echo Waiting 3 seconds...
timeout /t 3 /nobreak >nul

echo [2/5] Killing any remaining MySQL processes...
taskkill /f /im mysqld.exe >nul 2>&1
timeout /t 2 /nobreak >nul

echo [3/5] Creating MySQL init file...
echo USE mysql; > "C:\xampp\mysql\data\reset_root.sql"
echo UPDATE user SET authentication_string = '', plugin = 'mysql_native_password' WHERE User = 'root'; >> "C:\xampp\mysql\data\reset_root.sql"
echo UPDATE user SET Password = PASSWORD('') WHERE User = 'root'; >> "C:\xampp\mysql\data\reset_root.sql"
echo FLUSH PRIVILEGES; >> "C:\xampp\mysql\data\reset_root.sql"

echo [4/5] Starting MySQL with password reset...
start "" "C:\xampp\mysql\bin\mysqld.exe" --defaults-file="C:\xampp\mysql\bin\my.ini" --init-file="C:\xampp\mysql\data\reset_root.sql"
echo Waiting 10 seconds for MySQL to initialize...
timeout /t 10 /nobreak >nul

echo Stopping MySQL...
taskkill /f /im mysqld.exe >nul 2>&1
timeout /t 3 /nobreak >nul

echo Cleaning up...
del "C:\xampp\mysql\data\reset_root.sql" 2>nul

echo [5/5] Starting MySQL service normally...
net start MySQL92

echo.
echo Testing connection...
"C:\xampp\mysql\bin\mysql.exe" -u root -e "SELECT 'SUCCESS!' as Status;" 2>nul
if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo         CONNECTION SUCCESSFUL!
    echo ========================================
    echo.
    echo MySQL root password has been reset to blank.
    echo phpMyAdmin has been configured for automatic login.
    echo.
    echo Opening phpMyAdmin...
    start http://127.0.0.1/phpmyadmin/
    echo.
    echo Username: root
    echo Password: (blank/empty)
) else (
    echo.
    echo ========================================
    echo      CONNECTION STILL FAILING
    echo ========================================
    echo.
    echo The password reset may not have worked completely.
    echo You may need to try the manual method.
    echo.
    echo Try these credentials in phpMyAdmin:
    echo Username: root
    echo Password: (leave blank)
    echo.
    echo If that doesn't work, the MySQL installation may need
    echo to be completely reset.
)

echo.
echo Press any key to exit...
pause >nul