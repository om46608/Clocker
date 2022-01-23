<link rel="stylesheet" href="style.css"/>
<div class="header-div">
    <button class="bar" onclick="window.location.href='index.php';"> Strona główna </button>
    <button class="bar" onclick="window.location.href='?action=about_us';"> O nas </button>
    <button class="bar" onclick="window.location.href='?action=contact';"> Kontakt </button>
    <button class="bar" onclick="window.location.href='?action=faq';"> FAQ </button>

    <?php
    if (isset($_SESSION['usersId'])) {
        include_once __DIR__ . '/get_tasks.php';
        include_once __DIR__ . '/edit_user.php';
    }
    ?>
</div>


