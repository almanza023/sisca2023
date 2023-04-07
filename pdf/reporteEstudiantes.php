<?php
$grado   = $_POST['grado'];
$sede    = $_POST['sede'];
date_default_timezone_set("UTC");  
if (isset($grado) && isset($sede) ) {
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
$sqlg="SELECT descripcion FROM grados WHERE idgrado='$grado' ";
$resg=$mysqli->query($sqlg);
$reg2=$resg->fetch_row();
$sqls="SELECT nombre FROM sedes WHERE idsede='$sede' ";
$ress=$mysqli->query($sqls);
$regs=$ress->fetch_row();
$pdf->Cell(60, 4, 'GRADO: '.$reg2[0], 0, 0, 'J');
$sqld="SELECT e.apellidos, e.nombres, e.tipo_doc, e.num_doc, e.fecha_nac, e.folio, e.estado FROM estudiantes e  where e.idgrado='$grado' and e.idsede='$sede' order by e.apellidos asc   ";
$resd=$mysqli->query($sqld);
$pdf->Cell(100, 6, 'SEDE: '.utf8_decode($regs[0]), 0, 0, 'J'); 
$pdf->SetY(42);
$pdf->SetY(42);
$pdf->SetX(170);
$pdf->Cell(20, 6, utf8_decode('AÑO: 2020'), 0, 0, 'J');
$pdf->Ln(15);
$pdf->Cell(200, 6, utf8_decode('INFORMACIÓN DE ESTUDIANTES'), 1, 0, 'C', 1);
$pdf->Ln(8);        
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(5, 6, utf8_decode('N°'), 1, 0, 'C', 1);
     $pdf->Cell(50, 6, utf8_decode('APELLIDOS'), 1, 0, 'C', 1);
     $pdf->Cell(50, 6, utf8_decode('NOMBRES'), 1, 0, 'C', 1);
     $pdf->Cell(12, 6, utf8_decode('T.DOC'), 1, 0, 'C', 1);
    $pdf->Cell(23, 6, utf8_decode('N° DOC'), 1, 0, 'C', 1);
    $pdf->Cell(25, 6, utf8_decode('FECHA NAC'), 1, 0, 'C', 1);  
    $pdf->Cell(15, 6, utf8_decode('FOLIO'), 1, 0, 'C', 1);   
    $pdf->Cell(20, 6, utf8_decode('ESTADO'), 1, 0, 'C', 1);
    $pdf->Ln();
    $i=1;   
    while ($regd=$resd->fetch_row()) {

$pdf->SetFont('Arial', '', 9);

$pdf->Cell(5, 6, utf8_decode($i), 1, 0, 'J');

$pdf->Cell(50, 6, utf8_decode($regd[0]), 1, 0, 'J');

$pdf->Cell(50, 6, utf8_decode($regd[1]), 1, 0, 'J');

$pdf->Cell(12, 6, utf8_decode($regd[2]), 1, 0, 'J' );
$pdf->Cell(23, 6, utf8_decode($regd[3]), 1, 0, 'J' );
$pdf->Cell(25, 6, utf8_decode($regd[4]), 1, 0, 'J');  
$pdf->Cell(15, 6, utf8_decode($regd[5]), 1, 0, 'J' );   
$pdf->Cell(20, 6, utf8_decode($regd[6]), 1, 0, 'J' );
$pdf->Ln(); 

$i++;
    }
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
    $pdf->Ln();
    $pdf->Cell(0,10,'Impreso por SIA INEDA 2020',0,0,'R');
    $pdf->Output();
    $mysqli->close();
}
?>
