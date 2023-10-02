<script>
    function set_action(action, id, value, search='', searchBy='', page){
        var form_data = new FormData();
        form_data.append("action",action);
        form_data.append("id",id);
        form_data.append("value",value);
        if(action=='renew'){
            
            Swal.fire({       
                type: 'warning',                   
                title: "Renew?", 
                text: "Apakah anda yakin ingin renew client?", 
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
                        url: "<?=BASEURL.'/'.PATHURL_ST?>/"+action+"/"+id,
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
                                                load_data(<?=Filter::request(30, 'row')?>, search, searchBy,  page);
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
        }else{
            $.ajax({
                url: "<?=BASEURL.'/'.PATHURL_ST?>/"+action+"/"+id,
                type: "POST",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,

            })
            load_data(<?=Filter::request(30, 'row')?>, search, searchBy,  page);
        }
    }
</script>