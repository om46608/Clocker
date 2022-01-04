<?php
 require_once '../libraries/Database.php';

class Admin
{
    private $database;

    public function __construct(){
        $this->database = new Database;
    }

    //pokaz wszystkich oprocz admina / mozna dodac kolumne dla typu uzytkownika (U-user,A-admin) moze byc wiecej niz jeden admin
    public function showAllUsers(){
        $this->database->query('SELECT * FROM users WHERE usersLogin != "admin"' );

        $rows=$this->database->getAllResults();
        if($this->database->rowCount()>0){

            return $rows;
        }
        else{
            return false;
        }

    }


    //zrobic zeby nie mogl szukac admina/ szukanie po loginie lub emailu
    public function showSpecificUser($userSearchInput){
        $this->database->query('SELECT usersId, usersLogin, usersEmail, usersPassword FROM users WHERE usersLogin = :userSearchInput OR usersEmail = :userSearchInput');
        $this->database->bind(':userSearchInput', $userSearchInput);

        $rows=$this->database->getAllResults();
        if($this->database->rowCount()>0){
            return $rows;
        }
        else{
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




}