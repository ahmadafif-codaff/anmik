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

class Client extends Controller{
    private $API;
    private $user;
    
    public function __construct(){
        $this->authentication()->auth();
        $this->API = new RouterosAPI();
        $this->API->debug = false;
        $this->user = $this->model('SessionModel')->user();
    }

    public function index(){
        $data['title'] = 'Clients';
        $data['user'] = $this->model('SessionModel')->user();

        $this->view('account/layouts/header', $data);
        $this->view('account/data', $data);
        $this->view('account/layouts/footer',$data);
    }

    public function data(){
        $data['title'] = 'Clients';

        if($this->API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
            $query = $this->API->comm('/queue/simple/print');
            $ra = [];
            $root_simple_queue = [];
            foreach($query as $r){
                $address = $r['target'];
                $root_simple_queue = $address;
                if(explode('/',$address)[1]!=24){
                    $address = explode('/',$address)[0];
                }
                $firewall = $this->API->comm('/ip/firewall/filter/print',["?src-address"=>"$address"]);
                foreach($firewall as $f){

                    $id_c = $r['.id'];
                    $name = $r['name'];
                    $target = $r['target'];
                    $comment = $r['comment'];
                    $limit = explode('/',$r['limit-at']);
                    $upload = Format::bytes($limit[0],'rate');
                    $download = Format::bytes($limit[1],'rate');

                    $p = json_decode($comment);
                    $date = $p->date;
                    $usage = $p->usage;
                    $usage = Format::bytes($usage, 'byte');
                    $usage_sub = $p->usage/1000000000; 
                    $quota_expl = explode('|', $p->quota);
                    $quota = $quota_expl[0];
                    $package = $p->package;
                    $category = $p->category;
                    $renew = $p->renew;
                    $price = $p->price;
                    $text_color = '';

                    if(explode('/', $target)[1]=='32'){
                        $router = explode('/', $target)[0];
                    }else{
                        $router1 = explode('.', explode('/', $target)[0]);
                        $router = $router1[0].'.'.$router1[1].'.'.$router1[2].'.1';
                    }

                    $status = $f['disabled'];
                    $id_f = $f['.id'];

                    if($date==''){
                        $date = '-';
                    }
        
                    if($renew>0&&$category=='Regular'){
                        $quota *= ($renew+1);
                        $price = Format::currency($price + ($renew*0.5*$price))." (harga ".Format::currency($price)."  + (($renew kali renew*0.5)*harga ".Format::currency($price).")"; 
                    }else{
                        $price = Format::currency($price);
                    }
        
                    if($category=='Premium'){
                        $quota = 'Not Available';
                        $text_color = 'text-danger';
                    }else{
                        if($usage_sub>$quota&&$category=='Regular'){
                            $quota = $quota_expl[1];
                            if($usage_sub>$quota){
                                $quota = 'Last Bandwidth';
                                $text_color = 'text-danger';
                            }else{
                                $quota = Format::bytes($quota*1000000000);
                            }
                        }elseif($category=='Kuota'){
                            if($renew>0){
                                $quota *= ($renew+1);
                            }
                            $quota = Format::bytes($quota*1000000000);
                        }
                    }

                    if($status=='false'){
                        $bg_color = 'table-danger';
                        $c_status = 'Blocked Access';
                    }else{
                        $bg_color = '';
                        $c_status = 'Internet Acces';
                    };

                    $c_f = [
                        "id"=>$id_c,
                        "date"=>$date,
                        "name"=>$name,
                        "target"=>$target,
                        "target_num"=>Format::addr_num($target),
                        "upload"=>$upload,
                        "download"=>$download,
                        "upload_num"=>$limit[0],
                        "download_num"=>$limit[1],
                        "usage"=>$usage,
                        "usage_sub"=>$usage_sub,
                        "quota"=>$quota,
                        "quota_sub"=>$quota_expl[0],
                        "package"=>$package,
                        "renew"=>$renew,
                        "category"=>$category,
                        "price"=>$price,
                        "price_sub"=>$p->price,
                        "status"=>$c_status,
                        "id_f"=>$id_f,
                        "bg"=>$bg_color,
                        "text"=>$text_color,
                        "router"=>$router,
                    ];
                    $ra[]= $c_f;
                }
            }

            $array = $ra;

            $sort_by = explode('|', Filter::request('name|ASC', 'sort_by'));
            $array_search = ArrayShow::search($array, Filter::request('address','search_by'), $sort_by[0],  $sort_by[1], 'json');
            $data['client'] = $array_search[0];
            $data['page'] = $array_search[1];
            $data['start'] = $array_search[2];
            $data['root'] = $root_simple_queue;
        }
        $this->API -> disconnect();

        $this->view('account/client',$data);
    }

