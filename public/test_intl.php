<?php
echo "<h1>✅ PHP and intl Extension Test</h1>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";

if (extension_loaded('intl')) {
    echo "<p><strong>✅ intl Extension:</strong> LOADED</p>";
    echo "<p><strong>ICU Version:</strong> " . INTL_ICU_VERSION . "</p>";
    echo "<p><strong>ICU Data Version:</strong> " . INTL_ICU_DATA_VERSION . "</p>";
} else {
    echo "<p><strong>❌ intl Extension:</strong> NOT LOADED</p>";
}

echo "<hr>";
echo "<h2>🎯 Test Your LMS Application:</h2>";
echo "<ul>";
echo "<li><a href='http://localhost:8080/ITE311-TERRADO/public/'>🏠 Homepage</a></li>";
echo "<li><a href='http://localhost:8080/ITE311-TERRADO/public/login'>🔐 Login Page</a></li>";
echo "<li><a href='http://localhost:8080/ITE311-TERRADO/public/register'>📝 Register Page</a></li>";
echo "</ul>";
?>