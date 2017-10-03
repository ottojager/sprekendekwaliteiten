<?php
require('../../fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16); // set various font options (font family, style, size)
$pdf->Cell(0, 10, 'Kwaliteiten spell', 0, 1, 'C'); // add the text in a 10 heigh cell without a border that's centered

$pdf->Output(); // sends the PDF to the user
                // browsers with a build in PDF viewer will show it
                // other browsers will download it
 ?>
