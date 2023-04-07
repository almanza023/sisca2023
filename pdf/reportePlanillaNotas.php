<?php
$grado   = $_POST['grado'];
$sede   = $_POST['sede'];
$asignatura   = $_POST['asignaturas'];
$periodo   = $_POST['periodo'];

if (isset($grado) && isset($sede) && isset($asignatura) ) {
require_once "../../config/Conexion.php";
include "fpdf/fpdf.php";
date_default_timezone_set('UTC');
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
$sqlg="SELECT descripcion FROM grados WHERE idgrado='$grado' ";
$resg=$mysqli->query($sqlg);
$reg2=$resg->fetch_row();
$pdf->Cell(60, 4, 'GRADO: '.$reg2[0], 0, 0, 'J');
$sqla="SELECT nombre FROM asignaturas WHERE idasignatura='$asignatura' ";
$resa=$mysqli->query($sqla);
$rega=$resa->fetch_row();
$sqls="SELECT nombre FROM sedes WHERE idsede='$sede' ";
$ress=$mysqli->query($sqls);
$regs=$ress->fetch_row();
$sqld="SELECT p.nombres, p.apellidos FROM carga_academica c INNER JOIN personal p ON c.iddocente=p.idpersonal WHERE c.idasignatura='$asignatura' AND c.idsede='$sede' AND c.idgrado='$grado' ";
$resd=$mysqli->query($sqld);
$regd=$resd->fetch_row();
$pdf->Cell(100, 6, utf8_decode('ARÉA/ASIGNATURA: ').utf8_decode($rega[0]), 0, 0, 'J'); 
$pdf->Cell(130, 6, 'PERIODO: '.$periodo, 0, 0, 'J'); 
$pdf->SetY(48);
$pdf->Cell(120, 6, 'DOCENTE: '. utf8_decode($regd[0]).' '.utf8_decode($regd[1]), 0, 0, 'J');  
$pdf->SetY(48);
$pdf->SetX(103);
$pdf->Cell(20, 6, utf8_decode('SEDE: ').$regs[0], 0, 0, 'J');
$pdf->SetY(48);
$pdf->SetX(170);
$pdf->Cell(20, 6, utf8_decode('AÑO: 2020'), 0, 0, 'J');
$pdf->Ln(11);    
$pdf->Cell(200, 6, utf8_decode('PLANILLA DE NOTAS'), 1, 0, 'C', 1); 
$pdf->Ln(9);         
    $pdf->SetFont('Arial', 'B', 10);
     $pdf->Cell(8, 6, utf8_decode('N°'), 1, 0, 'C', 1);
     $pdf->Cell(100, 6, utf8_decode('ESTUDIANTES'), 1, 0, 'C', 1);
     $pdf->Cell(72, 6, utf8_decode('NOTAS '), 1, 0, 'C', 1); 
    $pdf->Cell(20, 6, utf8_decode('DEF'), 1, 0, 'C', 1);
    $pdf->Ln();
        $sql = "SELECT nombres, apellidos FROM estudiantes  WHERE  idsede='$sede' AND idgrado='$grado' AND estado='ACTIVO' order by apellidos ASC";
        
    $res = $mysqli->query($sql);
    $num1 = $res->num_rows;
    $i=0;      
    while ($reg = $res->fetch_row()) {
        $i++;
        $est=$reg[0].' '.$reg[1];       
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(8, 6, $i, 1, 0, 'J');
        $pdf->Cell(100, 6, utf8_decode($est), 1, 0, 'J');
        $pdf->Cell(12, 6, ' ', 1, 0, 'J');
        $pdf->Cell(12, 6, ' ', 1, 0, 'J');
        $pdf->Cell(12, 6, ' ', 1, 0, 'J');
        $pdf->Cell(12, 6, ' ', 1, 0, 'J');
        $pdf->Cell(12, 6, ' ', 1, 0, 'J');
        $pdf->Cell(12, 6, ' ', 1, 0, 'J');        
        $pdf->Cell(20, 6, ' ', 1, 0, 'J');
        $pdf->Ln();        
    }
       
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();  
    $pdf->SetFont('Arial','B',10); 
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
