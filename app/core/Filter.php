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

class Filter{
    public static function request($value, $param){
        $data = $value;
        if(in_array('?', str_split($_SERVER['REQUEST_URI']))){
            if(explode('=',explode('?',$_SERVER['REQUEST_URI'])[1])[0]==$param){
                if(in_array('&', str_split($_SERVER['REQUEST_URI']))){
                    $data = explode('&', explode('=',explode('?',$_SERVER['REQUEST_URI'])[1])[1])[0];
                }else{
                    $data = explode('=',explode('?',$_SERVER['REQUEST_URI'])[1])[1];
                }
            }
            if(in_array('&', str_split($_SERVER['REQUEST_URI']))){
                if(explode('=',explode('&',explode('?',$_SERVER['REQUEST_URI'])[1])[1])[0]==$param){
                    $data = explode('=',explode('&',explode('?',$_SERVER['REQUEST_URI'])[1])[1])[1];
                }
                for($i=1; $i<=10; $i++){
                    if(array_count_values(str_split($_SERVER['REQUEST_URI']))['&']>$i){
                        if(explode('=',explode('&',explode('?',$_SERVER['REQUEST_URI'])[1])[$i+1])[0]==$param){
                            $data = explode('=',explode('&',explode('?',$_SERVER['REQUEST_URI'])[1])[$i+1])[1];
                        }
                    }
                }
            }
        }

        $data = implode(' ',explode('%20', $data));

        $int ='@[0-9]@';
        $string ='@[a-z]@';
        $char ='/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';

        if($param=='row'){
            if(!preg_match($int, $data)||preg_match($string, $data)||preg_match($char, $data)||$data<1){
                $data = 30;
            }
            if($data>500){
                $data = 500;
            }
        }

        if($param=='page'){
            if(!preg_match($int, $data)||preg_match($string, $data)||preg_match($char, $data)||$data<1){
                $data = 1;
            }
        }

        if($param=='date'){
            if($data =='' || !in_array('-', str_split($data))){
                $data = date('Y').'-'.date('m').'-'.date('d');
            }
            if(!preg_match($int, explode('-',$data)[0])||preg_match($string, explode('-',$data)[0])){
                $data = date('Y').'-'.explode('-', $data)[1].'-'.explode('-', $data)[2];
            }
            if(!preg_match($int, explode('-',$data)[1])||preg_match($string, explode('-',$data)[1])||explode('-', $data)[1]>12){
                $data = explode('-', $data)[0].'-'.date('m').'-'.explode('-', $data)[2];
            }
            if(!preg_match($int, explode('-',$data)[2])||preg_match($string, explode('-',$data)[2])||explode('-', $data)[2]>31){
                $data = explode('-', $data)[0].'-'.explode('-', $data)[1].'-'.date('d');
            }
        }


        if($param=='address'){
            if($data ==''){
                $data = MikrotikAPI::get('simple', 'parent', 'none', 'target');
            }
            elseif(in_array('%',str_split($data))){
                $data = implode('/', explode('%2F', $data));
                $data = implode(',', explode('%2C', $data));
            }
            else{
                $data = MikrotikAPI::get('simple', 'target', $data, 'target');
            }
        }

        return $data;

    }
    public static function page($value, $show){
        $data = $value;

        $int ='@[1-9]@';
        $string ='@[a-z]@';
        $char ='/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';

        if(in_array('?', str_split($_SERVER['REQUEST_URI']))){
            if(explode('=',explode('?',$_SERVER['REQUEST_URI'])[1])[0]=='page'){
                if(in_array('&', str_split($_SERVER['REQUEST_URI']))){
                    $page = explode('&', explode('=',explode('?',$_SERVER['REQUEST_URI'])[1])[1])[0];
                    if(!preg_match($int, $page)||preg_match($string, $page)||preg_match($char, $page)){$page = 1;}
                    $data = ($page*$show)-$show;
            }else{
                    $page = explode('=',explode('?',$_SERVER['REQUEST_URI'])[1])[1];
                    if(!preg_match($int, $page)||preg_match($string, $page)||preg_match($char, $page)){$page = 1;}
                    $data = ($page*$show)-$show;
                }
            }
            if(in_array('&', str_split($_SERVER['REQUEST_URI']))){
                if(explode('=',explode('&',explode('?',$_SERVER['REQUEST_URI'])[1])[1])[0]=='page'){
                    $page = explode('=',explode('&',explode('?',$_SERVER['REQUEST_URI'])[1])[1])[1];
                    if(!preg_match($int, $page)||preg_match($string, $page)||preg_match($char, $page)){$page = 1;}
                    $data = ($page*$show)-$show;
                }
                for($i=1; $i<=10; $i++){
                    if(array_count_values(str_split($_SERVER['REQUEST_URI']))['&']>$i){
                        if(explode('=',explode('&',explode('?',$_SERVER['REQUEST_URI'])[1])[$i+1])[0]=='page'){
                            $page = explode('=',explode('&',explode('?',$_SERVER['REQUEST_URI'])[1])[$i+1])[1];
                        if(!preg_match($int, $page)||preg_match($string, $page)||preg_match($char, $page)){$page = 1;}
                        $data = ($page*$show)-$show;
                        }
                    }
                }
            }
        }
        
        return $data;

    }
}


?>