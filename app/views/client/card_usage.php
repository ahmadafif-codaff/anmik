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

$data = json_decode(json_encode($data)) ?>
<div class="d-flex text-secondary">
    <h3 class="pe-2">
    <?=$data->usage->usage[0]?>
    </h3>
    <p><?=$data->usage->usage[1]?></p>
</div>
<div class="bg-secondary rounded-3" style="width: 100%; height: 5px;"></div>
<div class="status_bandwith <?=$data->usage->bg?> rounded-3" style="width:<?=$data->usage->status_usage?>%; height: 5px; margin-top: -5px;"></div>