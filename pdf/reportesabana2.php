<?php

$jornada ='MATINAL';
$grado   = $_POST['grado'];
$periodo = $_POST['periodo'];
$sede = $_POST['sede'];
$promedios = array();

if (isset($jornada) && isset($grado) && isset($periodo)  && isset($sede)) {
    
if ($periodo==2) {
require_once "../php/Conexion.php";
    include "fpdf/fpdf.php";

    $sql  = "SELECT  e.idestudiante, e.nombres, e.apellidos, g.descripcion, s.nombre from estudiantes e  inner join grados g on e.idgrado=g.idgrado inner join sedes s on e.idsede=s.idsede  where e.idgrado='$grado'  and  e.idsede='$sede' order by e.apellidos asc";    
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
    $pdf->Cell(370, 5, 'SABANA DE NOTAS ', 0, 1, 'C');       
      $pdf->Cell(320, 10, '', 1, 0, 'J'); 
     $pdf->Ln(2);
      
    $pdf->SetFont('Arial', 'B', 10);
   
    $pdf->Cell(140, 6, 'GRADO: '.$reggr[0], 0, 0, 'J');
    $pdf->Cell(120, 6, 'SEDE: '.$regs[0], 0, 0, 'J');   
    $pdf->Cell(140, 6, utf8_decode('Año: 2018'), 0, 0, 'J');
    $pdf->Ln(5);
  
    $pdf->Cell(80, 6, '', 0, 'C', 1);
    $pdf->Ln();
     $pdf->SetX(90);    

    $pdf->Cell(30, 5, 'MAT', 1, 0, 'C', 1);
    $pdf->SetX(120);
    $pdf->Cell(30, 5, 'HUMANIDADES', 1, 0, 'C', 1); 
    $pdf->SetX(150);    
    $pdf->Cell(30, 5, 'C. SOCIALES', 1, 0, 'C', 1);
    $sqlp7 = "SELECT distinct  a.acronimo, a.idasignatura from asignaturas a inner join calificaciones c on a.idasignatura=c.idasignatura where c.idgrado='$grado'  and orden>=4.5 order by orden asc ";
            $resp7 = $mysqli->query($sqlp7);
            while ( $regp7 = $resp7->fetch_row()) {
                $pdf->SetFont('Arial', 'B', 8);
                $asig=$regp7['0'];                       
            $pdf->Cell(24, 5, $asig,  1, 0, 'J', 1);
          } 
    $pdf->Ln();
    $pdf->Cell(8, 5, utf8_decode('N°'), 1, 0, 'C', 1);
    $pdf->Cell(72, 5, 'ESTUDIANTES', 1, 0, 'C', 1); 
        $pdf->SetFont('Arial', 'B', 8);
//Matematicas 
   
        $pdf->Cell(10, 5, '1',  1, 0, 'J', 0);
         $pdf->Cell(10, 5, '2',  1, 0, 'J', 0);
        $pdf->Cell(10, 5, 'DEF',  1, 0, 'J', 1);    
    

    //Lenguaje
   
         $pdf->Cell(10, 5, '1',  1, 0, 'J', 0);
         $pdf->Cell(10, 5, '2',  1, 0, 'J', 0);
        $pdf->Cell(10, 5, 'DEF',  1, 0, 'J', 1);   
   
    //Filosofia
   
         $pdf->Cell(10, 5, '1',  1, 0, 'J', 0);
         $pdf->Cell(10, 5, '2',  1, 0, 'J', 0);
        $pdf->Cell(10, 5, 'DEF',  1, 0, 'J', 1);     
     //Otras Materias
    $sqlp7 = "SELECT distinct  a.acronimo, a.idasignatura from asignaturas a inner join calificaciones c on a.idasignatura=c.idasignatura where c.idgrado='$grado'  and orden>=4.5 order by orden asc ";
            $resp7 = $mysqli->query($sqlp7);
            while ( $regp7 = $resp7->fetch_row()) {
                $pdf->SetFont('Arial', 'B', 8);
                $asig=$regp7['0'];                       
            $pdf->Cell(8, 5, '1',  1, 0, 'J', 1);
            $pdf->Cell(8, 5, '2',  1, 0, 'J', 1);
            $pdf->Cell(8, 5, 'DEF',  1, 0, 'J', 1);
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
    $notaNo=0;
            $notao=0;
        $pdf->SetFont('Arial', '', 8);
        $idest=$reg1['0'];
        $nom = $reg1['2'] . ' ' . $reg1['1'];       
        $pdf->Cell(8, 5, $i, 1, 0, 'J');
        $pdf->Cell(72, 5, utf8_decode($nom), 1, 0, 'J');
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
                  $sqln="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' ";
                  $resn=$mysqli->query($sqln);
                  $regn=$resn->fetch_row();
                  $notaN=$regn[0];
                  $ntpm=$notaNm*$por;
                } 
                if (!empty($notaNm)) {                                 
                 $mat=$mat+$ntpm;                 
                } else {                               
                 $mat=$mat+$npm;                
                }                       
            }
//SEGUNDO PERIODO
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
                  $sqln="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' ";
                  $resn=$mysqli->query($sqln);
                  $regn=$resn->fetch_row();
                  $notaN=$regn[0];
                  $ntpm=$notaNm*$por;
                } 
                if (!empty($notaNm)) {
                     
                 $mat2=$mat2+$ntpm;                 
                } else {
                               
                 $mat2=$mat2+$npm;                
                }                       
            }
            $pmat=round((($mat+$mat2)/2),1);
            $pdf->Cell(10, 5, $mat, 1,0 , 'J');
            $pdf->Cell(10, 5, $mat2, 1,0 , 'J');
            $pdf->Cell(10, 5, $pmat,  1, 0, 'J', 1);  
            if($pmat<3){
              $cp=$cp+1;
            } else {
              $cg=$cg+1;
            }
            $mat=0;
            $mat2=0;
            $pmat=0; 
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
              $sqlnl="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' ";
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
             $pdf->Cell(10, 5, '0', 1,0 , 'J');
          }
            
