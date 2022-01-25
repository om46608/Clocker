<?php
session_start();
switch (( array_key_exists( 'action', $_REQUEST) ? $_REQUEST['action'] : "" )) {
    case 'login':
        require './login.php';
        break;
    case 'register':
        require './register.php';
        break;
    case 'userpanel':
        require './userpanel.php';
        break;
    case 'adminpanel':
        require './adminpanel.php';
        break;
    case 'about_us':
        require './about_us.php';
        break;
    case 'contact':
        require './contact.php';
        break;
    case 'faq':
        require './faq.php';
        break;
    case 'profile':
        require './profile.php';
        break;
    case 'show_users_page':
        require './show_users_page.php';
        break;
    case 'tasks':
        require './tasks_view.php';
        break;
    case 'edit_task':
        require './edit_task.php';
        break;
    default:
        require './homepage.php';
        break;

}