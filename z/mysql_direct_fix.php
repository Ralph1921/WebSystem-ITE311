<?php
echo "<h2>Direct MySQL Fix Attempt</h2>";

// Try to connect using different approaches
$host = '127.0.0.1';
$port = 3306;

// Method 1: Try with mysqli using different SSL and authentication settings
echo "<h3>Method 1: mysqli with SSL disabled</h3>";
try {
    $conn = new mysqli();
    $conn->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, false);
    $conn->real_connect($host, 'root', '', '', $port);
    
    if (!$conn->connect_error) {
        echo "<p style='color: green;'>SUCCESS with mysqli SSL disabled!</p>";
        
        // Try to reset password directly
        $result = $conn->query("SELECT VERSION() as version");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "<p>Connected to: " . $row['version'] . "</p>";
            
            // Attempt to create a new admin user
            $createUser = $conn->query("CREATE USER 'admin'@'localhost' IDENTIFIED BY ''");
            if ($createUser) {
                echo "<p style='color: blue;'>Created admin user</p>";
                $grantPrivs = $conn->query("GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost' WITH GRANT OPTION");
                if ($grantPrivs) {
                    echo "<p style='color: blue;'>Granted all privileges to admin user</p>";
                    $conn->query("FLUSH PRIVILEGES");
                    
                    // Update phpMyAdmin config to use admin user
                    $configFile = 'C:\\xampp\\phpMyAdmin\\config.inc.php';
                    $config = file_get_contents($configFile);
                    $config = preg_replace("/\\\$cfg\['Servers'\]\[\\\$i\]\['user'\] = '.*';/", "\$cfg['Servers'][\$i]['user'] = 'admin';", $config);
                    $config = preg_replace("/\\\$cfg\['Servers'\]\[\\\$i\]\['auth_type'\] = '.*';/", "\$cfg['Servers'][\$i]['auth_type'] = 'config';", $config);
                    file_put_contents($configFile, $config);
                    
                    echo "<p style='color: green;'><strong>SUCCESS! Created admin user and updated phpMyAdmin config.</strong></p>";
                    echo "<p><a href='http://127.0.0.1/phpmyadmin/' target='_blank'>Try phpMyAdmin now with admin user</a></p>";
                }
            } else {
                echo "<p style='color: orange;'>Could not create admin user: " . $conn->error . "</p>";
            }
        }
        
        $conn->close();
        
    } else {
        echo "<p style='color: red;'>Failed: " . $conn->connect_error . "</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>Exception: " . $e->getMessage() . "</p>";
}

// Method 2: Try PDO with different options
echo "<h3>Method 2: PDO with different options</h3>";
try {
    $dsn = "mysql:host=$host;port=$port;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ];
    
    $pdo = new PDO($dsn, 'root', '', $options);
    echo "<p style='color: green;'>SUCCESS with PDO!</p>";
    
    $stmt = $pdo->query("SELECT VERSION() as version");
    $version = $stmt->fetch();
    echo "<p>Connected to: " . $version['version'] . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>PDO failed: " . $e->getMessage() . "</p>";
}

// Method 3: Try different authentication plugins
echo "<h3>Method 3: Test different hosts and sockets</h3>";
$hosts = ['127.0.0.1', 'localhost', '::1'];
$users = ['root', '', 'mysql.user'];

foreach ($hosts as $testHost) {
    foreach ($users as $testUser) {
        if (empty($testUser)) continue;
        
        echo "<p>Testing $testUser@$testHost...</p>";
        try {
            $conn = new mysqli($testHost, $testUser, '', '', $port);
            if (!$conn->connect_error) {
                echo "<p style='color: green; font-weight: bold;'>SUCCESS: $testUser@$testHost works!</p>";
                
                // Update phpMyAdmin
                $configFile = 'C\\xampp\\phpMyAdmin\\config.inc.php';
                $config = file_get_contents($configFile);
                $config = preg_replace("/\\\$cfg\['Servers'\]\[\\\$i\]\['user'\] = '.*';/", "\$cfg['Servers'][\$i]['user'] = '$testUser';", $config);
                $config = preg_replace("/\\\$cfg\['Servers'\]\[\\\$i\]\['host'\] = '.*';/", "\$cfg['Servers'][\$i]['host'] = '$testHost';", $config);
                file_put_contents($configFile, $config);
                
                echo "<p>phpMyAdmin updated to use $testUser@$testHost</p>";
                $conn->close();
                exit;
            }
        } catch (Exception $e) {
            // Silent fail
        }
    }
}

echo "<h3>Summary</h3>";
echo "<p>If none of the above methods worked, you'll need to manually reset MySQL password using administrator privileges.</p>";
echo "<p>Try running this in Command Prompt as Administrator:</p>";
echo "<pre style='background: #f0f0f0; padding: 10px;'>
cd C:\\xampp\\htdocs\\ITE311-TERRADO
powershell -ExecutionPolicy Bypass -File fix_mysql_auto.ps1
</pre>";
?>