//Segundo periodo
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
              $sqlnl="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' ";
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
            $prlen=round(($len1+$len2)/2, 1);
             $pdf->Cell(10, 5, $len1,  1, 0, 'J', 0);
             $pdf->Cell(10, 5, $len2,  1, 0, 'J', 0);
            $pdf->Cell(10, 5, $prlen,  1, 0, 'J', 1);
          }else {
             $pdf->Cell(10, 5, '0', 1,0 , 'J');
          }
            if($prlen<3){
             $cp=$cp+1;
            } else {
              $cg=$cg+1;
            }
            $len1=0;
            $len2=0;
            $prlen=0;
//Ciencias Sociales
            $notaf=0;
            $notaNf=0;
$sqlp5 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='1' and orden>=4.2 and orden<=4.3 order by orden asc";
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
                  $pdf->Cell(10, 5, $nota, 1,0 , 'J');
                }else if($notaf>=1 && $notaf<=2.9){
                  $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' ";
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
            
            if($fil<3){
             $cp=$cp+1;
            } else {
              $cg=$cg+1;
            }
//segundo periodo 
//Ciencias Sociales
            $notaf=0;
            $notaNf=0;
$sqlp5 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and orden>=4.2 and orden<=4.3 order by orden asc";
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
                  $pdf->Cell(10, 5, $nota, 1,0 , 'J');
                }else if($notaf>=1 && $notaf<=2.9){
                  $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' ";
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
            $prfil=round(($fil1+$fil2)/2,1);
            $pdf->Cell(10, 5, $fil1,  1, 0, 'J', 0);
            $pdf->Cell(10, 5, $fil2,  1, 0, 'J', 0);
            $pdf->Cell(10, 5, $prfil,  1, 0, 'J', 1);
            if($prfil<3){
             $cp=$cp+1;
            } else {
              $cg=$cg+1;
            }
            $fil1=0;
            $fil2=0;
            $prfil=0;
//Otras Materias
//Otras Materias
            $numn1=0;
            $a=0;
    $notaNo=0; 
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='1' and idasignatura=17   order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];                
                $c6++;
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo='$periodo' ";    
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
                 $cnat1=$cnat1+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $cnat1=$cnat1+$notao;                                   
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(10, 5, '0', 1,0 , 'J');
    }
  
