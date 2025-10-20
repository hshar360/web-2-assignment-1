<?php
include('includes/config.inc.php');

// fetch all users
try {
    $userSQL = "SELECT id, firstname, lastname FROM users ORDER BY lastname, firstname";
    $users = $pdo->query($userSQL)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching users: " . $e->getMessage());
}

// calculate selected users info
$selectedUserId = $_GET['userid'] ?? null;
$portfolio = [];
$totalAmount = 0;
$totalValue = 0;

if ($selectedUserId) {
    try {
        // fecth all the stocks
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
        $stmt->bindParam(':userId', $selectedUserId, PDO::PARAM_INT);
        $stmt->execute();
        $portfolio = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // calculate 
        foreach ($portfolio as $row) {
            $totalAmount += $row['amount'];
            $totalValue += $row['value'];
        }
    } catch (PDOException $e) {
        die("Error fetching portfolio: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Portfolio Project – Home</title>
    <link rel="stylesheet" href="css/index.css">



</head>
<body>
    <!-- navigation-->
    <header>
        <div class="nav-container">
            <h1 class="site-title">Portfolio Project</h1>
            <nav>
                <a href="index.php" class="active">Home</a>

                <a href="about.php">About</a>
                <a href="API.php">API tester</a>
            </nav>
        </div>
    </header>

    
    <main class="container portfolio-layout">
        <!-- users -->
        <section class="users-panel">
            <h2>Users</h2>

            <?php
            //list out all users
                foreach ($users as $user) {
                    echo '<div class="user-card">';
                    echo '<p>' . $user['lastname'] . ', ' . $user['firstname'] . '</p>';
                    echo '<a class="btn" href="index.php?userid=' . $user['id'] . '">Portfolio</a>';
                    echo '</div>';
                }
            ?>

        </section>

        <!-- the portfolio-->
        <section class="portfolio-panel">
            <?php
                echo '<h2>Portfolio Summary</h2>';
                echo '<div class="summary-boxes">';
                echo '<div class="summary-item">';
                echo '<h3>Companies</h3>';
                echo '<p>' . count($portfolio) . '</p>';
                echo '</div>';
                echo '<div class="summary-item">';
                echo '<h3># Shares</h3>';
                echo '<p>' . $totalAmount . '</p>';
                echo '</div>';
                echo '<div class="summary-item">';
                echo '<h3>Total Value</h3>';
                echo '<p>$' . number_format($totalValue, 2) . '</p>';
                echo '</div>';
                echo '</div>';

                echo '<h2>Portfolio Details</h2>';

                if (count($portfolio) > 0) {
                    echo '<table>';
                    echo '<tr>
                    <th>Symbol</th>
                    <th>Name</th>
                    <th>Sector</th>
                    <th>Amount</th>
                    <th>Value</th>
                    </tr>';

                    foreach ($portfolio as $row) {
                        echo '<tr>';
                        echo '<td><a href="company.php?symbol=' . $row['symbol'] . '">' . $row['symbol'] . '</a></td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['sector'] . '</td>';
                        echo '<td>' . $row['amount'] . '</td>';
                        echo '<td>$' . number_format($row['value'], 2) . '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                } 
            ?>
        </section>




    </main>
</body>
</html>
