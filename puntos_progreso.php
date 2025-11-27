<?php
include 'db.php'; // tu conexión existente

// Completar un módulo (lectura/práctica/preguntas)
function completarModulo($conn, $user_id, $course_id, $points = 10){
    $sql = "SELECT * FROM user_progress WHERE user_id=? AND course_id=? AND quiz_id IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $course_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if($res->num_rows == 0){
        $sqlInsert = "INSERT INTO user_progress(user_id, course_id, completed, earned_points) VALUES(?,?,1,?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("iii",$user_id,$course_id,$points);
        $stmtInsert->execute();
        actualizarRanking($conn, $user_id, $points);
    }
}

// Completar un quiz
function completarQuiz($conn, $user_id, $quiz_id, $points = 15){
    $sql = "SELECT * FROM user_progress WHERE user_id=? AND quiz_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $quiz_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if($res->num_rows == 0){
        $sqlInsert = "INSERT INTO user_progress(user_id, quiz_id, completed, earned_points) VALUES(?,?,1,?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("iii",$user_id,$quiz_id,$points);
        $stmtInsert->execute();
        actualizarRanking($conn, $user_id, $points);
    }
}

// Completar un reto
function completarReto($conn, $user_id, $reto_id, $points = 20){
    $sqlCheck = "SELECT * FROM user_progress WHERE user_id=? AND course_id IS NULL AND quiz_id IS NULL AND earned_points=?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("ii",$user_id,$points);
    $stmtCheck->execute();
    $resCheck = $stmtCheck->get_result();
    if($resCheck->num_rows == 0){
        $sqlInsert = "INSERT INTO user_progress(user_id, completed, earned_points) VALUES(?,?,?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $completed = 1;
        $stmtInsert->bind_param("iii",$user_id,$completed,$points);
        $stmtInsert->execute();
        actualizarRanking($conn, $user_id, $points);
    }
}

// Dar puntos por comentario
function puntosPorComentario($conn, $user_id, $points = 5){
    $sqlInsert = "INSERT INTO user_progress(user_id, completed, earned_points) VALUES(?,?,?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $completed = 1;
    $stmtInsert->bind_param("iii",$user_id,$completed,$points);
    $stmtInsert->execute();
    actualizarRanking($conn, $user_id, $points);
}

// Actualizar ranking
function actualizarRanking($conn, $user_id, $points){
    $sql = "SELECT * FROM ranking_usuarios WHERE usuario_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if($res->num_rows > 0){
        $sqlUpdate = "UPDATE ranking_usuarios SET puntos_totales = puntos_totales + ? WHERE usuario_id=?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ii",$points,$user_id);
        $stmtUpdate->execute();
    } else {
        $sqlInsert = "INSERT INTO ranking_usuarios(usuario_id, puntos_totales) VALUES(?,?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("ii",$user_id,$points);
        $stmtInsert->execute();
    }
}
?>
