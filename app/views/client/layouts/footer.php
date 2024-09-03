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
            <br>
            <p class="text-secondary">© 2023 - <?=date('Y')?> Codaff Project. All right reserved. ANMIK version <?=VERSION?></p>
            <br>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="<?=BASEURL?>/js/ajax-jquery-3.4.1/jquery.min.js"></script>
    <script src="<?=BASEURL?>/js/sweatalert2/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('#humberger-side').toggleClass('active');
                $('#content').toggleClass('active');
                $('body').toggleClass('overflow-x-none');
            });
            $('.card-usage').load('<?=BASEURL.'/dashboard_client/card_usage'?>');
            $('.card-package').load('<?=BASEURL.'/dashboard_client/card_client'?>');
            $('.card-renew').load('<?=BASEURL.'/dashboard_client/card_renew'?>');
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
            }
        }

        function graph_load(duration, address, date){
            $('.graph-'+duration).html('<div class="d-flex justify-content-center align-items-center w-100 h-100"><img src="<?=BASEURL?>/img/loading2.gif" alt="loading" style="width:50%;"></div>');
            $('.total-'+duration).load(location.href + ' .total-'+duration);
            setTimeout(function(){
                $('.graph-'+duration).load('<?=BASEURL?>/dashboard_client/graph_'+duration+'?address='+address+'&date='+date);
                $('.total-'+duration).load('<?=BASEURL?>/dashboard_client/total_'+duration+'?address='+address+'&date='+date);
            },2000);
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
        
        function logout() { 
            Swal.fire({       
                type: 'warning',                   
                title: "Logout?", 
                text: "Apakah anda ingin logout? Sesi anda akan berakhir.", 
                buttons: true,           
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#6c757d',
                cancelButtonText: "Batal"
            }).then((confirmed) => {
                if(confirmed && confirmed.value == true){
                    // window.location.href = getLink

                    $.ajax({
                        url: "<?=BASEURL?>/dashboard_client/logout",

                        success:function(response){
                            if (response) {
                                Swal.fire({
                                type: 'success',
                                title: 'Sukses!',
                                text: 'Anda keluar dari sistem!',                       
                                timer: 2000,                                
                                showConfirmButton: false
                                });
                                setTimeout(function() {
                                    document.location.href = '<?=BASEURL?>/login_client';
                                }, 2000);
                            } 
                        }
                    })
                }
            })
            return false;
        };
    </script>
</body>
</html>