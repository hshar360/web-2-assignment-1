<?php
include('includes/config.inc.php');


if (isset($_GET['symbol'])) {
    $symbol = $_GET['symbol'];
} else {
    $symbol = '';
}


if ($symbol == '') {
    echo "<p style='color:red;'>No company symbol provided.</p>";
    exit;
}

// Step 2 - Get company details
try {
    $sql = "SELECT * FROM companies WHERE symbol = :symbol";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':symbol', $symbol, PDO::PARAM_STR);
    $stmt->execute();
    $company = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$company) {
        echo "<p style='color:red;'>Company not found.</p>";
        exit;
    }
} catch (PDOException $e) {
    
}

// Step 3 - Retrieve related stock history
try {
    $historySQL = "SELECT * FROM history WHERE symbol = :symbol ORDER BY date DESC";
    $stmt2 = $pdo->prepare($historySQL);
    $stmt2->bindParam(':symbol', $symbol, PDO::PARAM_STR);
    $stmt2->execute();
    $history = $stmt2->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $company['name']; ?> – Company Details</title>
    <link rel="stylesheet" href="css/company.css">


</head>


<body>
    <!-- navigation menu -->
    <div class="nav-container">
            <h1 class="site-title">Portfolio Project</h1>
            <nav >
                <a href="index.php" >Home</a>
                <a href="about.php" >About</a>
                <a href="API.php" >API tester</a>
                
            </nav>
        </div>

    <!--company details-->
    <main class="container">
        <h1><?php echo $company['name'] ?></h1>
        <section class="company-info">
        
        <p>
            <strong>Symbol:</strong> 
            <?php echo $company['symbol'] ?>
        </p>
        <p>
            <strong>Sector:</strong>
             <?php echo $company['sector'] ?>
        </p>
        <p>
            <strong>Subindustry:</strong>
             <?php echo $company['subindustry'] ?>
        </p>
        <p>
            <strong>Exchange:</strong> 
            <?php echo $company['exchange'] ?>
        </p>
        <p>
            <strong>Address:</strong> 
            <?php echo $company['address'] ?></p>
        <p>
            <strong>Website:</strong> 
            <a href="<?php echo $company['website'] ?>" target="_blank">
                <?php echo $company['website'] ?>
            </a>
        </p>

        </section>
    </main>

   


        <!--Stock history table--> 
        <section class="stock-history">
            

            <!-- Description Section -->
                <section class="description">
                    <h2>Description</h2>
                        <p style="white-space: pre-line;">
                            <?php echo $company['description'] ?>
                        </p>
                </section>

            </div>
                <!-- Stats -->
                <div class="stats-box">
                    <div class="stat">
                        <h3>History High</h3>
                        <p>$94.45</p>
                    </div>
                    <div class="stat">
                        <h3>History Low</h3>
                        <p>$78.74</p>
                    </div>
                    <div class="stat">
                        <h3>Total Volume</h3>
                        <p>45,564,765</p>
                    </div>
                    <div class="stat">
                        <h3>Average Volume</h3>
                        <p>164,503</p>
                    </div>
                </div>

                
                <h2>Stock History (<?php echo $company['symbol'] ?>)</h2>
                <div class="history-layout">
                
                    <div class="history-table">

                        <?php
                        //stock history
                            if (count($history) > 0) {
                                echo '<table>
                                    <tr>                      
                                        <th>Date</th>
                                        <th>Open</th>
                                        <th>Close</th>
                                        <th>High</th>
                                        <th>Low</th>
                                        <th>Volume</th>
                                    </tr>';
    
                                foreach ($history as $record) {
                                    echo '<tr>';
                                    echo '<td>' . $record['date'] . '</td>';
                                    echo '<td>' . $record['open'] . '</td>';
                                    echo '<td>' . $record['close'] . '</td>';
                                    echo '<td>' . $record['high'] . '</td>';
                                    echo '<td>' . $record['low'] . '</td>';
                                    echo '<td>' . $record['volume'] . '</td>';
                                    echo '</tr>';
                                }

                                echo '</table>';
                            } else {
                                echo '<p>No stock history found for this company.</p>';
                            }
                        ?>
            
            
            </div>
        </section>


        
        
        

        <p>
            <a href="index.php">&larr; Back to main paget</a>
        </p>
    </main>
</body>
</html>
