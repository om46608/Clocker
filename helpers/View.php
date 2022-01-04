<?php

class View
{
    protected $_data = array();


    public function __construct()
    {

    }

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
}