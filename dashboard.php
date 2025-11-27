<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: index.php");
include 'db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Principal - SQL Learning</title>
  <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        background: #f5f5f5;
        padding: 20px;
        color: #333;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: #2575fc;
    }

    nav {
        text-align: center;
        margin-bottom: 30px;
    }

    nav a {
        display: inline-block;
        margin: 0 8px;
        padding: 10px 18px;
        background: linear-gradient(135deg, #ff416c, #ff4b2b);
        color: white;
        font-weight: bold;
        text-decoration: none;
        border-radius: 25px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    nav a:hover {
        background: linear-gradient(135deg, #ff4b2b, #ff416c);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    form textarea {
        width: 100%;
        min-height: 80px;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        resize: vertical;
        margin-bottom: 10px;
        font-size: 14px;
    }

    form input[type="file"] {
        margin-top: 10px;
    }

    form button {
        padding: 8px 12px;
        border: none;
        border-radius: 8px;
        background-color: #2575fc;
        color: white;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 10px;
    }

    form button:hover {
        background-color: #1a5edb;
    }

    .post {
        background: white;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .post b {
        color: #2575fc;
    }

    .post small {
        color: #999;
        font-size: 12px;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></h1>

    <nav>
      <a href="course/course.php">Cursos por niveles</a>
      <a href="retos.php">Retos</a>
            <a href="ranking.php">Ranking</a>
      <a href="books.php">Biblioteca</a>
      <a href="profile/index.php">Perfil</a>
      <a href="logout.php">Cerrar</a>


    </nav>


<!-- ================== PROGRESO ================== -->
<h2>📊 Progreso general</h2>
<?php
$user_id = $_SESSION['user_id'];

$total_cursos = $conn->query("SELECT COUNT(*) as total FROM courses")->fetch_assoc()['total'];
$total_score = $conn->query("SELECT SUM(score) as user_total FROM user_progress WHERE user_id=$user_id")
    ->fetch_assoc()['user_total'] ?? 0;

if($total_score == 0){
    $total_score = rand(10,50);
}

$porcentaje = round(($total_score / ($total_cursos * 100)) * 100);
$porcentaje = min($porcentaje, 100);
?>

<div style="background:#e0e0e0; border-radius:25px; width:100%; height:30px; overflow:hidden; margin-bottom:20px;">
    <div style="width:<?= $porcentaje ?>%; background: linear-gradient(135deg, #ff416c, #ff4b2b); height:100%; text-align:right; line-height:30px; color:white; padding-right:10px; font-weight:bold;">
        <?= $porcentaje ?>%
    </div>
</div>


<!-- ================== FORMULARIO SIMPLE ================== -->

<h2>Foro de Posts</h2>

<style>
.editor-box {
    border: 1px solid #bbb;
    border-radius: 8px;
    padding: 10px;
    background: white;
    min-height: 120px;
}
.editor-toolbar button {
    margin-right: 5px;
    padding: 5px 10px;
    background: #2575fc;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
.editor-toolbar button:hover {
    background: #1a5edb;
}
</style>
<br>

<!-- Botones básicos -->
<div class="editor-toolbar">
    <button type="button" onclick="formatText('bold')"><b>B</b></button>
    <button type="button" onclick="formatText('italic')"><i>I</i></button>
    <button type="button" onclick="formatText('underline')"><u>U</u></button>
</div>
<br>

<!-- Editor visual -->
<div id="editor" class="editor-box" contenteditable="true"></div>

<form id="postForm" method="post" action="posts/add_post.php" enctype="multipart/form-data">
    
    <!-- CONTENIDO REAL QUE SE ENVÍA -->
    <textarea id="contentArea" name="content" style="display:none;"></textarea>

    <input type="file" name="image" accept="image/*">

    <button type="submit">Publicar</button>
</form><br>


<script>
function formatText(cmd) {
    document.execCommand(cmd, false, null);
}

document.getElementById("postForm").addEventListener("submit", function(e) {
    let html = document.getElementById("editor").innerHTML.trim();

    // Copiar el HTML al textarea
    document.getElementById("contentArea").value = html;

    // Evitar error "campo vacío"
    if (html.length === 0 || html === "<br>") {
        e.preventDefault();
        alert("Escribe algo antes de publicar.");
    }
});
</script>


<!-- ================== MOSTRAR POSTS ================== -->
<?php
$query = $conn->query("
    SELECT p.*, u.username 
    FROM posts p 
    JOIN users u ON p.user_id = u.id
    ORDER BY p.created_at DESC
");

while($p = $query->fetch_assoc()){

    $content = nl2br(htmlspecialchars($p['content']));

   $content = $p['content'];

echo "<div class='post'>";
echo "<b><a href='view_profile.php?id=" . $p['user_id'] . "' 
style='color:#2575fc; text-decoration:none;'>"
. htmlspecialchars($p['username']) . 
"</a></b><br>";



// Mostrar el contenido con HTML habilitado:
echo "<div style='margin-top:5px;'>$content</div>";

if (!empty($p['image_path'])) {
    echo "<div><img src='".htmlspecialchars($p['image_path'])."' 
    style='max-width:100%; margin-top:10px; border-radius:8px;'></div>";
}

echo "<br><br><a href='posts/reply_form.php?post_id=" . $p['id'] . "' 
style='color:#ff416c; font-weight:bold; text-decoration:none;'>Responder</a>";

echo "</div>";

// Mostrar las respuestas del post
$rep = $conn->query("
    SELECT r.*, u.username 
    FROM replies r
    JOIN users u ON r.user_id = u.id
    WHERE r.post_id=" . $p['id'] . "
    ORDER BY r.created_at ASC
");

echo "<div style='margin-left:25px; margin-top:10px;'>";

while($r = $rep->fetch_assoc()) {
    echo "
    <div style='background:#f9f9f9; border-left:3px solid #2575fc; padding:10px; border-radius:6px; margin-bottom:8px;'>
        <b style='color:#2575fc;'>" . htmlspecialchars($r['username']) . "</b><br>
        " . htmlspecialchars($r['content']) . "<br>
        <small>" . $r['created_at'] . "</small>
    </div>";
}

echo "</div>";
echo "
<form action='posts/reply.php' method='POST' style='margin-top:10px; margin-left:20px;'>
    <input type='hidden' name='post_id' value='" . $p['id'] . "'>
    <textarea name='content' placeholder='Escribe una respuesta...' required
        style='width:95%; height:60px; border-radius:8px; padding:8px; margin-bottom:5px;'></textarea>
    <br>
    <button type='submit' 
        style='padding:6px 12px; border:none; border-radius:8px; background:#2575fc; color:white; cursor:pointer;'>
        Enviar
    </button>
</form><br>

"; 

}
?>
  </div>
</body>
</html>
