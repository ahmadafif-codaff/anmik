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

class Pengaturan extends Controller{
    private $table;
    private $user;

    public function __construct()
    {
        $this->authentication()->auth();
        $this->table = 'user';
        $this->user = $this->model('SessionModel')->user();
    }

    public function index(){

        $data['title'] = "Settings";
        $data['user'] = $this->model('SessionModel')->user();

        $this->view('account/layouts/header', $data);
        $this->view('account/pengaturan', $data);
        $this->view('account/layouts/footer');
    }

    public function profil(){
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $data = $this->model('SessionModel')->user();
        $id = $data->id_user;

        $rules = [
            "nama"=>"$nama=required",
            "username"=>"$username=required",
        ];

        if($username!=$data->username){
            $rules['username'] = "$username=required|unique";
        }

        Validator::validate($rules, $this->table);

        if($this->model('AllModel')->update($this->table, "nama='$nama', username='$username'", "id_$this->table='$id'")>0){
            $edit = "";
            if($nama!=$data->nama||$username!=$data->username){
                $edit = "menjadi ";
            }
            if($nama!=$data->nama){
                $edit .= "nama <i>$nama</i> ";
            }
            if($username!=$data->kategori){
                $edit .= "username <i>$username</i>";
            }
            Logging::log('edit_profil', 1, "Profil <i>$data->nama</i> username <i>$data->username</i> diubah $edit", $this->user->username);
            Flasher::success('ubah', $this->table);
        }else{
            Logging::log('edit_profil', 0, "Profil <i>$data->nama</i> username <i>$data->username</i> gagal diubah", $this->user->username);
            Flasher::error('ubah', $this->table);
        }
    }

    public function password(){
        $password = $_POST['password'];
        
        $data = $this->model('SessionModel')->user();
        $id = $data->id_user;

        Validator::validate(["password"=>"$password=required"]);

        Validator::password($password, 8);

        $password = password_hash($password, PASSWORD_DEFAULT) ;

        if($this->model('AllModel')->update($this->table, "password='$password'", "id_$this->table='$id'")>0){
            Logging::log('edit_password', 1, "Password <i>$data->nama</i> username <i>$data->username</i> diubah", $this->user->username);
            Flasher::success('ubah', $this->table);
        }else{
            Logging::log('edit_password', 0, "Password <i>$data->nama</i> username <i>$data->username</i> gagal diubah", $this->user->username);
            Flasher::error('ubah', $this->table);
        }
    }
}

?>