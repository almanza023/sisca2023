<?php
$jornada ='MATINAL';
$grado   = $_POST['grado'];;
$periodo = $_POST['periodo'];
$sede = $_POST['sede'];
$promedios = array();

require_once "../php/Conexion.php";
include "fpdf/fpdf.php";
$sql  = "SELECT  e.idestudiante, e.nombres, e.apellidos, g.descripcion, s.nombre from estudiantes e  inner join grados g on e.idgrado=g.idgrado inner join sedes s on e.idsede=s.idsede  where e.idgrado='$grado'  and  e.idsede='$sede' and e.estado='ACTIVO' order by e.apellidos asc";    
$sqlg="SELECT descripcion from grados where idgrado='$grado'";
$resgr=$mysqli->query($sqlg);
$reggr=$resgr->fetch_row();
$sqls="SELECT nombre from sedes where idsede='$sede'";
$ress=$mysqli->query($sqls);
$regs=$ress->fetch_row();
$pdf = new FPDF('L', 'mm', 'Legal');
$pdf->SetAutoPageBreak(true,45);
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
    $pdf->Cell(370, 5, 'SABANA FINAL ', 0, 1, 'C');       
      $pdf->Cell(320, 10, '', 1, 0, 'J'); 
     $pdf->Ln(2);
      
    $pdf->SetFont('Arial', 'B', 10);
   
    $pdf->Cell(140, 6, 'GRADO: '.$reggr[0], 0, 0, 'J');
    $pdf->Cell(120, 6, 'SEDE: '.$regs[0], 0, 0, 'J');   
    $pdf->Cell(140, 6, utf8_decode('Año: 2018'), 0, 0, 'J');
    $pdf->Ln(5);
  	$pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(80, 6, '', 0, 'C', 1);
    $pdf->Ln();
     $pdf->SetX(75);
    $pdf->Cell(30, 5, 'MAT', 1, 0, 'C', 1);
    $pdf->SetX(105);
    $pdf->Cell(30, 5, 'HUM', 1, 0, 'C', 1); 
    $pdf->SetX(135);
    $pdf->Cell(30, 5, 'CNAT', 1, 0, 'C', 1); 
    $pdf->SetX(165);
    $pdf->Cell(30, 5, 'CSOC', 1, 0, 'C', 1); 
     $sqlp7 = "SELECT distinct  a.acronimo, a.idasignatura from asignaturas a inner join calificaciones c on a.idasignatura=c.idasignatura where c.idgrado='$grado' and orden>=5 order by orden asc ";
            $resp7 = $mysqli->query($sqlp7);
            while ( $regp7 = $resp7->fetch_row()) {
                $pdf->SetFont('Arial', 'B', 8);
                $asig=$regp7['0'];                       
            $pdf->Cell(30, 5, $asig,  1, 0, 'J', 1);       
          }
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 6.5);
    $pdf->Cell(5, 5, utf8_decode('N°'), 1, 0, 'C', 1);
    $pdf->Cell(60, 5, 'ESTUDIANTES', 1, 0, 'C', 1); 
        $pdf->SetFont('Arial', 'B', 8);
