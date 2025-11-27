<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "sql_learning_app";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}
?>
