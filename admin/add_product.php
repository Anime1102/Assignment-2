<?php
session_start();
include '../database.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $image_url = $_POST['image_url'];

  $stmt = $conn->prepare("INSERT INTO products (name, price, image_url) VALUES (?, ?, ?)");
  $stmt->bind_param("sds", $name, $price, $image_url);
  $stmt->execute();
  header("Location: products.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Product</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="page-wrapper">
  <div class="auth-form">
    <h2>Add Product</h2>
    <form method="POST">
      <input type="text" name="name" placeholder="Product Name" required>
      <input type="number" step="0.01" name="price" placeholder="Price" required>
      <input type="text" name="image_url" placeholder="Image URL" required>
      <button type="submit">Save</button>
    </form>
    <p><a href="products.php">Back to Products</a></p>
  </div>
</div>
</body>
</html>
