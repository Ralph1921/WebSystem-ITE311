@echo off
echo ================================================
echo    MySQL & phpMyAdmin Complete Setup
echo ================================================
echo.

set MYSQL_PATH="C:\Program Files\MySQL\MySQL Server 9.2\bin\mysql.exe"
set SQL_FILE="C:\xampp\htdocs\ITE311-TERRADO\setup_mysql_user.sql"

echo Step 1: Testing MySQL connection...
%MYSQL_PATH% -u root -e "SELECT 1;" >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo ✓ MySQL accessible with root (no password)
    echo.
    echo Step 2: Creating lms_terrado user...
    %MYSQL_PATH% -u root < %SQL_FILE%
    if %ERRORLEVEL% EQU 0 (
        echo ✓ MySQL user setup completed successfully!
    ) else (
        echo ✗ MySQL setup failed
    )
) else (
    echo ✗ Cannot access MySQL with root user
    echo Trying with password 'root'...
    %MYSQL_PATH% -u root -proot -e "SELECT 1;" >nul 2>&1
    if %ERRORLEVEL% EQU 0 (
        echo ✓ Connected with password: root
        %MYSQL_PATH% -u root -proot < %SQL_FILE%
    ) else (
        echo ✗ Could not connect to MySQL
        echo Manual setup required
    )
)

echo.
echo Step 3: Testing new user...
%MYSQL_PATH% -u lms_terrado -psiopao112 -e "SHOW DATABASES;" >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo ✓ lms_terrado user working perfectly!
) else (
    echo ✗ lms_terrado user test failed
)

echo.
echo ================================================
echo    Setup Complete!
echo ================================================
echo.
echo 🎯 Your phpMyAdmin access:
echo URL: http://localhost/phpmyadmin
echo Username: lms_terrado
echo Password: siopao112
echo.
echo ✓ phpMyAdmin will auto-login with these credentials!
echo ✓ You can also use: root / (no password)
echo.
echo 🔗 Test links:
echo - phpMyAdmin: http://localhost/phpmyadmin
echo - CodeIgniter: http://localhost/ITE311-TERRADO/login
echo.
pause