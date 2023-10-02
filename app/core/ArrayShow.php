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

class ArrayShow{
    public static function search($array=[], $column, $output='array'){
        $show = Filter::request(30,'row');
        $start = Filter::page(0, $show);
        $keyword = strtolower(Filter::request('', 'search'));

        if($keyword==''){
            $array_show = []; 
            for($x=$start;$x<$show*Filter::request(1,'page');$x++){
                if($x<count($array)){
                    $array_show[] = $array[$x];
                }
            }
            $page = $array;
        }else{
            $array_search = [];
            foreach($array as $key => $r){
                $value = str_split(strtolower($r[$column]));
            
                $result = [];
                for($x=0; $x<strlen($keyword); $x++){
                    $result[] = $value[$x];
                }
                $result = [$key=>implode($result)];
                $search= array_search($keyword,$result);
                if(is_int($search)){
                    $array_search[]=$array[$search];
                }
            };
            $array_show = [];
            for($x=$start;$x<$show*Filter::request(1,'page');$x++){
                if($x<count($array_search)){
                    $array_show[] = $array_search[$x];
                }
            }
            $data = $array_show;
            $page = $array_search;
        }
                    
        $data = $array_show;
        $page = ceil(count($page)/$show);
        
        if($output=='json'){
            $data = json_decode(json_encode($array_show));
        }
        $output = [$data, $page, $start];

        return $output;
    }
}

?>