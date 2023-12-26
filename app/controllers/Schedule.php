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

class Schedule extends Controller{
    private $table;
    private $user;

    public function __construct(){
        $this->authentication()->auth();
        $this->table = 'schedule';
        $this->user = $this->model('SessionModel')->user();
    }

    public function index(){
        $data['title'] = ucwords(PATHURL_ST.' '.PATHURL_ND);
        $data['user'] = $this->model('SessionModel')->user();

        $data['input'] = $this->model('AllModel')->whereGet($this->table, "type='input'");

        $this->view('account/layouts/header', $data);
        $this->view('account/data');
        $this->view('account/layouts/footer', $data);
    }

    public function schedule_reboot(){
        $search = Filter::request('','search');
        $show = Filter::request(30,'row');
        $start = Filter::page(0, $show);

        $data['title'] = "Schedule";
        $data['user'] = $this->model('SessionModel')->user();

        $data['data'] = $this->model('AllModel')->data($this->table, "time LIKE '%$search%' AND type='reboot' OR frequency LIKE '%$search%' AND type='reboot' LIMIT $start,$show");
        $count_all = count($this->model('AllModel')->data($this->table, "time LIKE '%$search%' AND type='reboot' OR frequency LIKE '%$search%' AND type='reboot'"));
        $data['count_data'] = count($data['data']) ;
        $data['start'] = $start;
        
        $data['page'] = ceil($count_all/$show);

        $this->view('account/schedule', $data);
    }

    public function schedule_boost(){
        $search = Filter::request('','search');
        $show = Filter::request(30,'row');
        $start = Filter::page(0, $show);

        $data['title'] = "Schedule";
        $data['user'] = $this->model('SessionModel')->user();

        $data['data'] = $this->model('AllModel')->data($this->table, "time LIKE '%$search%' AND type='boost' OR frequency LIKE '%$search%' AND type='boost' LIMIT $start,$show");
        $count_all = count($this->model('AllModel')->data($this->table, "time LIKE '%$search%' AND type='boost' OR frequency LIKE '%$search%' AND type='boost'"));
        $data['count_data'] = count($data['data']) ;
        $data['start'] = $start;
        
        $data['page'] = ceil($count_all/$show);

        $this->view('account/schedule', $data);
    }

    public function client_list(){
        $client = MikrotikAPI::all('simple');
        $option = [];
        $option[] = '<select name="client" id="client" class="btn btn-ligth w-100 border text-start"><option value="">--Select Client--</option>';
        foreach($client as $r){
            $comment = json_decode($r['comment']);
            $limit = explode('/',$r['limit-at']);
            $upload = $limit[0]/1000000;
            $download = $limit[1]/1000000;
            $option[] = '<option value="'.$r['.id'].'->'.$r['target'].'->'.$r['name'].'">'.$r['name'].' // '.$comment->category.' // '.$download.'Mbps/'.$upload.'Mbps</option>';
        }
        $option[] = '</select>';

        echo implode($option);
    }

