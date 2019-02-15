<?php
if (!isset($_SESSION['logged_in'])) {
    include('db.php');
    $query = $pdo->prepare('SELECT value FROM config WHERE name=?');
/*
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'localonly', 'localonly');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    
        $pdo->prepare('INSERT INTO DoesNotExist (x) VALUES (?)');
    }
    catch(Exception $e) {
        echo 'Exception -> ';
        var_dump($e->getMessage());
    }
*/

    $query->execute(["LOGIN_URL"]);
    $_SESSION['login_url'] = $query->fetch()['value'];
    $_SESSION['logged_in'] = 'not ok';
    echo('we set it to not ok');
}

if ($_SESSION['logged_in'] == 'not ok' && !isset($isLoginPage)) {
    //echo("check ".$_SESSION['logged_in']);
    header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SESSION['login_url']);
}
?>