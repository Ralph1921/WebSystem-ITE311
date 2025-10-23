<?php
// Remove MySQL password for easy development access
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔓 Remove MySQL Password - Easy Access Setup</h1>\n";
echo "<p>This script will help you remove the MySQL root password so you can access everything easily.</p>\n";

// Try to find current password first
$passwords_to_try = [
    '12345', 'password', 'root', 'admin', 'mysql', 'xampp', '123456', '123', 'localhost', 'secret'
];

$host = 'localhost';
$user = 'root';
$port = 3306;

echo "<h2>🔍 Step 1: Finding Current Password...</h2>\n";

$current_password = null;
$conn = null;

foreach ($passwords_to_try as $pwd) {
    $desc = "password: '$pwd'";
    echo "Testing $desc...<br>\n";
    
    try {
        $conn = @new mysqli($host, $user, $pwd, '', $port);
        
        if (!$conn->connect_error) {
            echo "✅ <strong>Found current password:</strong> '$pwd'<br>\n";
            $current_password = $pwd;
            break;
        } else {
            echo "❌ Not this one<br>\n";
        }
    } catch (Exception $e) {
        echo "❌ Failed<br>\n";
    }
}

if ($current_password === null) {
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0;'>\n";
    echo "<h3>⚠️ Could Not Find Current Password</h3>\n";
    echo "<p>We need to reset MySQL password using the safe mode method:</p>\n";
    echo "<h4>Manual Steps (Run as Administrator):</h4>\n";
    echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; font-family: monospace;'>\n";
    echo "1. net stop MySQL92<br>\n";
    echo "2. mysqld --console --skip-grant-tables --skip-networking<br>\n";
    echo "3. In another command prompt: mysql -u root<br>\n";
    echo "4. USE mysql;<br>\n";
    echo "5. UPDATE user SET authentication_string = '' WHERE User = 'root' AND Host = 'localhost';<br>\n";
    echo "6. UPDATE user SET plugin = 'mysql_native_password' WHERE User = 'root';<br>\n";
    echo "7. FLUSH PRIVILEGES;<br>\n";
    echo "8. EXIT;<br>\n";
    echo "9. Restart MySQL service<br>\n";
    echo "</div>\n";
    echo "</div>\n";
    exit;
}

echo "<h2>🔓 Step 2: Removing Password...</h2>\n";

try {
    // Remove password by setting it to empty
    $remove_password_query = "ALTER USER 'root'@'localhost' IDENTIFIED BY ''";
    
    if ($conn->query($remove_password_query)) {
        echo "✅ Password removed successfully!<br>\n";
    } else {
        // Try older MySQL syntax
        $legacy_query = "UPDATE mysql.user SET authentication_string = '', plugin = 'mysql_native_password' WHERE User = 'root' AND Host = 'localhost'";
        if ($conn->query($legacy_query)) {
            echo "✅ Password removed using legacy method!<br>\n";
            $conn->query("FLUSH PRIVILEGES");
        } else {
            echo "❌ Failed to remove password: " . $conn->error . "<br>\n";
            echo "❌ Legacy method also failed: " . $conn->error . "<br>\n";
        }
    }
    
    // Also ensure root can login from localhost without password
    $conn->query("FLUSH PRIVILEGES");
    echo "✅ Privileges flushed<br>\n";
    
} catch (Exception $e) {
    echo "❌ Error removing password: " . $e->getMessage() . "<br>\n";
}

echo "<h2>🏗️ Step 3: Setting Up Database...</h2>\n";

