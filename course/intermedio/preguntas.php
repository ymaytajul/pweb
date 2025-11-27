<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../index.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Examen - Nivel Intermedio</title>
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
    form {
      background: #fff;
      padding: 30px;
      max-width: 850px;
      margin: 30px auto;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    .pregunta {
      margin-bottom: 25px;
      background: #fafafa;
      padding: 15px;
      border-radius: 8px;
      border-left: 5px solid #007bff;
    }
    p {
      margin: 0 0 10px;
      font-weight: bold;
    }
    label {
      display: block;
      margin-bottom: 5px;
      cursor: pointer;
    }
    input[type="radio"] {
      margin-right: 8px;
    }
    button {
      background: #007bff;
      color: white;
      padding: 12px 25px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      display: block;
      margin: 30px auto 0;
      font-size: 16px;
      transition: background 0.2s ease;
    }
    button:hover { background: #0056b3; }
    a {
      display: block;
      margin: 10px auto;
      text-align: center;
      text-decoration: none;
      color: #007bff;
    }
  </style>
</head>
<body>
  <h1>🧠 Examen de SQL - Nivel Intermedio</h1>
  <form method="post" action="resultado.php">

    <div class="pregunta">
      <p>1️⃣ ¿Qué hace la cláusula <code>GROUP BY</code> en SQL?</p>
      <label><input type="radio" name="q1" value="Agrupa filas que tienen valores iguales en columnas especificadas" required> Agrupa filas que tienen valores iguales en columnas especificadas</label>
      <label><input type="radio" name="q1" value="Elimina duplicados de una tabla"> Elimina duplicados de una tabla</label>
      <label><input type="radio" name="q1" value="Ordena las filas en orden ascendente"> Ordena las filas en orden ascendente</label>
    </div>

    <div class="pregunta">
      <p>2️⃣ ¿Cuál es la función que devuelve el número total de filas?</p>
      <label><input type="radio" name="q2" value="COUNT()" required> COUNT()</label>
      <label><input type="radio" name="q2" value="SUM()"> SUM()</label>
      <label><input type="radio" name="q2" value="TOTAL()"> TOTAL()</label>
    </div>

    <div class="pregunta">
      <p>3️⃣ ¿Qué comando se utiliza para actualizar datos existentes en una tabla?</p>
      <label><input type="radio" name="q3" value="UPDATE" required> UPDATE</label>
      <label><input type="radio" name="q3" value="INSERT INTO"> INSERT INTO</label>
      <label><input type="radio" name="q3" value="MODIFY"> MODIFY</label>
    </div>

    <div class="pregunta">
      <p>4️⃣ ¿Cuál es el propósito de la cláusula <code>HAVING</code>?</p>
      <label><input type="radio" name="q4" value="Filtrar resultados después de aplicar GROUP BY" required> Filtrar resultados después de aplicar GROUP BY</label>
      <label><input type="radio" name="q4" value="Renombrar columnas"> Renombrar columnas</label>
      <label><input type="radio" name="q4" value="Agregar nuevas filas"> Agregar nuevas filas</label>
    </div>

    <div class="pregunta">
      <p>5️⃣ ¿Qué comando elimina una tabla completa junto con sus datos?</p>
      <label><input type="radio" name="q5" value="DROP TABLE" required> DROP TABLE</label>
      <label><input type="radio" name="q5" value="DELETE *"> DELETE *</label>
      <label><input type="radio" name="q5" value="REMOVE"> REMOVE</label>
    </div>

    <div class="pregunta">
      <p>6️⃣ ¿Cuál de los siguientes es un tipo de JOIN en SQL?</p>
      <label><input type="radio" name="q6" value="INNER JOIN" required> INNER JOIN</label>
      <label><input type="radio" name="q6" value="LINK JOIN"> LINK JOIN</label>
      <label><input type="radio" name="q6" value="COMBINE JOIN"> COMBINE JOIN</label>
    </div>

    <div class="pregunta">
      <p>7️⃣ ¿Qué hace la instrucción <code>CREATE VIEW</code>?</p>
      <label><input type="radio" name="q7" value="Crea una vista virtual basada en una consulta" required> Crea una vista virtual basada en una consulta</label>
      <label><input type="radio" name="q7" value="Crea una tabla física nueva"> Crea una tabla física nueva</label>
      <label><input type="radio" name="q7" value="Elimina una vista existente"> Elimina una vista existente</label>
    </div>

    <div class="pregunta">
      <p>8️⃣ ¿Qué instrucción se usa para confirmar una transacción?</p>
      <label><input type="radio" name="q8" value="COMMIT" required> COMMIT</label>
      <label><input type="radio" name="q8" value="SAVE"> SAVE</label>
      <label><input type="radio" name="q8" value="ROLLBACK"> ROLLBACK</label>
    </div>

    <button type="submit">Enviar examen</button>
  </form>
  <a href="../course.php">← Volver al curso</a>
</body>
</html>
