<?php
// Debug script for login issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Login Issues</h1>";

// 1. Check database connection
echo "<h2>1. Database Connection Test</h2>";
try {
    $db = new mysqli('localhost', 'root', '', 'lms_terrado', 3306);
    if ($db->connect_error) {
        echo "❌ Database connection failed: " . $db->connect_error . "<br>";
        echo "Trying port 3307...<br>";
        $db = new mysqli('localhost', 'root', '', 'lms_terrado', 3307);
        if ($db->connect_error) {
            echo "❌ Database connection failed on port 3307 too: " . $db->connect_error . "<br>";
        } else {
            echo "✅ Database connected on port 3307<br>";
        }
    } else {
        echo "✅ Database connected on port 3306<br>";
    }
} catch (Exception $e) {
    echo "❌ Database connection error: " . $e->getMessage() . "<br>";
}

// 2. Check if database exists
echo "<h2>2. Database and Table Check</h2>";
if (isset($db) && !$db->connect_error) {
    $result = $db->query("SHOW DATABASES LIKE 'lms_terrado'");
    if ($result && $result->num_rows > 0) {
        echo "✅ Database 'lms_terrado' exists<br>";
        
        // Check users table
        $result = $db->query("SHOW TABLES LIKE 'users'");
        if ($result && $result->num_rows > 0) {
            echo "✅ Users table exists<br>";
            
            // Check specific user
            $stmt = $db->prepare("SELECT id, email, name, password FROM users WHERE email = ?");
            $stmt->bind_param("s", $_GET['email'] ?? 'terrado@gmail.com');
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                echo "✅ User found: " . htmlspecialchars($user['name']) . " (" . htmlspecialchars($user['email']) . ")<br>";
                
                // Test password verification
                $test_password = $_GET['password'] ?? 'siopao123';
                if (password_verify($test_password, $user['password'])) {
                    echo "✅ Password verification successful<br>";
                } else {
                    echo "❌ Password verification failed<br>";
                    echo "Stored hash: " . substr($user['password'], 0, 50) . "...<br>";
                }
            } else {
                echo "❌ User with email 'terrado@gmail.com' not found<br>";
                
                // Show all users for debugging
                $all_users = $db->query("SELECT id, email, name FROM users LIMIT 5");
                if ($all_users && $all_users->num_rows > 0) {
                    echo "Existing users:<br>";
                    while ($row = $all_users->fetch_assoc()) {
                        echo "- " . htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['email']) . ")<br>";
                    }
                }
            }
        } else {
            echo "❌ Users table does not exist<br>";
        }
    } else {
        echo "❌ Database 'lms_terrado' does not exist<br>";
    }
}

// 3. Check CodeIgniter environment
echo "<h2>3. CodeIgniter Environment Check</h2>";
if (file_exists('./app/Config/Database.php')) {
    echo "✅ CodeIgniter Database config exists<br>";
} else {
    echo "❌ CodeIgniter Database config missing<br>";
}

// 4. Test simple form processing
echo "<h2>4. Simple Form Test</h2>";
if ($_POST) {
    echo "✅ POST data received:<br>";
    foreach ($_POST as $key => $value) {
        echo "- $key: " . htmlspecialchars($value) . "<br>";
    }
}

echo '<form method="post">
    <input type="email" name="test_email" placeholder="Email" value="terrado@gmail.com"><br>
    <input type="password" name="test_password" placeholder="Password" value="siopao123"><br>
    <button type="submit">Test Form</button>
</form>';

echo "<br><a href='?email=terrado@gmail.com&password=siopao123'>Test with URL parameters</a>";
?>