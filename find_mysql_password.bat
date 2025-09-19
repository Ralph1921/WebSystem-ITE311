@echo off
echo ================================================
echo    MySQL Password Finder & User Creator
echo ================================================
echo.

set MYSQL_BIN="C:\Program Files\MySQL\MySQL Server 9.2\bin\mysql.exe"

echo Testing common MySQL passwords...
echo.

REM Test passwords in order of likelihood
set passwords="" "root" "admin" "password" "mysql" "123456" "toor"

for %%p in (%passwords%) do (
    if "%%p"=="" (
        echo Testing: root with no password
        %MYSQL_BIN% -u root -e "SELECT 'SUCCESS: No password required!' AS Result;" 2>nul
    ) else (
        echo Testing: root with password %%p
        %MYSQL_BIN% -u root -p%%p -e "SELECT 'SUCCESS: Password is %%p' AS Result;" 2>nul
    )
    
    if !ERRORLEVEL! EQU 0 (
        echo.
        echo ✓ FOUND WORKING PASSWORD!
        if "%%p"=="" (
            echo MySQL root password: (blank)
            echo.
            echo Creating lms_terrado user...
            %MYSQL_BIN% -u root -e "CREATE DATABASE IF NOT EXISTS lms_terrado; CREATE USER IF NOT EXISTS 'lms_terrado'@'localhost' IDENTIFIED BY 'siopao112'; GRANT ALL PRIVILEGES ON lms_terrado.* TO 'lms_terrado'@'localhost'; GRANT SELECT ON mysql.* TO 'lms_terrado'@'localhost'; FLUSH PRIVILEGES;"
        ) else (
            echo MySQL root password: %%p
            echo.
            echo Creating lms_terrado user...
            %MYSQL_BIN% -u root -p%%p -e "CREATE DATABASE IF NOT EXISTS lms_terrado; CREATE USER IF NOT EXISTS 'lms_terrado'@'localhost' IDENTIFIED BY 'siopao112'; GRANT ALL PRIVILEGES ON lms_terrado.* TO 'lms_terrado'@'localhost'; GRANT SELECT ON mysql.* TO 'lms_terrado'@'localhost'; FLUSH PRIVILEGES;"
        )
        
        echo.
        echo ================================================
        echo    SUCCESS! Setup Complete!
        echo ================================================
        echo.
        echo Now you can login to phpMyAdmin with:
        echo.
        if "%%p"=="" (
            echo Option 1: Username: root, Password: (leave blank)
        ) else (
            echo Option 1: Username: root, Password: %%p
        )
        echo Option 2: Username: lms_terrado, Password: siopao112
        echo.
        echo URL: http://localhost/phpmyadmin
        echo.
        goto :end
    )
)

echo.
echo ✗ Could not find working MySQL password
echo.
echo Manual options:
echo 1. Try MySQL Workbench to connect
echo 2. Reset MySQL service
echo 3. Use different MySQL installation
echo.

:end
pause