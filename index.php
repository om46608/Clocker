<?php
session_start();
switch (( array_key_exists( 'action', $_REQUEST) ? $_REQUEST['action'] : "" )) {
    case 'login':
        require './login.php';
        setTabTitle("Logowanie");
        break;
    case 'register':
        require './register.php';
        setTabTitle("Rejestracja");
        break;
    case 'userpanel':
        require './userpanel.php';
        setTabTitle("Panel użytkownika");
        break;
    case 'adminpanel':
        require './adminpanel.php';
        setTabTitle("Panel Administratora");
        break;
    case 'about_us':
        require './about_us.php';
        setTabTitle("O nas");
        break;
    case 'contact':
        require './contact.php';
        setTabTitle("Kontakt");
        break;
    case 'faq':
        require './faq.php';
        setTabTitle("FAQ");
        break;
    case 'profile':
        require './profile.php';
        setTabTitle("Profil użytkownika");
        break;
    case 'show_users_page':
        require './show_users_page.php';
        setTabTitle("Pokaż użytkowników");
        break;
    case 'tasks':
        require './tasks_view.php';
        setTabTitle("Lista zadań");
        break;
    case 'edit_task':
        require './edit_task.php';
        setTabTitle("Edycja taska");
        break;
    case 'guest':
        require './time_tracker.php';
        setTabTitle("Sekcja Gościa");
        break;
    default:
        require './homepage.php';
        break;

}

function setTabTitle($tabTitle) {
    echo("<title>$tabTitle</title>");
}