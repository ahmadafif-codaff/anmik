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
        <table class=" table table-sm table-hover">
            <tr>
                <th class="text-center align-middle">No.</th>
                <th class="text-center align-middle">Frequency</th>
                <th class="text-center align-middle">Time</th>
                <th class="text-center align-middle">Status</th>
                <th class="text-center align-middle">Aksi</th>
            </tr>
            <?php 
                $no = $data['start']+1; foreach($data['data'] as $r):
                $bg_color = ''; if($r->status=='false'){$bg_color = 'table-danger';}
            ?>
            <tr class="<?=$bg_color?>">
                <td><?=$no?></td>
                <td><?=$r->frequency?></td>
                <td><?=$r->time?></td>
                <td><?=$r->status?></td>
                <td class="text-center">
                    <?php if($r->status=='false'): ?>
                    <button class="btn btn-sm btn-secondary m-1" data-bs-toggle="tooltip" title="disable"><span class="bi-dash-circle"></span></button>
                    <button class="btn btn-sm btn-primary m-1" onclick="set_action('status', '<?=$r->id_schedule?>', 'true', '<?=Filter::request('', 'search')?>', '<?=Filter::request('', 'search_by')?>',  <?=Filter::request(1, 'page')?>)" data-bs-toggle="tooltip" title="enable"><span class="bi-check-circle"></span></button>
                    <?php else: ?>
                    <button class="btn btn-sm btn-secondary m-1" onclick="set_action('status', '<?=$r->id_schedule?>', 'false', '<?=Filter::request('', 'search')?>', '<?=Filter::request('', 'search_by')?>',  <?=Filter::request(1, 'page')?>)" data-bs-toggle="tooltip" title="disable"><span class="bi-dash-circle"></span></button>
                    <button class="btn btn-sm btn-primary m-1" data-bs-toggle="tooltip" title="enable"><span class="bi-check-circle"></span></button>
                    <?php endif ?>
                    <a class="btn btn-sm btn-danger m-1 drop" onclick="return delete_confirm(<?=$r->id_schedule?>, '<?=Filter::request('', 'search')?>', '<?=Filter::request('', 'search_by')?>',  <?=Filter::request(1, 'page')?>)"><span class="bi bi-x-square"></span></a>
                </td>
            </tr>
            <?php $no++; endforeach ?>
            <?php if($data['count_data']==0): ?>
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
                        <label for="">Frequency</label><br>
                        <select name="frequency" id="frequency" class="btn btn-ligth w-100 border text-start" onchange="select_frequency()">
                            <option value="">--Select Frequency--</option>
                            <option value="Day">Day</option>
                            <option value="Hour">Hour</option>
                        </select>
                        <div class="text-danger" id="if-frequency"></div>
                    </div>
                    <div class="mb-3 col-md-12 row align-items-center time">
                    </div>
                    <div class="mb-3">
                        <label for="">Status</label><br>
                        <select name="status" id="status" class="btn btn-ligth w-100 border text-start">
                            <option value="">--Select Status--</option>
                            <option value="true">Activated</option>
                            <option value="false">Nonactivated</option>
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
