<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_SESSION['cart'])) {
    $userId = $_SESSION['user']['id'];
    $total = 0;

    // calculate total
    $ids = implode(",", array_keys($_SESSION['cart']));
    $result = $conn->query("SELECT * FROM products WHERE id IN ($ids)");
    while($row = $result->fetch_assoc()) {
      $total += $row['price'] * $_SESSION['cart'][$row['id']];
    }

    // insert into orders
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status, created_at) VALUES (?, ?, 'Pending', NOW())");
    $stmt->bind_param("id", $userId, $total);
    $stmt->execute();
    $orderId = $stmt->insert_id;

    // insert into order_items
    foreach($_SESSION['cart'] as $pid => $qty) {
      $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
      $stmt->bind_param("iii", $orderId, $pid, $qty);
      $stmt->execute();
    }

    // clear cart
    $_SESSION['cart'] = [];
    $success = "Order placed successfully!";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="page-wrapper">
    <div class="checkout-container">
      <h2>Checkout</h2>
      <?php if(isset($success)): ?>
        <p style="color:green; text-align:center;"><?= $success ?></p>
      <?php elseif(empty($_SESSION['cart'])): ?>
        <p style="text-align:center;">Your cart is empty.</p>
      <?php else: ?>
        <div class="checkout-summary">
          <h3>Order Summary</h3>
          <ul>
            <?php foreach($_SESSION['cart'] as $id => $qty): ?>
              <li>Product ID <?= $id ?> x <?= $qty ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <form method="POST">
          <button type="submit" class="checkout-btn">Place Order</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
