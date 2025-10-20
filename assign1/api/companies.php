<?php
// =======================================================
// COMP 3512 - Assignment 1
// API: companies.php
// Returns JSON list of all companies or one by symbol
// =======================================================

// Set JSON response type
header('Content-Type: application/json');

// Include your database configuration
require_once('../includes/config.inc.php');

try {
    // Check if a query parameter 'ref' was provided
    if (isset($_GET['ref']) && !empty($_GET['ref'])) {
        // Return a specific company by its symbol
        $symbol = $_GET['ref'];
        $sql = "SELECT * FROM companies WHERE symbol = :symbol";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':symbol', $symbol, PDO::PARAM_STR);
        $stmt->execute();
        $company = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($company) {
            echo json_encode($company, JSON_PRETTY_PRINT);
        } else {
            echo json_encode(["error" => "Company not found"]);
        }
    } else {
        // Return all companies
        $sql = "SELECT * FROM companies ORDER BY name";
        $stmt = $pdo->query($sql);
        $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($companies, JSON_PRETTY_PRINT);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
