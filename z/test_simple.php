<?php
// Simple test to see if CodeIgniter is working
echo "PHP is working!<br>";
echo "Current time: " . date('Y-m-d H:i:s') . "<br>";

// Test if we can include CodeIgniter
try {
    require_once 'vendor/autoload.php';
    echo "Composer autoloader loaded successfully!<br>";
} catch (Exception $e) {
    echo "Error loading autoloader: " . $e->getMessage() . "<br>";
}
?>