//SEGUNDO PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and idasignatura=17    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];                
                $c6++;
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
                 $cnat2=$cnat2+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $cnat2=$cnat2+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(10, 5, '0', 1,0 , 'J');
    }
    $prcnat=round(($cnat1+$cnat2)/2,1); 
    $pdf->Cell(8, 5, $cnat1, 1,0 , 'J', 0); 
    $pdf->Cell(8, 5, $cnat2, 1,0 , 'J', 0);  
     $pdf->Cell(8, 5, $prcnat, 1,0 , 'J', 1);
     $cnat1=0;
     $cnat2=0;
     $prcnat=0;
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
                $c6++;
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
      $pdf->Cell(10, 5, '0', 1,0 , 'J');
    }
  
//SEGUNDO PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and idasignatura=24    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];                
                $c6++;
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
      $pdf->Cell(10, 5, '0', 1,0 , 'J');
    }
    $prart=round(($art1+$art2)/2,1); 
    $pdf->Cell(8, 5, $art1, 1,0 , 'J', 0); 
    $pdf->Cell(8, 5, $art2, 1,0 , 'J', 0);  
     $pdf->Cell(8, 5, $prart, 1,0 , 'J', 1);
     $art1=0;
     $art2=0;
     $prart=0;
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
                $c6++;
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
      $pdf->Cell(10, 5, '0', 1,0 , 'J');
    }
  
//SEGUNDO PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and idasignatura=25    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];                
                $c6++;
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
      $pdf->Cell(10, 5, '0', 1,0 , 'J');
    }
    $prrel=round(($rel1+$rel2)/2,1); 
    $pdf->Cell(8, 5, $rel1, 1,0 , 'J', 0); 
    $pdf->Cell(8, 5, $rel2, 1,0 , 'J', 0);  
     $pdf->Cell(8, 5, $prrel, 1,0 , 'J', 1);
     $rel1=0;
     $rel2=0;
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
                $c6++;
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
      $pdf->Cell(10, 5, '0', 1,0 , 'J');
    }
  
//SEGUNDO PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and idasignatura=26    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];                
                $c6++;
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
      $pdf->Cell(10, 5, '0', 1,0 , 'J');
    }
    $pretc=round(($etc1+$etc2)/2,1); 
    $pdf->Cell(8, 5, $etc1, 1,0 , 'J', 0); 
    $pdf->Cell(8, 5, $etc2, 1,0 , 'J', 0);  
     $pdf->Cell(8, 5, $pretc, 1,0 , 'J', 1);
     $etc1=0;
     $etc2=0;
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
                $c6++;
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
      $pdf->Cell(10, 5, '0', 1,0 , 'J');
    }
  
//SEGUNDO PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and idasignatura=27    order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];                
                $c6++;
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
      $pdf->Cell(10, 5, '0', 1,0 , 'J');
    }
    $prtecn=round(($tecn1+$tecn2)/2,1); 
    $pdf->Cell(8, 5, $tecn1, 1,0 , 'J', 0); 
    $pdf->Cell(8, 5, $tecn2, 1,0 , 'J', 0);  
     $pdf->Cell(8, 5, $prtecn, 1,0 , 'J', 1);
     $tecn1=0;
     $tecn2=0;
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
              $notaNo=0; 
              $ida=$regp7['1'];                
                $c6++;
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
                $c6++;
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
    $predf=round(($edf1+$edf2)/2,1); 
    $pdf->Cell(8, 5, $edf1, 1,0 , 'J', 0); 
    $pdf->Cell(8, 5, $edf2, 1,0 , 'J', 0);  
     $pdf->Cell(8, 5, $predf, 1,0 , 'J', 1);
     $edf1=0;
     $edf2=0;
     $predf=0;
    $idasig=0;
    $idest=0;
    $num=0;
    $notao=0;
      $prom=($mat+$len+$cn+$fil+$et+$acom)/($c1+$c2+$c3+$c4+$c5+$c6);
      $rprom=round($prom,1);      
    
             
$pdf->Ln(); 
$i++;
    }



    $pdf->Output();      
}

