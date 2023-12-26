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
                <?php if(PATHURL_ND=='schedule_boost'):?>
                <th class="text-center align-middle">Date<br>(For Repeat)<br>Start End</th>
                <th class="text-center align-middle">Start Time</th>
                <th class="text-center align-middle">End Time</th>
                <th class="text-center align-middle">Download</th>
                <th class="text-center align-middle">Upload</th>
                <th class="text-center align-middle">Target</th>
                <th class="text-center align-middle">Client</th>
                <?php else:?>
                <th class="text-center align-middle">Time</th>
                <?php endif?>
                <th class="text-center align-middle">Status</th>
                <th class="text-center align-middle">Aksi</th>
            </tr>
            <?php 
                $no = $data['start']+1; foreach($data['data'] as $r):
                $bg_color = ''; if($r->status=='false'){$bg_color = 'table-danger';}
                if(PATHURL_ND=='schedule_boost'){
                    $time = explode('|', $r->time);
                }
            ?>
            <tr class="<?=$bg_color?>">
                <td><?=$no?></td>
                <td><?=$r->frequency?></td>
                <?php if(PATHURL_ND=='schedule_boost'):?>
                <td><?php if($r->frequency=='Repeat'){echo explode(' ',explode('->',$time[0])[0])[0].'-'.explode(' ',explode('->',$time[0])[1])[0];}else{echo '-';}?></td>
                <td><?php if($r->frequency=='Repeat'){echo explode(' ',explode('->',$time[0])[0])[1];}else{echo explode('->',$time[0])[0];}?></td>
                <td><?php if($r->frequency=='Repeat'){echo explode(' ',explode('->',$time[0])[1])[1];}else{echo explode('->',$time[0])[1];}?></td>
                <td><?=explode('/',$time[2])[1]?> Mbps</td>
                <td><?=explode('/',$time[2])[0]?> Mbps</td>
                <td><?=explode('->',$time[1])[1]?></td>
                <td><?=explode('->',$time[1])[2]?></td>
                <?php else:?>
                <td><?=$r->time?></td>
                <?php endif?>
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
                    <input type="hidden" name="type" id="type" readonly value="<?=PATHURL_ND?>">
                    <div class="mb-3">
                        <label for="">Frequency</label><br>
                        <select name="frequency" id="frequency" class="btn btn-ligth w-100 border text-start" onchange="select_frequency()">
                            <option value="">--Select Frequency--</option>
                            <?php if(PATHURL_ND=='schedule_boost'):?>
                                <option value="Repeat">Repeat</option>
                                <option value="One Time">One Time</option>
                            <?php else:?>
                                <option value="Day">Day</option>
                                <option value="Hour">Hour</option>
                            <?php endif;?>
                        </select>
                        <div class="text-danger" id="if-frequency"></div>
                    </div>
                    <div class="time"></div>
                    <?php if(PATHURL_ND=='schedule_boost'):?>
                    <div class="mb-3">
                        <label for="">Client List</label><br>
                        <div class="client"><input type="hidden" name="" id="client" disabled><img src="<?=BASEURL?>/img/loading.webp" alt="" style="width:60px;"></div>
                        <div class="text-danger" id="if-client"></div>
                    </div>
                    <div class="mb-3 col-md-12 row">
                        <div class="col-md-6">
                            <label for="">Boost Download</label>
                            <div class="input-group">
                                <input type="text" name="download" class="form-control" placeholder="download" id="download" value="">
                                <span class="btn btn-danger">Mbps</span>
                            </div>
                            <div class="text-danger" id="if-download"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Boost Upload</label>
                            <div class="input-group">
                                <input type="text" name="upload" class="form-control" placeholder="upload" id="upload" value="">
                                <span class="btn btn-primary">Mbps</span>
                            </div>
                            <div class="text-danger" id="if-upload"></div>
                        </div>
                    </div>
                    <?php endif;?>
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
    <script>
    $(document).ready(function(){
        $('.client').load('<?=BASEURL?>/schedule/client_list');
    })
    </script>
