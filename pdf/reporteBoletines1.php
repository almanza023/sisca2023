<?php 
//fORMATO BOLETIN PARA GRADOS
//1° Y 2°
//
$sede   = $_POST['sede'];
$grado   = $_POST['grado'];
$jornada = $_POST['jornada'];
$periodo = $_POST['periodo'];
if (isset($grado) && isset($jornada) && isset($periodo) && isset($sede)) {
require_once "../../config/Conexion.php";
include "fpdf/fpdf.php";
switch ($periodo) {
case '1':
//Obtener el numero de estudiante
$sql2 = "SELECT distinct idestudiante from calificaciones where idgrado='$grado' and  periodo ='$periodo' and idsede='$sede'";
    $res2 = $mysqli->query($sql2);
    $num1 = $res2->num_rows;    
    $i    = 1;
    $pdf  = new FPDF('P', 'mm', 'legal');
    $sql  = "SELECT distinct c.idestudiante, e.nombres, e.apellidos, g.descripcion, s.nombre, e.num_doc, e.folio from calificaciones c inner join estudiantes e on c.idestudiante=e.idestudiante inner join grados g on c.idgrado=g.idgrado inner join sedes s on c.idsede=s.idsede  where c.idgrado='$grado' and  periodo ='$periodo' and  c.idsede='$sede' order by e.apellidos asc";    
    $res  = $mysqli->query($sql);
    while ($i <= $num1) {
        while ($reg = $res->fetch_row()) {
            $pdf->AddPage();
            $pdf->SetFillColor(232, 232, 232);
            $sqlc="SELECT * FROM datos_colegio ";
            $resc=$mysqli->query($sqlc);
            $regc=$resc->fetch_row();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(190, 6, utf8_decode($regc[1]), 0, 1, 'C');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(190, 4, utf8_decode($regc[2]), 0, 1, 'C');
            $pdf->Cell(190, 4, utf8_decode(' Plantel de Carácter Oficial'), 0, 1, 'C');
            $pdf->Cell(190, 4, utf8_decode(' Resolución N° 1072 Mayo 31/04 y 1566 Agosto 06/04'), 0, 1, 'C');
            $pdf->Cell(190, 6, utf8_decode(' Código Icfes '.$regc[7]), 0, 1, 'C');
            $pdf->Cell(190, 6, utf8_decode($regc[6]), 0, 1, 'C');
            $pdf->Image('logo-ineda.png', 8, 6, 20);
            $pdf->SetFont('Arial', 'B', 10);          
            $pdf->Ln(2);
             $pdf->Cell(198, 6, utf8_decode(' INFORME ACADEMICO Y/O DISCIPLINARIO'), 1, 1, 'C', 1);           
            $pdf->SetFont('Arial', '', 8);
            $idest= $reg['0'];  
            $nom = $reg['1'] . ' ' . $reg['2'];
            $pdf->Cell(113, 4, 'Nombres: ' . $nom, 1, 0, 'J');
            $pdf->Cell(47, 4, 'Grado: ' . $reg['3'], 1, 0, 'J');
            $pdf->Cell(38, 4, 'Periodo: ' . $periodo, 1, 1, 'J');
            $pdf->Cell(40, 5, 'Sede: ' . $reg['4'], 1, 0, 'J');     
         $pdf->Cell(40, 5, utf8_decode(' N° Doc: ') . $reg['5'], 1, 0, 'J');
        $pdf->Cell(33, 5, utf8_decode(' N° Folio: ') . $reg['6'], 1, 0, 'J');
        $pdf->Cell(47, 5, utf8_decode(' Jornada: ') . $jornada, 1, 0, 'J');
        $pdf->Cell(38, 5, utf8_decode(' Año: 2020 '), 1, 1, 'J');
        $pdf->Ln();
            
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(102, 6, ' ', 0, 0, 'J');
        $pdf->Cell(96, 6, 'PERIODOS  ', 1, 1, 'C', 1);
        $pdf->Cell(8, 6, ' IHS', 1, 0, 'C', 1);
        $pdf->Cell(94, 6, utf8_decode('ARÉAS Y/O ASIGNATURAS: '), 1, 0, 'J', 1);
        $pdf->Cell(16, 6, 'I  ', 1, 0, 'C', 1);
        $pdf->Cell(16, 6, 'NIV  ', 1, 0, 'C', 1);
        $pdf->Cell(16, 6, 'II  ', 1, 0, 'C', 1);            
        $pdf->Cell(16, 6, 'III  ', 1, 0, 'C', 1);           
        $pdf->Cell(16, 6, 'IV  ', 1, 0, 'C', 1);            
        $pdf->Cell(16, 6, 'DEF  ', 1, 1, 'C', 1);
        $pdf->SetFont('Arial', '', 10);           
        $acih=0;
        $ac=0;
           
             //OTRAS MATERIAS
        $act=0;
        $c5=0;
        $ac5=0;
       $nota=0;
    $sql1 = "SELECT  distinct * from calificaciones where idestudiante='$idest'  and periodo='$periodo' and idgrado='$grado' and idsede='$sede' and orden>=1  order by orden asc";
            $res1 = $mysqli->query($sql1);           
            while ($reg1 = $res1->fetch_row()) {
               $c5++;
             $notaN=0;
            $ac5=$ac5+$c5; 
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetX(18);
                $idasig=$reg1['2'];
               $sqlm = "SELECT c.ihs, c.porcentaje, a.nombre, c.idasignatura from carga_academica c inner join asignaturas a on a.idasignatura=c.idasignatura where c.idasignatura='$idasig' and c.idgrado='$grado' and c.idsede='$sede' ";
        
            $resm = $mysqli->query($sqlm);
            while ($regm=$resm->fetch_row()) {   
            $sqln1 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='$periodo'";
            $resn1 = $mysqli->query($sqln1);
            $nv1=$resn1->num_rows;
            while ( $regn1 = $resn1->fetch_row()) {              
                $pdf->SetX(128);
                 $pdf->SetFont('Arial', 'B', 10);
                  $pdf->SetFillColor(232, 232, 232);
                 $pdf->Cell(16, 6, $regn1['0'], 1, 0, 'J',1);              
              $notaN=$regn1['0'];
            }
                $pdf->SetX(10);
                $iha=$regm['0'];
                $acil=$acil+$iha;
               $pdf->Cell(8, 6, $regm['0'], 1, 0, 'C');
               $pdf->SetX(18);
               $pdf->SetFont('Arial', 'B', 10);
                $pdf->SetFillColor(232, 232, 232);
               $pdf->Cell(94, 6, utf8_decode($regm['2']).'     '.utf8_decode($regm['1']).' '.utf8_decode("%"), 1, 0, 'J',1);   
                $nota_a=$reg1['5'];
               if (empty($notaN) ) {
                 $por=$regm['1']/100;            
               $nt=round($reg1['5']*$por,1);
               $nota=$reg1['5'];
                $act=$act+$nt;
               } else {
                 $por=$regm['1']/100;            
               $nt=round($notaN*$por,1);               
                 $act=$act+$nt;
               }               
               $pdf->SetX(112);
               $pdf->Cell(16, 6, $reg1['5'], 1, 0, 'J', 1);
               $pdf->SetX(112);        
            $proma=$nota;
            if (empty($notaN) ) {
            $pdf->SetX(192);
            $pdf->SetFont('Arial', 'B', 10);
           
            $pdf->Cell(16, 6, $proma, 1, 1, 'J');        
            } else {                
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetX(192);
             
            $pdf->Cell(16, 6, $notaN, 1, 1, 'J');  
            }   
             //Parte de Logros
            if ($nota_a>=0 && $nota_a<=2.99) {
                    $sql3   = "select * from prefijos where idprefijo='1'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];

                } elseif ($nota_a>=3 && $nota_a<=3.99) {
                   $sql3   = "select * from prefijos where idprefijo='2'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } elseif ($nota_a>=4 && $nota_a<=4.49) {
                $sql3   = "select * from prefijos where idprefijo='3'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } else {
                    $sql3   = "select * from prefijos where idprefijo='4'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                }
                  $pdf->SetFont('Arial', '', 9);
                $logro_c = $reg1['7'];
                $logro_d=$reg1['8'];
                $sql3   = "SELECT descripcion from logros_academicos where idlogro='$logro_c' and idasignatura='$idasig'";

                $resl   = $mysqli->query($sql3);
                while ($regl = $resl->fetch_row()) {                
                $pdf->SetFillColor(255, 255, 255);
                $pdf->MultiCell('198', '5', utf8_decode($pre1)." ".utf8_decode($regl['0'])." ".utf8_decode($su1), 1, 1, 'J',true);                  
                    
                }
                 $sql4   = "SELECT descripcion from logros_academicos where idlogro='$logro_d' and idasignatura='$idasig'";
                $res4   = $mysqli->query($sql4);
                while ($reg4 = $res4->fetch_row()) {
                    $pdf->SetFillColor(255, 255, 255);
                    $pdf->MultiCell('198', '5',utf8_decode( $reg4['0']), 1, 1, 'J');
                }              
            }
            
        }
             $pdf->SetFillColor(232, 232, 232);
            $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(198, 6, ' DISCIPLINA ', 1, 1, 'J', 1);
        $sqlc=  "SELECT l.descripcion  from convivencia_escolar c inner join logros_disciplinarios l on c.idlogro_dis=l.idlogro_dis where idestudiante='$idest' and c.idgrado='$grado' and c.periodo='$periodo' and c.idsede='$sede' ";        
            $resc = $mysqli->query($sqlc); 
            $regc=$resc->fetch_row();           
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetFillColor(255, 255, 255);  
            $pdf->MultiCell('198', '5', utf8_decode( $regc['0']), 1, 1, 'J');
        $tac=$ac+$acl+$acs+$act;
         $pdf->SetFillColor(232, 232, 232);
        $tc=$c2+$c2+$c5;
        $promg=$tac/$tc;
        $nprom=round($promg, 1);
            if ($nprom>=1 && $nprom<=2.99) {
                $des="DESEMPEÑO BAJO";
            } elseif ($nprom>=3 && $nprom<=3.99) {
                 $des="DESEMPEÑO BÁSICO";
            }elseif ($nprom>=4 && $nprom<=4.49) {
                 $des="DESEMPEÑO ALTO";
            } elseif($nprom>=4.5){
                $des="DESEMPEÑO SUPERIOR";
            }
            else {
           $des="";     
            }
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(198, 6, ' PROMEDIO DE PERIODO: '.$nprom.'        '.utf8_decode($des), 1, 1, 'J', 1);
            $pr=round($promg, 2);
            $pdf->Ln(0.5);       
            $sql= "SELECT p.nombres, p.apellidos  from direccion_grado d inner join personal p on d.iddocente=p.idpersonal where d.idgrado='$grado' and d.idsede='$sede'";
            $resa = $mysqli->query($sql);
            $rega = $resa->fetch_row();                
            $nom_ac=$rega['0'].' '.$rega['1'];
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(190, 4,utf8_decode($nom_ac) , 0, 1, 'J');            
            $pdf->Cell(40, 6, 'Director de Grupo', 0, 1, 'J');     
            $pdf->Ln(); 
                        
            
            }
                        
        $i++;

            
    }
    $a=1;
    //Para guardar puestos de estudiates
            /* foreach ($promedios as $key => $val) {
             $pdf->Cell(72, 5, "$key ", 1,0 , 'J',0);   
             $pdf->Cell(12, 5, "$val ", 1,1 , 'J',0); 
             $stmt = $mysqli->prepare("INSERT INTO puestos (idestudiante, periodo, promedio, puesto) VALUES (?, ?, ?, ?)");
                $stmt->bind_param('isdi', $key, $periodo, $val, $a);
                if ($stmt->execute()) {
                $pdf->Cell(190, 4, 'Guardado', 0, 1, 'J'); 
                }              
                $a++;                
      
            } */

             
            break;
         
break;
//periodo
case '2':
    $grad=$grado;
    $sql2 = "SELECT distinct idestudiante from calificaciones where idgrado='$grado' and  periodo ='$periodo' and idsede='$sede'";
    $res2 = $mysqli->query($sql2);
    $num1 = $res2->num_rows;    
    $i    = 1;
    $pdf  = new FPDF('P', 'mm', 'legal');
    $sql  = "SELECT distinct c.idestudiante, e.nombres, e.apellidos, g.descripcion, s.nombre, e.num_doc, e.folio from calificaciones c inner join estudiantes e on c.idestudiante=e.idestudiante inner join grados g on c.idgrado=g.idgrado inner join sedes s on c.idsede=s.idsede  where c.idgrado='$grado' and  periodo ='$periodo' and  c.idsede='$sede' order by e.apellidos asc";
    
    $res  = $mysqli->query($sql);
    while ($i <= $num1) {
        while ($reg = $res->fetch_row()) {
            $pdf->AddPage();
            $pdf->SetFillColor(232, 232, 232);
            $sqlc="SELECT * FROM datos_colegio ";
            $resc=$mysqli->query($sqlc);
            $regc=$resc->fetch_row();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(190, 6, utf8_decode($regc[1]), 0, 1, 'C');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(190, 4, utf8_decode($regc[2]), 0, 1, 'C');
            $pdf->Cell(190, 4, utf8_decode(' Plantel de Carácter Oficial'), 0, 1, 'C');
            $pdf->Cell(190, 4, utf8_decode(' Resolución N° 1072 Mayo 31/04 y 1566 Agosto 06/04'), 0, 1, 'C');
            $pdf->Cell(190, 6, utf8_decode(' Código Icfes '.$c[7]), 0, 1, 'C');
            $pdf->Cell(190, 6, utf8_decode($regc[6]), 0, 1, 'C');
            $pdf->Image('logo-ineda.png', 8, 6, 20);
            $pdf->SetFont('Arial', 'B', 10);          
            $pdf->Ln(2);
             $pdf->Cell(198, 6, utf8_decode(' INFORME ACADEMICO Y/O DISCIPLINARIO'), 1, 1, 'C', 1);           
            $pdf->SetFont('Arial', '', 8);
            $idest= $reg['0'];  
            $nom = $reg['1'] . ' ' . $reg['2'];
            $pdf->Cell(113, 4, 'Nombres: ' . utf8_decode($nom), 1, 0, 'J');
            $pdf->Cell(47, 4, 'Grado: ' . $reg['3'], 1, 0, 'J');
            $pdf->Cell(38, 4, 'Periodo: ' . $periodo, 1, 1, 'J');
            $pdf->Cell(40, 5, 'Sede: ' . $reg['4'], 1, 0, 'J');     
        $pdf->Cell(40, 5, utf8_decode(' N° Doc: ') . $reg['5'], 1, 0, 'J');
        $pdf->Cell(33, 5, utf8_decode(' N° Folio: ') . $reg['6'], 1, 0, 'J');
        $pdf->Cell(47, 5, utf8_decode(' Jornada: ') . $jornada, 1, 0, 'J');
        $pdf->Cell(38, 5, utf8_decode(' Año: 2020 '), 1, 1, 'J');
        $pdf->Ln();
             $pdf->SetFont('Arial', 'B', 10);
             $pdf->Cell(102, 6, ' ', 0, 0, 'J');
             $pdf->Cell(96, 6, 'PERIODOS  ', 1, 1, 'C', 1);
             $pdf->Cell(8, 6 ,' IHS', 1, 0, 'C', 1);

            $pdf->Cell(94, 6, utf8_decode('ARÉAS Y/O ASIGNATURAS: '), 1, 0, 'J', 1);
            $pdf->Cell(16, 6, 'I  ', 1, 0, 'C', 1);
            $pdf->Cell(16, 6, 'II  ', 1, 0, 'C', 1);
            $pdf->Cell(16, 6, 'NIV  ', 1, 0, 'C', 1);            
            $pdf->Cell(16, 6, 'III  ', 1, 0, 'C', 1);           
            $pdf->Cell(16, 6, 'IV  ', 1, 0, 'C', 1);            
            $pdf->Cell(16, 6, 'DEF  ', 1, 1, 'C', 1);
            $pdf->SetFont('Arial', '', 9);             
            
        //OTRAS MATERIAS
        $acdefs=0;
        $act=0;
        $c5=0;
        $ac5=0;   
        $acomp1=0; 
    $sql1 = "SELECT  distinct * from calificaciones where idestudiante='$idest'  and periodo='$periodo' and idgrado='$grado' and idsede='$sede' and orden>=1  order by orden asc";
             $res1 = $mysqli->query($sql1);           
            while ($reg1 = $res1->fetch_row()) {
               $c5++;
             $notaN=0;
               $ac5=$ac5+$c5; 
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetX(18);
                $idasig=$reg1['2'];
        $sqlm = "SELECT c.ihs, c.porcentaje, a.nombre, c.idasignatura from carga_academica c inner join asignaturas a on a.idasignatura=c.idasignatura where c.idasignatura='$idasig' and c.idgrado='$grado' and c.idsede='$sede' ";        
            $resm = $mysqli->query($sqlm);
            while ($regm=$resm->fetch_row()) { 
           $sqln1 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='$periodo'";
            $resn1 = $mysqli->query($sqln1);
            $nv1=$resn1->num_rows;
            while ( $regn1 = $resn1->fetch_row()) {            
                $pdf->SetX(144);
                 $pdf->SetFont('Arial', 'B', 9);
                 $pdf->SetFillColor(232, 232, 232);
                 $pdf->Cell(16, 6, $regn1['0'], 1, 0, 'J',1);              
              $notaN=$regn1['0'];
            }
            $notap1N=0;
            $sqlnp1 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='1' ";
            $resnp1 = $mysqli->query($sqlnp1);           
            while ( $regnp1 = $resnp1->fetch_row()) {                    
              $notap1N=$regnp1['0'];
            }                
            $sqlcp1 = "SELECT nota from calificaciones where idestudiante='$idest'  and periodo='1' and idgrado='$grado' and idsede='$sede' and idasignatura='$idasig'";
            $rescp1 = $mysqli->query($sqlcp1);
            $num=$rescp1->num_rows;
            if($num>0){
                $regcp1 = $rescp1->fetch_row();                   
                    $ncomp1=$regcp1['0'];                                 
              
            }else{
              $ncomp1=0;  
            }
           
             if (empty($notap1N)) {                   
                    $pdf->SetX(112);
                    $np1=$ncomp1;
                    $pdf->SetFont('Arial', 'B', 9);
                   $pdf->Cell(16, 6, $np1, 1, 0, 'J');                      
             } else {                           
                 $np1=$notap1N;
                 $pdf->SetX(112);
                   $pdf->Cell(16, 6, $notap1N, 1, 0, 'J', 1);  
             }
                $pdf->SetX(10);                
               $pdf->Cell(8, 6, $regm['0'], 1, 0, 'C');
               $pdf->SetX(18);
               $pdf->SetFont('Arial', 'B', 9);
               $pdf->SetFillColor(232, 232, 232);
               $pdf->Cell(94, 6, utf8_decode($regm['2']).'     '.utf8_decode($regm['1']).' '.utf8_decode("%"), 1, 0, 'J',1);   
                $nota_a=$reg1['5'];
                if ($nota_a<3 && !empty($notaN)) {                         
                $def=($np1+$notaN)/2; 
                $act=$act+$notaN;
                  } else {               
                $act=$act+$nota_a;                                            
                $def=($np1+$nota_a)/2;                  
                  }            
               $pdf->SetX(128);
               $pdf->Cell(16, 6, $reg1['5'], 1, 0, 'J',1);
               $pdf->SetX(112);
                $nota_a=$reg1['5'];     
            $pdf->SetFont('Arial', 'B', 9);
            $promom=round($def,1);           
             $pdf->SetX(192);
         $pdf->SetFont('Arial', 'B', 9);   
            $pdf->Cell(16, 6, $promom, 1, 1, 'J');           
            $pdf->SetFont('Arial', '', 10);  
          if ($nota_a>=0 && $nota_a<=2.99) {
                    $sql3   = "select * from prefijos where idprefijo='1'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];

                } elseif ($nota_a>=3 && $nota_a<=3.99) {
                   $sql3   = "select * from prefijos where idprefijo='2'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } elseif ($nota_a>=4 && $nota_a<=4.49) {
                $sql3   = "select * from prefijos where idprefijo='3'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } else {
                    $sql3   = "select * from prefijos where idprefijo='4'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                }
                  $pdf->SetFont('Arial', '', 9);
                $logro_c = $reg1['7'];
                $logro_d=$reg1['8'];
                $sql3   = "SELECT descripcion from logros_academicos where idlogro='$logro_c' and idasignatura='$idasig'";

                $resl   = $mysqli->query($sql3);
                while ($regl = $resl->fetch_row()) {                
                $pdf->SetFillColor(255, 255, 255);
                $pdf->MultiCell('198', '5', utf8_decode($pre1)." ".utf8_decode($regl['0'])." ".utf8_decode($su1), 1, 1, 'J',true);                  
                    
                }
                 $sql4   = "SELECT descripcion from logros_academicos where idlogro='$logro_d' and idasignatura='$idasig'";
                $res4   = $mysqli->query($sql4);
                while ($reg4 = $res4->fetch_row()) {
                    $pdf->SetFillColor(255, 255, 255);
                    $pdf->MultiCell('198', '5',utf8_decode( $reg4['0']), 1, 1, 'J');
                }              
                break;             
            }           
        }
        $pdf->SetFillColor(232, 232, 232);
            $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(198, 6, ' DISCIPLINA ', 1, 1, 'J', 1);
        $sqlc=  "SELECT l.descripcion  from convivencia_escolar c inner join logros_disciplinarios l on c.idlogro_dis=l.idlogro_dis where idestudiante='$idest' and c.idgrado='$grado' and c.periodo='$periodo' and c.idsede='$sede' ";        
            $resc = $mysqli->query($sqlc); 
            $regc=$resc->fetch_row();           
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetFillColor(255, 255, 255);  
            $pdf->MultiCell('198', '5', utf8_decode( $regc['0']), 1, 1, 'J');
        $tac=$acs+$acl+$act;
        $tc=$c2+$c3+$c5;
        $promg=$tac/$tc;
        $nprom=round($promg, 1);
            if ($nprom>=1 && $nprom<=2.99) {
                $des="DESEMPEÑO BAJO";
            } elseif ($nprom>=3 && $nprom<=3.99) {
                 $des="DESEMPEÑO BÁSICO";
            }elseif ($nprom>=4 && $nprom<=4.49) {
                 $des="DESEMPEÑO ALTO";
            } elseif($nprom>=4.5){
                $des="DESEMPEÑO SUPERIOR";
            }
            else {
           $des="";     
            }
            $pdf->SetFillColor(232, 232, 232);
                $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(198, 6, ' PROMEDIO DE PERIODO: '.$nprom.'        '.utf8_decode($des), 1, 1, 'J', 1);  
            $pdf->Ln(15);
            $pdf->Cell(80, 0, ' ', 1, 1, 'J');  
            $pdf->Ln(0.5);   
            $sql= "SELECT p.nombres, p.apellidos  from direccion_grado d inner join personal p on d.iddocente=p.idpersonal where d.idgrado='$grado' and d.idsede='$sede'";
            $resa = $mysqli->query($sql);
            $rega = $resa->fetch_row();                
            $nom_ac=$rega['0'].' '.$rega['1'];
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(190, 4,utf8_decode($nom_ac) , 0, 1, 'J');            
            $pdf->Cell(40, 6, 'Director de Grupo', 0, 1, 'J');     
            $pdf->Ln(); 
                        
            }

        $i++;

    }
        break;
case '3':
$idgrado=$grado;
$sql2 = "SELECT distinct idestudiante from calificaciones where idgrado='$idgrado' and  periodo ='$periodo' and idsede='$sede'";
    $res2 = $mysqli->query($sql2);
    $num1 = $res2->num_rows;    
    $i    = 1;
    $pdf  = new FPDF('P', 'mm', 'legal');
    $sql  = "SELECT distinct c.idestudiante, e.nombres, e.apellidos, g.descripcion, s.nombre, e.num_doc, e.folio from calificaciones c inner join estudiantes e on c.idestudiante=e.idestudiante inner join grados g on c.idgrado=g.idgrado inner join sedes s on c.idsede=s.idsede  where c.idgrado='$idgrado' and  periodo ='$periodo' and  c.idsede='$sede' order by e.apellidos asc";    
    $res  = $mysqli->query($sql);
    while ($i <= $num1) {
        while ($reg = $res->fetch_row()) {
            $pdf->AddPage();
            $pdf->SetFillColor(232, 232, 232);
            $sqlc="SELECT * FROM datos_colegio ";
            $resc=$mysqli->query($sqlc);
            $regc=$resc->fetch_row();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(190, 6, utf8_decode($regc[1]), 0, 1, 'C');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(190, 4, utf8_decode($regc[2]), 0, 1, 'C');
            $pdf->Cell(190, 4, utf8_decode(' Plantel de Carácter Oficial'), 0, 1, 'C');
            $pdf->Cell(190, 4, utf8_decode(' Resolución N° 1072 Mayo 31/04 y 1566 Agosto 06/04'), 0, 1, 'C');
            $pdf->Cell(190, 6, utf8_decode(' Código Icfes '.$c[7]), 0, 1, 'C');
            $pdf->Cell(190, 6, utf8_decode($regc[6]), 0, 1, 'C');
            $pdf->Image('logo-ineda.png', 8, 6, 20);
            $pdf->SetFont('Arial', 'B', 10);          
            $pdf->Ln(2);
             $pdf->Cell(198, 6, utf8_decode(' INFORME ACADEMICO Y/O DISCIPLINARIO'), 1, 1, 'C', 1);           
        $pdf->SetFont('Arial', '', 8);
        $idest= $reg['0'];  
        $nom = $reg['1'] . ' ' . $reg['2'];
        $pdf->Cell(113, 4, 'Nombres: ' . $nom, 1, 0, 'J');
        $pdf->Cell(47, 4, 'Grado: ' . $reg['3'], 1, 0, 'J');
        $pdf->Cell(38, 4, 'Periodo: ' . $periodo, 1, 1, 'J');
        $pdf->Cell(40, 5, 'Sede: ' . $reg['4'], 1, 0, 'J');     
        $pdf->Cell(40, 5, utf8_decode(' N° Doc: ') . $reg['5'], 1, 0, 'J');
        $pdf->Cell(33, 5, utf8_decode(' N° Folio: ') . $reg['6'], 1, 0, 'J');
        $pdf->Cell(47, 5, utf8_decode(' Jornada: ') . $jornada, 1, 0, 'J');
        $pdf->Cell(38, 5, utf8_decode(' Año: 2020 '), 1, 1, 'J');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(102, 6, ' ', 0, 0, 'J');
        $pdf->Cell(96, 6, 'PERIODOS  ', 1, 1, 'C', 1);
        $pdf->Cell(8, 6, ' IHS', 1, 0, 'C', 1);
        $pdf->Cell(94, 6, utf8_decode('ARÉAS Y/O ASIGNATURAS: '), 1, 0, 'J', 1);
        $pdf->Cell(16, 6, 'I  ', 1, 0, 'C', 1);
        $pdf->Cell(16, 6, 'II  ', 1, 0, 'C', 1);
        $pdf->Cell(16, 6, 'III  ', 1, 0, 'C', 1);            
        $pdf->Cell(16, 6, 'NIV  ', 1, 0, 'C', 1);           
        $pdf->Cell(16, 6, 'IV  ', 1, 0, 'C', 1);            
        $pdf->Cell(16, 6, 'DEF  ', 1, 1, 'C', 1);
        $pdf->SetFont('Arial', '', 9);         //Lenguaje
        $c3=0;      
        $acs=0; 
        $acis=0;    
        $acsp1=0; 
        $acsp2=0; 
        $acdefs=0;  
        $notaN=0;
        $defs=0;
        $nt=0;          
        //OTRAS MATERIAS
        $act=0;
        $c5=0;
        $ac5=0;   
        $acomp1=0; 
        $sql1 = "SELECT  distinct * from calificaciones where idestudiante='$idest'  and periodo='$periodo' and idgrado='$grado' and idsede='$sede' and orden>=1  order by orden asc";
           $res1 = $mysqli->query($sql1);           
            while ($reg1 = $res1->fetch_row()) {
               $c5++;
             $notaN=0;
               $ac5=$ac5+$c5; 
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetX(18);
                $idasig=$reg1['2'];         
               $sqlm = "SELECT c.ihs, c.porcentaje, a.nombre, c.idasignatura from carga_academica c inner join asignaturas a on a.idasignatura=c.idasignatura where c.idasignatura='$idasig' and c.idgrado='$idgrado' and c.idsede='$sede' "; 
            $resm = $mysqli->query($sqlm);
            while ($regm=$resm->fetch_row()) { 
         $sqln1 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='$periodo'";
            $resn1 = $mysqli->query($sqln1);
            $nv1=$resn1->num_rows;
            $regn1 = $resn1->fetch_row();             
            if($nv1>0){
            $pdf->SetX(160);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetFillColor(232, 232, 232);
            $pdf->Cell(16, 6, $regn1['0'], 1, 0, 'J',1);              
            $notaN=$regn1['0'];
            }
            //Nivelacion de segundo periodo
            $notap2N=0;
            $sqlnp2 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='2'";
            $resnp2 = $mysqli->query($sqlnp2);           
            $regnp2 = $resnp2->fetch_row();                   
            $notap2N=$regnp2['0'];            
            $notap1N=0;
            $sqlnp1 = " SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='1'";
            $resnp1 = $mysqli->query($sqlnp1);           
            $regnp1 = $resnp1->fetch_row();                   
            $notap1N=$regnp1['0'];            
            //Calificaciones de segundo periodo
             $sqlcp2 = "SELECT nota from calificaciones where idestudiante='$idest'  and periodo='2' and idgrado='$idgrado' and idsede='$sede' and idasignatura='$idasig' ";
            $rescp2 = $mysqli->query($sqlcp2);
            $regcp2 = $rescp2->fetch_row();
            if (!empty($regcp2['0'])) {
            $ncomp2=$regcp2['0']; 
            }else {
            	$ncomp2=0;
            }                                           
              
            $sqlcp1 = "SELECT nota from calificaciones where idestudiante='$idest'  and periodo='1' and idgrado='$idgrado' and idsede='$sede' and idasignatura='$idasig'";
            $rescp1 = $mysqli->query($sqlcp1);
            $regcp1 = $rescp1->fetch_row();
            if (!empty($regcp1['0'])) {
             $ncomp1=$regcp1['0'];    
            }else {
            	$ncomp1=0;    
            }                 
                                                 
              
             if (empty($notap1N)) {  
                    $pdf->SetX(112);
                    $np1=$ncomp1;
                    $pdf->SetFont('Arial', '', 9);
                   $pdf->Cell(16, 6, $np1, 1, 0, 'J');  

             } else {                           
                 $np1=$notap1N;
                 $pdf->SetX(112);
                   $pdf->Cell(16, 6, $notap1N, 1, 0, 'J');  
             } if (empty($notap2N)) {
                $pdf->SetX(128);
                    $np2=$ncomp2;
                    $pdf->SetFont('Arial', '', 9);
                   $pdf->Cell(16, 6, $np2, 1, 0, 'J'); 
             } else {
                $pdf->SetX(128);
                 $np2=$notap2N;  
                 $pdf->SetFont('Arial', '', 9);               
                 $pdf->Cell(16, 6, $np2, 1, 0, 'J'); 
             }
             foreach ($variable as $key => $value) {
                 # code...
             }
             
               $pdf->SetX(10);                
               $pdf->Cell(8, 6, $regm['0'], 1, 0, 'C');
               $pdf->SetX(18);
               $pdf->SetFont('Arial', 'B', 9);
               $pdf->SetFillColor(232, 232, 232);
               $pdf->Cell(94, 6, utf8_decode($regm['2']).'     '.$regm['1'].' '.utf8_decode("%"), 1, 0, 'J',1);   
                $nota_a=$reg1['5'];
                if ($nota<3 && !empty($notaN)) {                                                 
                $def=($np1+$np2+$notaN)/3; 
                $act=$act+$notaN;
                  } else {
               $act=$act+$nota_a;                                            
                $def=($np1+$np2+$nota_a)/3;                 
                  }            
               $pdf->SetX(144);               
               $pdf->Cell(16, 6, $reg1['5'], 1, 0, 'J', 1);
               $pdf->SetX(112);
                $nota_a=$reg1['5'];     
            $pdf->SetFont('Arial', 'B', 9);
            $promom=round($def,1);           
            $pdf->SetX(192);
            $pdf->SetFont('Arial', 'B', 9);   
            $pdf->Cell(16, 6, $promom, 1, 1, 'J',1);           
            $pdf->SetFont('Arial', '', 9);  
           if ($nota_a>=0 && $nota_a<=2.99) {
                    $sql3   = "select * from prefijos where idprefijo='1'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];

                } elseif ($nota_a>=3 && $nota_a<=3.99) {
                   $sql3   = "select * from prefijos where idprefijo='2'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } elseif ($nota_a>=4 && $nota_a<=4.49) {
                $sql3   = "select * from prefijos where idprefijo='3'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } else {
                    $sql3   = "select * from prefijos where idprefijo='4'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                }
                $pdf->SetFont('Arial', '', 9);
                $logro_c = $reg1['7'];
                $logro_d=$reg1['8'];
                $sql3   = "SELECT descripcion from logros_academicos where idlogro='$logro_c' and idasignatura='$idasig'";
                $resl   = $mysqli->query($sql3);
                while ($regl = $resl->fetch_row()) {                
                $pdf->SetFillColor(255, 255, 255);
                $pdf->MultiCell('198', '5', utf8_decode($pre1)." ".utf8_decode($regl['0'])." ".utf8_decode($su1), 1, 1, 'J',true);                  
                    
                }
                 $sql4   = "SELECT descripcion from logros_academicos where idlogro='$logro_d' and idasignatura='$idasig'";
                $res4   = $mysqli->query($sql4);
                while ($reg4 = $res4->fetch_row()) {
                    $pdf->SetFillColor(255, 255, 255);
                    $pdf->MultiCell('198', '5',utf8_decode( $reg4['0']), 1, 1, 'J');
                }               
                break;   
                        
            }
                 
        }        
        $pdf->SetFillColor(232, 232, 232);
            $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(198, 6, ' DISCIPLINA ', 1, 1, 'J', 1);
            $sqlc=  "SELECT l.descripcion  from convivencia_escolar c inner join logros_disciplinarios l on c.idlogro_dis=l.idlogro_dis where idestudiante='$idest' and c.idgrado='$idgrado' and c.periodo='$periodo' and c.idsede='$sede' ";        
            $resc = $mysqli->query($sqlc); 
            $regc=$resc->fetch_row();           
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetFillColor(255, 255, 255);  
            $pdf->MultiCell('198', '5', utf8_decode( $regc['0']), 1, 1, 'J');     
        $tac=$acs+$acl+$act;
        $tc=$c2+$c3+$c5;
        $promg=$tac/$tc;
        $nprom=round($promg, 2);
            if ($nprom>=1 && $nprom<=2.99) {
                $des="DESEMPEÑO BAJO";
            } elseif ($nprom>=3 && $nprom<=3.99) {
                 $des="DESEMPEÑO BÁSICO";
            }elseif ($nprom>=4 && $nprom<=4.49) {
                 $des="DESEMPEÑO ALTO";
            } elseif($nprom>=4.5){
                $des="DESEMPEÑO SUPERIOR";
            }
            else {
           $des="";     
            }
            $pdf->SetFillColor(232, 232, 232);
                $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(198, 6, ' PROMEDIO DE PERIODO: '.round($promg, 1).'        '.utf8_decode($des), 1, 1, 'J', 1);
            $pr=round($promg, 2);           
            $pdf->SetFont('Arial', '', 9);
            
            $pdf->Ln(18);
            $pdf->Cell(80, 0, ' ', 1, 1, 'J');         
            $sql= "SELECT p.nombres, p.apellidos  from direccion_grado d inner join personal p on d.iddocente=p.idpersonal where d.idgrado='$idgrado' and d.idsede='$sede'";
            $resa = $mysqli->query($sql);
            $rega = $resa->fetch_row();                
            $nom_ac=$rega['0'].' '.$rega['1'];
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(190, 4,utf8_decode($nom_ac) , 0, 1, 'J');            
            $pdf->Cell(40, 6, ' Director de Grupo', 0, 1, 'J');        
            $pdf->Ln();
            }

        $i++;

    }
        break;
    //Cuarto Periodo
case '4':
 $sql2 = "SELECT distinct idestudiante from calificaciones where idgrado='$grado' and  periodo ='$periodo' and idsede='$sede'";
    $res2 = $mysqli->query($sql2);
    $num1 = $res2->num_rows;    
    $i    = 1;
    $pdf  = new FPDF('P', 'mm', 'legal');
    $sql  = "SELECT distinct c.idestudiante, e.nombres, e.apellidos, g.descripcion, s.nombre, e.num_doc, e.folio from calificaciones c inner join estudiantes e on c.idestudiante=e.idestudiante inner join grados g on c.idgrado=g.idgrado inner join sedes s on c.idsede=s.idsede  where c.idgrado='$grado' and  periodo ='$periodo' and  c.idsede='$sede' order by e.apellidos asc";    
    $res  = $mysqli->query($sql);
    while ($i <= $num1) {
        while ($reg = $res->fetch_row()) {
            $pdf->AddPage();
            $pdf->SetFillColor(232, 232, 232);
            $sqlc="SELECT * FROM datos_colegio ";
            $resc=$mysqli->query($sqlc);
            $regc=$resc->fetch_row();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(190, 6, utf8_decode($regc[1]), 0, 1, 'C');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(190, 4, utf8_decode($regc[2]), 0, 1, 'C');
            $pdf->Cell(190, 4, utf8_decode(' Plantel de Carácter Oficial'), 0, 1, 'C');
            $pdf->Cell(190, 4, utf8_decode(' Resolución N° 1072 Mayo 31/04 y 1566 Agosto 06/04'), 0, 1, 'C');
            $pdf->Cell(190, 6, utf8_decode(' Código Icfes '.$regc[7]), 0, 1, 'C');
            $pdf->Cell(190, 6, utf8_decode($regc[6]), 0, 1, 'C');
            $pdf->Image('logo-ineda.png', 8, 6, 20);
            $pdf->SetFont('Arial', 'B', 10);          
            $pdf->Ln(2);
             $pdf->Cell(198, 6, utf8_decode(' INFORME ACADÉMICO Y/O DISCIPLINARIO'), 1, 1, 'C', 1);           
            $pdf->SetFont('Arial', '', 8);
            $idest= $reg['0'];  
            $nom = $reg['1'] . ' ' . $reg['2'];
            $pdf->Cell(113, 4, 'Nombres: ' . $nom, 1, 0, 'J');
            $pdf->Cell(47, 4, 'Grado: ' . $reg['3'], 1, 0, 'J');
            $pdf->Cell(38, 4, 'Periodo: ' . $periodo, 1, 1, 'J');
            $pdf->Cell(40, 5, 'Sede: ' . $reg['4'], 1, 0, 'J');     
         $pdf->Cell(40, 5, utf8_decode(' N° Doc: ') . $reg['5'], 1, 0, 'J');
        $pdf->Cell(33, 5, utf8_decode(' N° Folio: ') . $reg['6'], 1, 0, 'J');
        $pdf->Cell(47, 5, utf8_decode(' Jornada: ') . $jornada, 1, 0, 'J');
        $pdf->Cell(38, 5, utf8_decode(' Año: 2020 '), 1, 1, 'J');
        $pdf->Ln();
             $pdf->SetFont('Arial', 'B', 8);
             $pdf->Cell(102, 6, ' ', 0, 0, 'J');
             $pdf->Cell(96, 6, 'PERIODOS  ', 1, 1, 'C', 1);
             $pdf->Cell(8, 6, ' IHS', 1, 0, 'C', 1);
        $pdf->Cell(94, 6, utf8_decode('ARÉAS Y/O ASIGNATURAS: '), 1, 0, 'J', 1);
            $pdf->Cell(16, 6, 'I  ', 1, 0, 'C', 1);
            $pdf->Cell(16, 6, 'II  ', 1, 0, 'C', 1);
            $pdf->Cell(16, 6, 'III  ', 1, 0, 'C', 1); 
            $pdf->Cell(16, 6, 'IV  ', 1, 0, 'C', 1); 
              $pdf->Cell(16, 6, 'NIV  ', 1, 0, 'C', 1);
            $pdf->Cell(16, 6, 'DEF  ', 1, 1, 'C', 1);
             $pdf->SetFont('Arial', '', 9);         
           
        //OTRAS MATERIAS
        $act=0;
        $c5=0;
        $ac5=0;   
        $acomp1=0; 
        $nota=0;
        $ac=0;
        $acl=0;
         $c1=0;
          $c2=0;
    $sql1 = "SELECT  distinct * from calificaciones where idestudiante='$idest'  and periodo='$periodo' and idgrado='$grado' and idsede='$sede' and orden>=1 order by orden asc";
            $res1 = $mysqli->query($sql1);           
            while ($reg1 = $res1->fetch_row()) {
               $c5++;
             $notaN=0;
               $ac5=$ac5+$c5; 
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetX(18);
                $idasig=$reg1['2'];                
     $sqlm = "SELECT c.ihs, c.porcentaje, a.nombre, c.idasignatura from carga_academica c inner join asignaturas a on a.idasignatura=c.idasignatura where c.idasignatura='$idasig' and c.idgrado='$grado' and c.idsede='$sede' ";        
            $resm = $mysqli->query($sqlm);
            while ($regm=$resm->fetch_row()) { 
            $sqln1 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='$periodo' ";
            $resn1 = $mysqli->query($sqln1);
            $nv1=$resn1->num_rows;
            while ( $regn1 = $resn1->fetch_row()) {              
                $pdf->SetX(160);
                 $pdf->SetFont('Arial', 'B', 9);
                 $pdf->SetFillColor(232, 232, 232);
                 $pdf->Cell(16, 6, $regn1['0'], 1, 0, 'J',1);              
              $notaN=$regn1['0'];
            }
             //Nivelacion de tercer periodo
            $notap3N=0;
            $sqlnp3 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='3'";
            $resnp3 = $mysqli->query($sqlnp3);           
            while ( $regnp3 = $resnp3->fetch_row()) {                    
              $notap3N=$regnp3['0'];
            } 
            //Nivelacion de segundo periodo
            $notap2N=0;
            $sqlnp2 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='2'";
            $resnp2 = $mysqli->query($sqlnp2);           
            while ( $regnp2 = $resnp2->fetch_row()) {                    
              $notap2N=$regnp2['0'];
            } 
            $notap1N=0;
            $sqlnp1 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='1'";
            $resnp1 = $mysqli->query($sqlnp1);           
            while ( $regnp1 = $resnp1->fetch_row()) {                    
              $notap1N=$regnp1['0'];
            } 
             //Calificaciones de Tercer periodo
             $sqlcp3 = "SELECT nota from calificaciones where idestudiante='$idest'  and periodo='3' and idgrado='$grado' and idsede='$sede' and idasignatura='$idasig' ";
            $rescp3 = $mysqli->query($sqlcp3);
            if($rescp3){
            while ( $regcp3 = $rescp3->fetch_row()) {                 
                    $ncomp3=$regcp3['0'];                                 
              }} else {
                   $ncomp3=0;
              }
            //Calificaciones de segundo periodo
             $sqlcp2 = "SELECT nota from calificaciones where idestudiante='$idest'  and periodo='2' and idgrado='$grado' and idsede='$sede' and idasignatura='$idasig' ";
            $rescp2 = $mysqli->query($sqlcp2);
            if($rescp2){
            while ( $regcp2 = $rescp2->fetch_row()) {                 
                    $ncomp2=$regcp2['0'];                                 
              }}else {
                  $ncomp2=0;
              }
            $sqlcp1 = "SELECT nota from calificaciones where idestudiante='$idest'  and periodo='1' and idgrado='$grado' and idsede='$sede' and idasignatura='$idasig' ";
            $rescp1 = $mysqli->query($sqlcp1);
            if($rescp1){
            while ( $regcp1 = $rescp1->fetch_row()) {                    
                    $ncomp1=$regcp1['0'];                                  
              }} else {
                  $ncomp1=0;
              }
             if (empty($notap1N)) {  
                    $pdf->SetX(112);
                    $np1=$ncomp1;
                    $pdf->SetFont('Arial', '', 9);
                   $pdf->Cell(16, 6, $np1, 1, 0, 'J');  

             } else {                           
                 $np1=$notap1N;
                 $pdf->SetX(112);
                   $pdf->Cell(16, 6, $notap1N, 1, 0, 'J');  
             } if (empty($notap2N)) {
                $pdf->SetX(128);
                    $np2=$ncomp2;
                    $pdf->SetFont('Arial', '', 9);
                   $pdf->Cell(16, 6, $np2, 1, 0, 'J'); 
             } else {
                $pdf->SetX(128);
                 $np2=$notap2N;  
                 $pdf->SetFont('Arial', '', 9);               
                   $pdf->Cell(16, 6, $np2, 1, 0, 'J'); 
             } if (empty($notap3N)) {
                $pdf->SetX(144);
                    $np3=$ncomp3;
                    $pdf->SetFont('Arial', '', 9);
                   $pdf->Cell(16, 6, $np3, 1, 0, 'J'); 
             } else {
                $pdf->SetX(144);
                 $np2=$notap3N;  
                 $pdf->SetFont('Arial', '', 9);               
                   $pdf->Cell(16, 6, $np3, 1, 0, 'J'); 
             }
             
                $pdf->SetX(10);                
               $pdf->Cell(8, 6, $regm['0'], 1, 0, 'C');
               $pdf->SetX(18);
               $pdf->SetFont('Arial', 'B', 9);
               $pdf->SetFillColor(232, 232, 232);
               $pdf->Cell(94, 6, $regm['2'].'     '.$regm['1'].' '.utf8_decode("%"), 1, 0, 'J',1);   
                $nota_a=$reg1['5'];

                if ($nota<3 && !empty($notaN)) {                                            
                $def=($np1+$np2+$np3+$notaN)/4; 
                $act=$act+$notaN;
                  } else {               
               $act=$act+$nota_a;                                            
                $def=($np1+$np2+$np3+$nota_a)/4;                 
                  }            
               $pdf->SetX(160);               
               $pdf->Cell(16, 6, $reg1['5'], 1, 0, 'J');
               $pdf->SetX(112);
                $nota_a=$reg1['5'];     
            $pdf->SetFont('Arial', 'B', 9);
            $promom=round($def,1);           
             $pdf->SetX(192);
         $pdf->SetFont('Arial', 'B', 9);   
            $pdf->Cell(16, 6, $promom, 1, 1, 'J',1);           
            $pdf->SetFont('Arial', '', 9);  
          if ($nota_a>=0 && $nota_a<=2.99) {
                    $sql3   = "select * from prefijos where idprefijo='1'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];

                } elseif ($nota_a>=3 && $nota_a<=3.99) {
                   $sql3   = "select * from prefijos where idprefijo='2'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } elseif ($nota_a>=4 && $nota_a<=4.49) {
                $sql3   = "select * from prefijos where idprefijo='3'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } else {
                    $sql3   = "select * from prefijos where idprefijo='4'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                }
                  $pdf->SetFont('Arial', '', 9);
                $logro_c = $reg1['7'];
                $logro_d=$reg1['8'];
                $sql3   = "SELECT descripcion from logros_academicos where idlogro='$logro_c' and idasignatura='$idasig'";
                $resl   = $mysqli->query($sql3);
                while ($regl = $resl->fetch_row()) {                
                $pdf->SetFillColor(255, 255, 255);
                $pdf->MultiCell('198', '5', utf8_decode($pre1)." ".utf8_decode($regl['0'])." ".utf8_decode($su1), 1, 1, 'J',true);                 
                    
                }
                 $sql4   = "SELECT descripcion from logros_academicos where idlogro='$logro_d' and idasignatura='$idasig'";
                $res4   = $mysqli->query($sql4);
                while ($reg4 = $res4->fetch_row()) {
                    $pdf->SetFillColor(255, 255, 255);
                    $pdf->MultiCell('198', '5',utf8_decode( $reg4['0']), 1, 1, 'J');
                }              
                break;             
            }           
        }
        $pdf->SetFillColor(232, 232, 232);
            $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(198, 6, ' DISCIPLINA ', 1, 1, 'J', 1);
     $sqlc=  "SELECT l.descripcion  from convivencia_escolar c inner join logros_disciplinarios l on c.idlogro_dis=l.idlogro_dis where idestudiante='$idest' and c.idgrado='$grado' and c.periodo='$periodo' and c.idsede='$sede' ";        
            $resc = $mysqli->query($sqlc); 
            $regc=$resc->fetch_row();           
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetFillColor(255, 255, 255);  
            $pdf->MultiCell('198', '5', utf8_decode( $regc['0']), 1, 1, 'J');    
        $tac=$ac+$acl+$act;
        $tc=$c1+$c2+$c5;
        $promg=$tac/$tc;
        $nprom=round($promg, 1);
            if ($nprom>=1 && $nprom<=2.99) {
                $des="DESEMPEÑO BAJO";
            } elseif ($nprom>=3 && $nprom<=3.99) {
                 $des="DESEMPEÑO BÁSICO";
            }elseif ($nprom>=4 && $nprom<=4.49) {
                 $des="DESEMPEÑO ALTO";
            } elseif($nprom>=4.5){
                $des="DESEMPEÑO SUPERIOR";
            }
            else {
           $des="";     
            }
            $pdf->SetFillColor(232, 232, 232);
                $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(198, 6, ' PROMEDIO DE PERIODO: '.round($promg, 1).'        '.utf8_decode($des), 1, 1, 'J', 1);
            $pr=round($promg, 2);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(198, 5, ' OBSERVACIONES', 1, 1, 'J', 1);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(198, 8, ' ', 1, 1, 'J');
           $pdf->Ln(15);
            $pdf->Cell(80, 0, ' ', 1, 1, 'J');         
            $sql= "SELECT p.nombres, p.apellidos  from direccion_grado d inner join personal p on d.iddocente=p.idpersonal where d.idgrado='$grado' and d.idsede='$sede'";
            $resa = $mysqli->query($sql);
            $rega = $resa->fetch_row();                
            $nom_ac=$rega['0'].' '.$rega['1'];
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(190, 4,utf8_decode($nom_ac) , 0, 1, 'J');            
            $pdf->Cell(40, 6, ' Director de Grupo', 0, 1, 'J');           
            $pdf->Ln();
            }

        $i++;

    }
        break;

    default:
    echo "error";
    break;
}
}
$pdf->Output();