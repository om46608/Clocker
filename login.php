<?php
include_once 'header.php';
?>
<form method="post" action="controllers/Users.php">
    <input type="hidden" name="type" value="login">
    <label>
        Login: <br>
        <input type="text" name="usersLogin" placeholder="Wpisz swój login">
    </label> <br>
    <label>
        Hasło: <br>
        <input type="password" name="usersPassword" placeholder="Wpisz swoje haslo">
    </label> <br>
    <button type="submit" name="submit"> Zaloguj się!</button>
</form>
<h3> Nie masz jeszcze konta? <a href="register.php"> Zarejestruj się! </a></h3>
