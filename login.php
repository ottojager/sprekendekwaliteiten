<?php
    session_start();
    $isLoginPage = true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" sizes="16x16" type="image/png" href="bewustwording/Rainbow_placeholder.png">
    <link rel="stylesheet" href="./css/basis.css" type="text/css">
    <link rel="stylesheet" href="./css/header.css" type="text/css">
    <link rel="stylesheet" href="./css/footer.css" type="text/css">
    <title>Inloggen</title>
</head>
<body>
    <?php
    require("header.php"); 
    ?>
    <?php 
        if ($_SESSION['logged_in']) {
            header('Location: ./');
        }
    
        if (isset($_POST['username']) && isset($_POST['password'])) {
            
            include('db.php');
            $query = $pdo->prepare('SELECT * FROM users WHERE username=? AND password=?');
            $query->execute([$_POST['username'], sha1($_POST['password'])]);
            
            if ($query->fetchColumn() > 0)
            {
                $_SESSION['logged_in'] = true;
                header('Location: ./');
            }
        }
    ?>
    <form method="POST" action="login.php">
        Username:
        <input type="text" name="username">
        Password:
        <input type="password" name="password">
        <input type="submit" value="Inloggen">
    </form>

    <?php include("footer.php"); ?>
</body>
</html>