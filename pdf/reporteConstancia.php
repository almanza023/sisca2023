<?php
date_default_timezone_set("UTC");  
$grado   = $_POST['grado'];
$idest   = $_POST['estudiantes'];
if ($_POST) {
    $fecha= $_POST['fecha'];
}
if (isset($grado)  ) {
    require_once "../../config/Conexion.php";
    include "fpdf/fpdf.php";
    $pdf = new FPDF('P', 'mm', 'A4'); 

    $pdf->AddPage();

    $pdf->SetFillColor(232, 232, 232);
    
    $pdf->Image('escudo.png', 30, 20, 15);
            $pdf->SetFont('Arial', '', 7);
            $pdf->SetY(37);
            $pdf->SetX(2);
            $pdf->Cell(80, 4, utf8_decode('REPUBLICA DE COLOMBIA '), 0, 1, 'C');
            $pdf->SetX(1);
            $pdf->Cell(80, 4, utf8_decode('MINISTERIO DE EDUCACIÓN '), 0, 1, 'C');
            $pdf->SetX(1);
            $pdf->Cell(80, 4, utf8_decode('SECRETARIA DE EDUCACIÓN DE SUCRE'), 0, 1, 'C');
            $pdf->SetX(1);
            $pdf->Cell(80, 4, utf8_decode('INSTITUCIÓN EDUCATIVA DON ALONSO'), 0, 1, 'C');
            $pdf->SetX(1);
            $pdf->SetFont('Arial', 'B', 9);
             $pdf->Cell(80, 4, utf8_decode('DANE Nº. 270215000190 - 01'), 0, 1, 'C');
             $pdf->SetX(1);
            $pdf->SetFont('Arial','',5);
             $pdf->Cell(80, 4, utf8_decode('NIT: 800079517-8'), 0, 1, 'C');
              $pdf->SetX(1);
              $pdf->Cell(80, 4, 'COROZAL SUCRE', 0, 1, 'C');

            $pdf->Image('logo-ineda.png', 160, 20, 15);
             $pdf->SetFont('Arial', '', 7);
            $pdf->SetY(37);
            $pdf->SetX(130);
            $pdf->Cell(80, 4, utf8_decode('PLANTEL DE CARÁCTER OFICIAL '), 0, 1, 'C');
            $pdf->SetX(130);
            $pdf->Cell(80, 4, utf8_decode('DECRETO 0591 OCTUBRE 30 DE 2002'), 0, 1, 'C');
            $pdf->SetX(130);
            $pdf->Cell(80, 4, utf8_decode('RESOLUCIÓN Nº. 1072 MAYO 31/04'), 0, 1, 'C');
            $pdf->SetX(130);
            $pdf->Cell(80, 4, utf8_decode('Y 1566 AGOSTO  6/04.'), 0, 1, 'C');
            $pdf->SetX(130);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(80, 4, utf8_decode('E-MAIL: iedonalonso@hotmail.com'), 0, 1, 'C');
            $pdf->SetX(130);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(80, 4, utf8_decode('CODIGO ICFES: 092908 - 128413'), 0, 1, 'C');
            $pdf->SetX(130);
            $pdf->Cell(80, 4, utf8_decode('TELEFONO: 2499711'), 0, 1, 'C');
             $pdf->SetFont('Arial', 'B', 14);
                $pdf->Ln(10);
            $pdf->SetY(75);
            $pdf->SetX(70);
            $pdf->Cell(80, 6, utf8_decode('EL SUSCRITO RECTOR  DE LA INSTITUCIÓN EDUCATIVA DON ALONSO '), 0, 1, 'C');
            $pdf->SetX(70);
          $pdf->Cell(80, 4, utf8_decode('CON CÓDIGO DANE No. 270215000190 - 01'), 0, 1, 'C');
        $pdf->SetY(95);
            $pdf->SetX(70);
            $pdf->Cell(80, 6, utf8_decode('HACE CONSTAR: '), 0, 1, 'C');
             $sql = "SELECT e.idestudiante, e.apellidos, e.nombres, g.descripcion from estudiantes e inner join grados g on e.idgrado=g.idgrado where idestudiante='$idest' ";
             
    $res = $mysqli->query($sql);   
    $i=1;
 
      $ano = substr($fecha, -10, 4);
$mes = substr($fecha, -5, 2);
$dia = substr($fecha, -2, 2);
$m="";
$d="";
   switch ($mes) {
       case '01':
          $m="Enero";
           break;
       case '02':
          $m="Febrero";
           break;
           case '03':
          $m="Marzo";
          break;
          case '04':
          $m="Abril";
           break;
           case '05':
          $m="Mayo";
           break;
           case '06':
          $m="Junio";
           break;
           case '07':
          $m="Julio";
           break;
           case '08':
          $m="Agosto";
           break;
           case '09':
          $m="Septiembre";
           break;
           case '10':
          $m="Octubre";
           break;
           case '11':
          $m="Noviembre";
           break;
           case '12':
          $m="Diciembre";
           break;
       default:
         $m="";
           break;
   }
switch ($dia) {
    case '01':
       $d="Un";
        break;
    case '02':
       $d="Dos";
        break;
    case '03':
       $d="Tres";
        break;
    case '04':
       $d="Cuatro";
        break;
    case '05':
       $d="Quinto";
        break;
    case '06':
       $d="Seis";
        break;
    case '07':
       $d="Siete";
        break;
    case '08':
       $d="Ocho";
        break;
    case '09':
       $d="Nueve";
        break;
    case '10':
       $d="Diez";
        break;
    case '11':
       $d="Once";
        break;
    case '12':
       $d="Doce";
        break;
    case '13':
       $d="Trece";
        break;
    case '14':
       $d="Catorce";
        break;
    case '15':
       $d="Quince";
        break;
    case '16':
       $d="Dieciseis";
        break;
    case '17':
       $d="Diecisiete";
        break;
    case '18':
       $d="Dieciocho";
        break;
    case '19':
       $d="Diecinueve";
        break;
    case '20':
       $d="Veinte";
        break;   
    case '21':
       $d="Veintiuno";
        break; 
    case '22':
       $d="Veintidós";
        break;
    case '23':
       $d="Veintitres";
        break;
    case '24':
       $d="Veinticuatro";
        break;
    case '25':
       $d="Veinticinco";
        break;
    case '26':
       $d="Veintiseis";
        break;
    case '27':
       $d="Veintisiete";
        break;
    case '28':
       $d="Veintiocho";
        break;
    case '29':
       $d="Veintinueve";
        break;
    case '30':
       $d="Treinta";
        break;
    case '31':
       $d="Treintaiun";
        break;
    default:
        # code...
        break;
}
$sqlg="SELECT descripcion FROM grados where idgrado='$grado'";
$resg=$mysqli->query($sqlg);
$reg=$resg->fetch_row();
$desg=$reg[0];

    while ($reg =$res->fetch_row()) { 
        $nom= $reg['1'].' '. $reg['2'];
        $idgrado=$reg['3'];
        $grad="";
        $edu="";
        switch ($idgrado) {
            case 'TRANSICION':
                $grad="0°";
                break;
            case 'PRIMERO':
                $grad="(1°)";
                $edu="Básica Primaria ";
                break;
                case 'SEGUNDO':
                $grad="(2°)";
                  $edu="Básica Primaria ";
                break;
                case 'TERCERO':
                $grad="(3°)";
                  $edu="Básica Primaria ";
                break;
                case 'CUARTO':
                $grad="(4°)";
                  $edu="Básica Primaria ";
                break;
                case 'QUINTO':
                $grad="(5°)";
                  $edu="Básica Primaria ";
                break;
                case 'SEXTO':
                $grad="(6°)";
                  $edu="Básica Secundaria ";
                break;
                case 'SEPTIMO':
                $grad="(7°)";
                $edu="Básica Secundaria ";
                break;
                case 'OCTAVO':
                $grad="(8°)";
                $edu="Básica Secundaria ";
                break;
                 case 'NOVENO':
                $grad="(9°)";
                $edu="Básica Secundaria ";
                break;
                 case 'DECIMO':
                $grad="(10°)";
                $edu="Media Académica  ";
                break;
                 case 'UNDECIMO':
                $grad="(11°)";
                $edu="Media Académica  ";
                break;
            default:
                $grad="";
                break;
        }
        $pdf->SetY(115);
    $pdf->SetX(5);
            $pdf->Cell(80, 6, utf8_decode('Qué el Alumno (a): '), 0, 1, 'C');  
            
            $pdf->SetY(115);
            $pdf->SetX(75);
            $pdf->Cell(80, 6, utf8_decode($nom), 0, 1, 'C');     
     $pdf->Ln(7);
    $pdf->SetX(21);
    $fec=$d.' ('.$dia.') Días '.' del mes de '.$m.' año Dos Mil Dieciocho '.$ano.'.';
    $pdf->SetFillColor(255, 255, 255);
            $pdf->MultiCell(180, 6, utf8_decode('Se  encuentra  matriculado  en  esta  Institución  Educativa  en  el  Grado ').$desg.' '.utf8_decode($grad). utf8_decode(' Educación  ').utf8_decode($edu). utf8_decode('para el año lectivo 2.018.'), 0, 1, 'J');      
        $pdf->Ln(10); 
         $pdf->SetX(21);        
       $pdf->MultiCell(180, 6, utf8_decode('La  presente constancia se expide a solicitud del padre de familia en Don Alonso Corozal - Sucre a los  ' ).utf8_decode($fec), 0, 1, 'J');    
    
    $pdf->Ln(45); 
         $pdf->SetX(21);        
       $pdf->Cell(80, 0, '', 1, 1, 'J');
        
        $pdf->Ln(3);
        $pdf->SetX(20);
       $pdf->Cell(70, 4, utf8_decode('JOSE FRANCISCO MEZA D´ LUIZ.'), 0, 1, 'J');

        $pdf->SetX(20);
       $pdf->Cell(70, 6, utf8_decode('C.C. No. 3.912.520 de Morroa.'), 0, 1, 'J');
       $pdf->Ln(30);
     $pdf->SetX(0);
       $pdf->Cell(300, 0, '', 1, 1, 'J');
       
         $pdf->SetX(70);
         $pdf->Cell(70, 8, utf8_decode('SABER - ESFUERZO - ESPERANZA'), 0, 1, 'J');
    
         $pdf->SetX(0);
       $pdf->Cell(300, 0, '', 1, 1, 'J');
    }
    
    $pdf->Output();
}

?>


