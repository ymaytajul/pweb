<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../index.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Práctica - Nivel Básico</title>
  <link rel="stylesheet" href="../../assets/style.css">
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; background: #f4f6f8; color: #333; }
    h1 { color: #004aad; }
    .card {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      margin: 15px 0;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    textarea {
      width: 100%;
      height: 80px;
      margin-top: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      padding: 8px;
      font-family: monospace;
    }
    button {
      background: #004aad;
      color: white;
      border: none;
      border-radius: 8px;
      padding: 8px 16px;
      cursor: pointer;
      margin-top: 8px;
    }
    button:hover { background: #00357a; }
    a { text-decoration: none; color: #004aad; }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <h1>💻 Prácticas de SQL - Nivel Básico</h1>
  <a href="../course.php">← Volver al curso</a>

  <p>Escribe las consultas SQL correctas para cada caso y presiona <b>“Validar respuesta”</b> para comprobarlas.</p>

  <?php
  $practicas = [
    ["SELECT * FROM empleados;", "Selecciona todos los empleados."],
    ["SELECT nombre FROM empleados WHERE salario > 2000;", "Muestra los empleados con salario mayor a 2000."],
    ["SELECT COUNT(*) FROM clientes;", "Cuenta el número total de clientes."],
    ["SELECT nombre, edad FROM estudiantes WHERE edad >= 18;", "Selecciona los estudiantes mayores o iguales a 18 años."],
    ["SELECT DISTINCT ciudad FROM proveedores;", "Muestra las ciudades sin repetir donde hay proveedores."],
    ["SELECT nombre, salario FROM empleados ORDER BY salario DESC;", "Lista los empleados ordenados por salario de mayor a menor."],
    ["SELECT nombre FROM productos WHERE precio BETWEEN 10 AND 50;", "Selecciona los productos cuyo precio está entre 10 y 50."],
    ["SELECT nombre FROM clientes WHERE nombre LIKE 'A%';", "Muestra los clientes cuyos nombres comienzan con la letra A."],
    ["SELECT AVG(edad) FROM usuarios;", "Calcula la edad promedio de todos los usuarios."],
    ["SELECT MAX(precio) FROM productos;", "Muestra el precio más alto entre los productos."]
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
