<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../index.php");
include '../../db.php';

// Respuestas correctas
$respuestas_correctas = [
    'q1' => 'Agrupa filas que tienen valores iguales en columnas especificadas',
    'q2' => 'COUNT()',
    'q3' => 'UPDATE',
    'q4' => 'Filtrar resultados después de aplicar GROUP BY',
    'q5' => 'DROP TABLE',
    'q6' => 'INNER JOIN',
    'q7' => 'Crea una vista virtual basada en una consulta',
    'q8' => 'COMMIT'
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

// Guardar resultado en BD
$stmt = $conn->prepare("INSERT INTO exam_results (user_id, nivel, nota, fecha) VALUES (?, 'Intermedio', ?, NOW())");
$stmt->bind_param("id", $user_id, $nota);
$stmt->execute();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultado - Nivel Intermedio</title>
  <style>
    body { font-family: Arial; background: #f0f2f5; padding: 40px; text-align: center; }
    .resultado {
      background: white;
      padding: 40px;
      border-radius: 12px;
      display: inline-block;
      box-shadow: 0 3px 12px rgba(0,0,0,0.15);
      max-width: 500px;
    }
    .nota {
      font-size: 36px;
      font-weight: bold;
      color: <?= ($nota >= 10 ? '#28a745' : '#dc3545') ?>;
      margin-top: 25px;
    }
    .mensaje {
      margin-top: 10px;
      font-size: 18px;
      color: #555;
    }
    a {
      display: inline-block;
      margin-top: 25px;
      text-decoration: none;
      color: #007bff;
      font-weight: bold;
    }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <div class="resultado">
    <h1>Resultado del Examen - Nivel Intermedio</h1>
    <p>Has respondido correctamente <b><?= $puntos ?></b> de <b><?= $total ?></b> preguntas.</p>
    <p class="nota"><?= $nota ?> / 20</p>
    <p class="mensaje">
      <?= ($nota >= 10)
        ? "🎉 ¡Excelente trabajo! Has aprobado el nivel intermedio."
        : "📘 Puedes volver a repasar el contenido y volver a intentarlo." ?>
    </p>
    <a href="../course.php">← Volver al Curso</a>
  </div>
</body>
</html>
