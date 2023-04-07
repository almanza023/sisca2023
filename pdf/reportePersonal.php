<?php
require_once "conexion.php";
include "fpdf/fpdf.php";
$f   = date("Y-m-d");
$sql = "select * from docentes  order by apellidos asc";
$res = mysqli_query($conexion, $sql);

$num1 = mysqli_num_rows($res);

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFillColor(232, 232, 232);

$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(190, 6, 'Institucion Educativa Don Alonso ', 0, 1, 'C');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(190, 6, 'Vigilada MinEducacion ', 0, 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(190, 6, 'Resolucion N 12 de 2014 ', 0, 1, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln();

$pdf->Ln();
$pdf->Ln();
$pdf->Cell(10, 6, 'Reporte de Docentes ', 0, 1, 'J');
$pdf->Cell(10, 6, 'Fecha: ' . $f, 0, 0, 'J');
$pdf->Image('logo-ineda.png', 10, 8, 25);
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(70, 6, 'APELLIDOS', 1, 0, 'C', 1);

$pdf->Cell(65, 6, 'NOMBRES', 1, 0, 'C', 1);
$pdf->Cell(25, 6, 'TELEFONO', 1, 0, 'C', 1);
$pdf->Cell(30, 6, 'JORNADA', 1, 0, 'C', 1);

$pdf->Ln();
while ($reg = mysqli_fetch_array($res)) {
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(70, 6, $reg['apellidos'], 1, 0, 'J');
    $pdf->Cell(65, 6, $reg['nombres'], 1, 0, 'J');
    $pdf->Cell(25, 6, $reg['telefono'], 1, 0, 'J');
    $pdf->Cell(30, 6, utf8_decode(str_replace("??", "ñ", $reg['jornada'])), 1, 1, 'J');
}
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(70, 6, 'Total Docentes: ' . $num1, 1, 0, 'J', 1);
$pdf->Output();