    public function paket(){
        $paket = $this->model('AllModel')->all('paket');
        $option = [];
        $option[] = '<select name="paket" id="paket" class="btn btn-ligth w-100 border text-start" onchange="select_paket()"><option value="">--Select Paket--</option>';
        foreach($paket as $r){
            $kuota = '';
            if($r->kategori!='Premium'){
                $kuota = '//'.$r->kuota.' GB';
            }
            $paket = $r->nama.'//'.Format::currency($r->harga).'//'.$r->kategori.$kuota.'//'.$r->max_download.'Mbps/'.$r->max_upload.'Mbps';
            $paketv = $r->nama.' // '.$r->harga.' // '.$r->kategori.' // '.$r->max_upload.'/'.$r->max_download.' // '.$r->bandwidth_kedua.' // '.$r->bandwidth_ketiga.' // '.$r->kuota.' // '.$r->kuota_kedua;
        
            $option[] = '<option value="'.$paketv.'">'.$paket.'</option>';
        }
        $option[] = '</select>';

        echo implode($option);
    }

    public function target(){
        $firewall = MikrotikAPI::all('firewall');
        $option = [];
        $option[] = '<select name="target" id="target" class="btn btn-ligth w-100 border text-start"><option value="">--Select Target--</option>';
        foreach($firewall as $r){
            $target = $r['src-address'];
            if(explode('/', $target)[1]!=24){
                $target = $target.'/32';
            }
            $simple = MikrotikAPI::get('simple', 'target', $target, 'target');
            if($target!=''&&$target!='/32'&&$r['disabled']=='false'&&$simple==""){
                $option[] = '<option value="'.$target.'">'.$target.'</option>';
            }
        }
        $option[] = '</select>';

        echo implode($option);
    }

    public function parent(){
        $client = MikrotikAPI::all('simple');
        $option = [];
        $option[] = '<select name="parent" id="parent" class="btn btn-ligth w-100 border text-start"><option value="">--Select Parent--</option>';
        foreach($client as $r){
            $parent = $r['name'];
            $target = $r['target'];
            if(explode('/', $target)[1]==24){
                $option[] = ' <option value="'.$parent.'">'.$parent.' ('.$target.')</option>';
            }
        }
        $option[] = '</select>';

        echo implode($option);
    }

    public function detail($id){
        $data['title'] = 'Detail Clients';
        $data['paket'] = $this->model('AllModel')->all('paket');

        $data['client'] = MikrotikAPI::get('simple', '.id', $id);

        $this->view('account/layouts/header', $data);
        $this->view('account/client_detail',$data);
        $this->view('account/layouts/footer',$data);
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

        if(explode('/', $address)[1]!=24){
            $address .= '/32';
        }
        if($this->API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
            $queue = $this->API->comm('/queue/simple/print', ['?target'=>"$address"]);
            foreach($queue as $r){
                $id_c = $r['.id'];
                $name = $r['name'];
                $p = json_decode($r['comment']);
                $bandwidth = explode('/', explode('|', $p->bandwidth)[0]);
                $limit = (1000).'/'.(1000);
                if($status=='nonaktif'){
                    $limit = ($bandwidth[0]*1000000).'/'.($bandwidth[1]*1000000);
                }
                MikrotikAPI::single_set('simple', $id_c, 'limit', $limit);
                Logging::log("$status"."_firewall", 1, "Firewall Address <i>$address</i> ($name) di$status"."kan ($access).", $this->user->username);
            }
        }
        $this->API->disconnect();
    }

