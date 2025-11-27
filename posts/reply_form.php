<?php
session_start();
if (!isset($_SESSION['user_id'])) die("Acceso denegado");
include '../db.php';

$post_id = intval($_GET['post_id']);
$post = $conn->query("SELECT content FROM posts WHERE id=$post_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Responder post</title>
</head>
<body>

<h2>Responder al post:</h2>
<div style="padding:10px; background:#eee; border-radius:8px; margin-bottom:20px;">
    <?= $post['content'] ?>
</div>

<form action="reply.php" method="POST">
    <input type="hidden" name="post_id" value="<?= $post_id ?>">
    <textarea name="content" required style="width:100%; height:120px;"></textarea><br><br>
    <button type="submit">Enviar respuesta</button>
</form>

</body>
</html>
