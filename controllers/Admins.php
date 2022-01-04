<?php
require_once '../helpers/session.php';
require_once '../helpers/View.php';
require_once '../models/Admin.php';
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



        $this->view('show_users_page',$rows);





    }
    public function deleteUser(){

        $user_id = $_POST['user_delete'];
        $this->admin->deleteUser($user_id);

    }
    public function searchUser(){
        $user_search_input=$_POST['userSearchInput'];

        //$newURL = '../adminpanel.php';
        //header('Location: ' . $newURL);

        //$this->view('header_admin');
        //$this->view('adminpanel');



        echo $user_search_input;
        $rows = $this->admin->showSpecificUser($user_search_input);
        print $rows;
        $_POST['output']=$rows;

        //nowe url to adminpanel ale gdzies powinna byc przechowywana wartosc zwrocona ? moze
        // wyswietlic wartosc zrocona wczesniej


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

