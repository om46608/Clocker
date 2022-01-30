<link rel="stylesheet" href="style.css"/>
<div class="wrap">
    <ul>
        <li>
            <button class="menu" onclick="window.location.href='index.php?action=login';"> Zaloguj się
        </li>
        <li>
            <button class="menu" onclick="window.location.href='index.php?action=register';">Zarejestruj się
        </li>
        <li><a href="./index.php?action=guest">
                <button class="menu">Wypróbuj jako gość</button>
            </a></li>
        <form id="Guest" method="post" action="controllers/Users.php">
            <input type="hidden" name="type" value="login">
            <input type="hidden" name="usersLogin" value="Guest"><!-- Login: Guest-->
            <input type="hidden" name="usersPassword" value="EBxe9y2NWuAPPLe"><!-- Hasło: zmienić-->
        </form>

    </ul>
</div>