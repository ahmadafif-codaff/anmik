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
<div class="d-flex dashboard mb-1 pt-3 justify-content-between rounded-2">
    <div class="d-flex flex-column shadow  col-md-3 bg-light radius-3 mt-3 rounded-1" style="height: 103px;">
        <div class="d-flex ms-1 me-1">
            <div class="me-1 bg-primary-dark rounded-1 shadow" style="width: 20%;margin-left:-10px;margin-top:-8px;"><h1 class="text-center text-light"><span class="bi-graph-up-arrow"></span></h1></div>
            <div class="mt-1 ms-1" style="width: 80%;">
                <h6 class="mb-1">Usage This Month</h6>
                <div class="card-usage">
                <img src="<?=BASEURL?>/img/loading.webp" alt="" style="width:60px;">
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column shadow  col-md-3 bg-light radius-3 mt-3 rounded-1" style="height: 103px;">
        <div class="d-flex ms-1 me-1">
            <div class="me-1 bg-warning rounded-1 shadow" style="width: 20%;margin-left:-10px;margin-top:-8px;"><h1 class="text-center text-light"><span class="bi-people-fill"></span></h1></div>
            <div class="mt-1 ms-1" style="width: 80%;">
                <h6 class="mb-1">Client Total</h6>
                <div class="d-flex text-secondary card-client">
                    <img src="<?=BASEURL?>/img/loading.webp" alt="" style="width:60px;">
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column shadow  col-md-3 bg-light radius-3 mt-3 rounded-1" style="height: 103px;">
        <div class="d-flex ms-1 me-1">
            <div class="me-1 bg-danger rounded-1 shadow" style="width: 20%;margin-left:-10px;margin-top:-8px;"><h1 class="text-center text-light"><span class="bi-hdd-stack-fill"></span></h1></div>
            <div class="mt-1 ms-1" style="width: 80%;">
                <h6 class="mb-1">Mikrotik Resource</h6>
                <div class="d-flex"  style="width: 100%;">
                    <div class="" style="width: 25%;">
                        <div class="mb-1" style="font-size: smaller;">CPU</div>
                        <div class="mb-1" style="font-size: smaller;">Memory</div>
                        <div class="mb-1" style="font-size: smaller;">HDD</div>
                    </div>
                    <div class="card-resource" style="width: 75%;">
                    <img src="<?=BASEURL?>/img/loading.webp" alt="" style="width:60px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
    
