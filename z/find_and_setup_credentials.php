<?php
echo "<h1>🔍 Finding Working MySQL Credentials & Setting Up Auto-Login</h1>";
echo "<hr>";

$host = '127.0.0.1';
$port = 3306;

// Extended list of common XAMPP/MySQL passwords
$users = ['root', 'mysql', 'admin', 'xampp', 'user'];
$passwords = [
    '', 
    'root', 
    'admin', 
    'password', 
    'xampp', 
    'mysql', 
    '123456',
    'toor',
    'qwerty',
    'admin123',
    'root123',
    'xampp123',
    'localhost'
];
$hosts = ['127.0.0.1', 'localhost', '::1'];

$workingCredentials = null;

echo "<h2>🔎 Testing Different Credentials...</h2>";

foreach ($hosts as $testHost) {
    if ($workingCredentials) break;
    
    echo "<h3>Testing host: <code>$testHost</code></h3>";
    
    foreach ($users as $testUser) {
        if ($workingCredentials) break;
        
        foreach ($passwords as $testPassword) {
            echo "<p>🔐 Testing: <strong>$testUser</strong>@<strong>$testHost</strong> with password: <strong>'" . ($testPassword === '' ? '(empty)' : $testPassword) . "'</strong></p>";
            
            try {
                // Try different connection methods
                $conn = new mysqli($testHost, $testUser, $testPassword, '', $port);
                
                if (!$conn->connect_error) {
                    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border: 1px solid #c3e6cb; border-radius: 5px; margin: 10px 0;'>";
                    echo "<h3>✅ SUCCESS! Found Working Credentials:</h3>";
                    echo "<ul>";
                    echo "<li><strong>Host:</strong> $testHost</li>";
                    echo "<li><strong>Username:</strong> $testUser</li>";
                    echo "<li><strong>Password:</strong> " . ($testPassword === '' ? '(empty/blank)' : $testPassword) . "</li>";
                    echo "<li><strong>Port:</strong> $port</li>";
                    echo "</ul>";
                    echo "</div>";
                    
                    // Get MySQL version
                    $result = $conn->query("SELECT VERSION() as version");
                    if ($result) {
                        $row = $result->fetch_assoc();
                        echo "<p><strong>Database Version:</strong> " . $row['version'] . "</p>";
                    }
                    
                    // Show databases
                    echo "<h4>📂 Available Databases:</h4>";
                    $result = $conn->query("SHOW DATABASES");
                    if ($result) {
                        echo "<ul>";
                        while ($row = $result->fetch_row()) {
                            echo "<li>" . $row[0] . "</li>";
                        }
                        echo "</ul>";
                    }
                    
                    $workingCredentials = [
                        'host' => $testHost,
                        'user' => $testUser,
                        'password' => $testPassword,
                        'port' => $port
                    ];
                    
                    $conn->close();
                    break 2; // Break out of both password and user loops
                    
                } else {
                    echo "<span style='color: red;'>❌ Failed: " . $conn->connect_error . "</span><br>";
                }
            } catch (Exception $e) {
                echo "<span style='color: red;'>❌ Error: " . $e->getMessage() . "</span><br>";
            }
        }
    }
    echo "<hr>";
}

