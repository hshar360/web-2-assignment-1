<?php
include('config.inc.php');

$sql = "SELECT symbol, name, sector, exchange FROM companies";
$result = $pdo->query($sql);

echo "<h2>Companies</h2>";
echo "<table border='1' cellpadding='8'>";
echo "<tr><th>Symbol</th><th>Name</th><th>Sector</th><th>Exchange</th></tr>";

foreach ($result as $row) {
    echo "<tr>";
    echo "<td>{$row['symbol']}</td>";
    echo "<td>{$row['name']}</td>";
    echo "<td>{$row['sector']}</td>";
    echo "<td>{$row['exchange']}</td>";
    echo "</tr>";
}
echo "</table>";
?>

