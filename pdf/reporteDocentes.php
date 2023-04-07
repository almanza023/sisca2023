<?php
$sede   = $_POST['sede'];
if (isset($sede)  ) {
require_once "../../config/Conexion.php";
include "fpdf/fpdf.php";
$pdf = new FPDF('P', 'mm', 'Legal');
$pdf->AddPage();
$pdf->SetFillColor(232, 232, 232);
$pdf->SetFont('Arial', 'B', 16);
$sql="SELECT * FROM datos_colegio ";
$res=$mysqli->query($sql);
$reg=$res->fetch_row();
$pdf->Cell(190, 6, utf8_decode($reg[1]), 0, 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(190, 4, utf8_decode($reg[2]), 0, 1, 'C');
$pdf->Cell(190, 4, utf8_decode(' Plantel de Carácter Oficial'), 0, 1, 'C');
$pdf->Cell(190, 4, utf8_decode(' Resolución N° 1072 Mayo 31/04 y 1566 Agosto 06/04'), 0, 1, 'C');
$pdf->Cell(190, 6, utf8_decode(' Código Icfes '.$reg[7]), 0, 1, 'C');
$pdf->Cell(190, 6, utf8_decode($reg[6]), 0, 1, 'C');
$pdf->Image('logo-ineda.png', 8, 6, 20);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(200, 10, '', 1, 0, 'J'); 
$pdf->Ln(2);      
$pdf->SetFont('Arial', 'B', 10);
$sqld="SELECT nombre FROM sedes ";
$resd=$mysqli->query($sqld);
$regd=$resd->fetch_row();
$pdf->Cell(90, 6, 'SEDE:  '.$regd[0], 0, 0, 'J');  
$pdf->Cell(140, 6, utf8_decode('AÑO: 2020'), 0, 0, 'J');
$pdf->Ln(11);    
$pdf->Cell(200, 6, utf8_decode('LISTADO DE DOCENTES'), 1, 0, 'C', 1); 
$pdf->Ln(8);         
    $pdf->SetFont('Arial', 'B', 10);
     $pdf->Cell(10, 6, utf8_decode('N°'), 1, 0, 'J', 1);
     $pdf->Cell(70, 6, utf8_decode('DOCENTE'), 1, 0, 'J', 1);
     $pdf->Cell(30, 6, utf8_decode('N° DOCUMENTO'), 1, 0, 'J', 1);
     $pdf->Cell(30, 6, utf8_decode('TELÉFONO'), 1, 0, 'J', 1);
    $pdf->Cell(60, 6, utf8_decode('CORREO'), 1, 0, 'J', 1);
    
    $pdf->Ln();
    $sql = "SELECT * FROM personal where idsede='$sede' and tipo=1";
    
    $res = $mysqli->query($sql);   
    $i=1;
    while ($reg = $res->fetch_row()) {
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(10, 6, $i, 1, 0, 'J');
        $nomc=$reg['2'].' '.$reg['3'];
        $pdf->Cell(70, 6, utf8_decode($nomc), 1, 0, 'J');
        $pdf->Cell(30, 6, utf8_decode($reg['4']), 1, 0, 'J');
        $pdf->Cell(30, 6, utf8_decode($reg['6']), 1, 0, 'J');
        $pdf->MultiCell('60', '6', utf8_decode($reg['5']), 1, 1,0);  
        $i++;
    }
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();   
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(70, 1, '' , 0, 1, 'J', 0);
        $pdf->Cell(70, 6, utf8_decode('VoBo '), 0, 1, 'J', 0);
         $pdf->Cell(70, 6, utf8_decode('Cordinador Académico '), 0, 1, 'J', 0);
    date_default_timezone_set("UTC");
    $fecha=date("d/m/Y");
    $pdf->Cell(70, 6, utf8_decode($fecha), 0, 1, 'J', 0);
    // Footer
      $pdf->SetY(310);    
    $pdf->SetFont('Arial','B',8);    
    $pdf->Cell(0,10,utf8_decode('Pagína N°: ').$pdf->PageNo(),0,0,'R');
    $pdf->Ln(3.5);
    $pdf->Cell(0,10,'Impreso por SIA INEDA 2020',0,0,'R');
    $pdf->Output();
}

?>
