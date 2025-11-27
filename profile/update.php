<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $bio = trim($_POST['bio']);
    $bg_color = $_POST['bg_color'];

    if ($username === "" || $email === "") {
        $_SESSION['error'] = "Todos los campos obligatorios.";
        header("Location: index.php");
        exit();
    }

    // Manejo de avatar
    $avatar = $conn->query("SELECT avatar FROM users WHERE id=$id")->fetch_assoc()['avatar'];
    if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK){
        $tmp_name = $_FILES['avatar']['tmp_name'];
        $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $avatar_name = 'user_'.$id.'_'.time().'.'.$ext;
        move_uploaded_file($tmp_name, 'avatars/'.$avatar_name);
        $avatar = $avatar_name;
    }

    $stmt = $conn->prepare("UPDATE users SET username=?, email=?, bio=?, bg_color=?, avatar=? WHERE id=?");
    $stmt->bind_param("sssssi", $username, $email, $bio, $bg_color, $avatar, $id);

    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "Perfil actualizado correctamente.";
    } else {
        $_SESSION['error'] = "Error al actualizar el perfil.";
    }

    $stmt->close();
    header("Location: index.php");
    exit();
}
