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

class Menu{
    public static function search($row='no', $load='', $input_by=[]){
        $search = Filter::request('','search');
        $rows = Filter::request(30,'row');
        $form = 'form';
        $keyup = '';
        $rounded_end ='';
        $button = '<button type="submit" class="btn btn-sm btn-primary bi bi-search rounded rounded-end-5"></button>';
        if($load == 'load'){
            $form = 'div';
            $keyup = ' onkeyup="load_data() "';
            $rounded_end = ' rounded-end-5 ';
            $button = '';
        }
        if(count($input_by)>0){
            $rounded_end = '';
            $by = [];
            foreach($input_by as $r){
                $by[] = '<option value="'.$r.'">Search by '.$r.'</option>';
            }
            $option = implode($by);
        }
        $data ='<'.$form.' autocomplete="off" class="input-group rounded-5"><input type="text" class="form-control rounded rounded-start-5 '.$rounded_end.'" '.$keyup.' id="search" name="search" value="'.$search.'" style="height: 35px" placeholder="keywords">';
        if($row=='yes'){
            $data .= '<input type="hidden" name="row" value="'.$rows.'">';
        }
        if(count($input_by)>0){
            $data .= '
            <select name="search_by" id="search_by" class="btn btn-sm btn-primary text-start" onchange="load_data()">'.
                // '<option value="'.$input_by[0].'">Search by ('.$input_by[0].')</option>'.
                $option.
            '</select>';
        }
        $data .= $button.'</'.$form.'>';

        return $data;
        
    }
    public static function row($load=''){
        $search = Filter::request('','search');
        $rows = Filter::request(30,'row');
        $form = 'form';
        $onchange = 'this.form.submit()';
        $select = '<option selected>Number of rows '.$rows.'</option>';
        $text_option = '';
        
        if($load=='load'){
            $form = 'div';
            $onchange = 'load_data()';
            $select = '';
            $text_option = 'Number of rows ';
        }

        $data = '<'.$form.' class="form-group bg-secondary rounded text-light me-1 mb-3 ps-2 d-flex align-items-center" action="" style="width: fit-content; height:fit-content;">
                <span class="bi bi-eye"></span> <select class="btn btn-sm btn-secondary text-start" name="row" id="row" onchange="'.$onchange.'">';
                
        $data .= $select.'
                <option value="30">'.$text_option.'30</option>
                <option value="50">'.$text_option.'50</option>
                <option value="100">'.$text_option.'100</option>
            </select>';
        if($search!=''){
            $data .= '<input type="hidden" name="search" value="'.$search.'">';
        }
        $data .= '</'.$form.'>';

        return $data;
               
    }
    public static function sort($load='', $sort_by=[], $default_sort='ASC'){
        $search = Filter::request('','search');
        $rows = Filter::request(30,'row');
        $sort = Filter::request('','sort_by');
        $form = 'form';
        $onchange = 'this.form.submit()';
        $select = '<option selected>Sort By '.explode('|', $sort)[0].' ('.explode('|', $sort)[1].')</option>';

        $sort_st = 'ASC';
        $sort_nd = 'DESC';
        
        if($load=='load'){
            $form = 'div';
            $onchange = 'load_data()';
            $select = '';
        }

        if($default_sort=='DESC'){
            $sort_st = 'DESC';
            $sort_nd = 'ASC';
        }

        if(count($sort_by)>0){
            $by = [];
            foreach($sort_by as $r){
                $by[] = '<option value="'.$r.'|'.$sort_st.'">Sort by '.$r.' ('.$sort_st.')</option><option value="'.$r.'|'.$sort_nd.'">Sort by '.$r.' ('.$sort_nd.')</option>';
            }
            $option = implode($by);
        }

        $data = '<'.$form.' class="form-group bg-secondary rounded text-light me-1 mb-3 ps-2 d-flex align-items-center" action="" style="width: fit-content; height:fit-content;">
                <span class="bi bi-sort-down"></span> <select class="btn btn-sm btn-secondary text-start" name="sort_by" id="sort_by" onchange="'.$onchange.'">';
                
        $data .= $select.$option.'
            </select>';
        if($search!=''){
            $data .= '<input type="hidden" name="search" value="'.$search.'">';
        }
        $data .= '</'.$form.'>';

        return $data;
               
    }
    public static function paginate($page, $row='no', $load=''){
        $on_page = Filter::request(1,'page');
        $search = Filter::request('','search');
        $rows = Filter::request(30,'row');

        $a = 'a';
        if($load=='load'){
            $a = 'div';
        }
        function click($a, $data){
            if($a=='div'){
                return ' onclick="page('.$data.')" ';
            }
        };

        $paginate = [];
        $paginate[] = '<div class="pt-4">';
        if(!in_array($on_page, ['', 1])){
            $paginate[] .= '<'.$a.click($a,$on_page-1).' href="'.BASEURL.'/'.PATHURL_FULL.'?page='.($on_page-1);
            $paginate[] .= self::page_include($search, $row, $rows);
            $paginate[] .= '" class="btn btn-primary border"><span class="bi-chevron-left"></span></'.$a.'>';
        }else{
            $paginate[] .= '<'.$a.' class="btn btn-secondary border"><span class="bi-chevron-left"></span></'.$a.'>';
        }
        if($page<7){
            $paginate[] .= self::page_number(1, $page, $on_page, $a, $search, $row, $rows);
        }else{
            if($on_page<7){
                $paginate[] .= self::page_number(1, self::page_last_number($on_page, $page), $on_page, $a, $search, $row, $rows);
                $paginate[] .= self::page_point_last_number($page, $on_page, $a, $search, $row, $rows);
            }else{
                $paginate[] .= self::page_number(1, 2, $on_page, $a, $search, $row, $rows);
                $paginate[] .= '<'.$a.' class="btn btn-light border">...</'.$a.'>';
                $paginate[] .= self::page_number($on_page-3, $on_page, $on_page, $a, $search, $row, $rows);
                $paginate[] .= self::page_number($on_page+1, self::page_last_number($on_page, $page), $on_page, $a, $search, $row, $rows);
                $paginate[] .= self::page_point_last_number($page, $on_page, $a, $search, $row, $rows);
            }
        }
        if($page!=1 && $on_page!=$page && $on_page<$page){ 
            $paginate[] .= '<'.$a.click($a,$on_page+1).' href="'.BASEURL.'/'.PATHURL_FULL.'?page='.($on_page+1);
            $paginate[] .= self::page_include($search, $row, $rows);
            $paginate[] .= '" class="btn btn-primary border"><span class="bi-chevron-right"></span></'.$a.'>';
        }else{
            $paginate[] .= '<'.$a.' class="btn btn-secondary border"><span class="bi-chevron-right"></span></'.$a.'>';
        }
        $paginate[] = '</div>';

        return implode($paginate);
    }