    public function renew($id){
        $data = MikrotikAPI::get('simple', '.id', $id);
        foreach($data as $r){
            $p = json_decode($r['comment']);
            if($p->category=='Regular'||$p->category=='Kuota'){
                $renew = $p->renew+1;
                $comment = '{"date":"'.$p->date.'","package":"'.$p->package.'","price":"'.$p->price.'","category":"'.$p->category.'","bandwidth":"'.$p->bandwidth.'","quota":"'.$p->quota.'","renew":"'.$renew.'","input_date":"'.$p->input_date.'","usage":"'.$p->usage.'"}';
                MikrotikAPI::single_set('simple', $id, 'comment', $comment);
                Logging::log("renew_client", 1, "Client <i>".$r['name']."</i> dengan Address <i>".$r['target']."</i> di <i>Renew<i/>", $this->user->username);
            }
        }
        Flasher::success('renew', 'client');
    }

    public function store(){
        $tanggal = $_POST['tanggal'];
        $nama = $_POST['nama'];
        $paket = $_POST['paket'];
        $target = $_POST['target'];
        $parent = $_POST['parent'];

        $nama_paket = explode(' // ', $paket)[0];
        $harga_paket = explode(' // ', $paket)[1];
        $kategori_paket = explode(' // ', $paket)[2];
        $bandwidth_paket = explode(' // ', $paket)[3];
        $bandwidth2_paket = explode(' // ', $paket)[4];
        $bandwidth3_paket = explode(' // ', $paket)[5];
        $kuota_paket = explode(' // ', $paket)[6];
        $kuota2_paket = explode(' // ', $paket)[7]*$kuota_paket;

        $download = explode('/',$bandwidth_paket)[1];
        $upload = explode('/',$bandwidth_paket)[0];

        $bandwidth2_paket = $upload*$bandwidth2_paket.'/'.$download*$bandwidth2_paket;
        $bandwidth3_paket = $upload*$bandwidth3_paket.'/'.$download*$bandwidth3_paket;

        $comment = '{"date":"'.$tanggal.'","package":"'.$nama_paket.'","price":"'.$harga_paket.'","category":"'.$kategori_paket.'","bandwidth":"'.$bandwidth_paket.'|'.$bandwidth2_paket.'|'.$bandwidth3_paket.'","quota":"'.$kuota_paket.'|'.$kuota2_paket.'","renew":"0","input_date":"'.DATENOW.'","usage":"0"}';

        if($tanggal == ''){
            $tanggal = '-';
        }

        $rules = [
            "tanggal"=>"$tanggal=required",
            "nama"=>"$nama=required",
            "paket"=>"$paket=required",
            "target"=>"$target=required",
            "parent"=>"$parent=required",
        ];

        $name_exist = MikrotikAPI::get('simple', 'name', $nama, 'name');
        $target_exist = MikrotikAPI::get('simple', 'target', $target, 'target');

        if($name_exist!=""){
            $rules["nama"] = "$nama=required|unique_api";
        }

        if($target_exist!=""){
            $rules["target"] = "$target=required|unique_api";
        }

        Validator::validate($rules);

        $download = explode('/',$bandwidth_paket)[1]*1000000;
        $upload = explode('/',$bandwidth_paket)[0]*1000000;

        if($this->API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
            $this->API->comm('/queue/simple/add', array(
                "name" => "$nama",
                "target" => "$target",
                "limit-at" => "$upload/$download",
                "max-limit" => "$upload/$download",
                "comment" => "$comment",
                "queue" => "default/default",
                "parent" => "$parent",
            ));
        }
        $this->API->disconnect();

        Flasher::success('tambah', 'client');

        Logging::log('tambah_client', 1, "Client <i>$nama</i> address <i>$target</i> ditambahkan", $this->user->username);
    }

