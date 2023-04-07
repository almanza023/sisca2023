<?php 
$sede   = $_POST['sede'];
$grado   = $_POST['grado'];
$jornada = $_POST['jornada'];
$periodo=4;
 require_once "conexion.php";
 include "fpdf/fpdf.php";
$sql2 = "select distinct nombres, apellidos from calificaciones where grado='$grado' and jornada='$jornada' and  periodo ='$periodo' and sede='$sede'";
    $res2 = mysqli_query($conexion, $sql2);
    $num1 = mysqli_num_rows($res2);
    $i    = 1;
    $pdf  = new FPDF('P', 'mm', 'Legal');
    $sql  = "select distinct nombres, apellidos from calificaciones where grado='$grado' and jornada='$jornada' and  periodo ='$periodo' and sede='$sede' order by apellidos asc";
    $res  = mysqli_query($conexion, $sql);
    while ($i <= $num1) {
        while ($reg = mysqli_fetch_array($res)) {
            $pdf->AddPage();
            $pdf->SetFillColor(232, 232, 232);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(190, 6, utf8_decode('INSTITUCIÓN EDUCATIVA DON ALONSO '), 0, 1, 'C');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(190, 4, utf8_decode(' KR 9 CL 8-32'), 0, 1, 'C');
            $pdf->Cell(190, 4, utf8_decode(' Plantel de Carácter Oficial'), 0, 1, 'C');
            $pdf->Cell(190, 4, utf8_decode(' Resolución N° 1072 Mayo 31/04 y 1566 Agosto 06/04'), 0, 1, 'C');
            $pdf->Cell(190, 6, utf8_decode(' Código Icfes 092908 - 128413'), 0, 1, 'C');
            $pdf->Image('logo-ineda.png', 8, 6, 20);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(198, 6, utf8_decode(' INFORME ACADEMICO Y/O DISCIPLINARIO'), 1, 1, 'C', 1);
            $pdf->SetFont('Arial', '', 8);
            $n   = $reg['nombres'];
            $a=$reg['apellidos'];
            $nom = $reg['apellidos'] . ' ' . $reg['nombres'];
            $pdf->Cell(113, 5, 'Nombres: ' . utf8_decode($nom), 1, 0, 'J');
            $pdf->Cell(47, 5, 'Grado: ' . $grado, 1, 0, 'J');
            $pdf->Cell(38, 5, 'Periodo: ' . $periodo, 1, 1, 'J');
            $pdf->Cell(40, 5, 'Sede: ' . $sede, 1, 0, 'J');
            $sql0 = "select * from estudiantes where nombres='$n' and apellidos='$a' and sede='$sede'";
            $res0 = mysqli_query($conexion, $sql0);
            while ($reg0 = mysqli_fetch_array($res0)) {
                $pdf->Cell(40, 5, utf8_decode(' N° Doc: ') . $reg0['numero_doc'], 1, 0, 'J');
                $pdf->Cell(33, 5, utf8_decode(' N° Folio: ') . $reg0['numero_folio'], 1, 0, 'J');
                $pdf->Cell(47, 5, utf8_decode(' Jornada: ') . $jornada, 1, 0, 'J');
                $pdf->Cell(38, 5, utf8_decode(' Año: 2017 '), 1, 1, 'J');
                $pdf->Ln();
            }
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
             $pdf->SetFont('Arial', '', 10);             
             //matematicas
                $c1=0;  
                $ac=0;            
             $sql1 = "select  * from calificaciones where nombres='$n' and apellidos='$a' and periodo='$periodo' and grado='$grado' and sede='$sede'  and orden>1 and orden<=1.3  order by orden asc";
            $res1 = mysqli_query($conexion, $sql1);           
            while ($reg1 = mysqli_fetch_array($res1)) {
                $pdf->SetFont('Arial', '', 8);
                $pdf->SetX(18);
                $mat=$reg1['materias'];
                $nota=$reg1['nota'];
                $sqlm = "select distinct * from materias where nombre='$mat' and grado='$grado' and dependencia>0";
            $resm = mysqli_query($conexion, $sqlm);
            while ($regm=mysqli_fetch_array($resm)) {
                $sqlnp = "select * from nivelaciones where nombres='$n' and apellidos='$a' and materia='$mat' and periodo ='$periodo' and sede='$sede'";
            $resnp = mysqli_query($conexion, $sqlnp);           
            while ( $regnp = mysqli_fetch_array($resnp)) {              
                $pdf->SetX(176);
                $notaN=$regnp['nota'];
                $pdf->SetFillColor(232, 232, 232);
                 $pdf->Cell(16, 6, $notaN, 1, 0, 'J',1);        
            }
             $notap3N=0;        
            $sqlnp3 = "select * from nivelaciones where nombres='$n' and apellidos='$a' and materia='$mat' and sede='$sede' and periodo ='3'";
            $resnp3 = mysqli_query($conexion, $sqlnp3);           
            while ( $regnp3 = mysqli_fetch_array($resnp3)) {                    
              $notap3N=$regnp3['nota'];
            }
            $notap2N=0;        
            $sqlnp2 = "select * from nivelaciones where nombres='$n' and apellidos='$a' and materia='$mat' and sede='$sede' and periodo ='2'";
            $resnp2 = mysqli_query($conexion, $sqlnp2);           
            while ( $regnp2 = mysqli_fetch_array($resnp2)) {                    
              $notap2N=$regnp2['nota'];
            } 
             $notap1N=0;
             $np=0;
            $sqlnp1 = "select * from nivelaciones where nombres='$n' and apellidos='$a' and materia='$mat' and sede='$sede' and periodo ='1'";
            $resnp1 = mysqli_query($conexion, $sqlnp1);           
            while ( $regnp1 = mysqli_fetch_array($resnp1)) {                    
              $notap1N=$regnp1['nota'];
            }    
             $sqlcp3 = "select * from calificaciones where nombres='$n' and apellidos='$a' and grado='$grado' and periodo='3' and sede='$sede' and materias='$mat' ";
            $rescp3 = mysqli_query($conexion, $sqlcp3);
            while ( $regcp3 = mysqli_fetch_array($rescp3)) {                    
                    $ncp3=$regcp3['nota'];   
                    $np3=1;
              }
           $sqlcp2 = "select * from calificaciones where nombres='$n' and apellidos='$a' and grado='$grado' and periodo='2' and sede='$sede' and materias='$mat' ";
            $rescp2 = mysqli_query($conexion, $sqlcp2);
            while ( $regcp2 = mysqli_fetch_array($rescp2)) {                    
                    $ncp2=$regcp2['nota'];   
                    $np2=1;
              }
            $sqlcp1 = "select * from calificaciones where nombres='$n' and apellidos='$a' and grado='$grado' and periodo='1' and sede='$sede' and materias='$mat' ";
            $rescp1 = mysqli_query($conexion, $sqlcp1);
            while ( $regcp1 = mysqli_fetch_array($rescp1)) {                    
                    $ncp1=$regcp1['nota'];   
                    $np1=1;     
            }
             if (empty($notap1N)) {
                 $ntemp=round($ncp1*($regm['porcentaje']/100),2);              
                $acp1=$acp1+$ntemp;
                    $pdf->SetX(112);
                    $nper1=$ncp1;
                   $pdf->Cell(16, 6, $nper1, 1, 0, 'J');   
                   
             } else {
                $ntemp1=round($notap1N*($regm['porcentaje']/100),2); 
                 $acp1=$acp1+$ntemp1;
                 $nper1=$notap1N;
                 $pdf->SetX(112);
                   $pdf->Cell(16, 6, $nper1, 1, 0, 'J');  
             }
             if (empty($notap2N)) {
                 $ntemp=round($ncp2*($regm['porcentaje']/100),2);             
                $acp2=$acp2+$ntemp;
                    $pdf->SetX(128);
                    $nper2=$ncp2;
                   $pdf->Cell(16, 6, $nper2, 1, 0, 'J');   
             } else {
                $ntemp=round($notap2N*($regm['porcentaje']/100),2); 
                 $acp2=$acp2+$ntemp;
                 $nper2=$notap2N;
                 $pdf->SetX(128);
                   $pdf->Cell(16, 6, $nper2, 1, 0, 'J');  
             }
             if (empty($notap3N)) {
                 $ntemp=round($ncp3*($regm['porcentaje']/100),2);             
                $acp3=$acp3+$ntemp;
                    $pdf->SetX(144);
                    $nper3=$ncp3;
                   $pdf->Cell(16, 6, $nper3, 1, 0, 'J');   
             } else {
                $ntemp=round($notap3N*($regm['porcentaje']/100),2); 
                 $acp3=$acp3+$ntemp;
                 $nper3=$notap3N;
                 $pdf->SetX(144);
                   $pdf->Cell(16, 6, $nper3, 1, 0, 'J');  
             }
            
                $c1=1;
                $pdf->SetX(10);
                $iha=$regm['ihs'];
                $acih=$acih+$iha;
               $pdf->Cell(8, 6, $regm['ihs'], 1, 0, 'C');
               $pdf->SetX(18);
               $pdf->SetFont('Arial', '', 8);
               $pdf->Cell(94, 6, $reg1['materias'].'     '.$regm['porcentaje'].' '.utf8_decode("%"), 1, 0, 'J');
               if ($nota<3 && !empty($notaN)) {
                $por=$regm['porcentaje']/100;            
               $nt=round($notaN*$por,2);                                      
                $def=($nper1+$nper2+$nper3+$notaN)/4;  
                $ac=$ac+$nt;
                  } else {
                     $por=$regm['porcentaje']/100;            
               $nt=round($nota*$por,2);                                         
                $def=($nper1+$nper2+$nper3+$nota)/4;  
                $ac=$ac+$nt;
                  }            
               $pdf->SetX(160);
               $pdf->Cell(16, 6, $reg1['nota'], 1, 0, 'J');
               $pdf->SetX(112);
                $nota_a=$reg1['nota'];
            $pdf->SetFont('Arial', 'B', 8);
            $proma=round($def,2);           
             $pdf->SetX(192);
         $pdf->SetFont('Arial', 'B', 8);   
            $pdf->Cell(16, 6, $proma, 1, 1, 'J');
            $pdf->SetFont('Arial', '', 8);  
            if ($nota_a>=0 && $nota_a<=2.99) {
                    $sql3   = "select * from prefijos where Id='1'";
                    $res3   = mysqli_query($conexion, $sql3);
                    $reg = mysqli_fetch_array($res3);
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } elseif ($nota_a>=3 && $nota_a<=3.99) {
                   $sql3   = "select * from prefijos where Id='2'";
                    $res3   = mysqli_query($conexion, $sql3);
                    $reg = mysqli_fetch_array($res3);
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } elseif ($nota_a>=4 && $nota_a<=4.49) {
                     $sql3   = "select * from prefijos where Id='3'";
                    $res3   = mysqli_query($conexion, $sql3);
                    $reg = mysqli_fetch_array($res3);
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } else {
                     $sql3   = "select * from prefijos where Id='4'";
                    $res3   = mysqli_query($conexion, $sql3);
                    $reg = mysqli_fetch_array($res3);
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                }
                $codigo_c = $reg1['logro_c'];
                $codigo_d=$reg1['logro_d'];
                $sql3   = "select * from logros where codigo='$codigo_c' and materia='$mat' and grado='$grado' and sede='$sede'";
                $res3   = mysqli_query($conexion, $sql3);
                while ($reg3 = mysqli_fetch_array($res3)) {                
             $pdf->SetFillColor(255, 255, 255);
 $pdf->MultiCell('198', '5', utf8_decode($pre1)." ".utf8_decode($reg3['nombre'])." ".utf8_decode($su1), 1, 1, 'J',true);                  
                    
                }
                 $sql4   = "select * from logros where codigo='$codigo_d' and tipo='AFECTIVO-EXPRESIVO' and sede='$sede' and grado='$grado'";
                $res4   = mysqli_query($conexion, $sql4);
                while ($reg4 = mysqli_fetch_array($res4)) {
            $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell('198', '5', utf8_decode($reg4['nombre']), 1, 1, 'J',true);  
                }
               break;
            }
            
            }

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetX(10);
            $pdf->Cell(8, 6,$acih , 1, 0, 'C' );
            $pdf->SetX(18);            
            $pdf->SetFillColor(232, 232, 232);
            $pdf->Cell(94, 6, "MATEMATICAS".'    '.utf8_decode('100%'), 1, 0, 'J', 1);
            $pdf->SetX(112);
            $pdf->Cell(16, 6, $acp1, 1, 0, 'J');
            $pdf->SetX(128);
            $pdf->Cell(16, 6, $acp2, 1, 0, 'J');
            $pdf->SetX(144);            
            $pdf->Cell(16, 6, $acp3, 1, 0, 'J',1);
             $pdf->SetX(160);            
            $pdf->Cell(16, 6, $ac, 1, 0, 'J',1);
            $pdf->SetX(192);
            $acdef=($acp1+$acp2+$acp3+$ac)/4;
             $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(16, 6, round($acdef,2), 1, 1, 'J',1);    
            $acp2=0;
            $acp1=0;
            $acp3=0;
            $acih=0;
             $acihl=0;
            //Lenguaje
            $c2=0;  
            $acl=0;          
        $sql1 = "select * from calificaciones where nombres='$n' and apellidos='$a' and periodo='$periodo' and grado='$grado' and sede='$sede' and orden>2 and orden<=2.5  order by orden asc";
            $res1 = mysqli_query($conexion, $sql1);           
            while ($reg1 = mysqli_fetch_array($res1)) {                    
                $pdf->SetFont('Arial', '', 8);
                $pdf->SetX(18);
                $mat=$reg1['materias'];
                $nota=$reg1['nota'];
                $sqlm = "select * from materias where nombre='$mat' and grado='$grado' and dependencia>0";
            $resm = mysqli_query($conexion, $sqlm);
            while ($regm=mysqli_fetch_array($resm)) {
                $notaN=0;
                $sqlnp = "select * from nivelaciones where nombres='$n' and apellidos='$a' and materia='$mat' and periodo ='$periodo' and sede='$sede'";
            $resnp = mysqli_query($conexion, $sqlnp);           
            while ( $regnp = mysqli_fetch_array($resnp)) {              
                $pdf->SetX(176);
                $notaN=$regnp['nota'];
                 $pdf->Cell(16, 6, $notaN, 1, 0, 'J',1);        
            }
            $notap3N=0;             
            $sqlnp3 = "select * from nivelaciones where nombres='$n' and apellidos='$a' and materia='$mat' and periodo ='3' and sede='$sede'";
            $resnp3 = mysqli_query($conexion, $sqlnp3);           
            while ( $regnp3 = mysqli_fetch_array($resnp3)) {                    
              $notap3N=$regnp3['nota'];
            }  
             $notap2N=0;             
            $sqlnp2 = "select * from nivelaciones where nombres='$n' and apellidos='$a' and materia='$mat' and periodo ='2' and sede='$sede'";
            $resnp2 = mysqli_query($conexion, $sqlnp2);           
            while ( $regnp2 = mysqli_fetch_array($resnp2)) {                    
              $notap2N=$regnp2['nota'];
            }  
             $notap1N=0;             
            $sqlnp1 = "select * from nivelaciones where nombres='$n' and apellidos='$a' and materia='$mat' and periodo ='1' and sede='$sede'";
            $resnp1 = mysqli_query($conexion, $sqlnp1);           
            while ( $regnp1 = mysqli_fetch_array($resnp1)) {                    
              $notap1N=$regnp1['nota'];
            } 
             $sqlcp3 = "select * from calificaciones where nombres='$n' and apellidos='$a' and grado='$grado' and periodo='3' and materias='$mat' and sede='$sede'";
            $rescp3 = mysqli_query($conexion, $sqlcp3);
            while ( $regcp3 = mysqli_fetch_array($rescp3)) {                    
                    $nclp3=$regcp3['nota'];           
              }
            $sqlcp2 = "select * from calificaciones where nombres='$n' and apellidos='$a' and grado='$grado' and periodo='2' and materias='$mat' and sede='$sede'";
            $rescp2 = mysqli_query($conexion, $sqlcp2);
            while ( $regcp2 = mysqli_fetch_array($rescp2)) {                    
                    $nclp2=$regcp2['nota'];           
              }
              $sqlcp1 = "select * from calificaciones where nombres='$n' and apellidos='$a' and grado='$grado' and periodo='1' and materias='$mat' and sede='$sede'";
            $rescp1 = mysqli_query($conexion, $sqlcp1);
            while ( $regcp1 = mysqli_fetch_array($rescp1)) {                    
                    $nclp1=$regcp1['nota'];               
              }
             if (empty($notap1N)) {
                 $ntemp=round($nclp1*($regm['porcentaje']/100),2);           
                $aclp1=$aclp1+$ntemp;
                    $pdf->SetX(112);
                    $np1=$nclp1;
                   $pdf->Cell(16, 6, $np1, 1, 0, 'J'); 
             } else {
                $ntemp=round($notap1N*($regm['porcentaje']/100),2); 
                 $aclp1=$aclp1+$ntemp;
                 $np1=$notap1N;
                 $pdf->SetX(112);
                   $pdf->Cell(16, 6, $notap1N, 1, 0, 'J');  
             }
             if (empty($notap2N)) {
                 $ntemp=round($nclp2*($regm['porcentaje']/100),2);        
                $aclp2=$aclp2+$ntemp;
                    $pdf->SetX(128);
                    $np2=$nclp2;
                   $pdf->Cell(16, 6, $np2, 1, 0, 'J'); 
                } else {
                $ntemp=round($notap2N*($regm['porcentaje']/100),2); 
                 $aclp2=$aclp2+$ntemp;
                 $np2=$notap2N;
                 $pdf->SetX(128);
                   $pdf->Cell(16, 6, $np2, 1, 0, 'J');  
             }if (empty($notap3N)) {
                 $ntemp=round($nclp3*($regm['porcentaje']/100),2);        
                $aclp3=$aclp3+$ntemp;
                    $pdf->SetX(144);
                    $np3=$nclp3;
                   $pdf->Cell(16, 6, $np3, 1, 0, 'J'); 
                } else {
                $ntemp=round($notap3N*($regm['porcentaje']/100),2); 
                 $aclp3=$aclp3+$ntemp;
                 $np3=$notap3N;
                 $pdf->SetX(144);
                   $pdf->Cell(16, 6, $np3, 1, 0, 'J');  
                }
                $c2=1;
                $pdf->SetX(10);
                $iha=$regm['ihs'];
                $acihl=$acihl+$iha;
               $pdf->Cell(8, 6, $regm['ihs'], 1, 0, 'C');
               $pdf->SetX(18);
               $pdf->SetFont('Arial', '', 8);
               $pdf->Cell(94, 6, $reg1['materias'].'     '.$regm['porcentaje'].' '.utf8_decode("%"), 1, 0, 'J');
               if ($nota<3 && !empty($notaN)) {
                $por=$regm['porcentaje']/100;            
               $nt=round($notaN*$por,2);                                    
                $defl=($np1+$np2+$np3+$notaN)/4;  
                $acl=$acl+$nt;
                  } else {
                $por=$regm['porcentaje']/100;            
               $nt=round($nota*$por,2);                                    
                $defl=($np1+$np2+$np3+$nota)/4;  
                $acl=$acl+$nt;
                  }            
               $pdf->SetX(160);
               $pdf->Cell(16, 6, $reg1['nota'], 1, 0, 'J');
               $pdf->SetX(112);
                $nota_a=$reg1['nota'];     
            $pdf->SetFont('Arial', 'B', 8);
            $promal=round($defl,2);           
             $pdf->SetX(192);
         $pdf->SetFont('Arial', 'B', 8);   
            $pdf->Cell(16, 6, $promal, 1, 1, 'J');           
            $pdf->SetFont('Arial', '', 8);  
            if ($nota_a>=0 && $nota_a<=2.99) {
                    $sql3   = "select * from prefijos where Id='1'";
                    $res3   = mysqli_query($conexion, $sql3);
                    $reg = mysqli_fetch_array($res3);
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } elseif ($nota_a>=3 && $nota_a<=3.99) {
                   $sql3   = "select * from prefijos where Id='2'";
                    $res3   = mysqli_query($conexion, $sql3);
                    $reg = mysqli_fetch_array($res3);
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } elseif ($nota_a>=4 && $nota_a<=4.49) {
                     $sql3   = "select * from prefijos where Id='3'";
                    $res3   = mysqli_query($conexion, $sql3);
                    $reg = mysqli_fetch_array($res3);
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } else {
                     $sql3   = "select * from prefijos where Id='4'";
                    $res3   = mysqli_query($conexion, $sql3);
                    $reg = mysqli_fetch_array($res3);
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                }
                $codigo_c = $reg1['logro_c'];
                $codigo_d=$reg1['logro_d'];
                $sql3   = "select * from logros where codigo='$codigo_c' and materia='$mat' and sede='$sede' and grado='$grado'";
                $res3   = mysqli_query($conexion, $sql3);
                while ($reg3 = mysqli_fetch_array($res3)) {   
                                   $pdf->SetFillColor(255, 255, 255);
    $pdf->MultiCell('198', '5', utf8_decode($pre1)." ".utf8_decode($reg3['nombre'])." ".utf8_decode($su1), 1, 1, 'J',true);                   
                }
                 $sql4   = "select * from logros where codigo='$codigo_d' and tipo='AFECTIVO-EXPRESIVO' and grado='$grado' and sede='$sede'";
                $res4   = mysqli_query($conexion, $sql4);
                while ($reg4 = mysqli_fetch_array($res4)) {
                                   $pdf->SetFillColor(255, 255, 255);
                    $pdf->MultiCell('198', '5', utf8_decode($reg4['nombre']), 1, 1, 'J',true);  
                } 
                break;              
            }                
            }
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetX(10);
            $pdf->Cell(8, 6,$acihl , 1, 0, 'C' );
            $pdf->SetX(18); 
            $pdf->SetFillColor(232, 232, 232);           
            $pdf->Cell(94, 6, "HUMANIDADES".'    '.utf8_decode('100%'), 1, 0, 'J', 1);
            $pdf->SetX(112);
            $pdf->Cell(16, 6, $aclp1, 1, 0, 'J');
            $pdf->SetX(128);
            $pdf->Cell(16, 6, $aclp2, 1, 0, 'J');
             $pdf->SetX(144);            
            $pdf->Cell(16, 6, $aclp3, 1, 0, 'J',1);
            $pdf->SetX(160);            
            $pdf->Cell(16, 6, $acl, 1, 0, 'J',1);
            $pdf->SetX(192);
            $acdefl=($aclp1+$aclp2+$aclp3+$acl)/4;
             $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(16, 6, round($acdefl,2), 1, 1, 'J',1);  
            $aclp1=0;
            $aclp2=0;
            $acih=0;
            $acihl=0;
        //OTRAS MATERIAS
        $act=0;
        $c5=0;
        $ac5=0;   
        $acomp1=0; 
$sql1 = "select * from calificaciones where nombres='$n' and apellidos='$a' and periodo='$periodo' and grado='$grado' and sede='$sede' and orden>2.3  order by orden asc";
            $res1 = mysqli_query($conexion, $sql1);           
            while ($reg1 = mysqli_fetch_array($res1)) {
                $pdf->SetFillColor(232, 232, 232);
               $c5++;
             $notaN=0;
               $ac5=$ac5+$c5; 
                $pdf->SetFont('Arial', '', 8);
                $pdf->SetX(18);
                $mat=$reg1['materias'];
                $sqlm = "select * from materias where nombre='$mat' and grado='$grado'";
            $resm = mysqli_query($conexion, $sqlm);
            while ($regm=mysqli_fetch_array($resm)) {
                 $sqln1 = "select * from nivelaciones where nombres='$n' and apellidos='$a' and materia='$mat' and periodo ='$periodo' and sede='$sede'";
            $resn1 = mysqli_query($conexion, $sqln1);          
            while ( $regn1 = mysqli_fetch_array($resn1)) {              
                $pdf->SetX(176);
                 $pdf->SetFont('Arial', 'B', 8);
                 $pdf->Cell(16, 6, $regn1['nota'], 1, 0, 'J',1);              
              $notaN=$regn1['nota'];
            }
             $notap3N=0;
            $np3=0;
            $sqlnp3 = "select * from nivelaciones where nombres='$n' and apellidos='$a' and materia='$mat' and periodo ='3' and sede='$sede'";
            $resnp3 = mysqli_query($conexion, $sqlnp3);           
            while ( $regnp3 = mysqli_fetch_array($resnp3)) {
            $notap3N=0;
            $np3=0;
            $sqlnp2 = "select * from nivelaciones where nombres='$n' and apellidos='$a' and materia='$mat' and periodo ='2' and sede='$sede'";
            $resnp2 = mysqli_query($conexion, $sqlnp2);           
            while ( $regnp2 = mysqli_fetch_array($resnp2)) {                    
              $notap2N=$regnp2['nota'];
            }
            $notap1N=0;
            $np1=0;
            $sqlnp1 = "select * from nivelaciones where nombres='$n' and apellidos='$a' and materia='$mat' and periodo ='1' and sede='$sede'";
            $resnp1 = mysqli_query($conexion, $sqlnp1);           
            while ( $regnp1 = mysqli_fetch_array($resnp1)) {                    
              $notap1N=$regnp1['nota'];
            } 
             $sqlcp3 = "select * from calificaciones where nombres='$n' and apellidos='$a' and grado='$grado' and periodo='3' and materias='$mat' and sede='$sede'";
            $rescp3 = mysqli_query($conexion, $sqlcp3);
            while ( $regcp3 = mysqli_fetch_array($rescp3)) {                 
                    $ncomp3=$regcp3['nota'];                 
              }
            $sqlcp2 = "select * from calificaciones where nombres='$n' and apellidos='$a' and grado='$grado' and periodo='2' and materias='$mat' and sede='$sede'";
            $rescp2 = mysqli_query($conexion, $sqlcp2);
            while ( $regcp2 = mysqli_fetch_array($rescp2)) {                 
                    $ncomp2=$regcp2['nota'];                 
              }
              $sqlcp1 = "select * from calificaciones where nombres='$n' and apellidos='$a' and grado='$grado' and periodo=1 and materias='$mat' and sede='$sede'";
            $rescp1 = mysqli_query($conexion, $sqlcp1);
            while ( $regcp1 = mysqli_fetch_array($rescp1)) {                    
                    $ncomp1=$regcp1['nota'];                 
              }
             if (empty($notap1N)) {                   
                    $pdf->SetX(112);
                    $np1=$ncomp1;
                    $pdf->SetFont('Arial', 'B', 8);
                   $pdf->Cell(16, 6, $np1, 1, 0, 'J');                      
             } else {                           
                 $np1=$notap1N;
                 $pdf->SetX(112);
                   $pdf->Cell(16, 6, $notap1N, 1, 0, 'J');  
             }
             if (empty($notap2N)) {                   
                    $pdf->SetX(128);
                    $np2=$ncomp2;
                    $pdf->SetFont('Arial', 'B', 8);
                   $pdf->Cell(16, 6, $np2, 1, 0, 'J');                      
             } else {                           
                 $np2=$notap2N;
                 $pdf->SetX(128);
                   $pdf->Cell(16, 6, $np2, 1, 0, 'J');  
             }
              if (empty($notap3N)) {                   
                    $pdf->SetX(144);
                    $np3=$ncomp3;
                    $pdf->SetFont('Arial', 'B', 8);
                   $pdf->Cell(16, 6, $np3, 1, 0, 'J');                      
             } else {                           
                 $np2=$notap3N;
                 $pdf->SetX(144);
                   $pdf->Cell(16, 6, $np3, 1, 0, 'J');  
             }
                $pdf->SetX(10);                
               $pdf->Cell(8, 6, $regm['ihs'], 1, 0, 'C');
               $pdf->SetX(18);
               $pdf->SetFont('Arial', 'B', 8);
               $pdf->Cell(94, 6, $reg1['materias'].'     '.$regm['porcentaje'].' '.utf8_decode("%"), 1, 0, 'J',1);   
                $nota_a=$reg1['nota'];
                if ($nota<3 && !empty($notaN)) {
                $por=$regm['porcentaje']/100;            
               $nt=round($notaN*$por,2);                                       
                $def=($np1+$np2+$np3+$nota_a)/4; 
                $act=$act+$notaN;
                  } else {
                $por=$regm['porcentaje']/100;            
               $nt=round($nota*$por,2);  
               $act=$act+$nota_a;                                            
                $def=($np1+$np2+$np3+$nota_a)/4;                  
                  }            
               $pdf->SetX(160);
               $pdf->Cell(16, 6, $reg1['nota'], 1, 0, 'J',1);
               $pdf->SetX(112);
                $nota_a=$reg1['nota'];     
            $pdf->SetFont('Arial', 'B', 8);
            $promom=round($def,2);           
             $pdf->SetX(192);
         $pdf->SetFont('Arial', 'B', 8);   
            $pdf->Cell(16, 6, $promom, 1, 1, 'J',1);           
            $pdf->SetFont('Arial', '', 8);  
            if ($nota_a>=0 && $nota_a<=2.99) {
                    $sql3   = "select * from prefijos where Id='1'";
                    $res3   = mysqli_query($conexion, $sql3);
                    $reg = mysqli_fetch_array($res3);
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } elseif ($nota_a>=3 && $nota_a<=3.99) {
                   $sql3   = "select * from prefijos where Id='2'";
                    $res3   = mysqli_query($conexion, $sql3);
                    $reg = mysqli_fetch_array($res3);
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } elseif ($nota_a>=4 && $nota_a<=4.49) {
                     $sql3   = "select * from prefijos where Id='3'";
                    $res3   = mysqli_query($conexion, $sql3);
                    $reg = mysqli_fetch_array($res3);
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                } else {
                     $sql3   = "select * from prefijos where Id='4'";
                    $res3   = mysqli_query($conexion, $sql3);
                    $reg = mysqli_fetch_array($res3);
                    $pre1=$reg['1'];
                    $su1=$reg['2'];
                }
                $codigo_c = $reg1['logro_c'];
                $codigo_d=$reg1['logro_d'];
                $sql3   = "select * from logros where codigo='$codigo_c' and materia='$mat' and grado='$grado'";
                $res3   = mysqli_query($conexion, $sql3);
                $pdf->SetFont('Arial', '', 8);
                while ($reg3 = mysqli_fetch_array($res3)) {    
                 $pdf->SetFillColor(255, 255, 255);
                 $pdf->MultiCell('198', '5', utf8_decode($pre1)." ".utf8_decode($reg3['nombre'])." ".utf8_decode($su1), 1, 1, 'J',true);             
                }
                 $sql4   = "select * from logros where codigo='$codigo_d' and tipo='AFECTIVO-EXPRESIVO' and grado='$grado'";
                $res4   = mysqli_query($conexion, $sql4);
                while ($reg4 = mysqli_fetch_array($res4)) {
                 $pdf->SetFillColor(255, 255, 255);
                 $pdf->MultiCell('198', '5', utf8_decode( $reg4['nombre']), 1, 1, 'J');
                } 
                $aclp1=0;
                $aclp2=0;
                $acpl3=0;
                
            }   
            break;        
        }
    }          
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetFillColor(232, 232, 232);
    $pdf->Cell(190, 6, ' DISCIPLINA ', 1, 1, 'J', 1);
        $sqlc=  "select * from convivencia where nombres='$n' and apellidos='$a' and grado='$grado' and periodo='$periodo' and sede='$sede' ";
            $resc = mysqli_query($conexion, $sqlc);
            while ($regc = mysqli_fetch_array($resc)) {
            $logc=$regc['logro_dis'];
             $sql4   = "select * from logros where codigo='$logc' and tipo='DISCIPLINA'";
                $res4   = mysqli_query($conexion, $sql4);
                while ($reg4 = mysqli_fetch_array($res4)) {
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->SetFillColor(255, 255, 255);
                    $pdf->MultiCell('198', '5', utf8_decode( $reg4['nombre']), 1, 1, 'J');
                }
                 
                
            }
        $tac=$ac+$acl+$act;
        $tc=$c1+$c2+$c5;
        $promg=$tac/$tc;
        $nprom=round($promg, 2);
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
            $pdf->Cell(198, 5, ' PROMEDIO DE PERIODO: '.round($promg, 2).'        '.utf8_decode($des), 1, 1, 'J', 1);
            $pr=round($promg, 2);
            $pdf->SetFont('Arial', 'B', 8);
           
            $pdf->Ln(6);
         
            
              if ($sede=="PRINCIPAL") {   
            $pdf->Cell(80, 0, ' ', 1, 1, 'J');         
            $sql=  "select * from docentes where direccion_grado='$grado' and sede='$sede'";
            $resa = mysqli_query($conexion, $sql);
            while ($rega = mysqli_fetch_array($resa)) {
                $nom_ac=$rega['nombres'].' '.$rega['apellidos'];
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(190, 5,strtoupper($nom_ac) , 0, 1, 'J');
            }
           
        }
        
        if($sede=="CAPIRA"){
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(80, 0, ' ', 1, 1, 'J');
             $pdf->Cell(190, 4,utf8_decode("ISLENA ISABEL BARBOZA SALGADO") , 0, 1, 'J');
             $pdf->Cell(40, 6, ' Director de Grupo', 0, 1, 'J');

        }
        if($sede=="MILAN"){
            $pdf->SetFont('Arial', 'B', 8);
            if($grado=="JARDIN" || $grado=="TRANSICION" || $grado=="PRIMERO" ){
                 $pdf->Cell(80, 0, ' ', 1, 1, 'J');
             $pdf->Cell(190, 4,utf8_decode("SILSA MARTINEZ MENDOZA") , 0, 1, 'J');
             $pdf->Cell(40, 6, ' Director de Grupo', 0, 1, 'J');
            }
            if($grado=="SEGUNDO" || $grado=="TERCERO"  ){
                 $pdf->Cell(80, 0, ' ', 1, 1, 'J');
             $pdf->Cell(190, 4,utf8_decode("LIDIA ROSA DIAZ QUIROZ") , 0, 1, 'J');
             $pdf->Cell(40, 6, ' Director de Grupo', 0, 1, 'J');
            }
            if($grado=="CUARTO" || $grado=="QUINTO"  ){
                 $pdf->Cell(80, 0, ' ', 1, 1, 'J');
             $pdf->Cell(190, 4,utf8_decode("GUSTAVO ADOLFO BARBOZA SANCHEZ") , 0, 1, 'J');
             $pdf->Cell(40, 6, ' Director de Grupo', 0, 1, 'J');
            }

        }
            $pdf->Ln();
          
    }

        $i++;

    
}
    $pdf->Output();
   
?>