<div class="d-flex dashboard mb-1 pt-3 justify-content-between rounded-2">
    <div class="col-md-7 load-graph">
        <script src="<?=BASEURL?>/js/ajax-jquery-3.4.1/jquery.min.js"></script>
    
        <div class="bg-white d-flex flex-column shadow col-md-12 radius-3 mt-2 mb-4 rounded-1" style="height: 350px;">
            <div class="bg-light text-dark border p-2 d-flex justify-content-between rounded-1"><div class=""><span class="bi-graph-up-arrow"></span> Pemakaian <span class="name"><?=$data['name']?></span> <span class="day">Hari Ini</span></div><div><input class="border-0 bg-light" type="hidden" name="" id="address" disabled value="<?=Filter::request('', 'address')?>"><input class="bg-light border-0" type="date" name="date" id="date" value="<?=$data['date']?>" onchange="day_stat()"></div></div>
            <div class="d-flex align-items-end p-3 graph-daily" style="height:100%; width:100%; overflow-y:scroll;">
                <div class="d-flex justify-content-center align-items-center w-100 h-100">
                    <img src="<?=BASEURL?>/img/loading2.gif" alt="loading" style="width:50%;">
                </div>
            </div>
            <div class="bg-light text-dark border p-2 rounded-1">
                <div class="d-flex align-items-center total-daily">
                    <span class="bg-danger rounded" style="height:10px;width:10px;"></span>&nbsp;Downloads &nbsp;&nbsp;&nbsp;<span class="bg-primary-dark rounded" style="height:10px;width:10px;"></span>&nbsp;Uploads &nbsp;&nbsp;&nbsp;<span class="btn-bg-gradient-purple rounded" style="height:10px;width:10px;"></span>&nbsp;Total
                </div>
            </div>
        </div>
        <div class="bg-white d-flex flex-column shadow col-md-12 radius-3 mt-2 mb-4 rounded-1" style="height: 350px;">
            <div class="bg-light text-dark border p-2 d-flex justify-content-between rounded-1"><div class=""><span class="bi-graph-up-arrow"></span> Pemakaian <span class="name"><?=$data['name']?></span> <span class="month">Bulan Ini</span></div><div><input class="bg-light border-0" type="month" name="month" id="month" value="<?=substr($data['date'],0,7)?>" onchange="month_stat()"></div></div>
            <div class="d-flex align-items-end p-3 graph-monthly" style="height:100%; width:100%; overflow-y:scroll;">
                <div class="d-flex justify-content-center align-items-center w-100 h-100">
                    <img src="<?=BASEURL?>/img/loading2.gif" alt="loading" style="width:50%;">
                </div>
            </div>
            <div class="bg-light text-dark border p-2 rounded-1">
                <div class="d-flex align-items-center total-monthly">
                    <span class="bg-danger rounded" style="height:10px;width:10px;"></span>&nbsp;Downloads &nbsp;&nbsp;&nbsp;<span class="bg-primary-dark rounded" style="height:10px;width:10px;"></span>&nbsp;Uploads &nbsp;&nbsp;&nbsp;<span class="btn-bg-gradient-purple rounded" style="height:10px;width:10px;"></span>&nbsp;Total
                </div>
            </div>
        </div>
        <div class="bg-white d-flex flex-column shadow col-md-12 radius-3 mt-2 mb-4 rounded-1" style="height: 350px;">
            <div class="bg-light text-dark border p-2 d-flex justify-content-between rounded-1"><div class=""><span class="bi-graph-up-arrow"></span> Pemakaian <span class="name"><?=$data['name']?></span> 1 tahun terakhir </div></div>
            <div class="d-flex align-items-end p-3 graph-yearly" style="height:100%; width:100%; overflow-y:scroll;">
                <div class="d-flex justify-content-center align-items-center w-100 h-100">
                    <img src="<?=BASEURL?>/img/loading2.gif" alt="loading" style="width:50%;">
                </div>
            </div>
            <div class="bg-light text-dark border p-2 rounded-1">
                <div class="d-flex align-items-center total-yearly">
                    <span class="bg-danger rounded" style="height:10px;width:10px;"></span>&nbsp;Downloads &nbsp;&nbsp;&nbsp;<span class="bg-primary-dark rounded" style="height:10px;width:10px;"></span>&nbsp;Uploads &nbsp;&nbsp;&nbsp;<span class="btn-bg-gradient-purple rounded" style="height:10px;width:10px;"></span>&nbsp;Total
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 radius-3 mt-2 pb-2 rounded-1" style="height:fit-content;">
    
        <div class="bg-white d-flex flex-column shadow col-md-12 radius-3 rounded-1 mb-4" style="height: 350px;">
            <div class="bg-light text-dark border p-2 d-flex justify-content-between rounded-1"><div class=""><span class="bi-graph-up-arrow"></span> Traffic Monitor <span class="name"><?=$data['name']?></span></div></div>
            <div class="d-flex align-items-end p-3 traffic-monitor" style="height:100%; width:100%; overflow-y:scroll;">
                <div class="d-flex justify-content-center align-items-center w-100 h-100">
                    <img src="<?=BASEURL?>/img/loading2.gif" alt="loading" style="width:50%;">
                </div>
            </div>
            <div class="bg-light text-dark border p-2 rounded-1">
                <div class="mb-1 tx-rx">
                    <span class="text-danger bi-download"></span> rx &nbsp; <span class="text-primary bi-upload"></span> tx 
                </div>
            </div>
        </div>
        <div class="bg-white d-flex flex-column shadow col-md-12 radius-3 rounded-1 mb-4 pb-1">
            <div class="bg-light text-dark border p-2 d-flex justify-content-between align-items-center rounded-1"><div class=""><span class="bi-activity"></span> Client</div><span class="col-md-10" style="height: 30px; margin-top:-5px;"><?=Menu::search('no', 'load')?></span></div>
            <div class="border d-flex flex-wrap justify-content-between">
                <div class="ps-2 pt-2">
                    <div class="input-group align-items-center border rounded ps-2" style="height: fit-content; width: fit-content;">
                        <span class="bi-download"></span>
                        <select class="btn btn-sm" name="" id="speed_display" onchange="speed_display()">
                            <option value="hide">Hide Speed</option>
                            <option <?php if($_COOKIE['speed_display']=='show'){echo 'selected';}?> value="show">Show Speed</option>
                        </select>
                    </div>
                </div>
                <div class="ps-2 pt-2 pe-1">
                    <?=Menu::sort('load', ['usage_real','name'], 'DESC')?>
                </div>
            </div>
            <div class="ps-2 pe-2 overflow-auto client-list" style="height: 450px;">
                <img src="<?=BASEURL?>/img/loading2.gif" alt="loading" class="mt-5" style="width:100%;">
            </div>
        </div>
    </div>
</div>