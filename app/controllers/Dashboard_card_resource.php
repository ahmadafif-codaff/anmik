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

class Dashboard_card_resource extends Controller{

    public function index(){
        // Card Resource
        $user_session = $this->model('SessionModel')->token()->session;

        if($user_session>time()){
            $resource = MikrotikAPI::all('resource');
            foreach($resource as $r){
                $memory_width = 100-((($r['free-memory']/($r['total-memory']))*100));
                $hdd_width = 100-((($r['free-hdd-space']/($r['total-hdd-space']))*100));
                
                echo '<div class="bg-secondary mb-1" style="font-size: smaller; height:20px;"></div>';
                echo '<div class="bg-secondary mb-1" style="font-size: smaller; height:20px;"></div>';
                echo '<div class="bg-secondary mb-1" style="font-size: smaller; height:20px;"></div>';
        
                echo '<div class="bg-primary mb-1" style="margin-top:-72px; font-size: smaller;width:'.$r['cpu-load'].'%; height: 20px;"></div>';
                echo '<div class="bg-primary mb-1" style=" font-size: smaller;width:'.$memory_width.'%; height: 20px;"></div>';
                echo '<div class="bg-primary mb-1" style=" font-size: smaller;width:'.$hdd_width.'%; height: 20px;"></div>';
        
                echo '<div class="text-light mb-1" style="margin-top:-72px; font-size: smaller; height:20px;"><span style="margin-left: 3px;">'.$r['cpu-load'].'% '.$r['cpu-count'].'x '.$r['cpu-frequency'].' MHz</span></div>';
                echo '<div class="text-light mb-1" style=" font-size: smaller; height:20px;"><span style="margin-left: 3px;">'.substr($r['free-memory']/1046875,0,4).' MiB / '.number_format($r['total-memory']/1046875).' MiB</span></div>';
                echo '<div class="text-light mb-1" style=" font-size: smaller; height:20px;"><span style="margin-left: 3px;">'.substr($r['free-hdd-space']/1046875,0,4).' MiB / '.number_format($r['total-hdd-space']/1046875).' MiB</span></div>';
        
            }
        }else{
            echo '<img src="'.BASEURL.'/img/loading.webp" alt="" style="width:60px;">';
        }
    }
}

?>