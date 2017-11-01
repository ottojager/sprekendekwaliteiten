<?php
require('../fpdf/fpdf.php');


if (!isset($_GET['cards'])) {
	header('Location: ./');
}

$cards = explode(',', $_GET['cards']);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16); // set various font options (font family, style, size)
$pdf->Cell(0, 10, 'Kwaliteiten spel', 0, 1, 'C'); // add text in a new 10 heigh centered cell without a border

$pdf->SetFont('Arial', '', 12); // reset font to something more standard
foreach ($cards as $key => $value) {
	$pdf->Cell(0, 6, $value, 0, 1, 'C');
}

$pdf->Output(); // sends the PDF to the user
                // browsers with a build in PDF viewer will show it
                // other browsers will download it
?>
