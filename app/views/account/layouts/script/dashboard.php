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
        $('.card-usage').load('<?=BASEURL?>/dashboard/card_usage');
        $('.card-client').load('<?=BASEURL?>/dashboard/card_client');
        dashboard_load('<?=$data['address']?>','<?=$data['date']?>');
    })

    function dashboard_load(address, date, load='all'){
        if(load=='all'||load=='day'){
            graph_load('daily', address, date);
        }
        if(load=='all'||load=='month'){
            graph_load('monthly', address, date);
        }
        if(load=='all'){
            graph_load('yearly', address, date);
            load_client($('#search').val().split(' ').join('%20'));
        }
    }

    function graph_load(duration, address, date){
        $('.graph-'+duration).html('<div class="d-flex justify-content-center align-items-center w-100 h-100"><img src="<?=BASEURL?>/img/loading2.gif" alt="loading" style="width:50%;"></div>');
        $('.total-'+duration).load(location.href + ' .total-'+duration);
        setTimeout(function(){
            $('.graph-'+duration).load('<?=BASEURL?>/dashboard/graph_'+duration+'?address='+address+'&date='+date);
            $('.total-'+duration).load('<?=BASEURL?>/dashboard/total_'+duration+'?address='+address+'&date='+date);
            if(date=='<?=date('Y-m-d')?>'&&duration!='daily'){
                $('.traffic-monitor').load('<?=BASEURL?>/dashboard_tx_rx?view=true&address='+address);
            }
        },2000);
    }

    function load_data(){
        var keyword = $('#search').val().split(' ').join('%20');
        load_client(keyword);
    }

    function load_client(keyword=''){
        var sortBy = $('#sort_by').val();
        $('.client-list').html('<img src="<?=BASEURL?>/img/loading2.gif" alt="loading" class="mt-5" style="width:100%;">');
        setTimeout(function(){
            $('.client-list').load('<?=BASEURL?>/dashboard/client_list?search='+keyword+'&sort_by='+sortBy);
        },2000);
    }

    function speed_display(){
        var speed = $('#speed_display').val();
        document.cookie = "speed_display="+speed+";expires=Thu, 18 Dec <?=date('Y')+1?> 12:00:00 UTC";
        load_data();
    }

    function day_stat(address='', date='', name=''){
        if(address!=''){
            $('#address').val(address);
            $('.name').html(name);
        }
        if(date==''){
            var date = $('#date').val(); 
            var address = $('#address').val();
        }
        if(name!=''){
            var load = 'all';
        }else{
            var load = 'day';
        }
        
        var dateSplit = date.split('-');
        var year = dateSplit[0];
        var month = dateSplit[1];
        var day = dateSplit[2];

        var dayname = 'Tahun '+year+' Bulan '+month+' Tanggal '+day;
        var monthname = 'Tahun '+year+' Bulan '+month;

        if(date=='<?=date('Y-m-d')?>'){
            var dayname = 'Hari Ini';
        }
        if($('#month').val()=='<?=date('Y-m')?>'){
            var monthname = 'Bulan Ini';
        }

        $('.day').html(dayname);
        if(load=='all'){
            $('#date').val('<?=date('Y-m-d')?>');
            $('#month').val('<?=date('Y-m')?>');
            $('.month').html(monthname);
        }
        dashboard_load(address,date,load);
    }

    function month_stat(){
        var date = $('#month').val(); 
        var address = $('#address').val();
        var load = 'month';
        
        var dateSplit = date.split('-');
        var year = dateSplit[0];
        var month = dateSplit[1];

        var monthname = 'Tahun '+year+' Bulan '+month;

        if(date=='<?=date('Y-m')?>'){
            var monthname = 'Bulan Ini';
        }

        $('.month').html(monthname);
        dashboard_load(address,date,load);
    }

    setInterval(function(){
        var address = $('#address').val();
        $('.card-resource').load('<?=BASEURL?>/dashboard_card_resource');
        $('.tx-rx').load('<?=BASEURL?>/dashboard_tx_rx?address='+address);
    }, 2000);
</script>