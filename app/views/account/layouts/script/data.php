<script>
    $(document).ready(function(){
        load_data();
    })
    function search(){
        var keyword = $('#search').val();
        var by = $('#search_by').val();
        load_data(<?=Filter::request(30, 'row')?>, keyword, by);
    }
    function search_by(){
        var keyword = $('#search').val();
        var by = $('#search_by').val();
        load_data(<?=Filter::request(30, 'row')?>, keyword, by);
    }
    function page($i){
        var keyword = $('#search').val();
        var by = $('#search_by').val();
        load_data(<?=Filter::request(30, 'row')?>, keyword, by, $i);
    }
    function load_data(row=<?=Filter::request(30, 'row')?>, keyword='', searchBy='', page=''){
        $('.data').load('<?=BASEURL.'/'.PATHURL_ST?>/data?row='+row+'&search='+keyword+'&page='+page+'&search_by='+searchBy);
    }
</script>