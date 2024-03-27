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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="<?=BASEURL?>/js/ajax-jquery-3.4.1/jquery.min.js"></script>
    <script src="<?=BASEURL?>/js/sweatalert2/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#username').keyup(function(){
                var username = $('#username').val();
                if(username!=0){
                    $('#login').attr("class", "btn w-100 btn-bg-gradient-purple rounded-5");
                    $('#login').attr("onclick", "login()");
                }else{
                    $('#login').attr("class", "btn w-100 btn-secondary rounded-5");
                    $('#login').attr("onclick", "");
                }
            });
        })
        
        function login() { 
            var username = $('#username').val();
            var password = $('#password').val();
            var form_data = new FormData();
            form_data.append("username", username);
            form_data.append("password", password);
            
            $.ajax({
                url: "<?=BASEURL?>/login_client/proses",
                type: "POST",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                
                success:function(response){
                    if (response == "success") {
                        document.location.href = '<?=BASEURL?>/dashboard_client';
                    }
                    else{
                        Swal.fire({
                        type: 'error',
                        title: 'Oops',
                        text: 'login gagal, username atau password salah',                       
                        timer: 10000,                                
                        // showConfirmButton: false
                        });
                    }
                }
            })
        }
        
        function show_password() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
        
    </script>
</body>
</html>