<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    die("No autorizado");
}

$user_id = $_SESSION['user_id'];

// ======================
// 1. AGARRAR CONTENIDO
// ======================
if (!isset($_POST['content'])) {
    die("ERROR: No llegó 'content' desde el formulario.");
}

$content = trim($_POST['content']);

if ($content === "") {
    die("ERROR: El contenido está vacío.");
}

// ======================
// 2. MANEJO IMAGEN OPCIONAL
// ======================
$image_path = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

    $dir = "../uploads/";

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $fileName = time() . "_" . basename($_FILES["image"]["name"]);
    $uploadPath = $dir . $fileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath)) {
        $image_path = "uploads/" . $fileName;
    }
}

// ======================
// 3. INSERTAR POST
// ======================
$stmt = $conn->prepare("INSERT INTO posts (user_id, content, image_path) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $content, $image_path);

if ($stmt->execute()) {
    header("Location: ../dashboard.php");
    exit;
} else {
    die("ERROR al insertar: " . $stmt->error);
}
