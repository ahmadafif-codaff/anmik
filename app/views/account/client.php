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
<table class="table table-sm table-hover">
    <tr>
        <th rowspan="2" class="text-center align-middle">No</th>
        <th rowspan="2" class="text-center align-middle">Tanggal Gabung</th>
        <th rowspan="2" class="text-center align-middle">Nama</th>
        <th rowspan="2" class="text-center align-middle">IP Target</th>
        <th class="text-center align-middle" colspan="2">Limit</th>
        <th rowspan="2" class="text-center align-middle">Pemakaian</th>
        <th rowspan="2" class="text-center align-middle">Penurunan <br> Setelah</th>
        <th rowspan="2" class="text-center align-middle">Paket</th>
        <th rowspan="2" class="text-center align-middle">Pembayaran</th>
        <th rowspan="2" class="text-center align-middle">Status</th>
        <th rowspan="2" class="text-center align-middle">Aksi</th>
    </tr>
    <tr>
        <th class="text-center">Download</th>
        <th class="text-center">Upload</th>
    </tr>
    <?php 
        $no = $data['start']+1; foreach ($data['client'] AS $r):
    ?>
    <tr class="<?=$r->bg?>">
        <td><?=$no?></td>
        <td><?=$r->date?></td>
        <td><?=$r->name?></td>
        <td><?=$r->target?></td>
        <td><?=$r->download?></td>
        <td><?=$r->upload?></td>
        <td><?=$r->usage?></td>
        <td class="<?=$r->text?>"><?=$r->quota?></td>
        <td><?=$r->package.' ('.$r->category.')'?></td>
        <td><?=$r->price?></td>
        <td><?=$r->status?></td>
        <td>
            <?php if($r->status=='Blocked Access'):?>
            <button class="btn btn-sm btn-secondary m-1" data-bs-toggle="tooltip" title="disable"><span class="bi-dash-circle"></span></button>
            <button class="btn btn-sm btn-primary m-1" onclick="set_action('status', '<?=$r->id_f?>', 'true', '<?=Filter::request('', 'search')?>', '<?=Filter::request('', 'search_by')?>',  <?=Filter::request(1, 'page')?>)" data-bs-toggle="tooltip" title="enable"><span class="bi-check-circle"></span></button>
            <?php else:?>
            <button class="btn btn-sm btn-secondary m-1" onclick="set_action('status', '<?=$r->id_f?>', 'false', '<?=Filter::request('', 'search')?>', '<?=Filter::request('', 'search_by')?>',  <?=Filter::request(1, 'page')?>)" data-bs-toggle="tooltip" title="disable"><span class="bi-dash-circle"></span></button>
            <button class="btn btn-sm btn-primary m-1" data-bs-toggle="tooltip" title="enable"><span class="bi-check-circle"></span></button>
            <?php endif;?>
            <?php if(($r->category=='Regular'&&$r->usage_sub>($r->renew+1)*$r->quota_sub)||$r->category=='Kuota'):?>
            <button class="btn btn-sm btn-success m-1" onclick="return set_action('renew', '<?=$r->id?>', 'true', '<?=Filter::request('', 'search')?>', '<?=Filter::request('', 'search_by')?>',  <?=Filter::request(1, 'page')?>)" data-bs-toggle="tooltip" title="renew"><span class="bi-arrow-clockwise"></span></button>
            <?php else:?>
                <button class="btn btn-sm btn-secondary m-1" data-bs-toggle="tooltip" title="renew"><span class="bi-arrow-clockwise"></span></button>
            <?php endif;?>
            <a href="<?=BASEURL.'/'.PATHURL_EXPL[0]?>/detail/<?=$r->id?>" class="btn-sm btn text-light btn-warning bi bi-pencil-square m-1" title="edit"></a>
            <a class="btn btn-sm btn-danger m-1 drop" onclick="return delete_confirm('<?=$r->id?>', '<?=Filter::request('', 'search')?>', '<?=Filter::request('', 'search_by')?>',  <?=Filter::request(1, 'page')?>)"><span class="bi bi-x-square" title="delete"></span></a>
        </td>
        <td></td>
    </tr>
    <?php $no++; endforeach ?>
    <?php if(count($data['client'])==0): ?>
    <tr>
        <td class="text-center" colspan="15">Tidak ada data ditemukan</td>
    </tr>
    <?php endif ?>
</table>

<script src="<?=BASEURL?>/js/ajax-jquery-3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('.client-paket').load('<?=BASEURL?>/client/paket');
        $('.client-target').load('<?=BASEURL?>/client/target');
        $('.client-parent').load('<?=BASEURL?>/client/parent');
    })
</script>
<!-- Modal Input-->
<div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-5" id="ModalLabel" style="font-size: large">Input Data</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="">Tanggal</label>
                    <input type="datetime-local" name="tanggal" class="form-control" placeholder="tanggal" id="tanggal" value="">
                    <div class="text-danger" id="if-tanggal"></div>
                </div>
                <div class="mb-3">
                    <label for="">Nama</label>
                    <?php if(count($data['client'])>0): ?>
                    <input type="text" name="nama" class="form-control" placeholder="nama" id="nama" value="">
                    <?php else: ?>
                    <input type="text" name="nama" class="form-control" placeholder="nama" id="nama" disabled value="Root Simple Queue">
                    <?php endif ?>
                    <div class="text-danger" id="if-nama"></div>
                </div>
                <div class="mb-3">
                    <label for="">Paket</label><br>
                    <div class="client-paket"><input type="hidden" name="" id="paket" disabled><img src="<?=BASEURL?>/img/loading.webp" alt="" style="width:60px;"></div>
                    <div class="text-danger" id="if-paket"></div>
                </div>
                <div class="paket">
                </div>
                <div class="mb-3">
                    <label for="">IP Target</label><br>
                    <?php if(count($data['client'])>0): ?>
                    <div class="client-target"><input type="hidden" name="" id="target" disabled><img src="<?=BASEURL?>/img/loading.webp" alt="" style="width:60px;"></div>
                    <?php else:
                        $target = MikrotikAPI::all('address');
                        $t = []; 
                        foreach($target as $r){
                            $t[] = $r['network'].'/24';
                        } 
                    ?>
                    <input class="form-control" type="text" name="" id="target" disabled value="<?=implode(',',$t)?>">
                    <?php endif ?>
                    <div class="text-danger" id="if-target"></div>
                </div>
                <div class="mb-3">
                    <label for="">Parent</label><br>
                    <?php if(count($data['client'])>0): ?>
                    <div class="client-parent"><input type="hidden" name="" id="parent" disabled><img src="<?=BASEURL?>/img/loading.webp" alt="" style="width:60px;"></div>
                    <?php else: ?>
                    <input type="text" name="parent" class="form-control" placeholder="parent" id="parent" disabled value="none">
                    <?php endif ?>
                    <div class="text-danger" id="if-parent"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-primary" onclick="add_ed('store','','')">Save</button>
            </div>
        </div>
    </div>
</div>
<?=Menu::paginate($data['page'], 'yes', 'load')?>
