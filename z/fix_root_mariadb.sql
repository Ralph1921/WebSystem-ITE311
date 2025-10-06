-- For MariaDB 10.4+
UPDATE mysql.user SET password = '', plugin = 'mysql_native_password' WHERE User = 'root' AND Host = 'localhost';
UPDATE mysql.user SET password = '', plugin = 'mysql_native_password' WHERE User = 'root' AND Host = '127.0.0.1';
UPDATE mysql.user SET password = '', plugin = 'mysql_native_password' WHERE User = 'root' AND Host = '::1';
FLUSH PRIVILEGES;