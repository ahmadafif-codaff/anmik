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

class Dashboard_client extends Controller{
    private $username;
    private $address;
    private $paket;
    private $category;
    private $usage;
    private $quota;
    private $bandwidth;
    private $id_target;
    private $date;
    private $year;
    private $month;
    private $day;

    public function __construct()
    {
        session_start();
        $this->username = $_SESSION['username'];
        $this->address = $_SESSION['address'];
        $this->paket = json_decode(MikrotikAPI::get('simple', 'target', $this->address, 'comment'));
        $this->category = $this->paket->category;
        $this->usage = $this->paket->usage;
        $this->quota = explode('|', $this->paket->quota);
        $this->bandwidth = explode('|', $this->paket->bandwidth);
        $this->id_target = MikrotikAPI::get('simple', 'target', $this->address, '.id');
        $this->date = Filter::request("",'date');
        $this->year = explode('-',$this->date)[0];
        $this->month = explode('-',$this->date)[1];
        $this->day = explode('-',$this->date)[2];
        if(count(MikrotikAPI::get('simple', 'target', $this->address))>0){
            if(MikrotikAPI::get('simple', 'name', $this->username, 'target')==$_SESSION['address']){
                // echo 'success';
            }else{
                echo '<script>window.location.href="'.BASEURL.'/login_client"</script>';
                // echo 'error_name';
            }
        }else{
            echo '<script>window.location.href="'.BASEURL.'/login_client"</script>';
            // echo 'error_add';
        }
    }

    public function index(){

        $data['title'] = "Dashboard Client";
        $data['name'] = $this->username;
        $data['address'] = $this->address;
        $data['date'] = $this->date;

        $this->view('client/layouts/header', $data);
        $this->view('client/dashboard', $data);
        $this->view('client/layouts/footer', $data);
    }

    public function card_usage(){
        $total_usage = explode(' ', Format::bytes($this->usage));

        $quota1 = $this->quota[1];
        if($this->category=='Kuota'){
            $quota1 = $this->quota[0];
        }
        if($this->paket->renew>0){
            $quota1 *= ($this->paket->renew+1); 
        }

        $status_usage = (($this->usage/1000000000)/($quota1))*100;

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
        
        if($this->category=='Premium'){
            $status_usage = 100;  
            $bg_color   = "bg-primary";
        }

        $u = [
            "usage"=>$total_usage,
            "status_usage"=>$status_usage,
            "bg"=>$bg_color,
        ];

        $data['usage'] = $u;

        $this->view('client/card_usage', $data);
    }

    public function card_client(){
        $bandwidth = explode('/', $this->bandwidth[0])[1];
        if($this->category=='Premium'){
            $quota1 = '';
        }
        if($this->category=='Regular'){
            $quota1 = Format::bytes($this->quota[1]*1000000000);
        }
        if($this->category=='Kuota'){
            $quota1 = Format::bytes($this->quota[0]*1000000000);
        }

        echo 
            '<div class="pe-3 d-flex"><h5>'.$bandwidth.'&nbsp;</h5><p style="font-size:smaller;">Mbps</p></div>
            <p class="border-start ps-3">'.$this->category.'<br>'.$quota1.'</p>';
    }

    public function card_renew(){
        $renew = number_format($this->paket->renew);
        $quota = explode('|', $this->paket->quota);
        if($this->category=='Premium'){
            $quota1 = '';
        }
        if($this->category=='Regular'){
            $quota1 = 'Quota total '.Format::bytes($quota[1]*($renew+1)*1000000000);
        }
        if($this->category=='Kuota'){
            $quota1 = 'Quota total '.Format::bytes($quota[0]*($renew+1)*1000000000);
        }

        echo 
            '<div class="pe-3 d-flex"><h5>'.$renew.'&nbsp;</h5><p style="font-size:smaller;">x</p></div>
            <p class="border-start ps-3">'.$quota1.'</p>';
    }

    public function logout(){
        session_unset();
        session_destroy();
        echo '<script>window.location.href="'.BASEURL.'/login_client"</script>';
    }

    public function graph_monthly(){
        // Graph Monthly
        $year = $this->year;
        $month = $this->month;
        
        $id = $this->id_target;
        $this->graph('monthly', 'SUM(download) AS graph1st, SUM(upload) AS graph2nd, YEAR(time) AS year, MONTH(time) AS month, DAY(time) AS day, DAYNAME(time) AS dayname, MONTHNAME(time) AS monthname',"id_client='$id' AND MONTH(time)='$month' AND YEAR(time)='$year' GROUP BY DAY(time) ORDER BY time ASC");
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
    
    public function total_monthly(){
        // Total Monthly
        $year = $this->year;
        $month = $this->month;
        $id = $this->id_target;

        $this->data_total("id_client='$id' AND MONTH(time)='$month' AND YEAR(time)='$year'");
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
}

?>