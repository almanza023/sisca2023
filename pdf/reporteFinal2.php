<?php 
$sede   = $_POST['sede'];
$grado   = $_POST['grado'];
$jornada = 'MATINAL';
$periodo=4;
 require_once "Conexion.php";
 include "fpdf/fpdf.php";
 $sql2 = "SELECT distinct m.id from calificaciones c inner join matriculas m on c.matricula_id=m.id
 where m.grado_id='$grado' and  c.periodo_id ='$periodo' and m.sede_id='$sede'";
    $res2 = $mysqli->query($sql2);
    $num1 = $res2->num_rows;    
    $i    = 1;
    $pdf  = new FPDF('P', 'mm', 'legal');
    $sql  = "SELECT distinct c.matricula_id, e.nombres, 
    e.apellidos, g.descripcion, s.nombre, e.num_doc, m.folio 
    from calificaciones c 
    inner join matriculas m on m.id=c.matricula_id inner join grados g on m.grado_id=g.id inner join sedes s on m.sede_id=s.id inner join estudiantes e on m.estudiante_id=e.id
    where m.grado_id='$grado' and  c.periodo_id='$periodo' and  m.sede_id='$sede' order by e.apellidos asc";    
    
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
            $pdf->SetFillColor(232, 232, 232);
         $pdf->Cell(198, 6, utf8_decode(' INFORME FINAL'), 1, 1, 'C', 1); 
         $pdf->SetFont('Arial', '', 9);
            $idest= $reg['0'];  
            $nom = $reg['1'] . ' ' . $reg['2'];
            $pdf->Cell(113, 4, 'NOMBRE: ' . utf8_decode($nom), 1, 0, 'J');
            $pdf->Cell(47, 4, 'GRADO: ' . $reg['3'], 1, 0, 'J');
            $pdf->Cell(38, 4, 'PERIODO: FINAL', 1, 1, 'J');
            $pdf->Cell(40, 5, 'SEDE: ' . $reg['4'], 1, 0, 'J');     
         $pdf->Cell(40, 5, utf8_decode(' N° DOC: ') . $reg['5'], 1, 0, 'J');
        $pdf->Cell(33, 5, utf8_decode(' N° FOLIO: ') . $reg['6'], 1, 0, 'J');
        $pdf->Cell(47, 5, utf8_decode(' JORNADA: ') . $jornada, 1, 0, 'J');
        $pdf->Cell(38, 5, utf8_decode(' AÑO: 2021 '), 1, 1, 'J');
        $pdf->Ln();
        $pdf->SetFillColor(232, 232, 232);
             $pdf->SetFont('Arial', 'B', 9); 
             $pdf->Cell(8, 6, ' IHS', 1, 0, 'C', 1);
            $pdf->Cell(170, 6, utf8_decode('ARÉAS Y/O ASIGNATURAS: '), 1, 0, 'J', 1);  
            $pdf->SetX(188);         
            $pdf->Cell(20, 6, 'NOTA  ', 1, 1, 'C', 1);
             $pdf->SetFont('Arial', '', 10);             
             //matematicas                        
                $c1=0;  
                $ac=0;   
                $arper=0;     
                $acp1=0; $acp2=0; $acp3=0; $acih=0; $acmat=0; $conMat=0;  $aclp1=0; $acomat=0;
                $contLen=0; $contSoc=0; $contOM=0; $aclp2=0; $aclp3=0; $aclen=0;  
             $sql1 = "SELECT * from calificaciones  where matricula_id='$idest'  and periodo_id='$periodo' and orden>1 and orden<=1.3  order by orden asc";
            $res1 = $mysqli->query($sql1);           
            while ($reg1 = $res1->fetch_row()) {               
                $pdf->SetFont('Arial', '', 8);
                $pdf->SetX(18);
               $idasig=$reg1['2'];
                $nota=$reg1['6'];
                $sqlm = "SELECT c.ihs, c.porcentaje, a.nombre, c.asignatura_id from carga_academicas c inner join asignaturas a on a.id=c.asignatura_id where c.asignatura_id='$idasig' and c.grado_id='$grado' and c.sede_id='$sede' ";  
            $resm = $mysqli->query($sqlm);
            while ($regm=$resm->fetch_row()) {
                $sqlnp = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='5'";
             $notaN=0;
            $resnp = $mysqli->query($sqlnp);
            $nv1=$resnp->num_rows;
            $notaN=0;    
              if($nv1>0){
                $regnp = $resnp->fetch_row();
                $pdf->SetX(188);
                $notaN=$regnp['0'];
                $pdf->SetFillColor(232, 232, 232);
                $conMat++; 
              }           
            
           $notap3N=0;        
            $sqlnp3 = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='3'";
            $resnp3 = $mysqli->query($sqlnp3);           
            $regnp3 = $resnp3->fetch_row();
             if (!empty($regnp3['0'])) {
             $notap3N=$regnp3['0'];
            }
           $notap2N=0;        
            $sqlnp2 = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='2'";
            $resnp2 = $mysqli->query($sqlnp2);           
            $regnp2 = $resnp2->fetch_row();
             if (!empty($regnp2['0'])) {
             $notap2N=$regnp2['0'];
                 }
             $notap1N=0;
             $np=0;
            $sqlnp1 = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='1'";
            $resnp1 = $mysqli->query($sqlnp1);           
                $regnp1 = $resnp1->fetch_row();
          if (!empty($regnp1['0'])) {
            $notap1N=$regnp1['0'];
          }
            //calificaciones
             $sqlcp3 = "SELECT nota from calificaciones where matricula_id='$idest' and periodo_id='3'  and asignatura_id='$idasig' ";
            $rescp3 = $mysqli->query($sqlcp3);
            if ($rescp3) {
                $regcp3 = $rescp3->fetch_row();                  
                $ncp3=$regcp3['0'];   
                $np3=1;
            
            } else {
               $ncp3=0.0;
            }           
                       
           $sqlcp2 = "SELECT nota from calificaciones where matricula_id='$idest' and periodo_id='2' and asignatura_id='$idasig' ";
            $rescp2 = $mysqli->query($sqlcp2);
            if ($rescp2) {
               $regcp2 = $rescp2->fetch_row();                     
                $ncp2=$regcp2['0'];   
                $np2=1;
              
            } else {
               $ncp2=0.0;
            }           
            
            $sqlp1 = "SELECT nota from calificaciones where matricula_id='$idest' and periodo_id='1' and  asignatura_id='$idasig' ";
            $rescp1 = $mysqli->query($sqlp1);
            $regcp1 = $rescp1->fetch_row();
            if(empty($regcp1['0'])){
                $ncp1=0;
              }else{
                $ncp1=$regcp1['0'];   
                $np1=1; 
              }      
            
            
             if (empty($notap1N)) {
                 $ntemp=round($ncp1*($regm['1']/100),1);                     
                $acp1=$acp1+$ntemp;                    
                    $nper1=$ncp1;
                  
             } else {
                $ntemp1=round($notap1N*($regm['1']/100),1); 
                 $acp1=$acp1+$ntemp1;
                 $nper1=$notap1N;                 
             }
             if (empty($notap2N)) {
                 $ntemp=round($ncp2*($regm['1']/100),1);                     
                $acp2=$acp2+$ntemp;                  
                    $nper2=$ncp2;                   
                   
             } else {
                $ntemp=round($notap2N*($regm['1']/100),1); 
                 $acp2=$acp2+$ntemp;
                 $nper2=$notap2N;                  
             }
              if (empty($notap3N)) {
                 $ntemp=round($ncp3*($regm['1']/100),1);                     
                $acp3=$acp3+$ntemp;                   
                    $nper3=$ncp3;                 
                   
             } else {
                $ntemp=round($notap3N*($regm['1']/100),1); 
                 $acp3=$acp3+$ntemp;
                 $nper3=$notap3N;                
             }
            
                $c1=1;
                $pdf->SetX(10);
                $iha=$regm['0'];
                $acih=$acih+$iha;
               $pdf->Cell(8, 6, $regm['0'], 1, 0, 'C');
               $pdf->SetX(18);
               $pdf->SetFont('Arial', '', 8);
               $pdf->Cell(170, 6, utf8_decode($regm['2'].'     '.$regm['1']).' '.utf8_decode("%"), 1, 0, 'J');               
                $por=$regm['1']/100;            
               $nt=round($nota*$por,1);                                              
                $def=($nper1+$nper2+$nper3+$nota)/4;  
               $proma=round($def,1);
            if (!empty($notaN)) {
                $niv=round($notaN*($regm['1']/100),1); 
              $pdf->SetX(188);
            $pdf->SetFont('Arial', 'B', 8);   
            $pdf->Cell(20, 6, $notaN, 1, 1, 'J');
                $acmat=$acmat+$niv;
            } else {
              $pdf->SetX(188);               
         $pdf->SetFont('Arial', 'B', 8);   
         $ntemp=round($proma*($regm['1']/100),2);
            $pdf->Cell(20, 6, $proma, 1, 1, 'J'); 
            $acmat=$acmat+$ntemp;
           }          
                    
            break;
            }

            $notaN=0;                   
            }    
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetX(10);
            $pdf->Cell(8, 6,$acih , 1, 0, 'C' );
            $pdf->SetX(18);            
            $pdf->SetFillColor(232, 232, 232);
            $pdf->Cell(170, 6, utf8_decode("MATEMATICAS (GEOMETRIA - ESTADISTICA - MATEMATICA)").'    '.utf8_decode('100%'), 1, 0, 'J', 1);       
            $pdf->SetX(188);            
             $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 6, round($acmat,1), 1, 1, 'J',1);  
             if ($acmat>=0 && $acmat<=2.99) {
                    $sql3   = "SELECT * from prefijos where id='8'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $id=$reg['0'];                  
                    $arper++;

                } elseif ($acmat>=3 && $acmat<=3.99) {
                  $sql3   = "SELECT * from prefijos where id='7'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $id=$reg['0']; 
                } elseif ($acmat>=4 && $acmat<=4.49) {
                    $sql3   = "SELECT * from prefijos where id='6'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $id=$reg['0']; 
                } else {
                    $sql3   = "SELECT * from prefijos where id='5'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $id=$reg['0']; 
                }
                $sql3   = "SELECT * from prefijos where id='$id' ";
                $res3   = $mysqli->query($sql3);
                $pdf->SetFont('Arial', '', 8);
                while ($reg3 = $res3->fetch_row()) {   
                    $pdf->SetFillColor(255, 255, 255);
                    $pdf->MultiCell('198', '7', utf8_decode($reg3['1']), 1, 1, 'J',true);             
                }
                if ($conMat>0) {
                if ($acmat<3) {
                  $pdf->MultiCell('198', '7', utf8_decode('Estudiante Presentó Nivelación  y REPROBO'), 1, 1, 'J',true);
                } else {                
                }
                }
                $pdf->Ln(2);
            $conMat=0;                 
            $acp2=0;
            $acp1=0;
            $acp3=0;
            $acih=0;
             $acihl=0;
            //Lenguaje
            $c2=0;  
            $acl=0;          
        $sql1 = "SELECT * from calificaciones where matricula_id='$idest'  and periodo_id='$periodo' and orden>2 and orden<=2.4  order by orden asc";
            $res1 = $mysqli->query($sql1);           
            while ($reg1 = $res1->fetch_row()) {                   
                $pdf->SetFont('Arial', '', 8);
                $pdf->SetX(18);
                $idasig=$reg1['2'];
                $nota=$reg1['6'];
                $sqlm = "SELECT c.ihs, c.porcentaje, a.nombre, c.asignatura_id from carga_academicas c inner join asignaturas a on a.id=c.asignatura_id where c.asignatura_id='$idasig' and c.grado_id='$grado' and c.sede_id='$sede' ";  
            $resm = $mysqli->query($sqlm);
            while ($regm=$resm->fetch_row()) { 
                $notaN=0;
                $sqlnp = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='5'";
            $resnp = $mysqli->query($sqlnp);     
            $nv1=$resnp->num_rows;
            $notaN=0;    
              if($nv1>0){
                $regnp = $resnp->fetch_row();
                $pdf->SetX(188);
                $notaN=$regnp['0'];
                $pdf->SetFillColor(232, 232, 232);
                $contLen++;
              }         
            
             $notap3N=0;             
            $sqlnp3 = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='3'";
            $resnp3 = $mysqli->query($sqlnp3);           
           $regnp3 = $resnp3->fetch_row();
             if (!empty($regnp3['0'])) {
                $notap3N=$regnp3['0'];
            } 
             $notap2N=0;             
            $sqlnp2 = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='2'";
            $resnp2 = $mysqli->query($sqlnp2);           
            $regnp2 = $resnp2->fetch_row();
              if (!empty($regnp2['0'])) {
                $notap2N=$regnp2['0'];
              }  
             $notap1N=0;             
            $sqlnp1 = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='1'";
            $resnp1 = $mysqli->query($sqlnp1);           
            $regnp1 = $resnp1->fetch_row();
            if (!empty($regnp1['0'])) {
                $notap1N=$regnp1['0'];
            }    
            $sqlp3 = "SELECT nota from calificaciones where matricula_id='$idest'  and periodo_id='3'  and asignatura_id='$idasig'";
            $rescp3 = $mysqli->query($sqlp3);
            if ($rescp3) {
              $regcp3 = $rescp3->fetch_row();                    
              $nclp3=$regcp3['0'];               
              
            } else {
               $nclp3=0.0;
            }            
                    
            $sqlcp2 = "SELECT nota from calificaciones where matricula_id='$idest'  and periodo_id='2'  and asignatura_id='$idasig'";
            $rescp2 = $mysqli->query($sqlcp2);
            if ($rescp2) {
            $regcp2 = $rescp2->fetch_row();                    
            $nclp2=$regcp2['0'];               
              
            } else {
                $nclp2=0.0;
            }
            $sqlcp1 = "SELECT nota from calificaciones where matricula_id='$idest'  and periodo_id='1'  and asignatura_id='$idasig'";
            $rescp1 = $mysqli->query($sqlcp1);           
            $regcp1 = $rescp1->fetch_row();
            if(empty($regcp1['0'])){
              $nclp1=0;
            }else{
              $nclp1=$regcp1['0'];
            }                 
            
             if (empty($notap1N)) {
                 $ntemp=round($nclp1*($regm['1']/100),1);                    
                $aclp1=$aclp1+$ntemp;            
                    $np1=$nclp1;
                 
                   
             } else {
                $ntemp=round($notap1N*($regm['1']/100),1); 
                 $aclp1=$aclp1+$ntemp;
                 $np1=$notap1N;                 
             }
             if (empty($notap2N)) {
                 $ntemp=round($nclp2*($regm['1']/100),1);                    
                $aclp2=$aclp2+$ntemp;                   
                $np2=$nclp2;                                 
             } else {
                $ntemp=round($notap2N*($regm['1']/100),1); 
                 $aclp2=$aclp2+$ntemp;
                 $np2=$notap2N;                  
             }
             if (empty($notap3N)) {
                 $ntemp=round($nclp3*($regm['1']/100),1);                    
                $aclp3=$aclp3+$ntemp;                   
                    $np3=$nclp3;                                  
             } else {
                $ntemp=round($notap3N*($regm['1']/100),1); 
                 $aclp3=$aclp3+$ntemp;
                 $np3=$notap3N;                 
             }           
                $c2=1;
                $pdf->SetX(10);
                $iha=$regm['0'];
                $acihl=$acihl+$iha;
               $pdf->Cell(8, 6, $regm['0'], 1, 0, 'C');
               $pdf->SetX(18);
               $pdf->SetFont('Arial', '', 8);
               $pdf->Cell(170, 6, utf8_decode($regm['2'].'     '.$regm['1']).' '.utf8_decode("%"), 1, 0, 'J');              
                $por=$regm['1']/100;            
               $nt=round($nota*$por,1);                                              
                $defl=($np1+$np2+$np3+$nota)/4;  
                $acl=$acl+$nt;           
            $promal=round($defl,1);          
           if (!empty($notaN)) {
                $niv=round($notaN*($regm['1']/100),1); 
              $pdf->SetX(188);
            $pdf->SetFont('Arial', 'B', 8);   
            $pdf->Cell(20, 6, $notaN, 1, 1, 'J');
            $aclen=$aclen+$niv;
            } else {
              $pdf->SetX(188);               
         $pdf->SetFont('Arial', 'B', 8);   
         $ntemp=round($promal*($regm['1']/100),1);
            $pdf->Cell(20, 6, $promal, 1, 1, 'J'); 
            $aclen=$aclen+$ntemp;
           }          
                    
            break;
            }

            $notaN=0;

                   
            } 
              
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetX(10);
            $pdf->Cell(8, 6,$acihl , 1, 0, 'C' );
            $pdf->SetX(18); 
            $pdf->SetFillColor(232, 232, 232);           
            $pdf->Cell(170, 6, utf8_decode("HUMANIDADES (LECTURA - CASTELLANO)").'    '.utf8_decode('100%'), 1, 0, 'J', 1);       
            $pdf->SetX(188);           
             $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(20, 6, round($aclen,1), 1, 1, 'J',1);  
            if ($aclen>=0 && $aclen<=2.99) {
                    $sql3   = "SELECT * from prefijos where id='8'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $id=$reg['0'];                  
                    $arper++;

                } elseif ($aclen>=3 && $aclen<=3.99) {
                   $sql3   = "SELECT * from prefijos where id='7'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $id=$reg['0'];
                } elseif ($aclen>=4 && $aclen<=4.49) {
                     $sql3   = "SELECT * from prefijos where id='6'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $id=$reg['0'];
                } else {
                    $sql3   = "SELECT * from prefijos where id='5'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $id=$reg['0'];
                }
                 $sql3   = "SELECT * from prefijos where id='$id' ";
                $res3   = $mysqli->query($sql3);
                $pdf->SetFont('Arial', '', 8);
                while ($reg3 = $res3->fetch_row()) {   
                    $pdf->SetFillColor(255, 255, 255);
                    $pdf->MultiCell('198', '7', utf8_decode($reg3['1']), 1, 1, 'J',true);             
                }
                if ($contLen>0) {
                if ($aclen<3) {
                  $pdf->MultiCell('198', '7', utf8_decode('Estudiante Presentó Nivelación  y REPROBO'), 1, 1, 'J',true);
                } else {                 
                }
                }
            $contLen=0;
            $aclp1=0;
            $aclp2=0;
            $aclp3=0;
            $acih=0;
            $acihl=0;
            $pdf->Ln(2);
        
        //OTRAS MATERIAS
        $act=0;
        $c5=0;
        $ac5=0;   
        $acomp1=0; 
