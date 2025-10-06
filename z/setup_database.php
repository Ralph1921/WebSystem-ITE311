<?php
// Database setup script for ITE311-TERRADO
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Setup for ITE311-TERRADO</h1>";

// Since we can't connect to MySQL directly due to authentication issues,
// we'll provide instructions for manual setup

echo "<h2>🔧 Database Setup Instructions</h2>";

echo "<p><strong>Follow these steps to fix your login issue:</strong></p>";

echo "<h3>Option 1: Using phpMyAdmin (Recommended)</h3>";
echo "<ol>";
echo "<li><strong>Access phpMyAdmin:</strong> Go to <a href='http://localhost/phpmyadmin/' target='_blank'>http://localhost/phpmyadmin/</a></li>";
echo "<li><strong>Login:</strong> Try these common passwords with username 'root':<br>";
echo "   - Empty password (leave blank)<br>";
echo "   - password<br>";
echo "   - root<br>";
echo "   - admin<br>";
echo "   - xampp</li>";
echo "<li><strong>Create Database:</strong> Click 'New' → Create database named '<strong>lms_terrado</strong>' → Choose 'utf8_general_ci' collation → Click Create</li>";
echo "<li><strong>Create Users Table:</strong> Select the 'lms_terrado' database → Click SQL tab → Paste this SQL:</li>";
echo "</ol>";

echo "<textarea rows='15' cols='80' style='font-family: monospace;'>
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert your user account
INSERT INTO users (name, email, password, role) VALUES 
('Terrado User', 'terrado@gmail.com', '" . password_hash('siopao123', PASSWORD_DEFAULT) . "', 'admin');
</textarea>";

echo "<br><button onclick='copyToClipboard()'>Copy SQL Code</button>";

echo "<h3>Option 2: Using XAMPP Control Panel</h3>";
echo "<ol>";
echo "<li><strong>Open XAMPP Control Panel</strong> as Administrator</li>";
echo "<li><strong>Stop MySQL</strong> service</li>";
echo "<li><strong>Click 'Config'</strong> next to MySQL → Select 'my.ini'</li>";
echo "<li><strong>Find the [mysqld] section</strong> and add this line:<br><code>skip-grant-tables</code></li>";
echo "<li><strong>Save and restart MySQL</strong></li>";
echo "<li><strong>Now phpMyAdmin should work</strong> without password</li>";
echo "<li><strong>Follow Option 1 steps</strong> to create database and user</li>";
echo "<li><strong>Remove skip-grant-tables</strong> from my.ini and restart MySQL</li>";
echo "</ol>";

echo "<h3>Option 3: Manual Database Password Update</h3>";
echo "<p>If you know the MySQL root password, update the database configuration:</p>";
echo "<p><strong>File:</strong> <code>C:\\xampp\\htdocs\\ITE311-TERRADO\\app\\Config\\Database.php</code></p>";
echo "<p><strong>Change line 33:</strong> <code>'password' => 'YOUR_MYSQL_ROOT_PASSWORD',</code></p>";

echo "<h2>🧪 Test After Setup</h2>";
echo "<p>After completing the database setup, test your login:</p>";
echo "<ol>";
echo "<li>Go to: <a href='http://localhost/ITE311-TERRADO/login' target='_blank'>http://localhost/ITE311-TERRADO/login</a></li>";
echo "<li>Use credentials: <strong>terrado@gmail.com</strong> / <strong>siopao123</strong></li>";
echo "<li>Should redirect to dashboard successfully</li>";
echo "</ol>";

echo "<h2>📝 Current Status</h2>";
echo "<p>✅ Login form is working<br>";
echo "✅ CodeIgniter framework is running<br>";
echo "❌ Database connection is failing<br>";
echo "❌ Missing database or user table<br>";
echo "🔧 <strong>Solution:</strong> Complete database setup above</p>";

echo '<script>
function copyToClipboard() {
    const textarea = document.querySelector("textarea");
    textarea.select();
    document.execCommand("copy");
    alert("SQL code copied to clipboard!");
}
</script>';

// Test current database connection status
echo "<h2>🔍 Current Connection Status</h2>";
$common_passwords = ['', 'password', 'root', 'admin', 'xampp'];
$connection_found = false;

foreach ($common_passwords as $pwd) {
    try {
        $test_db = new mysqli('localhost', 'root', $pwd, '', 3306);
        if (!$test_db->connect_error) {
            echo "✅ <strong>MySQL Connection Found!</strong> Password: '" . ($pwd ?: 'empty') . "'<br>";
            
            // Check if database exists
            $db_exists = $test_db->query("SHOW DATABASES LIKE 'lms_terrado'");
            if ($db_exists && $db_exists->num_rows > 0) {
                echo "✅ Database 'lms_terrado' exists<br>";
                
                // Select database and check users table
                $test_db->select_db('lms_terrado');
                $table_exists = $test_db->query("SHOW TABLES LIKE 'users'");
                if ($table_exists && $table_exists->num_rows > 0) {
                    echo "✅ Users table exists<br>";
                    
                    // Check if your user exists
                    $user_exists = $test_db->query("SELECT * FROM users WHERE email = 'terrado@gmail.com'");
                    if ($user_exists && $user_exists->num_rows > 0) {
                        echo "✅ <strong>Your user account exists!</strong><br>";
                        echo "<p style='color: green; font-weight: bold;'>🎉 Everything is set up! Your login should work now.</p>";
                        echo "<p>If login still doesn't work, update the database password in the config file.</p>";
                    } else {
                        echo "❌ Your user account doesn't exist - needs to be created<br>";
                    }
                } else {
                    echo "❌ Users table doesn't exist - needs to be created<br>";
                }
            } else {
                echo "❌ Database 'lms_terrado' doesn't exist - needs to be created<br>";
            }
            
            // Update the config file if we found a working password
            if ($pwd !== '') {
                echo "<p><strong>🔧 Action Required:</strong> Update your database config with password: '<strong>$pwd</strong>'</p>";
                
                // Show the exact line to change
                echo "<p>In file <code>app/Config/Database.php</code> line 33, change to:</p>";
                echo "<code style='background: #f0f0f0; padding: 5px;'>'password' => '$pwd',</code>";
            }
            
            $connection_found = true;
            break;
        }
    } catch (Exception $e) {
        // Continue to next password
    }
}

if (!$connection_found) {
    echo "❌ <strong>No MySQL connection found with common passwords.</strong><br>";
    echo "<p>You'll need to use <strong>Option 2</strong> above to reset MySQL authentication.</p>";
}
?>