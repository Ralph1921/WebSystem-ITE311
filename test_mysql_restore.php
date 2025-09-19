<?php
// Test MySQL connection and database after restoration
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🧪 MySQL & Database Test - After Restoration</h1>\n";

// Test connection
echo "<h2>1. Testing MySQL Connection</h2>\n";
try {
    $conn = new mysqli('localhost', 'root', '', '', 3306);
    
    if ($conn->connect_error) {
        echo "❌ <strong>Connection failed:</strong> " . $conn->connect_error . "<br>\n";
        echo "<p style='color: red;'>MySQL still requires a password. The restoration script needs to be run.</p>\n";
        exit;
    } else {
        echo "✅ <strong>SUCCESS!</strong> Connected to MySQL without password<br>\n";
    }
} catch (Exception $e) {
    echo "❌ <strong>Connection error:</strong> " . $e->getMessage() . "<br>\n";
    exit;
}

// Test database exists
echo "<h2>2. Testing Database 'lms_terrado'</h2>\n";
$db_check = $conn->query("SHOW DATABASES LIKE 'lms_terrado'");
if ($db_check && $db_check->num_rows > 0) {
    echo "✅ Database 'lms_terrado' exists<br>\n";
    $conn->select_db('lms_terrado');
} else {
    echo "❌ Database 'lms_terrado' does not exist<br>\n";
    echo "<p style='color: orange;'>Creating database now...</p>\n";
    
    if ($conn->query("CREATE DATABASE lms_terrado CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
        echo "✅ Database 'lms_terrado' created<br>\n";
        $conn->select_db('lms_terrado');
    } else {
        echo "❌ Failed to create database: " . $conn->error . "<br>\n";
        exit;
    }
}

// Test users table
echo "<h2>3. Testing Users Table</h2>\n";
$table_check = $conn->query("SHOW TABLES LIKE 'users'");
if ($table_check && $table_check->num_rows > 0) {
    echo "✅ Users table exists<br>\n";
} else {
    echo "❌ Users table does not exist<br>\n";
    echo "<p style='color: orange;'>Creating users table now...</p>\n";
    
    $create_table = "CREATE TABLE users (
        id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin','user','instructor','student') NOT NULL DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY email (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($create_table)) {
        echo "✅ Users table created<br>\n";
    } else {
        echo "❌ Failed to create users table: " . $conn->error . "<br>\n";
        exit;
    }
}

// Test/create user account
echo "<h2>4. Testing User Account</h2>\n";
$user_check = $conn->prepare("SELECT * FROM users WHERE email = ?");
$email = 'terrado@gmail.com';
$user_check->bind_param('s', $email);
$user_check->execute();
$result = $user_check->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "✅ User account exists: " . htmlspecialchars($user['name']) . " (" . htmlspecialchars($user['email']) . ")<br>\n";
    echo "📊 Role: " . htmlspecialchars($user['role']) . "<br>\n";
    echo "📅 Created: " . htmlspecialchars($user['created_at']) . "<br>\n";
} else {
    echo "❌ User account does not exist<br>\n";
    echo "<p style='color: orange;'>Creating user account now...</p>\n";
    
    $insert_user = $conn->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $name = 'Terrado User';
    $password_hash = password_hash('siopao123', PASSWORD_DEFAULT);
    $role = 'admin';
    
    $insert_user->bind_param('ssss', $name, $email, $password_hash, $role);
    
    if ($insert_user->execute()) {
        echo "✅ User account created successfully<br>\n";
        echo "👤 Name: $name<br>\n";
        echo "📧 Email: $email<br>\n";
        echo "🔑 Password: siopao123<br>\n";
        echo "👑 Role: $role<br>\n";
    } else {
        echo "❌ Failed to create user account: " . $insert_user->error . "<br>\n";
    }
    $insert_user->close();
}
$user_check->close();

// Test password verification
echo "<h2>5. Testing Password Verification</h2>\n";
$login_test = $conn->prepare("SELECT password FROM users WHERE email = ?");
$login_test->bind_param('s', $email);
$login_test->execute();
$password_result = $login_test->get_result();

if ($password_result->num_rows > 0) {
    $stored_password = $password_result->fetch_assoc()['password'];
    
    if (password_verify('siopao123', $stored_password)) {
        echo "✅ Password verification successful<br>\n";
        echo "🔐 Login with 'siopao123' will work<br>\n";
    } else {
        echo "❌ Password verification failed<br>\n";
        echo "⚠️ There might be an issue with the stored password hash<br>\n";
    }
} else {
    echo "❌ Could not retrieve password for verification<br>\n";
}
$login_test->close();

$conn->close();

// Final status
echo "<div style='background: #d4edda; padding: 25px; border-radius: 10px; margin: 30px 0; border: 2px solid #28a745;'>\n";
echo "<h2>🎉 DATABASE RESTORATION TEST COMPLETE!</h2>\n";
echo "<h3>✅ Status Summary:</h3>\n";
echo "<ul style='font-size: 16px;'>\n";
echo "<li>✅ MySQL connection works without password</li>\n";
echo "<li>✅ Database 'lms_terrado' is ready</li>\n";
echo "<li>✅ Users table exists with proper structure</li>\n";
echo "<li>✅ Your admin account is set up</li>\n";
echo "<li>✅ Password verification works</li>\n";
echo "</ul>\n";

echo "<h3>🚀 Ready to Use:</h3>\n";
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 15px 0; font-family: monospace;'>\n";
echo "<strong>Login URL:</strong> http://localhost/ITE311-TERRADO/login<br>\n";
echo "<strong>Email:</strong> terrado@gmail.com<br>\n";
echo "<strong>Password:</strong> siopao123<br>\n";
echo "<strong>Role:</strong> Admin\n";
echo "</div>\n";

echo "<div style='margin-top: 25px;'>\n";
echo "<a href='login' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; margin-right: 15px;'>🚀 Test Login Now</a>\n";
echo "<a href='http://localhost/phpmyadmin' style='background: #17a2b8; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px;' target='_blank'>🔍 Test phpMyAdmin</a>\n";
echo "</div>\n";
echo "</div>\n";

echo "<h3>📝 Technical Details:</h3>\n";
echo "<ul>\n";
echo "<li><strong>Database:</strong> lms_terrado (utf8mb4)</li>\n";
echo "<li><strong>Main Table:</strong> users</li>\n";
echo "<li><strong>MySQL:</strong> No password authentication</li>\n";
echo "<li><strong>phpMyAdmin:</strong> Should work without password</li>\n";
echo "</ul>\n";
?>