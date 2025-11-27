<?php
session_start();
include 'db.php';
include 'points.php';

$user_id = $_SESSION['user_id'];
$quiz_id = $_POST['quiz_id'];
$user_answer = $_POST['answer'];

$r = $conn->query("SELECT correct_answer FROM quizzes WHERE id = $quiz_id")->fetch_assoc();
$correct = $r['correct_answer'];

if ($user_answer == $correct) {

    add_points($conn, $user_id, 20, null, $quiz_id);

    header("Location: dashboard.php?msg=quiz_correcto");
} 
else {
    header("Location: dashboard.php?msg=quiz_incorrecto");
}
?>
