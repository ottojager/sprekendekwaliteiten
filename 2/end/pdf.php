<?php
session_start();
require('../../fpdf/fpdf.php');

if (!isset($_SESSION['player_id'] && !isset($_SESSION['game_id']))) {
	header('Location: ../');
}

$game = $_SESSION['game_id'];
$player = $_SESSION['player_id'];
$json = json_decode(@file_get_contents("../games/$game.json"), true);
if (!(bool)$json) { // if the json is empty or not existant
	@unlink("../games/$game.json"); // remove bugged .json if it even exists
	header('Location: ../delete.php'); // send to user to have it's session deleted
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16); // set various font options (font family, style, size)
$pdf->Cell(0, 10, 'Kwaliteiten spell', 0, 1, 'C'); // add text in a new 10 heigh centered cell without a border

$pdf->SetFont('Arial', '', 12); // reset font to something more standard
foreach ($json['players'][$player]['stack'] as $key => $value) {
	$pdf->Cell(0, 6, $value, 0, 1, 'C');
}

$pdf->Output(); // sends the PDF to the user
                // browsers with a build in PDF viewer will show it
                // other browsers will download it
?>
