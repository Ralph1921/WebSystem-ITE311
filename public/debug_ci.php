<?php
echo "<h1>🔍 CodeIgniter Debug</h1>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Current Directory:</strong> " . __DIR__ . "</p>";

// Try to manually bootstrap CodeIgniter
try {
    // Set path constants
    define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
    
    $pathsPath = realpath(FCPATH . '../app/Config/Paths.php');
    echo "<p><strong>Paths file:</strong> " . ($pathsPath ? "✅ Found: $pathsPath" : "❌ Not found") . "</p>";
    
    if ($pathsPath) {
        $paths = require_once $pathsPath;
        echo "<p><strong>System Path:</strong> " . (isset($paths['systemDirectory']) ? $paths['systemDirectory'] : 'Not set') . "</p>";
        
        // Try to load bootstrap
        $bootstrapPath = $paths['systemDirectory'] . '/bootstrap.php';
        echo "<p><strong>Bootstrap file:</strong> " . (file_exists($bootstrapPath) ? "✅ Found" : "❌ Not found: $bootstrapPath") . "</p>";
        
        if (file_exists($bootstrapPath)) {
            echo "<p>✅ CodeIgniter files are accessible</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p><strong>❌ Error:</strong> " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>Direct File Tests:</h2>";
echo "<ul>";
echo "<li><a href='http://localhost/ITE311-TERRADO/index.php'>📄 Direct index.php</a></li>";
echo "<li><a href='http://localhost/ITE311-TERRADO/test_intl.php'>🧪 PHP Test</a></li>";
echo "</ul>";
?>

<h2>Expected Homepage URL:</h2>
<p><a href="http://localhost/ITE311-TERRADO/" style="font-size: 18px; color: blue;">🏠 http://localhost/ITE311-TERRADO/</a></p>