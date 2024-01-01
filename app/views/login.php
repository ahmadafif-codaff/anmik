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
<div class="vh-100 overflow-auto">
    <div class="vh-100 container d-flex flex-column align-items-center justify-content-center fullwide" style="font-size:small;">
        <div class="col-md-4 shadow rounded bg-white fullwide">
            <div class="text-center text-dark p-2 rounded-1 border-bottom" style=" font-size:medium;">ANMIK</div>
            <a  class="d-flex justify-content-center mt-3 mb-3">
                <img src="<?=BASEURL?>/img/logo.png" class="align-items-center" style="width:70px;">
            </a>
            <h4 class="text-secondary text-center">Sign in to continue</h4>
            <div class="p-3">
                <div class="form-floating text-dark bg-white border border-primary border-top-0 border-end-0 border-start-0 mb-2" style="font-size: medium;">
                    <input type="text" class="form-control" id="username" placeholder="Username" style="border: 0;">
                    <label for="username"><span class="bi-person"></span> Username</label>
                </div>
                <div class="form-floating text-dark bg-white border border-primary border-top-0 border-end-0 border-start-0 mb-2" style="font-size: medium;">
                    <input type="password" class="form-control" id="password" placeholder="Password"  style="border: 0;">
                    <label for="password"><span class="bi-key"></span> Password</label>
                </div>
                <input type="checkbox" onclick="show_password()">&nbsp;<label for="show_password">show password</label>
                <br>
                <br>
                <br>
                <button class="btn w-100 btn-secondary rounded-5" type="submit" id="login" name="login">Login</button>
            </div>
        </div>
        <p class="text-secondary mt-2" style="margin-bottom: -10px;">© 2023 Codaff Project. All right reserved. ANMIK version 2.0</p>
    </div>
</div>