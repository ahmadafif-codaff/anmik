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
                <th>No</th>
                <th>Time</th>
                <th>IP</th>
                <th>Browser</th>
                <th>Device</th>
                <th>Action</th>
                <th>Status</th>
                <th>Information</th>
                <th>User</th>
            </tr>
            <?php 
                $n = $data['start']+1; foreach($data['data'] as $r): 
            ?>
            <tr class="<?=$r->bg?>">
                <td><?=$n?></td>
                <td><?=$r->time?></td>
                <td><?=$r->ip?></td>
                <td><?=$r->browser?></td>
                <td><?=explode('(',explode(')',$r->so)[0])[1]?></td>
                <td><?=$r->action?></td>
                <td><?=$r->status?></td>
                <td><?=$r->message?></td>
                <td><?=$r->user?></td>
            </tr>
            <?php $n++; endforeach ?>
            <?php if($data['count_data']==0): ?>
            <tr>
                <td class="text-center" colspan="15">Tidak ada data ditemukan</td>
            </tr>
            <?php endif ?>

        </table>
    <?=Menu::paginate($data['page'], 'yes', 'load')?>
