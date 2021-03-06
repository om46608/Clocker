<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/View.php';
require_once __DIR__ . '/../models/Admin.php';
class Admins
{
    private $admin;

    public function __construct(){
        $this->admin = new Admin;

    }


    // dodac do controllers/Controller.php i dziedziczenie Admins po tym
    public function view($view , $data = array())
    {
        if (file_exists('../' . $view . '.php'))
        {

            require '../' . $view . '.php';
        }
        /*
        if(count($data)){
            extract($data);
        }
        */
    }

    public function showAllUsers(){

        $rows = $this->admin->showAllUsers();



        //$this->view('show_users_page',$rows);
        $newURL = '../index.php?action=show_users_page';
        header('Location:' . $newURL);





    }
    public function deleteUser(){

        $user_id = $_POST['user_delete'];
        $this->admin->deleteUser($user_id);

    }
    public function searchUser(){
        $user_search_input=$_POST['userSearchInput'];

        $this->view('header_admin');


        //echo $user_search_input;
        $rows = $this->admin->showSpecificUser($user_search_input);
        //print $rows;
        $_POST['output']=$rows;
        $this->view('adminpanel',$rows);



    }


}

$admins = new Admins;


if ($_SERVER['REQUEST_METHOD']=='POST'){
    if($_POST['type']=='showAllUsers'){
       $admins->showAllUsers();

    }
    if($_POST['type']=='delete'){
        $admins->deleteUser();
        $admins->showAllUsers();

    }

    if($_POST['type']=='showSpecificUser'){
        $admins->searchUser();

    }

}

if($_SERVER['REQUEST_METHOD']=='GET'){
    if($_GET['type']=='showSpecificUser'){
        $admins->searchUser();
    }
}

