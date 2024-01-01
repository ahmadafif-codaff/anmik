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
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            $('#humberger-side').toggleClass('active');
            $('#content').toggleClass('active');
            $('body').toggleClass('overflow-x-none');
        });
    });

    tinymce.init({ 
        selector: 'textarea',
        plugins: 'autolink charmap emoticons link lists searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });

    setInterval(function(){
        $(".load-table").load(location.href + " .load-table");
        $('.reload_time').load('<?=BASEURL?>/dashboard_uptime');
    }, 1000);

    $(document).ready(function(){
        $('#btn_load').click(function(){
            var valData = $('#val_load').val();  
            if(valData==1){
                $('#val_load').val('0');
                $('#icon_load').css({'transform':'rotate(360deg)','transition':'all 0.3s'})
            }else{
                $('#val_load').val('1');
                $('#icon_load').css({'transform':'rotate(180deg)','transition':'all 0.3s'})
            }
        })
    })
</script>