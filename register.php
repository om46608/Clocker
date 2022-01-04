<?php
include_once 'header.php';
?>

    <h1>Zarejestruj się!</h1>

    <form method="post" action="controllers/Users.php">
        <input type="hidden" name="type" value="register">

        <label>
            Imię: <br>
            <input type="text" name="usersFirstName" maxlength="50" placeholder="Wpisz swoje imię">
        </label> <br>

        <label>
            Nazwisko: <br>
            <input type="text" name="usersLastName" maxlength="50" placeholder="Wpisz swoje nazwisko">
        </label> <br>

        <label>
            Login: <br>
            <input type="text" name="usersLogin" maxlength="50" placeholder="Wpisz swoj login">
        </label> <br>

        <label>
            E-mail: <br>
            <input type="text" name="usersEmail" maxlength="50" placeholder="Wpisz swoj e-mail">
        </label> <br>

        <label>
            Hasło: <br>
            <input type="password" name="usersPassword" maxlength="25" placeholder="Wpisz swoje haslo">
        </label> <br>

        <label>
            Powtórz hasło: <br>
            <input type="password" name="repeatUsersPassword" maxlength="25" placeholder="Wpisz ponownie swoje haslo">
        </label> <br>

        <button type="submit" name="submit"> Zarejestruj się!</button>
    </form>

<?php
include_once 'footer.php'
?>