<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../index.php");
require('../../fpdf/fpdf.php');
include '../../db.php';

$user_id = $_SESSION['user_id'];

// Obtener nombre del usuario
$stmt = $conn->prepare("SELECT nombre FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nombre);
$stmt->fetch();
$stmt->close();

// Obtener última nota del nivel avanzado
$stmt = $conn->prepare("SELECT nota, fecha FROM exam_results WHERE user_id = ? AND nivel = 'Avanzado' ORDER BY fecha DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nota, $fecha);
$stmt->fetch();
$stmt->close();

if (!$nota) {
  echo "<h3>No has completado el examen avanzado aún.</h3>";
  exit;
}

// Crear PDF
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Fondo de color
$pdf->SetFillColor(240, 248, 255);
$pdf->Rect(0, 0, 297, 210, 'F');

// Título
$pdf->SetFont('Arial', 'B', 28);
$pdf->Cell(0, 30, 'CERTIFICADO DE FINALIZACIÓN', 0, 1, 'C');

// Texto principal
$pdf->SetFont('Arial', '', 18);
$pdf->Ln(20);
$pdf->Cell(0, 10, utf8_decode("Se otorga el presente certificado a:"), 0, 1, 'C');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 24);
$pdf->SetTextColor(0, 102, 204);
$pdf->Cell(0, 15, strtoupper($nombre), 0, 1, 'C');

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 16);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(0, 10, utf8_decode("Por haber completado satisfactoriamente el curso de SQL Nivel Avanzado con una calificación final de $nota/20."), 0, 'C');

$pdf->Ln(20);
$pdf->SetFont('Arial', 'I', 12);
$pdf->Cell(0, 10, utf8_decode("Emitido el día $fecha"), 0, 1, 'C');

// Firma o pie
$pdf->Ln(30);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, '_________________________', 0, 1, 'C');
$pdf->Cell(0, 8, utf8_decode('Instructor del Curso SQL'), 0, 1, 'C');

// Salida
$pdf->Output("D", "Certificado_SQL_Avanzado_$nombre.pdf");
?>
