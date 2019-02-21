<?php
if (!isset($_SESSION['logged_in'])) {
    require('db.php');
    $query = $pdo->prepare('SELECT value FROM config WHERE name=?');
    $query->execute(["LOGIN_URL"]);
    $_SESSION['login_url'] = $query->fetch()['value'];
    $_SESSION['logged_in'] = false;
}

if (!$_SESSION['logged_in'] && !isset($isLoginPage)) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SESSION['login_url']);
}
?>