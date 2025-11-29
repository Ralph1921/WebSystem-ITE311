<?php
require 'vendor/autoload.php';
$db = \Config\Database::connect();
$result = $db->query('SELECT * FROM notifications ORDER BY created_at DESC LIMIT 10');
echo "Notifications found: " . count($result->getResultArray()) . "\n";
print_r($result->getResultArray());
