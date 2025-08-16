<?php
session_start();
include '../database.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

$users = $conn->query("SELECT * FROM users");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Users</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="page-wrapper">
  <div class="admin-container">
    <h2>Users</h2>
    <table class="admin-table">
      <tr>
        <th>ID</th><th>Name</th><th>Email</th><th>Role</th>
      </tr>
      <?php while($u = $users->fetch_assoc()): ?>
      <tr>
        <td><?= $u['id'] ?></td>
        <td><?= htmlspecialchars($u['name']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td>
          <form method="POST" action="update_user.php">
            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
            <select name="role" onchange="this.form.submit()">
              <option <?= $u['role']=='user'?'selected':'' ?>>user</option>
              <option <?= $u['role']=='admin'?'selected':'' ?>>admin</option>
            </select>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</div>
</body>
</html>
