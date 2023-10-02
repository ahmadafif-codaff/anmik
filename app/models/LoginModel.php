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

class LoginModel extends Models {
    private $table = "user";

    public function login($data){
        $this->where($this->table, "username='$data'");
        return $this->get();
    }
    
    public function loginToken($data){
        return $this->insert('login', $data);
    }
    
    public function deleteToken($data){
        return $this->delete('login', $data);
    }
    
}

?>