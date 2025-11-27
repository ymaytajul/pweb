<?php
session_start();
include 'db.php';

function completarReto($conn, $user_id, $nivel, $points) {
    $stmt = $conn->prepare("SELECT puntos_totales FROM ranking_usuarios WHERE usuario_id=?");
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $stmt->store_result();
    
    if($stmt->num_rows > 0){
        $stmt->bind_result($puntos_actuales);
        $stmt->fetch();
        $puntos_totales = $puntos_actuales + $points;

        $update = $conn->prepare("UPDATE ranking_usuarios SET puntos_totales=? WHERE usuario_id=?");
        $update->bind_param("ii",$puntos_totales,$user_id);
        $update->execute();
        $update->close();
    } else {
        $insert = $conn->prepare("INSERT INTO ranking_usuarios (usuario_id, puntos_totales) VALUES (?,?)");
        $insert->bind_param("ii",$user_id,$points);
        $insert->execute();
        $insert->close();
    }
    $stmt->close();
}

$user_id = $_POST['user_id'];
$nivel = $_POST['nivel'];
$points = ($nivel == 'basico') ? 10 : 20;

completarReto($conn, $user_id, $nivel, $points);
echo "✅ Puntos guardados correctamente!";
?>
