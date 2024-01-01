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
        <table class=" table table-sm table-hover">
            <tr>
                <th rowspan="2" class="text-center align-middle">No.</th>
                <th rowspan="2" class="text-center align-middle">Nama</th>
                <th rowspan="2" class="text-center align-middle">Harga</th>
                <th rowspan="2" class="text-center align-middle">Kategori</th>
                <th class="text-center align-middle" colspan="2">First Speed</th>
                <th class="text-center align-middle" colspan="2">Second Speed</th>
                <th class="text-center align-middle" colspan="2">Third Speed</th>
                <th rowspan="2" class="text-center align-middle">First Quota</th>
                <th rowspan="2" class="text-center align-middle">Second Quota</th>
                <!-- <th rowspan="" class="text-center align-middle">Pengguna</th> -->
                <th rowspan="2" class="text-center align-middle">Aksi</th>
            </tr>
            <tr>
                <th class="text-center">Download</th>
                <th class="text-center">Upload</th>
                <th class="text-center">Download</th>
                <th class="text-center">Upload</th>
                <th class="text-center">Download</th>
                <th class="text-center">Upload</th>
            </tr>
            <?php 
                $no=$data['no']+1; foreach($data['data'] as $r):
            ?>
            <tr>
                <td><?=$no?></td>
                <td><?=$r->nama?></td>
                <td><?=$r->harga_format?></td>
                <td><?=$r->kategori_ket?></td>
                <td><?=$r->max_download?> Mbps</td>
                <td><?=$r->max_upload?> Mbps</td>
                <td><?=$r->download2?></td>
                <td><?=$r->upload2?></td>
                <td><?=$r->download3?></td>
                <td><?=$r->upload3?></td>
                <td><?=$r->kuota_format?></td>
                <td><?=$r->kuota2?></td>
                <td class="text-center">
                    <button class="btn-sm btn text-light btn-warning bi bi-pencil-square m-1" data-bs-toggle="modal" data-bs-target="#Modal<?=$r->id_paket?>"></button>
                    <!-- Modal Edit-->
                    <div class="modal fade" id="Modal<?=$r->id_paket?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p class="modal-title fs-5" id="ModalLabel" style="font-size: large">Edit Data</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">            
                                    <div class="mb-3">
                                        <label for="">Nama</label>
                                        <input type="text" name="nama" class="form-control" placeholder="nama" id="nama<?=$no?>" value="<?=$r->nama?>">
                                        <div class="text-danger" id="if-nama<?=$no?>"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Harga</label>
                                        <input type="text" name="harga" class="form-control" placeholder="harga" id="harga<?=$no?>" value="Rp. <?=$r->harga?>" onkeyup="format_rupiah(<?=$no?>)">
                                        <div class="text-danger" id="if-harga<?=$no?>"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Kategori</label><br>
                                        <select name="kategori" id="kategori<?=$no?>" class="btn btn-ligth w-100 border text-start" onchange="select_kategori('<?=$no?>','<?=$r->kuota?>')">
                                            <option value="">--Pilih Kategori--</option>
                                            <option value="Kuota">Kuota (Limited)</option>
                                            <option value="Regular">Regular (Unlimited with FUP)</option>
                                            <option value="Premium">Premium (Unlimited)</option>
                                        </select>
                                        <div class="text-danger" id="if-kategori<?=$no?>"></div>
                                    </div>
                                    <div class="mb-3 col-md-12 row">
                                        <div class="col-md-6">
                                            <label for="">Download</label>
                                            <div class="input-group">
                                                <input type="text" name="max_download" class="form-control" placeholder="download" id="max_download<?=$no?>" value="<?=$r->max_download?>">
                                                <span class="btn btn-danger">Mbps</span>
                                            </div>
                                            <div class="text-danger" id="if-max_download<?=$no?>"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Upload</label>
                                            <div class="input-group">
                                                <input type="text" name="max_upload" class="form-control" placeholder="upload" id="max_upload<?=$no?>" value="<?=$r->max_upload?>">
                                                <span class="btn btn-primary">Mbps</span>
                                            </div>
                                            <div class="text-danger" id="if-max_upload<?=$no?>"></div>
                                        </div>
                                    </div>
                                    <div class="kategori<?=$no?>"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-sm btn-primary" onclick="add_ed('edit', <?=$r->id_paket?>, '<?=$no?>')">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-sm btn-danger m-1 drop" onclick="return delete_confirm(<?=$r->id_paket?>, '<?=Filter::request('', 'search')?>', '<?=Filter::request('', 'search_by')?>',  <?=Filter::request(1, 'page')?>)"><span class="bi bi-x-square"></span></a>

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
                        <label for="">Nama</label>
                        <input type="text" name="nama" class="form-control" placeholder="nama" id="nama" value="">
                        <div class="text-danger" id="if-nama"></div>
                    </div>
                    <div class="mb-3">
                        <label for="">Harga</label>
                        <input type="text" name="harga" class="form-control" placeholder="harga" id="harga" value="" onkeyup="format_rupiah('')">
                        <div class="text-danger" id="if-harga"></div>
                    </div>
                    <div class="mb-3">
                        <label for="">Kategori</label><br>
                        <select name="kategori" id="kategori" class="btn btn-ligth w-100 border text-start" onchange="select_kategori('','')">
                            <option value="">--Pilih Kategori--</option>
                            <option value="Kuota">Kuota (Limited)</option>
                            <option value="Regular">Regular (Unlimited with FUP)</option>
                            <option value="Premium">Premium (Unlimited)</option>
                        </select>
                        <div class="text-danger" id="if-kategori"></div>
                    </div>
                    <div class="mb-3 col-md-12 row">
                        <div class="col-md-6">
                            <label for="">Download</label>
                            <div class="input-group">
                                <input type="text" name="max_download" class="form-control" placeholder="download" id="max_download" value="">
                                <span class="btn btn-danger">Mbps</span>
                            </div>
                            <div class="text-danger" id="if-max_download"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Upload</label>
                            <div class="input-group">
                                <input type="text" name="max_upload" class="form-control" placeholder="upload" id="max_upload" value="">
                                <span class="btn btn-primary">Mbps</span>
                            </div>
                            <div class="text-danger" id="if-max_upload"></div>
                        </div>
                    </div>
                    <div class="kategori"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary" onclick="add_ed('store','','')">Save</button>
                </div>
            </div>
        </div>
    </div>
    <?=Menu::paginate($data['page'], 'yes', 'load')?>
