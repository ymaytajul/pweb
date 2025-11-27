<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../index.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lectura - Nivel Intermedio</title>
  <link rel="stylesheet" href="../../assets/style.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f3f6fa;
      margin: 0;
      padding: 40px;
    }
    h1 {
      text-align: center;
      color: #004aad;
    }
    .volver {
      display: inline-block;
      margin-bottom: 20px;
      text-decoration: none;
      color: #004aad;
      font-weight: bold;
    }
    .volver:hover { text-decoration: underline; }
    .capitulo {
      background: white;
      padding: 25px;
      margin: 25px auto;
      border-radius: 12px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
      max-width: 900px;
    }
    .capitulo h2 {
      color: #00357a;
      margin-bottom: 10px;
    }
    code {
      background: #eef1f5;
      padding: 3px 6px;
      border-radius: 4px;
      color: #d63384;
    }
    pre {
      background: #1e1e1e;
      color: #c5c5c5;
      padding: 15px;
      border-radius: 8px;
      overflow-x: auto;
    }
    .nota {
      background: #e9f5e9;
      border-left: 5px solid #28a745;
      padding: 10px 15px;
      margin-top: 10px;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <h1>📘 Lectura - Curso SQL Intermedio</h1>
  <a href="../course.php" class="volver">← Volver al curso</a>

  <div class="capitulo">
    <h2>Capítulo 1: Cláusulas Avanzadas en SELECT</h2>
    <p>En este nivel aprenderás a usar <code>GROUP BY</code>, <code>HAVING</code> y <code>ORDER BY</code> para crear consultas más precisas y analíticas.</p>
    <pre>
SELECT departamento, COUNT(*) AS total_empleados
FROM empleados
GROUP BY departamento
HAVING COUNT(*) > 5
ORDER BY total_empleados DESC;
    </pre>
    <div class="nota">💡 <b>Nota:</b> <code>HAVING</code> se usa junto a <code>GROUP BY</code> para filtrar resultados agrupados.</div>
  </div>

  <div class="capitulo">
    <h2>Capítulo 2: Subconsultas (Subqueries)</h2>
    <p>Una subconsulta es una consulta dentro de otra. Se usa para comparar resultados o filtrar datos dinámicamente.</p>
    <pre>
SELECT nombre, salario
FROM empleados
WHERE salario > (
    SELECT AVG(salario) FROM empleados
);
    </pre>
    <div class="nota">💡 <b>Tip:</b> Las subconsultas también se pueden usar con <code>IN</code>, <code>EXISTS</code> o <code>=</code>.</div>
  </div>

  <div class="capitulo">
    <h2>Capítulo 3: Funciones de Agregación Avanzadas</h2>
    <p>Además de las básicas, SQL permite combinarlas para análisis complejos:</p>
    <pre>
SELECT departamento,
       AVG(salario) AS promedio,
       MAX(salario) AS mayor,
       MIN(salario) AS menor
FROM empleados
GROUP BY departamento;
    </pre>
  </div>

  <div class="capitulo">
    <h2>Capítulo 4: JOINs Avanzados (INNER, LEFT, RIGHT, FULL)</h2>
    <p>Los <code>JOIN</code> permiten combinar datos de varias tablas relacionadas.</p>
    <pre>
-- INNER JOIN: solo registros coincidentes
SELECT empleados.nombre, departamentos.nombre
FROM empleados
INNER JOIN departamentos
ON empleados.depto_id = departamentos.id;

-- LEFT JOIN: todos los empleados, incluso sin departamento
SELECT empleados.nombre, departamentos.nombre
FROM empleados
LEFT JOIN departamentos
ON empleados.depto_id = departamentos.id;
    </pre>
    <div class="nota">💡 <b>FULL JOIN</b> muestra todos los registros, coincidan o no, aunque no todos los motores SQL lo soportan directamente.</div>
  </div>

  <div class="capitulo">
    <h2>Capítulo 5: Vistas (Views)</h2>
    <p>Las vistas son consultas almacenadas que simplifican la visualización de datos complejos.</p>
    <pre>
CREATE VIEW vista_empleados_activos AS
SELECT nombre, departamento
FROM empleados
WHERE estado = 'activo';

SELECT * FROM vista_empleados_activos;
    </pre>
    <div class="nota">💡 Puedes actualizar los datos de una vista si está basada en una sola tabla sin funciones agregadas.</div>
  </div>

  <div class="capitulo">
    <h2>Capítulo 6: Transacciones y Control de Errores</h2>
    <p>Las transacciones aseguran que las operaciones de datos sean completas y consistentes.</p>
    <pre>
BEGIN;
UPDATE cuentas SET saldo = saldo - 100 WHERE id = 1;
UPDATE cuentas SET saldo = saldo + 100 WHERE id = 2;
COMMIT;
    </pre>
    <div class="nota">💡 Si ocurre un error, usa <code>ROLLBACK;</code> para deshacer todos los cambios desde el <code>BEGIN</code>.</div>
  </div>

  <div class="capitulo">
    <h2>Capítulo 7: Funciones de Texto y Fecha</h2>
    <p>SQL tiene funciones útiles para manipular cadenas y fechas.</p>
    <pre>
SELECT UPPER(nombre), LOWER(ciudad), YEAR(fecha_contrato)
FROM empleados
WHERE MONTH(fecha_contrato) = 10;
    </pre>
    <div class="nota">📅 <b>Ejemplo:</b> <code>YEAR()</code> devuelve el año de una fecha, <code>UPPER()</code> convierte texto a mayúsculas.</div>
  </div>

  <div class="capitulo">
    <h2>Capítulo 8: CASE y Expresiones Condicionales</h2>
    <p><code>CASE</code> permite realizar condiciones dentro de una consulta SQL.</p>
    <pre>
SELECT nombre,
CASE 
  WHEN salario > 5000 THEN 'Alto'
  WHEN salario BETWEEN 2000 AND 5000 THEN 'Medio'
  ELSE 'Bajo'
END AS nivel_salarial
FROM empleados;
    </pre>
    <div class="nota">💡 Muy útil para clasificar resultados o crear etiquetas automáticas.</div>
  </div>

  <div class="capitulo">
    <h2>Capítulo 9: Funciones de Ventana (Window Functions)</h2>
    <p>Permiten calcular valores como promedios o totales acumulados sin agrupar los datos.</p>
    <pre>
SELECT nombre, departamento,
       salario,
       AVG(salario) OVER (PARTITION BY departamento) AS promedio_depto
FROM empleados;
    </pre>
    <div class="nota">💡 Estas funciones se usan con <code>OVER()</code> y <code>PARTITION BY</code>.</div>
  </div>

  <div class="capitulo">
    <h2>Capítulo 10: Buenas Prácticas SQL</h2>
    <ul>
      <li>Evita usar <code>SELECT *</code> en producción.</li>
      <li>Usa alias cortos y claros en tus consultas (<code>AS</code>).</li>
      <li>Siempre documenta tus <code>JOIN</code> y subconsultas.</li>
      <li>Aplica índices a columnas que se usen en <code>WHERE</code> o <code>JOIN</code>.</li>
      <li>Revisa el plan de ejecución (<b>EXPLAIN</b>) para optimizar.</li>
    </ul>
  </div>

</body>
</html>
