<script>
    function select_frequency(no=''){
        var fq = $('#frequency'+no).val();
        if(fq=='Day'){
            $('.time'+no).html('<label for="">Time</label><br><div class="col-md-12 row align-items-center"><div style="width: 23.5%;"><input class="form-control" type="number" name="dd" id="dd'+no+'" min="1" max="31" placeholder="dd" onkeyup="tt(1,31)"></div>:<div style="width: 23.5%;"><input class="form-control" type="number" name="hh" id="hh'+no+'" min="0"  max="23" placeholder="hh" onkeyup="tt(2,23)"></div>:<div style="width: 23.5%;"><input class="form-control" type="number" name="mm" id="mm'+no+'" min="0"  max="59" placeholder="mm" onkeyup="tt(3,59)"></div>:<div style="width: 23.5%;"><input class="form-control" type="number" name="ss" id="ss'+no+'" min="0"  max="59" placeholder="ss" onkeyup="tt(4,59)"></div> </div>');
        }
        if(fq=='Hour'){
            $('.time'+no).html('<label for="">Time</label><br><div class="col-md-12 row align-items-center"><div style="width: 23.5%;"><input class="form-control" type="number" name="hh" id="hh'+no+'" min="0"  max="23" placeholder="hh" onkeyup="tt(2,23)"></div>:<div style="width: 23.5%;"><input class="form-control" type="number" name="mm" id="mm'+no+'" min="0"  max="59" placeholder="mm" onkeyup="tt(3,59)"></div>:<div style="width: 23.5%;"><input class="form-control" type="number" name="ss" id="ss'+no+'" min="0"  max="59" placeholder="ss" onkeyup="tt(4,59)"></div> </div>');
        }
        if(fq==''){
            $('.time'+no).html('');
        }
    }
    function tt(i,v){
        if(i==1){var x = '#dd';}
        if(i==2){var x = '#hh';}
        if(i==3){var x = '#mm';}
        if(i==4){var x = '#ss';}
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