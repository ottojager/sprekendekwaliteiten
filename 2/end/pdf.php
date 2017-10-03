<?php
session_start();
require('../../fpdf/fpdf.php');

$game = $_SESSION['game_id'];
$player = $_SESSION['player_id'];
$json = json_decode(file_get_contents("../games/$game.json"), true);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16); // set various font options (font family, style, size)
$pdf->Cell(0, 10, 'Kwaliteiten spell', 0, 1, 'C'); // add the text in a 10 heigh cell without a border that's centered

$pdf->SetFont('Arial', '', 12); // reset font to something more standard
foreach ($json['players'][$player]['stack'] as $key => $value) {
	$pdf->Cell(0, 6, $value, 0, 1, 'C');
}

$pdf->Output(); // sends the PDF to the user
                // browsers with a build in PDF viewer will show it
                // other browsers will download it
 ?>