    public function store(){
        $frequency = $_POST['frequency'];
        $status = $_POST['status'];
        $dd = $_POST['dd'];
        $hh = $_POST['hh'];
        $mm = $_POST['mm'];
        $ss = $_POST['ss'];
        $dde = $_POST['dde'];
        $hhe = $_POST['hhe'];
        $mme = $_POST['mme'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $client = $_POST['client'];
        $download = $_POST['download'];
        $upload = $_POST['upload'];

        $rules = [
                    "frequency"=>"$frequency=required",
                    "status"=>"$status=required",
                    "hh"=>"$hh=required",
                    "mm"=>"$mm=required",
                    "ss"=>"$ss=required",
                ];

        if(in_array($frequency,['Day', 'Repeat'])){
            $rules['dd'] = "$dd=required";

            if($frequency!='Day'){
                $rules['dde'] = "$dde=required";
                $rules['hhe'] = "$hhe=required";
                $rules['mme'] = "$mme=required";
                $rules['client'] = "$client=required";
                $rules['download'] = "$download=required";
                $rules['upload'] = "$upload=required";
            }
        }

        if($frequency=='One Time'){
            $rules['start_time'] = "$start_time=required";
            $rules['end_time'] = "$end_time=required";
        }

        if($dd<10 && strlen($dd)<2){
            $dd = '0'.$dd;
        }
        if($hh<10 && strlen($hh)<2){
            $hh = '0'.$hh;
        }
        if($mm<10 && strlen($mm)<2){
            $mm = '0'.$mm;
        }
        if($ss<10 && strlen($ss)<2){
            $ss = '0'.$ss;
        }
        if($dde<10 && strlen($dde)<2){
            $dde = '0'.$dde;
        }
        if($hhe<10 && strlen($hhe)<2){
            $hhe = '0'.$hhe;
        }
        if($mme<10 && strlen($mme)<2){
            $mme = '0'.$mme;
        }

        $time = $hh.':'.$mm.':'.$ss;

        if($frequency=='Day'){
            $time = $dd.':'.$hh.':'.$mm.':'.$ss;
        }

        if(in_array($frequency,['Repeat'])){
            $time = $dd.' '.$hh.':'.$mm.'->'.$dde.' '.$hhe.':'.$mme.'|'.$client.'|'.$upload.'/'.$download;
        }

        if(in_array($frequency,['One Time'])){
            $time = $start_time.'->'.$end_time.'|'.$client.'|'.$upload.'/'.$download;
        }


        Validator::validate($rules, $this->table);

        if($_POST['type']=='schedule_boost'){
            $type = 'boost';
        }
        else{
            $type = 'reboot';
        }

        if($this->model('AllModel')->insert($this->table, "null, '$type', '$frequency', '$time', '$status'")){
            Logging::log('tambah_schedule', 1, "Schedule $type frequency <i>$frequency</i> di waktu <i>$time</i> ditambahkan", $this->user->username);
            Flasher::success('tambah', $this->table);
        }else{
            Logging::log('tambah_schedule', 0, "Schedule $type frequency <i>$frequency</i> di waktu <i>$time</i> gagal ditambahkan", $this->user->username);
            Flasher::error('tambah', $this->table);
        }
    }

    public function status($id){
        $status = $_POST['value'];

        $this->model('AllModel')->update($this->table, "status='$status'", "id_$this->table='$id'");

        $data = $this->model('AllModel')->whereGet("$this->table", "id_$this->table='$id'");
        if($status == 'false'){
            $status = 'nonaktif';
        }else{
            $status = 'aktif';
        }

        Logging::log($status.'_schedule', 1, "Schedule reboot frequency <i>$data->frequency</i> di waktu <i>$data->time</i> di$status".'kan', $this->user->username);
    }

    public function schedule_input(){
        $minutes = $_POST['minutes'];

        $data = $this->model('AllModel')->whereGet("$this->table", "type='input'");
        Logging::log('edit_schedule', 1, "Schedule input frequency <i>$data->time</i> menit diubah menjadi <i>$minutes</i> menit", $this->user->username);

        $this->model('AllModel')->update($this->table, "time='$minutes'", "type='input'");
    }

    public function drop($id){
        $data = $this->model('AllModel')->whereGet("$this->table", "id_$this->table='$id'");
        if($this->model('AllModel')->delete($this->table, "id_$this->table='$id'")>0){
            Logging::log('hapus_schedule', 1, "Schedule reboot frequency <i>$data->frequency</i> di waktu <i>$data->time</i> dihapus", $this->user->username);
            Flasher::success('hapus', $this->table);
        }else{
            Logging::log('hapus_schedule', 0, "Schedule reboot frequency <i>$data->frequency</i> di waktu <i>$data->time</i> gagal dihapus", $this->user->username);
            Flasher::error('hapus', $this->table);
        }
    }
}


?>