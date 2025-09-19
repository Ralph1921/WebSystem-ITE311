@echo off
title ULTIMATE MySQL Fix for phpMyAdmin
color 0E
echo.
echo ================================================
echo         ULTIMATE MYSQL FIX FOR PHPMYADMIN
echo ================================================
echo.
echo This will completely reset MySQL authentication
echo and fix all plugin-related issues.
echo.
pause

:: Check for admin privileges
net session >nul 2>&1
if %errorLevel% neq 0 (
    echo Requesting administrator privileges...
    powershell -Command "Start-Process '%~f0' -Verb RunAs"
    exit /b
)

echo.
echo [STEP 1] Stopping all MySQL processes...
net stop MySQL92 >nul 2>&1
taskkill /f /im mysqld.exe >nul 2>&1
echo Waiting 5 seconds...
timeout /t 5 /nobreak >nul

echo [STEP 2] Backing up current MySQL data...
if not exist "C:\xampp\mysql\data_backup" (
    mkdir "C:\xampp\mysql\data_backup"
)
xcopy "C:\xampp\mysql\data\mysql" "C:\xampp\mysql\data_backup\mysql" /E /I /Y >nul 2>&1

echo [STEP 3] Creating comprehensive reset script...
(
echo USE mysql;
echo -- Reset root user for all hosts
echo UPDATE user SET authentication_string = '', plugin = 'mysql_native_password' WHERE User = 'root';
echo UPDATE user SET Password = '' WHERE User = 'root';
echo -- Create root user if it doesn't exist
echo INSERT IGNORE INTO user ^(Host, User, authentication_string, plugin^) VALUES ^('localhost', 'root', '', 'mysql_native_password'^);
echo INSERT IGNORE INTO user ^(Host, User, authentication_string, plugin^) VALUES ^('127.0.0.1', 'root', '', 'mysql_native_password'^);
echo INSERT IGNORE INTO user ^(Host, User, authentication_string, plugin^) VALUES ^('::1', 'root', '', 'mysql_native_password'^);
echo -- Grant all privileges
echo UPDATE user SET Select_priv='Y', Insert_priv='Y', Update_priv='Y', Delete_priv='Y', Create_priv='Y', Drop_priv='Y', Reload_priv='Y', Shutdown_priv='Y', Process_priv='Y', File_priv='Y', Grant_priv='Y', References_priv='Y', Index_priv='Y', Alter_priv='Y', Show_db_priv='Y', Super_priv='Y', Create_tmp_table_priv='Y', Lock_tables_priv='Y', Execute_priv='Y', Repl_slave_priv='Y', Repl_client_priv='Y', Create_view_priv='Y', Show_view_priv='Y', Create_routine_priv='Y', Alter_routine_priv='Y', Create_user_priv='Y', Event_priv='Y', Trigger_priv='Y' WHERE User='root';
echo FLUSH PRIVILEGES;
) > "C:\xampp\mysql\data\ultimate_reset.sql"

echo [STEP 4] Starting MySQL in safe mode...
start "" "C:\xampp\mysql\bin\mysqld.exe" --skip-grant-tables --skip-networking --init-file="C:\xampp\mysql\data\ultimate_reset.sql"
echo Waiting 15 seconds for complete initialization...
timeout /t 15 /nobreak >nul

echo [STEP 5] Stopping safe mode...
taskkill /f /im mysqld.exe >nul 2>&1
timeout /t 3 /nobreak >nul

echo [STEP 6] Cleaning up...
del "C:\xampp\mysql\data\ultimate_reset.sql" >nul 2>&1

echo [STEP 7] Starting MySQL service...
net start MySQL92

echo [STEP 8] Testing connection...
echo Testing root connection...
"C:\xampp\mysql\bin\mysql.exe" -u root -e "SELECT 'Connection successful!' as Status, USER() as CurrentUser, VERSION() as Version;" 2>nul

if %errorlevel% equ 0 (
    echo.
    echo =============================================
    echo              SUCCESS! MYSQL FIXED!
    echo =============================================
    echo.
    echo Root user can now connect without password.
    echo Opening phpMyAdmin...
    start http://127.0.0.1/phpmyadmin/
) else (
    echo.
    echo =============================================
    echo        TRYING ALTERNATIVE METHOD...
    echo =============================================
    
    echo Stopping MySQL...
    net stop MySQL92 >nul 2>&1
    
    echo Starting with skip-grant-tables permanently...
    start "" "C:\xampp\mysql\bin\mysqld.exe" --skip-grant-tables --skip-networking
    timeout /t 5 /nobreak >nul
    
    echo Testing connection in safe mode...
    "C:\xampp\mysql\bin\mysql.exe" -u root -e "SELECT 'Safe mode connection works!' as Status;" 2>nul
    
    if %errorlevel% equ 0 (
        echo.
        echo MySQL is working in safe mode.
        echo This means authentication is completely bypassed.
        echo Opening phpMyAdmin...
        start http://127.0.0.1/phpmyadmin/
        echo.
        echo NOTE: MySQL is running in safe mode ^(no authentication^).
        echo This is not secure but will allow you to use phpMyAdmin.
    ) else (
        echo.
        echo =============================================
        echo           MYSQL STILL NOT WORKING
        echo =============================================
        echo.
        echo This suggests a deeper MySQL installation issue.
        echo You may need to reinstall XAMPP or reset MySQL completely.
        echo.
        echo Try accessing phpMyAdmin anyway - it might still work:
        start http://127.0.0.1/phpmyadmin/
    )
)

echo.
echo Script completed. Press any key to exit...
pause >nul