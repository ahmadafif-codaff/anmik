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

class Login extends Controller{
    
    public function __construct()
    {
        $this->authentication()->guest();
    }

    public function index(){
        $data['title'] = 'Login -';

        $this->view('layouts/header', $data);
        $this->view('login');
        $this->view('layouts/footer');
    }
    
    public function proses(){
        // if(isset($_POST['login'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $data = $this->model('LoginModel')->login($username);
            if($data>0 && password_verify($password, $data->password)){
                $session = SESSION;
                $created_at = DATENOW;
                $ip = IP;
                $os = OS;
                $token = str_shuffle(SHA);

                $this->model('LoginModel')->loginToken("null, '$created_at', '$created_at', '$session', '$ip', '$os', '$username', '$token'");
                $this->model('LoginModel')->deleteToken("token!='$token' AND username='$username'");

                setcookie("token", $token, $session, $this->authentication()->path);

                Logging::log('login', 1, "User <i>$username</i> berhasil login", "guest");
            // header("location:".BASEURL."/account/dashboard");
                echo "success";
            }else{
                Logging::log('login', 0, "User <i>$username</i> gagal login", "guest");
                // header("location:".BASEURL."/login/gagal");
            }

        // }
    }
}

?>