<?php 
$sede   = $_POST['sede'];
$grado   = $_POST['grado'];
$jornada = $_POST['jornada'];
$texto="El plantel educativo expresa que el carnet ";
require_once "conexion.php";
include "fpdf/fpdf.php";
$f   = date("Y-m-d");
$sql = "select * from estudiantes where grado='$grado' and sede='$sede' and jornada='$jornada'   order by apellidos asc";
$res = mysqli_query($conexion, $sql);
$num1 = mysqli_num_rows($res);
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFillColor(232, 232, 232);

$i=0;
$pdf->SetFont('Arial', '', 10);
      
    $pdf->SetFont('Arial', 'B', 10);   
   while ($reg = mysqli_fetch_array($res)) {  
     $pdf->Ln();
    $pdf->Ln();
    
     
    $pdf->Cell(95, 60, '', 1, 0, 'J');
    $pdf->Cell(95, 60, $texto, 1, 0, 'J');
    $pdf->MultiCell(40,5, $pdf->Image("carnet-col.png", $pdf->GetX()-190, $pdf->GetY()+0, 1, 60) ,0,"C");
             $pdf->SetFont('Arial', 'B', 10);
     $pdf->SetX(40);
     $pdf->Cell(30, 6, utf8_decode("INSTITUCIÓN EDUCATIVA DON ALONSO"), 0, 1, 'C');
     $pdf->SetX(43);
     $pdf->Cell(30, 6, utf8_decode("COROZAL - SUCRE"), 0, 1, 'C');
     $pdf->SetX(43);
     $pdf->Cell(30, 6, utf8_decode("CARNET ESTUDIANTIL"), 0, 1, 'C');     
     $pdf->SetX(15);
     $pdf->Cell(25, 25, '', 1, 0, 'J');
     $pdf->SetX(90);     
    $pdf->MultiCell(40,5, $pdf->Image("logo-ineda.png", $pdf->GetX()-40, $pdf->GetY()+3, 15) ,0,"C");
     $pdf->SetFont('Arial', '', 9);
     $pdf->Ln();
     $pdf->Ln();
     $pdf->Ln();
     $pdf->Ln();
     $pdf->SetX(15);
        $pdf->Cell(70, 6, utf8_decode("ESTUDIANTE:")." ".$reg['apellidos']." ".$reg['nombres'], 0, 1, 'J');
        $pdf->SetX(15);
        $pdf->Cell(70, 6, utf8_decode("N° Doc:")." ".$reg['numero_doc'], 0, 1, 'J');
   
 
}


$pdf->Output();