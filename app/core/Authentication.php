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

class Authentication{
    protected $db;
    protected $modified;
    protected $session;
    protected $ip;
    protected $os;
    public $path;

    public function __construct()
    {
        $this->db = new Database;
        $this->modified = DATENOW;
        $this->session = SESSION;
        $this->ip = IP;
        $this->os = OS;
        // $this->path = '/';
        $this->path = BASEURL;
    }

    public function auth(){
        if(isset($_COOKIE['token'])){
            $this->db->query("SELECT * FROM login WHERE token=:token");
            $this->db->bind('token', $_COOKIE['token']);
            $data = $this->db->single();
            
            if($data->session>time()){
                $this->db->query("UPDATE login SET modified_at=:modified_at, session=:session, ip=:ip, os=:os WHERE token=:token");
                $this->db->bind('modified_at', $this->modified);
                $this->db->bind('session', $this->session);
                $this->db->bind('ip', $this->ip);
                $this->db->bind('os', $this->os);
                $this->db->bind('token', $_COOKIE['token']);
                $this->db->execute();

                setcookie("token", $_COOKIE['token'], $this->session, $this->path);
            }else{
                setcookie("token", "", -1, $this->path);
                // header("location:".BASEURL."/login");
                echo '<script>window.location.href="'.BASEURL.'/login"</script>';
                die;
            }
        }else{
            header("location:".BASEURL."/login");
            die;
        }
    }

    public function guest(){
        if(isset($_COOKIE['token'])){
            $this->db->query("SELECT * FROM login WHERE token=:token");
            $this->db->bind('token', $_COOKIE['token']);
            $data = $this->db->single();
            
            if($data>0){
                if($data->session>time()){
                    header("location:".BASEURL."/dashboard");
                }
            }else{
                setcookie("token", "", -1, $this->path);
            }
        }
    }
}

?>