<?php
$grado   = $_POST['grado'];
$sede   = $_POST['sede'];
$asignatura   = $_POST['asignaturas'];
$nulo=0;
$acu=0;
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
$pdf->SetX(95);
$pdf->Cell(100, 6, utf8_decode('ARÉA/ASIGNATURA: ').utf8_decode($rega[0]), 0, 0, 'J');
$pdf->SetY(48);
$pdf->Cell(120, 6, 'DOCENTE: '. utf8_decode($regd[0]).' '.utf8_decode($regd[1]), 0, 0, 'J');  
$pdf->SetY(48);
$pdf->SetX(103);
$pdf->Cell(20, 6, utf8_decode('SEDE: ').$regs[0], 0, 0, 'J');
$pdf->SetY(48);
$pdf->SetX(170);
$pdf->Cell(20, 6, utf8_decode('AÑO: 2020'), 0, 0, 'J');
$pdf->Ln(11);    
$pdf->Cell(200, 6, utf8_decode('LISTADO DE NOTAS ACUMULATIVAS'), 1, 0, 'C', 1); 
$pdf->Ln(8);             
    $pdf->SetFont('Arial', 'B', 10);
     $pdf->Cell(7, 6, utf8_decode('N°'), 1, 0, 'C', 1);
     $pdf->Cell(85, 6, utf8_decode('ESTUDIANTES'), 1, 0, 'C', 1);
    $pdf->Cell(12, 6, utf8_decode('P1'), 1, 0, 'C', 1);
    $pdf->Cell(12, 6, utf8_decode('NP1'), 1, 0, 'C', 1);
    $pdf->Cell(12, 6, utf8_decode('P2'), 1, 0, 'C', 1);
    $pdf->Cell(12, 6, utf8_decode('NP2'), 1, 0, 'C', 1);
    $pdf->Cell(12, 6, utf8_decode('P3'), 1, 0, 'C', 1);
    $pdf->Cell(12, 6, utf8_decode('NP3'), 1, 0, 'C', 1);
    $pdf->Cell(12, 6, utf8_decode('P4'), 1, 0, 'C', 1);
    $pdf->Cell(12, 6, utf8_decode('NP4'), 1, 0, 'C', 1);
    $pdf->Cell(12, 6, utf8_decode('DEF'), 1, 0, 'C', 1);    
    $pdf->Ln();
    $sql = "SELECT idestudiante, apellidos, nombres from estudiantes where idgrado='$grado' and idsede='$sede' order by apellidos";
    $res = $mysqli->query($sql);  
    $i=1; 
    $pdf->SetFont('Arial', '', 10);  
    $c=0;
    $a1=0;
    $a2=0;
    $a3=0;
    $a4=0;
    while ($reg = $res->fetch_row()) {
        $pdf->SetFillColor(255, 255, 255);
        $idest=$reg['0'];
        $ape=$reg['1'];
        $nom=$reg['2'];
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(7, 6, $i, 1, 0, 'J');        
        $pdf->Cell(85, 6, utf8_decode($ape.' '.$nom), 1, 0, 'J');          
        $i++;
    $sql1="SELECT nota from calificaciones where idestudiante='$idest'  and idasignatura='$asignatura' and periodo='1' and idsede='$sede'";
    $resp1=$mysqli->query($sql1);
    $num1=$resp1->num_rows;
    if($num1>0){
    while ($regp1=$resp1->fetch_row()) {
        $notap1=$regp1['0'];
        $acu1=$acu1+$notap1;
        $pdf->Cell(12, 6, $notap1, 1, 0, 'J'); 
        $c=1;
        $a1++;
    }
    } else {
        $pdf->Cell(12, 6, $nulo, 1, 0, 'J'); 
       $acu=$acu+$nulo;
    }
     $sqln1="SELECT nota from nivelaciones where idestudiante='$idest' and idasignatura='$asignatura' and periodo='1' and idsede='$sede'";
    $respn1=$mysqli->query($sqln1);
    $numn1=$respn1->num_rows;
    if($numn1>0){
    while ($regpn1=mysqli_fetch_array($respn1)) {
        $notan1=$regpn1['0'];
        if(isset($notan1)){
              $acu1=0;
              $acu1=$acu1+$notan1;
              $c=1;
              $a1++;
        }
        $pdf->Cell(12, 6, $notan1, 1, 0, 'J'); 
       
    }
    } else {
        $pdf->Cell(12, 6, $nulo, 1, 0, 'J'); 
       $acu1=$notap1;
    }
     
    $sql2="SELECT nota from calificaciones where idestudiante='$idest'  and idasignatura='$asignatura' and periodo='2' and idsede='$sede'";
    $resp2=$mysqli->query($sql2);
    $num2=$resp2->num_rows;
    if ($num2>0) {
     while ($regp2=$resp2->fetch_row()) {
        $notap2=$regp2['0'];
        $pdf->Cell(12, 6, $notap2, 1, 0, 'J'); 
        $acu2=$acu2+$notap2;
        $c=2;
        $a2++;
    }
    } else {
       $pdf->Cell(12, 6, $nulo, 1, 0, 'J');
       $acu2=$acu2-$nulo;
    }
     $sqln2="SELECT nota from nivelaciones where idestudiante='$idest' and idasignatura='$asignatura' and periodo='2' and idsede='$sede' ";
    $respn2=$mysqli->query($sqln2);
    $numn2=$respn2->num_rows;
    if($numn2>0){
    while ($regpn2=$respn2->fetch_row()) {
        $notan2=$regpn2['0'];
       if(isset($notan2)){
           $acu2=0;
              $acu2=$acu2+$notan2;
              $c=2;
              $a2++;
        }
        $pdf->Cell(12, 6, $notan2, 1, 0, 'J'); 
      
    }
    } else {
        $pdf->Cell(12, 6, $nulo, 1, 0, 'J'); 
       $acu2=$notap2;
      
    }
    
    $sql3="SELECT nota from calificaciones where idestudiante='$idest'  and idasignatura='$asignatura' and periodo='3' and idsede='$sede' ";
    $resp3=$mysqli->query($sql3);
    $num3=$resp3->num_rows;
    if ($num3>0) {
       while ($regp3=mysqli_fetch_array($resp3)) {
        $notap3=$regp3['0'];
        $acu3=$acu3+$notap3;
        $pdf->Cell(12, 6, $notap3, 1, 0, 'J'); 
        $c=3;
        $a3++;
    }
    } else {
      $pdf->Cell(12, 6, $nulo, 1, 0, 'J'); 
      $acu3=$acu3+$nulo;
    }   
    $sqln3="SELECT nota from nivelaciones where idestudiante='$idest' and idasignatura='$asignatura' and periodo='3' and idsede='$sede'  ";
    $respn3=$mysqli->query($sqln3);
    $numn3=$respn3->num_rows;
    if($numn3>0){
    while ($regpn3=mysqli_fetch_array($respn3)) {
        $notan3=$regpn3['0'];
       if(isset($notan3)){
           $acu3=0;
              $acu3=$acu3+$notan3;
              $c=3;
              $a3++;
        }
        $pdf->Cell(12, 6, $notan3, 1, 0, 'J'); 
        $c=3;
    }
    } else {
        $pdf->Cell(12, 6, $nulo, 1, 0, 'J'); 
       $acu3=$notap3;
    }
    
    $sql4="SELECT nota from calificaciones where idestudiante='$idest'  and idasignatura='$asignatura' and periodo='4' and idsede='$sede' ";
    $resp4=$mysqli->query($sql4);
    $num4=$resp4->num_rows;
    if ($num4>0) {
     while ($regp4=mysqli_fetch_array($resp4)) {
        $notap4=$regp4['0'];
        $acu4=$acu4+$notap4;
        $pdf->Cell(12, 6, $notap4, 1, 0, 'J'); 
        $c=4;
        $a4++;
    }
    } else {
      $pdf->Cell(12, 6, $nulo, 1, 0, 'J'); 
      $acu4=$acu4+$nulo;
    }
    $sqln4="SELECT nota from nivelaciones where idestudiante='$idest' and idasignatura='$asignatura' and periodo='4' and idsede='$sede' ";
    $respn4=$mysqli->query($sqln4);
    $numn4=$respn4->num_rows;
    if($numn4>0){
    while ($regpn4=mysqli_fetch_array($respn4)) {
        $notan4=$regpn4['0'];
       if(isset($notan4)){
           $acu4=0;
              $acu4=$acu4+$notan4;
              $c=4;
              $a4++;
        }
        $pdf->Cell(12, 6, $notan4, 1, 0, 'J'); 
        $c=1;
    }
    } else {
        $pdf->Cell(12, 6, $nulo, 1, 0, 'J'); 
       $acu4=$notap4;
       
    }
    $prom=($acu1+$acu2+$acu3+$acu4)/$c;
    $p1=$p1+$acu1;
    $p2=$p2+$acu2;
    $p3=$p3+$acu3;
    $p4=$p4+$acu4;
    if($p1>0 && $a1>0){
      $npr1=$p1/$a1;  
    }
    if($p2>0 && $a2>0){
     $npr2=$p2/$a2;
    }
    if($p3>0 && $a3>0){
      $npr3=$p3/$a3;  
    }
    if($p4>0 && $a4>0){
      $npr4=$p4/$a4;  
    }    
    if ($npr1>0) {
        $np1=round($npr1,1);
    }else {
        $np1=0;
    }
    if ($npr2>0) {
         $np2=round($npr2,1);
    }else {
        $np2=0;
    }
   if ($npr3>0) {
         $np3=round($npr3,1);
    }else {
        $np3=0;
    }
    if ($npr4>0) {
          $np4=round($npr4,1);
    }else {
        $np4=0;
    }
   
   
    $nprom=round($prom, 1);  
    $pf=$np1+$np2+$np3+$np4;
    $npf=$pf/4;
    $pfinal=round($npf, 1 ); 
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(12, 6, $nprom, 1, 1, 'J',1); 
      $pdf->SetFont('Arial', '', 10);
    }
    $pdf->SetFillColor(232, 232, 232);
    $pdf->SetFont('Arial', 'B', 10);    
    $pdf->Cell(7, 6, '', 0, 0, 'C',0);
    $pdf->Cell(85, 6, 'PROMEDIOS', 1, 0, 'C',1);
    $pdf->SetX(102);
    $pdf->Cell(24, 6, $np1, 1, 0, 'C',1);   
    $pdf->SetX(126);
    $pdf->Cell(24, 6, $np2, 1, 0, 'C',1); 
    $pdf->SetX(150);
    $pdf->Cell(24, 6, $np3, 1, 0, 'C',1);
    $pdf->SetX(174);
    $pdf->Cell(24, 6, $np4, 1, 0, 'C',1);
    $pdf->SetX(198);
    $pdf->Cell(12, 6, $pfinal, 1, 0, 'C',1); 
    $pdf->SetX(130);
    $pdf->SetFont('Arial', 'B', 10);
      $pdf->SetFillColor(232, 232, 232);  
    $pdf->Ln(15); 
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
$pdf->Output();
}

?>
