<?php
include '../db.php';
session_start();

// Verificar rol admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit;
}

// Crear usuario
if (isset($_POST['create'])) {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();
}

// Actualizar usuario
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = trim($_POST['username']);
    $role = $_POST['role'];
    $stmt = $conn->prepare("UPDATE users SET username=?, role=? WHERE id=?");
    $stmt->bind_param("ssi", $username, $role, $id);
    $stmt->execute();
}

// Eliminar usuario
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Obtener todos los usuarios
$result = $conn->query("SELECT * FROM users ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <style>
        body { font-family: Arial; margin: 30px; }
        table { border-collapse: collapse; width: 80%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background: #f2f2f2; }
        a { text-decoration: none; color: #007bff; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<h2>🧍‍♂️ Matriz CRUD de Usuarios</h2>
<p><a href="dashboard.php">⬅ Volver al panel</a></p>

<!-- Formulario de creación -->
<form method="POST">
    <h3>➕ Crear nuevo usuario</h3>
    <input type="text" name="username" placeholder="Usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <select name="role">
        <option value="student">Estudiante</option>
        <option value="admin">Administrador</option>
    </select>
    <button type="submit" name="create">Crear</button>
</form>

<!-- Tabla de usuarios -->
<table>
    <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Rol</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <form method="POST">
            <td><?php echo $row['id']; ?></td>
            <td><input type="text" name="username" value="<?php echo htmlspecialchars($row['username']); ?>"></td>
            <td>
                <select name="role">
                    <option value="student" <?php if($row['role']=='student') echo 'selected'; ?>>Estudiante</option>
                    <option value="admin" <?php if($row['role']=='admin') echo 'selected'; ?>>Administrador</option>
                </select>
            </td>
            <td>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="update">💾 Actualizar</button>
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Eliminar usuario?');">🗑️ Eliminar</a>
            </td>
        </form>
    </tr>
    <?php } ?>
</table>

</body>
</html>
