<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../index.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Prácticas - Nivel Intermedio</title>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      background: #eef2f3;
      padding: 40px;
    }
    h1 {
      text-align: center;
      color: #222;
    }
    a {
      display: inline-block;
      margin: 10px 0 30px 0;
      text-decoration: none;
      color: #007bff;
    }
    a:hover {
      text-decoration: underline;
    }
    .practica {
      background: #fff;
      padding: 25px;
      margin: 25px auto;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      max-width: 850px;
      transition: transform 0.2s ease;
    }
    .practica:hover {
      transform: scale(1.02);
    }
    textarea {
      width: 100%;
      height: 100px;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-family: monospace;
      font-size: 14px;
      margin-top: 10px;
    }
    button {
      margin-top: 10px;
      background: #007bff;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.2s ease;
    }
    button:hover { background: #0056b3; }
    .resultado {
      font-weight: bold;
      margin-top: 10px;
      text-align: center;
      font-size: 16px;
    }
  </style>
</head>
<body>
  <h1>💻 Prácticas - Curso SQL Intermedio</h1>
  <a href="../course.php">← Volver al curso</a>

  <?php
  // Lista de prácticas con sus consultas esperadas
  $practicas = [
    ["Cuenta cuántos empleados hay en la tabla <b>empleados</b>.", "SELECT COUNT(*) FROM empleados;"],
    ["Obtén el nombre y salario de los empleados con salario mayor a 3000.", "SELECT nombre, salario FROM empleados WHERE salario > 3000;"],
    ["Muestra el total de ventas agrupadas por año.", "SELECT YEAR(fecha_venta), SUM(total) FROM ventas GROUP BY YEAR(fecha_venta);"],
    ["Elimina la tabla temporal llamada <b>temp_datos</b>.", "DROP TABLE temp_datos;"],
    ["Obtén la cantidad de productos vendidos por categoría.", "SELECT categoria, COUNT(*) FROM productos GROUP BY categoria;"],
    ["Muestra los clientes cuyo nombre empiece con la letra 'A'.", "SELECT * FROM clientes WHERE nombre LIKE 'A%';"],
    ["Calcula el salario promedio por departamento.", "SELECT departamento_id, AVG(salario) FROM empleados GROUP BY departamento_id;"],
    ["Muestra las ventas realizadas después del 1 de enero de 2024.", "SELECT * FROM ventas WHERE fecha_venta > '2024-01-01';"],
    ["Muestra los empleados que pertenecen a los departamentos de Finanzas o Marketing.", "SELECT * FROM empleados WHERE departamento IN ('Finanzas', 'Marketing');"],
    ["Elimina todos los registros de la tabla <b>logs</b>.", "DELETE FROM logs;"]
  ];

  // Validar respuesta (si se envía)
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $respuesta = trim($_POST["respuesta"]);
    $correcta = trim($_POST["correcta"]);

    if (strcasecmp($respuesta, $correcta) === 0) {
      echo "<div class='resultado' style='color:green;'>✅ ¡Correcto! La consulta SQL es válida.</div>";
    } else {
      echo "<div class='resultado' style='color:red;'>❌ Incorrecto. Revisa la sintaxis o mayúsculas.</div>";
    }
  }
  ?>

  <?php foreach ($practicas as $i => $p): ?>
    <div class="practica">
      <h3>Práctica <?= $i + 1 ?>:</h3>
      <p><?= $p[0] ?></p>
      <form method="post">
        <textarea name="respuesta" placeholder="Escribe aquí tu comando SQL..."></textarea>
        <input type="hidden" name="correcta" value="<?= htmlspecialchars($p[1]) ?>">
        <button type="submit">Validar respuesta</button>
      </form>
    </div>
  <?php endforeach; ?>

  <script>
    // Efecto visual opcional al enviar formularios
    const forms = document.querySelectorAll("form");
    forms.forEach(f => {
      f.addEventListener("submit", () => {
        f.querySelector("button").textContent = "Validando...";
        f.querySelector("button").disabled = true;
      });
    });
  </script>
</body>
</html>
