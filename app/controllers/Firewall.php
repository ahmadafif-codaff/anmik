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

class Firewall extends Controller{
    private $API;
    private $user;
    
    public function __construct(){
        $this->authentication()->auth();
        $this->API = new RouterosAPI();
        $this->API->debug = false;
        $this->user = $this->model('SessionModel')->user();
    }

    public function index(){
        $data['title'] = 'Firewall';
        $data['user'] = $this->model('SessionModel')->user();

        $data['dhcp-pool'] = MikrotikAPI::all('pool');

        $this->view('account/layouts/header', $data);
        $this->view('account/data');
        $this->view('account/layouts/footer', $data);
    }

    public function data(){
        $data['title'] = 'Firewall';

        $firewall = MikrotikAPI::all('firewall');
        $array = [];
        foreach ($firewall as $r){
            if($r['disabled']=='false'){
                $bg_color = 'table-danger';
                $f_status = 'Activated';
                $c_status = 'Blocked Access';
            }else{
                $bg_color = '';
                $f_status = 'Nonactivated';
                $c_status = 'Internet Acces';};
            if($r['src-address']!=''){
                $address = $r['src-address'];
            }else{
                $address = '--not identified--';
            }
            if(explode('.',$r['src-address'])[3]=='0/24'){
                $type = 'Network';
            }elseif($r['src-address']==''){
                $type = '--not identified--';
            }else{
                $type = 'Host';
            };

            $f = [
                'id'=>$r['.id'],
                'address'=>$address,
                'address_num'=>implode(explode('.', implode(explode('/',$address)))),
                'firewall_status'=>$f_status,
                'client_status'=>$c_status,
                'type'=>$type,
                'bg'=>$bg_color
            ];
            $array[] = $f;
        }
        
        $sort_by = explode('|', Filter::request('address_num|ASC', 'sort_by'));
        $array_search = ArrayShow::search($array, Filter::request('address','search_by'), $sort_by[0],  $sort_by[1], 'json');
        $data['firewall'] = $array_search[0];
        $data['page'] = $array_search[1];
        $data['start'] = $array_search[2];

        $this->view('account/firewall',$data);
    }

    public function status($id){
        $status = $_POST['value'];

        MikrotikAPI::single_set('firewall', $id, 'disabled', $status);

        $address = MikrotikAPI::get('firewall', '.id', $id, 'src-address');
        if($status == 'false'){
            $status = 'aktif';
            $access = 'Blocked Access';
        }else{
            $status = 'nonaktif';
            $access = 'Internet Access';
        }
        Logging::log("$status"."_firewall", 1, "Firewall Address <i>$address</i> di$status"."kan ($access)", $this->user->username);
    }

    public function drop($id){
        $address = MikrotikAPI::get('firewall', '.id', $id, 'src-address');
        $perfect = '';
        if(explode('/',$address)[1]!=24){
            $perfect = '/32';
        }
        Logging::log("hapus_firewall", 1, "Firewall Address <i>$address$perfect</i> dihapus", $this->user->username);
        MikrotikAPI::remove('firewall', $id);

        Flasher::success('hapus', 'firewall');
    }

    public function store(){
        $address = $_POST['address'];
        $status = $_POST['status'];

        $address1 = explode('/',$address)[0]; 
        $perfect = explode('/',$address)[1]; 
        $ip_pertama = explode('.',$address1)[0]; 
        $ip_kedua = explode('.',$address1)[1]; 
        $ip_ketiga = explode('.',$address1)[2]; 
        $ip_terakhir = explode('.',$address1)[3]; 
        $ip_lebih = explode('.',$address1)[4]; 

        if($perfect==24){
            $address2 = $address;
        }else{
            $address2 = $address1;
        }

        $rules = [
            "address"=>"$address=required",
            "status"=>"$status=required",
        ];
    
        if(($ip_pertama>255)||($ip_kedua>255)||($ip_ketiga>255)||($ip_terakhir>255)||($ip_terakhir=="")||($ip_lebih)||($perfect=="")||($ip_terakhir!=0&&$perfect==24)||($ip_terakhir==0&&$perfect!=24)||($ip_terakhir>0&&$perfect!=32)){
            $rules['address'] = "$address2=required|valid_ip";
        }

        $address_exist = MikrotikAPI::get('firewall', 'src-address', $address2, 'src-address');

        if($address_exist!=""){
            $rules["address"] = "$address2=required|unique_api";
        }

        Validator::validate($rules);

        if($this->API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
            $this->API->comm('/ip/firewall/filter/add', array(
                "chain" => "forward",
                "src-address" => "$address",
                "action" => "drop",
                "disabled" => "$status",
            ));
        }
        $this->API -> disconnect();

        Flasher::success('tambah', 'firewall');

        if($status == 'false'){
            $access = 'Blocked Access';
        }else{
            $access = 'Internet Access';
        }
        Logging::log("tambah_firewall", 1, "Firewall Address <i>$address2</i> ditambahkan ($access)", $this->user->username);
    }

