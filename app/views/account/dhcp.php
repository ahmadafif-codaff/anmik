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
                <th>No</th>
                <th class="text-center">Address</th>
                <th class="text-center">MAC Address</th>
                <th class="text-center">Client ID</th>
                <th class="text-center">Server</th>
                <th class="text-center">Active Address</th>
                <th class="text-center">Active Mac Address</th>
                <th class="text-center">Hostname</th>
                <th class="text-center">Expire After</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
            <?php 
                $no = $data['start']+1; foreach ($data['dhcp-lease'] AS $r):
            ?>
            <tr class="<?=$r->bg?>">
                <td><?=$no?></td>
                <td colspan="20"><?=$r->comment?></td>
            </tr>
            <tr class="<?=$r->bg?>">
                <td></td>
                <td class="font-top"><?=$r->address?></td>
                <td class="font-top"><?=$r->mac_address?></td>
                <td class="font-top"><?=$r->client_id?></td>
                <td class="font-top"><?=$r->server?></td>
                <td class="font-top"><?=$r->active_address?></td>
                <td class="font-top"><?=$r->active_mac_address?></td>
                <td class="font-top"><?=$r->host_name?></td>
                <td class="font-top"><?=$r->expires_after?></td>
                <td class="font-top"><?=$r->status?></td>
                <td>
                    <?php if($ip=='Static'):?>
                    <button class="btn btn-sm btn-secondary m-1" data-bs-toggle="tooltip" title="Static"><span class="bi-check-circle"></span></button>
                    <?php else:?>
                    <button class="btn btn-sm btn-primary m-1" onclick="set_action('static', '<?=$r->id?>', '<?=$r->host_name?>', '<?=Filter::request('', 'search')?>', '<?=Filter::request('', 'search_by')?>',  <?=Filter::request(1, 'page')?>)" data-bs-toggle="tooltip" title="Static"><span class="bi-check-circle"></span></button>
                    <?php endif;?>
                    <button class="btn btn-sm btn-danger m-1 drop" onclick="return delete_confirm('<?=$r->id?>', '<?=Filter::request('', 'search')?>', '<?=Filter::request('', 'search_by')?>',  <?=Filter::request(1, 'page')?>)"><span class="bi-x-square" title="delete"></span></button>
                </td>
            </tr>
            <?php $no++; endforeach ?>
            <?php if(count($data['dhcp-lease'])==0): ?>
            <tr>
                <td class="text-center" colspan="15">Tidak ada data ditemukan</td>
            </tr>
            <?php endif ?>
        </table>
    <?=Menu::paginate($data['page'], 'yes', 'load')?>
