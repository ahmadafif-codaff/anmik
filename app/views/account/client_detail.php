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
<h4 class="text-secondary"><?= ucwords(PATHURL_ND.' '.PATHURL_ST) ?></h4><br>
    <div class="rounded bg-white p-3 shadow overflow-auto">
        <div class="mb-3">
            <label for="">Tanggal (old <?=json_decode($data['client'][0]['comment'])->date?>)</label>
            <input type="datetime-local" name="tanggal" class="form-control" placeholder="tanggal" id="tanggal" value="<?=json_decode($data['client'][0]['comment'])->date?>">
            <div class="text-danger" id="if-tanggal"></div>
        </div>
        <div class="mb-3">
            <label for="">Nama (old <?=$data['client'][0]['name']?>)</label>
            <input type="text" name="nama" class="form-control" placeholder="nama" id="nama" value="<?=$data['client'][0]['name']?>">
            <div class="text-danger" id="if-nama"></div>
        </div>
        <div class="mb-3">
            <label for="">Paket (old <?=json_decode($data['client'][0]['comment'])->package?>)</label><br>
            <div class="client-paket"><input type="hidden" name="" id="paket" disabled><img src="<?=BASEURL?>/img/loading.webp" alt="" style="width:60px;"></div>
            <div class="text-danger" id="if-paket"></div>
        </div>
        <div class="paket">
        </div>
        <div class="mb-3">
            <label for="">IP Target (old <?=$data['client'][0]['target']?>)</label><br>
            <div class="client-target"><input type="hidden" name="" id="target" disabled><img src="<?=BASEURL?>/img/loading.webp" alt="" style="width:60px;"></div>
            <div class="text-danger" id="if-target"></div>
        </div>
        <div class="mb-3">
            <label for="">Parent (old <?=$data['client'][0]['parent']?>)</label><br>
            <div class="client-parent"><input type="hidden" name="" id="parent" disabled><img src="<?=BASEURL?>/img/loading.webp" alt="" style="width:60px;"></div>
            <div class="text-danger" id="if-parent"></div>
        </div>
        <br>
        <div class="mt-2 mb-2 border-bottom"></div>
        <div class="text-end">
            <a href="<?=BASEURL.'/'.PATHURL_ST?>" class="btn btn-sm btn-secondary">Back</a>
            <button type="submit" class="btn btn-sm btn-primary" onclick="add_ed('edit','<?=$data['client'][0]['.id']?>','')">Save</button>
        </div>
    </div>