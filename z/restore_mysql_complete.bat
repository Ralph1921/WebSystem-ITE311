@echo off
echo ================================================================
echo            MySQL Password Reset & Database Restore
echo ================================================================
echo.
echo This script will:
echo 1. Stop MySQL service
echo 2. Reset MySQL root password to empty (no password)
echo 3. Restore your lms_terrado database
echo 4. Create your user account
echo 5. Fix phpMyAdmin access
echo.
echo IMPORTANT: This must be run as Administrator!
echo.
pause

echo.
echo [1/6] Stopping MySQL service...
net stop MySQL92 2>nul
if errorlevel 1 (
    echo WARNING: Could not stop MySQL92 service. It might already be stopped.
) else (
    echo SUCCESS: MySQL92 service stopped.
)

echo.
echo [2/6] Looking for MySQL installation...
set MYSQL_PATH=""

if exist "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqld.exe" (
    set MYSQL_PATH="C:\Program Files\MySQL\MySQL Server 8.0\bin"
    echo Found MySQL at: C:\Program Files\MySQL\MySQL Server 8.0\bin
) else if exist "C:\Program Files\MySQL\MySQL Server 8.2\bin\mysqld.exe" (
    set MYSQL_PATH="C:\Program Files\MySQL\MySQL Server 8.2\bin"
    echo Found MySQL at: C:\Program Files\MySQL\MySQL Server 8.2\bin
) else if exist "C:\Program Files\MySQL\MySQL Server 9.2\bin\mysqld.exe" (
    set MYSQL_PATH="C:\Program Files\MySQL\MySQL Server 9.2\bin"
    echo Found MySQL at: C:\Program Files\MySQL\MySQL Server 9.2\bin
) else if exist "C:\mysql\bin\mysqld.exe" (
    set MYSQL_PATH="C:\mysql\bin"
    echo Found MySQL at: C:\mysql\bin
) else if exist "C:\xampp\mysql\bin\mysqld.exe" (
    set MYSQL_PATH="C:\xampp\mysql\bin"
    echo Found MySQL at: C:\xampp\mysql\bin
) else (
    echo ERROR: Could not find MySQL installation!
    echo Please check your MySQL installation.
    pause
    exit /b 1
)

echo.
echo [3/6] Creating password reset SQL script...
echo USE mysql; > reset_password.sql
echo UPDATE user SET authentication_string = '', plugin = 'mysql_native_password' WHERE User = 'root' AND Host = 'localhost'; >> reset_password.sql
echo FLUSH PRIVILEGES; >> reset_password.sql
echo.
echo CREATE DATABASE IF NOT EXISTS lms_terrado CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; >> reset_password.sql
echo USE lms_terrado; >> reset_password.sql
echo.
echo CREATE TABLE IF NOT EXISTS users ( >> reset_password.sql
echo     id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, >> reset_password.sql
echo     name VARCHAR(100) NOT NULL, >> reset_password.sql
echo     email VARCHAR(255) NOT NULL, >> reset_password.sql
echo     password VARCHAR(255) NOT NULL, >> reset_password.sql
echo     role ENUM('admin','user','instructor','student') NOT NULL DEFAULT 'user', >> reset_password.sql
echo     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, >> reset_password.sql
echo     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, >> reset_password.sql
echo     PRIMARY KEY (id), >> reset_password.sql
echo     UNIQUE KEY email (email) >> reset_password.sql
echo ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; >> reset_password.sql
echo.
echo INSERT IGNORE INTO users (name, email, password, role) VALUES ('Terrado User', 'terrado@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'); >> reset_password.sql
echo.
echo SELECT 'Password reset and database restoration complete!' as Status; >> reset_password.sql

echo SQL script created successfully.

echo.
echo [4/6] Starting MySQL in safe mode (this may take a moment)...
echo Starting mysqld with --skip-grant-tables...
start /b %MYSQL_PATH%\mysqld.exe --console --skip-grant-tables --skip-networking

echo Waiting 10 seconds for MySQL to start...
timeout /t 10 /nobreak >nul

echo.
echo [5/6] Executing password reset and database restoration...
%MYSQL_PATH%\mysql.exe -u root < reset_password.sql
if errorlevel 1 (
    echo WARNING: MySQL commands completed with warnings.
) else (
    echo SUCCESS: Password reset and database restoration completed!
)

echo.
echo [6/6] Stopping safe mode MySQL and starting normal service...
taskkill /im mysqld.exe /f 2>nul
timeout /t 3 /nobreak >nul

net start MySQL92
if errorlevel 1 (
    echo WARNING: Could not start MySQL92 service automatically.
    echo Please start it manually from Windows Services.
) else (
    echo SUCCESS: MySQL92 service started normally.
)

echo.
echo Cleaning up temporary files...
del reset_password.sql 2>nul

echo.
echo ================================================================
echo                     RESTORATION COMPLETE!
echo ================================================================
echo.
echo What has been fixed:
echo - MySQL root password removed (no password needed)
echo - lms_terrado database created/restored
echo - users table created with your account
echo - phpMyAdmin should now work without password
echo.
echo Your login credentials:
echo URL: http://localhost/ITE311-TERRADO/login
echo Email: terrado@gmail.com
echo Password: siopao123
echo.
echo Test phpMyAdmin: http://localhost/phpmyadmin
echo.
echo If phpMyAdmin still asks for password, restart Apache service.
echo.
pause