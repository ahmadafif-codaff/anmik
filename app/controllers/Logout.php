<?php
/* 
    ******************************************
    ANMIK
    Copyright © 2023 Codaff Project

    By :
        Ahmad Afif
        ahmadafif.codaff@gmail.com
        https://github.com/ahmadafif-codaff/anmik

    This program is free software
    You can redistribute it and/or modify
    ******************************************
*/

class Logout extends Controller{
    public function index(){
        $token = $_COOKIE['token'];
        setcookie("token", "", -1, $this->authentication()->path);
        $this->model('LoginModel')->deleteToken("token='$token'");
        header("location:BASEURL/login");
    }
}

?>