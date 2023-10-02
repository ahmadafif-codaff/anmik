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

class Controller{
    public function view($view, $data = []){
        require_once 'app/views/'.$view.'.php';
    }
    
    public function model($model){
        require_once 'app/models/'.$model.'.php';
        return new $model;
    }

    public function authentication(){
        return new Authentication;
    }
}

?>