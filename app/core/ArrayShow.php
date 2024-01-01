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
    private static function order($array=[], $order_by, $sort){
        $array1 = [];
        foreach($array as $as){
            $array1[] = ['order'=>$as[$order_by],'data'=>$as];
        }

        $array_sort = asort($array1);

        if(strtolower($sort)=='desc'){
            $array_sort = arsort($array1);
        }
        
        $array_sort = json_decode(json_encode($array1));

        $array2 = [];
        foreach($array_sort as $as){
            $array2[] = ['order'=>$as->order,'data'=>$as->data];
        }

        return $array2;
    }

    public static function all($array=[], $order_by, $sort, $output='array'){
        $show = Filter::request(30,'row');
        $start = Filter::page(0, $show);
        $array2 = self::order($array, $order_by, $sort);

        $array_show = []; 
        for($x=$start;$x<$show*Filter::request(1,'page');$x++){
            if($x<count($array2)){
                $array_show[] = $array2[$x];
            }
        }

        $page = $array;
        $data = $array_show;
        $page = ceil(count($page)/$show);
        
        if($output=='json'){
            $data = json_decode(json_encode($array_show));
        }

        $output = [$data, $page, $start];

        return $output;
    }

    public static function search($array=[], $column, $order_by, $sort='asc', $output='array'){
        $keyword = strtolower(Filter::request('', 'search'));
        
        if($keyword==''){
            $array_show = self::all($array, $order_by, $sort, $output);
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
            $array_show = self::all($array_search, $order_by, $sort, $output);
        }

        return $array_show;
    }
}

?>