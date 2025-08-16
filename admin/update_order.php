<?php
session_start();
include '../database.php';
if ($_SESSION['user']['role'] !== 'admin') exit;

$orderId = $_POST['order_id'];
$status = $_POST['status'];

$stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
$stmt->bind_param("si", $status, $orderId);
$stmt->execute();

header("Location: orders.php");
