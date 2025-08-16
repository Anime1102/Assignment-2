<?php
session_start();
include '../database.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

$id = $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $image_url = $_POST['image_url'];

  $stmt = $conn->prepare("UPDATE products SET name=?, price=?, image_url=? WHERE id=?");
  $stmt->bind_param("sdsi", $name, $price, $image_url, $id);
  $stmt->execute();
  header("Location: products.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Product</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="page-wrapper">
  <div class="auth-form">
    <h2>Edit Product</h2>
    <form method="POST">
      <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
      <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
      <input type="text" name="image_url" value="<?= htmlspecialchars($product['image_url']) ?>" required>
      <button type="submit">Update</button>
    </form>
    <p><a href="products.php">Back to Products</a></p>
  </div>
</div>
</body>
</html>
