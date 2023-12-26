<script>
    function add_ed(action, id, no){
        <?php if(PATHURL_ST=='paket'): ?>

        var nama = $("#nama"+no).val();
        var harga = $("#harga"+no).val();
        var kategori = $("#kategori"+no).val();
        var max_upload = $("#max_upload"+no).val();
        var max_download = $("#max_download"+no).val();
        var bandwidth_kedua = $("#bandwidth_kedua"+no).val();
        var bandwidth_ketiga = $("#bandwidth_ketiga"+no).val();
        var kuota = $("#kuota"+no).val();
        var kuota_kedua = $("#kuota_kedua"+no).val();
        var form_data = new FormData();
        form_data.append("nama",nama);
        form_data.append("harga",harga);
        form_data.append("kategori",kategori);
        form_data.append("max_upload",max_upload);
        form_data.append("max_download",max_download);
        form_data.append("bandwidth_kedua",bandwidth_kedua);
        form_data.append("bandwidth_ketiga",bandwidth_ketiga);
        form_data.append("kuota",kuota);
        form_data.append("kuota_kedua",kuota_kedua);

        <?php endif ?>
        
        <?php if(PATHURL_ST=='firewall'): ?>

        var address = $("#address"+no).val();
        var status = $("#status"+no).val();
        var form_data = new FormData();
        form_data.append("address",address);
        form_data.append("status",status);

        <?php endif ?>
        
        <?php if(PATHURL_ST=='client'): ?>

        var tanggal = $("#tanggal"+no).val();
        var nama = $("#nama"+no).val();
        var paket = $("#paket"+no).val();
        var target = $("#target"+no).val();
        var parent = $("#parent"+no).val();
        var form_data = new FormData();
        form_data.append("tanggal",tanggal);
        form_data.append("nama",nama);
        form_data.append("paket",paket);
        form_data.append("target",target);
        form_data.append("parent",parent);

        <?php endif ?>
        
        <?php if(PATHURL_ST=='pengaturan'): ?>

        var nama = $("#nama"+no).val();
        var username = $("#username"+no).val();
        var password = $("#password"+no).val();
        var form_data = new FormData();
        form_data.append("nama",nama);
        form_data.append("username",username);
        form_data.append("password",password);

        <?php endif ?>
        
        <?php if(PATHURL_ST=='schedule'): ?>

        var type = $("#type"+no).val();
        var frequency = $("#frequency"+no).val();
        var status = $("#status"+no).val();
        var dd = $("#dd"+no).val();
        var hh = $("#hh"+no).val();
        var mm = $("#mm"+no).val();
        var ss = $("#ss"+no).val();
        var dde = $("#dde"+no).val();
        var hhe = $("#hhe"+no).val();
        var mme = $("#mme"+no).val();
        var start_time = $("#start_time"+no).val();
        var end_time = $("#end_time"+no).val();
        var client = $("#client"+no).val();
        var download = $("#download"+no).val();
        var upload = $("#upload"+no).val();
        var form_data = new FormData();
        form_data.append("type",type);
        form_data.append("frequency",frequency);
        form_data.append("status",status);
        form_data.append("dd",dd);
        form_data.append("hh",hh);
        form_data.append("mm",mm);
        form_data.append("ss",ss);
        form_data.append("dde",dde);
        form_data.append("hhe",hhe);
        form_data.append("mme",mme);
        form_data.append("start_time",start_time);
        form_data.append("end_time",end_time);
        form_data.append("client",client);
        form_data.append("download",download);
        form_data.append("upload",upload);

        <?php endif ?>

        $.ajax({
            <?php if($data['title']=='Detail Clients'): ?>
            url: "<?=BASEURL.'/'?>client/"+action+"/"+id
            <?php else: ?>
            url: "<?=BASEURL.'/'.PATHURL_ST?>/"+action+"/"+id
            <?php endif ?>,
            type: "POST",
            dataType: 'script',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            
            success:function(response){
                // console.log(response);
                
                if(response){
                    var n = response.split('}').length-1;
                    // console.log(n);
                    
                    for(i=0; i<n;i++){
                        var a = JSON.parse(response.split('}')[i]+'}');
                        // console.log(a);

                        if(a.name){
                            $('#if-'+a.name+no).html(a.text);
                            $('#'+a.name+no).attr('class','form-control '+a.validation);
                        }
                        
                        if(a.type){
                            Swal.fire({
                            type: a.type,
                            title: a.title,
                            text: a.text,                       
                            timer: 2000,                                
                            showConfirmButton: false
                            });
                            setTimeout(function() {
                                if(a.type == 'success'){
                                    document.location.href = '';
                                }
                            }, 2000);
                        }else{

                        }
                    }
                }
            },
        })
    }
</script>