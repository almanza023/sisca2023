<?php
include "fpdf/fpdf.php";
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', '7');
$pdf->Sety((40)/2);
$pdf->Setx((15)/2);
$pdf->Cell('110', '6', utf8_decode('Este documento es un apéndice de mi proyecto fin de carrera. Lo escribí después de leer tres o cuatro libros sobre el tema y consultar algunas páginas de Internet. Lo cierto es que, sinceramente, no recuerdo las fuentes que utilicé, así que me temo que, por mucho
que me gustaría, me es imposible.'), 1, 1, 'J');
$pdf->Output();
