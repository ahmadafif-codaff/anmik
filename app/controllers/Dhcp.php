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

        // $dhcp = MikrotikAPI::all('dhcp');
        if($this->API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
            $dhcp = $this->API->comm('/ip/dhcp-server/lease/print');
            $array = [];
            foreach ($dhcp as $r){
                $address = $r['address'].'/32';
                $queue = $this->API->comm('/queue/simple/print', ["?target"=>"$address"]);
                $name = [];
                $jcom = json_decode($r['comment']);

                foreach ($queue as $q){
                    $name[] = $q['name'];
                }

                if($r['dynamic']=='false'){
                    $ip = 'Static';
                }else{
                    $ip = 'Dynamic';
                };
                
                if(count($name)<1){
                    $name[] = 'No client data';
                    $lifetime = '- -:-:-';
                    $lastconnect = '- -:-:-';
                }else{
                    $lifetime = Format::count_time($jcom->lifetime, 'up', 'day');
                    $lastconnect = $jcom->lastconnect;
                }

                $comment = ' <span class="text-primary">Life time : '.$lifetime;
                if($r['status']=='waiting'||$r['status']=='offered'){
                    $bg_color = 'table-danger';
                    $comment = ' <span class="text-danger">Last time connect : '.$lastconnect;
                }elseif($ip=='Dynamic'){
                    $bg_color = 'table-warning';
                }else{
                    $bg_color = '';
                }
                $comment .= " ($name[0]) $jcom->host</span>";

                $d = [
                    'id' => $r['.id'],
                    'address' => $r['address'],
                    'address_num'=> Format::addr_num($r['address']),
                    'mac_address' => $r['mac-address'],
                    'client_id' => $r['client-id'],
                    'server' => $r['server'],
                    'active_address' => $r['active-address'],
                    'active_mac_address' => $r['active-mac-address'],
                    'host_name' => $r['host-name'],
                    'expires_after' => $r['expires-after'],
                    'status' => $r['status'],
                    'status_static' => $ip,
                    'comment' => ';;; &nbsp; '.$ip.' &nbsp; '.$comment,
                    'client_name' => "$name[0]",
                    'bg' => $bg_color,
                ];

                $array[] = $d;
            }
        }
        $this->API -> disconnect();

        $sort_by = explode('|', Filter::request('address_num|ASC', 'sort_by'));
        $array_search = ArrayShow::search($array, Filter::request('address','search_by'), $sort_by[0],  $sort_by[1], 'json');
        $data['dhcp-lease'] = $array_search[0];
        $data['page'] = $array_search[1];
        $data['start'] = $array_search[2];

        $this->view('account/dhcp',$data);
    }

    public function static($id){

        $comment = '{"lastconnect":"'.DATENOW.'","lifetime":"'.time().'","status":"1","host":"'.$_POST['value'].'"}';

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