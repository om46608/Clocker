<?php
include_once 'header_admin.php';
?>
<h2> Panel admina </h2>

<!-- -->
<!--Szukanie usera po loginie -->
<p>Szukanie usera:</p>
<?php
include_once 'show_specific_user.php';

print_r($_POST);
print_r($_SESSION);
print_r($_SERVER);



if(isset($_POST['submit'])) {
    if (empty($_POST['userSearchInput'])) {
        echo "bro";
    }
    $searchInput = $_POST['userSearchInput'];
    echo $searchInput;



}
?>

<!-- Pokaz wszystkich userow -->
<?php
include_once 'show_users.php';
include_once 'logout.php';
?>

<!--Wglad w dane usera -->
