<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../index.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cursos de SQL</title>
  <link rel="stylesheet" href="../assets/style.css">
  <style>
    body { font-family: Arial; background: #f5f5f5; padding: 20px; }
    h1 { text-align: center; }
    .nivel-container { 
      display: flex; 
      flex-wrap: wrap;
      justify-content: space-around; 
      margin-top: 40px; 
    }
    .nivel { 
      background: white; 
      padding: 20px; 
      width: 30%; 
      border-radius: 10px; 
      box-shadow: 0 0 10px #ccc; 
      margin-bottom: 20px;
    }
    .nivel h2 { text-align: center; }
    .seccion { margin-top: 15px; text-align: center; }
    a.boton { 
      display: inline-block; 
      background: #007bff; 
      color: white; 
      padding: 10px 15px; 
      border-radius: 5px; 
      text-decoration: none; 
      margin: 5px; 
      transition: background 0.3s;
    }
    a.boton:hover { background: #0056b3; }
  </style>
</head>
<body>
  <h1>Curso de SQL</h1>
  <a href="../dashboard.php">← Volver al Panel</a>

  <div class="nivel-container">
    <!-- Nivel Básico -->
    <div class="nivel">
      <h2>Nivel Básico</h2>
      <div class="seccion">
        <a href="basico/lectura.php" class="boton">📘 Lectura</a>
        <a href="basico/practica.php" class="boton">💻 Práctica</a>
        <a href="basico/preguntas.php" class="boton">📝 Preguntas</a>
      </div>
    </div>

    <!-- Nivel Intermedio -->
    <div class="nivel">
      <h2>Nivel Intermedio</h2>
      <div class="seccion">
        <a href="intermedio/lectura.php" class="boton">📘 Lectura</a>
        <a href="intermedio/practica.php" class="boton">💻 Práctica</a>
        <a href="intermedio/preguntas.php" class="boton">📝 Preguntas</a>
      </div>
    </div>

    <!-- Nivel Avanzado -->
    <div class="nivel">
      <h2>Nivel Avanzado</h2>
      <div class="seccion">
        <a href="avanzado/lectura.php" class="boton">📘 Lectura</a>
        <a href="avanzado/practica.php" class="boton">💻 Práctica</a>
        <a href="avanzado/preguntas.php" class="boton">📝 Preguntas</a>
        <div class="seccion" style="text-align:center;margin-top:30px;">
  <a href="certificado.php" class="boton">🎓 Descargar Certificado</a>
</div>

      </div>
    </div>
  </div>
</body>
</html>
