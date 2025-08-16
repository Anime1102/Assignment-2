<?php
session_start();
include '../database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

$products = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Products</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="page-wrapper">
  <div class="admin-container">
    <h2>Products</h2>
    <div class="admin-actions" style="text-align:right; margin-bottom:15px;">
      <a href="add_product.php" class="add">+ Add Product</a>
    </div>
    <table class="admin-table">
      <tr>
        <th>ID</th><th>Name</th><th>Price</th><th>Image</th><th>Actions</th>
      </tr>
      <?php while($p = $products->fetch_assoc()): ?>
      <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td>$<?= $p['price'] ?></td>
        <td><img src="../<?= $p['image_url'] ?>" width="80"></td>
        <td class="admin-actions">
          <a href="edit_product.php?id=<?= $p['id'] ?>" class="edit">Edit</a>
          <a href="delete_product.php?id=<?= $p['id'] ?>" class="delete" onclick="return confirm('Delete this product?')">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</div>
</body>
</html>
