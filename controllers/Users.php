<?php
require_once '../models/User.php';
require_once '../helpers/session.php';

class Users
{
    private $user;

    public function __construct()
    {
        $this->user = new User;
    }

    public function register()
    {

        //Mozna dodac funkcje ktora by usuwała przypadkowe spacje

        $userdata = [
            'usersFirstName' => $_POST['usersFirstName'],
            'usersLastName' => $_POST['usersLastName'],
            'usersLogin' => $_POST['usersLogin'],
            'usersEmail' => $_POST['usersEmail'],
            'usersPassword' => $_POST['usersPassword'],
            'repeatUsersPassword' => $_POST['repeatUsersPassword']
        ];

        $wdf = 0; //flaga na błędy

        //Sprawdzanie czy któreś z pól jest puste
        foreach ($userdata as $key => $item) {
            if (empty($userdata[$key])) {
                echo "Wszystkie pola muszą być wypełnione"; //TODO ładne wyświeltanie
                $wdf = 1;
            }
        }

        if (preg_match('~[0-9]+~', $userdata['usersFirstName'])) {
            echo "Nieprawidłowe imię - imię musi zawierać tylko litery";
            $wdf = 1;
        }

        if (preg_match('~[0-9]+~', $userdata['usersLastName'])) {
            echo "Nieprawidłowe nazwisko - nazwisko musi zawierać tylko litery";
            $wdf = 1;
        }
        //Sprawdzanie czy login zawiera tylko litery i cyfry oraz czy jest dłuższy niż 3 znaki
        if (strlen($userdata['usersLogin']) <= 3) {
            echo "Login musi mieć więcej niż 3 znaki\n"; //TODO ładne wyświetlanie
            $wdf = 1;

        } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $userdata['usersLogin'])) {
            echo "Login może zawierać tylko litery i cyfry\n"; //TODO ładne wyświetlanie
            $wdf = 1;
        }

        //Sprawdzanie czy hasło ma minimum TYMCZASOWO 3 znaki TODO 8
        if (strlen($userdata['usersPassword']) <= 3) {
            echo "Hasło musi mieć więcej niż 8 znaków\n"; //TODO ładne wyświetlanie
            $wdf = 1;
        }

        //Weryfikacja adresu email
        if (!preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/", $userdata['usersEmail'])) {
            echo "Niepoprawny adres e-mail"; //TODO ładne wyświetlanie
            $wdf = 1;
        }


        //Sprawdzanie czy powtórzone hasło jest takie same
        $check_password = strval($userdata['repeatUsersPassword']);
        if (!preg_match("/^" . $check_password . "$/", $userdata['usersPassword'])) {
            echo "Hasla nie są zgodne"; //TODO ładne wyświetlanie
            $wdf = 1;
        }

        //Sprawdzanie czy user juz istnieje
        if ($this->user->checkIfUserExists($userdata['usersLogin'], $userdata['usersEmail'])) {
            echo "User już istnieje";
            $wdf = 1;
        }

        //Zeby wszystkie błędy były wyświetlane, a nie tylko pierwszy napotkany
        if ($wdf == 1){
            exit();
        }

        //Haszowanie hasła
        //https://www.php.net/manual/en/function.password-hash.php
        $userdata['usersPassword'] = password_hash($userdata['usersPassword'], PASSWORD_DEFAULT);

        //Rejestracja usera
        if ($this->user->register($userdata)) {
            $newURL = '../index.php';
            header('Location: ' . $newURL);
        } else {
            exit("Cos chyba poszlo nie tak");
        }
    }

    public function login()
    {
        $userdata = [
            'usersLogin' => $_POST['usersLogin'],
            'usersPassword' => $_POST['usersPassword']
        ];
        //Sprawdzanie czy któreś z pól jest puste
        foreach ($userdata as $key => $item) {
            if (empty($userdata[$key])) {
                echo "Wszystkie pola muszą być wypełnione";
                exit();
            }
        }
        //Sprawdzanie czy user istnieje
        if ($this->user->checkIfUserExists($userdata['usersLogin'], $userdata['usersLogin'])) {
            echo "Użytkownik istnieje\n";
            $logged = $this->user->login($userdata['usersLogin'], $userdata['usersPassword']);
            //var_dump(($logged));
            if ($logged) {
                $this->newSession($logged);
            } else {
                echo "Podano złe hasło";
                //TODO ładnie się ma wyswietlac
                exit();
            }
        } //Jeśli użytkownika nie znaleziono...
        else {
            echo "Nie ma takiego użytkownika";
            //TODO ładnie się ma wyswietlac
            exit();
        }
        echo $_SESSION['usersLogin'];
    }

    public function newSession($user)
    {
        $session_attrs = array(
            'usersId',
            'usersLogin',
            'usersEmail',
        );
        foreach ($session_attrs as $value) {
            $_SESSION[$value] = $user->$value;
        }
        session_start();
        $newURL = '../index.php';
        header('Location: ' . $newURL);
    }

    public function destroySession()
    {
        $session_attrs = array(
            'usersId',
            'usersLogin',
            'usersEmail'
        );
        foreach ($session_attrs as $value) {
            unset($_SESSION[$value]);
        }
        session_destroy();
        $newURL = '../index.php';
        header('Location: ' . $newURL);
    }
}

$user = new Users;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['type'] == 'register')
        $user->register();
    if ($_POST['type'] == 'login')
        $user->login();
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET['type'] == 'logout') {
        $user->destroySession();
    }
}