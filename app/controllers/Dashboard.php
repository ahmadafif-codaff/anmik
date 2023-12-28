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

class Dashboard extends Controller{
    private $address;
    private $id_target;
    private $date;
    private $year;
    private $month;
    private $day;

    public function __construct()
    {
        $this->authentication()->auth();
        $this->address = Filter::request("",'address');
        $this->id_target = MikrotikAPI::get('simple', 'target', $this->address, '.id');
        $this->date = Filter::request("",'date');
        $this->year = explode('-',$this->date)[0];
        $this->month = explode('-',$this->date)[1];
        $this->day = explode('-',$this->date)[2];
    }

    public function index(){

        $data['title'] = "Dashboard";
        $data['user'] = $this->model('SessionModel')->user();
        $data['address']= $this->address;
        $data['date'] = $this->date;
        $data['year'] = $this->year;
        $data['month'] = $this->month;
        $data['day'] = $this->day;
        $name = MikrotikAPI::get('simple', 'target', $this->address, 'name');
        $data['name'] = $name;

        $this->view('account/layouts/header', $data);
        $this->view('account/dashboard', $data);
        $this->view('account/layouts/footer', $data);
    }

    public function card_usage(){
        // Card Usage 
        $p = json_decode(MikrotikAPI::get('simple', 'parent', 'none', 'comment'));
        $total_usage = explode(' ', Format::bytes($p->usage));

        $status_usage = (($p->usage/1000000000)/($p->quota2))*100;

        if($status_usage<=50){
            $bg_color   = "bg-primary";
        }elseif($status_usage<=75){
            $bg_color   = "bg-warning";
        }elseif($status_usage<=100){
            $bg_color   = "bg-danger";
        }else{
            $bg_color   = "bg-danger";
            $status_usage = 100;  
        }

        $u = [
            "usage"=>$total_usage,
            "status_usage"=>$status_usage,
            "bg"=>$bg_color,
        ];

        $data['usage'] = $u;

        $this->view('account/dashboard/card_usage', $data);
    }

    public function card_client(){
        // Card Client
        $API = new RouterosAPI();
        if($API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
            $query = $API->comm('/queue/simple/print');
            $ra = [];
            $status = [];
            foreach($query as $r){
                $address = $r['target'];
                if(explode('/',$address)[1]!=24){
                    $address = explode('/',$address)[0];
                }
                $firewall = $API->comm('/ip/firewall/filter/print',["?src-address"=>"$address"]);
                foreach($firewall as $f){
                    $ra[] = $r;
                    $status[] = $f['disabled'];
                }
            }

            $count_status = array_count_values($status);
            $count_client = count($ra);

            echo 
                '<h3 class="pe-5">'.$count_client.'</h3>
                <p>Acivated <br>Nonactivated</p>
                <p>&nbsp; : '.$count_status['true'].'<br>&nbsp; : '.$count_status['false'].'</p>';
        }
        $API -> disconnect();
    }

    public function graph_daily(){
        // Graph daily
        $year = $this->year;
        $month = $this->month;
        $day = $this->day;
        
        $id = $this->id_target;
        $this->graph('daily', 'download AS graph1st, upload AS graph2nd, HOUR(time) AS hour, MINUTE(time) AS minutes, DAYNAME(time) AS dayname, MONTHNAME(time) AS monthname', "id_client='$id' AND DAY(time)='$day' AND MONTH(time)='$month' AND YEAR(time)='$year' ORDER BY time ASC");
    }

    public function graph_monthly(){
        // Graph Monthly
        $year = $this->year;
        $month = $this->month;
        
        $id = $this->id_target;
        $this->graph('monthly', 'SUM(download) AS graph1st, SUM(upload) AS graph2nd, YEAR(time) AS year, MONTH(time) AS month, DAY(time) AS day, DAYNAME(time) AS dayname, MONTHNAME(time) AS monthname',"id_client='$id' AND MONTH(time)='$month' AND YEAR(time)='$year' GROUP BY DAY(time) ORDER BY time ASC");
    }

    public function graph_yearly(){
        // Graph Yearly
        $id = $this->id_target;
        $this->graph('yearly', 'SUM(download) AS graph1st, SUM(upload) AS graph2nd, YEAR(time) AS year, MONTH(time) AS month, MONTHNAME(time) AS monthname',"id_client='$id' GROUP BY MONTH(time) ORDER BY time ASC");
    }

