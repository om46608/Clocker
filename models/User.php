<?php
require_once '../libraries/Database.php';

class User
{
    private $database;

    public function __construct()
    {
        $this->database = new Database;
    }

    public function checkIfUserExists($usersLogin, $usersEmail)
    {
        $this->database->query('SELECT usersId, usersLogin, usersEmail, usersPassword FROM users WHERE usersLogin = :usersLogin OR usersEmail = :usersEmail');
        $this->database->bind(':usersLogin', $usersLogin);
        $this->database->bind(':usersEmail', $usersEmail);

        $row = $this->database->getOneResult();
        if ($this->database->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function register($userdata)
    {
        $this->database->query('INSERT INTO users (usersFirstName, usersLastName, usersLogin, usersEmail, usersPassword) 
                                VALUES (:usersfirstname, :userslastname, :userslogin, :usersemail, :userspassword)');
        $this->database->bind(':usersfirstname', $userdata['usersFirstName']);
        $this->database->bind(':userslastname', $userdata['usersLastName']);
        $this->database->bind(':userslogin', $userdata['usersLogin']);
        $this->database->bind(':usersemail', $userdata['usersEmail']);
        $this->database->bind(':userspassword', $userdata['usersPassword']);

        if ($this->database->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($usersLogin, $passwd)
    {
        $row = $this->checkIfUserExists($usersLogin, $usersLogin);
        //var_dump(get_object_vars($row));
        if ($row == false) {
            return false;
        }

        //Zaszyfrowane hasło
        $hpasswd = $row->usersPassword;

        //Sprawdzanie czy podane hasło zgadza się z tym zaszyfrowanym
        if (password_verify($passwd, $hpasswd)) {

            return $row;
        } else {
            return false;
        }
    }
}