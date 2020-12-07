<?php


namespace App\controllers;


use App\http\Request;

abstract class BaseController
{
    protected Request $request;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {

        $this->request = new Request();
    }

    public function loadView($name, $data = [])
    {
        //ob_start();
        extract($data);
        require_once (VIEW_PATH . $name . '.php');
        //$content = ob_get_contents();
        //ob_clean();
        //echo $content;
    }

    public function redirect($to)
    {
        header("Location: " . $to);
    }
}