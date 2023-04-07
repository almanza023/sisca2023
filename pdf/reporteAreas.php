<?php
$grado   = $_POST['grado'];
$jornada   = $_POST['jornada'];
$sede   = $_POST['sede'];
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
     $pdf->Cell(80, 6, 'GRADO: '.$grado, 0, 0, 'J');
    $pdf->Cell(90, 6, 'SEDE: '.$sede, 0, 0, 'J');  
     $pdf->Cell(90, 6, utf8_decode('AÑO: 2017'), 0, 0, 'J');  
         $pdf->Ln(20);    
         
    $pdf->SetFont('Arial', 'B', 10);
     $pdf->Cell(10, 6, utf8_decode('N°'), 1, 0, 'C', 1);
    $pdf->Cell(75, 6, utf8_decode('ARÉA/ASIGNATURA'), 1, 0, 'C', 1);
    $pdf->Cell(20, 6, utf8_decode('POR'), 1, 0, 'C', 1);
    $pdf->Cell(20, 6, 'IHS', 1, 0, 'C', 1);
       $pdf->Cell(75, 6, 'DOCENTE', 1, 0, 'C', 1);
    $pdf->Ln();
        $sql = "select * from materias where grado='$grado' and sede='$sede'";
    $res = mysqli_query($conexion, $sql);
    $num1 = mysqli_num_rows($res);
    $i=1;
    while ($reg = mysqli_fetch_array($res)) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 6, $i, 1, 0, 'J');
        $pdf->Cell(75, 6, $reg['nombre'], 1, 0, 'J');
        $pdf->Cell(20, 6, utf8_decode($reg['porcentaje'])."%", 1, 0, 'J');
        $pdf->Cell(20, 6, $reg['ihs'], 1, 0, 'J');
        $pdf->Cell(75, 6, utf8_decode($reg['docente']), 1, 1, 'J');
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
