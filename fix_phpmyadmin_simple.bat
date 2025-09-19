@echo off
echo ========================================
echo    phpMyAdmin MySQL Access Fix
echo ========================================
echo.

REM Try to connect with no password first
echo Testing connection with no password...
"C:\Program Files\MySQL\MySQL Server 9.2\bin\mysql.exe" -u root -e "SHOW DATABASES;" 2>nul
if %ERRORLEVEL% EQU 0 (
    echo SUCCESS: MySQL root has no password!
    echo You can login to phpMyAdmin with:
    echo Username: root
    echo Password: (leave blank)
    goto end
)

echo Root has a password. Trying common passwords...

REM Try common passwords
for %%P in ("root" "admin" "password" "" "mysql" "123456") do (
    echo Trying password: %%P
    "C:\Program Files\MySQL\MySQL Server 9.2\bin\mysql.exe" -u root -p%%P -e "SHOW DATABASES;" 2>nul
    if !ERRORLEVEL! EQU 0 (
        echo SUCCESS: Password is %%P
        echo You can login to phpMyAdmin with:
        echo Username: root
        echo Password: %%P
        goto end
    )
)

echo.
echo ========================================
echo Manual Reset Required
echo ========================================
echo None of the common passwords worked.
echo.
echo To reset MySQL root password:
echo 1. Stop MySQL service: net stop MySQL92
echo 2. Start MySQL in safe mode
echo 3. Reset password to blank
echo.
echo Or try these common credentials in phpMyAdmin:
echo - Username: root, Password: (blank)
echo - Username: root, Password: root
echo - Username: root, Password: admin
echo - Username: root, Password: password
echo.

:end
echo.
echo phpMyAdmin URL: http://localhost/phpmyadmin
echo.
pause