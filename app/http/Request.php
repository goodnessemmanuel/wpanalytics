<?php


namespace App\http;


class Request
{
    public function param($key)
    {
        return $_POST[$key]??$_GET[$key]??'';
    }
}