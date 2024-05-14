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

$ip = Logging::get_client_ip();
$ip_acc = array('::1');
if(!in_array($ip, $ip_acc)){
    echo '<div style="height: 100vh; display:flex; flex-direction:column; justify-content:center; align-items:center; font-family:arial;"><div style="font-size:xx-large;">Oopss</div><div style="font-size: large;">Akses ditolak :)</div><br><div>Buka halaman ini di localhost</div></div>';
    die;
}
?>
<!DOCTYPE html>
<html lang="in">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?=BASEURL?>/css/style.css">
    <link rel="shortcut icon" href="<?=BASEURL?>/img/logo.png" type="image/x-icon">
    <title><?=$data['title']?> - Codaff Project</title>
</head>
<body>
    <div class="container d-flex flex-column align-items-center justify-content-center vh-100 overflow-scroll p-5">
        <div class="time h-100">
            <h1 class="text-bg-primary p-2 rounded-1">
                <?php 

                    echo date('H:i:s');

                    foreach($data['reboot'] as $re){
                        if($re->status=='true'){
                            $d = '';
                            if($re->frequency=='Day'){
                                $d = 'd ';
                            }
                            $live_time = date($d.'H:i:s');
                            if($live_time==$re->time){
                                Logging::log('reboot_mikrotik', 1, "Mulai ulang perangkat terjadwal", 'from_server');
                                MikrotikAPI::reboot();
                            }
                        }
                    }
                ?>
            </h1>
        </div>
        <h2 class="text-secondary">Perhitungan sedang berlangsung....</h2>
        <h5 class="text-danger">Mohon jangan tutup halaman ini!</h5>
        <br>
        <div class="input_pemakaian container d-flex flex-column align-items-center justify-content-center vh-100 overflow-scroll">
            <?php 
                    $time = date('Y-m-d H:i:s');
                    $year = date('Y');
                    $month = date('m');
                    $day = date('d');
                    $hour = date('H');
                    $minutes = date('i');
                    $input_menit   = $data['input']->time;

                    for($x=0; $x<60; $x++){
                        if($x%$input_menit == 0){
                            if($minutes==$x){

                                $db = new Database;
                                
                                // $cek = $db->query("SELECT * FROM usages WHERE YEAR(time)='$year' AND MONTH(time)='$month' AND DAY(time)='$day' AND HOUR(time)='$hour' AND MINUTE(time)='$minutes'");
                                // $cek = $db->resultSet();
                                
                                $cek = [];
                                foreach(Datafile::get('db/usage.json') as $r){
                                    if(substr($r->time,0,16)==date('Y-m-d H:i')){
                                        $cek[] = $r;
                                    }
                                }

                                if(count($cek)<1){

                                    $API = new RouterosAPI();
                                    if($API->connect(MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASS)){
                                        $cek_normal_usage = [];
                                        $minimal_bites = 1000;
                                        $data = $API->comm('/queue/simple/print');
                                        foreach($data as $r){
                                            $id = $r['.id'];
                                            $name = $r['name'];
                                            $comment = $r['comment'];
                                            $target = $r['target'];
                                            $max_limit = $r['max-limit'];
                                            $up_limit = explode('/', $max_limit)[0]/1000000;
                                            $down_limit = explode('/', $max_limit)[1]/1000000;
                                            $bytes = explode('/',$r['bytes']);
            
                                            $p = json_decode($comment);
                                            $date = $p->date; 
                                            $package = $p->package; 
                                            $price = $p->price; 
                                            $category = $p->category; 
                                            $bandwidth = explode('|',$p->bandwidth); 
                                            $bandwidth1 = explode('/',$bandwidth[0]); 
                                            $bandwidth2 = explode('/',$bandwidth[1]); 
                                            $bandwidth3 = explode('/',$bandwidth[2]); 
                                            $quota = explode('|',$p->quota); 
                                            $quota1 = $quota[0]; 
                                            $quota2 = $quota[1]; 
                                            $renew = $p->renew; 
                                            $input_date = $p->input_date; 
                                            $usage = $p->usage;
                                            
                                            $limit1 = ($bandwidth1[0]*1000000).'/'.($bandwidth1[1]*1000000);
                                            $limit2 = ($bandwidth2[0]*1000000).'/'.($bandwidth2[1]*1000000);
                                            $limit3 = ($bandwidth3[0]*1000000).'/'.($bandwidth3[1]*1000000);
                                            $limit4 = (1000).'/'.(1000);

                                            $firewall_addr = $target;
                                            if(explode('/', $target)[1]==32){
                                                $firewall_addr = explode('/', $target)[0];
                                            }
                                            $firewall = $API->comm('/ip/firewall/filter/print', ["?src-address"=>"$firewall_addr"]);
                                            $firewall_dis = [];
                                            foreach($firewall as $f){
                                                $firewall_dis[] = $f['disabled'];
                                                if($max_limit!=$limit4&&$f['disabled']=='false'){
                                                    MikrotikAPI::single_set('simple', $id, 'limit', $limit4);
                                                    Logging::log('limited', 1, "Client <i>$name</i> nonaktif, kecepatan dialihkan ke 1Kbps", 'from_server');
                                                }
                                            }
                                            
                                            $dhcp_addr = explode('/', $target)[0];
                                            $dhcp = $API->comm('/ip/dhcp-server/lease/print', ["?address"=>"$dhcp_addr"]);
                                            foreach($dhcp as $d){
                                                $d_id = $d['.id'];
                                                $d_status = $d['status'];
                                                $d_address = $d['address'];
                                                $d_hostname = $d['host-name'];
                                                if($d_hostname==''){
                                                    $d_hostname = 'device is not detected';
                                                }
                                                if($d_status=='waiting'){
                                                    if(explode('->',explode(' | ',$d['comment'])[1])[2]!=0){
                                                        Logging::log('disconnected', 1, "Client <i>$name</i> ($d_hostname) dengan alamat ip <i>$d_address</i> terputus dari jaringan", 'from_server');
                                                    }
                                                    $d_comment = explode(' -> ',$d['comment'])[0].' -> '.time().' -> 0';
                                                }
                                                if($d_status=='bound'){
                                                    if(explode('->',explode(' | ',$d['comment'])[1])[2]!=1){
                                                        Logging::log('connected', 1, "Client <i>$name</i> ($d_hostname) dengan alamat ip <i>$d_address</i> terhubung ke jaringan", 'from_server');
                                                    }
                                                    $d_comment = explode(' | ',$d['comment'])[0].' | '.DATENOW.' -> '.explode(' -> ',$d['comment'])[1].' -> 1';
                                                }
                                                $API->comm('/ip/dhcp-server/lease/set', [
                                                    ".id"=>"$d_id",
                                                    "comment"=>"$d_comment"
                                                ]);
                                            }
            
                                            $comment = '{"date":"'.$date.'","package":"'.$package.'","price":"'.$price.'","category":"'.$category.'",';
                                            if(in_array($category, ['Kuota', 'Premium'])){
                                                $comment .= '"bandwidth":"'.$bandwidth1[0].'/'.$bandwidth1[1].'",';
                                                if($category=='Kuota'){
                                                    $comment .= '"quota":"'.$quota1.'",';
                                                }
                                            }
                                            if($category=='Regular'){
                                                $comment .= '"bandwidth":"'.$bandwidth1[0].'/'.$bandwidth1[1].'|'.$bandwidth2[0].'/'.$bandwidth2[1].'|'.$bandwidth3[0].'/'.$bandwidth3[1].'","quota":"'.$quota1.'|'.$quota2.'",';
                                            }

                                            $upload = $bytes[0];
                                            $download = $bytes[1];

                                            $cek_normal_usage[] = $upload;
                                            $cek_normal_usage[] = $download;
                                                
                                            $qboost = $db->query("SELECT * FROM schedule WHERE type='boost'");
                                            $qboost = $db->resultSet();
                                            $boost_client = [];
                                            foreach($qboost as $boost){
                                                $id_schedule = $boost->id_schedule;
                                                $boost_time = explode('|', $boost->time);
                                                $time_schedule = explode('->', $boost_time[0]);
                                                $start_time = strtotime($time_schedule[0]);
                                                $end_time = strtotime($time_schedule[1]);
                                                $client = explode('->', $boost_time[1]);
                                                $id_client = $client[0];
                                                $target_client = $client[1];
                                                $name_client = $client[2];
                                                $boost_bandwidth = explode('/', $boost_time[2]);
                                                $boost_upload = $boost_bandwidth[0];
                                                $boost_download = $boost_bandwidth[1];
                                                $boost_limit = ($boost_upload*1000000).'/'.($boost_download*1000000);

                                                if($id==$id_client){
                                                    if($boost->status=='true'){
                                                        if($boost->frequency=='One Time'){
                                                            if(time()>=$start_time){
                                                                if(time()<=$end_time){
                                                                    if($max_limit!=$boost_limit&&$firewall_dis[0]=='true'){
                                                                        MikrotikAPI::single_set('simple', $id, 'limit', $boost_limit);
                                                                        Logging::log('boost_bandwidth', 1, "Kecepatan <i>$name</i> di boost dari bandwidth upload <i>".$up_limit." Mbps dan download ".$down_limit." Mbps</i> menjadi <i>upload ".$boost_bandwidth[0]." Mbps dan download ".$boost_bandwidth[1]." Mbps</i> sampai <i>".$time_schedule[1]."</i>", 'from_server');
                                                                    }
                                                                    $boost_client[] = $id_client;
                                                                }else{
                                                                    $db->query("DELETE FROM schedule WHERE id_schedule='$id_schedule'");
                                                                    $db->execute();
                                                                    Logging::log('expired_boost', 1, "Waktu boost <i>$name</i> selesai, data schedule boost <i>$name</i> bandwidth <i>upload ".$boost_bandwidth[0]." Mbps dan download ".$boost_bandwidth[1]." Mbps dihapus", 'from_server');
                                                                }
                                                            }
                                                        }elseif($boost->frequency=='Repeat'){
                                                            $day_start = explode(' ', $time_schedule[0]);
                                                            $day_end = explode(' ', $time_schedule[1]);
                                                            if($day>=$day_start[0]&&$day<=$day_end[0]){
                                                                if($hour>=explode(':', $day_start[1])[0]&&$hour<=explode(':', $day_end[1])[0]){
                                                                    if($max_limit!=$boost_limit&&$firewall_dis[0]=='true'){
                                                                        MikrotikAPI::single_set('simple', $id, 'limit', $boost_limit);
                                                                        Logging::log('boost_bandwidth', 1, "Kecepatan <i>$name</i> di boost dari bandwidth upload <i>".$up_limit." Mbps dan download ".$down_limit." Mbps</i> menjadi <i>upload ".$boost_bandwidth[0]." Mbps dan download ".$boost_bandwidth[1]." Mbps</i> sampai pukul <i>".$day_end[1]."</i>", 'from_server');
                                                                    }
                                                                    $boost_client[] = $id_client;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            if($category=='Kuota'){
                                                if(explode('/', $target)[1]==32){
                                                    $target = explode('/', $target)[0];
                                                }
                                                $status = $API->comm('/ip/firewall/filter/print', ['?src-address'=>"$target"])[0]['disabled'];
                                                if($status=='true'){
                                                    if(count($boost_client)<1&&$firewall_dis[0]=='true'){
                                                        if($max_limit!=$limit1){
                                                            MikrotikAPI::single_set('simple', $id, 'limit', $limit1);
                                                            Logging::log('reset_bandwidth', 1, "Pengembalian kecepatan <i>$name</i> ke kecepatan semula", 'from_server');
                                                        }
                                                    }
                                                    if((substr($input_date,0,16)!=substr($time,0,16))){
                                                        $usage += $bytes[0]+$bytes[1];

                                                        $comment .= '"renew":"'.$renew.'","input_date":"'.DATENOW.'","usage":"'.$usage.'"}';

                                                        if($upload>$minimal_bites || $download>$minimal_bites){
                                                            $API->comm('/queue/simple/set', [".id"=>"$id", "comment"=>"$comment"]);
                                                            $this->model('AllModel')->insert("usages","null, null, '$upload', '$download', '$id'");
                                                            Datafile::usage($upload, $download, $id);
                                                            echo '<h5 class="text-success">Success input client '.$name.'!</h5><br>';
                                                        }else{
                                                            $this->model('AllModel')->insert("usages","null, null, '0', '0', '$id'");
                                                            Datafile::usage(0, 0, $id);
                                                        }
                                                    }
                                                    if($renew>0){
                                                        $quota1 *= ($renew+1);
                                                    }
                                                    if(($usage/1000000000)>=$quota1){
                                                        $comment = '{"date":"'.$date.'","package":"'.$package.'","price":"'.$price.'","category":"'.$category.'","bandwidth":"'.$bandwidth1[0].'/'.$bandwidth1[1].'","quota":"'.$quota1.'","input_date":"'.DATENOW.'","usage":"0"}';
                                                        $API->comm('/queue/simple/set', [".id"=>"$id", "comment"=>"$comment"]);
                                                        $id_f = $API->comm('/ip/firewall/filter/print', ['?src-address'=>"$target"])[0]['.id'];
                                                        MikrotikAPI::single_set('firewall', $id_f, 'disabled', 'false');
                                                        Logging::log('nonactivated', 1, "Pemakaian <i>$name</i> sebesar ".Format::bytes($usage).", telah melampaui batasan kuota (".Format::bytes($quota1*1000000000)."). Internet dinonaktifkan", 'from_server');
                                                    }
                                                }
                                            }else{
                                                if((substr($input_date,0,16)!=substr($time,0,16))){
                                                    if(substr($input_date,0,7)==substr($time,0,7)){
                                                        $usage += $bytes[0]+$bytes[1];

                                                        if($category=='Regular'){
                                                            if($renew>0){
                                                                $comment .= '"renew":"'.$renew.'",';
                                                            }
                                                        }
                                                        
                                                        $comment .= '"input_date":"'.DATENOW.'","usage":"'.$usage.'"}';
                                                    }else{
                                                        $comment .= '"input_date":"'.DATENOW.'","usage":"0"}';
                                                    }

                                                    if($upload>$minimal_bites || $download>$minimal_bites){
                                                        $API->comm('/queue/simple/set', [".id"=>"$id", "comment"=>"$comment"]);
                                                        $this->model('AllModel')->insert("usages","null, null, '$upload', '$download', '$id'");
                                                        Datafile::usage($upload, $download, $id);
                                                        echo '<h5 class="text-success">Success input client '.$name.'!</h5><br>';
                                                    }else{
                                                        $this->model('AllModel')->insert("usages","null, null, '0', '0', '$id'");
                                                        Datafile::usage(0, 0, $id);
                                                    }
                                                }
                                                
                                                if(count($boost_client)<1&&$firewall_dis[0]=='true'){
                                                    
                                                    if($category=='Premium'){
                                                        if($max_limit!=$limit1){
                                                            MikrotikAPI::single_set('simple', $id, 'limit', $limit1);
                                                            Logging::log('reset_bandwidth', 1, "Pengembalian kecepatan <i>$name</i> ke kecepatan semula", 'from_server');
                                                        }
                                                    }
                    
                                                    if($category=='Regular'){
                                                        if($renew>0){
                                                            $quota1 *= ($renew+1);
                                                            $quota2 *= ($renew+1);
                                                        }
                                                        if(($usage/1000000000)<$quota1){
                                                            if($max_limit!=$limit1){
                                                                MikrotikAPI::single_set('simple', $id, 'limit', $limit1);
                                                                Logging::log('reset_bandwidth', 1, "Pengembalian kecepatan <i>$name</i> ke kecepatan awal", 'from_server');
                                                            }
                                                        }
                                                        elseif(($usage/1000000000)>=$quota1){
                                                            if(($usage/1000000000)>=$quota2){
                                                                if($max_limit!=$limit3){
                                                                    MikrotikAPI::single_set('simple', $id, 'limit', $limit3);
                                                                    Logging::log('fup2', 1, "Pemakaian <i>$name</i> sebesar ".Format::bytes($usage).", telah melampaui batas kuota kedua (".Format::bytes($quota2*1000000000)."). Kecepatan dialihkan ke kecepatan ketiga", 'from_server');
                                                                }
                                                            }
                                                            else{
                                                                if($max_limit!=$limit2){
                                                                    MikrotikAPI::single_set('simple', $id, 'limit', $limit2);
                                                                    Logging::log('fup1', 1, "Pemakaian <i>$name</i> sebesar ".Format::bytes($usage).", telah melampaui batas kuota pertama (".Format::bytes($quota1*1000000000)."). Kecepatan dialihkan ke kecepatan kedua", 'from_server');
                                                                }
                                                            }
                                                        }
                                                    }

                                                }
                                            }
                                        }
                                        $API->comm('/queue/simple/reset-counters-all');
                                    
                                        $max_usage = max($cek_normal_usage);
                                        $usg           = $db->query("SELECT * FROM log WHERE YEAR(time)='$year' AND MONTH(time)='$month' AND DAY(time)='$day' AND HOUR(time)='$hour' AND MINUTE(time)='$minutes' AND message='Perangkat dimulai ulang karena kesalahan aturan'");
                                        $usg           = $db->resultSet();
                                        if($max_usage<$minimal_bites&&count($usg)<1&&count($cek_normal_usage)>0){
                                            $data = $API->comm('/queue/simple/print');
                                            foreach($data as $r){
                                                $id = $r['.id'];
                                                $API->comm('/queue/simple/set', [".id"=>"$id", "disabled"=>"true"]);
                                            }
                                            foreach($data as $r){
                                                $id = $r['.id'];
                                                $API->comm('/queue/simple/set', [".id"=>"$id", "disabled"=>"false"]);
                                            }
                                            // Logging::log('error_rule', '1', 'Fix data calculation', 'from_server');
                                        }
                                    }
                                    $API -> disconnect();
                                }
                                Logging::log();

                                // max save graph usage
                                
                                $usage         = $db->query("SELECT DISTINCT MONTH(time) AS month FROM usages ORDER BY time ASC");
                                $usage         = $db->resultSet();
                                $min           = $db->query("SELECT MONTH(time) as month FROM usages ORDER BY time ASC");
                                $min           = $db->single();
                                $last          = $min->month;

                                if(count($usage)>11){
                                    $db->query("DELETE FROM usages WHERE MONTH(time)='$last'");
                                    $db->execute();
                                }
                            }
                        }
                    }
                
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="<?=BASEURL?>/js/ajax-jquery-3.4.1/jquery.min.js"></script>
    <script src="<?=BASEURL?>/js/sweatalert2/sweetalert2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/7qrbxnkdphzuvnmchzx0u6qnfiptzke1ui5awvuz1mg24wyy/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        setInterval(function(){
            $(".time").load(location.href + " .time");
        }, 1000);
        
        setInterval(function(){
            $(".input_pemakaian").load(location.href + " .input_pemakaian");
        }, 20000);
    </script>
</body>
</html>