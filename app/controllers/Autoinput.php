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

class Autoinput extends Controller{
    private $table;
    
    public function __construct(){
        $this->table = 'schedule';
    }

    public function index(){
        $data['title'] = 'Auto input';
        $data['input'] = $this->model('AllModel')->whereGet($this->table, "type='input'");
        $data['reboot'] = $this->model('AllModel')->data($this->table, "type='reboot'");

        $this->view('input_usage',$data);
    }
}


?>