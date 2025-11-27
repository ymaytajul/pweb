<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insertar en la base de datos usando consulta preparada para mayor seguridad
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro - SQL Learning</title>
  <style>
    /* Reset básico */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, #ff7e5f, #feb47b);
        color: #333;
    }

    .register-container {
        background-color: #ffffff;
        padding: 40px 30px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        width: 350px;
        text-align: center;
    }

    .register-container h2 {
        margin-bottom: 25px;
        color: #333;
    }

    .register-container input[type="text"],
    .register-container input[type="email"],
    .register-container input[type="password"] {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 8px;
        outline: none;
        transition: 0.3s;
        font-size: 14px;
    }

    .register-container input[type="text"]:focus,
    .register-container input[type="email"]:focus,
    .register-container input[type="password"]:focus {
        border-color: #feb47b;
        box-shadow: 0 0 5px rgba(254,180,123,0.5);
    }

    .register-container button {
        width: 100%;
        padding: 12px;
        background-color: #ff7e5f;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 10px;
    }

    .register-container button:hover {
        background-color: #eb6741;
    }

    .register-container p {
        margin-top: 15px;
        font-size: 14px;
    }

    .register-container a {
        color: #ff7e5f;
        text-decoration: none;
        font-weight: bold;
    }

    .register-container a:hover {
        text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Crear Cuenta</h2>
    <form method="post">
      <input type="text" name="username" placeholder="Usuario" required>
      <input type="email" name="email" placeholder="Correo" required>
      <input type="password" name="password" placeholder="Contraseña" required>
      <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes cuenta? <a href="index.php">Inicia Sesión</a></p>
  </div>
</body>
</html>
