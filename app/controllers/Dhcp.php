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

class Dhcp extends Controller{
    private $API;
    private $user;
    
    public function __construct(){
        $this->authentication()->auth();
        $this->API = new RouterosAPI();
        $this->API->debug = false;
        $this->user = $this->model('SessionModel')->user();
    }
    
    public function index(){
        $data['title'] = 'DHCP Lease';
        $data['user'] = $this->model('SessionModel')->user();

        $this->view('account/layouts/header', $data);
        $this->view('account/data');
        $this->view('account/layouts/footer', $data);
    }

    public function data(){
        $data['title'] = 'DHCP Lease';

        $dhcp = MikrotikAPI::all('dhcp');
        $array = [];
        foreach ($dhcp as $r){
            if($r['dynamic']=='false'){
                $ip = 'Static';
            }else{
                $ip = 'Dynamic';
            };

            if($r['status']=='waiting'){
                $bg_color = 'table-danger';
            }elseif($ip=='Dynamic'){
                $bg_color = 'table-warning';
            }else{
                $bg_color = '';
            
            }

            $d = [
                'id' => $r['.id'],
                'address' => $r['address'],
                'mac_address' => $r['mac-address'],
                'client_id' => $r['client-id'],
                'server' => $r['server'],
                'active_address' => $r['active-address'],
                'active_mac_address' => $r['active-mac-address'],
                'host_name' => $r['host-name'],
                'exire_after' => $r['expires-after'],
                'status' => $r['status'],
                'status_static' => $ip,
                'comment' => ';;; &nbsp; '.$ip.' &nbsp; '.$r['comment'],
                'bg' => $bg_color,
            ];

            $array[] = $d;
        }

        $array_search = ArrayShow::search($array, Filter::request('address','search_by'), 'json');
        $data['dhcp-lease'] = $array_search[0];
        $data['page'] = $array_search[1];
        $data['start'] = $array_search[2];

        $this->view('account/dhcp',$data);
    }

    public function static($id){

        $comment = $_POST['value'].' Tanggal '.date('d').' '.date('M').' '.date('Y'). ' '. date('H:i:s');

        if($this->API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
            $this->API->comm('/ip/dhcp-server/lease/make-static', array(
                ".id" => "$id",
            ));  

            $this->API->comm('/ip/dhcp-server/lease/set', array(
                ".id" => "$id",
                "comment" => "$comment",
            ));
        }
        $this->API -> disconnect();

        $device = MikrotikAPI::get('dhcp', '.id', $id, 'host-name');
        $mac = MikrotikAPI::get('dhcp', '.id', $id, 'mac-address');
        $address = MikrotikAPI::get('dhcp', '.id', $id, 'address');
        Logging::log('make_static', 1, "Perangkat <i>$device</i> dengan Mac address <i>$mac</i> static di address <i>$address</i>", $this->user->username);
    }

    public function drop($id){
        $device = MikrotikAPI::get('dhcp', '.id', $id, 'host-name');
        $mac = MikrotikAPI::get('dhcp', '.id', $id, 'mac-address');
        $address = MikrotikAPI::get('dhcp', '.id', $id, 'address');
        Logging::log('hapus_dhcp_lease', 1, "Perangkat <i>$device</i> dengan Mac address <i>$mac</i> di address <i>$address</i> dihapus", $this->user->username);

        MikrotikAPI::remove('dhcp', $id);

        Flasher::success('hapus', 'dhcp-lease');
    }

}


?>