    private function graph($frequency, $select, $where){
        $data['address']= $this->address;
        $data['date'] = $this->date;
        $data['year'] = $this->year;
        $data['month'] = $this->month;
        $data['day'] = $this->day;

        $graph_frequency = 'graph_'.$frequency;
        $max_upload_frequency = 'max_upload_'.$frequency;
        $max_download_frequency = 'max_download_'.$frequency;
        $max_frequency = 'max_'.$frequency;

        $upload_as_max = 'SUM(upload) AS max';
        $download_as_max = 'SUM(download) AS max';

        if($frequency=='daily'){
            $upload_as_max = 'upload AS max';
            $download_as_max = 'download AS max';
        }

        $data[$graph_frequency] = $this->model('AllModel')->dataArr('usages',$select, $where);
        $data[$max_upload_frequency] = max($this->model('AllModel')->dataArr('usages',$upload_as_max, $where));
        $data[$max_download_frequency] = max($this->model('AllModel')->dataArr('usages',$download_as_max, $where));
        $data[$max_frequency] = max([$data[$max_upload_frequency],$data[$max_download_frequency]]);
        
        $this->view('account/dashboard/graph', $data);
    }
    
    public function total_daily(){
        // Total Daily
        $year = $this->year;
        $month = $this->month;
        $day = $this->day;
        $id = $this->id_target;

        $this->data_total("id_client='$id' AND DAY(time)='$day' AND MONTH(time)='$month' AND YEAR(time)='$year'");
    }
    
    public function total_monthly(){
        // Total Monthly
        $year = $this->year;
        $month = $this->month;
        $id = $this->id_target;

        $this->data_total("id_client='$id' AND MONTH(time)='$month' AND YEAR(time)='$year'");
    }
    
    public function total_yearly(){
        // Total Yearly
        $id = $this->id_target;

        $this->data_total("id_client='$id'");
    }

    private function data_total($where){
        $total = $this->model('AllModel')->dataArr('usages','SUM(download) AS download, SUM(upload) AS upload', "$where");

        $download = $total[0]['download']; 
        $upload = $total[0]['upload']; 

        $this->total($download, $upload);
    }

    private function total($download, $upload){
        $total = $download+$upload;
        $download = Format::bytes($download, 'byte');
        $upload = Format::bytes($upload, 'byte');
        $total = Format::bytes($total, 'byte');

        echo '<span class="bg-danger rounded" style="height:10px;width:10px;"></span>&nbsp;Downloads '.$download.'&nbsp;&nbsp;&nbsp;<span class="bg-primary-dark rounded" style="height:10px;width:10px;"></span>&nbsp;Uploads '.$upload.'&nbsp;&nbsp;&nbsp;<span class="btn-bg-gradient-purple rounded" style="height:10px;width:10px;"></span>&nbsp;Total '.$total;
    }

    public function client_list(){
        // Client List
        $data['date'] = $this->date;

        $API = new RouterosAPI();
        if($API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
            $query = $API->comm('/queue/simple/print');
            $ra = [];
            foreach($query as $r){
                $address = $r['target'];
                if(explode('/',$address)[1]!=24){
                    $address = explode('/',$address)[0];
                }
                $firewall = $API->comm('/ip/firewall/filter/print',["?src-address"=>"$address"]);
                foreach($firewall as $f){
                    $p = json_decode($r['comment']);

                    if($p->renew>0){
                        $p->quota2 *= ($p->renew+1);
                    }

                    $status_usage = substr($p->usage/1000000000,0,5)/$p->quota2*100;
                    if($p->category=='Kuota'){
                        $status_usage = substr($p->usage/1000000000,0,5)/$p->quota*100;
                        $btn = 'btn-danger';
                    }else{
                        $btn = 'btn-success';
                    }

                    $card = 'bg-primary';
                    if($f['disabled']=='false'){
                        $card = 'bg-danger';
                    }

                    if($status_usage<=50){
                        $bg_color   = "bg-primary";
                    }elseif($status_usage<=75){
                        $bg_color   = "bg-warning";
                    }elseif($status_usage<=100){
                        $bg_color   = "bg-danger";
                    }else{
                        $bg_color   = "bg-danger";
                        $status_usage = 100;  
                        if($p->category=='Premium'){
                            $bg_color   = "bg-primary";
                            $btn = 'btn-primary';
                        }
                    }

                    $c_f = [
                        "target"=>$r['target'],
                        "name"=>$r['name'],
                        "category"=>$p->category,
                        "usage"=>explode(' ',Format::bytes($p->usage)),
                        "usage_real"=>$p->usage,
                        "status_usage"=>$status_usage,
                        "bg"=>$bg_color,
                        "btn"=>$btn,
                        "card"=>$card,
                    ];
                    $ra[] = $c_f;
                }
            }

            $array = $ra;

            $array_search = ArrayShow::search($array, 'name', 'usage_real','desc', 'json');
            $data['client'] = $array_search[0];
        }
        $API -> disconnect();
        
        $this->view('account/dashboard/client_list', $data);
    }
}

?>