if ($workingCredentials) {
    echo "<h2>⚙️ Configuring phpMyAdmin for Auto-Login...</h2>";
    
    try {
        $configFile = 'C:\\xampp\\phpMyAdmin\\config.inc.php';
        
        if (!file_exists($configFile)) {
            echo "<p style='color: red;'>❌ phpMyAdmin config file not found!</p>";
            exit;
        }
        
        $config = file_get_contents($configFile);
        
        // Update the configuration
        $config = preg_replace("/\\\$cfg\['Servers'\]\[\\\$i\]\['auth_type'\] = '.*';/", "\$cfg['Servers'][\$i]['auth_type'] = 'config';", $config);
        $config = preg_replace("/\\\$cfg\['Servers'\]\[\\\$i\]\['host'\] = '.*';/", "\$cfg['Servers'][\$i]['host'] = '{$workingCredentials['host']}';", $config);
        $config = preg_replace("/\\\$cfg\['Servers'\]\[\\\$i\]\['user'\] = '.*';/", "\$cfg['Servers'][\$i]['user'] = '{$workingCredentials['user']}';", $config);
        $config = preg_replace("/\\\$cfg\['Servers'\]\[\\\$i\]\['password'\] = '.*';/", "\$cfg['Servers'][\$i]['password'] = '{$workingCredentials['password']}';", $config);
        $config = preg_replace("/\\\$cfg\['Servers'\]\[\\\$i\]\['port'\] = '.*';/", "\$cfg['Servers'][\$i]['port'] = '{$workingCredentials['port']}';", $config);
        
        if (file_put_contents($configFile, $config)) {
            echo "<div style='background: #d1ecf1; color: #0c5460; padding: 15px; border: 1px solid #bee5eb; border-radius: 5px; margin: 10px 0;'>";
            echo "<h3>✅ phpMyAdmin Configuration Updated Successfully!</h3>";
            echo "<p><strong>Auto-login configured with:</strong></p>";
            echo "<ul>";
            echo "<li><strong>Username:</strong> {$workingCredentials['user']}</li>";
            echo "<li><strong>Password:</strong> " . ($workingCredentials['password'] === '' ? '(empty/blank)' : $workingCredentials['password']) . "</li>";
            echo "<li><strong>Host:</strong> {$workingCredentials['host']}</li>";
            echo "<li><strong>Port:</strong> {$workingCredentials['port']}</li>";
            echo "</ul>";
            echo "</div>";
            
            // Create a credentials file for future reference
            $credentialsInfo = "MySQL Credentials for phpMyAdmin\n";
            $credentialsInfo .= "=====================================\n";
            $credentialsInfo .= "Host: {$workingCredentials['host']}\n";
            $credentialsInfo .= "Username: {$workingCredentials['user']}\n";
            $credentialsInfo .= "Password: " . ($workingCredentials['password'] === '' ? '(empty/blank)' : $workingCredentials['password']) . "\n";
            $credentialsInfo .= "Port: {$workingCredentials['port']}\n";
            $credentialsInfo .= "Date: " . date('Y-m-d H:i:s') . "\n";
            
            file_put_contents('mysql_working_credentials.txt', $credentialsInfo);
            echo "<p>📝 Credentials saved to: <code>mysql_working_credentials.txt</code></p>";
            
            echo "<div style='background: #d4edda; color: #155724; padding: 20px; border: 2px solid #c3e6cb; border-radius: 10px; margin: 20px 0; text-align: center;'>";
            echo "<h2>🎉 SUCCESS! You can now access phpMyAdmin!</h2>";
            echo "<p style='font-size: 18px;'><strong><a href='http://127.0.0.1/phpmyadmin/' target='_blank' style='color: #155724;'>👉 Click Here to Access phpMyAdmin 👈</a></strong></p>";
            echo "<p>You will be automatically logged in without entering any credentials!</p>";
            echo "</div>";
            
        } else {
            echo "<p style='color: red;'>❌ Failed to update phpMyAdmin configuration file!</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Error updating configuration: " . $e->getMessage() . "</p>";
    }
    
} else {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px; margin: 10px 0;'>";
    echo "<h3>❌ No Working Credentials Found</h3>";
    echo "<p>None of the common username/password combinations worked.</p>";
    echo "<p><strong>This means you'll need to reset the MySQL password using administrator privileges.</strong></p>";
    echo "</div>";
    
    echo "<h3>🛠️ Next Steps:</h3>";
    echo "<ol>";
    echo "<li>Right-click <strong>Command Prompt</strong> and select <strong>'Run as administrator'</strong></li>";
    echo "<li>Navigate to your project: <code>cd C:\\xampp\\htdocs\\ITE311-TERRADO</code></li>";
    echo "<li>Run: <code>powershell -ExecutionPolicy Bypass -File fix_mysql_auto.ps1</code></li>";
    echo "<li>Or follow the manual steps in: <code>run_as_admin.txt</code></li>";
    echo "</ol>";
}

echo "<hr>";
echo "<p><em>Script completed at: " . date('Y-m-d H:i:s') . "</em></p>";
?>