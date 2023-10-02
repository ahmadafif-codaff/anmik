<script>
    function reboot_mikrotik(){
            Swal.fire({       
                type: 'warning',                   
                title: "Reboot?", 
                text: "Are you sure want to rebooting the mikrotik?", 
                buttons: true,           
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonColor: '#6c757d',
                cancelButtonText: "No"
            }).then((confirmed) => {
                if(confirmed && confirmed.value == true){

                    $.ajax({
                        type: 'POST',
                        url: '<?=BASEURL.'/reboot'?>',
                        success:function(response){
                            Swal.fire({
                            type: 'success',
                            title: 'Rebooted!',
                            text: response.success,                       
                            timer: 2000,                                
                            showConfirmButton: false
                            });

                        },
                        error:function(response){
                            Swal.fire({
                            type: 'error',
                            title: 'Oopss!',
                            text: 'Failed!',                  
                            timer: 2000,                                
                            showConfirmButton: false
                            });
                        }
                    })
                }
            })
            return false;
    }
</script>