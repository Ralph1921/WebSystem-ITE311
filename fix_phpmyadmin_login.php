<?php
// phpMyAdmin Login Fix Tool
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔐 phpMyAdmin Login Fix Tool</h1>";

echo "<style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
    .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto; }
    .method { border: 2px solid #e0e0e0; padding: 20px; margin: 20px 0; border-radius: 5px; }
    .method h3 { color: #2563eb; margin-top: 0; }
    .success { background: #d4edda; border-color: #c3e6cb; color: #155724; }
    .warning { background: #fff3cd; border-color: #ffeaa7; color: #856404; }
    .error { background: #f8d7da; border-color: #f5c6cb; color: #721c24; }
    .code { background: #f8f9fa; border: 1px solid #e9ecef; padding: 10px; font-family: monospace; margin: 10px 0; }
    .highlight { background: #ffff99; padding: 2px 5px; }
    button { background: #2563eb; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    button:hover { background: #1d4ed8; }
</style>";

echo "<div class='container'>";

// Test database connections with common passwords
echo "<h2>🧪 Testing MySQL Connection</h2>";

$common_passwords = [
    '' => 'Empty (no password)',
    'password' => 'password',
    'root' => 'root',
    'admin' => 'admin',
    'xampp' => 'xampp',
    'mysql' => 'mysql',
    'vertrigo' => 'vertrigo',
    '123456' => '123456'
];

$working_credentials = [];
$mysql_ports = [3306, 3307];

foreach ($mysql_ports as $port) {
    echo "<h3>Testing Port $port:</h3>";
    
    foreach ($common_passwords as $pwd => $label) {
        try {
            $mysqli = new mysqli('localhost', 'root', $pwd, '', $port);
            
            if (!$mysqli->connect_error) {
                echo "<div class='method success'>";
                echo "✅ <strong>SUCCESS!</strong> MySQL connection works with:<br>";
                echo "🔑 <strong>Username:</strong> root<br>";
                echo "🔑 <strong>Password:</strong> " . ($pwd === '' ? '<em>Empty (leave blank)</em>' : "<span class='highlight'>$pwd</span>") . "<br>";
                echo "🔌 <strong>Port:</strong> $port<br>";
                echo "<p><strong>📋 Use these credentials in phpMyAdmin:</strong></p>";
                echo "<p>Go to <a href='http://localhost/phpmyadmin/' target='_blank'>phpMyAdmin</a> and login with:</p>";
                echo "<div class='code'>";
                echo "Username: <strong>root</strong><br>";
                echo "Password: <strong>" . ($pwd === '' ? '(leave empty)' : $pwd) . "</strong>";
                echo "</div>";
                echo "</div>";
                
                $working_credentials[] = ['user' => 'root', 'pass' => $pwd, 'port' => $port];
                
                // Close connection
                $mysqli->close();
                break 2; // Exit both loops if we found working credentials
            }
        } catch (Exception $e) {
            // Continue testing
        }
    }
}

if (empty($working_credentials)) {
    echo "<div class='method error'>";
    echo "<h3>❌ No Working Credentials Found</h3>";
    echo "<p>None of the common passwords work. Let's reset MySQL to allow passwordless access.</p>";
    echo "</div>";
    
    // Provide reset instructions
    echo "<div class='method warning'>";
    echo "<h3>🔧 Method 1: Reset MySQL Using XAMPP Control Panel</h3>";
    echo "<ol>";
    echo "<li><strong>Open XAMPP Control Panel</strong> as Administrator</li>";
    echo "<li><strong>Stop MySQL service</strong> (click Stop next to MySQL)</li>";
    echo "<li><strong>Click Config</strong> next to MySQL → Select <strong>my.ini</strong></li>";
    echo "<li><strong>Find the [mysqld] section</strong> and add this line:</li>";
    echo "<div class='code'>skip-grant-tables</div>";
    echo "<li><strong>Save the file</strong> and close the editor</li>";
    echo "<li><strong>Start MySQL service</strong> again</li>";
    echo "<li><strong>Now try phpMyAdmin</strong> - it should work without password</li>";
    echo "<li><strong>After setup:</strong> Remove the 'skip-grant-tables' line and restart MySQL</li>";
    echo "</ol>";
    echo "</div>";
    
    echo "<div class='method warning'>";
    echo "<h3>🔧 Method 2: Manual MySQL Configuration Edit</h3>";
    echo "<p><strong>File to edit:</strong> <code>C:\\xampp\\mysql\\bin\\my.ini</code></p>";
    echo "<p><strong>Add this line</strong> in the [mysqld] section:</p>";
    echo "<div class='code'>skip-grant-tables</div>";
    echo "<p><strong>Then restart MySQL service</strong></p>";
    echo "</div>";
    
    echo "<div class='method warning'>";
    echo "<h3>🔧 Method 3: Alternative phpMyAdmin Access</h3>";
    echo "<p>If MySQL reset doesn't work, try these alternative access methods:</p>";
    echo "<ul>";
    echo "<li><strong>Use MySQL Workbench:</strong> Download MySQL Workbench for GUI access</li>";
    echo "<li><strong>Command Line:</strong> Use MySQL command line client</li>";
    echo "<li><strong>Different User:</strong> Try creating a new MySQL user</li>";
    echo "</ul>";
    echo "</div>";
} else {
    // Show additional setup for the database
    $creds = $working_credentials[0];
    
    echo "<div class='method success'>";
    echo "<h3>🎯 Next Steps: Set Up Your Database</h3>";
    echo "<p>Now that you can access phpMyAdmin, create your database:</p>";
    echo "<ol>";
    echo "<li><strong>Login to phpMyAdmin</strong> with the credentials above</li>";
    echo "<li><strong>Click 'New'</strong> to create a database</li>";
    echo "<li><strong>Database name:</strong> <code>lms_terrado</code></li>";
    echo "<li><strong>Collation:</strong> <code>utf8_general_ci</code></li>";
    echo "<li><strong>Click SQL tab</strong> and run this code:</li>";
    echo "</ol>";
    
    echo "<textarea rows='12' cols='80' style='width: 100%; font-family: monospace;'>";
    echo "CREATE TABLE users (\n";
    echo "    id INT AUTO_INCREMENT PRIMARY KEY,\n";
    echo "    name VARCHAR(100) NOT NULL,\n";
    echo "    email VARCHAR(100) UNIQUE NOT NULL,\n";
    echo "    password VARCHAR(255) NOT NULL,\n";
    echo "    role VARCHAR(20) DEFAULT 'user',\n";
    echo "    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n";
    echo "    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP\n";
    echo ");\n\n";
    echo "-- Insert your user account\n";
    echo "INSERT INTO users (name, email, password, role) VALUES \n";
    echo "('Terrado User', 'terrado@gmail.com', '" . password_hash('siopao123', PASSWORD_DEFAULT) . "', 'admin');";
    echo "</textarea>";
    
    echo "<br><button onclick='copySQL()'>📋 Copy SQL Code</button>";
    
    echo "<script>";
    echo "function copySQL() {";
    echo "    const textarea = document.querySelector('textarea');";
    echo "    textarea.select();";
    echo "    document.execCommand('copy');";
    echo "    alert('SQL code copied to clipboard!');";
    echo "}";
    echo "</script>";
    echo "</div>";
    
    // Update the CodeIgniter config if needed
    if ($creds['pass'] !== '') {
        echo "<div class='method warning'>";
        echo "<h3>⚠️ Update Your CodeIgniter Database Config</h3>";
        echo "<p><strong>File:</strong> <code>C:\\xampp\\htdocs\\ITE311-TERRADO\\app\\Config\\Database.php</code></p>";
        echo "<p><strong>Change line 33 to:</strong></p>";
        echo "<div class='code'>'password' => '" . $creds['pass'] . "',</div>";
        echo "</div>";
    }
}

echo "<div class='method'>";
echo "<h3>🔗 Quick Links</h3>";
echo "<p>";
echo "<a href='http://localhost/phpmyadmin/' target='_blank' style='margin-right: 20px;'>🔗 Open phpMyAdmin</a>";
echo "<a href='http://localhost/ITE311-TERRADO/login' target='_blank' style='margin-right: 20px;'>🔗 Test Your Login</a>";
echo "<a href='http://localhost/ITE311-TERRADO/setup_database.php' target='_blank'>🔗 Database Setup Guide</a>";
echo "</p>";
echo "</div>";

echo "</div>";
?>