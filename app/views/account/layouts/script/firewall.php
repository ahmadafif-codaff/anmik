<script>
    function address_pool(action=''){
        var data = $('#address-pool').val();
        var interface = data.split(" ")[0]; 
        var addressPool = data.split(" ")[1];
        var textConfirm = 'Filter rule akan dibuat dan alamat ip yang terhubung dengan '+interface+' akan dinonaktifkan!';
        var actionUrl = 'generate';
        if(action=='delete'){
            var data = $('#address-pool-delete').val();
            var interface = data.split(" ")[0]; 
            var addressPool = data.split(" ")[1];
            var textConfirm = 'Alamat ip yang terhubung dengan '+interface+' akan dihapus!';
            var actionUrl = 'dropall';
        }
        if (data !==""){
            Swal.fire({       
                type: 'warning',                   
                title: "Apakah anda yakin?", 
                text: textConfirm,                        
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
                        url: '<?=BASEURL.'/'.PATHURL_ST?>'+'/'+actionUrl,
                        type: "POST",
                        data: {
                            "address_pool": addressPool,
                        },
                        
                        success:function(response){
                        if(response){
                            var n = response.split('}').length-1;
                            // console.log(n);
                            
                            for(i=0; i<n;i++){
                                var a = JSON.parse(response.split('}')[i]+'}');
                                // console.log(a);
                                
                                if(a.type){
                                    Swal.fire({
                                    type: a.type,
                                    title: a.title,
                                    text: a.text,                       
                                    timer: 5000,                                
                                    showConfirmButton: false
                                    });

                                    load_data();
                                }else{

                                }
                            }
                        }
                        }
                    })
                }
            })
        return false;
        }

    }
</script>