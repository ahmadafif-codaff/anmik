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
<div class="mb-3 row justify-content-end me-1">
        <button class="btn-sm btn btn-primary w-auto" data-bs-toggle="modal" data-bs-target="#Modal">Edit Profil</button>
    </div>
    <div class="rounded bg-white p-3 shadow mb-3">
        <div class="mb-3">
            <label for="">Nama</label>
            <input type="text" class="form-control bg-white"value="<?=$data['user']->nama?>" disabled>
        </div>
        <div class="mb-3">
            <label for="">Username</label>
            <input type="text" class="form-control bg-white" value="<?=$data['user']->username?>" disabled>
        </div>
    </div>
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5" id="ModalLabel" style="font-size: large">Edit Profil</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Nama </label>
                        <input type="text" name="nama" class="form-control" placeholder="nama" id="nama" value="<?=$data['user']->nama?>">
                        <div class="text-danger" id="if-nama"></div>
                    </div>
                    <div class="mb-3">
                        <label for="">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="username" id="username" value="<?=$data['user']->username?>">
                        <div class="text-danger" id="if-username"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary" onclick="add_ed('profil', '', '')">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3 row justify-content-end me-1">
        <button class="btn-sm btn btn-primary w-auto" data-bs-toggle="modal" data-bs-target="#Modal1">Edit Password</button>
    </div>
    <div class="rounded bg-white p-3 shadow">
        <div class="mb-3">
            <label for="">Password</label>
            <input type="password" class="form-control bg-white"value="password" disabled>
        </div>
    </div>
    <div class="modal fade" id="Modal1" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5" id="ModalLabel" style="font-size: large">Edit Password</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="password" id="password" value="">
                        <input type="checkbox" onclick="show_password()">&nbsp;<label for="show_password">show password</label>
                        <div class="text-danger" id="if-password"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary" onclick="add_ed('password', '', '')">Save</button>
                </div>
            </div>
        </div>
    </div>