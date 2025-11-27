<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../index.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lectura - SQL Avanzado</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #121212;
      color: #e0e0e0;
      padding: 40px;
      line-height: 1.6;
    }
    h1 {
      text-align: center;
      color: #00bcd4;
    }
    .contenedor {
      background: #1e1e1e;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(255,255,255,0.1);
      max-width: 900px;
      margin: 0 auto;
    }
    p {
      margin-bottom: 15px;
    }
    b, strong {
      color: #ffeb3b; /* Amarillo claro para resaltar sobre fondo oscuro */
    }
    code {
      background: #333;
      color: #00ffcc;
      padding: 3px 6px;
      border-radius: 4px;
      font-family: monospace;
    }
    pre {
      background: #222;
      color: #00e676;
      padding: 15px;
      border-radius: 8px;
      overflow-x: auto;
    }
    a {
      color: #03a9f4;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <h1>Lectura - Nivel Avanzado</h1>
  <a href="../course.php" style="color:#90caf9;">← Volver al curso</a>

  <div class="contenedor">
    <p>En este nivel aprenderás conceptos avanzados de SQL que te permitirán optimizar consultas, automatizar tareas y crear estructuras de bases de datos más eficientes.</p>

    <h2>1. Subconsultas (Subqueries)</h2>
    <p>Una <b>subconsulta</b> es una consulta dentro de otra consulta. Se usa para obtener resultados que serán utilizados por la consulta principal.</p>
    <pre>
SELECT nombre, salario
FROM empleados
WHERE salario > (SELECT AVG(salario) FROM empleados);
    </pre>
    <p>En este ejemplo, solo se muestran los empleados cuyo salario es mayor que el promedio general.</p>

    <h2>2. Joins avanzados</h2>
    <p>Los <b>JOINS</b> permiten combinar datos de múltiples tablas. En SQL avanzado, se utilizan con condiciones más complejas o múltiples niveles de unión.</p>
    <pre>
SELECT e.nombre, d.nombre_departamento
FROM empleados e
INNER JOIN departamentos d ON e.id_departamento = d.id_departamento
WHERE d.ubicacion = 'Lima';
    </pre>

    <h2>3. Vistas (Views)</h2>
    <p>Una <b>vista</b> es una consulta guardada que puede ser tratada como una tabla virtual. Se usa para simplificar consultas complejas o proteger datos sensibles.</p>
    <pre>
CREATE VIEW vista_empleados_lima AS
SELECT nombre, salario, id_departamento
FROM empleados
WHERE ciudad = 'Lima';
    </pre>

    <h2>4. Procedimientos almacenados (Stored Procedures)</h2>
    <p>Un <b>procedimiento almacenado</b> es un conjunto de instrucciones SQL que se pueden ejecutar como una unidad. Es útil para automatizar procesos repetitivos.</p>
    <pre>
DELIMITER //
CREATE PROCEDURE AumentarSalario(IN porcentaje DECIMAL(5,2))
BEGIN
  UPDATE empleados SET salario = salario * (1 + porcentaje/100);
END //
DELIMITER ;
    </pre>

    <h2>5. Triggers</h2>
    <p>Un <b>trigger</b> (disparador) es un bloque de código que se ejecuta automáticamente cuando ocurre un evento (INSERT, UPDATE o DELETE).</p>
    <pre>
CREATE TRIGGER actualizar_fecha_modificacion
BEFORE UPDATE ON empleados
FOR EACH ROW
SET NEW.fecha_modificacion = NOW();
    </pre>

    <h2>6. Índices</h2>
    <p>Un <b>índice</b> acelera las búsquedas en una tabla, aunque puede ralentizar las inserciones o actualizaciones. Se recomienda usarlos estratégicamente.</p>
    <pre>
CREATE INDEX idx_nombre_empleado ON empleados(nombre);
    </pre>

    <p>Estos temas son la base del <b>SQL profesional</b> usado en aplicaciones de alto rendimiento y sistemas empresariales complejos.</p>
  </div>
</body>
</html>
