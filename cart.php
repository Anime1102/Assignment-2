<?php
session_start();
include 'database.php';

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Remove item
if (isset($_GET['remove'])) {
  $id = $_GET['remove'];
  unset($_SESSION['cart'][$id]);
  header("Location: cart.php");
  exit;
}

// Fetch product details for items in cart
$cartItems = [];
$total = 0;
if (!empty($_SESSION['cart'])) {
  $ids = implode(",", array_keys($_SESSION['cart']));
  $result = $conn->query("SELECT * FROM products WHERE id IN ($ids)");
  while($row = $result->fetch_assoc()) {
    $row['quantity'] = $_SESSION['cart'][$row['id']];
    $row['subtotal'] = $row['price'] * $row['quantity'];
    $total += $row['subtotal'];
    $cartItems[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cart</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="page-wrapper">
    <div class="cart-container">
      <h2>Your Cart</h2>
      <?php if(empty($cartItems)): ?>
        <p>Your cart is empty.</p>
      <?php else: ?>
        <?php foreach($cartItems as $item): ?>
          <div class="cart-item">
            <span><?= $item['name'] ?> (x<?= $item['quantity'] ?>)</span>
            <span>$<?= number_format($item['subtotal'], 2) ?></span>
            <a href="cart.php?remove=<?= $item['id'] ?>" style="color:red;">Remove</a>
          </div>
        <?php endforeach; ?>
        <div class="cart-total">Total: $<?= number_format($total, 2) ?></div>
        <div class="cart-actions">
          <a href="checkout.php">Proceed to Checkout</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
