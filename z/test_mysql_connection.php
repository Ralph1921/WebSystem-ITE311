<?php
// Test MySQL connection with different passwords
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$user = 'root';
$database = 'lms_terrado';
$port = 3306;

$passwords_to_try = ['', '12345', 'password', 'root', 'admin', 'xampp'];

echo "<h2>Testing MySQL Connection</h2>\n";

foreach ($passwords_to_try as $password) {
    echo "Testing password: '" . ($password ?: 'empty') . "'...\n";
    
    try {
        $conn = new mysqli($host, $user, $password, '', $port);
        if (!$conn->connect_error) {
            echo "✅ SUCCESS! Password works: '" . ($password ?: 'empty') . "'\n";
            
            // Try to create database if it doesn't exist
            $conn->query("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            
            // Select database and create user if needed
            if ($conn->select_db($database)) {
                echo "✅ Database '$database' selected\n";
                
                // Create users table
                $create_table = "CREATE TABLE IF NOT EXISTS `users` (
                    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(100) NOT NULL,
                    `email` VARCHAR(255) NOT NULL,
                    `password` VARCHAR(255) NOT NULL,
                    `role` ENUM('admin','user') NOT NULL DEFAULT 'user',
                    `created_at` DATETIME NULL,
                    `updated_at` DATETIME NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `email` (`email`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                
                if ($conn->query($create_table)) {
                    echo "✅ Users table created/ensured\n";
                    
                    // Check if user exists
                    $check_user = $conn->prepare("SELECT id FROM users WHERE email = ?");
                    $email = 'terrado@gmail.com';
                    $check_user->bind_param('s', $email);
                    $check_user->execute();
                    $result = $check_user->get_result();
                    
                    if ($result->num_rows == 0) {
                        // Create user
                        $name = 'Terrado User';
                        $password_plain = 'siopao123';
                        $hash = password_hash($password_plain, PASSWORD_DEFAULT);
                        $role = 'admin';
                        $now = date('Y-m-d H:i:s');
                        
                        $insert = $conn->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
                        $insert->bind_param('ssssss', $name, $email, $hash, $role, $now, $now);
                        
                        if ($insert->execute()) {
                            echo "✅ User created successfully!\n";
                        } else {
                            echo "❌ Failed to create user: " . $insert->error . "\n";
                        }
                        $insert->close();
                    } else {
                        echo "✅ User already exists\n";
                    }
                    $check_user->close();
                } else {
                    echo "❌ Failed to create users table: " . $conn->error . "\n";
                }
            } else {
                echo "❌ Failed to select database: " . $conn->error . "\n";
            }
            
            $conn->close();
            echo "\n🎉 WORKING PASSWORD FOUND: '" . ($password ?: 'empty') . "'\n";
            echo "Login credentials: terrado@gmail.com / siopao123\n\n";
            break;
        } else {
            echo "❌ Failed: " . $conn->connect_error . "\n";
        }
    } catch (Exception $e) {
        echo "❌ Exception: " . $e->getMessage() . "\n";
    }
    echo "\n";
}

echo "<p><a href='login'>Test Login Now</a></p>";
?>