    public function generate(){
        $address_pool = addslashes($_POST['address_pool']);

        if($this->API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
            $system=$this->API->comm('/ip/pool/print', array(
                "?name" => "$address_pool",
            ));

            foreach($system as $r){
                $ranges = $r['ranges'];
                $ip = explode('-',$ranges);
                $ip_class = explode('.',$ip[0])[0].'.'.explode('.',$ip[0])[1].'.'.explode('.',$ip[0])[2].'.';
                $ip_start = explode('.',$ip[0])[3];
                $ip_end  = explode('.',$ip[1])[3];

                $net_addr = $ip_class.'0/24';

                $query = $this->API->comm('/ip/firewall/filter/print', array(
                    "?src-address" => "$net_addr",
                ));
                if(count($query)<1){
                    $this->API->comm('/ip/firewall/filter/add', array(
                        "chain" => "forward",
                        "src-address" => "$net_addr",
                        "action" => "drop",
                        "disabled" => "false",
                    ));
                    Flasher::success('tambah', 'firewall');

                    Logging::log("generate_firewall", 1, "Firewall Address <i>$net_addr</i> ditambahkan (Blocked Access)", $this->user->username);
                }else{
                    echo json_encode(["type"=>"warning","title"=>"Peringatan","text"=>"Data firewall sudah ada, tidak perlu ditambahkan lagi"]);
                }

                for($x=$ip_start; $x<=$ip_end; $x++){
                    $host_add = $ip_class.$x;
                    $host_addr = $ip_class.$x.'/32';

                    $query = $this->API->comm('/ip/firewall/filter/print', array(
                        "?src-address" => "$host_add",
                    ));
                    if(count($query)<1){
                        $this->API->comm('/ip/firewall/filter/add', array(
                            "chain" => "forward",
                            "src-address" => "$host_addr",
                            "action" => "drop",
                            "disabled" => "false",
                        ));
                        Flasher::success('tambah', 'firewall');

                        Logging::log("generate_firewall", 1, "Firewall Address <i>$host_addr</i> ditambahkan (Blocked Access)", $this->user->username);
                    }else{
                        echo json_encode(["type"=>"warning","title"=>"Peringatan","text"=>"Data firewall sudah ada, tidak perlu ditambahkan lagi"]);
                    }
                }

            }

        }
        $this->API -> disconnect();
    }

    public function dropall(){
        $address_pool = addslashes($_POST['address_pool']);

        if($this->API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
            $system=$this->API->comm('/ip/pool/print', array(
                "?name" => "$address_pool",
            ));

            foreach($system as $r){
                $ranges = $r['ranges'];
                $ip = explode('-',$ranges);
                $ip_class = explode('.',$ip[0])[0].'.'.explode('.',$ip[0])[1].'.'.explode('.',$ip[0])[2].'.';
                $ip_start = explode('.',$ip[0])[3];
                $ip_end  = explode('.',$ip[1])[3];

                $net_addr = $ip_class.'0/24';

                $id_net = MikrotikAPI::get('firewall', 'src-address', $net_addr, '.id');
                if($id_net!=''){
                    MikrotikAPI::remove('firewall', $id_net);
                    Flasher::success('hapus', 'firewall');

                    Logging::log("hapus_firewall", 1, "Firewall Address <i>$net_addr</i> dihapus", $this->user->username);
                }else{
                    echo json_encode(["type"=>"warning","title"=>"Peringatan","text"=>"Data firewall tidak ada, tidak perlu dihapus"]);
                }

                for($x=$ip_start; $x<=$ip_end; $x++){
                    $host_addr = $ip_class.$x;

                    $id_host = MikrotikAPI::get('firewall', 'src-address', $host_addr, '.id');

                    if($id_host!=''){
                        MikrotikAPI::remove('firewall', $id_host);
                        Flasher::success('hapus', 'firewall');
    
                        Logging::log("hapus_firewall", 1, "Firewall Address <i>$host_addr/32</i> dihapus", $this->user->username);
                    }else{
                        echo json_encode(["type"=>"warning","title"=>"Peringatan","text"=>"Data firewall tidak ada, tidak perlu dihapus"]);
                    }
                }

            }

        }
        $this->API -> disconnect();
    }
}


?>