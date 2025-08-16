<?php
session_start();
include '../database.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

$orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Orders</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="page-wrapper">
  <div class="admin-container">
    <h2>Orders</h2>
    <table class="admin-table">
      <tr>
        <th>ID</th><th>User ID</th><th>Total</th><th>Status</th><th>Date</th>
      </tr>
      <?php while($o = $orders->fetch_assoc()): ?>
      <tr>
        <td><?= $o['id'] ?></td>
        <td><?= $o['user_id'] ?></td>
        <td>$<?= $o['total_price'] ?></td>
        <td>
          <form method="POST" action="update_order.php">
            <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
            <select name="status" onchange="this.form.submit()">
              <option <?= $o['status']=='Pending'?'selected':'' ?>>Pending</option>
              <option <?= $o['status']=='Shipped'?'selected':'' ?>>Shipped</option>
              <option <?= $o['status']=='Completed'?'selected':'' ?>>Completed</option>
              <option <?= $o['status']=='Cancelled'?'selected':'' ?>>Cancelled</option>
            </select>
          </form>
        </td>
        <td><?= $o['created_at'] ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</div>
</body>
</html>
