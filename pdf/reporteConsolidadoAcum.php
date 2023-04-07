<?php

$jornada ='MATINAL';
$grado   = $_POST['grado'];
$periodo = $_POST['periodo'];
$sede = $_POST['sede'];
$promedios = array();

if (isset($jornada) && isset($grado) && isset($periodo)  && isset($sede)) {
    require_once "conexion.php";
    include "fpdf/fpdf.php";

    $sql  = "select * from estudiantes where grado='$grado' and jornada='$jornada' and sede='$sede' and estado='ACTIVO'  order by apellidos asc";
    $res  = mysqli_query($conexion, $sql);
    $num1 = mysqli_num_rows($res);
    $pdf = new FPDF('L', 'mm', 'Legal');
    $pdf->AddPage();
    $pdf->SetFillColor(232, 232, 232);

     $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(320, 6, utf8_decode('INSTITUCIÓN EDUCATIVA DON ALONSO '), 0, 1, 'C');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(320, 6, utf8_decode(' Plantel de Carácter Oficial'), 0, 1, 'C');
            $pdf->Cell(320, 6, utf8_decode(' Resolución N° 1072 Mayo 31/04 y 1566 Agosto 06/04'), 0, 1, 'C');
            $pdf->Cell(320, 6, utf8_decode(' Código Icfes 092908 - 128413'), 0, 1, 'C');
            $pdf->Image('logo-ineda.png', 8, 6, 20);
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 12);
   
    $pdf->Cell(320, 5, 'CONSOLIDADO ACUMULATIVO DE NOTAS ', 0, 1, 'C');
       
      $pdf->Cell(320, 10, '', 1, 0, 'J'); 
     $pdf->Ln(2);
      
    $pdf->SetFont('Arial', 'B', 10);
   
    $pdf->Cell(140, 6, 'GRADO: '.$grado, 0, 0, 'J');
    $pdf->Cell(120, 6, 'SEDE: '.$sede, 0, 0, 'J');
    $pdf->Cell(140, 6, 'PERIODO: '.$periodo, 0, 0, 'J');
    $pdf->Cell(140, 6, utf8_decode('Año: 2017'), 0, 0, 'J');
    $pdf->Ln(5);
  
    $pdf->Cell(80, 6, '', 0, 'C', 1);
    $pdf->Ln();
    $pdf->Cell(8, 5, utf8_decode('N°'), 1, 0, 'C', 1); 
    $pdf->Cell(72, 5, 'ESTUDIANTES', 1, 0, 'C', 1); 
        $pdf->SetFont('Arial', 'B', 8);
       $sqlp2 = "select  distinct materias from calificaciones where  periodo ='$periodo' and grado='$grado' and sede='$sede' order by orden asc";
            $resp2 = mysqli_query($conexion, $sqlp2);
            while ( $regp2 = mysqli_fetch_array($resp2)) {
                $pdf->SetFont('Arial', 'B', 8);
                $mat=$regp2['materias'];
               
               switch ($mat) {
        case 'ESTADISTICAS':
            $pdf->Cell(12, 5, 'ESTAD',  1, 0, 'J');
            break;
              case 'GEOMETRIA':
            $pdf->Cell(12, 5, 'GEOM',  1, 0, 'J');
            break;
              case 'MATEMATICA':
            $pdf->Cell(12, 5, 'MAT',  1, 0, 'J');
            break;
              case 'MATEMATICAS':
            $pdf->Cell(12, 5, 'MAT',  1, 0, 'J');
            break;
            case 'LENGUA CASTELLANA':
            $pdf->Cell(12, 5, 'LEN',  1, 0, 'J');
            break;
              case 'LECTURA':
            $pdf->Cell(12, 5, 'LECT',  1, 0, 'J');
            break;
              case 'INGLES':
            $pdf->Cell(12, 5, 'ING',  1, 0, 'J');
            break;
              case 'CASTELLANO':
            $pdf->Cell(12, 5, 'CAST',  1, 0, 'J');
            break;
            case 'QUIMICA':
            $pdf->Cell(12, 5, 'QUIM',  1, 0, 'J');
            break;
            case 'FISICA':
            $pdf->Cell(12, 5, 'FIS',  1, 0, 'J');
            break;
            case 'BIOLOGIA':
            $pdf->Cell(12, 5, 'BIOL',  1, 0, 'J');
            break;
              case 'CIENCIAS NATURALES':
            $pdf->Cell(12, 5, 'CNAT',  1, 0, 'J');
            break;
               case 'CIENCIAS SOCIALES':
            $pdf->Cell(12, 5, 'CSOC',  1, 0, 'J');
            break;
             case 'CIENCIAS POLITICAS':
            $pdf->Cell(12, 5, 'POL',  1, 0, 'J');
            break;
            case 'CONSTITUCION NACIONAL':
            $pdf->Cell(12, 5, 'CONT',  1, 0, 'J');
            break;
              case 'CATEDRA DE PAZ':
            $pdf->Cell(12, 5, 'PAZ',  1, 0, 'J');
            break;
            case 'SOCIALES INTEGRADAS':
            $pdf->Cell(12, 5, 'SOC',  1, 0, 'J');
            break;
            case 'FILOSOFIA':
            $pdf->Cell(12, 5, 'FIL',  1, 0, 'J');
            break;
              case 'ARTISTICA':
            $pdf->Cell(12, 5, 'ART',  1, 0, 'J');
            break;
              case 'RELIGION':
            $pdf->Cell(12, 5, 'REL',  1, 0, 'J');
            break;
              case 'ETICA Y VALORES':
            $pdf->Cell(12, 5, 'ETIV',  1, 0, 'J');
            break;
          case 'TECNOLOGIA E INFORMATICA':
            $pdf->Cell(12, 5, 'TECN',  1, 0, 'J');
            break;
              case 'EDUCACION FISICA':
            $pdf->Cell(12, 5, 'EDUFIS',  1, 0, 'J');
            break;
        default:
            # code...
            break;
    }
        
        }
       
    $pdf->Ln();
    $i=1;
    
     while ($reg = mysqli_fetch_array($res)) {
      $ac=0;
    $c=0;
    $cp=0;
    $cg=0;
        $pdf->SetFont('Arial', '', 8);
        $nom = $reg['apellidos'] . ' ' . $reg['nombres'];
        $n=$reg['nombres'];
        $ape=$reg['apellidos'];
        $pdf->Cell(8, 5, $i, 1, 0, 'J');
        $pdf->Cell(72, 5, utf8_decode($nom), 1, 0, 'J');
         $sqlp1 = "select * from calificaciones where nombres='$n' and apellidos='$ape' and  grado='$grado' and sede='$sede' and materias='$mat'";
            $resp1 = mysqli_query($conexion, $sqlp1);
            while ( $regp1 = mysqli_fetch_array($resp1)) {
                $c++;
                $nota=$regp1['nota'];
               $pdf->Cell(12, 5, $regp1['nota'], 1,0 , 'J');
            $ac=$ac+$nota;                
            }
            
            $prom=$ac/$c;
			$rprom=round($prom,2);
			$promedios[$nom]=($rprom );
			$pdf->Cell(12, 5, $cp, 1,0 , 'J',0);
			$pdf->Cell(12, 5, $cg, 1,0 , 'J',0);
             $pdf->Cell(12, 5, round($prom,2), 1,0 , 'J',1);
             
$pdf->Ln(); 
$i++;

    }
	$pdf->Ln(); 
	
	
