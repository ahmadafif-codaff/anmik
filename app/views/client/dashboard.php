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
                <h6 class="mb-1">Usage</h6>
                <div class="card-usage">
                <img src="<?=BASEURL?>/img/loading.webp" alt="" style="width:60px;">
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column shadow  col-md-3 bg-light radius-3 mt-3 rounded-1" style="height: 103px;">
        <div class="d-flex ms-1 me-1">
            <div class="me-1 bg-warning rounded-1 shadow" style="width: 20%;margin-left:-10px;margin-top:-8px;"><h1 class="text-center text-light"><span class="bi-box-fill"></span></h1></div>
            <div class="mt-1 ms-1" style="width: 80%;">
                <h6 class="mb-1">Package</h6>
                <div class="d-flex text-secondary card-package">
                    <img src="<?=BASEURL?>/img/loading.webp" alt="" style="width:60px;">
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column shadow  col-md-3 bg-light radius-3 mt-3 rounded-1" style="height: 103px;">
        <div class="d-flex ms-1 me-1">
            <div class="me-1 bg-success rounded-1 shadow" style="width: 20%;margin-left:-10px;margin-top:-8px;"><h1 class="text-center text-light"><span class="bi-arrow-clockwise"></span></h1></div>
            <div class="mt-1 ms-1" style="width: 80%;">
                <h6 class="mb-1">Renew</h6>
                <div class="d-flex text-secondary card-renew">
                    <img src="<?=BASEURL?>/img/loading.webp" alt="" style="width:60px;">
                </div>
            </div>
        </div>
    </div>

</div>

    
<div class="d-flex fullwide mb-1 pt-3 justify-content-between rounded-2">
    <div class="col-md-12 load-graph">
        <script src="<?=BASEURL?>/js/ajax-jquery-3.4.1/jquery.min.js"></script>
    
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
    </div>
</div>
    