<?php
/**
 * Migration script to add is_deleted column to projects table
 * Accessed via public URL
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/models/Database.php';

echo "<pre>"; // For better browser formatting
try {
    $db = Database::getInstance()->getConnection();
    
    echo "Starting migration...\n";
    
    // Check if column exists
    $checkColumn = $db->query("SHOW COLUMNS FROM projects LIKE 'is_deleted'");
    if ($checkColumn->rowCount() == 0) {
        echo "Adding 'is_deleted' column to 'projects' table...\n";
        $db->exec("ALTER TABLE projects ADD COLUMN is_deleted TINYINT DEFAULT 0 AFTER is_active");
        echo "Column 'is_deleted' added successfully.\n";
    } else {
        echo "Column 'is_deleted' already exists.\n";
    }
    
    // Sync is_active = 0 to is_deleted = 1 if needed
    echo "Syncing existing inactive projects to deleted status...\n";
    $db->exec("UPDATE projects SET is_deleted = 1 WHERE is_active = 0");
    
    echo "Migration completed successfully!\n";
    
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
echo "</pre>";
