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
    ******************************************client_li
*/
?>
<table class="w-100 table table-hover">
    <?php 
        foreach($data['client'] as $r): 
    ?> 
    <tr>
        <td>
            <div class="d-flex flex-column shadow  col-md-12 bg-light radius-3 rounded-1" style="height: 103px;">
                <div class="d-flex ms-1 me-1">
                    <div class="me-1 <?=$r->data->card?> rounded-1 shadow" style="width: 20%;"><h1 class="text-center text-light"><span class="bi-person-fill"></span></h1></div>
                    <div class="mt-1 ms-1" style="width: 80%;">
                        <h6 class="mb-1 d-flex justify-content-between"><div class=""><?=$r->data->name?></div><div class="btn btn-sm <?=$r->data->btn?>" style="font-size:x-small;"><?=$r->data->category?></div></h6>
                        <div class="d-flex text-secondary">
                            <h3 class="pe-2">
                                <?=$r->data->usage[0]?>
                            </h3>
                            <p><?=$r->data->usage[1]?></p>
                        </div>
                        <div class="bg-secondary rounded-3" style="width: 100%; height: 5px;"></div>
                        <div class="status_bandwith <?=$r->data->bg?> rounded-3" style="width:<?=$r->data->status_usage?>%; height: 5px; margin-top: -5px;"></div>
                        <a href="?address=<?=$r->data->target?>" class="pointer">Usage Statistic</a>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <?php endforeach ?>
    <?php if(count($data['client'])==0): ?>
    <tr>
        <td class="text-center" colspan="15">Tidak ada data ditemukan</td>
    </tr>
    <?php endif ?>
</table>