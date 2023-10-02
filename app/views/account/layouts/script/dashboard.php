<script>
    $(document).ready(function(){
        $('.card-usage').load('<?=BASEURL?>/dashboard/card_usage');
        $('.card-client').load('<?=BASEURL?>/dashboard/card_client');
        dashboard_load('<?=$data['address']?>','<?=$data['date']?>');
    })

    function dashboard_load(address, date, load='all'){
        if(load=='all'||load=='day'){
            $('.graph-daily').load('<?=BASEURL?>/dashboard/graph_daily?address='+address+'&date='+date);
            $('.total-daily').load('<?=BASEURL?>/dashboard/total_daily?address='+address+'&date='+date);
        }
        if(load=='all'||load=='month'){
            $('.graph-monthly').load('<?=BASEURL?>/dashboard/graph_monthly?address='+address+'&date='+date);
            $('.total-monthly').load('<?=BASEURL?>/dashboard/total_monthly?address='+address+'&date='+date);
        }
        if(load=='all'){
            $('.graph-yearly').load('<?=BASEURL?>/dashboard/graph_yearly?address='+address+'&date='+date);
            $('.total-yearly').load('<?=BASEURL?>/dashboard/total_yearly?address='+address+'&date='+date);
            load_client($('#search').val());
        }
    }
    function search(){
        var keyword = $('#search').val();
        load_client(keyword);
    }
    function load_client(keyword=''){
        $('.client-list').load('<?=BASEURL?>/dashboard/client_list?search='+keyword);
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