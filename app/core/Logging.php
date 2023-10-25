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

class Logging{
    public static function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'IP tidak dikenali';
        return $ipaddress;
    }
    
    private static function get_client_browser() {
        $browser = '';
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape'))
            $browser = 'Netscape';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
            $browser = 'Firefox';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
            $browser = 'Chrome';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
            $browser = 'Opera';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
            $browser = 'Internet Explorer';
        else
            $browser = 'Other';
        return $browser;
    }
    
    public static function log($action, $status, $message, $user=''){
        $db = new Database;

        $ip_log        = self::get_client_ip();
        $browser_log   = self::get_client_browser();
        $so_log        = addslashes($_SERVER['HTTP_USER_AGENT']);
        $tahun         = date('Y');
        $bulan         = date('m');
        $tanggal       = date('d');
        $time          = DATENOW;
        
        if($action=='visit'){
            $q_log         = $db->query("SELECT * FROM log WHERE ip='$ip_log' AND message='$message' AND YEAR(time)='$tahun' AND MONTH(time)='$bulan' AND DAY(time)='$tanggal'");
            $q_log         = $db->single();
            if($q_log==''){
                $db->query("INSERT INTO log VALUES(null, '$time', '$ip_log', '$browser_log', '$so_log', '$action', '$status', '$message','$user')");
                $db->execute();
            }
        }else{
            $db->query("INSERT INTO log VALUES(null, '$time', '$ip_log', '$browser_log', '$so_log', '$action', '$status', '$message','$user')");
            $db->execute();
        }

        $log         = $db->query("SELECT * FROM log");
        $log         = $db->resultSet();
        $min         = $db->query("SELECT MIN(id_log) AS last FROM log");
        $min         = $db->single();
        $last        = $min->last;
        
        if(count($log)>300){
            $delete         = $db->query("DELETE FROM log WHERE id_log='$last'");
            $delete         = $db->execute();
        }
    }
}

?>