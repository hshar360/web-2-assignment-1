<?php
include('config.inc.php');

$sql = "SELECT name FROM sqlite_master WHERE type='table'";
$result = $pdo->query($sql);

echo "<h3>Tables in this database:</h3>";
foreach ($result as $row) {
    echo $row['name'] . "<br>";
}
?>
