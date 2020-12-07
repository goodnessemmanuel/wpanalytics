<?php


namespace App\controllers;

use App\http\Request;
use App\Router;

/**
 * Class AuthController
 * @package App\Controllers
 */

class AuthController extends BaseController
{
    public function login(){
        $this->loadView('login', ["parseVariable"=> "James"]);
    }

    public function store()
    {
        //print_r($_POST);
        $email = $this->request->param("email");
        $password = $this->request->param("password");
        var_dump($email);
        echo "<br/>";
        var_dump($password);

        $this->redirect("/");

    }

}