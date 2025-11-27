<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../index.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lectura - Nivel Básico</title>
  <link rel="stylesheet" href="../../assets/style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
      line-height: 1.6;
      background-color: #f7f9fb;
    }
    .container {
      max-width: 900px;
      margin: auto;
      background: white;
      padding: 25px 40px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    h1, h2, h3 {
      color: #007bff;
    }
    pre {
      background: #f4f4f4;
      border-left: 4px solid #007bff;
      padding: 10px;
      overflow-x: auto;
      border-radius: 8px;
    }
    nav {
      margin-top: 15px;
      background: #e8f0ff;
      padding: 10px;
      border-radius: 10px;
    }
    a {
      color: #007bff;
      text-decoration: none;
    }
    a:hover { text-decoration: underline; }
    .chapter {
      display: none;
    }
    .active {
      display: block;
    }
    .buttons {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }
    button {
      background: #007bff;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 8px;
      cursor: pointer;
    }
    button:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Curso SQL - Nivel Básico 📘</h1>
    <a href="../course.php">← Volver</a>
    <hr>

    <nav>
      <b>Capítulos:</b>
      <a href="#" onclick="showChapter(0)">1. Introducción</a> |
      <a href="#" onclick="showChapter(1)">2. Conceptos SQL</a> |
      <a href="#" onclick="showChapter(2)">3. SELECT y FROM</a> |
      <a href="#" onclick="showChapter(3)">4. WHERE y operadores</a> |
      <a href="#" onclick="showChapter(4)">5. Funciones</a> |
      <a href="#" onclick="showChapter(5)">6. JOINS básicos</a>
    </nav>

    <div id="chapters">

      <!-- CAPÍTULO 1 -->
      <div class="chapter active">
        <h2>1️⃣ Introducción a las bases de datos</h2>
        <p>Una <b>base de datos</b> es un conjunto organizado de información estructurada. Permite almacenar, administrar y acceder a datos fácilmente. Los sistemas gestores de bases de datos (SGBD) como <b>MySQL</b>, <b>PostgreSQL</b> o <b>SQL Server</b> permiten crear, modificar y consultar información usando el lenguaje SQL.</p>
        <pre>
Ejemplo:
Clientes
+----+----------+----------------------+
| ID | Nombre   | Correo               |
+----+----------+----------------------+
| 1  | Ana      | ana@email.com        |
| 2  | Carlos   | carlos@email.com     |
+----+----------+----------------------+
        </pre>
      </div>

      <!-- CAPÍTULO 2 -->
      <div class="chapter">
        <h2>2️⃣ Conceptos básicos de SQL</h2>
        <p><b>SQL (Structured Query Language)</b> es el lenguaje utilizado para comunicarse con bases de datos. Permite realizar las siguientes operaciones:</p>
        <ul>
          <li><b>SELECT</b> – Consultar datos</li>
          <li><b>INSERT</b> – Insertar nuevos registros</li>
          <li><b>UPDATE</b> – Actualizar datos existentes</li>
          <li><b>DELETE</b> – Eliminar datos</li>
        </ul>
        <pre>
Ejemplo de consulta básica:
SELECT * FROM clientes;
        </pre>
      </div>

      <!-- CAPÍTULO 3 -->
      <div class="chapter">
        <h2>3️⃣ SELECT y FROM</h2>
        <p>La instrucción <b>SELECT</b> se usa para seleccionar columnas específicas de una tabla.</p>
        <pre>
-- Sintaxis:
SELECT columnas FROM tabla;

-- Ejemplo:
SELECT nombre, correo FROM clientes;
        </pre>
        <p>El asterisco (<code>*</code>) significa “todas las columnas”.</p>
        <pre>
SELECT * FROM clientes;
        </pre>
      </div>

      <!-- CAPÍTULO 4 -->
      <div class="chapter">
        <h2>4️⃣ WHERE y operadores lógicos</h2>
        <p>El comando <b>WHERE</b> permite filtrar los resultados según una condición.</p>
        <pre>
-- Ejemplo:
SELECT * FROM clientes WHERE id = 1;
        </pre>
        <p>También se pueden usar operadores lógicos como <code>AND</code>, <code>OR</code> y <code>NOT</code>:</p>
        <pre>
SELECT * FROM clientes WHERE nombre = 'Ana' OR nombre = 'Carlos';
        </pre>
      </div>

      <!-- CAPÍTULO 5 -->
      <div class="chapter">
        <h2>5️⃣ Funciones de agregación</h2>
        <p>Las funciones de agregación permiten realizar cálculos sobre grupos de datos:</p>
        <ul>
          <li><b>COUNT()</b> – Cuenta registros</li>
          <li><b>SUM()</b> – Suma valores</li>
          <li><b>AVG()</b> – Calcula el promedio</li>
          <li><b>MAX()</b> y <b>MIN()</b> – Encuentran el mayor y menor valor</li>
        </ul>
        <pre>
-- Ejemplo:
SELECT COUNT(*) FROM clientes;
SELECT AVG(edad) FROM empleados;
        </pre>
      </div>

      <!-- CAPÍTULO 6 -->
      <div class="chapter">
        <h2>6️⃣ JOINS básicos</h2>
        <p>Los <b>JOIN</b> se usan para combinar datos de varias tablas relacionadas. Por ejemplo, si tienes una tabla <code>clientes</code> y una tabla <code>pedidos</code>:</p>
        <pre>
-- Ejemplo INNER JOIN:
SELECT clientes.nombre, pedidos.fecha
FROM clientes
INNER JOIN pedidos ON clientes.id = pedidos.id_cliente;
        </pre>
        <p>Esto mostrará qué cliente hizo cada pedido.</p>
      </div>
    </div>

    <div class="buttons">
      <button onclick="prevChapter()">← Anterior</button>
      <button onclick="nextChapter()">Siguiente →</button>
    </div>
  </div>

  <script>
    let current = 0;
    const chapters = document.querySelectorAll(".chapter");

    function showChapter(i) {
      chapters[current].classList.remove("active");
      current = i;
      chapters[current].classList.add("active");
      window.scrollTo(0, 0);
    }

    function nextChapter() {
      if (current < chapters.length - 1) {
        showChapter(current + 1);
      }
    }

    function prevChapter() {
      if (current > 0) {
        showChapter(current - 1);
      }
    }
  </script>
</body>
</html>
