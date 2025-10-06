<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "PHP Error Reporting Enabled<br>";
echo "Current time: " . date('Y-m-d H:i:s') . "<br>";

// Test if we can load CodeIgniter
try {
    // Set the paths
    define('SYSTEMPATH', realpath('system') . DIRECTORY_SEPARATOR);
    define('APPPATH', realpath('app') . DIRECTORY_SEPARATOR);
    define('WRITEPATH', realpath('writable') . DIRECTORY_SEPARATOR);
    
    echo "Paths defined successfully<br>";
    
    // Try to load CodeIgniter
    require SYSTEMPATH . 'CodeIgniter.php';
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}
?>
