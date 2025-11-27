<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../index.php");
include '../../db.php';

// Claves correctas
$respuestas_correctas = [
  'q1' => 'SELECT',
  'q2' => 'WHERE',
  'q3' => 'ORDER BY',
  'q4' => 'COUNT()',
  'q5' => 'DELETE',
  'q6' => 'CREATE TABLE',
  'q7' => 'DISTINCT',
  'q8' => 'JOIN',
  'q9' => 'AVG()',
  'q10' => 'INSERT INTO'
];

$puntos = 0;
$total = count($respuestas_correctas);

// Calcular aciertos
foreach ($respuestas_correctas as $pregunta => $correcta) {
  if (isset($_POST[$pregunta]) && $_POST[$pregunta] === $correcta) {
    $puntos++;
  }
}

$nota = round(($puntos / $total) * 20, 2);
$user_id = $_SESSION['user_id'];

// Guardar resultado (opcional)
$stmt = $conn->prepare("INSERT INTO exam_results (user_id, nivel, nota, fecha) VALUES (?, 'Básico', ?, NOW())");
$stmt->bind_param("id", $user_id, $nota);
$stmt->execute();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultado del examen - Nivel Básico</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f8;
      text-align: center;
      padding: 40px;
    }
    .resultado {
      background: white;
      border-radius: 12px;
      padding: 30px;
      display: inline-block;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .nota {
      font-size: 36px;
      font-weight: bold;
      color: <?= ($nota >= 10 ? 'green' : 'red') ?>;
    }
    a {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: #004aad;
      font-weight: bold;
    }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <div class="resultado">
    <h1>Resultado del Examen - Nivel Básico</h1>
    <p>Has respondido correctamente <b><?= $puntos ?></b> de <b><?= $total ?></b> preguntas.</p>
    <p class="nota">Tu nota final: <?= $nota ?> / 20</p>

    <?php if ($nota >= 10): ?>
      <p>🎉 ¡Felicidades! Has aprobado el examen básico.</p>
    <?php else: ?>
      <p>😔 No alcanzaste la nota mínima. Intenta nuevamente.</p>
    <?php endif; ?>

    <a href="../course.php">← Volver al Curso</a>
  </div>
</body>
</html>
