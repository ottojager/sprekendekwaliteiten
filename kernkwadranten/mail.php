<?php
require('../mail/MailBuilder.php');
session_start();
$emailPosted = false;
$email = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST['email'];
        $emailPosted = true;
        $builder = new MailBuilder();
        $builder->setTitle('Kernkwadranten');
        $builder->insertQuadrants($_SESSION["kernkwadrant_results"]);
        $builder->sendMail($email);
    } else {
        $error = 'Ongeldig e-mailadres.';
    }
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/basis.css" type="text/css">
    <link rel="stylesheet" href="../css/header.css" type="text/css">
    <link rel="stylesheet" href="../css/footer.css" type="text/css">
    <link rel="stylesheet" href="../css/spelvorm2.css" type="text/css">
    <script src="./scripts.js"></script>
</head>

<body>
    <?php
    $spelvorm = 'Kernkwadranten';
    $in_sub_folder = true;

    require('../header.php');
    ?>
    <main class="container" id="main">
        <div class="email-container">
            <span class="alienBackLeft"></span>
            <span class="alienBackRight"></span>
            <?php if (!$emailPosted) : ?>
                <form method="POST" action="?">
                    <div class="form-email">
                        <label for="email">E-mail</label>
                        <input id="email" class="form-input" name="email" type="email" autofocus>
                        <p id="error"><?= $error ?></p>
                    </div>
                    <div class="button">
                            <input class="send-button" type="submit" value="Stuur e-mail">
                        </div>
                </form>
            <?php else : ?>
                <h1>E-mail is verzonden!</h1>
            <?php endif; ?>
            <div class="button">
                <button class="back-button" onclick="window.location='../index.php'">Terug naar home</button>
            </div>
        </div>
    </main>
    <?php include('../footer.php'); ?>
</body>

</html>
