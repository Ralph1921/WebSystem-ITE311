<?php
echo "<h1>Quick MySQL Credential Test</h1>";
echo "<p>Testing the most common XAMPP username/password combinations...</p>";
echo "<hr>";

$host = '127.0.0.1';
$port = 3306;

// Most common combinations to test first
$combinations = [
    ['user' => 'root', 'pass' => ''],
    ['user' => 'root', 'pass' => 'root'],
    ['user' => 'root', 'pass' => 'admin'],
    ['user' => 'root', 'pass' => 'password'],
    ['user' => 'root', 'pass' => 'xampp'],
    ['user' => 'root', 'pass' => 'mysql'],
    ['user' => 'admin', 'pass' => ''],
    ['user' => 'admin', 'pass' => 'admin'],
    ['user' => 'mysql', 'pass' => ''],
    ['user' => 'mysql', 'pass' => 'mysql'],
];

foreach ($combinations as $combo) {
    $user = $combo['user'];
    $pass = $combo['pass'];
    
    echo "<p><strong>Testing:</strong> Username: <code>$user</code>, Password: <code>" . ($pass === '' ? '(empty/blank)' : $pass) . "</code></p>";
    
    try {
        $conn = new mysqli($host, $user, $pass, '', $port);
        
        if (!$conn->connect_error) {
            echo "<div style='background: #d4edda; color: #155724; padding: 20px; border: 2px solid #c3e6cb; border-radius: 10px; margin: 15px 0;'>";
            echo "<h2>🎉 FOUND WORKING CREDENTIALS!</h2>";
            echo "<p><strong>Username:</strong> <span style='font-size: 18px; background: yellow; padding: 3px;'>$user</span></p>";
            echo "<p><strong>Password:</strong> <span style='font-size: 18px; background: yellow; padding: 3px;'>" . ($pass === '' ? '(Leave blank/empty)' : $pass) . "</span></p>";
            echo "</div>";
            
            // Test the connection
            $result = $conn->query("SELECT VERSION() as version, USER() as current_user");
            if ($result) {
                $row = $result->fetch_assoc();
                echo "<p><strong>MySQL Version:</strong> " . $row['version'] . "</p>";
                echo "<p><strong>Connected as:</strong> " . $row['current_user'] . "</p>";
            }
            
            echo "<h3>📋 Instructions for phpMyAdmin Login:</h3>";
            echo "<div style='background: #e2f3ff; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
            echo "<ol>";
            echo "<li>Go to: <a href='http://127.0.0.1/phpmyadmin/' target='_blank'>http://127.0.0.1/phpmyadmin/</a></li>";
            echo "<li>When it asks for credentials, enter:</li>";
            echo "<ul>";
            echo "<li><strong>Username:</strong> $user</li>";
            echo "<li><strong>Password:</strong> " . ($pass === '' ? '(leave this field completely empty)' : $pass) . "</li>";
            echo "</ul>";
            echo "<li>Click Login</li>";
            echo "</ol>";
            echo "</div>";
            
            // Auto-configure phpMyAdmin
            echo "<h3>🔧 Auto-configuring phpMyAdmin...</h3>";
            $configFile = 'C:\\xampp\\phpMyAdmin\\config.inc.php';
            $config = file_get_contents($configFile);
            
            // Set to auto-login configuration
            $config = preg_replace("/\\\$cfg\['Servers'\]\[\\\$i\]\['auth_type'\] = '.*';/", "\$cfg['Servers'][\$i]['auth_type'] = 'config';", $config);
            $config = preg_replace("/\\\$cfg\['Servers'\]\[\\\$i\]\['user'\] = '.*';/", "\$cfg['Servers'][\$i]['user'] = '$user';", $config);
            $config = preg_replace("/\\\$cfg\['Servers'\]\[\\\$i\]\['password'\] = '.*';/", "\$cfg['Servers'][\$i]['password'] = '$pass';", $config);
            
            if (file_put_contents($configFile, $config)) {
                echo "<p style='color: green; font-weight: bold;'>✅ phpMyAdmin has been configured for automatic login!</p>";
                echo "<div style='background: #d4edda; color: #155724; padding: 15px; border: 2px solid #c3e6cb; border-radius: 10px; margin: 15px 0; text-align: center;'>";
                echo "<h3>🚀 phpMyAdmin is now ready!</h3>";
                echo "<p><a href='http://127.0.0.1/phpmyadmin/' target='_blank' style='font-size: 18px; color: #155724; text-decoration: none; background: #c3e6cb; padding: 10px 20px; border-radius: 5px;'>👉 Access phpMyAdmin Now 👈</a></p>";
                echo "<p>You will be automatically logged in!</p>";
                echo "</div>";
            }
            
            $conn->close();
            exit; // Stop testing once we find working credentials
        } else {
            echo "<span style='color: red;'>❌ Failed: " . $conn->connect_error . "</span>";
        }
    } catch (Exception $e) {
        echo "<span style='color: red;'>❌ Error: " . $e->getMessage() . "</span>";
    }
    
    echo "<br><br>";
}

echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px;'>";
echo "<h3>❌ No working credentials found in quick test</h3>";
echo "<p>Please run the comprehensive test: <a href='find_and_setup_credentials.php'>find_and_setup_credentials.php</a></p>";
echo "<p>Or you may need to reset the MySQL password with administrator privileges.</p>";
echo "</div>";
?>