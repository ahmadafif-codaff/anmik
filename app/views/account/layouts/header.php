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
    <title><?=$data['title']?> - ANMIK</title>
    <style>
        .col-md-7{
            width:65.5%;
        }
        .col-md-3{
            width:32%;
        }
    </style>
</head>
<body class="bg-light-blue">
        <nav class="navbar navbar-expand-lg bg-white shadow-sm">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn border-0">
                <div id="humberger-side">
                    <div class="humberger-side-stik bg-secondary"></div>
                    <div class="humberger-side-stik bg-secondary"></div>
                    <div class="humberger-side-stik bg-secondary"></div>
                </div>
                </button>
                <a href="<?=BASEURL?>" class="d-flex">
                    <img src="<?=BASEURL?>/img/logo.png" alt="" style="width:40px;" class="drop-shadow">
                    <h4 class="text-secondary m-auto"> ANMIK</h4>
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="w-100 d-flex justify-content-end text-secondary reload_time">
                        <div class="border-start p-2 ms-1" title="uptime"><span class="bi-hourglass-bottom"></span> --:--:--</div>
                        <div class="border-start p-2 ms-1" title="session"><span class="bi-stopwatch"></span> --:--:--</div>
                        <div class="border-start p-2 ms-1" title="time"><span class="bi-clock"></span> --:--:--</div>
                    </div>
                    <?php if(!in_array(PATHURL_ST, ['dashboard','pengaturan'])&&PATHURL_ND!='detail'): ?>
                        <div class="border-start p-2 ms-1 pointer" title="reload data" id="btn_load" style="width: fit-content; height:fit-content;" onclick="load_data()"><input type="hidden" id="val_load" name="" value="0"><div class="bi-arrow-repeat" id="icon_load"></div></div>
                    <?php else: ?>
                        <a href="" class="border-start p-2 ms-1 pointer" title="reload data" id="btn_load" style="width: fit-content; height:fit-content;"><input type="hidden" id="val_load" name="" value="0"><div class="bi-arrow-repeat" id="icon_load"></div></a>
                    <?php endif ?>
                </div>
            </div>
        </nav>
    <div class="d-flex wh-100 vh-100 overflow-hidden"  style="margin-top:-56px; padding-top:56px; font-size: smaller;">
        <nav id="sidebar" class="overflow-auto text-secondary overflow-scroll">
            <div class="sidebar-header text-center d-flex flex-column align-items-center">
                <br>
                <div class="border rounded-5 d-flex justify-content-center align-items-center" style="height: 60px; width: 60px;">
                    <img src="<?=BASEURL?>/img/logo.png" alt="logo" style="width:100%;" class="drop-shadow">
                </div>
                <h5 class="text-secondary"><?=$data['user']->nama?></h5>
            </div>
            <div class="mt-1 mb-1 border-bottom border-2"></div>
            <ul class="list-unstyled components overflow-auto" style="height: 65%;">
                <li class="<?php if(PATHURL_ST=='dashboard'){echo "active";} ?>">
                    <a class="text-decoration-none m-1" style="border-radius: 5px 15px 5px 15px;" href="<?=BASEURL?>/dashboard"><span class="bi-speedometer2"></span> Dashboard</a>
                </li>
                <li class="<?php if(PATHURL_ST=='paket'){echo "active";} ?>">
                    <a class="text-decoration-none m-1" style="border-radius: 5px 15px 5px 15px;" href="<?=BASEURL?>/paket"><span class="bi-box"></span> Paket</a>
                </li>
                <div class="mt-1 mb-1 border-bottom border-2"></div>
                <li class="<?php if(in_array(PATHURL_ST, ['firewall','dhcp'])){echo "active";} ?>">
                    <a class="text-decoration-none m-1" style="border-radius: 5px 15px 5px 15px;" href="#homeSubmenu" data-bs-toggle="collapse" data-bs-target="#menu-collapse-2" aria-expanded="<?php if(in_array(PATHURL_ST, ['firewall','dhcp'])){echo "true";}else{echo "false";} ?>" class="dropdown-toggle"><div class="d-flex justify-content-between"><div class="d-flex"><span class="bi-hdd-network"></span>&nbsp;IP</div> <span class="bi-chevron-down"></span></div></a>
                    <ul class="collapse list-unstyled <?php if(in_array(PATHURL_ST, ['firewall','dhcp'])){echo "show";} ?>" id="menu-collapse-2">
                        <li class="<?php if(PATHURL_ST=='dhcp'){echo "select";} ?>" >
                            <a class="text-decoration-none m-1" style="border-radius: 5px 15px 5px 15px;" href="<?=BASEURL?>/dhcp"><span class="bi bi-pc-display-horizontal"></span> DHCP Lease</a>
                        </li>
                        <li class="<?php if(PATHURL_ST=='firewall'){echo "select";} ?>" >
                            <a class="text-decoration-none m-1" style="border-radius: 5px 15px 5px 15px;" href="<?=BASEURL?>/firewall"><span class="bi bi-bricks"></span> Firewall</a>
                        </li> 
                    </ul>
                </li>
                <li class="<?php if(PATHURL_ST=='client'){echo "active";} ?>">
                    <a class="text-decoration-none m-1" style="border-radius: 5px 15px 5px 15px;" href="<?=BASEURL?>/client"><span class="bi-people"></span> Clients</a>
                </li>
                <li class="<?php if(in_array(PATHURL_ST, ['schedule','reboot'])){echo "active";} ?>">
                    <a class="text-decoration-none m-1" style="border-radius: 5px 15px 5px 15px;" href="#homeSubmenu" data-bs-toggle="collapse" data-bs-target="#menu-collapse" aria-expanded="<?php if(in_array(PATHURL_ST, ['schedule','reboot'])){echo "true";}else{echo "false";} ?>" class="dropdown-toggle"><div class="d-flex justify-content-between"><div class="d-flex"><span class="bi-cpu"></span>&nbsp;Management</div> <span class="bi-chevron-down"></span></div></a>
                    <ul class="collapse list-unstyled <?php if(in_array(PATHURL_ST, ['schedule','reboot'])){echo "show";} ?>" id="menu-collapse">
                        <li class="<?php if(in_array(PATHURL_ST, ['schedule','boost'])){echo "active";} ?>">
                            <a class="text-decoration-none m-1" style="border-radius: 5px 15px 5px 15px;" href="#homeSubmenu" data-bs-toggle="collapse" data-bs-target="#menu-collapse-3" aria-expanded="<?php if(in_array(PATHURL_ST, ['schedule'])){echo "true";}else{echo "false";} ?>" class="dropdown-toggle"><div class="d-flex justify-content-between"><div class="d-flex"><span class="bi-clock-history"></span>&nbsp;Schedule</div> <span class="bi-chevron-down"></span></div></a>
                            <ul class="collapse list-unstyled <?php if(in_array(PATHURL_ST, ['schedule'])){echo "show";} ?>" id="menu-collapse-3">
                                <li class="<?php if(PATHURL_ND=='reboot'){echo "select";} ?>" >
                                    <a class="text-decoration-none m-1 ps-5" style="border-radius: 5px 15px 5px 15px;" href="<?=BASEURL?>/schedule/reboot"><span class="bi bi-arrow-clockwise"></span> Reboot</a>
                                </li>
                                <li class="<?php if(PATHURL_ND=='boost'){echo "select";} ?>" >
                                    <a class="text-decoration-none m-1 ps-5" style="border-radius: 5px 15px 5px 15px;" href="<?=BASEURL?>/schedule/boost"><span class="bi bi-speedometer"></span> Boost Limit</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if(PATHURL_ST=='reboot'){echo "select";} ?>" >
                            <a class="text-decoration-none m-1 pointer" style="border-radius: 5px 15px 5px 15px;" onclick="return reboot_mikrotik()"><span class="bi bi-power"></span> Reboot Mikrotik</a>
                        </li> 
                    </ul>
                </li>
                <div class="mt-1 mb-1 border-bottom border-2"></div>
                <li class="<?php if(PATHURL_ST=='log'){echo "active";} ?>">
                    <a class="text-decoration-none m-1" style="border-radius: 5px 15px 5px 15px;" href="<?=BASEURL?>/log"><span class="bi-activity"></span> History & Log</a>
                </li>
                <li class="<?php if(PATHURL_ST=='pengaturan'){echo "active";} ?>">
                    <a class="text-decoration-none m-1" style="border-radius: 5px 15px 5px 15px;" href="<?=BASEURL?>/pengaturan"><span class="bi-gear"></span> Settings</a>
                </li>
                <div class="mt-1 mb-1 border-bottom border-2"></div>
                <li>
                    <a class="text-decoration-none m-1" style="border-radius: 5px 15px 5px 15px;" id="logout" onclick="return logout()"><span class="bi-box-arrow-left"></span> Logout</a>
                </li>
            </ul>
        </nav>
            
        <div id="content" class="overflow-auto p-4">
            <div class="col-md-12 row justify-content-between">
                <?php if(!in_array(PATHURL_ST, ['dashboard','pengaturan'])&&PATHURL_ND!='detail'): ?>
                <div class="col-md-5 mb-3">
                    <?php if(PATHURL_ST=='dhcp'):?>
                        <?=Menu::search('no', 'load', ['address','mac_address','server','host_name','status','status_static','client_name'])?>
                    <?php elseif(PATHURL_ST=='firewall'):?>
                        <?=Menu::search('no', 'load', ['address','firewall_status','client_status','type','client_name'])?>
                    <?php elseif(PATHURL_ST=='client'):?>
                        <?=Menu::search('no', 'load',['name','target','date','download','upload','usage','quota','package','category','price','status'])?>
                    <?php else:?>
                        <?=Menu::search('no', 'load')?>
                    <?php endif?>
                </div>
                <?php endif ?>
                <div class="col-md-6 row justify-content-end">
                    <?php if(PATHURL_ST =='firewall'&&PATHURL_ND!='detail'): ?>
                    <div class="form-group bg-danger rounded text-light me-1 mb-3" style="width: fit-content; height:fit-content;">
                        <span class="bi bi-trash"></span>
                        <select class="btn btn-sm btn-danger text-start" name="" id="address-pool-delete" onchange="return address_pool('delete')" style="width: fit-content;">
                            <option value="">Delete Firewall</option>
                                <?php
                                    foreach($data['dhcp-pool'] as $r){
                                        $address_pool = $r['address-pool'];
                                        echo'<option value="'.$r['interface'].' '.$r['address-pool'].'">'.$r['interface'].'</option>';
                                    }
                                ?>
                        </select>
                    </div>
                    <div class="form-group bg-success rounded text-light me-1 mb-3" style="width: fit-content; height:fit-content;">
                        <span class="bi bi-printer"></span>
                        <select class="btn btn-sm btn-success text-start" name="" id="address-pool" onchange="return address_pool()" style="width: fit-content;">
                            <option value="">Generate Firewall</option>
                                <?php
                                    foreach($data['dhcp-pool'] as $r){
                                        $address_pool = $r['address-pool'];
                                        echo'<option value="'.$r['interface'].' '.$r['address-pool'].'">'.$r['interface'].'</option>';
                                    }
                                ?>
                        </select>
                    </div>
                    <?php endif ?>
                    <?php if(PATHURL_ST=='schedule'&&PATHURL_ND!='detail'): ?>
                    <div class="form-group bg-success rounded text-light me-1 mb-3" style="width: fit-content; height:fit-content;">
                        <span class="bi bi-stopwatch"></span>
                        <select class="btn btn-sm btn-success text-start" name="" id="schedule-input" style="width: fit-content;">
                            <option>Schedule Input (<?=$data['input']->time?> M)</option>
                            <option value="2">2 Minutes</option>
                            <option value="5">5 Minutes</option>
                            <option value="10">10 Minutes</option>
                            <option value="20">20 Minutes</option>
                        </select>
                    </div>
                    <?php endif ?>
                    <?php if(!in_array(PATHURL_ST, ['dashboard','pengaturan'])&&PATHURL_ND!='detail'): ?>
                    <?php if(PATHURL_ST=='paket'):?>
                        <?=Menu::sort('load', ['id_paket', 'nama','harga','kategori','max_upload','max_download', 'bandwidth_kedua', 'bandwidth_ketiga', 'kuota', 'kuota_kedua'])?>
                    <?php elseif(PATHURL_ST=='dhcp'):?>
                        <?=Menu::sort('load', ['address_num','mac_address','server','host_name','status', 'status_static'])?>
                    <?php elseif(PATHURL_ST=='firewall'):?>
                        <?=Menu::sort('load', ['address_num','firewall_status', 'client_status', 'type'])?>
                    <?php elseif(PATHURL_ST=='client'):?>
                        <?=Menu::sort('load',['name','target','date','download_num','upload_num','usage_sub','quota_sub','package','category','price_sub','status'])?>
                    <?php elseif(PATHURL_ST=='schedule'):?>
                        <?=Menu::sort('load',['id_schedule','frequency'])?>
                    <?php elseif(PATHURL_ST=='log'):?>
                        <?=Menu::sort('load',['time','ip', 'browser', 'so', 'action', 'status', 'message'], 'DESC')?>
                    <?php endif?>
                        <?=Menu::row('load')?>
                    <?php endif ?>
                    <?php if(!in_array(PATHURL_ST, ['dashboard','log','pengaturan','dhcp'])&&PATHURL_ND!='detail'): ?>
                    <button class="btn btn-sm  btn-primary w-auto mb-3" style="height: fit-content" data-bs-toggle="modal" data-bs-target="#Modal"><span class="bi bi-plus-circle"></span> Input Data</button>
                    <?php endif ?>
                </div>
            </div>
