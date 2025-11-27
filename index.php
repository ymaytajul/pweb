<?php
session_start();
include 'db.php';

// Si ya inició sesión, redirige directamente
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: dashboard.php");
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Evitar inyección SQL con consulta preparada
    $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Guardar sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirigir según el rol
        if ($user['role'] === 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login - SQL Learning</title>
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
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        color: #333;
    }

    .login-container {
        background-color: #ffffff;
        padding: 40px 30px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        width: 350px;
        text-align: center;
    }

    .login-container h2 {
        margin-bottom: 25px;
        color: #333;
    }

    .login-container input[type="email"],
    .login-container input[type="password"] {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 8px;
        outline: none;
        transition: 0.3s;
        font-size: 14px;
    }

    .login-container input[type="email"]:focus,
    .login-container input[type="password"]:focus {
        border-color: #2575fc;
        box-shadow: 0 0 5px rgba(37,117,252,0.5);
    }

    .login-container button {
        width: 100%;
        padding: 12px;
        background-color: #2575fc;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 10px;
    }

    .login-container button:hover {
        background-color: #1a5edb;
    }

    .login-container p {
        margin-top: 15px;
        font-size: 14px;
    }

    .login-container a {
        color: #2575fc;
        text-decoration: none;
        font-weight: bold;
    }

    .login-container a:hover {
        text-decoration: underline;
    }

    .error-message {
        margin-top: 15px;
        font-weight: bold;
        color: red;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>🔐 Iniciar Sesión</h2>

    <form method="post">
      <input type="email" name="email" placeholder="Correo" required>
      <input type="password" name="password" placeholder="Contraseña" required>
      <button type="submit">Entrar</button>
    </form>

    <p>¿No tienes cuenta? <a href="register.php">Regístrate</a></p>

    <?php if (!empty($error)) echo "<p class='error-message'>$error</p>"; ?>
  </div>
</body>
</html>
