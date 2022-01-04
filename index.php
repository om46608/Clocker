<!--Header-->
<?php
include_once 'header.php';
//require_once '../helpers/View.php';
?>

<h1 id="index-text">Użytkownik <?php
    session_start();
    if (isset($_SESSION['usersId'])) {
        echo $_SESSION['usersLogin'];
    }
    else {
        echo "niezalogowany";
    }
    ?> </h1>

<!--Wyświetlanie ogólnych statystyk (jeżeli user nie jest zalogowany) lub panel usera (jeżeli user jest zalogowany)-->
<?php
if (!isset($_SESSION['usersId'])) {
    include_once 'stats_for_everyone.php';
} else {
    if ($_SESSION['usersLogin'] == 'admin')
        //include_once 'adminpanel.php';
        $newURL = 'adminpanel.php';
        header('Location: ' . $newURL);


    if ($_SESSION['usersLogin'] != 'admin')
        include_once 'userpanel.php';
}
?>

<!--Możliwość logowania i rejestracji (jeżeli user nie jest zalogowany) lub wylogowywania (jeżeli user jest zalogowany)-->
<?php
if (!isset($_SESSION['usersId'])) {
    include_once 'login_and_register_buttons.php';
} else {
    include_once 'logout.php';
}
?>

<!--Footer-->
<?php
include_once 'footer.php';
?>
