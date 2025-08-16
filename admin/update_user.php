<?php
session_start();
include '../database.php';
if ($_SESSION['user']['role'] !== 'admin') exit;

$userId = $_POST['user_id'];
$role = $_POST['role'];

$stmt = $conn->prepare("UPDATE users SET role=? WHERE id=?");
$stmt->bind_param("si", $role, $userId);
$stmt->execute();

header("Location: users.php");
