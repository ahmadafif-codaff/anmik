<?php
/* 
    ******************************************
    ANMIK
    Copyright © 2023 Codaff Project

    By :
        Ahmaf Afif
        ahmadafif.codaff@gmail.com
        https://github.com/ahmadafif-codaff/anmik

    This program is free software
    You can redistribute it and/or modify
    ******************************************
*/

class App{ 
    protected $controller = 'Login';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();

        // berlaku di linux server
        $url[0] = ucwords($url[0]);

        // controller

        if(file_exists('app/controllers/' . $url[0] . '.php')){
            $this->controller = $url[0];
            unset($url[0]);
        };

        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // method

        if(isset($url[1])){
            if(method_exists($this->controller, $url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // param

        if(!empty($url)){
            $this->params = array_values($url);
        }
        // var_dump(ucwords($url[0]));

        // jalankan controler & method, serta kirim kan param jika ada

        call_user_func_array([$this->controller, $this->method], $this->params);

    }
    public function parseURL()
    {
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}

?>