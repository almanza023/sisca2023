<?php 
$sede   = $_POST['sede'];
$grado = $_POST['grado'];
$periodo = $_POST['periodo'];
require_once "../../config/Conexion.php";
include "fpdf/fpdf.php";
   $sql2 = "SELECT e.apellidos, e.nombres, g.descripcion, s.nombre, e.num_doc, e.folio, e.idgrado, e.idsede, e.estado, e.idestudiante FROM estudiantes e inner join grados g on g.idgrado=e.idgrado inner join sedes s on s.idsede=e.idsede where e.idgrado='$grado' and e.idsede='$sede' and e.estado='ACTIVO' order by e.apellidos asc ";   
    $res2 = $mysqli->query($sql2);
    $num1 = $res2->num_rows;  
    $i    = 1;
    $pdf  = new FPDF('P', 'mm', 'Legal');

while ($i <= $num1) {
while ($rege = $res2->fetch_row()) {
$idest=$rege[9];
$pdf->AddPage();
$pdf->SetFillColor(232, 232, 232);
$pdf->SetFont('Arial', 'B', 16);
$sqlc="SELECT * FROM datos_colegio ";
$resc=$mysqli->query($sqlc);
$regc=$resc->fetch_row();
$pdf->Cell(190, 6, utf8_decode($regc[1]), 0, 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(190, 4, utf8_decode($regc[2]), 0, 1, 'C');
$pdf->Cell(190, 4, utf8_decode(' Plantel de Carácter Oficial'), 0, 1, 'C');
$pdf->Cell(190, 4, utf8_decode(' Resolución N° 1072 Mayo 31/04 y 1566 Agosto 06/04'), 0, 1, 'C');
$pdf->Cell(190, 6, utf8_decode(' Código Icfes '.$regc[7]), 0, 1, 'C');
$pdf->Cell(190, 6, utf8_decode($regc[6]), 0, 1, 'C');
$pdf->Image('logo-ineda.png', 8, 6, 20);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, 6, utf8_decode(' INFORME DE DESEMPEÑOS'), 1, 1, 'C', 1);           
$pdf->SetFont('Arial', '', 10);            
$nom = $rege['0'] . ' ' . $rege['1'];
$pdf->Cell(113, 6, 'Nombres: ' . utf8_decode($nom), 1, 0, 'J');
$pdf->Cell(47, 6, 'Grado: ' . utf8_decode($rege['2']), 1, 0, 'J');
$pdf->Cell(30, 6, 'Periodo: ' . $periodo, 1, 1, 'J');
$pdf->Cell(40, 6, 'Sede: ' . $rege['3'], 1, 0, 'J');           
$pdf->Cell(40, 6, utf8_decode(' N° Doc: ') . $rege['4'], 1, 0, 'J');
$pdf->Cell(33, 6, utf8_decode(' N° Folio: ') . $rege['5'], 1, 0, 'J');
$pdf->Cell(47, 6, utf8_decode(' Jornada: MATINAL') , 1, 0, 'J');
$pdf->Cell(30, 6, utf8_decode(' Año: 2020 '), 1, 1, 'J');
$pdf->Ln(); 
$pdf->SetFont('Arial', 'B', 10); 
$pdf->Cell(8, 8, 'IHS ', 1, 0, 'C', 1);     
$pdf->SetFillColor(232, 232, 232);      
$pdf->Cell(183, 8, 'DIMENSIONES ', 1, 1, 'C', 1);
$pdf->Ln(2);
$sql  = "SELECT distinct  a.nombre, c.ihs,  l.descripcion, l2.descripcion, l3.descripcion,  p.idgrado, p.idsede from preescolar p inner join logros_preescolar l on p.logro_a=l.idlogro inner join logros_preescolar l2 on p.logro_b=l2.idlogro inner join logros_preescolar l3 on p.logro_c=l3.idlogro  inner join asignaturas a on p.iddimension=a.idasignatura inner join carga_academica c on p.iddimension=c.idasignatura   where p.idgrado='$grado' and p.idsede='$sede' and p.idestudiante='$idest' and p.periodo='$periodo'";
$res  = $mysqli->query($sql);
while ($reg = $res->fetch_row()) {            
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(8, 8, $reg[1], 1, 0, 'C', 0);  
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(232, 232, 232);  
$pdf->Cell(183, 8, $reg['0'], 1, 1, 'J',1);
$pdf->Ln(0.5);                
$pdf->SetFont('Arial', '', 10);              
$pdf->SetFillColor(255, 255, 255);
$pdf->MultiCell(191, 7,'* '. utf8_decode($reg['2']), 0, 1, 'J',1);
$pdf->MultiCell(191, 7,'* '. utf8_decode($reg['3']), 0, 1, 'J',1);
$pdf->MultiCell(191, 7,'* '. utf8_decode($reg['4']), 0, 1, 'J',1);             
}
if ($periodo==4) {
$pdf->Ln(5);
$pdf->SetFillColor(232, 232, 232);                    
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(191, 6, ' OBSERVACIONES FINALES', 1, 1, 'J', 1);
$pdf->SetFillColor(255, 255, 255);  
$sql6="SELECT idlogro FROM observaciones where idgrado='$grado' and idsede='$sede' and periodo='$periodo' and idestudiante='$idest'";
$res6=$mysqli->query($sql6);
while ($reg6=$res6->fetch_row()) {
	$idlog=$reg6[0];
$sql7="SELECT descripcion from logros_observaciones where idlogro='$idlog'";
$res7=$mysqli->query($sql7);
$reg7=$res7->fetch_row();
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(191, 8,utf8_decode($reg7['0']), 1, 1, 'J',0);
}
$pdf->Ln();
$pdf->Ln();         	
}else {
$pdf->SetFillColor(232, 232, 232);                    
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(191, 6, ' OBSERVACIONES', 1, 1, 'J', 1);
$pdf->SetFillColor(255, 255, 255); 
$pdf->Cell(191, 15, ' ', 1, 1, 'J', 1);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(80, 0, ' ', 1, 1, 'J');
$pdf->Ln();  
}         
$sql= "SELECT p.nombres, p.apellidos  from direccion_grado d inner join personal p on d.iddocente=p.idpersonal where d.idgrado='$grado' and d.idsede='$sede'";
$resa = $mysqli->query($sql);
$rega = $resa->fetch_row();                
$nom_ac=$rega['0'].' '.$rega['1'];
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, 4,utf8_decode($nom_ac) , 0, 1, 'J');            
$pdf->Cell(40, 6, ' Directora de Grupo', 0, 1, 'J');
// Footer
$pdf->SetY(320);    
$pdf->SetFont('Arial','I',8);    
$pdf->Cell(0,10,utf8_decode('Pagína N°: ').$pdf->PageNo(),0,0,'R');
$pdf->Ln(3.7);
$pdf->Cell(0,10,'Impreso por SIA INEDA 2020',0,0,'R');
}
$i++;
}

$pdf->Output();

?>