<?php

$jornada ='MATINAL';
$grado   = $_POST['grado'];
$periodo = $_POST['periodo'];
$sede = $_POST['sede'];
$promedios = array();

if (isset($jornada) && isset($grado) && isset($periodo)  && isset($sede)) {
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
    $pdf->Cell(370, 5, 'CUADRO DE HONOR ', 0, 1, 'C');       
      $pdf->Cell(320, 10, '', 1, 0, 'J'); 
     $pdf->Ln(2);
      
    $pdf->SetFont('Arial', 'B', 10);
   
    $pdf->Cell(140, 6, 'GRADO: '.$reggr[0], 0, 0, 'J');
    $pdf->Cell(120, 6, 'SEDE: '.$regs[0], 0, 0, 'J');
    $pdf->Cell(140, 6, 'PERIODO: '.$periodo, 0, 0, 'J');
    $pdf->Cell(140, 6, utf8_decode('Año: 2018'), 0, 0, 'J');
    $pdf->Ln(5);
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
              $sqlp2 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='$periodo' and orden>1 and orden<2  order by orden asc";         

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
            if($mat<3){
              $cp=$cp+1;
            } else {
              $cg=$cg+1;
            } 
//Lenguaje
$notaNl=0;
$sqlp3 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='$periodo' and orden>2 and orden<3  order by orden asc";

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
                 $len=$len+$ntpl;                 
                } else {
                  $len=$len+$npl;                               
                }                       
            }
         
          }
            if($len<3){
             $cp=$cp+1;
            } else {
              $cg=$cg+1;
            }
$notac=0;
$notaNc=0;
//Ciencias Naturales
$sqlp4 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='$periodo' and orden>=3.1 and orden<=3.3  order by orden asc";
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
                  $sqlnc="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' ";                  
                  $resnc=$mysqli->query($sqlnc);
                  $regnc=$resnc->fetch_row();
                  $notaNC=$regnc[0];
                  $ntpc=$notaN*$por;
                } 
                if (!empty($notaNC)) {                              
                 $cn=$cn+$ntpc;                 
                } else {
                  $cn=$cn+$npc;                                   
                }                       
            }          
            if($cn<3){
              $cp=$cp+1;
            } else {
             $cg=$cg+1;
            }
    }
//Ciencias Sociales
$sqlp5 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='$periodo' and orden>4 and orden<5  order by orden asc";
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
                  $sqlnf="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' ";
                  $resnf=$mysqli->query($sqlnf);
                  $regnf=$resnf->fetch_row();
                  $notaNf=$regnf[0];
                  $ntpf=$notaNf*$por;
                } 
                if (!empty($notaNf)) {                               
                 $fil=$fil+$ntpf;
                
                } else {                              
                 $fil=$fil+$npf;
                
                }                       
            }           
            if($fil<3){
             $cp=$cp+1;
            } else {
              $cg=$cg+1;
            }
//Otras Materias
            $numn1=0;
$sqlp7 = "SELECT nota, idasignatura from calificaciones where idestudiante='$idest'  and  idgrado='$grado' and idsede='$sede' and periodo ='$periodo' and orden>=5   order by orden asc";
            $resp7 = $mysqli->query($sqlp7); 
            $numn1=$resp7->num_rows; 
            
  if ($numn1>0) {                       
            while ( $regp7 = $resp7->fetch_row()) {
              $ida=$regp7['1'];
              $notaNo=0;
            $notao=0;
      $sql_cg="SELECT porcentaje from carga_academica where idasignatura='$ida' and idgrado='$grado'";
      $res_cg=$mysqli->query($sql_cg);
      $reg_cg=$res_cg->fetch_row();
      $por=($reg_cg[0]/100);              
                $c6++;
                $notao=$regp7['0'];                
               if($notao>=1 && $notao<=2.9){
                  $sqlno="SELECT nota from nivelaciones where idestudiante='$idest' and idgrado='$grado' and idasignatura='$ida' ";
                  $resno=$mysqli->query($sqlno);
                  $regno=$resno->fetch_row();
                  $num=$resno->num_rows; 
                  if ($num==0) {                 
                  }else {
                    $notaNo=$regno[0];                  
                  }
                  
                } else {
                   $cg++;
                }
                if (!empty($notaNo)) {
                 $acom=$acom+$notaNo;  
                 if ($notaNo<3) {
                  $cp++;
                 }   
                
                } else {                 
                  $acom=$acom+$notao;                 
                 if ($notao<3) {
                  $cp++;
                 }
                }                       
            }}            
      $prom=($mat+$len+$cn+$fil+$et+$acom)/($c1+$c2+$c3+$c4+$c5+$c6);
      $rprom=round($prom,2);
      $promedios[$nom]=($rprom );     
             
$pdf->Ln(); 
$i++;

    }
  $pdf->Ln();   
  arsort($promedios);
  $a=0;
  $pdf->SetFont('Arial', 'B', 10);  
  $acval=0;
  $pdf->SetY(70);
$pdf->Cell(100, 60, '', 1,0 , 'J',0);
$pdf->SetX(120);
$pdf->Cell(100, 60, '', 1,0 , 'J',0);
$pdf->SetX(230);
$pdf->Cell(100, 60, '', 1,0 , 'J',0);
  $pdf->Ln(); 
foreach ($promedios as $key => $val) {
  $a++;
  if($a==1){
    $pdf->Cell(8, 5, $a, 1,0 , 'J',0);
  $pdf->Cell(80, 5, "$key ", 1,0 , 'J',0);   
  $pdf->Cell(12, 5, "$val ", 1,1 , 'J',0); 
  }
  if($a==2){
    $pdf->SetY(130);
    $pdf->SetX(120);
    $pdf->Cell(8, 5, $a, 1,0 , 'J',0);
  $pdf->Cell(80, 5, "$key ", 1,0 , 'J',0);   
  $pdf->Cell(12, 5, "$val ", 1,1 , 'J',0); 
  }
  if($a==3){

    $pdf->SetY(130);
      $pdf->SetX(230);
    $pdf->Cell(8, 5, $a, 1,0 , 'J',0);
  $pdf->Cell(80, 5, "$key ", 1,0 , 'J',0);   
  $pdf->Cell(12, 5, "$val ", 1,1 , 'J',0); 
  }
  $acval=$acval+$val;
}
$pdf->Ln(); 
$promg=$acval/$a;
$pdf->SetFont('Arial', 'B', 12);
$rpromg=round($promg, 2);
$pdf->SetX(120);
$pdf->Cell(88, 5, "PROMEDIO GENERAL DE GRADO ", 1,0 , 'C',1);
$pdf->Cell(12, 5, "$rpromg ", 1,1 , 'C',0);
$pdf->Ln(); 
$pdf->Ln(20);
$pdf->SetX(0);
$pdf->Cell(900, 0, '', 1, 1, 'J');       
$pdf->SetX(150);
$pdf->Cell(70, 8, utf8_decode('SABER - ESFUERZO - ESPERANZA'), 0, 1, 'J');    
$pdf->SetX(0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(900, 0, '', 1, 1, 'J');  
$pdf->Cell(0,10,utf8_decode('Pagína N°: ').$pdf->PageNo(),0,0,'R');
$pdf->Ln(3.5);
$pdf->Cell(0,10,'Impreso por SIA INEDA 2018',0,0,'R');
$pdf->Output();

}
