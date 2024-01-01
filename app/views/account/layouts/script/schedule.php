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
    function select_frequency(no=''){
        var fq = $('#frequency'+no).val();
        <?php if(PATHURL_ND=='boost'):?>
            if(fq=='One Time'){
                $('.time'+no).html('<div class="mb-3"><label for="">Start Time</label><input type="datetime-local" name="start_time" class="form-control" placeholder="start_time" id="start_time" value=""><div class="text-danger" id="if-start_time"></div></div><div class="mb-3"><label for="">End Time</label><input type="datetime-local" name="end_time" class="form-control" placeholder="end_time" id="end_time" value=""><div class="text-danger" id="if-end_time"></div></div>');
            }
            if(fq=='Repeat'){
                $('.time'+no).html('<div class="mb-3 col-md-12 d-flex"><div class="col-md-6"><label for="">Start Date</label><input class="form-control" type="number" name="dd" id="dd'+no+'" min="1" max="31" placeholder="dd" onkeyup="tt(1,31)"></div><p class="mt-4"> - </p><div class="col-md-6"><label for="">End Date</label><input class="form-control" type="number" name="dd" id="dde'+no+'" min="1" max="31" placeholder="dd" onkeyup="tt(5,31)"></div></div><div class="mb-3 col-md-12 d-flex"><div class="col-md-6"><label for="">Start Time</label><br><div class="col-md-12 row align-items-center"><div style="width: 48.8%;"><input class="form-control" type="number" name="hh" id="hh'+no+'" min="0"  max="23" placeholder="hh" onkeyup="tt(2,23)"></div>:<div style="width: 48.8%;"><input class="form-control" type="number" name="mm" id="mm'+no+'" min="0"  max="59" placeholder="mm" onkeyup="tt(3,59)" value="00" disabled></div></div></div><p class="mt-4"> - </p><div class="col-md-6"><label for="">End Time</label><br><div class="col-md-12 row align-items-center"><div style="width: 48.8%;"><input class="form-control" type="number" name="hh" id="hhe'+no+'" min="0"  max="23" placeholder="hh" onkeyup="tt(6,23)"></div>:<div style="width: 48.8%;"><input class="form-control" type="number" name="mm" id="mme'+no+'" min="0"  max="59" placeholder="mm" onkeyup="tt(7,59)" value="59" disabled></div></div></div></div>');
            }
            if(fq==''){
                $('.time'+no).html('');
            }
        <?php else:?>
            if(fq=='Day'){
                $('.time'+no).html('<div class="mb-3 col-md-12 row align-items-center"><label for="">Time</label><br><div class="col-md-12 row align-items-center"><div style="width: 23.5%;"><input class="form-control" type="number" name="dd" id="dd'+no+'" min="1" max="31" placeholder="dd" onkeyup="tt(1,31)"></div>:<div style="width: 23.5%;"><input class="form-control" type="number" name="hh" id="hh'+no+'" min="0"  max="23" placeholder="hh" onkeyup="tt(2,23)"></div>:<div style="width: 23.5%;"><input class="form-control" type="number" name="mm" id="mm'+no+'" min="0"  max="59" placeholder="mm" onkeyup="tt(3,59)"></div>:<div style="width: 23.5%;"><input class="form-control" type="number" name="ss" id="ss'+no+'" min="0"  max="59" placeholder="ss" onkeyup="tt(4,59)"></div> </div></div>');
            }
            if(fq=='Hour'){
                $('.time'+no).html('<div class="mb-3 col-md-12 row align-items-center"><label for="">Time</label><br><div class="col-md-12 row align-items-center"><div style="width: 23.5%;"><input class="form-control" type="number" name="hh" id="hh'+no+'" min="0"  max="23" placeholder="hh" onkeyup="tt(2,23)"></div>:<div style="width: 23.5%;"><input class="form-control" type="number" name="mm" id="mm'+no+'" min="0"  max="59" placeholder="mm" onkeyup="tt(3,59)"></div>:<div style="width: 23.5%;"><input class="form-control" type="number" name="ss" id="ss'+no+'" min="0"  max="59" placeholder="ss" onkeyup="tt(4,59)"></div> </div></div>');
            }
            if(fq==''){
                $('.time'+no).html('');
            }
        <?php endif?>
    }
    function tt(i,v){
        if(i==1){var x = '#dd';}
        if(i==2){var x = '#hh';}
        if(i==3){var x = '#mm';}
        if(i==4){var x = '#ss';}
        if(i==5){var x = '#dde';}
        if(i==6){var x = '#hhe';}
        if(i==7){var x = '#mme';}
        var tt = $(x).val();
        if(tt>v){
            $(x).val(v);
        }
        if(tt<=v&&tt.length>2){
            $(x).val('00');
        }
        if(i==1){var n=1;}else{var n=0;};
        if(tt<n){
            $(x).val(n);
        }
    }

    $('#schedule-input').change(function() { 
        var data = $(this).val(); 
            $.ajax({
                url: '<?=BASEURL.'/'.PATHURL_ST?>'+'/schedule_input',
                type: "POST",
                data: {
                    "minutes": data,
                },
                
                success:function(){
                    Swal.fire({
                    type: 'success',
                    title: 'Sukses!',
                    text: 'Schedule Input Change to '+ data +' Minutes!',                       
                    timer: 2000,                                
                    showConfirmButton: false
                    });

                    setTimeout(function() {
                        document.location.href = '';
                    }, 1000);
                }
            })
    });
</script>