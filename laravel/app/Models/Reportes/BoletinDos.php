<?php
namespace App\Models\Reportes;

use App\Models\Calificacion;
use App\Models\CargaAcademica;
use App\Models\Matricula;
use App\Models\Nivelacion;
use App\Models\Prefijo;
use App\Models\Puesto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoletinDos extends Model
{

    public static function reporte($sede, $grado, $periodo, $pdf)
    {
        switch ($periodo)
        {
            case '1':
                //Obtener el numero de estudiante
                $matriculas = Matricula::listado($sede, $grado);
                $num1 = count($matriculas);
                $filas = 0;
                $pdf = app('Fpdf');

                while ($filas <= $num1)
                {

                    foreach ($matriculas as $matricula)
                    {
                        Auxiliar::cabecera($pdf, $matricula, $periodo);
                        //matematicas
                        $acih = 0;
                        $ac = 0;
                        $proma = 0;
                        $acil = 0;
                        $acin = 0;
                        $proml = 0;
                        $acl = 0;
                        $c1 = 0;
                        $c2 = 0;
                        $c3 = 0;
                        $acs = 0;
                        $calificaciones = Calificacion::reportCalificaciones($matricula->id, $periodo, 1, 1.3);
                        foreach ($calificaciones as $cal)
                        {
                            $notaN = 0;
                            $pdf->SetFont('Arial', '', 8);
                            $pdf->SetX(18);
                            $nivelacionPeriodo = Nivelacion::getNivelacion($matricula->id, $cal->asignatura_id, $periodo);
                            if (!empty($nivelacionPeriodo) && $nivelacionPeriodo->nota > 0)
                            {
                                $notaN = $nivelacionPeriodo->nota;
                                $pdf->SetX(128);
                                $pdf->SetFont('Arial', 'B', 10);
                                $pdf->SetFillColor(232, 232, 232);
                                $pdf->Cell(16, 6, $notaN, 1, 0, 'J', 1);
                            }
                            $pdf->SetFillColor(255, 255, 255);
                            $carga = CargaAcademica::getIhs($grado, $cal->asignatura_id);
                            $iha = $carga->ihs;
                            $c1 = 1;
                            $pdf->SetX(10);
                            $acih = $acih + $iha;
                            $pdf->Cell(8, 6, $iha, 1, 0, 'C');
                            $pdf->SetX(18);
                            $pdf->SetFont('Arial', '', 8);
                            $pdf->Cell(94, 6, utf8_decode($cal
                                ->asignatura
                                ->nombre) . '     ' . utf8_decode($carga->porcentaje) . ' ' . utf8_decode("%") , 1, 0, 'J', 1);
                            $nota_a = $cal->nota;
                            $por = $carga->porcentaje / 100;
                            if (empty($notaN))
                            {
                                $nt = round($nota_a * $por, 1, PHP_ROUND_HALF_DOWN);
                                $nota = $cal->nota;
                                $ac = $ac + $nt;
                            }
                            else
                            {
                                $nt = round($notaN * $por, 1);
                                $ac = $ac + $nt;
                            }
                            $pdf->SetX(112);
                            $pdf->Cell(16, 6, $nota, 1, 0, 'J');
                            $pdf->SetX(112);
                            $pdf->SetFont('Arial', 'B', 8);
                            $proma = $nota;
                            if (empty($notaN))
                            {
                                $pdf->SetX(192);
                                $pdf->SetFont('Arial', '', 8);
                                $pdf->Cell(16, 6, $proma, 1, 1, 'J');
                            }
                            else
                            {
                                $pdf->SetX(192);
                                $pdf->SetFont('Arial', '', 8);
                                $pdf->Cell(16, 6, $notaN, 1, 1, 'J');
                            }
                            //Parte de Logros
                            if ($nota_a >= 0 && $nota_a <= 2.99)
                            {
                                $prefijo = Prefijo::find(1);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;

                            }
                            elseif ($nota_a >= 3 && $nota_a <= 3.99)
                            {
                                $prefijo = Prefijo::find(2);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;
                            }
                            elseif ($nota_a >= 4 && $nota_a <= 4.49)
                            {
                                $prefijo = Prefijo::find(3);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;
                            }
                            else
                            {
                                $prefijo = Prefijo::find(4);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;
                            }
                            $pdf->SetFont('Arial', '', 9);
                            $pdf->SetFillColor(255, 255, 255);
                            if (!empty($cal
                                ->logroCognitivo
                                ->descripcion))
                            {
                                $pdf->MultiCell('198', '5', utf8_decode($pre1) . " " . utf8_decode($cal
                                    ->logroCognitivo
                                    ->descripcion) . " " . utf8_decode($su1) , 1, 1, 'J', true);
                            }
                            if (!empty($cal
                                ->logroAfectivo
                                ->descripcion))
                            {
                                $pdf->MultiCell('198', '5', utf8_decode($cal
                                    ->logroAfectivo
                                    ->descripcion) , 1, 1, 'J');
                            }
                        }

                        $pdf->SetFont('Arial', 'B', 8);
                        $pdf->SetX(10);
                        $pdf->Cell(8, 6, $acih, 1, 0, 'C');
                        $pdf->SetX(18);
                        $pdf->SetFillColor(232, 232, 232);
                        $pdf->Cell(94, 6, "MATEMATICAS" . '    ' . utf8_decode('100%') , 1, 0, 'J', 1);
                        $pdf->SetX(112);
                        $pdf->Cell(16, 6, $ac, 1, 0, 'J', 1);
                        $pdf->SetX(192);
                        $pdf->SetFont('Arial', 'B', 8);
                        $ac=round($ac, 1,PHP_ROUND_HALF_DOWN );
                        $pdf->Cell(16, 6, $ac , 1, 1, 'J');

                        //OTRAS MATERIAS
                        $act = 0;
                        $c5 = 0;
                        $ac5 = 0;
                        $calificaciones = Calificacion::reportCalificaciones($matricula->id, $periodo, 2, '');
                        foreach ($calificaciones as $cal)
                        {
                            $c5++;
                            $notaN = 0;
                            $ac5 = $ac5 + $c5;
                            $pdf->SetFont('Arial', '', 8);
                            $pdf->SetX(18);
                            $nivelacionPeriodo = Nivelacion::getNivelacion($matricula->id, $cal->asignatura_id, $periodo);
                            //Si existe una nota de nivelacion de periodo
                            if (!empty($nivelacionPeriodo) && $nivelacionPeriodo->nota > 0)
                            {
                                $notaN = $nivelacionPeriodo->nota;
                                $pdf->SetX(128);
                                $pdf->SetFont('Arial', 'B', 10);
                                $pdf->SetFillColor(232, 232, 232);
                                $pdf->Cell(16, 6, $notaN, 1, 0, 'J', 1);
                            }
                            $carga = CargaAcademica::getIhs($grado, $cal->asignatura_id);
                            $pdf->SetX(10);
                            $iha = $carga->ihs;
                            $acil = $acil + $iha;
                            $pdf->Cell(8, 6, $iha, 1, 0, 'C');
                            $pdf->SetX(18);
                            $pdf->SetFont('Arial', 'B', 8);
                            $pdf->SetFillColor(232, 232, 232);
                            $pdf->Cell(94, 6, utf8_decode($cal
                                ->asignatura
                                ->nombre) . '     ' . utf8_decode($carga->porcentaje) . ' ' . utf8_decode("%") , 1, 0, 'J', 1);
                            $nota_a = $cal->nota;
                            $por = $carga->porcentaje / 100;
                            if (empty($notaN))
                            {
                                $nt = round($nota_a * $por, 1, PHP_ROUND_HALF_DOWN);
                                $nota = $cal->nota;
                                $act = $act + $nt;
                            }
                            else
                            {
                                $nt = round($notaN * $por, 1, PHP_ROUND_HALF_DOWN);
                                $act = $act + $nt;
                            }
                            $pdf->SetX(112);
                            $pdf->Cell(16, 6, $nota_a, 1, 0, 'J', 1);
                            $proma = $nota;
                            if (empty($notaN))
                            {
                                $pdf->SetX(192);
                                $pdf->SetFont('Arial', 'B', 8);
                                $pdf->Cell(16, 6, $proma, 1, 1, 'J');
                            }
                            else
                            {
                                $pdf->SetFont('Arial', 'B', 8);
                                $pdf->SetX(192);

                                $pdf->Cell(16, 6, $notaN, 1, 1, 'J');
                            }
                            //Parte de Logros
                            if ($nota_a >= 0 && $nota_a <= 2.99)
                            {
                                $prefijo = Prefijo::find(1);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;

                            }
                            elseif ($nota_a >= 3 && $nota_a <= 3.99)
                            {
                                $prefijo = Prefijo::find(2);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;
                            }
                            elseif ($nota_a >= 4 && $nota_a <= 4.49)
                            {
                                $prefijo = Prefijo::find(3);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;
                            }
                            else
                            {
                                $prefijo = Prefijo::find(4);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;
                            }
                            $pdf->SetFont('Arial', '', 9);
                            $pdf->SetFillColor(255, 255, 255);
                            
                            if (!empty($cal
                                ->logroCognitivo
                                ->descripcion))
                            {
                                $pdf->MultiCell('198', '5', utf8_decode($pre1) . " " . utf8_decode($cal
                                    ->logroCognitivo
                                    ->descripcion) . " " . utf8_decode($su1) , 1, 1, 'J', true);
                            }
                            if (!empty($cal
                                ->logroAfectivo
                                ->descripcion))
                            {
                                $pdf->MultiCell('198', '5', utf8_decode($cal
                                    ->logroAfectivo
                                    ->descripcion) , 1, 1, 'J');
                            }

                        }
                        Auxiliar::disciplina($pdf, $matricula, $periodo);
                        $tac = $ac + $acl + $acs + $act;
                        $pdf->SetFillColor(232, 232, 232);
                        $tc = $c1 + $c2 + $c3 + $c5;
                        $promg = $tac / $tc;
                        $nprom = round($promg, 1, PHP_ROUND_HALF_DOWN);
                        Puesto::updateOrCreate(['matricula_id' => $matricula->id, 'periodo_id' => $periodo], ['matricula_id' => $matricula->id, 'periodo_id' => $periodo, 'promedio' => $nprom],);
                        if ($nprom >= 1 && $nprom <= 2.99)
                        {
                            $des = "DESEMPEÑO BAJO";
                        }
                        elseif ($nprom >= 3 && $nprom <= 3.99)
                        {
                            $des = "DESEMPEÑO BÁSICO";
                        }
                        elseif ($nprom >= 4 && $nprom <= 4.49)
                        {
                            $des = "DESEMPEÑO ALTO";
                        }
                        elseif ($nprom >= 4.5)
                        {
                            $des = "DESEMPEÑO SUPERIOR";
                        }
                        else
                        {
                            $des = "";
                        }
                        $pdf->SetFont('Arial', 'B', 9);
                        $posicion = 0;
                        $cont = 0;

                        $puestos = Puesto::getPuesto($sede, $grado, $periodo);
                        $total = count($puestos);
                        foreach ($puestos as $puesto)
                        {
                            $cont++;
                            if ($puesto->matricula_id == $matricula->id)
                            {
                                $posicion = $cont;
                                break;
                            }
                        }
                        $pdf->Cell(198, 6, ' PROMEDIO DE PERIODO: ' . $nprom . '        ' . utf8_decode($des) , 1, 1, 'J', 1);
                        $pdf->Cell(198, 6, ' PUESTO: ' . $posicion . '  DE ' . $total, 1, 1, 'J', 1);
                        Auxiliar::footer($pdf, $grado, $sede);
                        $cal='';
                    }
                    $pdf->Output();
                    exit;
                    $filas++;
                }

            break;

            case '2':
                //Obtener el numero de estudiante
                $matriculas = Matricula::listado($sede, $grado);
                $num1 = count($matriculas);
                $filas = 0;
                $pdf = app('Fpdf');

                while ($filas <= $num1)
                {

                    foreach ($matriculas as $matricula)
                    {
                        Auxiliar::cabecera($pdf, $matricula, $periodo);
                        //matematicas
                        $acih = 0;
                        $ac = 0;
                        $ac1=0;
                        $proma = 0;
                        $promac = 0;
                        $acil = 0;
                        $porc1 = 0;
                        $acl = 0;
                        $c1 = 0;
                        $c2 = 0;
                        $c3 = 0;
                        $acs = 0;
                        $niveladas=0;
                        $calificaciones = Calificacion::reportCalificaciones($matricula->id, $periodo, 1, 1.3);
                        foreach ($calificaciones as $cal)
                        {
                            $notaN = 0;
                            $pdf->SetFont('Arial', '', 8);
                            $pdf->SetX(18);
                            //Nota periodo 1
                            $calPer1 = Calificacion::notaAnteriorEst($matricula->id, $cal->asignatura_id, 1);
                            if (!empty($calPer1))
                            {
                                $notaP1 = $calPer1->nota;
                                $pdf->SetX(112);
                                $pdf->SetFont('Arial', '', 8);
                                $pdf->SetFillColor(232, 232, 232);
                                $pdf->Cell(16, 6, $notaP1, 1, 0, 'J', 0);

                            }
                            if($cal->nota<3){
                                $nivelacionPeriodo=Nivelacion::getNivelacion($matricula->id, $cal->asignatura_id, $periodo);
                                //Si existe una nota de nivelacion de periodo
                                if(!empty($nivelacionPeriodo) ){
                                    $notaN=$nivelacionPeriodo->nota;
                                    $pdf->SetX(144);
                                    $pdf->SetFont('Arial', 'B', 10);
                                    $pdf->SetFillColor(232, 232, 232);
                                    $pdf->Cell(16, 6, $notaN, 1, 0, 'J',1);
                                }
                            }
                            $pdf->SetFillColor(255, 255, 255);
                            $carga = CargaAcademica::getIhs($grado, $cal->asignatura_id);
                            $iha = $carga->ihs;
                            $c1 = 1;
                            $pdf->SetX(10);
                            $acih = $acih + $iha;
                            $pdf->Cell(8, 6, $iha, 1, 0, 'C');
                            $pdf->SetX(18);
                            $pdf->SetFont('Arial', '', 8);
                            $pdf->Cell(94, 6, utf8_decode($cal
                                ->asignatura
                                ->nombre) . '     ' . utf8_decode($carga->porcentaje) . ' ' . utf8_decode("%") , 1, 0, 'J', 1);
                            $nota_a = $cal->nota;
                            $por = $carga->porcentaje / 100;
                            $porc1=$notaP1*$por;
                            $ac1=$ac1+$porc1;
                            if (empty($notaN))
                            {
                                $nt = round($nota_a * $por, 1,PHP_ROUND_HALF_DOWN);
                                $nota = $cal->nota;
                                $ac = $ac + $nt;
                                $pdf->SetX(128);
                                 $pdf->Cell(16, 6, $cal->nota, 1, 0, 'J', 1);
                            }
                            else
                            {
                                $nt = round($notaN * $por, 1,PHP_ROUND_HALF_DOWN);
                                $ac = $ac + $nt;
                                $pdf->SetX(128);
                                $pdf->Cell(16, 6, $cal->nota, 1, 0, 'J', 1);
                            }
                            if (empty($notaN) ) {
                                $proma=round(($nota+$notaP1)/2,1,PHP_ROUND_HALF_DOWN);
                               }else{
                                $niveladas++;
                                $proma=round(($notaN+$notaP1)/2,1,PHP_ROUND_HALF_DOWN);
                               }
                                $pdf->SetX(192);
                                $pdf->SetFont('Arial', 'B', 10);
                                $pdf->Cell(16, 6, $proma, 1, 1, 'C',1);

                            //Parte de Logros
                            if ($nota_a >= 0 && $nota_a <= 2.99)
                            {
                                $prefijo = Prefijo::find(1);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;

                            }
                            elseif ($nota_a >= 3 && $nota_a <= 3.99)
                            {
                                $prefijo = Prefijo::find(2);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;
                            }
                            elseif ($nota_a >= 4 && $nota_a <= 4.49)
                            {
                                $prefijo = Prefijo::find(3);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;
                            }
                            else
                            {
                                $prefijo = Prefijo::find(4);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;
                            }
                            $pdf->SetFont('Arial', '', 9);
                            $pdf->SetFillColor(255, 255, 255);
                            if (!empty($cal
                                ->logroCognitivo
                                ->descripcion))
                            {
                                $pdf->MultiCell('198', '5', utf8_decode($pre1) . " " . utf8_decode($cal
                                    ->logroCognitivo
                                    ->descripcion) . " " . utf8_decode($su1) , 1, 1, 'J', true);
                            }
                            if (!empty($cal
                                ->logroAfectivo
                                ->descripcion))
                            {
                                $pdf->MultiCell('198', '5', utf8_decode($cal
                                    ->logroAfectivo
                                    ->descripcion) , 1, 1, 'J');
                            }
                        }

                        $pdf->SetFont('Arial', 'B', 8);
                        $pdf->SetX(10);
                        $pdf->Cell(8, 6, $acih, 1, 0, 'C');
                        $pdf->SetX(18);
                        $pdf->SetFillColor(232, 232, 232);
                        $pdf->Cell(94, 6, "MATEMATICAS" . '    ' . utf8_decode('100%') , 1, 0, 'J', 1);
                        $pdf->SetX(112);
                        $pdf->Cell(16, 6, $ac1, 1, 0, 'J', 0);
                        $pdf->SetX(128);
                        $ac=round($ac, 1,PHP_ROUND_HALF_DOWN);
                        $pdf->Cell(16, 6, $ac, 1, 0, 'J', 1);
                        if($ac>0 && $ac1>0){
                            $promac=round(($ac+$ac1)/2,1);
                        }
                        $pdf->SetX(192);
                        $pdf->Cell(16, 6, round($promac, 1) , 1, 1, 'C',1);

                        //OTRAS MATERIAS
                        $act = 0;
                        $c5 = 0;
                        $ac5 = 0;
                        $calificaciones = Calificacion::reportCalificaciones($matricula->id, $periodo, 2, '');
                        foreach ($calificaciones as $cal)
                        {
                            $c5++;
                            $notaN = 0;
                            $ac5 = $ac5 + $c5;
                            $pdf->SetFont('Arial', '', 8);
                            $pdf->SetX(18);
                            $calPer1 = Calificacion::notaAnteriorEst($matricula->id, $cal->asignatura_id, 1);
                            if (!empty($calPer1))
                            {
                                $notaP1 = $calPer1->nota;
                                $pdf->SetX(112);
                                $pdf->SetFont('Arial', '', 8);
                                $pdf->SetFillColor(232, 232, 232);
                                $pdf->Cell(16, 6, $notaP1, 1, 0, 'J', 0);

                            }
                            if($cal->nota<3){
                                $nivelacionPeriodo=Nivelacion::getNivelacion($matricula->id, $cal->asignatura_id, $periodo);
                                //Si existe una nota de nivelacion de periodo
                                if(!empty($nivelacionPeriodo) ){
                                    $notaN=$nivelacionPeriodo->nota;
                                    $pdf->SetX(144);
                                    $pdf->SetFont('Arial', 'B', 10);
                                    $pdf->SetFillColor(232, 232, 232);
                                    $pdf->Cell(16, 6, $notaN, 1, 0, 'J',1);
                                }
                            }
                            $carga = CargaAcademica::getIhs($grado, $cal->asignatura_id);
                            $pdf->SetX(10);
                            $iha = $carga->ihs;
                            $acil = $acil + $iha;
                            $pdf->Cell(8, 6, $iha, 1, 0, 'C');
                            $pdf->SetX(18);
                            $pdf->SetFont('Arial', 'B', 8);
                            $pdf->SetFillColor(232, 232, 232);
                            $pdf->Cell(94, 6, utf8_decode($cal
                                ->asignatura
                                ->nombre) . '     ' . utf8_decode($carga->porcentaje) . ' ' . utf8_decode("%") , 1, 0, 'J', 1);
                            $nota_a = $cal->nota;
                            $por = $carga->porcentaje / 100;
                            if (empty($notaN))
                            {
                                $nt = round($nota_a * $por, 1,PHP_ROUND_HALF_DOWN);
                                $nota = $cal->nota;
                                $act = $act + $nt;
                                $pdf->SetX(128);
                                $pdf->Cell(16, 6, $cal->nota, 1, 0, 'J', 1);
                            }
                            else
                            {
                                $nt = round($notaN * $por, 1,PHP_ROUND_HALF_DOWN);
                                $act = $act + $nt;
                                $pdf->SetX(128);
                                $pdf->Cell(16, 6, $cal->nota, 1, 0, 'J', 0);
                            }

                            if (empty($notaN) ) {
                                $proma=round(($nota+$notaP1)/2,1,PHP_ROUND_HALF_DOWN);
                               }else{
                                $niveladas++;
                                $proma=round(($notaN+$notaP1)/2,1,PHP_ROUND_HALF_DOWN);
                               }
                                $pdf->SetX(192);
                                $pdf->SetFont('Arial', 'B', 10);
                                $pdf->Cell(16, 6, $proma, 1, 1, 'C',1);
                            //Parte de Logros
                            if ($nota_a >= 0 && $nota_a <= 2.99)
                            {
                                $prefijo = Prefijo::find(1);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;

                            }
                            elseif ($nota_a >= 3 && $nota_a <= 3.99)
                            {
                                $prefijo = Prefijo::find(2);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;
                            }
                            elseif ($nota_a >= 4 && $nota_a <= 4.49)
                            {
                                $prefijo = Prefijo::find(3);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;
                            }
                            else
                            {
                                $prefijo = Prefijo::find(4);
                                $pre1 = $prefijo->prefijo;
                                $su1 = $prefijo->subfijo;
                            }
                            $pdf->SetFont('Arial', '', 9);
                            $pdf->SetFillColor(255, 255, 255);
                            if (!empty($cal
                                ->logroCognitivo
                                ->descripcion))
                            {
                                $pdf->MultiCell('198', '5', utf8_decode($pre1) . " " . utf8_decode($cal
                                    ->logroCognitivo
                                    ->descripcion) . " " . utf8_decode($su1) , 1, 1, 'J', true);
                            }
                            if (!empty($cal
                                ->logroAfectivo
                                ->descripcion))
                            {
                                $pdf->MultiCell('198', '5', utf8_decode($cal
                                    ->logroAfectivo
                                    ->descripcion) , 1, 1, 'J');
                            }

                        }
                        Auxiliar::disciplina($pdf, $matricula, $periodo);
                        $tac = $ac + $acl + $acs + $act;
                        $pdf->SetFillColor(232, 232, 232);
                        $tc = $c1 + $c2 + $c3 + $c5;
                        $promg = $tac / $tc;
                        $nprom = round($promg, 1,PHP_ROUND_HALF_DOWN);
                        Puesto::updateOrCreate(['matricula_id' => $matricula->id, 'periodo_id' => $periodo], ['matricula_id' => $matricula->id, 'periodo_id' => $periodo, 'promedio' => $nprom],);
                        if ($nprom >= 1 && $nprom <= 2.99)
                        {
                            $des = "DESEMPEÑO BAJO";
                        }
                        elseif ($nprom >= 3 && $nprom <= 3.99)
                        {
                            $des = "DESEMPEÑO BÁSICO";
                        }
                        elseif ($nprom >= 4 && $nprom <= 4.49)
                        {
                            $des = "DESEMPEÑO ALTO";
                        }
                        elseif ($nprom >= 4.5)
                        {
                            $des = "DESEMPEÑO SUPERIOR";
                        }
                        else
                        {
                            $des = "";
                        }
                        $pdf->SetFont('Arial', 'B', 9);
                        $posicion = 0;
                        $cont = 0;

                        $puestos = Puesto::getPuesto($sede, $grado, $periodo);
                        $total = count($puestos);
                        foreach ($puestos as $puesto)
                        {
                            $cont++;
                            if ($puesto->matricula_id == $matricula->id)
                            {
                                $posicion = $cont;
                                break;
                            }
                        }
                        $pdf->Cell(198, 6, ' PROMEDIO DE PERIODO: ' . $nprom . '        ' . utf8_decode($des) , 1, 1, 'J', 1);
                        $pdf->Cell(198, 6, ' PUESTO: ' . $posicion . '  DE ' . $total, 1, 1, 'J', 1);
                        Auxiliar::footer($pdf, $grado, $sede);
                    }
                    $pdf->Output();
                    exit;
                    $filas++;
                }

            break;
            case '3':
               //Obtener el numero de estudiante
               $matriculas = Matricula::listado($sede, $grado);
               $num1 = count($matriculas);
               $filas = 0;
               $pdf = app('Fpdf');

               while ($filas <= $num1)
               {

                   foreach ($matriculas as $matricula)
                   {
                       Auxiliar::cabecera($pdf, $matricula, $periodo);
                       //matematicas
                       $acih = 0;
                       $ac = 0;
                       $ac1=0;
                       $ac2=0;
                       $proma = 0;
                       $acil = 0;
                       $porc1 = 0;
                       $porc2 = 0;
                       $acl = 0;
                       $c1 = 0;
                       $c2 = 0;
                       $c3 = 0;
                       $acs = 0;
                       $niveladas=0;
                       $calificaciones = Calificacion::reportCalificaciones($matricula->id, $periodo, 1, 1.3);
                       foreach ($calificaciones as $cal)
                       {
                           $notaN = 0;
                           $pdf->SetFont('Arial', '', 8);
                           $pdf->SetX(18);
                           //Nota periodo 1
                           $calPer1 = Calificacion::notaAnteriorEst($matricula->id, $cal->asignatura_id, 1);
                           if (!empty($calPer1))
                           {
                               $notaP1 = $calPer1->nota;
                               $pdf->SetX(112);
                               $pdf->SetFont('Arial', '', 8);
                               $pdf->SetFillColor(232, 232, 232);
                               $pdf->Cell(16, 6, $notaP1, 1, 0, 'J', 0);
                           }
                           $calPer2 = Calificacion::notaAnteriorEst($matricula->id, $cal->asignatura_id, 2);
                           if (!empty($calPer2))
                           {
                               $notaP2 = $calPer2->nota;
                               $pdf->SetX(128);
                               $pdf->SetFont('Arial', '', 8);
                               $pdf->SetFillColor(232, 232, 232);
                               $pdf->Cell(16, 6, $notaP2, 1, 0, 'J', 0);

                           }
                           if($cal->nota<3){
                               $nivelacionPeriodo=Nivelacion::getNivelacion($matricula->id, $cal->asignatura_id, $periodo);
                               //Si existe una nota de nivelacion de periodo
                               if(!empty($nivelacionPeriodo) ){
                                   $notaN=$nivelacionPeriodo->nota;
                                   $pdf->SetX(160);
                                   $pdf->SetFont('Arial', 'B', 10);
                                   $pdf->SetFillColor(232, 232, 232);
                                   $pdf->Cell(16, 6, $notaN, 1, 0, 'J',1);
                               }
                           }
                           $pdf->SetFillColor(255, 255, 255);
                           $carga = CargaAcademica::getIhs($grado, $cal->asignatura_id);
                           $iha = $carga->ihs;
                           $c1 = 1;
                           $pdf->SetX(10);
                           $acih = $acih + $iha;
                           $pdf->Cell(8, 6, $iha, 1, 0, 'C');
                           $pdf->SetX(18);
                           $pdf->SetFont('Arial', '', 8);
                           $pdf->Cell(94, 6, utf8_decode($cal
                               ->asignatura
                               ->nombre) . '     ' . utf8_decode($carga->porcentaje) . ' ' . utf8_decode("%") , 1, 0, 'J', 1);
                           $nota_a = $cal->nota;
                           $por = $carga->porcentaje / 100;
                           $porc1=$notaP1*$por;
                           $ac1=$ac1+$porc1;
                           $porc2=$notaP2*$por;
                           $ac2=$ac2+$porc2;
                           if (empty($notaN))
                           {
                               $nt = round($nota_a * $por, 1);
                               $nota = $cal->nota;
                               $ac = $ac + $nt;
                               $pdf->SetX(144);
                               $pdf->Cell(16, 6, $cal->nota, 1, 0, 'J', 1);
                           }
                           else
                           {
                               $nt = round($notaN * $por, 1);
                               $ac = $ac + $nt;
                               $pdf->SetX(144);
                               $pdf->Cell(16, 6, $cal->nota, 1, 0, 'J', 1);
                           }
                           if (empty($notaN) ) {
                               $proma=round(($nota+$notaP1+$notaP2)/3,1);
                              }else{
                               $niveladas++;
                               $proma=round(($notaN+$notaP1+$notaP2)/3,1);
                              }
                               $pdf->SetX(192);
                               $pdf->SetFont('Arial', 'B', 10);
                               $pdf->Cell(16, 6, $proma, 1, 1, 'C',1);

                           //Parte de Logros
                           if ($nota_a >= 0 && $nota_a <= 2.99)
                           {
                               $prefijo = Prefijo::find(1);
                               $pre1 = $prefijo->prefijo;
                               $su1 = $prefijo->subfijo;

                           }
                           elseif ($nota_a >= 3 && $nota_a <= 3.99)
                           {
                               $prefijo = Prefijo::find(2);
                               $pre1 = $prefijo->prefijo;
                               $su1 = $prefijo->subfijo;
                           }
                           elseif ($nota_a >= 4 && $nota_a <= 4.49)
                           {
                               $prefijo = Prefijo::find(3);
                               $pre1 = $prefijo->prefijo;
                               $su1 = $prefijo->subfijo;
                           }
                           else
                           {
                               $prefijo = Prefijo::find(4);
                               $pre1 = $prefijo->prefijo;
                               $su1 = $prefijo->subfijo;
                           }
                           $pdf->SetFont('Arial', '', 9);
                           $pdf->SetFillColor(255, 255, 255);
                           if (!empty($cal
                               ->logroCognitivo
                               ->descripcion))
                           {
                               $pdf->MultiCell('198', '5', utf8_decode($pre1) . " " . utf8_decode($cal
                                   ->logroCognitivo
                                   ->descripcion) . " " . utf8_decode($su1) , 1, 1, 'J', true);
                           }
                           if (!empty($cal
                               ->logroAfectivo
                               ->descripcion))
                           {
                               $pdf->MultiCell('198', '5', utf8_decode($cal
                                   ->logroAfectivo
                                   ->descripcion) , 1, 1, 'J');
                           }
                       }

                       $pdf->SetFont('Arial', 'B', 8);
                       $pdf->SetX(10);
                       $pdf->Cell(8, 6, $acih, 1, 0, 'C');
                       $pdf->SetX(18);
                       $pdf->SetFillColor(232, 232, 232);
                       $pdf->Cell(94, 6, "MATEMATICAS" . '    ' . utf8_decode('100%') , 1, 0, 'J', 1);
                       $pdf->SetX(112);
                       $pdf->Cell(16, 6, $ac1, 1, 0, 'J', 0);
                       $pdf->SetX(128);
                       $pdf->Cell(16, 6, $ac2, 1, 0, 'J', 0);
                       $pdf->SetX(144);
                       $pdf->Cell(16, 6, ($ac), 1, 0, 'J', 1);
                       $promac=round(($ac+$ac1+$ac2)/3,1);

                       $pdf->SetX(192);
                       $pdf->Cell(16, 6, round($promac, 1) , 1, 1, 'C',1);

                       //OTRAS MATERIAS
                       $act = 0;
                       $c5 = 0;
                       $ac5 = 0;
                       $calificaciones = Calificacion::reportCalificaciones($matricula->id, $periodo, 2, '');
                       foreach ($calificaciones as $cal)
                       {
                           $c5++;
                           $notaN = 0;
                           $ac5 = $ac5 + $c5;
                           $pdf->SetFont('Arial', '', 8);
                           $pdf->SetX(18);
                           $calPer1 = Calificacion::notaAnteriorEst($matricula->id, $cal->asignatura_id, 1);
                           if (!empty($calPer1))
                           {
                               $notaP1 = $calPer1->nota;
                               $pdf->SetX(112);
                               $pdf->SetFont('Arial', '', 8);
                               $pdf->SetFillColor(232, 232, 232);
                               $pdf->Cell(16, 6, $notaP1, 1, 0, 'J', 0);
                           }
                           $calPer2 = Calificacion::notaAnteriorEst($matricula->id, $cal->asignatura_id, 2);
                           if (!empty($calPer2))
                           {
                               $notaP2 = $calPer2->nota;
                               $pdf->SetX(128);
                               $pdf->SetFont('Arial', '', 8);
                               $pdf->SetFillColor(232, 232, 232);
                               $pdf->Cell(16, 6, $notaP2, 1, 0, 'J', 0);

                           }
                           if($cal->nota<3){
                               $nivelacionPeriodo=Nivelacion::getNivelacion($matricula->id, $cal->asignatura_id, $periodo);
                               //Si existe una nota de nivelacion de periodo
                               if(!empty($nivelacionPeriodo) ){
                                   $notaN=$nivelacionPeriodo->nota;
                                   $pdf->SetX(160);
                                   $pdf->SetFont('Arial', 'B', 10);
                                   $pdf->SetFillColor(232, 232, 232);
                                   $pdf->Cell(16, 6, $notaN, 1, 0, 'J',1);
                               }
                           }
                           $carga = CargaAcademica::getIhs($grado, $cal->asignatura_id);
                           $pdf->SetX(10);
                           $iha = $carga->ihs;
                           $acil = $acil + $iha;
                           $pdf->Cell(8, 6, $iha, 1, 0, 'C');
                           $pdf->SetX(18);
                           $pdf->SetFont('Arial', 'B', 8);
                           $pdf->SetFillColor(232, 232, 232);
                           $pdf->Cell(94, 6, utf8_decode($cal
                               ->asignatura
                               ->nombre) . '     ' . utf8_decode($carga->porcentaje) . ' ' . utf8_decode("%") , 1, 0, 'J', 1);
                           $nota_a = $cal->nota;
                           $por = $carga->porcentaje / 100;
                           if (empty($notaN))
                           {
                               $nt = round($nota_a * $por, 1);
                               $nota = $cal->nota;
                               $act = $act + $nt;
                               $pdf->SetX(144);
                               $pdf->Cell(16, 6, $cal->nota, 1, 0, 'J', 1);
                           }
                           else
                           {
                               $nt = round($notaN * $por, 1);
                               $act = $act + $nt;
                               $pdf->SetX(128);
                               $pdf->Cell(16, 6, $cal->nota, 1, 0, 'J', 0);
                           }

                           if (empty($notaN) ) {
                               $proma=round(($nota+$notaP1+$notaP2)/3,1);
                              }else{
                               $niveladas++;
                               $proma=round(($notaN+$notaP1+$notaP2)/3,1);
                              }
                               $pdf->SetX(192);
                               $pdf->SetFont('Arial', 'B', 10);
                               $pdf->Cell(16, 6, $proma, 1, 1, 'C',1);
                           //Parte de Logros
                           if ($nota_a >= 0 && $nota_a <= 2.99)
                           {
                               $prefijo = Prefijo::find(1);
                               $pre1 = $prefijo->prefijo;
                               $su1 = $prefijo->subfijo;

                           }
                           elseif ($nota_a >= 3 && $nota_a <= 3.99)
                           {
                               $prefijo = Prefijo::find(2);
                               $pre1 = $prefijo->prefijo;
                               $su1 = $prefijo->subfijo;
                           }
                           elseif ($nota_a >= 4 && $nota_a <= 4.49)
                           {
                               $prefijo = Prefijo::find(3);
                               $pre1 = $prefijo->prefijo;
                               $su1 = $prefijo->subfijo;
                           }
                           else
                           {
                               $prefijo = Prefijo::find(4);
                               $pre1 = $prefijo->prefijo;
                               $su1 = $prefijo->subfijo;
                           }
                           $pdf->SetFont('Arial', '', 9);
                           $pdf->SetFillColor(255, 255, 255);
                           if (!empty($cal
                               ->logroCognitivo
                               ->descripcion))
                           {
                               $pdf->MultiCell('198', '5', utf8_decode($pre1) . " " . utf8_decode($cal
                                   ->logroCognitivo
                                   ->descripcion) . " " . utf8_decode($su1) , 1, 1, 'J', true);
                           }
                           if (!empty($cal
                               ->logroAfectivo
                               ->descripcion))
                           {
                               $pdf->MultiCell('198', '5', utf8_decode($cal
                                   ->logroAfectivo
                                   ->descripcion) , 1, 1, 'J');
                           }

                       }
                       Auxiliar::disciplina($pdf, $matricula, $periodo);
                       $tac = $ac + $acl + $acs + $act;
                       $pdf->SetFillColor(232, 232, 232);
                       $tc = $c1 + $c2 + $c3 + $c5;
                       $promg = $tac / $tc;
                       $nprom = round($promg, 1);
                       Puesto::updateOrCreate(['matricula_id' => $matricula->id, 'periodo_id' => $periodo], ['matricula_id' => $matricula->id, 'periodo_id' => $periodo, 'promedio' => $nprom],);
                       if ($nprom >= 1 && $nprom <= 2.99)
                       {
                           $des = "DESEMPEÑO BAJO";
                       }
                       elseif ($nprom >= 3 && $nprom <= 3.99)
                       {
                           $des = "DESEMPEÑO BÁSICO";
                       }
                       elseif ($nprom >= 4 && $nprom <= 4.49)
                       {
                           $des = "DESEMPEÑO ALTO";
                       }
                       elseif ($nprom >= 4.5)
                       {
                           $des = "DESEMPEÑO SUPERIOR";
                       }
                       else
                       {
                           $des = "";
                       }
                       $pdf->SetFont('Arial', 'B', 9);
                       $posicion = 0;
                       $cont = 0;

                       $puestos = Puesto::getPuesto($sede, $grado, $periodo);
                       $total = count($puestos);
                       foreach ($puestos as $puesto)
                       {
                           $cont++;
                           if ($puesto->matricula_id == $matricula->id)
                           {
                               $posicion = $cont;
                               break;
                           }
                       }
                       $pdf->Cell(198, 6, ' PROMEDIO DE PERIODO: ' . $nprom . '        ' . utf8_decode($des) , 1, 1, 'J', 1);
                       $pdf->Cell(198, 6, ' PUESTO: ' . $posicion . '  DE ' . $total, 1, 1, 'J', 1);
                       Auxiliar::footer($pdf, $grado, $sede);
                   }
                   $pdf->Output();
                   exit;
                   $filas++;
               }
            break;
            case '4':
                $sql2 = "SELECT distinct idestudiante from calificaciones where idgrado='$grado' and  periodo ='$periodo' and idsede='$sede' ";
                $res2 = $mysqli->query($sql2);
                $num1 = $res2->num_rows;
                $i = 1;
                $pdf = new FPDF('P', 'mm', 'legal');
                $sql = "SELECT distinct c.idestudiante, e.nombres, e.apellidos, g.descripcion, s.nombre, e.num_doc, e.folio from calificaciones c inner join estudiantes e on c.idestudiante=e.idestudiante inner join grados g on c.idgrado=g.idgrado inner join sedes s on c.idsede=s.idsede  where c.idgrado='$grado' and  periodo ='$periodo' and  c.idsede='$sede' order by e.apellidos asc";

                $res = $mysqli->query($sql);
                while ($i <= $num1)
                {
                    while ($reg = $res->fetch_row())
                    {
                        $pdf->AddPage();
                        $pdf->SetFillColor(232, 232, 232);
                        $sqlc = "SELECT * FROM datos_colegio ";
                        $resc = $mysqli->query($sqlc);
                        $regc = $resc->fetch_row();
                        $pdf->SetFont('Arial', 'B', 16);
                        $pdf->Cell(190, 6, utf8_decode($regc[1]) , 0, 1, 'C');
                        $pdf->SetFont('Arial', '', 8);
                        $pdf->Cell(190, 4, utf8_decode($regc[2]) , 0, 1, 'C');
                        $pdf->Cell(190, 4, utf8_decode(' Plantel de Carácter Oficial') , 0, 1, 'C');
                        $pdf->Cell(190, 4, utf8_decode(' Resolución N° 1072 Mayo 31/04 y 1566 Agosto 06/04') , 0, 1, 'C');
                        $pdf->Cell(190, 6, utf8_decode(' Código Icfes ' . $regc[7]) , 0, 1, 'C');
                        $pdf->Cell(190, 6, utf8_decode($regc[6]) , 0, 1, 'C');
                        $pdf->Image('logo-ineda.png', 8, 6, 20);
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Ln(2);
                        $pdf->Cell(198, 6, utf8_decode(' INFORME ACADÉMICO Y/O DISCIPLINARIO') , 1, 1, 'C', 1);
                        $pdf->SetFont('Arial', '', 8);
                        $idest = $reg['0'];
                        $nom = $reg['1'] . ' ' . $reg['2'];
                        $pdf->Cell(113, 4, 'Nombres: ' . $nom, 1, 0, 'J');
                        $pdf->Cell(47, 4, 'Grado: ' . $reg['3'], 1, 0, 'J');
                        $pdf->Cell(38, 4, 'Periodo: ' . $periodo, 1, 1, 'J');
                        $pdf->Cell(40, 5, 'Sede: ' . $reg['4'], 1, 0, 'J');
                        $pdf->Cell(40, 5, utf8_decode(' N° Doc: ') . $reg['5'], 1, 0, 'J');
                        $pdf->Cell(33, 5, utf8_decode(' N° Folio: ') . $reg['6'], 1, 0, 'J');
                        $pdf->Cell(47, 5, utf8_decode(' Jornada: ') . $jornada, 1, 0, 'J');
                        $pdf->Cell(38, 5, utf8_decode(' Año: 2020 ') , 1, 1, 'J');
                        $pdf->Ln();
                        $pdf->SetFont('Arial', 'B', 8);
                        $pdf->Cell(102, 6, ' ', 0, 0, 'J');
                        $pdf->Cell(96, 6, 'PERIODOS  ', 1, 1, 'C', 1);
                        $pdf->Cell(8, 6, ' IHS', 1, 0, 'C', 1);

                        $pdf->Cell(94, 6, utf8_decode('ARÉAS Y/O ASIGNATURAS: ') , 1, 0, 'J', 1);
                        $pdf->Cell(16, 6, 'I  ', 1, 0, 'C', 1);
                        $pdf->Cell(16, 6, 'II  ', 1, 0, 'C', 1);
                        $pdf->Cell(16, 6, 'III  ', 1, 0, 'C', 1);
                        $pdf->Cell(16, 6, 'IV  ', 1, 0, 'C', 1);
                        $pdf->Cell(16, 6, 'NIV  ', 1, 0, 'C', 1);
                        $pdf->Cell(16, 6, 'DEF  ', 1, 1, 'C', 1);
                        $pdf->SetFont('Arial', '', 10);
                        //matematicas
                        $c1 = 0;
                        $ac = 0;
                        $acp1 = 0;
                        $acp2 = 0;
                        $acp3 = 0;
                        $acih = 0;
                        $sql1 = "SELECT * from calificaciones where idestudiante='$idest' and periodo='$periodo' and idgrado='$grado' and  idsede='$sede' and orden>1 and orden<=1.3  order by orden asc";
                        $res1 = $mysqli->query($sql1);
                        while ($reg1 = $res1->fetch_row())
                        {

                            $pdf->SetFont('Arial', '', 9);
                            $pdf->SetX(18);
                            $idasig = $reg1['2'];
                            $nota = $reg1['5'];
                            $sqlm = "SELECT c.ihs, c.porcentaje, a.nombre, c.idasignatura from carga_academica c inner join asignaturas a on a.idasignatura=c.idasignatura where c.idasignatura='$idasig' and c.idgrado='$grado' and c.idsede='$sede' ";
                            $resm = $mysqli->query($sqlm);
                            while ($regm = $resm->fetch_row())
                            {
                                $sqlnp = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='$periodo'";
                                $notaN = 0;
                                $resnp = $mysqli->query($sqlnp);
                                $num = $resnp->num_rows;
                                if ($num > 0)
                                {
                                    $regnp = $resnp->fetch_row();
                                    $pdf->SetX(176);
                                    $notaN = $regnp['0'];
                                    $pdf->SetFillColor(232, 232, 232);
                                    $pdf->Cell(16, 6, $notaN, 1, 0, 'J', 1);
                                }
                                $notap3N = 0;
                                $sqlnp3 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='3'";
                                $resnp3 = $mysqli->query($sqlnp3);
                                $regnp3 = $resnp3->fetch_row();
                                if (!empty($regnp3['0']))
                                {
                                    $notap3N = $regnp3['0'];
                                }
                                $notap2N = 0;
                                $sqlnp2 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='2'";
                                $resnp2 = $mysqli->query($sqlnp2);
                                $regnp2 = $resnp2->fetch_row();
                                if (!empty($regnp2['0']))
                                {
                                    $notap2N = $regnp2['0'];
                                }
                                $notap1N = 0;
                                $np = 0;
                                $sqlnp1 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='1'";
                                $resnp1 = $mysqli->query($sqlnp1);
                                $regnp1 = $resnp1->fetch_row();
                                if (!empty($regnp1['0']))
                                {
                                    $notap1N = $regnp1['0'];
                                }
                                //Calificaciones 3 periodo
                                $sqlcp3 = "SELECT nota from calificaciones where idestudiante='$idest' and periodo='3' and idgrado='$grado' and  idsede='$sede' and idasignatura='$idasig' ";
                                $rescp3 = $mysqli->query($sqlcp3);
                                $regcp3 = $rescp3->fetch_row();
                                if (!empty($regcp3['0']))
                                {
                                    $ncp3 = $regcp3['0'];
                                }
                                else
                                {
                                    $ncp3 = 0;
                                }

                                //2 periodo
                                $sqlcp2 = "SELECT nota from calificaciones where idestudiante='$idest' and periodo='2' and idgrado='$grado' and  idsede='$sede' and idasignatura='$idasig' ";
                                $rescp2 = $mysqli->query($sqlcp2);
                                $regcp2 = $rescp2->fetch_row();
                                if (!empty($regcp2['0']))
                                {
                                    $ncp2 = $regcp2['0'];
                                }
                                else
                                {
                                    $ncp2 = 0;
                                }
                                // 1 periodo
                                $sqlp1 = "SELECT nota from calificaciones where idestudiante='$idest' and periodo='1' and idgrado='$grado' and  idsede='$sede' and idasignatura='$idasig' ";
                                $rescp1 = $mysqli->query($sqlp1);
                                $regcp1 = $rescp1->fetch_row();
                                if (!empty($regcp1['0']))
                                {
                                    $ncp1 = $regcp1['0'];
                                }
                                else
                                {
                                    $ncp1 = 0;
                                }

                                if (empty($notap1N))
                                {
                                    $ntemp = round($ncp1 * ($regm['1'] / 100) , 1);
                                    $acp1 = $acp1 + $ntemp;
                                    $pdf->SetX(112);
                                    $nper1 = $ncp1;
                                    $pdf->Cell(16, 6, $nper1, 1, 0, 'J');

                                }
                                else
                                {
                                    $ntemp1 = round($notap1N * ($regm['1'] / 100) , 1);
                                    $acp1 = $acp1 + $ntemp1;
                                    $nper1 = $notap1N;
                                    $pdf->SetX(112);
                                    $pdf->Cell(16, 6, $nper1, 1, 0, 'J');
                                }
                                if (empty($notap2N))
                                {
                                    $ntemp = round($ncp2 * ($regm['1'] / 100) , 1);
                                    $acp2 = $acp2 + $ntemp;
                                    $pdf->SetX(128);
                                    $nper2 = $ncp2;
                                    $pdf->Cell(16, 6, $nper2, 1, 0, 'J');

                                }
                                else
                                {
                                    $ntemp = round($notap2N * ($regm['1'] / 100) , 1);
                                    $acp2 = $acp2 + $ntemp;
                                    $nper2 = $notap2N;
                                    $pdf->SetX(128);
                                    $pdf->Cell(16, 6, $nper2, 1, 0, 'J');
                                }
                                if (empty($notap3N))
                                {
                                    $ntemp = round($ncp3 * ($regm['1'] / 100) , 1);
                                    $acp3 = $acp3 + $ntemp;
                                    $pdf->SetX(144);
                                    $nper3 = $ncp3;
                                    $pdf->Cell(16, 6, $nper3, 1, 0, 'J');

                                }
                                else
                                {
                                    $ntemp = round($notap3N * ($regm['1'] / 100) , 1);
                                    $acp3 = $acp3 + $ntemp;
                                    $nper3 = $notap3N;
                                    $pdf->SetX(144);
                                    $pdf->Cell(16, 6, $nper3, 1, 0, 'J');
                                }

                                $c1 = 1;
                                $pdf->SetX(10);
                                $iha = $regm['0'];
                                $acih = $acih + $iha;
                                $pdf->Cell(8, 6, $regm['0'], 1, 0, 'C');
                                $pdf->SetX(18);
                                $pdf->SetFont('Arial', '', 9);
                                $pdf->Cell(94, 6, $regm['2'] . '     ' . $regm['1'] . ' ' . utf8_decode("%") , 1, 0, 'J');

                                if ($nota < 3 && !empty($notaN))
                                {
                                    $por = $regm['1'] / 100;
                                    $nt = round($notaN * $por, 1);
                                    $def = ($nper1 + $nper2 + $nper3 + $notaN) / 4;
                                    $ac = $ac + $nt;
                                }
                                else
                                {
                                    $por = $regm['1'] / 100;
                                    $nt = round($nota * $por, 1);
                                    $def = ($nper1 + $nper2 + $nper3 + $nota) / 4;
                                    $ac = $ac + $nt;
                                }
                                $pdf->SetX(160);
                                $pdf->Cell(16, 6, $reg1['5'], 1, 0, 'J');
                                $pdf->SetX(112);
                                $nota_a = $reg1['5'];

                                $pdf->SetFont('Arial', 'B', 9);
                                $proma = round($def, 1);
                                $pdf->SetX(192);
                                $pdf->Cell(16, 6, $proma, 1, 1, 'J');
                                $pdf->SetFont('Arial', '', 9);
                                if ($nota_a >= 0 && $nota_a <= 2.99)
                                {
                                    $sql3 = "select * from prefijos where idprefijo='1'";
                                    $res3 = $mysqli->query($sql3);
                                    $reg = $res3->fetch_row();
                                    $pre1 = $reg['1'];
                                    $su1 = $reg['2'];

                                }
                                elseif ($nota_a >= 3 && $nota_a <= 3.99)
                                {
                                    $sql3 = "select * from prefijos where idprefijo='2'";
                                    $res3 = $mysqli->query($sql3);
                                    $reg = $res3->fetch_row();
                                    $pre1 = $reg['1'];
                                    $su1 = $reg['2'];
                                }
                                elseif ($nota_a >= 4 && $nota_a <= 4.49)
                                {
                                    $sql3 = "select * from prefijos where idprefijo='3'";
                                    $res3 = $mysqli->query($sql3);
                                    $reg = $res3->fetch_row();
                                    $pre1 = $reg['1'];
                                    $su1 = $reg['2'];
                                }
                                else
                                {
                                    $sql3 = "select * from prefijos where idprefijo='4'";
                                    $res3 = $mysqli->query($sql3);
                                    $reg = $res3->fetch_row();
                                    $pre1 = $reg['1'];
                                    $su1 = $reg['2'];
                                }
                                $pdf->SetFont('Arial', '', 9);
                                $logro_c = $reg1['7'];
                                $logro_d = $reg1['8'];
                                $sql3 = "SELECT descripcion from logros_academicos where idlogro='$logro_c' and idasignatura='$idasig'";
                                $resl = $mysqli->query($sql3);
                                while ($regl = $resl->fetch_row())
                                {
                                    $pdf->SetFillColor(255, 255, 255);
                                    $pdf->MultiCell('198', '5', utf8_decode($pre1) . " " . utf8_decode($regl['0']) . " " . utf8_decode($su1) , 1, 1, 'J', true);

                                }
                                $sql4 = "SELECT descripcion from logros_academicos where idlogro='$logro_d' and idasignatura='$idasig'";
                                $res4 = $mysqli->query($sql4);
                                while ($reg4 = $res4->fetch_row())
                                {
                                    $pdf->SetFillColor(255, 255, 255);
                                    $pdf->MultiCell('198', '5', utf8_decode($reg4['0']) , 1, 1, 'J');
                                }
                                break;
                            }
                        }
                        $pdf->SetFont('Arial', 'B', 9);
                        $pdf->SetX(10);
                        $pdf->Cell(8, 6, $acih, 1, 0, 'C');
                        $pdf->SetX(18);
                        $pdf->SetFillColor(232, 232, 232);
                        $pdf->Cell(94, 6, "MATEMATICAS" . '    ' . utf8_decode('100%') , 1, 0, 'J', 1);
                        $pdf->SetX(112);
                        $pdf->Cell(16, 6, $acp1, 1, 0, 'J');
                        $pdf->SetX(128);
                        $pdf->Cell(16, 6, $acp2, 1, 0, 'J');
                        $pdf->SetX(144);
                        $pdf->Cell(16, 6, $acp3, 1, 0, 'J');
                        $pdf->SetX(160);
                        $pdf->Cell(16, 6, $ac, 1, 0, 'J', 1);
                        $pdf->SetX(192);
                        $acdef = ($acp1 + $acp2 + $acp3 + $ac) / 4;
                        $pdf->SetFont('Arial', 'B', 9);
                        $pdf->Cell(16, 6, round($acdef, 1) , 1, 1, 'J', 1);
                        $pdf->Ln(1.5);
                        $acp2 = 0;
                        $acp1 = 0;
                        $acp3 = 0;
                        $aclp1 = 0;
                        $aclp2 = 0;
                        $aclp3 = 0;
                        //Lenguaje
                        $acih = 0;
                        $acihl = 0;
                        $c2 = 0;
                        $acl = 0;
                        $sql1 = "SELECT * from calificaciones where idestudiante='$idest'  and periodo='$periodo' and idgrado='$grado' and idsede='$sede' and orden>2 and orden<=2.3  order by orden asc";
                        $res1 = $mysqli->query($sql1);
                        while ($reg1 = $res1->fetch_row())
                        {
                            $pdf->SetFont('Arial', '', 9);
                            $pdf->SetX(18);
                            $idasig = $reg1['2'];
                            $nota = $reg1['5'];
                            $sqlm = "SELECT c.ihs, c.porcentaje, a.nombre, c.idasignatura from carga_academica c inner join asignaturas a on a.idasignatura=c.idasignatura where c.idasignatura='$idasig' and c.idgrado='$grado' and c.idsede='$sede' ";
                            $resm = $mysqli->query($sqlm);
                            while ($regm = $resm->fetch_row())
                            {
                                $notaN = 0;
                                $sqln1 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='$periodo'";
                                $resn1 = $mysqli->query($sqln1);
                                $nv1 = $resn1->num_rows;
                                $notaN = 0;
                                if ($nv1 > 0)
                                {
                                    $regnp = $resn1->fetch_row();
                                    $pdf->SetX(176);
                                    $pdf->SetFillColor(232, 232, 232);
                                    $notaN = $regnp['0'];
                                    $pdf->Cell(16, 6, $notaN, 1, 0, 'J', 1);
                                }
                                $notap3N = 0;
                                $sqlnp3 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='3'";
                                $resnp3 = $mysqli->query($sqlnp3);
                                $regnp3 = $resnp3->fetch_row();
                                if (!empty($regnp3['0']))
                                {
                                    $notap3N = $regnp3['0'];
                                }
                                $notap2N = 0;
                                $sqlnp2 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='2'";
                                $resnp2 = $mysqli->query($sqlnp2);
                                $regnp2 = $resnp2->fetch_row();
                                if (!empty($regnp2['0']))
                                {
                                    $notap2N = $regnp2['0'];
                                }
                                $notap1N = 0;
                                $sqlnp1 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='1'";
                                $resnp1 = $mysqli->query($sqlnp1);
                                $regnp1 = $resnp2->fetch_row();
                                if (!empty($regnp1['0']))
                                {
                                    $notap2N = $regnp1['0'];
                                }
                                //Calificaciones periodo 3
                                $sqlp3 = "SELECT nota from calificaciones where idestudiante='$idest'  and periodo='3' and idgrado='$grado' and idsede='$sede' and idasignatura='$idasig'";
                                $rescp3 = $mysqli->query($sqlp3);
                                $regcp3 = $rescp3->fetch_row();
                                if (!empty($regcp3['0']))
                                {
                                    $nclp3 = $regcp3['0'];
                                }
                                else
                                {
                                    $nclp3 = 0;
                                }
                                //periodo 2
                                $sqlcp2 = "SELECT nota from calificaciones where idestudiante='$idest'  and periodo='2' and idgrado='$grado' and idsede='$sede' and idasignatura='$idasig'";
                                $rescp2 = $mysqli->query($sqlcp2);
                                $regcp2 = $rescp2->fetch_row();
                                if (!empty($regcp2['0']))
                                {
                                    $nclp2 = $regcp2['0'];
                                }
                                else
                                {
                                    $nclp2 = 0;
                                }
                                //periodo 1
                                $sqlcp1 = "SELECT nota from calificaciones where idestudiante='$idest'  and periodo='1' and idgrado='$grado' and idsede='$sede' and idasignatura='$idasig'";
                                $rescp1 = $mysqli->query($sqlcp1);
                                $regcp1 = $rescp1->fetch_row();
                                if (!empty($regcp1['0']))
                                {
                                    $nclp1 = $regcp1['0'];
                                }
                                else
                                {
                                    $nclp1 = 0;
                                }

                                if (empty($notap1N))
                                {
                                    $ntemp = round($nclp1 * ($regm['1'] / 100) , 1);
                                    $aclp1 = $aclp1 + $ntemp;
                                    $pdf->SetX(112);
                                    $np1 = $nclp1;
                                    $pdf->Cell(16, 6, $np1, 1, 0, 'J');

                                }
                                else
                                {
                                    $ntemp = round($notap1N * ($regm['1'] / 100) , 1);
                                    $aclp1 = $aclp1 + $ntemp;
                                    $np1 = $notap1N;
                                    $pdf->SetX(112);
                                    $pdf->Cell(16, 6, $notap1N, 1, 0, 'J');
                                }
                                if (empty($notap2N))
                                {
                                    $ntemp = round($nclp2 * ($regm['1'] / 100) , 1);
                                    $aclp2 = $aclp2 + $ntemp;
                                    $pdf->SetX(128);
                                    $np2 = $nclp2;
                                    $pdf->Cell(16, 6, $np2, 1, 0, 'J');
                                }
                                else
                                {
                                    $ntemp = round($notap2N * ($regm['1'] / 100) , 1);
                                    $aclp2 = $aclp2 + $ntemp;
                                    $np2 = $notap2N;
                                    $pdf->SetX(128);
                                    $pdf->Cell(16, 6, $np2, 1, 0, 'J');
                                }
                                if (empty($notap3N))
                                {
                                    $ntemp = round($nclp3 * ($regm['1'] / 100) , 1);
                                    $aclp3 = $aclp3 + $ntemp;
                                    $pdf->SetX(144);
                                    $np3 = $nclp3;
                                    $pdf->Cell(16, 6, $np3, 1, 0, 'J');
                                }
                                else
                                {
                                    $ntemp = round($notap3N * ($regm['1'] / 100) , 1);
                                    $aclp3 = $aclp3 + $ntemp;
                                    $np3 = $notap3N;
                                    $pdf->SetX(144);
                                    $pdf->Cell(16, 6, $np3, 1, 0, 'J');
                                }
                                $c2 = 1;
                                $pdf->SetX(10);
                                $iha = $regm['0'];
                                $acihl = $acihl + $iha;
                                $pdf->Cell(8, 6, $regm['0'], 1, 0, 'C');
                                $pdf->SetX(18);
                                $pdf->SetFont('Arial', '', 9);
                                $pdf->Cell(94, 6, utf8_decode($regm['2'] . '     ' . $regm['1']) . ' ' . utf8_decode("%") , 1, 0, 'J');
                                if ($nota < 3 && !empty($notaN))
                                {
                                    $por = $regm['1'] / 100;
                                    $nt = round($notaN * $por, 1);
                                    $defl = ($np1 + $np2 + $np3 + $notaN) / 4;
                                    $acl = $acl + $nt;
                                }
                                else
                                {
                                    $por = $regm['1'] / 100;
                                    $nt = round($nota * $por, 1);
                                    $defl = ($np1 + $np2 + $np3 + $nota) / 4;
                                    $acl = $acl + $nt;
                                }
                                $pdf->SetX(160);
                                $pdf->Cell(16, 6, $reg1['5'], 1, 0, 'J');
                                $pdf->SetX(112);
                                $nota_a = $reg1['5'];
                                $pdf->SetFont('Arial', 'B', 9);
                                $promal = round($defl, 1);
                                $pdf->SetX(192);
                                $pdf->SetFont('Arial', 'B', 9);
                                $pdf->Cell(16, 6, $promal, 1, 1, 'J');
                                $pdf->SetFont('Arial', '', 9);
                                if ($nota_a >= 0 && $nota_a <= 2.99)
                                {
                                    $sql3 = "select * from prefijos where idprefijo='1'";
                                    $res3 = $mysqli->query($sql3);
                                    $reg = $res3->fetch_row();
                                    $pre1 = $reg['1'];
                                    $su1 = $reg['2'];

                                }
                                elseif ($nota_a >= 3 && $nota_a <= 3.99)
                                {
                                    $sql3 = "select * from prefijos where idprefijo='2'";
                                    $res3 = $mysqli->query($sql3);
                                    $reg = $res3->fetch_row();
                                    $pre1 = $reg['1'];
                                    $su1 = $reg['2'];
                                }
                                elseif ($nota_a >= 4 && $nota_a <= 4.49)
                                {
                                    $sql3 = "select * from prefijos where idprefijo='3'";
                                    $res3 = $mysqli->query($sql3);
                                    $reg = $res3->fetch_row();
                                    $pre1 = $reg['1'];
                                    $su1 = $reg['2'];
                                }
                                else
                                {
                                    $sql3 = "select * from prefijos where idprefijo='4'";
                                    $res3 = $mysqli->query($sql3);
                                    $reg = $res3->fetch_row();
                                    $pre1 = $reg['1'];
                                    $su1 = $reg['2'];
                                }
                                $pdf->SetFont('Arial', '', 9);
                                $logro_c = $reg1['7'];
                                $logro_d = $reg1['8'];
                                $sql3 = "SELECT descripcion from logros_academicos where idlogro='$logro_c' and idasignatura='$idasig'";

                                $resl = $mysqli->query($sql3);
                                while ($regl = $resl->fetch_row())
                                {
                                    $pdf->SetFillColor(255, 255, 255);
                                    $pdf->MultiCell('198', '5', utf8_decode($pre1) . " " . utf8_decode($regl['0']) . " " . utf8_decode($su1) , 1, 1, 'J', true);

                                }
                                $sql4 = "SELECT descripcion from logros_academicos where idlogro='$logro_d' and idasignatura='$idasig'";
                                $res4 = $mysqli->query($sql4);
                                while ($reg4 = $res4->fetch_row())
                                {
                                    $pdf->SetFillColor(255, 255, 255);
                                    $pdf->MultiCell('198', '5', utf8_decode($reg4['0']) , 1, 1, 'J');
                                }
                                break;
                            }
                        }
                        $pdf->SetFont('Arial', 'B', 9);
                        $pdf->SetX(10);
                        $pdf->Cell(8, 6, $acihl, 1, 0, 'C');
                        $pdf->SetX(18);
                        $pdf->SetFillColor(232, 232, 232);
                        $pdf->Cell(94, 6, "HUMANIDADES" . '    ' . utf8_decode('100%') , 1, 0, 'J', 1);
                        $pdf->SetX(112);
                        $pdf->Cell(16, 6, $aclp1, 1, 0, 'J');
                        $pdf->SetX(128);
                        $pdf->Cell(16, 6, $aclp2, 1, 0, 'J');
                        $pdf->SetX(144);
                        $pdf->Cell(16, 6, $aclp3, 1, 0, 'J');
                        $pdf->SetX(160);
                        $pdf->Cell(16, 6, $acl, 1, 0, 'J', 1);
                        $pdf->SetX(192);
                        $acdefl = ($aclp1 + $aclp2 + $aclp3 + $acl) / 4;
                        $pdf->SetFont('Arial', 'B', 8);
                        $pdf->Cell(16, 6, round($acdefl, 1) , 1, 1, 'J', 1);
                        $aclp1 = 0;
                        $aclp2 = 0;
                        $aclp3 = 0;
                        $acih = 0;
                        $acihl = 0;
                        $pdf->Ln(1.5);

                        //OTRAS MATERIAS
                        $act = 0;
                        $c5 = 0;
                        $ac5 = 0;
                        $acomp1 = 0;
                        $sql1 = "SELECT  * from calificaciones where idestudiante='$idest'  and periodo='$periodo' and idgrado='$grado' and idsede='$sede' and orden>=3 order by orden asc";
                        $res1 = $mysqli->query($sql1);
                        while ($reg1 = $res1->fetch_row())
                        {
                            $pdf->SetFillColor(232, 232, 232);
                            $c5++;
                            $notaN = 0;
                            $ac5 = $ac5 + $c5;
                            $pdf->SetFont('Arial', '', 9);
                            $pdf->SetX(18);
                            $idasig = $reg1['2'];
                            $sqlm = "SELECT c.ihs, c.porcentaje, a.nombre, c.idasignatura from carga_academica c inner join asignaturas a on a.idasignatura=c.idasignatura where c.idasignatura='$idasig' and c.idgrado='$grado' and c.idsede='$sede' ";
                            $resm = $mysqli->query($sqlm);
                            while ($regm = $resm->fetch_row())
                            {
                                $sqln1 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='$periodo'";
                                $resn1 = $mysqli->query($sqln1);
                                $nv1 = $resn1->num_rows;
                                while ($regn1 = $resn1->fetch_row())
                                {
                                    $pdf->SetX(160);
                                    $pdf->SetFont('Arial', 'B', 9);
                                    $pdf->Cell(16, 6, $regn1['0'], 1, 0, 'J', 1);
                                    $notaN = $regn1['0'];
                                }
                                $notap3N = 0;
                                $np3 = 0;
                                $sqlnp3 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='3'";
                                $resnp3 = $mysqli->query($sqlnp3);
                                $regnp3 = $resnp3->fetch_row();
                                if (!empty($regnp3['0']))
                                {
                                    $notap3N = $regnp3['0'];
                                }
                                $notap2N = 0;
                                $np2 = 0;
                                $sqlnp2 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='2'";
                                $resnp2 = $mysqli->query($sqlnp2);
                                $regnp2 = $resnp2->fetch_row();
                                if (!empty($regnp2['0']))
                                {
                                    $notap2N = $regnp2['0'];
                                }
                                $notap1N = 0;
                                $np1 = 0;
                                $sqlnp1 = "SELECT nota from nivelaciones where idestudiante='$idest'  and idasignatura='$idasig' and periodo ='1'";
                                $resnp1 = $mysqli->query($sqlnp1);
                                $regnp1 = $resnp1->fetch_row();
                                if (!empty($regnp1['0']))
                                {
                                    $notap1N = $regnp1['0'];
                                }
                                //periodo 3
                                $sqlmp3 = "SELECT nota from calificaciones where idestudiante='$idest'  and periodo='3' and idgrado='$grado' and idsede='$sede' and idasignatura='$idasig'";
                                $resmp3 = $mysqli->query($sqlmp3);
                                $regcp3 = $resmp3->fetch_row();
                                if (!empty($regcp3['0']))
                                {
                                    $ncomp3 = $regcp3['0'];
                                }
                                else
                                {
                                    $ncomp3 = 0;
                                }
                                //Periodo 2
                                $sqlmp2 = "SELECT nota from calificaciones where idestudiante='$idest'  and periodo='2' and idgrado='$grado' and idsede='$sede' and idasignatura='$idasig'";
                                $resmp2 = $mysqli->query($sqlmp2);
                                $regcp2 = $resmp2->fetch_row();
                                if (!empty($regcp2['0']))
                                {
                                    $ncomp2 = $regcp2['0'];
                                }
                                else
                                {
                                    $ncomp2 = 0;
                                }
                                //Periodo 1
                                $sqlmp1 = "SELECT nota from calificaciones where idestudiante='$idest'  and periodo='1' and idgrado='$grado' and idsede='$sede' and idasignatura='$idasig'";
                                $resmp1 = $mysqli->query($sqlmp1);
                                $regcp1 = $resmp1->fetch_row();
                                if (!empty($regcp1['0']))
                                {
                                    $ncomp1 = $regcp1['0'];
                                }
                                else
                                {
                                    $ncomp1 = 0;
                                }
                                $pdf->SetFont('Arial', 'B', 9);
                                if (empty($notap1N))
                                {
                                    $pdf->SetX(112);
                                    $np1 = $ncomp1;
                                    $pdf->Cell(16, 6, $np1, 1, 0, 'J');
                                }
                                else
                                {
                                    $np1 = $notap1N;
                                    $pdf->SetX(112);
                                    $pdf->Cell(16, 6, $notap1N, 1, 0, 'J');
                                }
                                if (empty($notap2N))
                                {
                                    $pdf->SetX(128);
                                    $np2 = $ncomp2;
                                    $pdf->Cell(16, 6, $np2, 1, 0, 'J');
                                }
                                else
                                {
                                    $np2 = $notap2N;
                                    $pdf->SetX(128);
                                    $pdf->Cell(16, 6, $np2, 1, 0, 'J');
                                }
                                if (empty($notap3N))
                                {
                                    $pdf->SetX(144);
                                    $np3 = $ncomp3;
                                    $pdf->Cell(16, 6, $np3, 1, 0, 'J');
                                }
                                else
                                {
                                    $np3 = $notap3N;
                                    $pdf->SetX(144);
                                    $pdf->Cell(16, 6, $np3, 1, 0, 'J');
                                }
                                $pdf->SetX(10);
                                $pdf->Cell(8, 6, $regm['0'], 1, 0, 'C');
                                $pdf->SetX(18);
                                $pdf->Cell(94, 6, utf8_decode($regm['2'] . '     ' . $regm['1']) . ' ' . utf8_decode("%") , 1, 0, 'J', 1);
                                $nota_a = $reg1['5'];
                                if ($nota < 3 && !empty($notaN))
                                {
                                    $por = $regm['1'] / 100;
                                    $nt = round($notaN * $por, 2);
                                    $def = ($np1 + $np2 + $np3 + $nota_a) / 4;
                                    $act = $act + $notaN;
                                }
                                else
                                {
                                    $por = $regm['1'] / 100;
                                    $nt = round($nota * $por, 2);
                                    $act = $act + $nota_a;
                                    $def = ($np1 + $np2 + $np3 + $nota_a) / 4;
                                }
                                $pdf->SetX(160);
                                $pdf->Cell(16, 6, $reg1['5'], 1, 0, 'J', 1);
                                $pdf->SetX(112);
                                $nota_a = $reg1['5'];
                                $promom = round($def, 1);
                                $pdf->SetX(192);
                                $pdf->Cell(16, 6, $promom, 1, 1, 'J', 1);
                                $pdf->SetFont('Arial', '', 9);
                                if ($nota_a >= 0 && $nota_a <= 2.99)
                                {
                                    $sql3 = "select * from prefijos where idprefijo='1'";
                                    $res3 = $mysqli->query($sql3);
                                    $reg = $res3->fetch_row();
                                    $pre1 = $reg['1'];
                                    $su1 = $reg['2'];

                                }
                                elseif ($nota_a >= 3 && $nota_a <= 3.99)
                                {
                                    $sql3 = "select * from prefijos where idprefijo='2'";
                                    $res3 = $mysqli->query($sql3);
                                    $reg = $res3->fetch_row();
                                    $pre1 = $reg['1'];
                                    $su1 = $reg['2'];
                                }
                                elseif ($nota_a >= 4 && $nota_a <= 4.49)
                                {
                                    $sql3 = "select * from prefijos where idprefijo='3'";
                                    $res3 = $mysqli->query($sql3);
                                    $reg = $res3->fetch_row();
                                    $pre1 = $reg['1'];
                                    $su1 = $reg['2'];
                                }
                                else
                                {
                                    $sql3 = "select * from prefijos where idprefijo='4'";
                                    $res3 = $mysqli->query($sql3);
                                    $reg = $res3->fetch_row();
                                    $pre1 = $reg['1'];
                                    $su1 = $reg['2'];
                                }
                                $pdf->SetFont('Arial', '', 9);
                                $logro_c = $reg1['7'];
                                $logro_d = $reg1['8'];
                                $sql3 = "SELECT descripcion from logros_academicos where idlogro='$logro_c' and idasignatura='$idasig'";

                                $resl = $mysqli->query($sql3);
                                while ($regl = $resl->fetch_row())
                                {
                                    $pdf->SetFillColor(255, 255, 255);
                                    $pdf->MultiCell('198', '5', utf8_decode($pre1) . " " . utf8_decode($regl['0']) . " " . utf8_decode($su1) , 1, 1, 'J', true);

                                }
                                $sql4 = "SELECT descripcion from logros_academicos where idlogro='$logro_d' and idasignatura='$idasig'";
                                $res4 = $mysqli->query($sql4);
                                while ($reg4 = $res4->fetch_row())
                                {
                                    $pdf->SetFillColor(255, 255, 255);
                                    $pdf->MultiCell('198', '5', utf8_decode($reg4['0']) , 1, 1, 'J');
                                }
                                $aclp1 = 0;
                                $aclp2 = 0;
                                $aclp3 = 0;
                                $pdf->Ln(1.5);
                                break;
                            }
                        }
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->SetFillColor(232, 232, 232);
                        $pdf->Cell(198, 6, ' DISCIPLINA ', 1, 1, 'J', 1);
                        $sqlc = "SELECT l.descripcion  from convivencia_escolar c inner join logros_disciplinarios l on c.idlogro_dis=l.idlogro_dis where idestudiante='$idest' and c.idgrado='$grado' and c.periodo='$periodo' and c.idsede='$sede' ";
                        $resc = $mysqli->query($sqlc);
                        $regc = $resc->fetch_row();
                        $pdf->SetFont('Arial', '', 9);
                        $pdf->SetFillColor(255, 255, 255);
                        $pdf->MultiCell('198', '5', utf8_decode($regc['0']) , 1, 1, 'J');
                        $tac = $ac + $acl + $act;
                        $tc = $c1 + $c2 + $c5;
                        $promg = $tac / $tc;
                        $nprom = round($promg, 1);
                        if ($nprom > 0 && $nprom <= 2.99)
                        {
                            $des = "DESEMPEÑO BAJO";
                        }
                        elseif ($nprom >= 3 && $nprom <= 3.99)
                        {
                            $des = "DESEMPEÑO BÁSICO";
                        }
                        elseif ($nprom >= 4 && $nprom <= 4.49)
                        {
                            $des = "DESEMPEÑO ALTO";
                        }
                        elseif ($nprom >= 4.5)
                        {
                            $des = "DESEMPEÑO SUPERIOR";
                        }
                        else
                        {
                            $des = "";
                        }
                        $pdf->SetFillColor(232, 232, 232);
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(198, 5, ' PROMEDIO DE PERIODO: ' . $nprom . '        ' . utf8_decode($des) , 1, 1, 'J', 1);
                        $pr = round($promg, 2);
                        $pdf->Cell(198, 6, ' OBSERVACIONES', 1, 1, 'J', 1);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->Cell(198, 9, ' ', 1, 1, 'J');
                        $pdf->Ln(15);
                        $pdf->Cell(80, 0, ' ', 1, 1, 'J');
                        $pdf->Ln(0.5);
                        $sql = "SELECT p.nombres, p.apellidos  from direccion_grado d inner join personal p on d.iddocente=p.idpersonal where d.idgrado='$grado' and d.idsede='$sede'";
                        $resa = $mysqli->query($sql);
                        $rega = $resa->fetch_row();
                        $nom_ac = $rega['0'] . ' ' . $rega['1'];
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(190, 4, utf8_decode($nom_ac) , 0, 1, 'J');
                        $pdf->Cell(40, 6, 'Director de Grupo', 0, 1, 'J');
                        $pdf->Ln();
                    }

                    $i++;

                }
            break;
            default:
                echo "error";
            break;
        }
        $pdf->Output();
        exit;
    }

}