if ($periodo==3) {
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
$pdf->Cell(370, 5, 'SABANA DE PERIODOS ', 0, 1, 'C');       
$pdf->Cell(360, 10, '', 1, 0, 'J'); 
$pdf->Ln(2);     
$pdf->SetFont('Arial', 'B', 10);   
$pdf->Cell(140, 6, 'GRADO: '.$reggr[0], 0, 0, 'J');
$pdf->Cell(120, 6, 'SEDE: '.$regs[0], 0, 0, 'J');   
$pdf->Cell(140, 6, utf8_decode('Año: 2018'), 0, 0, 'J');
$pdf->Ln(5);  
$pdf->Cell(80, 6, '', 0, 'C', 1);
$pdf->Ln();
$pdf->SetX(90);    
$pdf->Cell(28, 5, 'MAT', 1, 0, 'C', 1);
$pdf->SetX(118);
$pdf->Cell(28, 5, 'HUMAN', 1, 0, 'C', 1); 
$pdf->SetX(146);    
$pdf->Cell(28, 5, 'C. SOCIALES', 1, 0, 'C', 1);
$sqlp7 = "SELECT distinct  a.acronimo, a.idasignatura from asignaturas a inner join calificaciones c on a.idasignatura=c.idasignatura where c.idgrado='$grado'  and orden>=4.5 order by orden asc ";
            $resp7 = $mysqli->query($sqlp7);
            while ( $regp7 = $resp7->fetch_row()) {
                $pdf->SetFont('Arial', 'B', 10);
                $asig=$regp7['0'];                       
            $pdf->Cell(28, 5, $asig,  1, 0, 'J', 1);
          } 
    $pdf->Ln();
    $pdf->Cell(8, 5, utf8_decode('N°'), 1, 0, 'C', 1);
    $pdf->Cell(72, 5, 'ESTUDIANTES', 1, 0, 'C', 1); 
        $pdf->SetFont('Arial', 'B', 8);
//Matematicas 
   
        $pdf->Cell(7, 5, '1',  1, 0, 'J', 0);
         $pdf->Cell(7, 5, '2',  1, 0, 'J', 0);
        $pdf->Cell(7, 5, '3',  1, 0, 'J', 0);
        $pdf->Cell(7, 5, 'DF',  1, 0, 'J', 1);    
    

    //Lenguaje
   
         $pdf->Cell(7, 5, '1',  1, 0, 'J', 0);
         $pdf->Cell(7, 5, '2',  1, 0, 'J', 0);
         $pdf->Cell(7, 5, '3',  1, 0, 'J', 0);
        $pdf->Cell(7, 5, 'DF',  1, 0, 'J', 1);   
   
    //Filosofia
   
         $pdf->Cell(7, 5, '1',  1, 0, 'J', 0);
         $pdf->Cell(7, 5, '2',  1, 0, 'J', 0);
         $pdf->Cell(7, 5, '3',  1, 0, 'J', 0);
        $pdf->Cell(7, 5, 'DF',  1, 0, 'J', 1);     
     //Otras Materias
    $sqlp7 = "SELECT distinct  a.acronimo, a.idasignatura from asignaturas a inner join calificaciones c on a.idasignatura=c.idasignatura where c.idgrado='$grado'  and orden>=4.5 order by orden asc ";
            $resp7 = $mysqli->query($sqlp7);
            while ( $regp7 = $resp7->fetch_row()) {
                $pdf->SetFont('Arial', 'B', 8);
                $asig=$regp7['0'];                       
            $pdf->Cell(7, 5, '1',  1, 0, 'J', 1);
            $pdf->Cell(7, 5, '2',  1, 0, 'J', 1);
             $pdf->Cell(7, 5, '3',  1, 0, 'J', 1);
            $pdf->Cell(7, 5, 'DF',  1, 0, 'J', 1);
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
    $notaNo=0;
            $notao=0;
        $pdf->SetFont('Arial', '', 8);
        $idest=$reg1['0'];
        $nom = $reg1['2'] . ' ' . $reg1['1'];       
        $pdf->Cell(8, 5, $i, 1, 0, 'J');
        $pdf->Cell(72, 5, utf8_decode($nom), 1, 0, 'J');
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
                  $sqln="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' ";
                  $resn=$mysqli->query($sqln);
                  $regn=$resn->fetch_row();
                  $notaN=$regn[0];
                  $ntpm=$notaNm*$por;
                } 
                if (!empty($notaNm)) {                                 
                 $mat=$mat+$ntpm;                 
                } else {                               
                 $mat=$mat+$npm;                
                }                       
            }
