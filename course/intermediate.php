<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../index.php");
include '../db.php';

$modules = $conn->query("SELECT * FROM courses WHERE level='Intermedio'");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Curso Intermedio de SQL</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
  <h1>Curso Intermedio de SQL</h1>
  <a href="../dashboard.php">← Volver al Panel</a>

  <?php while ($m = $modules->fetch_assoc()): ?>
    <div class="post">
      <h3><?= $m['module_name'] ?></h3>
      <p><b>Teoría:</b> <?= $m['theory'] ?></p>
      <p><b>Práctica:</b> <?= $m['practice_question'] ?></p>

      <form method="post" action="../practice/validate.php">
        <input type="hidden" name="expected" value="<?= $m['expected_query'] ?>">
        <textarea name="answer" placeholder="Escribe tu consulta SQL aquí..." required></textarea>
        <button type="submit">Validar respuesta</button>
      </form>
    </div>
  <?php endwhile; ?>

</body>
</html>
