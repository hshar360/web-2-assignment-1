<?php
include('includes/config.inc.php');


try {
    $sectorQuery = "SELECT DISTINCT sector FROM companies ORDER BY sector";
    $sectors = $pdo->query($sectorQuery)->fetchAll();
} catch (PDOException $e) {
    
}


if (isset($_GET['sector'])) {
    $selectedSector = $_GET['sector'];
} else {
    $selectedSector = '';
}



try {
    if ($selectedSector && $selectedSector !== 'All') {
        $sql = "SELECT * FROM companies WHERE sector = :sector ORDER BY name";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':sector', $selectedSector, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt;
    } else {
        $sql = "SELECT * FROM companies ORDER BY name";
        $result = $pdo->query($sql);
    }
} catch (PDOException $e) {
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Company Directory</title>
    <link rel="stylesheet" href="css/companies.css">
</head>
<body>
    <!-- navigation menu -->
    <div class="nav-container">
            <h1 class="site-title">Portfolio Project</h1>
            <nav >
                <a href="companies.php" >Home</a>
                <a href="users.php" >Users</a>
                <a href="API.php" >API tester</a>
                <a href="about.php" >About</a>
            </nav>
        </div>

<main class="container">

    <h1>Company Directory</h1>
    <p>Select a company to view more details.</p>
    <h1>Companies List</h1>

    <!-- form -->
    <form method="get" style="text-align:center; margin-bottom:20px;">
        <label for="sector">Filter by Sector: </label>
        
        <select name="sector" id="sector">
            
        <option value="All">All Sectors</option>
            <?php
                foreach ($sectors as $s) {
                    $sector = $s['sector'];
                    
                    if ($sector === $selectedSector) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }

                    echo "<option value='$sector' $selected>$sector</option>";
                }
            ?>
        </select>
    
        <button type="submit">Filter</button>

    </form>


    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Name</th>
            <th>Symbol</th>
            <th>Sector</th>
            <th>Exchange</th>
        </tr>

        <?php
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td><a href='company.php?symbol=" . $row['symbol'] . "'>" . $row['name'] . "</a></td>";
                echo "<td>" . $row['symbol'] . "</td>";
                echo "<td>" . $row['sector'] . "</td>";
                echo "<td>" . $row['exchange'] . "</td>";
                echo "</tr>";
            }
        ?>



    </table>

</main>
</body>
</html>