//SEGUNDO PERIODO
$sqlp2 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and orden>1 and orden<2  order by orden asc";         

            $resp2 = $mysqli->query($sqlp2);
            while ( $regp2 = $resp2->fetch_row()) {
              $ida=$regp2['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);               
                $notam=$regp2['0'];
                $npm=$notam*$por;
                if (empty($notam)) {
                  $nulo=0;
                  $pdf->Cell(7, 5, $nulo, 1,0 , 'J');
                }else   if($notam>=1 && $notam<=2.9){
                  $sqln="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' ";
                  $resn=$mysqli->query($sqln);
                  $regn=$resn->fetch_row();
                  $notaN=$regn[0];
                  $ntpm=$notaNm*$por;
                } 
                if (!empty($notaNm)) {
                     
                 $mat2=$mat2+$ntpm;                 
                } else {
                               
                 $mat2=$mat2+$npm;                
                }                       
            }
//TERCER PERIODO
$sqlp2 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='3' and orden>1 and orden<2  order by orden asc";         

            $resp2 = $mysqli->query($sqlp2);
            while ( $regp2 = $resp2->fetch_row()) {
              $ida=$regp2['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);           
                $notam=$regp2['0'];
                $npm=$notam*$por;
                if (empty($notam)) {
                  $nulo=0;
                  $pdf->Cell(10, 5, $nulo, 1,0 , 'J');
                }else   if($notam>=1 && $notam<=2.9){
                  $sqln="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo=3";
                  $resn=$mysqli->query($sqln);
                  $regn=$resn->fetch_row();
                  $notaN=$regn[0];
                  $ntpm=$notaNm*$por;
                } 
                if (!empty($notaNm)) {
                     
                 $mat3=$mat3+$ntpm;                 
                } else {
                               
                 $mat3=$mat3+$npm;                
                }                       
            }
            $pmat=round((($mat+$mat2+$mat3)/3),1);
            $acm=$acm+$pmat;
            $pdf->Cell(7, 5, round($mat,1), 1,0 , 'J');
            $pdf->Cell(7, 5, round($mat2,1), 1,0 , 'J');
             $pdf->Cell(7, 5, round($mat3,1), 1,0 , 'J');
            $pdf->Cell(7, 5, $pmat,  1, 0, 'J', 1);  
            if($pmat<3){
              $cp=$cp+1;
            } else {
              $cg=$cg+1;
            }
            $mat=0;
            $mat2=0;
            $mat3=0;
            $pmat=0; 
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
          }
 //segundo periodo
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
//tercer periodo
            $por=0;
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
                $notal=$regp3['0'];
                $npl=$notal*$por;
              
                
                  $len3=$len3+$npl;                         
                                      
            }
            $prlen=round(($len1+$len2+$len3)/3, 1);
            $acm=$acm+$prlen;
             $pdf->Cell(7, 5, round($len1,1),  1, 0, 'J', 0);
             $pdf->Cell(7, 5, round($len2,1),  1, 0, 'J', 0);
              $pdf->Cell(7, 5, round($len3,1),  1, 0, 'J', 0);
            $pdf->Cell(7, 5, $prlen,  1, 0, 'J', 1);
          }else {
             $pdf->Cell(7, 5, '0', 1,0 , 'J');
          }
            if($prlen<3){
             $cp=$cp+1;
            } else {
              $cg=$cg+1;
            }
            $len1=0;
            $len2=0;
            $len3=0;
            $prlen=0;
//Ciencias Sociales
            $notaf=0;
            $notaNf=0;
