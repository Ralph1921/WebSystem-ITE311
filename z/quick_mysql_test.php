<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>MySQL Connection Test</h2>\n";

// Common passwords to try
$passwords = [
    '' => 'empty password',
    'root' => 'password: root',
    'admin' => 'password: admin', 
    'password' => 'password: password',
    '123456' => 'password: 123456',
    'mysql' => 'password: mysql'
];

$connected = false;
$working_password = '';

foreach ($passwords as $pwd => $desc) {
    echo "Testing $desc...<br>";
    
    try {
        $conn = new mysqli('localhost', 'root', $pwd, '', 3306);
        
        if (!$conn->connect_error) {
            echo "✅ <strong>SUCCESS!</strong> Connected with $desc<br>";
            $working_password = $pwd;
            $connected = true;
            
            // Create database
            $conn->query("CREATE DATABASE IF NOT EXISTS lms_terrado CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "✅ Database 'lms_terrado' created/verified<br>";
            
            // Switch to database
            $conn->select_db('lms_terrado');
            
            // Create users table
            $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                role ENUM('admin','user') NOT NULL DEFAULT 'user',
                created_at DATETIME NULL,
                updated_at DATETIME NULL,
                PRIMARY KEY (id),
                UNIQUE KEY email (email)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            
            if ($conn->query($sql)) {
                echo "✅ Users table created/verified<br>";
                
                // Check if user exists
                $check = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE email = ?");
                $email = 'terrado@gmail.com';
                $check->bind_param('s', $email);
                $check->execute();
                $result = $check->get_result()->fetch_assoc();
                
                if ($result['count'] == 0) {
                    // Insert user
                    $insert = $conn->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
                    $name = 'Terrado User';
                    $password_hash = password_hash('siopao123', PASSWORD_DEFAULT);
                    $role = 'admin';
                    $insert->bind_param('ssss', $name, $email, $password_hash, $role);
                    
                    if ($insert->execute()) {
                        echo "✅ User 'terrado@gmail.com' created successfully<br>";
                    } else {
                        echo "❌ Failed to create user: " . $insert->error . "<br>";
                    }
                    $insert->close();
                } else {
                    echo "✅ User 'terrado@gmail.com' already exists<br>";
                }
                $check->close();
            } else {
                echo "❌ Failed to create users table: " . $conn->error . "<br>";
            }
            
            $conn->close();
            break;
        } else {
            echo "❌ Failed: " . $conn->connect_error . "<br>";
        }
    } catch (Exception $e) {
        echo "❌ Exception: " . $e->getMessage() . "<br>";
    }
    echo "<br>";
}

if ($connected) {
    echo "<div style='background: #d4edda; padding: 15px; margin: 20px 0; border: 1px solid #c3e6cb; border-radius: 5px;'>";
    echo "<h3>🎉 SUCCESS!</h3>";
    echo "<p><strong>Working MySQL password:</strong> '$working_password'</p>";
    echo "<p><strong>Login credentials:</strong></p>";
    echo "<ul>";
    echo "<li>Email: <strong>terrado@gmail.com</strong></li>";
    echo "<li>Password: <strong>siopao123</strong></li>";
    echo "</ul>";
    echo "<p>Now update your CodeIgniter database config:</p>";
    echo "<pre>File: app/Config/Database.php\nLine 33: 'password' => '$working_password',</pre>";
    echo "<p><a href='login' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Test Login Now</a></p>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 15px; margin: 20px 0; border: 1px solid #f5c6cb; border-radius: 5px;'>";
    echo "<h3>❌ Connection Failed</h3>";
    echo "<p>None of the common passwords worked. You'll need to:</p>";
    echo "<ol>";
    echo "<li>Reset the MySQL root password manually</li>";
    echo "<li>Or use XAMPP's MySQL instead</li>";
    echo "</ol>";
    echo "</div>";
}
?>