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

class Flasher{
    public static function message($type, $title, $action, $text){
       echo json_encode(["type"=>$type, "title"=>$title, "text"=>"Data $text di$action"]);
    }

    public static function success($action, $table){
        echo json_encode(["type"=>"success", "title"=>"Berhasil", "text"=>"Data $table berhasil di$action"]);
   }

   public static function error($action, $table){
      echo json_encode(["type"=>"error", "title"=>"Gagal", "text"=>"Data $table gagal di$action"]);
   }
    
}

?>