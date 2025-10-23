@echo off
echo Fixing MySQL root access for phpMyAdmin...
echo.

REM Stop MySQL service if running
net stop MySQL92 2>nul

REM Start MySQL in safe mode without password verification
echo Starting MySQL in safe mode...
start /min mysqld --skip-grant-tables --skip-networking

REM Wait a moment for MySQL to start
timeout /t 5 /nobreak >nul

REM Reset root password to blank
echo Resetting root password...
mysql -u root -e "FLUSH PRIVILEGES; ALTER USER 'root'@'localhost' IDENTIFIED BY '';"

REM Stop the safe mode MySQL
echo Stopping safe mode MySQL...
mysqladmin -u root shutdown

REM Start MySQL service normally
echo Starting MySQL service normally...
net start MySQL92

echo.
echo MySQL root password has been reset to blank.
echo You can now access phpMyAdmin without a password.
echo.
pause