<?php
session_start();
include 'db.php';
include 'puntos_progreso.php';

if (!isset($_POST['user_id'])) exit('Error: no user_id');

$user_id = $_POST['user_id'];
$nivel = $_POST['nivel'] ?? 'basico';

// Puntos según nivel
$points = ($nivel == 'basico') ? 10 : 20;

// Guardar reto
completarReto($conn, $user_id, $nivel, $points);

echo "¡Puntos guardados!";
?>
