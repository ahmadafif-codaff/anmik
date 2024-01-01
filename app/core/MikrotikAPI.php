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

class MikrotikAPI{
   private static function source($src){
      if($src == 'simple'){
         $src = '/queue/simple';
      }
      if($src == 'firewall'){
         $src = '/ip/firewall/filter';
      }
      if($src == 'address'){
         $src = '/ip/address';
      }
      if($src == 'dhcp'){
         $src = '/ip/dhcp-server/lease';
      }
      if($src == 'pool'){
         $src = '/ip/dhcp-server';
      }
      if($src == 'resource'){
         $src = '/system/resource';
      }
      return $src;
   }

   private static function target($id, $target, $target_value){
      if($target=='limit'){
         $target =[
         ".id" => "$id",
         "limit-at" => "$target_value",
         "max-limit" => "$target_value",];
      }
      if($target=='disabled'){
         $target = [".id" => "$id",
         "disabled" => "$target_value"];
      }
      if($target=='comment'){
         $target = [".id" => "$id",
         "comment" => "$target_value"];
      }
      return $target;
   }

   public static function get($src, $target, $target_value, $column=''){
      $API = new RouterosAPI();
      if($API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
      
         $query = $API->comm(self::source($src).'/print', array(
            "?$target" => "$target_value",
         ));
         $data = [];
         foreach($query as $r){
            if($column!=''){
               $data[] = $r[$column];
            }else{
               $data[] = $r;
            }
         }
         if($column!=''){
            return implode($data);
         }else{
            return $data;
         }
      }
      $API -> disconnect();
   }

   public static function all($src){
      $API = new RouterosAPI();
      if($API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
      
         $query = $API->comm(self::source($src).'/print');

         $ra = [];
         foreach($query as $r){
            $ra[] = $r;
         }
         return $ra;
      }
      $API -> disconnect();
   }

   public static function remove($src, $id){
      $API = new RouterosAPI();
      if($API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
         $API->comm(self::source($src).'/remove', array(
            ".id" => "$id",
         ));
      }
      $API -> disconnect();
   }

   public static function set($src, $set=[]){
      $API = new RouterosAPI();
      if($API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
         $API->comm(self::source($src).'/set', $set);
      }
      $API -> disconnect();
   }

   public static function single_set($src, $id, $target, $target_value){
      $API = new RouterosAPI();
      if($API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
         $API->comm(self::source($src).'/set', self::target($id, $target, $target_value));
      }
      $API -> disconnect();
   }

   public static function reset_simple($id){
      $API = new RouterosAPI();
      if($API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
         $API->comm('/queue/simple/reset-counters', [".id" => "$id"]);
      }
      $API -> disconnect();
   }

   public static function reboot(){
      $API = new RouterosAPI();
      if($API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
         $API->comm('/system/reboot');
      }
      $API -> disconnect();
   }
    
}

?>