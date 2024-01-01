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
<script>
    $(document).ready(function(){
        $('.client-paket').load('<?=BASEURL?>/client/paket');
        $('.client-target').load('<?=BASEURL?>/client/target');
        $('.client-parent').load('<?=BASEURL?>/client/parent');
    })

    function select_paket(id=''){
        var data = $('#paket'+id).val();
        var paket = $('.paket'+id);

        if(data!=""){
            var nama = data.split(' // ')[0];
            var harga = data.split(' // ')[1];
            var kategori = data.split(' // ')[2];
            var bandwidth = data.split(' // ')[3];
            var bandwidth_kedua = data.split(' // ')[4];
            var bandwidth_ketiga = data.split(' // ')[5];
            var kuota = data.split(' // ')[6];
            var kuota_kedua = data.split(' // ')[7]*kuota;

            var download = bandwidth.split('/')[1];
            var upload = bandwidth.split('/')[0];
            var download_kedua = bandwidth_kedua*download;
            var upload_kedua = bandwidth_kedua*upload;
            var download_ketiga = bandwidth_ketiga*download;
            var upload_ketiga = bandwidth_ketiga*upload;
        }
        
        if(data==""){
            paket.html('');
        }else if(kategori=="Kuota"){
            paket.html('<div class="border-bottom border-top border-primary mt-4 mb-4 pt-4 pb-4">   <div class="mb-3"><label for="">Nama Paket</label><input type="text" class="form-control" value="'+nama+'" disabled></div><div class="mb-3"><label for="">Harga Paket</label><input type="text" class="form-control" value="'+harga+'" disabled></div><div class="mb-3"><label for="">Kategori Paket</label><input type="text" class="form-control" value="'+kategori+'" disabled></div> <div class="mb-3 col-md-12 row"><div class="col-md-4"><label for="">Download</label><div class="input-group"><input type="text" class="form-control" value="'+download+'" disabled><span class="btn btn-danger">Mbps</span></div></div><div class="col-md-8"><label for="">Upload</label><div class="input-group"><input type="text" class="form-control" value="'+upload+'" disabled><span class="btn btn-primary">Mbps</span></div></div></div><div class="mb-3"><label for="">Kuota</label><div class="input-group"><input type="text" class="form-control" value="'+kuota+'" disabled><span class="btn btn-success">GB</span></div></div>');
        }else if(kategori=="Regular"){
            paket.html('<div class="border-bottom border-top border-primary mt-4 mb-4 pt-4 pb-4">   <div class="mb-3"><label for="">Nama Paket</label><input type="text" class="form-control" value="'+nama+'" disabled></div><div class="mb-3"><label for="">Harga Paket</label><input type="text" class="form-control" value="'+harga+'" disabled></div><div class="mb-3"><label for="">Kategori Paket</label><input type="text" class="form-control" value="'+kategori+'" disabled></div> <div class="mb-3 col-md-12 row"><div class="col-md-4"><label for="">Download</label><div class="input-group"><input type="text" class="form-control" value="'+download+'" disabled><span class="btn btn-danger">Mbps</span></div></div><div class="col-md-8"><label for="">Upload</label><div class="input-group"><input type="text" class="form-control" value="'+upload+'" disabled><span class="btn btn-primary">Mbps</span></div></div></div><div class="mb-3 col-md-12 row"><div class="col-md-6"><label for="">Download Kedua</label><div class="input-group"><input type="text" class="form-control" value="'+download_kedua+'" disabled><span class="btn btn-danger">Mbps</span></div></div><div class="col-md-6"><label for="">Upload Kedua</label><div class="input-group"><input type="text" class="form-control" value="'+upload_kedua+'" disabled><span class="btn btn-primary">Mbps</span></div></div></div><div class="mb-3 col-md-12 row"><div class="col-md-8"><label for="">Download Ketiga</label><div class="input-group"><input type="text" class="form-control" value="'+download_ketiga+'" disabled><span class="btn btn-danger">Mbps</span></div></div><div class="col-md-4"><label for="">Upload Ketiga</label><div class="input-group"><input type="text" class="form-control" value="'+upload_ketiga+'" disabled><span class="btn btn-primary">Mbps</span></div></div></div><div class="mb-3"><label for="">Kuota</label><div class="input-group"><input type="text" class="form-control" value="'+kuota+'" disabled><span class="btn btn-success">GB</span></div></div><div class="mb-3"><label for="">Kuota Kedua</label><div class="input-group"><input type="text" class="form-control" value="'+kuota_kedua+'" disabled><span class="btn btn-success">GB</span></div></div></div>');
        }else if(kategori=="Premium"){
            paket.html('<div class="border-bottom border-top border-primary mt-4 mb-4 pt-4 pb-4">   <div class="mb-3"><label for="">Nama Paket</label><input type="text" class="form-control" value="'+nama+'" disabled></div><div class="mb-3"><label for="">Harga Paket</label><input type="text" class="form-control" value="'+harga+'" disabled></div><div class="mb-3"><label for="">Kategori Paket</label><input type="text" class="form-control" value="'+kategori+'" disabled></div> <div class="mb-3 col-md-12 row"><div class="col-md-4"><label for="">Download</label><div class="input-group"><input type="text" class="form-control" value="'+download+'" disabled><span class="btn btn-danger">Mbps</span></div></div><div class="col-md-8"><label for="">Upload</label><div class="input-group"><input type="text" class="form-control" value="'+upload+'" disabled><span class="btn btn-primary">Mbps</span></div></div></div>');
        }
    }
</script>