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
            $keyup = ' onkeyup="search() "';
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
            <select name="search_by" id="search_by" class="btn btn-sm btn-primary text-start" onchange="search_by()">'.
                // '<option value="'.$input_by[0].'">Search by ('.$input_by[0].')</option>'.
                $option.
            '</select>';
        }
        $data .= $button.'</'.$form.'>';

        return $data;
        
    }
    public static function row(){
        $search = Filter::request('','search');
        $rows = Filter::request(30,'row');
        $data = '
            <form class="form-group bg-secondary rounded text-light me-1 mb-3" action="" style="width: fit-content; height:fit-content;">
                <span class="bi bi-eye"></span> <select class="btn btn-sm btn-secondary text-start" name="row" id="" onchange="this.form.submit()">
                <option selected>Number of rows '.$rows.'</option>
                <option value="30">30</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>';
        if($search!=''){
            $data .= '<input type="hidden" name="search" value="'.$search.'">';
        }
        $data .= '</form>';

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
            if($search!=''){
                $paginate[] .= '&search='.$search;
            }
            if($row=='yes'){
                $paginate[] .= '&row='.$rows;
            }
            $paginate[] .= '" class="btn btn-primary border"><span class="bi-chevron-left"></span></'.$a.'>';
        }else{
            $paginate[] .= '<'.$a.' class="btn btn-secondary border"><span class="bi-chevron-left"></span></'.$a.'>';
        }
        for($i=1; $i<=$page; $i++){
            if($on_page!=$i){
                $paginate[] .= '<'.$a.click($a,$i).' href="'.BASEURL.'/'.PATHURL_FULL.'?page='.$i;
                if($search!=''){
                    $paginate[] .= '&search='.$search;
                }
                if($row=='yes'){
                    $paginate[] .= '&row='.$rows;
                }
                $paginate[] .= '" class="btn btn-light border">'.$i.'</'.$a.'>';
            }else{
                $paginate[] .= '<'.$a.' class="btn btn-secondary border">'.$i.'</'.$a.'>';
            }
        } 
        if($page!=1 && $on_page!=$page && $on_page<$page){ 
            $paginate[] .= '<'.$a.click($a,$on_page+1).' href="'.BASEURL.'/'.PATHURL_FULL.'?page='.($on_page+1);
            if($search!=''){
                $paginate[] .= '&search='.$search;
            }
            if($row=='yes'){
                $paginate[] .= '&row='.$rows;
            }
            $paginate[] .= '" class="btn btn-primary border"><span class="bi-chevron-right"></span></'.$a.'>';
        }else{
            $paginate[] .= '<'.$a.' class="btn btn-secondary border"><span class="bi-chevron-right"></span></'.$a.'>';
        }
        $paginate[] = '</div>';

        return implode($paginate);
    }
}

?>