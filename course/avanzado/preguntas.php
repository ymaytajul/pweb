<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../index.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Examen - Nivel Avanzado</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8f8f8;
      padding: 40px;
    }
    h1 {
      text-align: center;
      color: #333;
    }
    form {
      background: white;
      padding: 30px;
      max-width: 800px;
      margin: auto;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
    }
    .pregunta {
      margin-bottom: 25px;
    }
    button {
      background: #007bff;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
    }
    button:hover { background: #0056b3; }
  </style>
</head>
<body>
  <h1>Examen de SQL - Nivel Avanzado</h1>
  <form method="post" action="resultado.php">

    <div class="pregunta">
      <p><b>1. ¿Qué hace una función de ventana (<code>OVER()</code>) en SQL?</b></p>
      <label><input type="radio" name="q1" value="Permite realizar cálculos sobre un conjunto de filas relacionadas sin agrupar" required> Permite realizar cálculos sobre un conjunto de filas relacionadas sin agrupar</label><br>
      <label><input type="radio" name="q1" value="Agrupa los resultados de una consulta"> Agrupa los resultados de una consulta</label><br>
      <label><input type="radio" name="q1" value="Elimina duplicados de una tabla"> Elimina duplicados de una tabla</label>
    </div>

    <div class="pregunta">
      <p><b>2. ¿Cuál es la diferencia entre <code>WHERE</code> y <code>HAVING</code>?</b></p>
      <label><input type="radio" name="q2" value="WHERE filtra antes de agrupar y HAVING después de agrupar" required> WHERE filtra antes de agrupar y HAVING después de agrupar</label><br>
      <label><input type="radio" name="q2" value="Ambas filtran después de agrupar"> Ambas filtran después de agrupar</label><br>
      <label><input type="radio" name="q2" value="HAVING se usa solo en subconsultas"> HAVING se usa solo en subconsultas</label>
    </div>

    <div class="pregunta">
      <p><b>3. ¿Qué comando inicia una transacción en SQL?</b></p>
      <label><input type="radio" name="q3" value="START TRANSACTION" required> START TRANSACTION</label><br>
      <label><input type="radio" name="q3" value="BEGIN CHANGES"> BEGIN CHANGES</label><br>
      <label><input type="radio" name="q3" value="OPEN TRANSACTION"> OPEN TRANSACTION</label>
    </div>

    <div class="pregunta">
      <p><b>4. ¿Para qué sirve un índice (<code>INDEX</code>)?</b></p>
      <label><input type="radio" name="q4" value="Para acelerar las búsquedas y consultas sobre columnas específicas" required> Para acelerar las búsquedas y consultas sobre columnas específicas</label><br>
      <label><input type="radio" name="q4" value="Para crear una copia de seguridad de los datos"> Para crear una copia de seguridad de los datos</label><br>
      <label><input type="radio" name="q4" value="Para eliminar duplicados automáticamente"> Para eliminar duplicados automáticamente</label>
    </div>

    <div class="pregunta">
      <p><b>5. ¿Qué hace el comando <code>CREATE VIEW</code>?</b></p>
      <label><input type="radio" name="q5" value="Crea una tabla virtual basada en una consulta" required> Crea una tabla virtual basada en una consulta</label><br>
      <label><input type="radio" name="q5" value="Crea una copia física de una tabla"> Crea una copia física de una tabla</label><br>
      <label><input type="radio" name="q5" value="Crea una transacción temporal"> Crea una transacción temporal</label>
    </div>

    <div class="pregunta">
      <p><b>6. ¿Cuál de los siguientes comandos deshace los cambios de una transacción?</b></p>
      <label><input type="radio" name="q6" value="ROLLBACK" required> ROLLBACK</label><br>
      <label><input type="radio" name="q6" value="COMMIT"> COMMIT</label><br>
      <label><input type="radio" name="q6" value="REVERT"> REVERT</label>
    </div>

    <div class="pregunta">
      <p><b>7. ¿Qué hace una subconsulta correlacionada?</b></p>
      <label><input type="radio" name="q7" value="Hace referencia a columnas de la consulta principal" required> Hace referencia a columnas de la consulta principal</label><br>
      <label><input type="radio" name="q7" value="Solo devuelve una fila"> Solo devuelve una fila</label><br>
      <label><input type="radio" name="q7" value="Crea una tabla temporal"> Crea una tabla temporal</label>
    </div>

    <div class="pregunta">
      <p><b>8. ¿Qué hace el comando <code>DROP INDEX</code>?</b></p>
      <label><input type="radio" name="q8" value="Elimina un índice existente en una tabla" required> Elimina un índice existente en una tabla</label><br>
      <label><input type="radio" name="q8" value="Elimina una tabla completa"> Elimina una tabla completa</label><br>
      <label><input type="radio" name="q8" value="Elimina una vista"> Elimina una vista</label>
    </div>

    <div class="pregunta">
      <p><b>9. ¿Qué palabra clave se usa para limitar el número de resultados?</b></p>
      <label><input type="radio" name="q9" value="LIMIT" required> LIMIT</label><br>
      <label><input type="radio" name="q9" value="TOP"> TOP</label><br>
      <label><input type="radio" name="q9" value="RANGE"> RANGE</label>
    </div>

    <div class="pregunta">
      <p><b>10. ¿Cuál es la ventaja principal de usar vistas?</b></p>
      <label><input type="radio" name="q10" value="Simplifican consultas complejas y mejoran la seguridad" required> Simplifican consultas complejas y mejoran la seguridad</label><br>
      <label><input type="radio" name="q10" value="Aceleran todas las consultas"> Aceleran todas las consultas</label><br>
      <label><input type="radio" name="q10" value="Eliminan datos duplicados"> Eliminan datos duplicados</label>
    </div>

    <button type="submit">Enviar respuestas</button>
  </form>
</body>
</html>
