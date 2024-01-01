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
    function format_rupiah(id){
        var rupiah = $('#harga'+id).val();
        if(rupiah!=""){
            $('#harga'+id).val(formatRupiah(rupiah, 'Rp. '));
        }
    }

    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function select_kategori(id,kuota){
        var data = $('#kategori'+id).val(); 
        if(data=="Kuota"){
            $('.kategori'+id).html('<div class="mb-3"><label for="">Kuota</label><div class="input-group"><input type="text" name="kuota" class="form-control" placeholder="kuota" id="kuota'+id+'" value="'+kuota+'"><span class="btn btn-success">GB</span></div><div class="text-danger" id="if-kuota'+id+'"></div></div>');
        }else if(data=="Regular"){
            if(id==""){
                var bandwidth_kedua ="select_bandwidth_kedua('')";
                var bandwidth_ketiga ="select_bandwidth_ketiga('')";
                var kuota_kedua ="select_kuota_kedua('')";
            }else{
                var bandwidth_kedua ="select_bandwidth_kedua("+id+")";
                var bandwidth_ketiga ="select_bandwidth_ketiga("+id+")";
                var kuota_kedua ="select_kuota_kedua("+id+")";
            }
            $('.kategori'+id).html('<div class="mb-3"><label for="">Kecepatan Kedua</label><br><select name="bandwidth_kedua" id="bandwidth_kedua'+id+'" class="btn btn-ligth w-100 border text-start" onchange="'+bandwidth_kedua+'"><option value="">--Pilih Kecepatan Kedua--</option><?php for($x=1; $x<10; $x++): ?><option value="<?='0.'.$x?>"><?=$x.'0%'?> dari bandwidth pertama</option><?php endfor ?></select><div class="bandwidth_kedua'+id+'"></div><div class="text-danger" id="if-bandwidth_kedua'+id+'"></div></div><div class="mb-3"><label for="">Kecepatan Ketiga</label><br><select name="bandwidth_ketiga" id="bandwidth_ketiga'+id+'" class="btn btn-ligth w-100 border text-start" onchange="'+bandwidth_ketiga+'"><option value="">--Pilih Kecepatan Ketiga--</option><?php for($x=1; $x<10; $x++): ?><option value="<?='0.'.$x?>"><?=$x.'0%'?> dari bandwidth pertama</option><?php endfor ?></select><div class="bandwidth_ketiga'+id+'"></div><div class="text-danger" id="if-bandwidth_ketiga'+id+'"></div></div><div class="mb-3"><label for="">Kuota</label><div class="input-group"><input type="text" name="kuota" class="form-control" placeholder="kuota" id="kuota'+id+'" value="'+kuota+'"><span class="btn btn-success">GB</span></div><div class="text-danger" id="if-kuota'+id+'"></div></div><div class="mb-3"><label for="">Kuota Kedua</label><br><select name="kuota_kedua" id="kuota_kedua'+id+'" class="btn btn-ligth w-100 border text-start" onchange="'+kuota_kedua+'"><option value="">--Pilih Kuota Kedua--</option><?php for($x=1; $x<10; $x++): ?><option value="<?='1.'.$x?>"><?='1'.$x.'0%'?> dari kuota pertama</option><?php endfor ?> </select><div class="kuota_kedua'+id+'"></div><div class="text-danger" id="if-kuota_kedua'+id+'"></div></div>');
        }else{
            $('.kategori'+id).html('');
        }
    }

    function select_bandwidth_kedua(id){
        var data = $('#bandwidth_kedua'+id).val();
        var download = $('#max_download'+id).val();
        var upload = $('#max_upload'+id).val();
        
        if(data!=""){
            $('.bandwidth_kedua'+id).html('<span class="text-primary fst-italic">Download '+download*data+' Mbps Upload '+upload*data+' Mbps</span>');
        }else{
            $('.bandwidth_kedua'+id).html('');
        }
    }

    function select_bandwidth_ketiga(id){
        var data = $('#bandwidth_ketiga'+id).val();
        var download = $('#max_download'+id).val();
        var upload = $('#max_upload'+id).val();
        
        if(data!=""){
            $('.bandwidth_ketiga'+id).html('<span class="text-primary fst-italic">Download '+download*data+' Mbps Upload '+upload*data+' Mbps</span>');
        }else{
            $('.bandwidth_ketiga'+id).html('');
        }
    }

    function select_kuota_kedua(id){
        var data = $('#kuota_kedua'+id).val();
        var kuota = $('#kuota'+id).val();
        
        if(data!=""){
            $('.kuota_kedua'+id).html('<span class="text-primary fst-italic">Kuota kedua '+kuota*data+' GB</span>');
        }else{
            $('.kuota_kedua'+id).html('');
        }
    }
</script>