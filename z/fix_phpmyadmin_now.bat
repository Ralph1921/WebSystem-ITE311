@echo off
echo ================================================
echo    Quick phpMyAdmin Fix
echo ================================================
echo.
echo I'll configure phpMyAdmin to work with any password
echo This will let you login with different credentials
echo.

REM Backup original config
copy "C:\xampp\phpmyadmin\config.inc.php" "C:\xampp\phpmyadmin\config.inc.php.backup" >nul

echo Creating flexible phpMyAdmin config...

REM Create new config that allows multiple authentication methods
(
echo ^<?php
echo $cfg['blowfish_secret'] = 'xampp_secret_key_123456789';
echo.
echo $i = 0;
echo $i++;
echo.
echo // Server 1 - Try with lms_terrado
echo $cfg['Servers'][$i]['auth_type'] = 'config';
echo $cfg['Servers'][$i]['host'] = '127.0.0.1';
echo $cfg['Servers'][$i]['user'] = 'lms_terrado';
echo $cfg['Servers'][$i]['password'] = 'siopao112';
echo $cfg['Servers'][$i]['port'] = '3306';
echo $cfg['Servers'][$i]['extension'] = 'mysqli';
echo $cfg['Servers'][$i]['AllowNoPassword'] = true;
echo $cfg['Servers'][$i]['hide_db'] = '^information_schema$';
echo.
echo // Server 2 - Manual login for any user
echo $i++;
echo $cfg['Servers'][$i]['auth_type'] = 'cookie';
echo $cfg['Servers'][$i]['host'] = '127.0.0.1';
echo $cfg['Servers'][$i]['user'] = '';
echo $cfg['Servers'][$i]['password'] = '';
echo $cfg['Servers'][$i]['port'] = '3306';
echo $cfg['Servers'][$i]['extension'] = 'mysqli';
echo $cfg['Servers'][$i]['AllowNoPassword'] = true;
echo.
echo ?^>
) > "C:\xampp\phpmyadmin\config.inc.php"

echo ✓ phpMyAdmin configuration updated!
echo.
echo ================================================
echo    Now Try These Options:
echo ================================================
echo.
echo Option 1: Direct access (should work automatically)
echo URL: http://localhost/phpmyadmin
echo.
echo Option 2: If prompted for login, try:
echo - Username: root, Password: (try common passwords)
echo - Username: lms_terrado, Password: siopao112
echo.
echo ✓ phpMyAdmin is now configured to work with multiple users!
echo.
pause