$sql1 = "SELECT  * from calificaciones where matricula_id='$idest'  and periodo_id='$periodo'  and orden>=3  order by orden asc";
      $res1 = $mysqli->query($sql1);           
            while ($reg1 = $res1->fetch_row()) {
                $pdf->SetFillColor(232, 232, 232);
               $c5++;
             $notaN=0;
               $ac5=$ac5+$c5; 
                $pdf->SetFont('Arial', '', 8);
                $pdf->SetX(18);
                $idasig=$reg1['2'];
                $sqlm = "SELECT c.ihs, c.porcentaje, a.nombre, c.asignatura_id from carga_academicas c inner join asignaturas a on a.id=c.asignatura_id where c.asignatura_id='$idasig' and c.grado_id='$grado' and c.sede_id='$sede' ";       
            $resm = $mysqli->query($sqlm);
            while ($regm=$resm->fetch_row()) { 
           $sqln1 = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='FINAL'";
            $resnp = $mysqli->query($sqln1);           
            $nv1=$resnp->num_rows;
            $notaN=0;    
              if($nv1>0){
                $regnp = $resnp->fetch_row();
                $pdf->SetX(188);
                $notaN=$regnp['0'];
                $pdf->SetFillColor(232, 232, 232);
                $contOM++;
              }
            
           $notap3N=0;
            $np3=0;
            $sqlnp3 = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='3'";
            $resnp3 = $mysqli->query($sqlnp3);           
            $regnp3 = $resnp3->fetch_row();
            if (!empty($regnp3['0'])) {
             $notap3N=$regnp3['0'];
            }
            $notap2N=0;
            $np2=0;
            $sqlnp2 = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='2'";
            $resnp2 = $mysqli->query($sqlnp2);           
            $regnp2 = $resnp2->fetch_row();
            if (!empty($regnp2['0'])) {
                $notap2N=$regnp2['0'];
            }
            $notap1N=0;
            $np1=0;
            $sqlnp1 = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='1'";
            $resnp1 = $mysqli->query($sqlnp1);           
            $regnp1 = $resnp1->fetch_row();
              if (!empty($regnp1['0'])) {
                $notap1N=$regnp1['0'];
              }
            $sqlmp3 = "SELECT nota from calificaciones where matricula_id='$idest' and periodo_id ='3'   and asignatura_id='$idasig'";
            $resmp3 = $mysqli->query($sqlmp3);
            $regcp3 = $resmp3->fetch_row();
            if(empty($regcp3['0'])){
              $ncomp3=0;
            }else{
                $ncomp3=$regcp3['0'];
            }
                         
            $sqlmp2 = "SELECT nota from calificaciones where matricula_id='$idest'  and periodo_id ='2' and asignatura_id='$idasig'";
            $resmp2 = $mysqli->query($sqlmp2);
            $regcp2 = $resmp2->fetch_row();
            if(empty($regcp2['0'])){
              $ncomp1=0;
            }else{
                $ncomp2=$regcp2['0'];
            }

            $sqlmp1 = "SELECT nota from calificaciones where matricula_id='$idest' and periodo_id ='1'  and asignatura_id='$idasig'";
          
            $resmp1 = $mysqli->query($sqlmp1);
            $regcp1 = $resmp1->fetch_row();
            if(empty($regcp1['0'])){
              $ncomp1=0;
            }else{
                $ncomp1=$regcp1['0'];
            }               
           
             if (empty($notap1N)) {                   
                    $pdf->SetX(112);
                    $np1=$ncomp1;                                      
             } else {                           
                 $np1=$notap1N;                 
             }
             if (empty($notap2N)) {       
                    $np2=$ncomp2;                                 
             } else {                           
                 $np2=$notap2N;                
             }
             if (empty($notap3N)) {          
                  
                    $np3=$ncomp3;                                       
             } else {                           
                 $np3=$notap3N;                 
             }
                $pdf->SetX(10);                
               $pdf->Cell(8, 6, $regm['0'], 1, 0, 'C');
               $pdf->SetX(18);
               $pdf->SetFont('Arial', 'B', 8);
               $pdf->Cell(170, 6, utf8_decode($regm['2'].'     '.$regm['1']).' '.utf8_decode("%"), 1, 0, 'J',1);   
                $nota_a=$reg1['6'];                
                $por=$regm['1']/100;            
               $nt=round($nota*$por,1);                                                     
                $def=($np1+$np2+$np3+$nota_a)/4;                 
            $promom=round($def,1);           
              if (!empty($notaN)) {
               $pdf->SetX(188);
         $pdf->SetFont('Arial', 'B', 8);   
            $pdf->Cell(20, 6, $notaN, 1, 1, 'J',1);           
            $pdf->SetFont('Arial', '', 8); 
            $acomat=$acomat+$notaN; 
            $nd=$notaN;
            }else {
             $pdf->SetX(188);
         $pdf->SetFont('Arial', 'B', 8);   
            $pdf->Cell(20, 6, $promom, 1, 1, 'J',1);           
            $pdf->SetFont('Arial', '', 8);
             $nd=$promom;
            $acomat=$acomat+$promom;      
            }
             if ($nd>=0 && $nd<=2.99) {
                    $sql3   = "SELECT * from prefijos where id='8'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $id=$reg['0'];                  
                    $arper++;

                } elseif ($nd>=3 && $nd<=3.99) {
                   $sql3   = "SELECT * from prefijos where id='7'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $id=$reg['0']; 
                } elseif ($nd>=4 && $nd<=4.49) {
                    $sql3   = "SELECT * from prefijos where id='6'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $id=$reg['0']; 
                } else {
                    $sql3   = "SELECT * from prefijos where id='5'";
                    $res3   = $mysqli->query($sql3);
                    $reg = $res3->fetch_row();
                    $id=$reg['0']; 
                }
                
                $sql3   = "SELECT * from prefijos where id='$id' ";
               
                $res3   = $mysqli->query($sql3);
                $pdf->SetFont('Arial', '', 8);
                $reg3 = $res3->fetch_row();  
                $pdf->SetFillColor(255, 255, 255);
                $pdf->MultiCell('198', '7', utf8_decode($reg3['1']), 1, 1, 'J',true);            
                
            if ($contOM>0) {
                if ($nd<3) {
                  $pdf->MultiCell('198', '7', utf8_decode('Estudiante Presentó Nivelación  y REPROBO'), 1, 1, 'J',true);
                } else {                 
                }
                }
            $contOM=0;                                  
           
                $aclp1=0;
                $aclp2=0;
                $aclp3=0;
                $pdf->Ln(2);
                break;
            }           
        }           
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetFillColor(232, 232, 232);            
    $pdf->Cell(198, 6, ' DISCIPLINA ', 1, 1, 'J', 1);
    $sqlc=  "SELECT descripcion  from logros_disciplinarios  where periodo_id='5' and sede_id='$sede' and grado_id='$grado' "; 
            $resc = $mysqli->query($sqlc); 
            $regc=$resc->fetch_row();           
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetFillColor(255, 255, 255);  
            if(!empty($regc['0'])){
                $pdf->MultiCell('198', '5', ( utf8_decode($regc['0'])), 1, 1, 'J');
            }
           
        $tac=$acmat+$aclen+$acomat;
        $tc=$c1+$c2+$c5;
        if($tac>0 && $tc>0){
            $promg=$tac/$tc;
            $nprom=round($promg,1);
        }
        
        $acmat=0;
        $aclen=0;
        $acomat=0;
        $acsoc=0;
            if ($nprom>0 && $nprom<=2.99) {
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
            $pdf->Cell(198, 5, ' PROMEDIO FINAL: '.$nprom.'        '.utf8_decode($des), 1, 1, 'J', 1);       
             $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(198, 6, utf8_decode(' CONCEPTO COMISIÓN EVALUACIÓN Y PROMOCIÓN'), 1, 1, 'J', 1);
            if ($arper>=1) {
            $pdf->Cell(198, 6, utf8_decode(' REPROBO EL AÑO ELECTIVO '), 1, 1, 'C');
            $pdf->Cell(198, 5, utf8_decode(' N° ARÉAS PERDIDAS '.$arper), 1, 1, 'J');
            }
            if ($arper==1 ) {
           	
            }
            if ($arper==0) {
            $pdf->Cell(198, 6, utf8_decode(' PROMOVIDO AL SIGUIENTE GRADO  '), 1, 1, 'C');
            
            }
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(198, 6, ' OBSERVACIONES', 1, 1, 'J', 1);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(198, 9, ' ', 1, 1, 'J');
            $pdf->Ln(10);
            $pdf->Cell(80, 0, ' ', 1, 1, 'J');  
            $pdf->Ln(0.5);       
            $sql= "SELECT p.nombres, p.apellidos from direcciones_grados doc inner join docentes p ON p.id=docente_id where doc.grado_id='$grado' and doc.sede_id='$sede'";
            $resa = $mysqli->query($sql);
            $rega = $resa->fetch_row();                
            $nom_ac=$rega['0'].' '.$rega['1'];
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(190, 4,utf8_decode($nom_ac) , 0, 1, 'J');            
            $pdf->Cell(40, 6, 'Director de Grupo', 0, 1, 'J');     
            $pdf->Ln();
    }
        $arper=0;
        $i++;

    }
    $pdf->Output();
   
?>
