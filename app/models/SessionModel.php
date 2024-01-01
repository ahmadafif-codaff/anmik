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

class SessionModel extends Models{
    public function token(){
        $token = $_COOKIE['token'];
        $this->where('login', "token='$token'");
        return $this->get();
    }

    public function user(){
        $username = $this->token()->username;
        $this->where('user', "username='$username'");
        return $this->get();
    }
}

?>