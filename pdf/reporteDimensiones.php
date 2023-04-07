<?php
$grado   = $_POST['grado'];
$dimen=$_POST['dimension'];
$sede   = $_POST['sede'];
$periodo   = $_POST['periodo'];
if (isset($grado) && isset($sede)  ) {
include "../../config/Conexion.php";
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
$sqla="SELECT nombre FROM asignaturas WHERE idasignatura='$dimen' ";
$resa=$mysqli->query($sqla);
$rega=$resa->fetch_row();
$sqls="SELECT nombre FROM sedes WHERE idsede='$sede' ";
$ress=$mysqli->query($sqls);
$regs=$ress->fetch_row();
$sqld="SELECT p.nombres, p.apellidos FROM carga_academica c INNER JOIN personal p ON c.iddocente=p.idpersonal WHERE c.idasignatura='$dimen' AND c.idsede='$sede' AND c.idgrado='$grado' ";
$resd=$mysqli->query($sqld);
$regd=$resd->fetch_row();
$pdf->Cell(100, 6, utf8_decode('DIMENSION: ').utf8_decode($rega[0]), 0, 0, 'J'); 
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
$pdf->Cell(200, 6, utf8_decode('LISTADO DE CALIFICACIÓN DIMENSIONES'), 1, 0, 'C', 1); 
$pdf->Ln(8);    
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 6, utf8_decode('N°'), 1, 0, 'C', 1);
$pdf->Cell(100, 6, utf8_decode('ESTUDIANTES'), 1, 0, 'J', 1);
$pdf->Cell(23, 6, utf8_decode('LOGRO N° 1'), 1, 0, 'J', 1);
$pdf->Cell(22, 6, utf8_decode('LOGRO N° 2'), 1, 0, 'J', 1);
$pdf->Cell(22, 6, utf8_decode('LOGRO N° 3'), 1, 0, 'J', 1);
$pdf->Cell(23, 6, utf8_decode('LOGRO N° 4'), 1, 0, 'J', 1);    
$pdf->Ln();
$sql = "SELECT e.apellidos, e.nombres, p.logro_a, p.logro_b, p.logro_c, p.logro_d from preescolar p INNER JOIN estudiantes e ON p.idestudiante=e.idestudiante where p.idgrado='$grado' and p.iddimension='$dimen' and p.periodo='$periodo' and p.idsede='$sede' order by e.apellidos";
        
    $res = $mysqli->query($sql);
    $num1 = $res->num_rows;
    $i=0;
    $ac=0;
    while ($reg = $res->fetch_row()) {
        $i++;
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 6, $i, 1, 0, 'J');
        $pdf->Cell(100, 6, utf8_decode($reg['0'].' '.$reg['1']), 1, 0, 'J');
        $pdf->Cell(23, 6, $reg[2], 1, 0, 'J');
        $pdf->Cell(22, 6, $reg[3], 1, 0, 'J');
        $pdf->Cell(22, 6, $reg[4], 1, 0, 'J');
        $pdf->Cell(23, 6, $reg[5], 1, 0, 'J');
        $pdf->Ln();
       
        
    }
    
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();   $pdf->Cell(70, 1, '' , 0, 1, 'J', 0);
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
    

}
?>
