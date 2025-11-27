<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <style>
        body { font-family: Arial; margin: 30px; }
        a { text-decoration: none; color: #007bff; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<h1>👑 Bienvenido, Administrador <?php echo $_SESSION['username']; ?></h1>
<p><a href="users.php">🧍‍♂️ Gestionar Usuarios</a></p>
<p><a href="../logout.php">🔒 Cerrar sesión</a></p>

</body>
</html>
