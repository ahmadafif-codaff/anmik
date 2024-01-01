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
        load_data();
    })
    function page(i){
        load_data(i);
    }
    function load_data(page=''){
        var row = $('#row').val();
        var keyword = $('#search').val();
        var searchBy = $('#search_by').val();
        var sortBy = $('#sort_by').val();
        $('.data').html('<div class="d-flex col-md-12 justify-content-center"><img src="<?=BASEURL?>/img/loading2.gif" alt="loading" style="width:50%;"></div>');
        setTimeout(function(){
            var data = 'data';
            if('<?=PATHURL_ST?>'=='schedule'){
                data = 'schedule_reboot';
                if('<?=PATHURL_ND?>'=='boost'){
                    data = 'schedule_boost';
                }
            }
            $('.data').load('<?=BASEURL.'/'.PATHURL_ST?>/'+data+'?sort_by='+sortBy+'&row='+row+'&search='+keyword+'&page='+page+'&search_by='+searchBy);
        },2000);
    }
</script>