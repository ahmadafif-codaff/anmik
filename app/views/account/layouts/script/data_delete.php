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
    function delete_confirm(id, search='', searchBy='', page=1){
            Swal.fire({       
                type: 'warning',                   
                title: "Hapus?", 
                text: "Apakah anda yakin ingin hapus data? Data yang dihapus tidak dapat dipulihkan.", 
                buttons: true,           
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#6c757d',
                cancelButtonText: "Batal"
            }).then((confirmed) => {
                if(confirmed && confirmed.value == true){

                    $.ajax({
                        type: 'POST',
                        url: '<?=BASEURL.'/'.PATHURL_ST?>'+'/drop/'+id,
                        success:function(response){
                            if(response){
                                var n = response.split('}').length-1;
                                for(i=0; i<n;i++){
                                    var a = JSON.parse(response.split('}')[i]+'}');
                                    if(a.type){
                                        Swal.fire({
                                        type: a.type,
                                        title: a.title,
                                        text: a.text,                       
                                        timer: 2000,                                
                                        showConfirmButton: false
                                        });
                                        // setTimeout(function() {
                                            if(a.type == 'success'){
                                                load_data(page);
                                            }
                                        // }, 2000);
                                    }else{

                                    }
                                }
                            }
                        },
                    })
                }
            })
            return false;
    }
</script>