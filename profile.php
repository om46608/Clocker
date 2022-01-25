<?php
include_once __DIR__ . '/header.php';
include_once __DIR__ . '/helpers/validate_inputs.php';
?>
<link rel="stylesheet" href="styles/tasks_view.css">
<h1 style="color:white; text-align:center;">Edytuj profil!</h1>
<form class="forms" method="post" action="controllers/Users.php">
    <input type="hidden" name="type" value="update">
    <label>
        Imię: <br>
        <input type="text" name="usersFirstName" maxlength="50" placeholder="Wpisz swoje imię" value=<?php echo $_SESSION["usersFirstName"]?>>
    </label> <br>

    <label>
        Nazwisko: <br>
        <input type="text" name="usersLastName" maxlength="50" placeholder="Wpisz swoje nazwisko" value=<?php echo $_SESSION["usersLastName"]?>>
    </label> <br>

    <label>
        Login: <br>
        <input type="text" name="usersLogin" maxlength="50" placeholder="Wpisz swoj login" value=<?php echo $_SESSION["usersLogin"]?>>
    </label> <br>

    <label>
        E-mail: <br>
        <input type="text" name="usersEmail" maxlength="50" placeholder="Wpisz swoj e-mail" value=<?php echo $_SESSION["usersEmail"]?>>
    </label> <br>

    <label>
        Hasło: <br>
        <input type="password" name="usersPassword" maxlength="25" placeholder="Wpisz swoje haslo">
    </label> <br>

    <label>
        Powtórz hasło: <br>
        <input type="password" name="repeatUsersPassword" maxlength="25" placeholder="Wpisz ponownie swoje haslo">
    </label> <br>
    <?php checkInputs('update') ?>
    <button class="btn btn-hover"type="submit" name="submit"> Zaktualizuj profil!</button>
</form>
<?php
include_once __DIR__ . '/footer.php'
?>

