-- Complete MySQL setup for lms_terrado user
-- This will create a user that can easily login to phpMyAdmin

-- Create the lms_terrado database if it doesn't exist
CREATE DATABASE IF NOT EXISTS lms_terrado;

-- Create the lms_terrado user with password siopao112
CREATE USER IF NOT EXISTS 'lms_terrado'@'localhost' IDENTIFIED BY 'siopao112';

-- Grant all privileges on the lms_terrado database
GRANT ALL PRIVILEGES ON lms_terrado.* TO 'lms_terrado'@'localhost';

-- Grant additional privileges for phpMyAdmin to work properly
GRANT SELECT ON mysql.* TO 'lms_terrado'@'localhost';
GRANT SHOW DATABASES ON *.* TO 'lms_terrado'@'localhost';

-- Also reset root password to blank for easy access
ALTER USER 'root'@'localhost' IDENTIFIED BY '';

-- Apply all changes
FLUSH PRIVILEGES;

-- Show confirmation
SELECT 'MySQL user setup complete!' AS Status;
SELECT User, Host FROM mysql.user WHERE User IN ('root', 'lms_terrado');