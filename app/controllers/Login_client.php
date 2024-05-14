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

class Login_client extends Controller{
    public function index(){
        session_start();
        if(isset($_SESSION['address'])){
            echo '<script>window.location.href="'.BASEURL.'/dashboard_client"</script>';
            // echo 'bad';
        }
        $data['title'] = 'Login Client -';

        $this->view('client/layouts_login/header', $data);
        $this->view('client/login');
        $this->view('client/layouts_login/footer');
    }
    
    public function proses(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(count(MikrotikAPI::get('simple', 'target', $password))>0){
            if(MikrotikAPI::get('simple', 'name', $username, 'target')==$password){
                session_start();
                $_SESSION['username']=$username;
                $_SESSION['address']=$password;
                echo 'success';
                Logging::log('login_client', 1, "User <i>$username</i> berhasil login", "guest");
            }else{
                echo 'error_name';
                Logging::log('login_client', 0, "User <i>$username</i> gagal login", "guest");
            }
        }else{
            echo 'error_add';
            Logging::log('login_client', 0, "User <i>$username</i> gagal login", "guest");
        }
    }
}

?>