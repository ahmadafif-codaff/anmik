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

class Dashboard_uptime extends Controller{
    public function index(){
        $user_session = $this->model('SessionModel')->token()->session;
        $count_down = Format::count_time($user_session, 'down');
        $title = '';
        $id = '';
        
        if($user_session>time()){
            if(!isset($_COOKIE['uptime'])){
                $uptime = MikrotikAPI::all('resource')[0]['uptime'];
                $title = 'click to hide ';
            }else{
                $uptime = '<span class="bi-eye"></span>';
                $title = 'click to show ';
                $id = 'show-';
            }
        }else{
            $uptime = '--:--:--';
            echo '<script>window.location.href = ""</script>';
        }

        echo '<div class="border-start p-2 ms-1 pointer" title="'.$title.'uptime" id="'.$id.'uptime"><span class="bi-hourglass-bottom"></span> '.$uptime.'</div>';
        echo '<div class="border-start p-2 ms-1" title="session"><span class="bi-stopwatch"></span> '.$count_down.'</div>';
        echo '<div class="border-start p-2 ms-1" title="time"><span class="bi-clock"></span> '.date('H:i:s').'</div>';
    }
}


?>
<script>
    $(document).ready(function(){
        $('#uptime').click(function(){
            document.cookie = "uptime=hidden;expires=Thu, 18 Dec <?=date('Y')+1?> 12:00:00 UTC";
        })
        $('#show-uptime').click(function(){
            document.cookie = "uptime=hidden;expires=Thu, 18 Dec 2013 12:00:00 UTC";
        })
    })
</script>

