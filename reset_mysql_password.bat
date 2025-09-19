@echo off
echo Stopping MySQL service...
net stop MySQL92

echo Starting MySQL with skip-grant-tables...
start "" "C:\xampp\mysql\bin\mysqld.exe" --skip-grant-tables --skip-networking

timeout /t 5 /nobreak >nul

echo Resetting root password...
"C:\xampp\mysql\bin\mysql.exe" -u root -e "USE mysql; UPDATE user SET authentication_string = '', plugin = 'mysql_native_password' WHERE User = 'root' AND Host = 'localhost'; FLUSH PRIVILEGES;"

echo Stopping MySQL...
taskkill /f /im mysqld.exe >nul 2>&1

echo Starting MySQL normally...
net start MySQL92

echo Done! Root password has been reset to empty.
pause