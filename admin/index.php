<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="page-wrapper">
  <div class="admin-container">
    <h2>Admin Dashboard</h2>
    <div class="admin-actions">
      <a href="products.php" class="add">Manage Products</a>
      <a href="orders.php" class="add">Manage Orders</a>
      <a href="users.php" class="add">Manage Users</a>
    </div>
  </div>
</div>
</body>
</html>
