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
                    url: "<?=BASEURL?>/logout",
                    
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
                            document.location.href = '<?=BASEURL?>/login';
                            }, 2000);
                        } 
                    }
                })
            }
        })
        return false;
    };
</script>