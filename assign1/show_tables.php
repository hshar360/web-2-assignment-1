<?php
include('includes/config.inc.php');

// Get all table names
$tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(PDO::FETCH_COLUMN);

foreach ($tables as $table) {
    echo "<h2>Table: $table</h2>";
    $columns = $pdo->query("PRAGMA table_info($table)")->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($columns);
    echo "</pre>";
}
?>
