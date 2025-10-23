@echo off
echo This script has been disabled to avoid any system changes.
echo.
echo To restore your Apache PHP configuration to its previous state:
echo   1) Open XAMPP Control Panel and STOP Apache.
echo   2) Restore php.ini from the backup made earlier:
echo        copy C:\xampp\php\php.ini.bak C:\xampp\php\php.ini
echo      If asked to overwrite, type:  Y
echo   3) START Apache again in XAMPP.
echo.
echo To remove this script completely, delete this file:
echo   c:\xampp\htdocs\ITE311-TERRADO\enable_intl_xampp.bat
echo.
echo No changes were made by running this disabled script.
exit /b 0
