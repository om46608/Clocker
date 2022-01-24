<?php
require_once __DIR__ . '/../libraries/Database.php';
require_once __DIR__ . '/../config/config.php';

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

    public function register($userdata): bool
    {
        $this->database->query('INSERT INTO users (usersFirstName, usersLastName, usersLogin, usersEmail, usersPassword) 
                                VALUES (:usersfirstname, :userslastname, :userslogin, :usersemail, :userspassword)');
        $this->database->bind(':usersfirstname', $userdata->getUsersFirstName());
        $this->database->bind(':userslastname', $userdata->getUsersLastName());
        $this->database->bind(':userslogin', $userdata->getUsersLogin());
        $this->database->bind(':usersemail', $userdata->getUsersEmail());
        $this->database->bind(':userspassword', $userdata->getUsersPassword());

        if ($this->database->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update($userdata, $usersId): bool
    {
        $this->database->query('UPDATE users SET usersFirstName = :usersfirstname, usersLastName = :userslastname, usersLogin = :userslogin, usersEmail = :usersemail, usersPassword = :userspassword
        WHERE usersId = :usersid');
        $this->database->bind(':usersfirstname', $userdata->getUsersFirstName());
        $this->database->bind(':userslastname', $userdata->getUsersLastName());
        $this->database->bind(':userslogin', $userdata->getUsersLogin());
        $this->database->bind(':usersemail', $userdata->getUsersEmail());
        $this->database->bind(':userspassword', $userdata->getUsersPassword());
        $this->database->bind(':usersid', $usersId);

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

    public function deleteUser($userId){
        $this->database->query('DELETE FROM users WHERE usersId = :userId');
        $this->database->bind(':userId',$userId);


        if($this->database->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public function getUserData($userId){
        $this->database->query('SELECT * FROM users WHERE usersId = '.$userId);
        $this->database->execute();
        return $this->database->getOneResult();
    }
    public function countAllUsers(){
        $this->database->query('SELECT COUNT(usersId) FROM users');
        $this->database->execute();
        return $this->database->getAllResults();
    }

}