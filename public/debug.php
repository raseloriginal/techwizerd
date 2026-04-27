<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Info</h1>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Current File: " . __FILE__ . "<br>";

require_once dirname(__DIR__) . '/config/config.php';
echo "BASE_URL: " . BASE_URL . "<br>";
echo "DB_HOST: " . DB_HOST . "<br>";
echo "DB_NAME: " . DB_NAME . "<br>";

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    echo "<h2 style='color:green'>Database Connection Success!</h2>";
} catch (Exception $e) {
    echo "<h2 style='color:red'>Database Connection Failed: " . $e->getMessage() . "</h2>";
}

echo "<h2>Checking for required tables</h2>";
$required_tables = ['projects', 'clients', 'services', 'team', 'settings', 'expenses', 'contact_messages'];
foreach ($required_tables as $table) {
    try {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "<div style='color:green'>Table '$table' exists.</div>";
            // Check columns for projects
            if ($table === 'projects') {
                $cols = $pdo->query("SHOW COLUMNS FROM projects LIKE 'is_deleted'");
                if ($cols->rowCount() > 0) {
                    echo "<div style='color:green; padding-left:20px'>- column 'is_deleted' exists.</div>";
                } else {
                    echo "<div style='color:red; padding-left:20px'>- column 'is_deleted' MISSING!</div>";
                }
            }
        } else {
            echo "<div style='color:red'>Table '$table' MISSING!</div>";
        }
    } catch (Exception $e) {
        echo "Error checking table '$table': " . $e->getMessage() . "<br>";
    }
}
