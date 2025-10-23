@echo off
echo ================================================
echo    Complete MySQL Reset and Setup
echo ================================================
echo.
echo This will:
echo 1. Stop MySQL service
echo 2. Reset root password to blank
echo 3. Create lms_terrado user
echo 4. Start MySQL service
echo.
echo Press any key to continue or Ctrl+C to cancel...
pause >nul

set MYSQL_DIR="C:\Program Files\MySQL\MySQL Server 9.2"
set MYSQL_BIN=%MYSQL_DIR%\bin
set MYSQL_DATA=%MYSQL_DIR%\data

echo Step 1: Stopping MySQL service...
net stop MySQL92 2>nul
if %ERRORLEVEL% EQU 0 (
    echo ✓ MySQL service stopped
) else (
    echo ✓ MySQL service was not running
)

echo.
echo Step 2: Starting MySQL in safe mode (no password required)...

REM Create init file to reset password and create user
set INIT_FILE=%TEMP%\mysql_init.sql
echo ALTER USER 'root'@'localhost' IDENTIFIED BY ''; > "%INIT_FILE%"
echo FLUSH PRIVILEGES; >> "%INIT_FILE%"
echo CREATE DATABASE IF NOT EXISTS lms_terrado; >> "%INIT_FILE%"
echo CREATE USER IF NOT EXISTS 'lms_terrado'@'localhost' IDENTIFIED BY 'siopao112'; >> "%INIT_FILE%"
echo GRANT ALL PRIVILEGES ON lms_terrado.* TO 'lms_terrado'@'localhost'; >> "%INIT_FILE%"
echo GRANT SELECT ON mysql.* TO 'lms_terrado'@'localhost'; >> "%INIT_FILE%"
echo GRANT SHOW DATABASES ON *.* TO 'lms_terrado'@'localhost'; >> "%INIT_FILE%"
echo FLUSH PRIVILEGES; >> "%INIT_FILE%"

echo Starting MySQL with init file...
start /B %MYSQL_BIN%\mysqld.exe --init-file="%INIT_FILE%" --console

REM Wait for MySQL to start and process init file
echo Waiting for MySQL to initialize...
timeout /t 15 /nobreak >nul

echo.
echo Step 3: Stopping safe mode MySQL...
taskkill /F /IM mysqld.exe >nul 2>&1

REM Clean up init file
del "%INIT_FILE%" 2>nul

echo.
echo Step 4: Starting MySQL service normally...
net start MySQL92
if %ERRORLEVEL% EQU 0 (
    echo ✓ MySQL service started successfully
) else (
    echo ✗ Failed to start MySQL service
    echo Try starting it manually from Services
)

echo.
echo Step 5: Testing the setup...
%MYSQL_BIN%\mysql.exe -u lms_terrado -psiopao112 -e "SHOW DATABASES;" 2>nul
if %ERRORLEVEL% EQU 0 (
    echo ✓ lms_terrado user is working perfectly!
    echo.
    echo ================================================
    echo    SUCCESS! Setup Complete!
    echo ================================================
    echo.
    echo You can now login to phpMyAdmin with:
    echo Username: lms_terrado
    echo Password: siopao112
    echo.
    echo Or use root with no password:
    echo Username: root
    echo Password: (leave blank)
    echo.
    echo phpMyAdmin URL: http://localhost/phpmyadmin
    echo.
) else (
    echo ✗ Setup verification failed
    echo.
    echo Try these credentials in phpMyAdmin:
    echo - root / (no password)
    echo - lms_terrado / siopao112
)

echo.
pause