$sqlp5 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='1' and orden>=4.2 and orden<=4.3 order by orden asc";
            $resp5 = $mysqli->query($sqlp5);
            while ( $regp5 = $resp5->fetch_row()) {
              $ida=$regp5['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c3=1;
                $notaf=$regp5['0'];
                $npf=$notaf*$por;
                if (empty($notaf)) {
                  $nota=0;
                  $pdf->Cell(10, 5, $nota, 1,0 , 'J');
                }else if($notaf>=1 && $notaf<=2.9){
                  $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' ";
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
            
            if($fil<3){
             $cp=$cp+1;
            } else {
              $cg=$cg+1;
            }
//segundo periodo 
            $notaf=0;
            $notaNf=0;
$sqlp5 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and orden>=4.2 and orden<=4.3 order by orden asc";
            $resp5 = $mysqli->query($sqlp5);
            while ( $regp5 = $resp5->fetch_row()) {
              $ida=$regp5['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);                  
                $notaf=$regp5['0'];
                $npf=$notaf*$por;
                if (empty($notaf)) {
                  $nota=0;
                  $pdf->Cell(10, 5, $nota, 1,0 , 'J');
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
//tercer periodo 
            $notaf=0;
            $notaNf=0;
$sqlp5 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='3' and orden>=4.2 and orden<=4.3 order by orden asc";
            $resp5 = $mysqli->query($sqlp5);
            while ( $regp5 = $resp5->fetch_row()) {
              $ida=$regp5['1'];
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);                 
                $notaf=$regp5['0'];
                $npf=$notaf*$por;
                if (empty($notaf)) {
                  $nota=0;
                  $pdf->Cell(10, 5, $nota, 1,0 , 'J');
                }else if($notaf>=1 && $notaf<=2.9){
                  $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' and periodo=3";
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
            $prfil=round(($fil1+$fil2+$fil3)/3,1);
            $acm=$acm+$prfil;
            $pdf->Cell(7, 5, round($fil1,1),  1, 0, 'J', 0);
            $pdf->Cell(7, 5, round($fil2,1),  1, 0, 'J', 0);
            $pdf->Cell(7, 5, round($fil3,1),  1, 0, 'J', 0);
            $pdf->Cell(7, 5, $prfil,  1, 0, 'J', 1);
            if($prfil<3){
             $cp=$cp+1;
            } else {
              $cg=$cg+1;
            }
            $fil1=0;
            $fil2=0;
            $fil3=0;
            $prfil=0;
//Otras Materias
            //Ciencias naturales

            $numn1=0;
            $a=0;
    $notaNo=0; 
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='1' and idasignatura=17   order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];                
                $c4=1;
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
                 $cnat1=$cnat1+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $cnat1=$cnat1+$notao;                                   
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
    }
  
//SEGUNDO PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='2' and idasignatura=17    order by orden asc";
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
                 $cnat2=$cnat2+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $cnat2=$cnat2+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
    }
//TERCERO PERIODO
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='3' and idasignatura=17    order by orden asc";
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
                 $cnat3=$cnat3+$notaNo;                
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {               
                  $cnat3=$cnat3+$notao;                                
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}
    else {
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
    }
    $prcnat=round(($cnat1+$cnat2+$cnat3)/3,1); 
    $acm=$acm+$prcnat;
    $pdf->Cell(7, 5, round($cnat1,1), 1,0 , 'J', 0); 
    $pdf->Cell(7, 5, round($cnat2,1), 1,0 , 'J', 0); 
    $pdf->Cell(7, 5, round($cnat3,1), 1,0 , 'J', 0);  
     $pdf->Cell(7, 5, $prcnat, 1,0 , 'J', 1);
     $cnat1=0;
     $cnat2=0;
     $cnat3=0;
     $prcnat=0;
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
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
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
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
    }
//TERCER PERIODO
//SEGUNDO PERIODO
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
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
    }
    $prart=round(($art1+$art2+$art3)/3,1); 
    $acm=$acm+$prart;
    $pdf->Cell(7, 5, round($art1,1), 1,0 , 'J', 0); 
    $pdf->Cell(7, 5, round($art2,1), 1,0 , 'J', 0);
    $pdf->Cell(7, 5, round($art3,1), 1,0 , 'J', 0);  
     $pdf->Cell(7, 5, $prart, 1,0 , 'J', 1);
     $art1=0;
     $art2=0;
     $art3=0;
     $prart=0;
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
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
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
                  $pdf->Cell(7, 5, $nulo, 1,0 , 'J');
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
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
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
                  $pdf->Cell(7, 5, $nulo, 1,0 , 'J');
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
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
    }
    $prrel=round(($rel1+$rel2+$rel3)/3,1); 
    $acm=$acm+$prrel;
    $pdf->Cell(7, 5, round($rel1,1), 1,0 , 'J', 0); 
    $pdf->Cell(7, 5, round($rel2,1), 1,0 , 'J', 0); 
    $pdf->Cell(7, 5, round($rel3,1), 1,0 , 'J', 0);  
     $pdf->Cell(7, 5, $prrel, 1,0 , 'J', 1);
     $rel1=0;
     $rel2=0;
     $rel3=0;
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
                  $pdf->Cell(7, 5, $nulo, 1,0 , 'J');
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
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
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
                  $pdf->Cell(7, 5, $nulo, 1,0 , 'J');
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
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
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
                  $pdf->Cell(7, 5, $nulo, 1,0 , 'J');
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
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
    }
    $pretc=round(($etc1+$etc2+$etc3)/3,1); 
    $acm=$acm+$pretc;
    $pdf->Cell(7, 5, round($etc1,1), 1,0 , 'J', 0); 
    $pdf->Cell(7, 5, round($etc2,1), 1,0 , 'J', 0);
    $pdf->Cell(7, 5, round($etc3,1), 1,0 , 'J', 0);  
     $pdf->Cell(7, 5, $pretc, 1,0 , 'J', 1);
     $etc1=0;
     $etc2=0;
     $etc3=0;
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
                  $pdf->Cell(7, 5, $nulo, 1,0 , 'J');
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
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
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
                  $pdf->Cell(7, 5, $nulo, 1,0 , 'J');
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
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
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
                  $pdf->Cell(7, 5, $nulo, 1,0 , 'J');
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
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
    }
    $prtecn=round(($tecn1+$tecn2+$tecn3)/3,1); 
    $acm=$acm+$prtecn;
    $pdf->Cell(7, 5, round($tecn1,1), 1,0 , 'J', 0); 
    $pdf->Cell(7, 5, round($tecn2,1), 1,0 , 'J', 0);  
    $pdf->Cell(7, 5, round($tecn3,1), 1,0 , 'J', 0);  
     $pdf->Cell(7, 5, $prtecn, 1,0 , 'J', 1);
     $tecn1=0;
     $tecn2=0;
    $tecn3=0;
     $prtecn=0;