//Matematicas     
        $pdf->Cell(5, 5, '1',  1, 0, 'J');
        $pdf->Cell(5, 5, '2',  1, 0, 'J');
        $pdf->Cell(5, 5, '3',  1, 0, 'J');
        $pdf->Cell(5, 5, '4',  1, 0, 'J');
        $pdf->Cell(5, 5, 'D',  1, 0, 'J',1);
        $pdf->Cell(5, 5, 'N',  1, 0, 'J', 1); 
    //Lenguaje  
        $pdf->Cell(5, 5, '1',  1, 0, 'J');
        $pdf->Cell(5, 5, '2',  1, 0, 'J');
        $pdf->Cell(5, 5, '3',  1, 0, 'J');
        $pdf->Cell(5, 5, '4',  1, 0, 'J');
        $pdf->Cell(5, 5, 'D',  1, 0, 'J',1);
        $pdf->Cell(5, 5, 'N',  1, 0, 'J', 1);      
    //Ciencias naturales    
        $pdf->Cell(5, 5, '1',  1, 0, 'J');
        $pdf->Cell(5, 5, '2',  1, 0, 'J');
        $pdf->Cell(5, 5, '3',  1, 0, 'J');
        $pdf->Cell(5, 5, '4',  1, 0, 'J');
        $pdf->Cell(5, 5, 'D',  1, 0, 'J',1);
        $pdf->Cell(5, 5, 'N',  1, 0, 'J', 1);  
    //Filosofia    
        $pdf->Cell(5, 5, '1',  1, 0, 'J');
        $pdf->Cell(5, 5, '2',  1, 0, 'J');
        $pdf->Cell(5, 5, '3',  1, 0, 'J');
        $pdf->Cell(5, 5, '4',  1, 0, 'J');
        $pdf->Cell(5, 5, 'D',  1, 0, 'J',1);
        $pdf->Cell(5, 5, 'N',  1, 0, 'J', 1);  
     //Otras Materias
    $sqlp7 = "SELECT distinct  a.acronimo, a.idasignatura from asignaturas a inner join calificaciones c on a.idasignatura=c.idasignatura where c.idgrado='$grado'  and orden>=5 order by orden asc ";
            $resp7 = $mysqli->query($sqlp7);
            while ( $regp7 = $resp7->fetch_row()) {
                $pdf->SetFont('Arial', 'B', 6.5);
                $asig=$regp7['0'];                       
        $pdf->Cell(5, 5, '1',  1, 0, 'J');
        $pdf->Cell(5, 5, '2',  1, 0, 'J');
        $pdf->Cell(5, 5, '3',  1, 0, 'J');
        $pdf->Cell(5, 5, '4',  1, 0, 'J');
        $pdf->Cell(5, 5, 'D',  1, 0, 'J',1);
        $pdf->Cell(5, 5, 'N',  1, 0, 'J', 1);  
          }
      
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
    $acm=0;
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
        $pdf->SetFont('Arial', '', 6.5);
        $idest=$reg1['0'];
        $nom = utf8_decode($reg1['2'] . ' ' . $reg1['1']);       
        $pdf->Cell(5, 5, $i, 1, 0, 'J');
        $pdf->Cell(60, 5, utf8_decode($nom), 1, 0, 'J');
         $sqlp2 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='1' and orden>1 and orden<2  order by orden asc";         

            $resp2 = $mysqli->query($sqlp2);
            while ( $regp2 = $resp2->fetch_row()) {
              $ida=$regp2['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c1=1;
                $notam=$regp2['0'];
                $npm=$notam*$por;
                if (empty($notam)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else   if($notam>=1 && $notam<=2.9){
                  $sqln="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='1'";
                  $resn=$mysqli->query($sqln);
                  $regn=$resn->fetch_row();
                  $notaN=$regn[0];
                  $ntpm=$notaNm*$por;
                } 
                if (!empty($notaNm)) {                               
                 $mat1=$mat1+$ntpm;                 
                } else {                               
                 $mat1=$mat1+$npm;                
                }                       
            }
           
//SEGUNDO PERIODO
$notaNm=0;
$ntpm=0;
 $sqlp2 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and orden>1 and orden<2  order by orden asc";         

            $resp2 = $mysqli->query($sqlp2);
            while ( $regp2 = $resp2->fetch_row()) {
              $ida=$regp2['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c1=1;
                $notam=$regp2['0'];
                $npm=$notam*$por;
                if (empty($notam)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else   if($notam>=1 && $notam<=2.9){
                  $sqln="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='2'";
                  $resn=$mysqli->query($sqln);
                  $regn=$resn->fetch_row();
                  $notaNm=$regn[0];
                  $ntpm=$notaNm*$por;
                } 
                if (!empty($notaNm)) {                               
                 $mat2=$mat2+$ntpm;                 
                } else {                               
                 $mat2=$mat2+$npm;                
                }                       
            }
//TERCER PERIODO
 $sqlmp3 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='3' and orden>1 and orden<2  order by orden asc";         

            $resmp3 = $mysqli->query($sqlmp3);
            while ( $regmp3 = $resmp3->fetch_row()) {
              $ida=$regmp3['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c1=1;
                $notam=$regmp3['0'];
                $npm=$notam*$por;
                if (empty($notam)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else   if($notam>=1 && $notam<=2.9){
                  $sqln="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='3'";
                  $resn=$mysqli->query($sqln);
                  $regn=$resn->fetch_row();
                  $notaNm=$regn[0];
                  $ntpm=$notaNm*$por;
                } 
                if (!empty($notaNm)) {                               
                 $mat3=$mat3+$ntpm;                 
                } else {                               
                 $mat3=$mat3+$npm;                
                }                       
            }
//cuarto PERIODO
 $sqlmp3 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='4' and orden>1 and orden<2  order by orden asc";         

            $resmp3 = $mysqli->query($sqlmp3);
            while ( $regmp3 = $resmp3->fetch_row()) {
              $ida=$regmp3['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c1=1;
                $notam=$regmp3['0'];
                $npm=$notam*$por;
                if (empty($notam)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else   if($notam>=1 && $notam<=2.9){
                  $sqln="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='4'";
                  $resn=$mysqli->query($sqln);
                  $regn=$resn->fetch_row();
                  $notaNm=$regn[0];
                  $ntpm=$notaNm*$por;
                } 
                if (!empty($notaNm)) {                               
                 $mat4=$mat4+$ntpm;                 
                } else {                               
                 $mat4=$mat4+$npm;                
                }                       
            }
            $pmat=round(($mat1+$mat2+$mat3+$mat4)/4,1);
            if($pmat<3){
              $cp=$cp+1;
            $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='FINAL'";
             $resnf=$mysqli->query($sqlnf);
            $regf=$resnf->fetch_row();
            
            if (!empty($regf[0])) {
            	$notaNF=$regf[0];            	
            }else {            	
            	$notaNF=0;
            }
            } else {
              $cg=$cg+1;
            } 
            $pdf->SetFont('Arial', '', 6.5);
            $pdf->Cell(5, 5, round($mat1,1),  1, 0, 'J', 0); 
            $pdf->Cell(5, 5, round($mat2,1),  1, 0, 'J', 0);
            $pdf->Cell(5, 5, round($mat3,1),  1, 0, 'J', 0); 
            $pdf->Cell(5, 5, round($mat4,1),  1, 0, 'J', 0);  
            $pdf->SetFont('Arial', 'B', 6.5);
            if($notaNF>0){
             $pdf->Cell(5, 5, round($pmat,1), 1,0 , 'J');
             $acm=$acm+$notaNF;
            $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J',1);            	
            }else {
            	$acm=$acm+$pmat;
             $pdf->Cell(5, 5, round($pmat,1), 1,0 , 'J',1);
            $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J');	
           }


            $mat1=0;
            $mat2=0;
            $mat3=0;
            $mat4=0;
            $notaNF=0;
            $pmat=0;
            $notaNm=0;
            
//Lenguaje
$notaNl=0;
$sqlp3 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='1' and orden>2 and orden<3  order by orden asc";

            $resp3 = $mysqli->query($sqlp3);
$numn3=$resp3->num_rows;
  if ($numn3>0) {  
            while ( $regp3 = $resp3->fetch_row()) {
              $ida=$regp3['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c2=1;
                $notal=$regp3['0'];
                $npl=$notal*$por;
              if($notal>=1 && $notal<=2.9){
              $sqlnl="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo=1";
                  $resnl=$mysqli->query($sqlnl);
                  $regnl=$resnl->fetch_row();
                  $notaNl=$regnl[0];
                  $ntpl=$notaNl*$por;
                } 
                if (!empty($notaNl)) {                             
                 $len1=$len1+$ntpl;                 
                } else {
                  $len1=$len1+$npl;                             
                }                       
            }           
          }else {
             $pdf->Cell(5, 5, '0', 1,0 , 'J');
          }
            
//SEGUNDO PERIODO 
$sqlp3 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and orden>2 and orden<3  order by orden asc";

            $resp3 = $mysqli->query($sqlp3);
$numn3=$resp3->num_rows;
  if ($numn3>0) {  
            while ( $regp3 = $resp3->fetch_row()) {
              $ida=$regp3['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c2=1;
                $notal=$regp3['0'];
                $npl=$notal*$por;
              if($notal>=1 && $notal<=2.9){
              $sqlnl="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo=2";
                  $resnl=$mysqli->query($sqlnl);
                  $regnl=$resnl->fetch_row();
                  $notaNl=$regnl[0];
                  $ntpl=$notaNl*$por;
                } 
                if (!empty($notaNl)) {                             
                 $len2=$len2+$ntpl;                 
                } else {
                  $len2=$len2+$npl;                             
                }                       
            }           
          }else {
            
          }
//TERCER PERIODO 
$sqlp3 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='3' and orden>2 and orden<3  order by orden asc";

            $resp3 = $mysqli->query($sqlp3);
$numn3=$resp3->num_rows;
  if ($numn3>0) {  
            while ( $regp3 = $resp3->fetch_row()) {
              $ida=$regp3['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c2=1;
                $notal=$regp3['0'];
                $npl=$notal*$por;
              if($notal>=1 && $notal<=2.9){
              $sqlnl="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo=3";
                  $resnl=$mysqli->query($sqlnl);
                  $regnl=$resnl->fetch_row();
                  $notaNl=$regnl[0];
                  $ntpl=$notaNl*$por;
                } 
                if (!empty($notaNl)) {                             
                 $len3=$len3+$ntpl;                 
                } else {
                  $len3=$len3+$npl;                             
                }                       
            }           
          }else {
            
          }
//CUARTO PERIODO 
$sqlp3 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='4' and orden>2 and orden<3  order by orden asc";

            $resp3 = $mysqli->query($sqlp3);
$numn3=$resp3->num_rows;
  if ($numn3>0) {  
            while ( $regp3 = $resp3->fetch_row()) {
              $ida=$regp3['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c2=1;
                $notal=$regp3['0'];
                $npl=$notal*$por;
              if($notal>=1 && $notal<=2.9){
              $sqlnl="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo=4";
                  $resnl=$mysqli->query($sqlnl);
                  $regnl=$resnl->fetch_row();
                  $notaNl=$regnl[0];
                  $ntpl=$notaNl*$por;
                } 
                if (!empty($notaNl)) {                             
                 $len4=$len4+$ntpl;                 
                } else {
                  $len4=$len4+$npl;                             
                }                       
            }           
          }else {
            
          }
          $prlen=round(($len1+$len2+$len3+$len4)/4,1);
          if($prlen<3){
             $cp=$cp+1;
          $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='FINAL'";
             $resnf=$mysqli->query($sqlnf);
            $regf=$resnf->fetch_row();            
            if (!empty($regf[0])) {
            	$notaNF=$regf[0];            	
            }else {            	
            	$notaNF=0;
            }
            } else {
              $cg=$cg+1;
            }
            $pdf->SetFont('Arial', '', 6.5);
             $pdf->Cell(5, 5, round($len1,1), 1,0 , 'J',0);
             $pdf->Cell(5, 5, round($len2,1), 1,0 , 'J',0);
             $pdf->Cell(5, 5, round($len3,1), 1,0 , 'J',0);
             $pdf->Cell(5, 5, round($len4,1), 1,0 , 'J',0);
             $pdf->SetFont('Arial', 'B', 6.5);
         if($notaNF>0){
             $pdf->Cell(5, 5, round($prlen,1), 1,0 , 'J');
             $acm=$acm+$notaNF;
            $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J',1);            	
            }else {
            	$acm=$acm+$prlen;
             $pdf->Cell(5, 5, round($prlen,1), 1,0 , 'J',1);
            $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J');	
           }
$len1=0;
$len2=0;
$len3=0;
$len4=0;
$notaNF=0;
$prlen=0;            
$notac=0;
$notaNc=0;
//Ciencias Naturales
$sqlp4 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='1' and orden>=3.1 and orden<=3.3  order by orden asc";
            $resp4 = $mysqli->query($sqlp4);
$numn4=$resp4->num_rows;
  if ($numn4>0) {  
            while ( $regp4 = $resp4->fetch_row()) {
              $ida=$regp4['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c3=1;
                $notac=$regp4['0'];
                $npc=$notac*$por;
                if($notac>=1 && $notac<=2.9){
                  $sqlnc="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo=1";                  
                  $resnc=$mysqli->query($sqlnc);
                  $regnc=$resnc->fetch_row();
                  $notaNC=$regnc[0];
                  $ntpc=$notaN*$por;
                } 
                if (!empty($notaNC)) {                               
                 $cn1=$cn1+$ntpc;                 
                } else {
                  $cn1=$cn1+$npc;                                    
                }                       
            }     
            
    }else {
       $pdf->Cell(5, 5, '0',  1, 0, 'J');
    }
//SEGUNDO PERIDO
$sqlp4 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and orden>=3.1 and orden<=3.3  order by orden asc";
            $resp4 = $mysqli->query($sqlp4);
$numn4=$resp4->num_rows;
  if ($numn4>0) {  
            while ( $regp4 = $resp4->fetch_row()) {
              $ida=$regp4['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c3=1;
                $notac=$regp4['0'];
                $npc=$notac*$por;
                if($notac>=1 && $notac<=2.9){
                  $sqlnc="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo=2";                  
                  $resnc=$mysqli->query($sqlnc);
                  $regnc=$resnc->fetch_row();
                  $notaNC=$regnc[0];
                  $ntpc=$notaN*$por;
                } 
                if (!empty($notaNC)) {                               
                 $cn2=$cn2+$ntpc;                 
                } else {
                  $cn2=$cn2+$npc;                                    
                }                       
            }
//TERCER PERIDO
$sqlp4 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='3' and orden>=3.1 and orden<=3.3  order by orden asc";
            $resp4 = $mysqli->query($sqlp4);
$numn4=$resp4->num_rows;
  if ($numn4>0) {  
            while ( $regp4 = $resp4->fetch_row()) {
              $ida=$regp4['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c3=1;
                $notac=$regp4['0'];
                $npc=$notac*$por;
                if($notac>=1 && $notac<=2.9){
                  $sqlnc="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo=3";                  
                  $resnc=$mysqli->query($sqlnc);
                  $regnc=$resnc->fetch_row();
                  $notaNC=$regnc[0];
                  $ntpc=$notaN*$por;
                } 
                if (!empty($notaNC)) {                               
                 $cn3=$cn3+$ntpc;                 
                } else {
                  $cn3=$cn3+$npc;                                    
                }                       
            }
//TERCER PERIDO
$sqlp4 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='4' and orden>=3.1 and orden<=3.3  order by orden asc";
            $resp4 = $mysqli->query($sqlp4);
$numn4=$resp4->num_rows;
  if ($numn4>0) {  
            while ( $regp4 = $resp4->fetch_row()) {
              $ida=$regp4['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c3=1;
                $notac=$regp4['0'];
                $npc=$notac*$por;
                if($notac>=1 && $notac<=2.9){
                  $sqlnc="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo=4";                  
                  $resnc=$mysqli->query($sqlnc);
                  $regnc=$resnc->fetch_row();
                  $notaNC=$regnc[0];
                  $ntpc=$notaN*$por;
                } 
                if (!empty($notaNC)) {                               
                 $cn4=$cn4+$ntpc;                 
                } else {
                  $cn4=$cn4+$npc;                                    
                }                       
            }}
            $prcn=round(($cn1+$cn2+$cn3+$cn4)/4,1);
            if($prcn<3){
             $cp=$cp+1;
             $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='FINAL'";
             $resnf=$mysqli->query($sqlnf);
            $regf=$resnf->fetch_row();
            
            if (!empty($regf[0])) {
            	$notaNF=$regf[0];            	
            }else {            	
            	$notaNF=0;
            }
            } else {
              $cg=$cg+1;
            }        
            $pdf->SetFont('Arial', '', 6.5);    
            $pdf->Cell(5, 5, round($cn1,1),  1, 0, 'J', 0);
            $pdf->Cell(5, 5, round($cn2,1),  1, 0, 'J', 0);
            $pdf->Cell(5, 5, round($cn3,1),  1, 0, 'J', 0);
            $pdf->Cell(5, 5, round($cn4,1),  1, 0, 'J', 0);
            $pdf->SetFont('Arial', 'B', 6.5); 
           	if($notaNF>0){
             $pdf->Cell(5, 5, round($prcn,1), 1,0 , 'J');
             $acm=$acm+$notaNF;
            $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J',1);            	
            }else {
             $pdf->Cell(5, 5, round($prcn,1), 1,0 , 'J',1);
             $acm=$acm+$prcn;
            $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J');	
           }           
            $cn1=0;
            $cn2=0;
            $cn3=0;
            $cn4=0;
            $notaNF=0;
            $prcn=0;
            
    }else {
       $pdf->Cell(5, 5, '0',  1, 0, 'J');
    }

//Ciencias Sociales
$sqlp5 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='1' and orden>4 and orden<5  order by orden asc";
            $resp5 = $mysqli->query($sqlp5);
            while ( $regp5 = $resp5->fetch_row()) {
              $ida=$regp5['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c4=1;
                $notaf=$regp5['0'];
                $npf=$notaf*$por;
                if (empty($notaf)) {
                  $nota=0;                  
                }else if($notaf>=1 && $notaf<=2.9){
                  $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo=1";
                  $resnf=$mysqli->query($sqlnf);
                  $regnf=$resnf->fetch_row();
                  $notaNf=$regnf[0];
                  $ntpf=$notaNf*$por;
                } 
                if (!empty($notaNf)) {                                 
                 $fil1=$fil1+$ntpf;
                
                } else {                         
                 $fil1=$fil1+$npf;                
                }                       
            }
           
//SEGUNDO PERIODO
//Ciencias Sociales
$sqlp5 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and orden>4 and orden<5  order by orden asc";
            $resp5 = $mysqli->query($sqlp5);
            while ( $regp5 = $resp5->fetch_row()) {
              $ida=$regp5['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c4=1;
                $notaf=$regp5['0'];
                $npf=$notaf*$por;
                if (empty($notaf)) {
                  $nota=0;                 
                }else if($notaf>=1 && $notaf<=2.9){
                  $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo=2";
                  $resnf=$mysqli->query($sqlnf);
                  $regnf=$resnf->fetch_row();
                  $notaNf=$regnf[0];
                  $ntpf=$notaNf*$por;
                } 
                if (!empty($notaNf)) {                                 
                 $fil2=$fil2+$ntpf;
                
                } else {                         
                 $fil2=$fil2+$npf;                
                }                       
            }
//TERCER PERIODO
$sqlp5 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='3' and orden>4 and orden<5  order by orden asc";
            $resp5 = $mysqli->query($sqlp5);
            while ( $regp5 = $resp5->fetch_row()) {
              $ida=$regp5['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c4=1;
                $notaf=$regp5['0'];
                $npf=$notaf*$por;
                if (empty($notaf)) {
                  $nota=0;                 
                }else if($notaf>=1 && $notaf<=2.9){
                  $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo=3 ";
                  $resnf=$mysqli->query($sqlnf);
                  $regnf=$resnf->fetch_row();
                  $notaNf=$regnf[0];
                  $ntpf=$notaNf*$por;
                } 
                if (!empty($notaNf)) {                                 
                 $fil3=$fil3+$ntpf;
                
                } else {                         
                 $fil3=$fil3+$npf;                
                }                       
            }
//cuarto PERIODO
$sqlp5 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='4' and orden>4 and orden<5  order by orden asc";
            $resp5 = $mysqli->query($sqlp5);
            while ( $regp5 = $resp5->fetch_row()) {
              $ida=$regp5['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c4=1;
                $notaf=$regp5['0'];
                $npf=$notaf*$por;
                if (empty($notaf)) {
                  $nota=0;                 
                }else if($notaf>=1 && $notaf<=2.9){
                  $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo=4 ";
                  $resnf=$mysqli->query($sqlnf);
                  $regnf=$resnf->fetch_row();
                  $notaNf=$regnf[0];
                  $ntpf=$notaNf*$por;
                } 
                if (!empty($notaNf)) {                                 
                 $fil4=$fil4+$ntpf;
                
                } else {                         
                 $fil4=$fil4+$npf;                
                }                       
            }
            $prfil=round(($fil1+$fil2+$fil3+$fil4)/4, 1);
            if($prfil<3){
             $cp=$cp+1;
            $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='FINAL'";
             $resnf=$mysqli->query($sqlnf);
            $regf=$resnf->fetch_row();            
            if (!empty($regf[0])) {
            	$notaNF=$regf[0];            	
            }else {
            	
            	$notaNF=0;
            }
            } else {
              $cg=$cg+1;
            }
            $pdf->SetFont('Arial', '', 6.5);
            $pdf->Cell(5, 5, round($fil1,1),  1, 0, 'J', 0);
            $pdf->Cell(5, 5, round($fil2,1),  1, 0, 'J', 0);
            $pdf->Cell(5, 5, round($fil3,1),  1, 0, 'J', 0);
            $pdf->Cell(5, 5, round($fil4,1),  1, 0, 'J', 0);
            $pdf->SetFont('Arial', 'B', 6.5);
            if($notaNF>0){
             $pdf->Cell(5, 5, round($prfil,1), 1,0 , 'J');
             $acm=$acm+$notaNF;
            $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J',1);            	
            }else {
             $pdf->Cell(5, 5, round($prfil,1), 1,0 , 'J',1);
             $acm=$acm+$prfil;
            $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J');	
           }


            $fil1=0;
            $fil2=0;
            $fil3=0;
             $fil4=0;
            $notaNF=0;
            $prfil=0;
            
//Artistica
//Otras Materias
            $numn1=0;
            $a=0;
    $notaNo=0; 
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='1' and idasignatura=24   order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];                
                $c5=1;
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='1' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $art1=$art1+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $art1=$art1+$notao;                                   
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
  
//SEGUNDO PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and idasignatura=24    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];             
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='2' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $art2=$art2+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $art2=$art2+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
//TERCER PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='3' and idasignatura=24    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];             
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='3' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $art3=$art3+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $art3=$art3+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
//TERCER PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='4' and idasignatura=24    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];             
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='4' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $art4=$art4+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $art4=$art4+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
    $prart=round(($art1+$art2+$art3+$art4)/4,1); 
    if ($prart<3) {
    	$cp++;
   $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='FINAL'";
             $resnf=$mysqli->query($sqlnf);
            $regf=$resnf->fetch_row();
            
            if (!empty($regf[0])) {
            	$notaNF=$regf[0];            	
            }else {
            	
            	$notaNF=0;
            }
        } else {
        	$cg++;
        }
    $pdf->SetFont('Arial', '', 6.5);
    $pdf->Cell(5, 5, round($art1,1), 1,0 , 'J', 0); 
    $pdf->Cell(5, 5, round($art2,1), 1,0 , 'J', 0);  
    $pdf->Cell(5, 5, round($art3,1), 1,0 , 'J', 0);  
    $pdf->Cell(5, 5, round($art4,1), 1,0 , 'J', 0);  
    $pdf->SetFont('Arial', 'B', 6.5);
   if($notaNF>0){
     $pdf->Cell(5, 5, round($prart,1), 1,0 , 'J');
     $acm=$acm+$notaNF;
    $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J',1);            	
    }else {
     $pdf->Cell(5, 5, round($prart,1), 1,0 , 'J',1);
     $acm=$acm+$prart;
    $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J');	
   }


     $art1=0;
     $art2=0;
     $art3=0;
     $art4=0;
     $prart=0;
     $notaNF=0;
//Religion
//Otras Materias
            $numn1=0;
            $a=0;
    $notaNo=0; 
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='1' and idasignatura=25   order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];                
                $c6=1;
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='1' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $rel1=$rel1+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $rel1=$rel1+$notao;                                   
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
  
//SEGUNDO PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and idasignatura=25    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];              
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='2' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $rel2=$rel2+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $rel2=$rel2+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
    //TERCER PERIODO
    $sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='3' and idasignatura=25    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];            
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='3' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $rel3=$rel3+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $rel3=$rel3+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
 //CUARTO PERIODO
    $sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='4' and idasignatura=25    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];            
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='4' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $rel4=$rel4+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $rel4=$rel4+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
    $prrel=round(($rel1+$rel2+$rel3+$rel4)/4,1);
    if($prrel<3){
    $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='FINAL'";
             $resnf=$mysqli->query($sqlnf);
            $regf=$resnf->fetch_row();            
            if (!empty($regf[0])) {
            	$notaNF=$regf[0];            	
            }else {            	
            	$notaNF=0;
            }
       	
    }
    $pdf->SetFont('Arial', '', 6.5);
    $pdf->Cell(5, 5, round($rel1,1), 1,0 , 'J', 0); 
    $pdf->Cell(5, 5, round($rel2,1), 1,0 , 'J', 0);  
    $pdf->Cell(5, 5, round($rel3,1), 1,0 , 'J', 0);  
    $pdf->Cell(5, 5, round($rel4,1), 1,0 , 'J', 0);  
    $pdf->SetFont('Arial', 'B', 6.5);
    if($notaNF>0){
     $pdf->Cell(5, 5, round($prrel,1), 1,0 , 'J');
     $acm=$acm+$notaNF;
     $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J',1);            	
     }else {
     	$acm=$acm+$prrel;
      $pdf->Cell(5, 5, round($prrel,1), 1,0 , 'J',1);
     $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J');	
    }
     $rel1=0;
     $rel2=0;
     $rel3=0;
     $rel4=0;
     $notaNF=0;
     $prrel=0;
//Etica y valores
//Otras Materias
            $numn1=0;
            $a=0;
    $notaNo=0; 
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='1' and idasignatura=26   order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];                
                $c7=1;
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='1' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $etc1=$etc1+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $etc1=$etc1+$notao;                                   
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
  
//SEGUNDO PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and idasignatura=26    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];          
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='2' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $etc2=$etc2+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $etc2=$etc2+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
    //TERCER PERIODO
    $sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='3' and idasignatura=26    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];                  
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='3' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $etc3=$etc3+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $etc3=$etc3+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
 //CUARTO PERIODO
    $sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='4' and idasignatura=26    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];                  
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='4' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $etc4=$etc4+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $etc4=$etc4+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
    $pretc=round(($etc1+$etc2+$etc3+$etc4)/4,1); 
    if($pretc<3){
    	$sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='FINAL'";
             $resnf=$mysqli->query($sqlnf);
            $regf=$resnf->fetch_row();
            
            if (!empty($regf[0])) {
            	$notaNF=$regf[0];            	
            }else {            	
            	$notaNF=0;
            }
    }
    $pdf->SetFont('Arial', '', 6.5);
    $pdf->Cell(5, 5, round($etc1,1), 1,0 , 'J', 0); 
    $pdf->Cell(5, 5, round($etc2,1), 1,0 , 'J', 0); 
    $pdf->Cell(5, 5, round($etc3,1), 1,0 , 'J', 0);  
    $pdf->Cell(5, 5, round($etc4,1), 1,0 , 'J', 0);  
    $pdf->SetFont('Arial', 'B', 6.5);
    if($notaNF>0){
    $acm=$acm+$notaNF;
     $pdf->Cell(5, 5, round($pretc,1), 1,0 , 'J');
     $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J',1);            	
     }else {
     	$acm=$acm+$pretc;
     $pdf->Cell(5, 5, round($pretc,1), 1,0 , 'J',1);
     $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J');	
    }
     $etc1=0;
     $etc2=0;
     $etc3=0;
     $etc4=0;
     $notaNF=0;
     $pretc=0;
//tecnologia 
//Otras Materias
            $numn1=0;
            $a=0;
    $notaNo=0; 
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='1' and idasignatura=27   order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];                
                $c8=1;
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='1' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $tecn1=$tecn1+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $tecn1=$tecn1+$notao;                                   
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
  
//SEGUNDO PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and idasignatura=27    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];                     
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='2' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $tecn2=$tecn2+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $tecn2=$tecn2+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
//TERCER PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='3' and idasignatura=27    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];             
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='3' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $tecn3=$tecn3+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $tecn3=$tecn3+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
//CUARTO PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='3' and idasignatura=27    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];             
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='3' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $tecn4=$tecn4+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $tecn4=$tecn4+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
    $prtecn=round(($tecn1+$tecn2+$tecn3+$tecn4)/4,1); 
   if($prtecn>3){
   	$sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='FINAL'";
             $resnf=$mysqli->query($sqlnf);
            $regf=$resnf->fetch_row();
            
            if (!empty($regf[0])) {
            	$notaNF=$regf[0];            	
            }else {            	
            	$notaNF=0;
            }
   }
   $pdf->SetFont('Arial', '', 6.5); 
    $pdf->Cell(5, 5, round($tecn1,1), 1,0 , 'J', 0); 
    $pdf->Cell(5, 5, round($tecn2,1), 1,0 , 'J', 0); 
    $pdf->Cell(5, 5, round($tecn3,1), 1,0 , 'J', 0); 
    $pdf->Cell(5, 5, round($tecn4,1), 1,0 , 'J', 0);  
    $pdf->SetFont('Arial', 'B', 6.5); 
    if($notaNF>0){
    	$acm=$acm+$notaNF;
    $pdf->Cell(5, 5, round($prtecn,1), 1,0 , 'J');
    $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J',1);            	
    }else {
    	$acm=$acm+$prtecn;
     $pdf->Cell(5, 5, round($prtecn,1), 1,0 , 'J',1);
    $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J');	
   }


     $tecn1=0;
     $tecn2=0;
     $tecn3=0;
     $tecn4=0;
     $notaNF=0;
     $prtecn=0;
//tecnologia 
//Otras Materias
            $numn1=0;
            $a=0;
    $notaNo=0; 
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='1' and idasignatura=28   order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $c9=1;
              $notaNo=0; 
              $ida=$regp7['1'];              
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='1' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $edf1=$edf1+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $edf1=$edf1+$notao;                                   
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(10, 5, '0', 1,0 , 'J');
    }
  
//SEGUNDO PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and idasignatura=28    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];               
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='2' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $edf2=$edf2+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $edf2=$edf2+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(10, 5, '0', 1,0 , 'J');
    }
//TERCER PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='3' and idasignatura=28    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];            
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='3' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                     $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $edf3=$edf3+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $edf3=$edf3+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
//CUARTO PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='4' and idasignatura=28    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];            
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='4' ";    
                  $resno=$mysqli->query($sqlno);
                  $num=$resno->num_rows;
                  if ($num==0) {
                  $notaNo=0;
                  }   else {
                    $a=1;
                  $regno=$resno->fetch_row();
                  $notaNo=$regno[0]; 
                  }                              
                } else {
                   $cg++;
                }
                if (!empty($notaNo) && $a==1) {                           
                 $edf4=$edf4+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $edf4=$edf4+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(5, 5, '0', 1,0 , 'J');
    }
    $predf=round(($edf1+$edf2+$edf3+$edf4)/4,1); 
    if($predf<3){
    $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='FINAL'";
             $resnf=$mysqli->query($sqlnf);
            $regf=$resnf->fetch_row();            
            if (!empty($regf[0])) {
            	$notaNF=$regf[0];            	
            }else {            	
            	$notaNF=0;
            }
    }
    $pdf->SetFont('Arial', '', 6.5);
    $pdf->Cell(5, 5, round($edf1,1), 1,0 , 'J', 0); 
    $pdf->Cell(5, 5, round($edf2,1), 1,0 , 'J', 0); 
    $pdf->Cell(5, 5, round($edf3,1), 1,0 , 'J', 0);  
    $pdf->Cell(5, 5, round($edf4,1), 1,0 , 'J', 0);  
    $pdf->SetFont('Arial', 'B', 6.5);
    if($notaNF>0){
    $acm=$acm+$notaNF;
     $pdf->Cell(5, 5, round($predf,1), 1,0 , 'J');
    $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J',1);            	
    }else {
    $acm=$acm+$predf;
     $pdf->Cell(5, 5, round($predf,1), 1,0 , 'J',1);
    $pdf->Cell(5, 5, round($notaNF,1), 1,0 , 'J');	
   }
     $edf1=0;
     $edf2=0;
     $edf3=0;
     $edf4=0;
     $notaNF=0;
     $predf=0; 
      $idasig=0;
    $idest=0;
    $num=0;
    $notao=0;        
   $prom=($acm)/($c1+$c2+$c3+$c4+$c5+$c6+$c7+$c8+$c9);
   $rprom=round($prom,1);
   $promedios[$nom]=($rprom );
             
$pdf->Ln(); 
$i++;
    }
}

$pdf->Ln();
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
$pdf->Output();