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
            //$pdf->SetFillColor(232, 232, 232);
            //$sqlc="SELECT * FROM datos_colegio ";
            //$resc=$mysqli->query($sqlc);
            //regc=$resc->fetch_row();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(190, 6, utf8_decode('INSTITUCION EDUCATIVA DON ALONSO'), 0, 1, 'C');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(190, 4, utf8_decode('COROZAL - SUCRE'), 0, 1, 'C');
            $pdf->Cell(190, 4, utf8_decode(' Plantel de Carácter Oficial'), 0, 1, 'C');
            $pdf->Cell(190, 4, utf8_decode(' Resolución N° 1072 Mayo 31/04 y 1566 Agosto 06/04'), 0, 1, 'C');
            $pdf->Cell(190, 6, utf8_decode(' Código Icfes '), 0, 1, 'C');
            $pdf->Cell(190, 6, utf8_decode('https://iedonalonso.co/sisca/'), 0, 1, 'C');
            $pdf->Image('logo-ineda.png', 8, 6, 20);
            $pdf->SetFont('Arial', 'B', 10);          
            $pdf->Ln(2);
            $pdf->SetFillColor(232, 232, 232);
            $pdf->Cell(198, 6, utf8_decode(' INFORME FINAL'), 1, 1, 'C',1);           
            $pdf->SetFont('Arial', '', 8);
            $idest= $reg['0'];  
            $nom = utf8_decode($reg['2'] . ' ' . $reg['1']);
            $pdf->Cell(113, 4, 'NOMBRE: ' . $nom, 1, 0, 'J');
            $pdf->Cell(47, 4, 'GRADO: ' . $reg['3'], 1, 0, 'J');
            $pdf->Cell(38, 4, 'PERIODO: FINAL' , 1, 1, 'J');
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
             $pdf->SetFont('Arial', '', 9);          
             
        $acom=0;
        $promg=0;
        $c5=0;
        $ac5=0;   
        $acomp1=0; 
        $nota=0; $act=0; $contOM=0; $aclen=0; $acsoc=0; $c2=0; $c3=0; $arper=0;
   $sql1 = "SELECT   * from calificaciones where matricula_id='$idest'  and periodo_id='$periodo' and orden>=1  order by orden asc";
            $res1 = $mysqli->query($sql1);           
            while ($reg1 = $res1->fetch_row()) {
               $c5++;
             $notaN=0;
               $ac5=$ac5+$c5; 
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetX(18);
               $idasig=$reg1['2']; 
      $sqlm = "SELECT c.ihs, c.porcentaje, a.nombre, c.asignatura_id from carga_academicas c inner join asignaturas a on a.id=c.asignatura_id where c.asignatura_id='$idasig' and c.grado_id='$grado' and c.sede_id='$sede' ";  
           
            $resm = $mysqli->query($sqlm);
            while ($regm=$resm->fetch_row()) { 
           $sqln1 = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='5' ";
            $resn1 = $mysqli->query($sqln1);
            $nv1=$resn1->num_rows;
            while ( $regn1 = $resn1->fetch_row()) {                   
              $notaN=$regn1['0'];
              $contOM++;
            }
            $notap3N=0;
            $sqlnp3 = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='3'";
            $resnp3 = $mysqli->query($sqlnp3);           
            while ( $regnp3 = $resnp3->fetch_row()) {                    
              $notap3N=$regnp3['0'];
            } 
            //Nivelacion de segundo periodo
            $notap2N=0;
            $sqlnp2 = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='2'";
            $resnp2 = $mysqli->query($sqlnp2);           
            while ( $regnp2 = $resnp2->fetch_row()) {                    
              $notap2N=$regnp2['0'];
            } 
            $notap1N=0;
            $sqlnp1 = "SELECT nota from nivelaciones where matricula_id='$idest'  and asignatura_id='$idasig' and periodo_id ='1'";
            $resnp1 = $mysqli->query($sqlnp1);           
            while ( $regnp1 = $resnp1->fetch_row()) {                    
              $notap1N=$regnp1['0'];
            } 
             //Calificaciones de Tercer periodo
             $sqlcp3 = "SELECT nota from calificaciones where matricula_id='$idest'  and periodo_id='3'  and asignatura_id='$idasig' ";
            $rescp3 = $mysqli->query($sqlcp3);
            $regcp3 = $rescp3->fetch_row();
            if(empty($regcp3['0'])){
              $ncomp3=0;
            }else{
              $ncomp3=$regcp3['0'];
            }        
            //Calificaciones de segundo periodo
             $sqlcp2 = "SELECT nota from calificaciones where matricula_id='$idest'  and periodo_id='2'  and asignatura_id='$idasig' ";
            $rescp2 = $mysqli->query($sqlcp2);           
            $regcp2 = $rescp2->fetch_row();
            if(empty($regcp2['0'])){
              $ncomp2=0;
            }else{
              $ncomp2=$regcp2['0'];
            }        
            $sqlcp1 = "SELECT nota from calificaciones where matricula_id='$idest'  and periodo_id='1'  and asignatura_id='$idasig' ";
            $rescp1 = $mysqli->query($sqlcp1);
            $regcp1 = $rescp1->fetch_row();
            if(empty($regcp1['0'])){
              $ncomp1=0;
            }else{
              $ncomp1=$regcp1['0'];
            }          
           
             if (empty($notap1N)) {                
                    $np1=$ncomp1;
             } else {                           
                 $np1=$notap1N;                  
             } if (empty($notap2N)) {
                
                    $np2=$ncomp2;                   
             } else {
                
                 $np2=$notap2N;           
             } if (empty($notap3N)) {
                
                    $np3=$ncomp3;                  
             } else {               
                 $np3=$notap3N;  
                
             }
             
                $pdf->SetX(10);                
               $pdf->Cell(8, 6, $regm['0'], 1, 0, 'C');
               $pdf->SetX(18);
               $pdf->SetFont('Arial', 'B', 9);
               $pdf->SetFillColor(232, 232, 232);
               $pdf->Cell(170, 6, utf8_decode($regm['2'].'     '.$regm['1']).' '.utf8_decode("%"), 1, 0, 'J',1);   
                $nota_a=$reg1['6'];               
                $por=$regm['1']/100;            
               $nt=round($nota*$por,1);  
               $act=$act+$nota_a;                                            
                $def=($np1+$np2+$np3+$nota_a)/4;           
            $promom=round($def, 1);           
             $pdf->SetX(192);
         $pdf->SetFont('Arial', 'B', 9);   
             if (!empty($notaN)) {
               $pdf->SetX(188);
         $pdf->SetFont('Arial', 'B', 9);   
            $pdf->Cell(20, 6, $notaN, 1, 1, 'J',1);           
            $pdf->SetFont('Arial', '', 8); 
            $acom=$acom+$notaN; 
            $nd=$notaN;
            }else {
             $pdf->SetX(188);
         $pdf->SetFont('Arial', 'B', 9);   
            $pdf->Cell(20, 6, $promom, 1, 1, 'J',1);           
            $pdf->SetFont('Arial', '', 8);
             $nd=$promom;
            $acom=$acom+$promom;      
                       
      
            }
                break;             
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
                $pdf->SetFont('Arial', '', 9);
                while ($reg3 = $res3->fetch_row()) {   
                    $pdf->SetFillColor(255, 255, 255);
                    $pdf->MultiCell('198', '7', utf8_decode($reg3['1']), 1, 1, 'J',true);
                }
            if ($contOM>0) {
                if ($nd<3) {
                  $pdf->MultiCell('198', '7', utf8_decode('Estudiante Presento Nivelación  y REPROBO'), 1, 1, 'J',true);
                } else {
                  $pdf->MultiCell('198', '7', utf8_decode('Estudiante Presento Nivelación  y APROBO'), 1, 1, 'J',true);  
                }
                }
            $pdf->Ln(2);
            $contOM=0;                                  
        }
        $pdf->SetFillColor(232, 232, 232);
            $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(198, 6, ' DISCIPLINA ', 1, 1, 'J', 1);
     $sqlc=  "SELECT descripcion  from logros_disciplinarios  where periodo_id='5' and sede_id='$sede' and grado_id='$grado' "; 
      
            $resc = $mysqli->query($sqlc); 
            $regc=$resc->fetch_row();           
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetFillColor(255, 255, 255);  
            if(!empty($regc['0'])){
              $pdf->MultiCell('198', '5', ( utf8_decode($regc['0'])), 1, 1, 'J');
            }      
        $tac=$acom;
        $tc=$c5;
        if($tac>0 && $tc>0){
          $promg=$tac/$tc;
          $nprom=round($promg, 1);
        }        
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
            $pdf->Cell(198, 6, ' PROMEDIO FINAL: '.$nprom.'        '.utf8_decode($des), 1, 1, 'J', 1);            
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(198, 6, utf8_decode(' CONCEPTO COMISIÓN EVALUACIÓN Y PROMOCIÓN'), 1, 1, 'J', 1);
            if ($arper>=2) {
            $pdf->Cell(198, 6, utf8_decode(' REPROBO EL AÑO LECTIVO '), 1, 1, 'C');
            $pdf->Cell(198, 5, utf8_decode(' N° ARÉAS PERDIDAS: '.$arper), 1, 1, 'J');
            }
            if ($arper==1 ) {
           
            }
            if ($arper==0) {
            $pdf->Cell(198, 6, utf8_decode(' PROMOVIDO AL SIGUIENTE GRADO  '), 1, 1, 'C');      
            } 
            $arper=0;
            $pdf->Cell(198, 5, ' OBSERVACIONES', 1, 1, 'J', 1);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(198, 16, ' ', 1, 1, 'J');
            $pdf->Ln(15);
            $pdf->Cell(80, 0, ' ', 1, 1, 'J');         
            $sql= "SELECT p.nombres, p.apellidos from direcciones_grados doc inner join docentes p ON p.id=docente_id where doc.grado_id='$grado' and doc.sede_id='$sede'";
            
            $resa = $mysqli->query($sql);
            $rega = $resa->fetch_row();                
            $nom_ac=$rega['0'].' '.$rega['1'];
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(190, 4,utf8_decode($nom_ac) , 0, 1, 'J');            
            $pdf->Cell(40, 6, ' Director de Grupo', 0, 1, 'J');           
            $pdf->Ln();        
            $pdf->Ln();
             $pdf->Ln();
              $pdf->Ln();
            }
        $aclen=0;
        $acsoc=0;
        $acom=0;
        $arper=0;
        $nprom=0;
        $promg=0;
        $i++;
    }
    $pdf->Output();
   
?>