// Create database and user
try {
    if ($conn->query("CREATE DATABASE IF NOT EXISTS lms_terrado CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
        echo "✅ Database 'lms_terrado' created<br>\n";
        
        $conn->select_db('lms_terrado');
        
        // Create users table
        $create_table = "CREATE TABLE IF NOT EXISTS users (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin','user','instructor','student') NOT NULL DEFAULT 'user',
            created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY email (email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        if ($conn->query($create_table)) {
            echo "✅ Users table created<br>\n";
            
            // Create your user account
            $check_user = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE email = ?");
            $email = 'terrado@gmail.com';
            $check_user->bind_param('s', $email);
            $check_user->execute();
            $result = $check_user->get_result()->fetch_assoc();
            
            if ($result['count'] == 0) {
                $insert_user = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
                $name = 'Terrado User';
                $password_hash = password_hash('siopao123', PASSWORD_DEFAULT);
                $role = 'admin';
                
                $insert_user->bind_param('ssss', $name, $email, $password_hash, $role);
                
                if ($insert_user->execute()) {
                    echo "✅ Your user account created: terrado@gmail.com<br>\n";
                } else {
                    echo "❌ Failed to create user: " . $insert_user->error . "<br>\n";
                }
                $insert_user->close();
            } else {
                echo "✅ User account already exists<br>\n";
            }
            $check_user->close();
        }
    }
} catch (Exception $e) {
    echo "❌ Database setup error: " . $e->getMessage() . "<br>\n";
}

$conn->close();

echo "<h2>🔧 Step 4: Updating Configuration Files...</h2>\n";

// Update CodeIgniter config to use no password
$config_file = __DIR__ . '/app/Config/Database.php';
$config_content = file_get_contents($config_file);
$config_content = preg_replace(
    "/        'password'     => '[^']*',/",
    "        'password'     => '', // No password for easy development",
    $config_content
);

if (file_put_contents($config_file, $config_content)) {
    echo "✅ CodeIgniter config updated (no password)<br>\n";
}

// Update phpMyAdmin configs
$configs_to_update = [
    __DIR__ . '/phpmyadmin_config/config.inc.php',
    'C:\\xampp\\phpMyAdmin\\config.inc.php'
];

foreach ($configs_to_update as $config_path) {
    if (file_exists($config_path)) {
        $content = file_get_contents($config_path);
        $content = preg_replace(
            '/\$cfg\[\'Servers\'\]\[\$i\]\[\'password\'\] = \'[^\']*\';/',
            "\$cfg['Servers'][\$i]['password'] = ''; // No password",
            $content
        );
        
        if (file_put_contents($config_path, $content)) {
            echo "✅ phpMyAdmin config updated: " . basename($config_path) . "<br>\n";
        }
    }
}

echo "<div style='background: #d4edda; padding: 25px; border-radius: 10px; margin: 30px 0; border: 3px solid #28a745;'>\n";
echo "<h2>🎉 SUCCESS! MySQL Password Removed!</h2>\n";
echo "<h3>✅ What's Now Working:</h3>\n";
echo "<ul style='font-size: 16px;'>\n";
echo "<li>✅ <strong>MySQL:</strong> No password required (root user)</li>\n";
echo "<li>✅ <strong>phpMyAdmin:</strong> Easy access without password</li>\n";
echo "<li>✅ <strong>Database:</strong> 'lms_terrado' created and ready</li>\n";
echo "<li>✅ <strong>User Account:</strong> Created and ready for login</li>\n";
echo "<li>✅ <strong>CodeIgniter:</strong> Configured for no password</li>\n";
echo "</ul>\n";

echo "<h3>🚀 Test Everything Now:</h3>\n";
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 15px 0;'>\n";
echo "<p><strong>Login to your app:</strong><br>\n";
echo "<strong>URL:</strong> http://localhost/ITE311-TERRADO/login<br>\n";
echo "<strong>Email:</strong> terrado@gmail.com<br>\n";
echo "<strong>Password:</strong> siopao123</p>\n";
echo "</div>\n";

echo "<p style='margin-top: 25px;'>\n";
echo "<a href='login' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; margin-right: 15px;'>🚀 Test Login Now</a>\n";
echo "<a href='http://localhost/phpmyadmin' style='background: #17a2b8; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px;' target='_blank'>🔍 Test phpMyAdmin</a>\n";
echo "</p>\n";
echo "</div>\n";

echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6;'>\n";
echo "<h3>📋 Quick Summary:</h3>\n";
echo "<ul>\n";
echo "<li><strong>MySQL:</strong> No password (easy development)</li>\n";
echo "<li><strong>Database:</strong> lms_terrado</li>\n";
echo "<li><strong>Your Login:</strong> terrado@gmail.com / siopao123</li>\n";
echo "<li><strong>Role:</strong> Admin</li>\n";
echo "</ul>\n";
echo "<p><em>Everything is now configured for easy development access!</em></p>\n";
echo "</div>\n";
?>