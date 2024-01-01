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
        
        if($user_session>time()){
            $uptime = MikrotikAPI::all('resource')[0]['uptime'];
        }else{
            $uptime = '--:--:--';
            echo '<script>window.location.href = ""</script>';
        }

        echo '<div class="border-start p-2 ms-1" title="uptime"><span class="bi-hourglass-bottom"></span> '.$uptime.'</div>';
        echo '<div class="border-start p-2 ms-1" title="session"><span class="bi-stopwatch"></span> '.$count_down.'</div>';
        echo '<div class="border-start p-2 ms-1" title="time"><span class="bi-clock"></span> '.date('H:i:s').'</div>';
    }
}


?>

