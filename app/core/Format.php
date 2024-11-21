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

class Format{
    private static function type($type){
        if($type=='byte'){
            $format = 'B';
        }
        if($type=='rate'){
            $format = 'bps';
        }
        return $format;
    }

    public static function bytes($number, $type='byte'){
        $perfect = 1000000;

        $data = $number/$perfect;
        $type = self::type($type);
        $format = ' M'.$type;

        if($data<1){
            $data *= 1000;
            $format = ' K'.$type;
        }

        if($data>=1000000){
            $data /=1000000;
            $format = ' T'.$type;
        }

        if($data>=1000){
            $data /=1000;
            $format = ' G'.$type;
        }

        if(in_array('.', str_split($data))){
            $data = explode('.',$data);
            $data = $data[0].'.'.substr($data[1],0,2).$format;
        }else{
            $data .= $format;
        }
        
        return $data;
    }

    private static function count_time_rule($time,$position,$type='second'){
        if($type=='second' || $type=='minute'){
            $range = 60;
            $perfect = 1.67;
        }
        if($type=='hour'){
            $range = 24;
            $perfect = 4.27;
        }
        
        if($position =='first'){
            $data = explode('.',$time/$range)[0];
            if($data<10){
                $data = '0'.$data;
            }
        }

        if($position == 'last'){
            $data = substr(explode('.',$time/$range)[1],0,2);
            if(strlen($data)<1){
                $data .= '00';
            }
            if(strlen($data)<2){
                $data .= '0';
            }
            $data /=$perfect;
            $data = ceil($data);
            if($data<10){
                $data = '0'.$data;
            }
        }

        return $data;
    }

    public static function count_time($time, $count='up', $view='hour'){
        $session = (time()-$time);

        if($count=='down'){
            $session = ($time-time());
        }

        $day = '00';
        $hour = '00';
        $minute = '00';
        $second = $session;

        if($session<10){
            $second = '0'.$second;
            if($session<0){
                $second ='00';
            }
        }

        if($session>=60){
            $second = self::count_time_rule($session, 'last');
            $minute = self::count_time_rule($session, 'first');

            if($minute>=60){
                $hour = self::count_time_rule($minute, 'first');
                $minute = self::count_time_rule($minute, 'last');

                if($hour>=24){
                    $day = self::count_time_rule($hour, 'first', 'hour');
                    $hour = self::count_time_rule($hour, 'last', 'hour');
                }
            }
        }

        if($view=='day'){
            return $day.' '.$hour.':'.$minute.':'.$second;
        }

        if($view=='hour'){
            return $hour.':'.$minute.':'.$second;
        }

        if($view=='minute'){
            return $minute.':'.$second;
        }
        
    }
    
    public static function addr_num($addr){
        $address = explode('/', $addr)[0];
        $prefix = explode('/', $addr)[1];
        $addr_exp = explode('.', $address);
        
        $data = self::add_null($addr_exp[0]).self::add_null($addr_exp[1]).self::add_null($addr_exp[2]).self::add_null($addr_exp[3]);
        if($prefix!=''){
            $data .= self::add_null($prefix, 'pref');
        }
        return $data;
    }

    private static function add_null($numb, $type='addr'){
        $null = [];
        $i = 3;
        if($type=='pref'){
            $i = 2;
        }
        for($x=0; $x<$i-count(str_split($numb)); $x++){
            $null[] = '0';
        }
        return implode($null).$numb;
    }
    
    public static function currency($number, $code="IDR", $decimal=0, $dec_point=',', $thousands_sep='.'){
        $data = '';
        if(strtoupper($code)=='IDR'){
            $data = 'Rp. ';
        }
        $data .= number_format($number, $decimal, $dec_point, $thousands_sep);
        return $data;
    }
}

?>