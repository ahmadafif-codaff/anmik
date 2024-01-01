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

class Dashboard_tx_rx extends Controller{

    public function index(){
        // tx rx
        $download = 0;
        $upload = 0;

        $user_session = $this->model('SessionModel')->token()->session;

        if($user_session>time()){
            $address = Filter::request('','address');
            $id = MikrotikAPI::get('simple', 'target', $address, '.id');
            $data['address']= $address;
    
            $rate = MikrotikAPI::get('simple', '.id', $id, 'rate');
    
            $rate = explode('/',$rate);
    
            $download = $rate[1]; 
            $upload = $rate[0]; 
        }

        $download = Format::bytes($download, 'rate');
        $upload = Format::bytes($upload, 'rate');

        echo '<span class="text-danger bi-download"></span> rx '.$download.'&nbsp; <span class="text-primary bi-upload"></span> tx '.$upload;
    }
}

?>