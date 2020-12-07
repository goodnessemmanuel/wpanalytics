<?php

use App\Router;

/**
 * Use this php file to register any route you want to use in this app.
 * Checkout the Router class for implementation. The __callStatic in the
 * Router class  is able handle static method that have not been created
 */

Router::get("/", "HomeController@index");
Router::get("auth/login", "AuthController@login");
Router::post("auth/login", "AuthController@store");
Router::post("auth/reg", "AuthController@reg");
Router::post("auth/logout", "AuthController@logout");