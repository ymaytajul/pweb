<?php
include '../config.php';
session_start();

$post_id = $_GET['post_id'];
$user_id = $_SESSION['user_id'] ?? 1; // por simplicidad

// Agregar nuevo comentario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_comment'])) {
    $comment = trim($_POST['comment']);
    if ($comment != '') {
        $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $post_id, $user_id, $comment);
        $stmt->execute();
    }
}

// Editar comentario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_comment'])) {
    $comment_id = $_POST['comment_id'];
    $new_comment = trim($_POST['new_comment']);
    if ($new_comment != '') {
        $stmt = $conn->prepare("UPDATE comments SET comment=? WHERE id=? AND user_id=?");
        $stmt->bind_param("sii", $new_comment, $comment_id, $user_id);
        $stmt->execute();
    }
}

// Eliminar comentario
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM comments WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $delete_id, $user_id);
    $stmt->execute();
}

// Mostrar comentarios
$stmt = $conn->prepare("SELECT c.id, c.comment, c.created_at, u.username 
                        FROM comments c 
                        JOIN users u ON c.user_id = u.id 
                        WHERE c.post_id=? ORDER BY c.created_at DESC");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Comentarios</title>
    <style>
        body { font-family: Arial; margin: 30px; }
        .comment-box { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; }
        .actions a { margin-right: 10px; text-decoration: none; color: #007bff; }
        .actions a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<h2>Comentarios</h2>

<form method="POST">
    <textarea name="comment" rows="3" cols="50" placeholder="Escribe un comentario..."></textarea><br>
    <button type="submit" name="add_comment">Comentar</button>
</form>

<hr>

<?php while ($row = $result->fetch_assoc()) { ?>
    <div class="comment-box">
        <p><strong><?php echo htmlspecialchars($row['username']); ?></strong>:</p>
        <p><?php echo nl2br(htmlspecialchars($row['comment'])); ?></p>
        <small><?php echo $row['created_at']; ?></small>

        <div class="actions">
            <a href="?post_id=<?php echo $post_id; ?>&edit=<?php echo $row['id']; ?>">✏️ Editar</a>
            <a href="?post_id=<?php echo $post_id; ?>&delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Eliminar este comentario?');">🗑️ Eliminar</a>
        </div>
    </div>

    <?php if (isset($_GET['edit']) && $_GET['edit'] == $row['id']) { ?>
        <form method="POST">
            <input type="hidden" name="comment_id" value="<?php echo $row['id']; ?>">
            <textarea name="new_comment" rows="3" cols="50"><?php echo htmlspecialchars($row['comment']); ?></textarea><br>
            <button type="submit" name="edit_comment">Guardar cambios</button>
        </form>
    <?php } ?>
<?php } ?>

</body>
</html>