//Educacion fisica 
//Otras Materias
            $numn1=0;
            $a=0;
    $notaNo=0; 
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='1' and idasignatura=28   order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $notaNo=0; 
              $ida=$regp7['1'];                
                $c9=1;
                $notao=$regp7['0'];                
                if (empty($notao)) {
                  $nulo=0;
                  $pdf->Cell(7, 5, $nulo, 1,0 , 'J');
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
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
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
                  $pdf->Cell(7, 5, $nulo, 1,0 , 'J');
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
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
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
                  $pdf->Cell(7, 5, $nulo, 1,0 , 'J');
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
      $pdf->Cell(7, 5, '0', 1,0 , 'J');
    }
    $predf=round(($edf1+$edf2+$edf3)/3,1); 
    $acm=$acm+$predf;
    $pdf->Cell(7, 5, round($edf1,1), 1,0 , 'J', 0); 
    $pdf->Cell(7, 5, round($edf2,1), 1,0 , 'J', 0);
    $pdf->Cell(7, 5, round($edf3,1), 1,0 , 'J', 0);  
     $pdf->Cell(7, 5, $predf, 1,0 , 'J', 1);
     $edf1=0;
     $edf2=0;
     $edf3=0;
     $predf=0;
    $idasig=0;
    $idest=0;
    $num=0;
    $notao=0;
      $prom=($acm)/($c1+$c2+$c3+$c4+$c5+$c6+$c7+$c8+$c9);
      $rprom=round($prom,1); 
      $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 5, $rprom, 1,0 , 'J', 1);      
    
             
$pdf->Ln(); 
$i++;
    }
}


    $pdf->Output();

}

}