    private static function page_number($start, $count, $on_page, $a, $search, $row, $rows){
        $paginate = [];
        for($i=$start; $i<=$count; $i++){
            if($on_page!=$i){
                $paginate[] .= '<'.$a.click($a,$i).' href="'.BASEURL.'/'.PATHURL_FULL.'?page='.$i;
                $paginate[] .= self::page_include($search, $row, $rows);
                $paginate[] .= '" class="btn btn-light border">'.$i.'</'.$a.'>';
            }else{
                $paginate[] .= '<'.$a.' class="btn btn-secondary border">'.$i.'</'.$a.'>';
            }
        }
        return implode($paginate);
    }

    private static function page_last_number($on_page, $page){
        if($on_page+3>=$page-2){
            $x = $page;
        }else{
            $x = $on_page+3;
        }
        return $x;
    }

    private static function page_point_last_number($page, $on_page, $a, $search, $row, $rows){
        $paginate = [];
        if($on_page+3<$page-2){
            $paginate[] .= '<'.$a.' class="btn btn-light border">...</'.$a.'>';
            $paginate[] .= self::page_number($page-1, $page, $on_page, $a, $search, $row, $rows);
        }

        return implode($paginate);
    }

    private static function page_include($search, $row, $rows){
        $paginate = [];
        if($search!=''){
            $paginate[] .= '&search='.$search;
        }
        if($row=='yes'){
            $paginate[] .= '&row='.$rows;
        }
        return implode($paginate);
    }
}

?>