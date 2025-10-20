<?php
try {
    // ✅ This is the correct path for your structure
    $pdo = new PDO('sqlite:D:/Programming files/htdocs/hshar360/assign1/assign1/data/stocks.db');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . htmlspecialchars($e->getMessage());
    exit;
}
?>