    public function edit($id){
        $tanggal = $_POST['tanggal'];
        $nama = $_POST['nama'];
        $paket = $_POST['paket'];
        $target = $_POST['target'];
        $parent = $_POST['parent'];

        $nama_paket = explode(' // ', $paket)[0];
        $harga_paket = explode(' // ', $paket)[1];
        $kategori_paket = explode(' // ', $paket)[2];
        $bandwidth_paket = explode(' // ', $paket)[3];
        $bandwidth2_paket = explode(' // ', $paket)[4];
        $bandwidth3_paket = explode(' // ', $paket)[5];
        $kuota_paket = explode(' // ', $paket)[6];
        $kuota2_paket = explode(' // ', $paket)[7]*$kuota_paket;

        $download = explode('/',$bandwidth_paket)[1];
        $upload = explode('/',$bandwidth_paket)[0];

        $bandwidth2_paket = $upload*$bandwidth2_paket.'/'.$download*$bandwidth2_paket;
        $bandwidth3_paket = $upload*$bandwidth3_paket.'/'.$download*$bandwidth3_paket;

        $old_comment = MikrotikAPI::get('simple', '.id', $id, 'comment');
        $oc = json_decode($old_comment);

        $renew = $oc->renew;
        $last_input = $oc->input_date;
        $usage = $oc->usage;

        $comment = '{"date":"'.$tanggal.'","package":"'.$nama_paket.'","price":"'.$harga_paket.'","category":"'.$kategori_paket.'","bandwidth":"'.$bandwidth_paket.'|'.$bandwidth2_paket.'|'.$bandwidth3_paket.'","quota":"'.$kuota_paket.'|'.$kuota2_paket.'","renew":"'.$renew.'","input_date":"'.$last_input.'","usage":"'.$usage.'"}';

        if($tanggal == ''){
            $tanggal = '-';
        }

        $rules = [
            "tanggal"=>"$tanggal=required",
            "nama"=>"$nama=required",
            "paket"=>"$paket=required",
            "parent"=>"$parent=required",
        ];

        $old_name = MikrotikAPI::get('simple', 'name', $nama, '.id');
        $old_target = MikrotikAPI::get('simple', 'target', $target, '.id');
        $name_exist = MikrotikAPI::get('simple', 'name', $nama, 'name');
        
        $old_na = MikrotikAPI::get('simple', '.id', $id, 'name');
        $old_ta = MikrotikAPI::get('simple', '.id', $id, 'target');

        if($name_exist!=""&&$old_name!=$id){
            $rules["nama"] = "$nama=required|unique_api";
        }

        if($target==''){
            $target = $old_ta;
        }

        Validator::validate($rules);

        $download = explode('/',$bandwidth_paket)[1]*1000000;
        $upload = explode('/',$bandwidth_paket)[0]*1000000;

        $set = [
            ".id" => "$id",
            "name" => "$nama",
            "target" => "$target",
            "limit-at" => "$upload/$download",
            "max-limit" => "$upload/$download",
            "comment" => "$comment",
            "queue" => "default/default",
            "parent" => "$parent",
        ];
        
        MikrotikAPI::set('simple', $set);

        Flasher::success('ubah', 'client'); 


        $edit = "";
        if($old_name!=$id||$old_target!=$id){
            $edit = "menjadi ";
        }
        if($old_name!=$id){
            $edit .= "<i>$nama</i> ";
        }
        if($old_target!=$id){
            $edit .= "address <i>$target</i>";
            $addr = explode('/', $old_ta);
            if($addr[1]!=24){
                $addr = $addr[0];
            }
            $id_f = MikrotikAPI::get('firewall', 'src-address', $addr, '.id');
            MikrotikAPI::single_set('firewall', $id_f, 'disabled', 'false');
        }
        Logging::log('edit_client', 1, "Client <i>$old_na</i> address <i>$old_ta</i> diubah $edit", $this->user->username);
    }

    public function drop($id){
        $old_na = MikrotikAPI::get('simple', '.id', $id, 'name');
        $old_ta = MikrotikAPI::get('simple', '.id', $id, 'target');

        Logging::log('hapus_client', 1, "Client <i>$old_na</i> address <i>$old_ta</i> dihapus", $this->user->username);
        
        $addr = explode('/', $old_ta);
        if($addr[1]!=24){
            $addr = $addr[0];
        }
        $id_f = MikrotikAPI::get('firewall', 'src-address', $addr, '.id');
        MikrotikAPI::single_set('firewall', $id_f, 'disabled', 'false');

        MikrotikAPI::remove('simple', $id);
        Flasher::success('hapus', 'client');
    }
}


?>