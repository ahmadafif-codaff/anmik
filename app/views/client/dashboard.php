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
    