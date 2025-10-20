<?php
// =======================================================
// COMP 3512 - Assignment 1
// API: history.php
// Returns JSON stock history for a company by symbol
// =======================================================

// Tell the browser this is JSON, not HTML
header('Content-Type: application/json');

// Include the database connection (update path if needed)
require_once('../includes/config.inc.php');

try {
    // Check if a company symbol was provided via ?ref=
    if (isset($_GET['ref']) && !empty($_GET['ref'])) {
        $symbol = $_GET['ref'];

        // Query for stock history of that symbol (ascending by date)
        $sql = "SELECT date, open, close, high, low, volume
                FROM history
                WHERE symbol = :symbol
                ORDER BY date ASC";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':symbol', $symbol, PDO::PARAM_STR);
        $stmt->execute();
        $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if any data was found
        if ($history) {
            echo json_encode($history, JSON_PRETTY_PRINT);
        } else {
            echo json_encode(["error" => "No history found for symbol: $symbol"]);
        }
    } else {
        // No symbol provided
        echo json_encode(["error" => "Missing required parameter: ref"]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
