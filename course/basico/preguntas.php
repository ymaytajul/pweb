<?php 
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../index.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Examen - Nivel Básico</title>
  <link rel="stylesheet" href="../../assets/style.css">
  <style>
    body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 40px; }
    h1 { color: #004aad; }
    form {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
      max-width: 700px;
      margin: auto;
    }
    p { font-weight: bold; color: #222; }
    label { display: block; margin: 4px 0 10px 20px; cursor: pointer; }
    button {
      background: #004aad;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 15px;
    }
    button:hover { background: #00357a; }
    a { text-decoration: none; color: #004aad; }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <h1>🧠 Examen del Curso Básico de SQL</h1>
  <a href="../course.php">← Volver al curso</a>
  <br><br>

  <form method="post" action="resultado.php">
    <p>1. ¿Qué comando se usa para seleccionar datos en SQL?</p>
    <label><input type="radio" name="q1" value="SELECT"> SELECT</label>
    <label><input type="radio" name="q1" value="INSERT"> INSERT</label>
    <label><input type="radio" name="q1" value="DELETE"> DELETE</label>

    <p>2. ¿Qué cláusula se usa para filtrar resultados?</p>
    <label><input type="radio" name="q2" value="WHERE"> WHERE</label>
    <label><input type="radio" name="q2" value="GROUP BY"> GROUP BY</label>
    <label><input type="radio" name="q2" value="JOIN"> JOIN</label>

    <p>3. ¿Qué palabra clave se usa para ordenar los resultados?</p>
    <label><input type="radio" name="q3" value="ORDER BY"> ORDER BY</label>
    <label><input type="radio" name="q3" value="GROUP BY"> GROUP BY</label>
    <label><input type="radio" name="q3" value="HAVING"> HAVING</label>

    <p>4. ¿Cuál es la función que devuelve el número total de filas?</p>
    <label><input type="radio" name="q4" value="COUNT()"> COUNT()</label>
    <label><input type="radio" name="q4" value="SUM()"> SUM()</label>
    <label><input type="radio" name="q4" value="AVG()"> AVG()</label>

    <p>5. ¿Qué comando se usa para eliminar registros?</p>
    <label><input type="radio" name="q5" value="DELETE"> DELETE</label>
    <label><input type="radio" name="q5" value="DROP"> DROP</label>
    <label><input type="radio" name="q5" value="REMOVE"> REMOVE</label>

    <p>6. ¿Qué comando crea una nueva tabla en SQL?</p>
    <label><input type="radio" name="q6" value="CREATE TABLE"> CREATE TABLE</label>
    <label><input type="radio" name="q6" value="INSERT INTO"> INSERT INTO</label>
    <label><input type="radio" name="q6" value="NEW TABLE"> NEW TABLE</label>

    <p>7. ¿Qué palabra clave evita mostrar registros duplicados?</p>
    <label><input type="radio" name="q7" value="DISTINCT"> DISTINCT</label>
    <label><input type="radio" name="q7" value="UNIQUE"> UNIQUE</label>
    <label><input type="radio" name="q7" value="DIFFERENT"> DIFFERENT</label>

    <p>8. ¿Qué cláusula se usa para combinar datos de dos tablas?</p>
    <label><input type="radio" name="q8" value="JOIN"> JOIN</label>
    <label><input type="radio" name="q8" value="LINK"> LINK</label>
    <label><input type="radio" name="q8" value="MERGE"> MERGE</label>

    <p>9. ¿Qué función calcula el valor promedio de una columna numérica?</p>
    <label><input type="radio" name="q9" value="AVG()"> AVG()</label>
    <label><input type="radio" name="q9" value="SUM()"> SUM()</label>
    <label><input type="radio" name="q9" value="COUNT()"> COUNT()</label>

    <p>10. ¿Qué comando se usa para agregar nuevos registros?</p>
    <label><input type="radio" name="q10" value="INSERT INTO"> INSERT INTO</label>
    <label><input type="radio" name="q10" value="ADD"> ADD</label>
    <label><input type="radio" name="q10" value="UPDATE"> UPDATE</label>

    <button type="submit">Enviar Examen</button>
  </form>
</body>
</html>
