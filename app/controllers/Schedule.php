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
        $data['title'] = "Schedule";
        $data['user'] = $this->model('SessionModel')->user();

        $data['input'] = $this->model('AllModel')->whereGet($this->table, "type='input'");

        $this->view('account/layouts/header', $data);
        $this->view('account/data');
        $this->view('account/layouts/footer', $data);
    }

    public function data(){
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

    public function store(){
        $frequency = $_POST['frequency'];
        $status = $_POST['status'];
        $dd = $_POST['dd'];
        $hh = $_POST['hh'];
        $mm = $_POST['mm'];
        $ss = $_POST['ss'];

        $rules = [
                    "frequency"=>"$frequency=required",
                    "status"=>"$status=required",
                    "hh"=>"$hh=required",
                    "mm"=>"$mm=required",
                    "ss"=>"$ss=required",
                ];

        if($frequency=='Day'){
            $rules['dd'] = "$dd=required";
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

        $time = $hh.':'.$mm.':'.$ss;

        if($frequency=='Day'){
            $time = $dd.' '.$hh.':'.$mm.':'.$ss;
        }

        Validator::validate($rules, $this->table);

        if($this->model('AllModel')->insert($this->table, "null, 'reboot', '$frequency', '$time', '$status'")){
            Logging::log('tambah_schedule', 1, "Schedule reboot frequency <i>$frequency</i> di waktu <i>$time</i> ditambahkan", $this->user->username);
            Flasher::success('tambah', $this->table);
        }else{
            Logging::log('tambah_schedule', 0, "Schedule reboot frequency <i>$frequency</i> di waktu <i>$time</i> gagal ditambahkan", $this->user->username);
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