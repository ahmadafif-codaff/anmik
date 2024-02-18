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
        <table class="table table-sm table-hover">
            <tr>
                <th>No</th>
                <th>Address</th>
                <th>Firewall Status</th>
                <th>Client Status</th>
                <th>Type Address</th>
                <th>Client Name</th>
                <th>Aksi</th>
            </tr>
            <?php 
                $no = $data['start']+1; foreach ($data['firewall'] AS $r):
            ?>
            <tr class="<?=$r->data->bg?>">
                <td><?=$no?></td>
                <td><?=$r->data->address?></td>
                <td><?=$r->data->firewall_status?></td>
                <td><?=$r->data->client_status?></td>
                <td><?=$r->data->type?></td>
                <td><?=$r->data->client_name?></td>
                <td>
                    <?php if($r->data->firewall_status=='Activated'):?>
                    <button class="btn btn-sm btn-secondary m-1" data-bs-toggle="tooltip" title="disable"><span class="bi-dash-circle"></span></button>
                    <button class="btn btn-sm btn-primary m-1" onclick="set_action('status', '<?=$r->data->id?>', 'true', '<?=Filter::request('', 'search')?>', '<?=Filter::request('', 'search_by')?>',  <?=Filter::request(1, 'page')?>)" data-bs-toggle="tooltip" title="enable"><span class="bi-check-circle"></span></button>
                    <?php else:?>
                    <button class="btn btn-sm btn-secondary m-1" onclick="set_action('status', '<?=$r->data->id?>', 'false', '<?=Filter::request('', 'search')?>', '<?=Filter::request('', 'search_by')?>',  <?=Filter::request(1, 'page')?>)" data-bs-toggle="tooltip" title="disable"><span class="bi-dash-circle"></span></button>
                    <button class="btn btn-sm btn-primary m-1" data-bs-toggle="tooltip" title="enable"><span class="bi-check-circle"></span></button>
                    <?php endif;?>
                    <?php if($r->data->firewall_status=='Nonactivated'||$r->data->client_name!='No client data'):?>
                    <a class="btn btn-sm btn-secondary m-1 drop"><span class="bi bi-x-square" title="delete"></span></a>
                    <?php else:?>
                    <a class="btn btn-sm btn-danger m-1 drop" onclick="return delete_confirm('<?=$r->data->id?>', '<?=Filter::request('', 'search')?>', '<?=Filter::request('', 'search_by')?>',  <?=Filter::request(1, 'page')?>)"><span class="bi bi-x-square" title="delete"></span></a>
                    <?php endif;?>
                </td>
                <td></td>
            </tr>
            <?php $no++; endforeach ?>
            <?php if(count($data['firewall'])==0): ?>
            <tr>
                <td class="text-center" colspan="15">Tidak ada data ditemukan</td>
            </tr>
            <?php endif ?>
        </table>
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
                        <label for="">Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Masukkan IP : xxx.xxx.xxx.xxx/32 atau Net : xxx.xxx.xxx.0/24" id="address" value="">
                        <div class="text-danger" id="if-address"></div>
                    </div>
                    <div class="mb-3">
                        <label for="">Status</label><br>
                        <select name="status" id="status" class="btn btn-ligth w-100 border text-start">
                            <option value="">--Select Firewall Status--</option>
                            <option value="true">Nonactivated</option>
                            <option value="false">Activated</option>
                        </select>
                        <div class="text-danger" id="if-status"></div>
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
