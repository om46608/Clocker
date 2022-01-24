<!--Header-->
<?php
include_once __DIR__ . '/header.php';
//require_once '../helpers/View.php';
?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Clocker </title>
</head>

<h1 id="index-text"> <?php
    if (isset($_SESSION['usersId'])) {
        echo $_SESSION['usersLogin'];
    } else {
        echo '<h1 class="menu"> CLOCKER</h1>';
        echo '<h3 class="menu"> Twój czas jest na wagę złota </h3>';
    }
    ?> </h1>

<!--Wyświetlanie ogólnych statystyk (jeżeli user nie jest zalogowany) lub panel usera/admina (jeżeli user jest zalogowany)-->
<?php
if (!isset($_SESSION['usersId'])) {
    include_once __DIR__ . '/stats_for_everyone.php';
} else {
    if ($_SESSION['usersLogin'] == 'admin')
        include_once __DIR__ . '/adminpanel.php';
    if ($_SESSION['usersLogin'] != 'admin')
        include_once __DIR__ . '/userpanel.php';
}
?>

<!--Możliwość logowania i rejestracji (jeżeli user nie jest zalogowany) lub wylogowywania (jeżeli user jest zalogowany)-->
<?php
if (!isset($_SESSION['usersId'])) {
    include_once __DIR__ . '/login_and_register_buttons.php';
}
?>

<!--Footer-->
<?php
//include_once  __DIR__ . '/footer.php';
//?>
<!---->
