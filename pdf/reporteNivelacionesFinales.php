<?php
$grado   = $_POST['grado'];
$jornada   = 'MATINAL';
$sede   = $_POST['sede'];
$materia   = $_POST['materia'];
$periodo   = $_POST['periodo'];
if (isset($grado) && isset($sede) && isset($jornada) ) {
    require_once "conexion.php";
    include "fpdf/fpdf.php";
    $pdf = new FPDF('P', 'mm', 'Legal');
    $pdf->AddPage();
    $pdf->SetFillColor(232, 232, 232);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(190, 6, utf8_decode('INSTITUCIÓN EDUCATIVA DON ALONSO '), 0, 1, 'C');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(190, 4, utf8_decode(' KR 9 CL 8-32'), 0, 1, 'C');
            $pdf->Cell(190, 4, utf8_decode(' Plantel de Carácter Oficial'), 0, 1, 'C');
            $pdf->Cell(190, 4, utf8_decode(' Resolución N° 1072 Mayo 31/04 y 1566 Agosto 06/04'), 0, 1, 'C');
            $pdf->Cell(190, 6, utf8_decode(' Código Icfes 092908 - 128413'), 0, 1, 'C');
            $pdf->Image('logo-ineda.png', 8, 6, 20);
            $pdf->SetFont('Arial', 'B', 10);
     $pdf->Cell(200, 10, '', 1, 0, 'J'); 
     $pdf->Ln(2);      
    $pdf->SetFont('Arial', 'B', 10);
     $pdf->Cell(50, 4, 'GRADO: '.$grado, 0, 0, 'J');  
     $pdf->Cell(100, 6, 'PERIODO: '.'FINAL', 0, 0, 'J');  
         $pdf->Ln(20);    
         
    $pdf->SetFont('Arial', 'B', 10);
     $pdf->Cell(10, 6, utf8_decode('N°'), 1, 0, 'C', 1);
     $pdf->Cell(100, 6, utf8_decode('ESTUDIANTES'), 1, 0, 'C', 1);    
     $pdf->Cell(50, 6, utf8_decode('ARÉA/ASIGNATURA'), 1, 0, 'j', 1);
     $pdf->Cell(20, 6, utf8_decode('NOTA'), 1, 0, 'j', 1);
    
    $pdf->Ln();
        $sql = "select * from nivelaciones where grado='$grado'  and periodo='FINAL' and sede='$sede' order by apellidos";
    $res = mysqli_query($conexion, $sql);
   
    $i=1;
    
    while ($reg = mysqli_fetch_array($res)) {
         $nom=$reg['nombres'];
         $ape=$reg['apellidos'];           
        $notaN=$reg['nota'];
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 6, $i, 1, 0, 'J');
        $pdf->Cell(100, 6, utf8_decode($reg['apellidos'].' '.$reg['nombres']), 1, 0, 'J');
         $pdf->Cell(50, 6, utf8_decode($reg['materia']), 1, 0, 'J');       
        $pdf->Cell(20, 6, $notaN, 1, 1, 'J');  
       
       
        $i++;
    }   
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();   $pdf->Cell(70, 1, '' , 0, 1, 'J', 0);
        $pdf->Cell(70, 6, utf8_decode('VoBo '), 0, 1, 'J', 0);
         $pdf->Cell(70, 6, utf8_decode('Cordinador Académico '), 0, 1, 'J', 0);
    
    $pdf->Output();
}

?>
