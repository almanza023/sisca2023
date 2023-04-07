<?php

$jornada ='MATINAL';
$grado   = $_POST['grado'];
$periodo = $_POST['periodo'];
$sede = $_POST['sede'];
$promedios = array();

if (isset($jornada) && isset($grado) && isset($periodo)  && isset($sede)) {
    require_once "../../config/Conexion.php";
    include "fpdf/fpdf.php";

    $sql  = "SELECT  e.idestudiante, e.nombres, e.apellidos, g.descripcion, s.nombre from estudiantes e  inner join grados g on e.idgrado=g.idgrado inner join sedes s on e.idsede=s.idsede  where e.idgrado='$grado'  and  e.idsede='$sede' and e.estado='ACTIVO' order by e.apellidos asc";    
    $sqlg="SELECT descripcion from grados where idgrado='$grado'";
    $resgr=$mysqli->query($sqlg);
    $reggr=$resgr->fetch_row();
  $sqls="SELECT nombre from sedes where idsede='$sede'";
    $ress=$mysqli->query($sqls);
    $regs=$ress->fetch_row();
    $pdf = new FPDF('L', 'mm', 'Legal');
    $pdf->AddPage();
    $pdf->SetFillColor(232, 232, 232);
     $sqlc="SELECT * FROM datos_colegio ";
            $resc=$mysqli->query($sqlc);
            $regc=$resc->fetch_row();
            $pdf->SetX(94);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetX(94);
            $pdf->Cell(190, 6, utf8_decode($regc[1]), 0, 1, 'C');
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetX(94);
            $pdf->Cell(190, 4, utf8_decode($regc[2]), 0, 1, 'C');
            $pdf->SetX(94);
            $pdf->Cell(190, 4, utf8_decode(' Plantel de Carácter Oficial'), 0, 1, 'C');
            $pdf->SetX(94);
            $pdf->Cell(190, 4, utf8_decode(' Resolución N° 1072 Mayo 31/04 y 1566 Agosto 06/04'), 0, 1, 'C');
            $pdf->SetX(94);
            $pdf->Cell(190, 6, utf8_decode(' Código Icfes '.$c[7]), 0, 1, 'C');
            $pdf->SetX(94);
            $pdf->Cell(190, 6, utf8_decode($regc[6]), 0, 1, 'C');
            $pdf->Image('logo-ineda.png', 8, 6, 20);
            $pdf->SetFont('Arial', 'B', 10);          
            $pdf->Ln(2);
    $pdf->SetFont('Arial', 'B', 12);   
    $pdf->Cell(370, 5, 'CONSOLIDADO DE NOTAS ', 0, 1, 'C');       
      $pdf->Cell(320, 10, '', 1, 0, 'J'); 
     $pdf->Ln(2);
      
    $pdf->SetFont('Arial', 'B', 10);
   
    $pdf->Cell(140, 6, 'GRADO: '.$reggr[0], 0, 0, 'J');
    $pdf->Cell(120, 6, 'SEDE: '.$regs[0], 0, 0, 'J');
    $pdf->Cell(140, 6, 'PERIODO: '.$periodo, 0, 0, 'J');
    $pdf->Cell(140, 6, utf8_decode('Año: 2018'), 0, 0, 'J');
    $pdf->Ln(10);
    
   
    $pdf->Cell(8, 5, utf8_decode('N°'), 1, 0, 'C', 1);
    $pdf->Cell(72, 5, 'ESTUDIANTES', 1, 0, 'C', 1); 
        $pdf->SetFont('Arial', 'B', 8);   
         
     //Otras Materias
    $sqlp7 = "SELECT distinct  a.acronimo, a.idasignatura from asignaturas a inner join calificaciones c on a.idasignatura=c.idasignatura where c.idgrado='$grado' and c.periodo='$periodo'  order by orden asc ";
            $resp7 = $mysqli->query($sqlp7);
            while ( $regp7 = $resp7->fetch_row()) {
                $pdf->SetFont('Arial', 'B', 8);
                $asig=$regp7['0'];                       
            $pdf->Cell(15, 5, $asig,  1, 0, 'J', 1);
          }
    $pdf->Cell(15, 5, 'PER',  1, 0, 'J');
    $pdf->Cell(15, 5, 'GAN',  1, 0, 'J');
    $pdf->Cell(15, 5, 'PROM',  1, 0, 'J', 1);
      $pdf->Ln();
    $i=1;
    $res  = $mysqli->query($sql);
     while ($reg1 = $res->fetch_row()) {
      $sqla = "SELECT distinct  a.idasignatura from asignaturas a inner join calificaciones c on a.idasignatura=c.idasignatura where c.idgrado='$grado' and c.periodo='$periodo'  order by orden asc ";
      $respa = $mysqli->query($sqla);
      $regpa = $respa->fetch_row();
       $idasig= $regpa['0'];
      $ac=0;
    $c1=0;
    $c2=0;
    $c3=0;
    $c4=0;
    $c5=0;
    $c6=0;
    $cp=0;
    $cg=0;
    $acom=0;
    $mat=0;
    $cn=0;
    $fil=0;
    $et=0;
    $len=0;
    $numn1=0;
    $notaNC=0;
    $notac=0;
    $notaf=0;
    $notaNf=0;
        $pdf->SetFont('Arial', '', 8);
        $idest=$reg1['0'];
        $nom = $reg1['2'] . ' ' . $reg1['1'];       
        $pdf->Cell(8, 5, $i, 1, 0, 'J');
        $pdf->Cell(72, 5, utf8_decode($nom), 1, 0, 'J');        

//Otras Materias
            $numn1=0;
            $notaNo=0;
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='$periodo'   order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $ida=$regp7['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c6++;
                $notao=$regp7['0'];
                $npo=$notao*$por;
               if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' ";
                  $resno=$mysqli->query($sqlno);
                  $regno=$resno->fetch_row();
                  $notaNo=$regno[0];
                  $ntpo=$notaNo*$por;
                } else {
                   $cg++;
                }
                if (!empty($notaNo)) {
                 $pdf->Cell(15, 5, $notaNo, 1,0 , 'J');           
                 $acom=$acom+$notaNo;  
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {
                  $pdf->Cell(15, 5, $notao, 1,0 , 'J', 1);
                  $acom=$acom+$notao;                 
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(15, 5, '0', 1,0 , 'J');
    }         
      if( $acom>0 ){
        $prom=($acom)/($c6);
      }
			$rprom=round($prom, 1);
			$promedios[$nom]=($rprom );
			$pdf->Cell(15, 5, $cp, 1,0 , 'J',0);
			$pdf->Cell(15, 5, $cg, 1,0 , 'J',0);
      $pdf->Cell(15, 5, $rprom, 1,0 , 'J',1);
             
$pdf->Ln(); 
$i++;














































    }

	$pdf->Ln(); 
	
	arsort($promedios);
	$a=0;
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(92, 5, "PUESTOS", 1,1 , 'C',1);
	$pdf->SetFont('Arial', '', 8);
	$acval=0;
foreach ($promedios as $key => $val) {
	$a++;
	$pdf->Cell(8, 5, $a, 1,0 , 'J',0);
	$pdf->Cell(72, 5, "$key ", 1,0 , 'J',0);   
	$pdf->Cell(12, 5, "$val ", 1,1 , 'J',0); 
	$acval=$acval+$val;
}
$promg=$acval/$a;
$pdf->SetFont('Arial', 'B', 8);
$rpromg=round($promg, 1);
$pdf->Cell(80, 5, "PROMEDIO GENERAL DE GRADO ", 1,0 , 'C',1);
$pdf->Cell(12, 5, "$rpromg ", 1,1 , 'C',0);
$pdf->Ln(); 
$pdf->Ln(); 


    $pdf->Output();

}
