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

class Validator{

    private static function db($table, $column, $field){
        $db = new Database;
        $db->query("SELECT * FROM $table WHERE $column='$field'");
        return $db->single();
    }

    public static function validate($data=[], $table=''){
        $data = $data;
        $r=[];
        $rj=[];

        foreach($data as $key=>$val){
            $req = explode('|',explode('=', $val)[1]);
            $input = explode('=', $val)[0];

            if(in_array('required', $req)){
                if($input==''){
                    $r[] = ["validation"=>"is-invalid"];
                    $rj[] = json_encode(["name"=>"$key", "text"=>"kolom $key tidak boleh kosong", "validation"=>"is-invalid"]);
                }else{
                    $r[] = ["validation"=>""];
                    $rj[] = json_encode(["name"=>"$key", "text"=>"", "validation"=>"is-valid"]);
                }
            }

            if(in_array(':', str_split($val))){
                foreach($req as $re){
                    if(in_array(':', str_split($re))){
                        $param = explode(':', $re)[1];
                        $re = explode(':', $re)[0];
                        $count_string  = strlen($input);

                        if($re == 'min'){
                            if($count_string<$param){
                                $r[] = ["validation"=>"is-invalid"];
                                $rj[] = json_encode(["name"=>"$key", "text"=>"masukkan $key minimal $param karakter", "validation"=>"is-invalid"]);
                            }
                        }

                        if($re == 'max'){
                            if($count_string<$param){
                                $r[] = ["validation"=>"is-invalid"];
                                $rj[] = json_encode(["name"=>"$key", "text"=>"masukkan $key maximal $param karakter", "validation"=>"is-invalid"]);
                            }
                        }
                    }
                }
            }

            if(in_array('unique', $req)){
                if(self::db($table, $key, explode('=',$val)[0])!=''){
                    $r[] = ["validation"=>"is-invalid"];
                    $rj[] = json_encode(["name"=>"$key", "text"=>"kolom $key tidak boleh sama", "validation"=>"is-invalid"]);
                }
            }


            if(in_array('unique_api', $req)){
                $r[] = ["validation"=>"is-invalid"];
                $rj[] = json_encode(["name"=>"$key", "text"=>"kolom $key tidak boleh sama", "validation"=>"is-invalid"]);
            }

            if(in_array('valid_ip', $req)){
                $r[] = ["validation"=>"is-invalid"];
                $rj[] = json_encode(["name"=>"$key", "text"=>"masukkan $key yang valid", "validation"=>"is-invalid"]);
            }
        }

        echo implode($rj);

        foreach($r as $a){
            if($a["validation"]=="is-invalid"){
                die;
            }
        }
    }

    public static function password($field, int $min){
        $password_min  = strlen($field) <$min ;
        $uppercase     = preg_match('@[A-Z]@', $field);
        $lowercase     = preg_match('@[a-z]@', $field);
        $numbers        = preg_match('@[0-9]@', $field);

        if($password_min || !$uppercase || !$lowercase || !$numbers){
            echo json_encode(["name"=>"password", "text"=>"masukkan passsword minimal $min karakter dengan kombinasi huruf besar, kecil, dan angka", "validation"=>"is-invalid"]);
            die;
        }
    }
}

?>