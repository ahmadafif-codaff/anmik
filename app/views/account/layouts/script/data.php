<script>
    $(document).ready(function(){
        load_data();
    })
    function search(){
        var row = $('#row').val();
        var keyword = $('#search').val();
        var by = $('#search_by').val();
        load_data(row, keyword, by);
    }
    function search_by(){
        var row = $('#row').val();
        var keyword = $('#search').val();
        var by = $('#search_by').val();
        load_data(row, keyword, by);
    }
    function row(){
        var row = $('#row').val();
        var keyword = $('#search').val();
        var by = $('#search_by').val();
        load_data(row, keyword, by);
    }
    function page($i){
        var row = $('#row').val();
        var keyword = $('#search').val();
        var by = $('#search_by').val();
        load_data(row, keyword, by, $i);
    }
    function load_data(row='', keyword='', searchBy='', page=''){
        var data = 'data';
        if('<?=PATHURL_ST?>'=='schedule'){
            data = 'schedule_reboot';
            if('<?=PATHURL_ND?>'=='boost'){
                data = 'schedule_boost';
            }
        }
        $('.data').load('<?=BASEURL.'/'.PATHURL_ST?>/'+data+'?row='+row+'&search='+keyword+'&page='+page+'&search_by='+searchBy);
    }
</script>