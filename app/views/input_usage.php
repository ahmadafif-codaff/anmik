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
                                Logging::log('reboot_mikrotik', 1, "Mulai ulang perangkat terjadwal", '@from_server');
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
                    // var_dump($data['pelanggan']); 
                    $time = date('Y-m-d H:i:s');
                    $year = date('Y');
                    $month = date('m');
                    $day = date('d');
                    $hour = date('H');
                    $minutes = date('i');
                    $input_menit   = $data['input']->time;
                    $minimal_bytes = 1000;

                    for($x=0; $x<60; $x++){
                        if($x%$input_menit == 0){
                            if($minutes==$x){
                                // var_dump($data['pelanggan']); 

                                $db = new Database;
                                
                                $cek = $db->query("SELECT * FROM usages WHERE YEAR(time)='$year' AND MONTH(time)='$month' AND DAY(time)='$day' AND HOUR(time)='$hour' AND MINUTE(time)='$minutes'");
                                $cek = $db->resultSet();

                                if(count($cek)<1){
                                    $cek_normal_usage = [];

                                    $data = MikrotikAPI::all('simple');
                                    foreach($data as $r){
                                        $id = $r['.id'];
                                        $name = $r['name'];
                                        $comment = $r['comment'];
                                        $target = $r['target'];
                                        $max_limit = $r['max-limit'];
                                        $bytes = explode('/',$r['bytes']);
        
                                        $p = json_decode($comment);
                                        $date = $p->date; 
                                        $package = $p->package; 
                                        $price = $p->price; 
                                        $category = $p->category; 
                                        $bandwidth = explode('/',$p->bandwidth); 
                                        $bandwidth2 = explode('/',$p->bandwidth2); 
                                        $bandwidth3 = explode('/',$p->bandwidth3); 
                                        $quota = $p->quota; 
                                        $quota2 = $p->quota2; 
                                        $renew = $p->renew; 
                                        $input_date = $p->input_date; 
                                        $usage = $p->usage;
                                        
                                        $limit = ($bandwidth[0]*1000000).'/'.($bandwidth[1]*1000000);
                                        $limit2 = ($bandwidth2[0]*1000000).'/'.($bandwidth2[1]*1000000);
                                        $limit3 = ($bandwidth3[0]*1000000).'/'.($bandwidth3[1]*1000000);
        
                                        $comment = '{"date":"'.$date.'","package":"'.$package.'","price":"'.$price.'","category":"'.$category.'","bandwidth":"'.$bandwidth[0].'/'.$bandwidth[1].'","bandwidth2":"'.$bandwidth2[0].'/'.$bandwidth2[1].'","bandwidth3":"'.$bandwidth3[0].'/'.$bandwidth3[1].'","quota":"'.$quota.'","quota2":"'.$quota2.'",';
                                        $upload = $bytes[0];
                                        $download = $bytes[1];

                                        $cek_normal_usage[] = $upload+$download;
                                            
                                        if($category=='Kuota'){
                                            if(explode('/', $target)[1]==32){
                                                $target = explode('/', $target)[0];
                                            }
                                            $status = MikrotikAPI::get('firewall', 'src-address', $target, 'disabled');
                                            if($status=='true'){
                                                if($max_limit!=$limit){
                                                    MikrotikAPI::single_set('simple', $id, 'limit', $limit);
                                                    Logging::log('reset_bandwidth', 1, "Pengembalian kecepatan <i>$name</i> ke kecepatan semula", '@from_server');
                                                }
                                                if((substr($input_date,0,16)!=substr($time,0,16))){
                                                    $usage += $bytes[0]+$bytes[1];

                                                    $comment .= '"renew":"'.$renew.'","input_date":"'.DATENOW.'","usage":"'.$usage.'"}';

                                                    if($upload>$minimal_bytes || $download>$minimal_bytes){
                                                        MikrotikAPI::single_set('simple', $id, 'comment', $comment);
                                                        $this->model('AllModel')->insert("usages","null, null, '$upload', '$download', '$id'");
                                                        echo '<h5 class="text-success">Success input client '.$name.'!</h5><br>';
                                                        MikrotikAPI::reset_simple($id);
                                                    }
                                                }
                                                if(($usage/1000000000)>=$quota){
                                                    $id_f = MikrotikAPI::get('firewall', 'src-address', $target, '.id');
                                                    MikrotikAPI::single_set('firewall', $id_f, 'disabled', 'false');
                                                    Logging::log('nonactivated', 1, "Pemakaian <i>$name</i> sudah melampaui batas kuota, internet dinonaktifkan", '@from_server');
                                                }
                                            }
                                        }else{
                                            if((substr($input_date,0,16)!=substr($time,0,16))){
                                                if(substr($input_date,0,7)==substr($time,0,7)){
                                                    $usage += $bytes[0]+$bytes[1];
                                                    
                                                    $comment .= '"renew":"'.$renew.'","input_date":"'.DATENOW.'","usage":"'.$usage.'"}';
                                                }else{
                                                    $comment .= '"renew":"0","input_date":"'.DATENOW.'","usage":"0"}';
                                                }

                                                if($upload>$minimal_bytes || $download>$minimal_bytes){
                                                    MikrotikAPI::single_set('simple', $id, 'comment', $comment);
                                                    $this->model('AllModel')->insert("usages","null, null, '$upload', '$download', '$id'");
                                                    echo '<h5 class="text-success">Success input client '.$name.'!</h5>';
                                                    MikrotikAPI::reset_simple($id);
                                                }
                                            }
        
                                            if($category=='Premium'){
                                                if($hour<5){
                                                    $limit2 = ($bandwidth[0]*400000).'/'.($bandwidth[1]*400000);
                                                    if($max_limit!=$limit2&&explode('/',$max_limit)[1]>1000000){
                                                        MikrotikAPI::single_set('simple', $id, 'limit', $limit2);
                                                        // Logging::log('reset_bandwidth', 1, "Pengembalian kecepatan $name ke kecepatan semula", '@from_server');
                                                    }
                                                }else{
                                                    if($max_limit!=$limit){
                                                        MikrotikAPI::single_set('simple', $id, 'limit', $limit);
                                                        // Logging::log('reset_bandwidth', 1, "Pengembalian kecepatan $name ke kecepatan semula", '@from_server');
                                                    }
                                                }
                                            }
            
                                            if($category=='Regular'){
                                                if($renew>0){
                                                    $quota *= $renew+1;
                                                    $quota2 *= $renew+1;
                                                }
                                                if(($usage/1000000000)<$quota){
                                                    if($max_limit!=$limit){
                                                        MikrotikAPI::single_set('simple', $id, 'limit', $limit);
                                                        Logging::log('reset_bandwidth', 1, "Pengembalian kecepatan $name ke kecepatan semula", '@from_server');
                                                    }
                                                }
                                                elseif(($usage/1000000000)>=$quota){
                                                    if(($usage/1000000000)>=$quota2){
                                                        if($max_limit!=$limit3){
                                                            MikrotikAPI::single_set('simple', $id, 'limit', $limit3);
                                                            Logging::log('fup2', 1, "Pemakaian <i>$name</i> melewati batas kedua", '@from_server');
                                                        }
                                                    }
                                                    else{
                                                        if($max_limit!=$limit2){
                                                            MikrotikAPI::single_set('simple', $id, 'limit', $limit2);
                                                            Logging::log('fup1', 1, "Pemakaian <i>$name</i> melewati batas pertama", '@from_server');
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    $max_usage = max($cek_normal_usage);
                                    $usg           = $db->query("SELECT * FROM log WHERE YEAR(time)='$year' AND MONTH(time)='$month' AND DAY(time)='$day' AND HOUR(time)='$hour' AND MINUTE(time)='$minutes' AND message='Perangkat dimulai ulang karena kesalahan aturan'");
                                    $usg           = $db->resultSet();
                                    if($max_usage<$minimal_bytes&&count($usg)<1){
                                        Logging::log('reboot_mikrotik', 1, "Perangkat dimulai ulang karena kesalahan aturan", '@from_server');
                                        MikrotikAPI::reboot();
                                    }
                                }

                                // max save graph usage
                                
                                $usage         = $db->query("SELECT DISTINCT MONTH(time) AS month FROM usages ORDER BY time ASC");
                                $usage         = $db->resultSet();
                                $min           = $db->query("SELECT MONTH(time) as month FROM usages ORDER BY time ASC");
                                $min           = $db->single();
                                $last          = $min->month;

                                if(count($usage)>11){
                                    $delete         = $db->query("DELETE FROM usages WHERE MONTH(time)='$last'");
                                    $delete         = $db->execute();
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