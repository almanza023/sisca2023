<?php

namespace App\Models\Reportes;

use App\Models\CargaAcademica;
use App\models\Convivencia;
use App\models\DireccionGrado;
use App\Models\LogroDisciplinario;
use App\Models\Nivelacion;
use App\Models\Prefijo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteNotas extends Model
{

    public static function reporte($pdf, $cabecera, $data, $periodo)
    {
        Auxiliar::headerPdf($pdf, $periodo, 'CALIFICACIONES  DE PERIODO');

        $pdf->Cell(190, 15, '', 1, 0, 'J');
        $pdf->Ln(4);

        $pdf->Cell(120, 6, utf8_decode('AREA/ASIGNATURA: ') . utf8_decode($cabecera['asignatura']), 0, 0, 'J');
        $pdf->Cell(150, 6, 'PERIODO: ' . $periodo, 0, 0, 'J');
        $pdf->SetY(48);
        $pdf->Cell(120, 6, 'DOCENTE: ' . utf8_decode($cabecera['docente']), 0, 0, 'J');
        $pdf->SetY(48);
        $pdf->SetX(130);
        $pdf->Cell(20, 6, utf8_decode('SEDE: ') . utf8_decode($cabecera['sede']), 0, 0, 'J');
        $pdf->SetY(48);
        $pdf->SetX(170);
        $pdf->Cell(20, 6, utf8_decode('AÑO: 2023'), 0, 0, 'J');
        $pdf->Ln(20);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, utf8_decode('N°'), 1, 0, 'C', 1);
        $pdf->Cell(100, 6, utf8_decode('ESTUDIANTE'), 1, 0, 'J', 1);
        $pdf->Cell(40, 6, utf8_decode('NOTA DE PERIODO'), 1, 0, 'J', 1);
        $pdf->Cell(40, 6, utf8_decode('FECHA SUBIDA'), 1, 0, 'J', 1);
        $pdf->Ln();
        $i=0;
        foreach ($data as  $item) {
            $i++;
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(10, 6, $i, 1, 0, 'J');
            $pdf->Cell(100, 6, utf8_decode($item->apellidos . ' ' . $item->nombres), 1, 0, 'J');
            $pdf->Cell(40, 6, $item->nota, 1, 0, 'J');
            $pdf->Cell(40, 6, $item->created_at, 1, 0, 'J');
            $pdf->Ln();
        }

        $pdf->Output();
        exit;



    }
}
