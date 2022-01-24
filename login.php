<?php
include_once __DIR__ . '/header.php';
include_once __DIR__ . '/helpers/validate_inputs.php';
?>
<link rel="stylesheet" href="styles/tasks_view.css">
<form class="forms" method="post" action="controllers/Users.php">

    <input type="hidden" name="type" value="login">
    <label>
        Login: <br>
        <input type="text" name="usersLogin" placeholder="Wpisz swój login">

    </label> <br>


    <label>
        Hasło: <br>
        <input type="password" name="usersPassword" placeholder="Wpisz swoje haslo">
    </label> <br>
    <?php checkInputs('login') ?>

    <button class="btn btn-hover"type="submit" name="submit"> Zaloguj się!</button>

</form>
<h3 style="padding-top: 30px; text-align:center;"> Nie masz jeszcze konta? <a href="register.php"> Zarejestruj się! </a>
</h3>


<?php
include_once __DIR__ . '/footer.php'
?>


