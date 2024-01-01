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

class Reboot extends Controller{
    private $user;
    public function __construct(){
        $this->authentication()->auth();
        $this->user = $this->model('SessionModel')->user();
    }
    public function index(){
        Logging::log('reboot_mikrotik', 1, "Perangkat dimulai ulang dari web ANMIK", $this->user->username);
        MikrotikAPI::reboot();
    }
}


?>