<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../index.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Prácticas - Nivel Avanzado</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f4f9;
      padding: 40px;
    }
    h1 {
      text-align: center;
      color: #333;
    }
    a {
      text-decoration: none;
      color: #007bff;
    }
    a:hover { text-decoration: underline; }
    .card {
      background: white;
      padding: 20px;
      margin: 15px auto;
      border-radius: 10px;
      max-width: 800px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    textarea {
      width: 100%;
      height: 100px;
      margin-top: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      padding: 10px;
      font-family: monospace;
    }
    button {
      background: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 10px;
    }
    button:hover { background: #0056b3; }
  </style>
</head>
<body>
  <h1>Prácticas de SQL - Nivel Avanzado</h1>
  <a href="../course.php">← Volver al curso</a>

  <?php
  $practicas = [
    [
      "SELECT nombre FROM empleados WHERE salario > (SELECT AVG(salario) FROM empleados);",
      "Selecciona los empleados cuyo salario es mayor al salario promedio."
    ],
    [
      "SELECT d.nombre AS departamento, COUNT(e.id) AS total_empleados FROM empleados e INNER JOIN departamentos d ON e.dep_id = d.id GROUP BY d.nombre;",
      "Muestra el nombre de cada departamento y cuántos empleados tiene."
    ],
    [
      "CREATE VIEW vista_empleados_activos AS SELECT nombre, puesto FROM empleados WHERE estado = 'ACTIVO';",
      "Crea una vista llamada <code>vista_empleados_activos</code> con el nombre y puesto de empleados activos."
    ],
    [
      "START TRANSACTION; UPDATE cuentas SET saldo = saldo - 100 WHERE id = 1; UPDATE cuentas SET saldo = saldo + 100 WHERE id = 2; COMMIT;",
      "Crea una transacción que transfiera 100 unidades de la cuenta 1 a la cuenta 2."
    ],
    [
      "SELECT nombre, salario, RANK() OVER (ORDER BY salario DESC) AS posicion FROM empleados;",
      "Usa una función de ventana para mostrar el salario y su posición en el ranking de empleados."
    ],
    [
      "CREATE INDEX idx_empleado_nombre ON empleados(nombre);",
      "Crea un índice sobre la columna <code>nombre</code> de la tabla empleados."
    ],
    [
      "SELECT nombre FROM empleados WHERE salario BETWEEN 3000 AND 5000;",
      "Selecciona los empleados cuyo salario esté entre 3000 y 5000."
    ],
    [
      "SELECT departamento, SUM(salario) FROM empleados GROUP BY departamento HAVING SUM(salario) > 20000;",
      "Muestra los departamentos cuya suma de salarios sea mayor a 20000."
    ],
    [
      "SELECT nombre FROM empleados e WHERE NOT EXISTS (SELECT * FROM proyectos p WHERE p.emp_id = e.id);",
      "Muestra los empleados que no están asignados a ningún proyecto."
    ],
    [
      "SELECT dep_id, AVG(salario) AS promedio FROM empleados GROUP BY dep_id ORDER BY promedio DESC LIMIT 1;",
      "Muestra el departamento con el salario promedio más alto."
    ]
  ];

  foreach ($practicas as $i => $p): ?>
    <div class="card">
      <b>Práctica <?= $i+1 ?>:</b> <?= $p[1] ?><br>
      <form method="post" action="../../practice/validate.php">
        <input type="hidden" name="expected" value="<?= htmlspecialchars($p[0]) ?>">
        <textarea name="answer" placeholder="Escribe tu consulta SQL aquí..." required></textarea><br>
        <button type="submit">Validar respuesta</button>
      </form>
    </div>
  <?php endforeach; ?>
</body>
</html>
