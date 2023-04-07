<?php
$docente   = $_POST['docente'];
$sede   = $_POST['sede'];
date_default_timezone_set("UTC");  
if (isset($docente) && isset($sede) ) {
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
$pdf->Cell(200, 15, '', 1, 0, 'J'); 
$pdf->Ln(2);      
$pdf->SetFont('Arial', 'B', 10);
$sqla="SELECT nombre FROM sedes WHERE idsede='$sede' ";
$resa=$mysqli->query($sqla);
$rega=$resa->fetch_row();
$sqld="SELECT nombres, apellidos FROM personal WHERE idpersonal='$docente' ";
$resd=$mysqli->query($sqld);
$regd=$resd->fetch_row();
$pdf->Cell(100, 6, 'SEDE: '.utf8_decode($rega[0]), 0, 0, 'J');
$pdf->Cell(20, 6, utf8_decode('AÑO: 2020'), 0, 0, 'J');
$pdf->SetY(48);
$pdf->Cell(100, 6, 'DOCENTE:  '.utf8_decode($regd[0]).' '.utf8_decode($regd[1]), 0, 0, 'J');
$pdf->Ln(10);   
$pdf->Cell(200, 6, utf8_decode('CARGA ACADÉMICA'), 1, 0, 'C', 1);   
$pdf->Ln(8);   
    $pdf->SetFont('Arial', 'B', 10);
     $pdf->Cell(15, 6, utf8_decode('COD'), 1, 0, 'C', 1);
     $pdf->Cell(50, 6, utf8_decode('GRADO'), 1, 0, 'C', 1);
     $pdf->Cell(110, 6, utf8_decode('ARÉA/ASIGNATURA'), 1, 0, 'C', 1);
    $pdf->Cell(25, 6, utf8_decode('IHS'), 1, 0, 'C', 1);            
    $pdf->Ln();
  $sql = "SELECT c.idcarga, g.descripcion, a.nombre, c.ihs  FROM carga_academica c INNER JOIN personal p ON c.iddocente=p.idpersonal INNER JOIN asignaturas a ON c.idasignatura=a.idasignatura INNER JOIN grados g ON c.idgrado=g.idgrado WHERE c.iddocente='$docente' AND c.idsede='$sede' and a.nombre<>'DISCIPLINA' ORDER BY c.idgrado ASC";
    $res = $mysqli->query($sql); 
    $ac=0;
    $i=1;
    while ($reg = $res->fetch_row()) {
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(15, 6, utf8_decode($reg[0]), 1, 0, 'J', 1);
     $pdf->Cell(50, 6, utf8_decode($reg[1]), 1, 0, 'J', 1);
     $pdf->Cell(110, 6, utf8_decode($reg[2]), 1, 0, 'J', 1);
    $pdf->Cell(25, 6, utf8_decode($reg[3]), 1, 0, 'C', 1);
    $ac=$ac+$reg[3];
    $pdf->Ln();   
        $i++;
    }
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetX(75);
    $pdf->SetFillColor(232, 232, 232);
    $pdf->Cell(110, 6, utf8_decode('TOTAL HORAS: '), 1, 0, 'J', 1);
    $pdf->SetX(185);
    $pdf->SetFillColor(232, 232, 232);
     $pdf->Cell(25, 6, $ac, 1, 0, 'C', 1);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();  
     $pdf->Cell(70, 1, '' , 0, 1, 'J', 0);
        $pdf->Cell(70, 6, utf8_decode('VoBo '), 0, 1, 'J', 0);
         $pdf->Cell(70, 6, utf8_decode('Cordinador Académico '), 0, 1, 'J', 0);       
    $pdf->Cell(70, 6, date("d/m/Y"), 0, 1, 'J', 0);
  // Footer
      $pdf->SetY(310);    
    $pdf->SetFont('Arial','I',8);    
    $pdf->Cell(0,10,utf8_decode('Pagína N°: ').$pdf->PageNo(),0,0,'R');
    $pdf->Ln(3.5);
    $pdf->Cell(0,10,'Impreso por SIA INEDA 2020',0,0,'R');

    $pdf->Output();
}

?>
