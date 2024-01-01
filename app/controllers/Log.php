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

class Log extends Controller{
    private $table;

    public function __construct()
    {
        $this->authentication()->auth();
        $this->table = 'log';
    }

    public function index(){
        $data['title'] = "Historry Log";
        $data['user'] = $this->model('SessionModel')->user();

        $this->view('account/layouts/header', $data);
        $this->view('account/data');
        $this->view('account/layouts/footer', $data);
    }

    public function data(){
        $search = Filter::request('','search');
        $show = Filter::request(30,'row');
        $start = Filter::page(0, $show);

        $data['title'] = "Historry Log";
        $data['user'] = $this->model('SessionModel')->user();

        $sort_by = explode('|', Filter::request('time|DESC', 'sort_by'));
        $order = $sort_by[0].' '.$sort_by[1];

        $log = $this->model('AllModel')->dataArr($this->table, '*', "time LIKE '%$search%' OR ip LIKE '%$search%' OR browser LIKE '%$search%' OR so LIKE '%$search%' OR message LIKE '%$search%' OR action LIKE '%$search%' ORDER BY $order LIMIT $start,$show");
        $array = [];
        foreach ($log as $r){
            $bg_color = '';
            if($r['status']==0||$r['action']=='nonactivated'){
                $bg_color = 'table-danger';
            }
            if(in_array($r['action'],['reboot_mikrotik','fup1','fup2'])){
                $bg_color = 'table-warning';
            }
            if(in_array($r['action'],['reset_bandwidth','renew_client'])){
                $bg_color = 'table-success';
            }
            if($r['action']=='expired_boost'){
                $bg_color = 'table-info';
            }
            if($r['action']=='boost_bandwidth'){
                $bg_color = 'table-primary';
            }
            $l = $r;
            $l['bg'] = $bg_color;
            $array[] = json_decode(json_encode($l));
        }
        $data['data'] = $array;
        $count_all = count($this->model('AllModel')->data($this->table, "time LIKE '%$search%' OR ip LIKE '%$search%' OR browser LIKE '%$search%' OR so LIKE '%$search%' OR message LIKE '%$search%' OR action LIKE '%$search%' ORDER BY time DESC"));
        $data['count_data'] = count($data['data']) ;
        $data['start'] = $start;
        
        $data['page'] = ceil($count_all/$show);

        $this->view('account/log', $data);
    }
}

?>