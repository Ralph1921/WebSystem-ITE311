<?php
echo "<h1>PHP is working!</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Current Directory: " . __DIR__ . "</p>";
echo "<p>CodeIgniter Test: ";

try {
    // Test if we can reach CodeIgniter
    if (file_exists('../system/CodeIgniter.php')) {
        echo "✅ CodeIgniter system files found";
    } else {
        echo "❌ CodeIgniter system files missing";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}

echo "</p>";
echo "<hr>";
echo "<p><a href='/ITE311-TERRADO/public/'>Go to CodeIgniter App</a></p>";
echo "<p><a href='/ITE311-TERRADO/'>Go to Root Redirect</a></p>";
?>
