<?php
include('includes/config.inc.php');

$sql = "PRAGMA table_info(users)";
foreach ($pdo->query($sql) as $row) {
    echo $row['name'] . "<br>";
}
?>
