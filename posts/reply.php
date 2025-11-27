<?php
session_start();
include '../db.php';
if (!isset($_SESSION['user_id'])) die("Acceso denegado");

$content = $_POST['content'];
$post_id = $_POST['post_id'];
$user_id = $_SESSION['user_id'];

$conn->query("INSERT INTO replies (post_id, user_id, content) VALUES ($post_id, $user_id, '$content')");
header("Location: ../dashboard.php");
?>
