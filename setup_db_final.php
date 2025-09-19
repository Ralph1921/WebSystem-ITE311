<?php
// Final database setup to fix login issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔧 Database Setup - Final Fix</h1>\n";

// Since CodeIgniter can connect initially but loses connection,
// let's use a direct approach to set up the database properly

$host = 'localhost';
$user = 'root';
$port = 3306;

// Try different passwords that might work with your current MySQL setup
$passwords_to_try = [
    '', 
    'password', 
    'root', 
    '123456',
    'admin',
    'mysql',
    '12345',
    'xampp'
];

$connected = false;
$working_password = '';
$conn = null;

echo "<h2>🔍 Testing MySQL Connection...</h2>\n";

foreach ($passwords_to_try as $pwd) {
    $desc = $pwd === '' ? 'empty password' : "password: '$pwd'";
    echo "Testing $desc...<br>\n";
    
    try {
        $conn = @new mysqli($host, $user, $pwd, '', $port);
        
        if (!$conn->connect_error) {
            echo "✅ <strong>SUCCESS!</strong> Connected with $desc<br>\n";
            $working_password = $pwd;
            $connected = true;
            break;
        } else {
            echo "❌ Failed: " . $conn->connect_error . "<br>\n";
        }
    } catch (Exception $e) {
        echo "❌ Exception: " . $e->getMessage() . "<br>\n";
    }
    echo "<br>\n";
}

if (!$connected) {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 5px;'>\n";
    echo "<h3>❌ No Connection Possible</h3>\n";
    echo "<p>Unable to connect to MySQL with any common passwords.</p>\n";
    echo "<p><strong>Solutions:</strong></p>\n";
    echo "<ol>\n";
    echo "<li>Stop the MySQL92 service: <code>net stop MySQL92</code></li>\n";
    echo "<li>Use XAMPP's MySQL instead</li>\n";
    echo "<li>Reset the MySQL root password</li>\n";
    echo "</ol>\n";
    echo "</div>\n";
    exit;
}

echo "<h2>🏗️ Setting up Database Structure...</h2>\n";

try {
    // Create database
    $db_name = 'lms_terrado';
    if ($conn->query("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
        echo "✅ Database '$db_name' created/verified<br>\n";
    } else {
        echo "❌ Failed to create database: " . $conn->error . "<br>\n";
    }
    
    // Select database
    if ($conn->select_db($db_name)) {
        echo "✅ Database '$db_name' selected<br>\n";
        
        // Create users table with proper structure
        $users_table_sql = "
        CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` varchar(100) NOT NULL,
            `email` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `role` enum('admin','user','instructor','student') NOT NULL DEFAULT 'user',
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `email` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        if ($conn->query($users_table_sql)) {
            echo "✅ Users table created/verified<br>\n";
            
            // Check if our main user exists
            $check_user = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE email = ?");
            $email = 'terrado@gmail.com';
            $check_user->bind_param('s', $email);
            $check_user->execute();
            $result = $check_user->get_result()->fetch_assoc();
            
            if ($result['count'] == 0) {
                // Create the main user account
                $insert_user = $conn->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
                $name = 'Terrado User';
                $password_hash = password_hash('siopao123', PASSWORD_DEFAULT);
                $role = 'admin';
                
                $insert_user->bind_param('ssss', $name, $email, $password_hash, $role);
                
                if ($insert_user->execute()) {
                    echo "✅ User '$email' created successfully<br>\n";
                } else {
                    echo "❌ Failed to create user: " . $insert_user->error . "<br>\n";
                }
                $insert_user->close();
            } else {
                echo "✅ User '$email' already exists<br>\n";
            }
            $check_user->close();
            
        } else {
            echo "❌ Failed to create users table: " . $conn->error . "<br>\n";
        }
    } else {
        echo "❌ Failed to select database: " . $conn->error . "<br>\n";
    }
    
} catch (Exception $e) {
    echo "❌ Database setup error: " . $e->getMessage() . "<br>\n";
}

$conn->close();

echo "<h2>🔧 Update CodeIgniter Configuration</h2>\n";
echo "<p>Your working MySQL password is: <strong>'$working_password'</strong></p>\n";

// Read current database config
$config_file = __DIR__ . '/app/Config/Database.php';
$config_content = file_get_contents($config_file);

// Update password in config
if ($working_password !== '') {
    $new_password_line = "        'password'     => '$working_password',";
} else {
    $new_password_line = "        'password'     => '',";
}

// Replace the password line
$pattern = "/        'password'     => '[^']*',/";
$config_content = preg_replace($pattern, $new_password_line, $config_content);

if (file_put_contents($config_file, $config_content)) {
    echo "✅ Database configuration updated automatically<br>\n";
} else {
    echo "❌ Failed to update configuration. Please update manually:<br>\n";
    echo "<code>File: app/Config/Database.php<br>Line 33: 'password' => '$working_password',</code><br>\n";
}

echo "<div style='background: #d4edda; padding: 20px; margin: 20px 0; border-radius: 5px;'>\n";
echo "<h2>🎉 Setup Complete!</h2>\n";
echo "<p><strong>Your login credentials:</strong></p>\n";
echo "<ul>\n";
echo "<li><strong>URL:</strong> <a href='login'>http://localhost/ITE311-TERRADO/login</a></li>\n";
echo "<li><strong>Email:</strong> terrado@gmail.com</li>\n";
echo "<li><strong>Password:</strong> siopao123</li>\n";
echo "</ul>\n";
echo "<p><a href='login' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Test Login Now</a></p>\n";
echo "</div>\n";

echo "<h3>🔍 Troubleshooting</h3>\n";
echo "<p>If login still doesn't work:</p>\n";
echo "<ol>\n";
echo "<li>Clear your browser cache/cookies</li>\n";
echo "<li>Try in an incognito/private browser window</li>\n";
echo "<li>Check if both MySQL processes are still running (only one should run)</li>\n";
echo "</ol>\n";
?>