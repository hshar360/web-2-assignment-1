<?php
header('Content-Type: application/json');
include('../includes/config.inc.php');

$response = [
    'status' => 'error',
    'message' => '',
    'data' => null
];


if (!isset($_GET['userid']) || !is_numeric($_GET['userid'])) {
    $response['message'] = 'Missing or invalid userid parameter.';
    echo json_encode($response);
    exit;
}

$userid = (int) $_GET['userid'];

try {
    // query
    $sql = "
        SELECT 
            companies.symbol,
            companies.name,
            companies.sector,
            portfolio.amount,
            ROUND(portfolio.amount * h.close, 2) AS value
        FROM portfolio
        INNER JOIN companies ON portfolio.symbol = companies.symbol
        INNER JOIN history h 
            ON portfolio.symbol = h.symbol
            AND h.date = (
                SELECT MAX(date) FROM history WHERE symbol = portfolio.symbol
            )
        WHERE portfolio.userId = :userId
        ORDER BY companies.name;
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $portfolio = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // calculate
    $totalShares = 0;
    $totalValue = 0;

    foreach ($portfolio as $item) {
        $totalShares += $item['amount'];
        $totalValue += $item['value'];
    }

    $response['status'] = 'success';
    $response['data'] = [
        'summary' => [
            'companies' => count($portfolio),
            'totalShares' => $totalShares,
            'totalValue' => round($totalValue, 2)
        ],
        'portfolio' => $portfolio
    ];

} catch (PDOException $e) {
    
}

echo json_encode($response, JSON_PRETTY_PRINT);

?>