<?php
session_start();
$id = $_POST['product_id'];

if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = []; }
$_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;

header("Location: cart.php");
