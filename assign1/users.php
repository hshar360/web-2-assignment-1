<?php
include('includes/config.inc.php');

try {
    $sql = "SELECT * FROM users ORDER BY lastname";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Users</title>
    <link rel="stylesheet" href="css/assignment1.css">
</head>
<body>

<main class="container">
<h1>Users</h1>

<table>
  <tr><th>First Name</th><th>Last Name</th><th>Email</th><th>City</th></tr>
  
  <?php
    foreach ($users as $user) {
      echo '<tr>';
      echo '<td>' . $user['firstname'] . '</td>';
      echo '<td>' . $user['lastname'] . '</td>';
      echo '<td>' . $user['email'] . '</td>';
      echo '<td>' . $user['city'] . '</td>';
      echo '</tr>';
    }
  ?>

</table>

</main>
</body>
</html>
