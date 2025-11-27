<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../index.php");
include '../../db.php';

// Respuestas correctas
$respuestas_correctas = [
  'q1' => 'Permite realizar cálculos sobre un conjunto de filas relacionadas sin agrupar',
  'q2' => 'WHERE filtra antes de agrupar y HAVING después de agrupar',
  'q3' => 'START TRANSACTION',
  'q4' => 'Para acelerar las búsquedas y consultas sobre columnas específicas',
  'q5' => 'Crea una tabla virtual basada en una consulta',
  'q6' => 'ROLLBACK',
  'q7' => 'Hace referencia a columnas de la consulta principal',
  'q8' => 'Elimina un índice existente en una tabla',
  'q9' => 'LIMIT',
  'q10' => 'Simplifican consultas complejas y mejoran la seguridad'
];

$puntos = 0;
$total = count($respuestas_correctas);

foreach ($respuestas_correctas as $pregunta => $correcta) {
  if (isset($_POST[$pregunta]) && $_POST[$pregunta] === $correcta) {
    $puntos++;
  }
}

$nota = round(($puntos / $total) * 20, 2);
$user_id = $_SESSION['user_id'];

// Guardar resultado
$stmt = $conn->prepare("INSERT INTO exam_results (user_id, nivel, nota, fecha) VALUES (?, 'Avanzado', ?, NOW())");
$stmt->bind_param("id", $user_id, $nota);
$stmt->execute();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultado - Nivel Avanzado</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f9;
      text-align: center;
      padding: 50px;
    }
    .resultado {
      background: white;
      padding: 30px;
      border-radius: 10px;
      display: inline-block;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .nota {
      font-size: 32px;
      color: <?= ($nota >= 10 ? 'green' : 'red') ?>;
    }
  </style>
</head>
<body>
  <div class="resultado">
    <h1>Resultado del Examen - Nivel Avanzado</h1>
    <p>Respuestas correctas: <?= $puntos ?> / <?= $total ?></p>
    <p class="nota">Nota final: <b><?= $nota ?></b> / 20</p>
    <br>
    <a href="../course.php">← Volver al curso</a>
  </div>
</body>
</html>
