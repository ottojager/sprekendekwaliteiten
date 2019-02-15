<?php
if (!isset($_SESSION['logged_in'])) {
    include('db.php');
    $query = $pdo->prepare('SELECT value FROM config WHERE name=?');
    $query->execute(["LOGIN_URL"]);
    $_SESSION['login_url'] = $query->fetch()['value'];
    $_SESSION['logged_in'] = 'not ok';
    echo 'we set it to not ok';
}

if ($_SESSION['logged_in'] == 'not ok' && !isset($isLoginPage)) {
    echo "check ".$_SESSION['logged_in'];
    header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SESSION['login_url']);
}
?>