$pdf->Ln(); 
 if($sede=='CAPIRA'){
            $pdf->Cell(80, 0, ' ', 1, 1, 'J');
             $pdf->Cell(190, 4,utf8_decode("ISLENA ISABEL BARBOZA SALGADO") , 0, 1, 'J');
             $pdf->Cell(40, 6, ' Director de Grupo', 0, 1, 'J');

        }
     if($sede=='MILAN'){
            if($grado=='PRIMERO' ){
                 $pdf->Cell(80, 0, ' ', 1, 1, 'J');
             $pdf->Cell(190, 4,utf8_decode("SILSA MARTINEZ MENDOZA") , 0, 1, 'J');
             $pdf->Cell(40, 6, ' Director de Grupo', 0, 1, 'J');
            }
            if($grado=='SEGUNDO" || $grado=="TERCERO'  ){
                 $pdf->Cell(80, 0, ' ', 1, 1, 'J');
             $pdf->Cell(190, 4,utf8_decode("LIDIA ROSA DIAZ QUIROZ") , 0, 1, 'J');
             $pdf->Cell(40, 6, ' Director de Grupo', 0, 1, 'J');
            }
            if($grado=='CUARTO' || $grado=='QUINTO'  ){
                 $pdf->Cell(80, 0, ' ', 1, 1, 'J');
             $pdf->Cell(190, 4,utf8_decode("GUSTAVO ADOLFO BARBOZA SANCHEZ") , 0, 1, 'J');
             $pdf->Cell(40, 6, ' Director de Grupo', 0, 1, 'J');
            }

        }
        if($sede=='PRINCIPAL'){
             $pdf->Cell(80, 0, ' ', 1, 1, 'J');
            $sql=  "select * from docentes where direccion_grado='$grado' and sede='$sede'";
            $resa = mysqli_query($conexion, $sql);
            while ($rega = mysqli_fetch_array($resa)) {                 
  
                $nom_ac=$rega['nombres'].' '.$rega['apellidos'];
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(190, 4,utf8_decode($nom_ac) , 0, 1, 'J');
            }
   
            $pdf->Cell(40, 6, ' Director de Grupo', 0, 1, 'J');
        }


    $pdf->Output();

}
