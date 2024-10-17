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
<!DOCTYPE html>
<html lang="in">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?=BASEURL?>/css/style.css">
    <link rel="shortcut icon" href="<?=BASEURL?>/img/logo.png" type="image/x-icon">
    <title><?=$data['title']?> - ANMIK</title>
    <style>
        .col-md-7{
            width:65.5%;
        }
        .col-md-3{
            width:32%;
        }
    </style>
</head>
<body class="bg-light-blue">
        <nav class="navbar navbar-expand-lg bg-white shadow-sm">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn border-0">
                <div id="humberger-side">
                    <div class="humberger-side-stik bg-secondary"></div>
                    <div class="humberger-side-stik bg-secondary"></div>
                    <div class="humberger-side-stik bg-secondary"></div>
                </div>
                </button>
                <a href="" class="d-flex">
                    <img src="<?=BASEURL?>/img/logo.png" alt="" style="width:40px;" class="drop-shadow">
                    <h4 class="text-secondary m-auto"> ANMIK</h4>
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="w-100 d-flex justify-content-end text-secondary "></div>
                    <a href="" class="border-start p-2 ms-1 pointer" title="reload data" id="btn_load" style="width: fit-content; height:fit-content;"><input type="hidden" id="val_load" name="" value="0"><div class="bi-arrow-repeat" id="icon_load"></div></a>
                </div>
            </div>
        </nav>
    <div class="d-flex wh-100 vh-100 overflow-hidden"  style="margin-top:-56px; padding-top:56px; font-size: smaller;">
        <nav id="sidebar" class="overflow-auto text-secondary overflow-scroll">
            <div class="sidebar-header text-center d-flex flex-column align-items-center">
                <br>
                <div class="border rounded-5 d-flex justify-content-center align-items-center" style="height: 60px; width: 60px;">
                    <img src="<?=BASEURL?>/img/logo.png" alt="logo" style="width:100%;" class="drop-shadow">
                </div>
                <h5 class="text-secondary"><?=$data['name']?></h5>
            </div>
            <div class="mt-1 mb-1 border-bottom border-2"></div>
            <ul class="list-unstyled components overflow-auto" style="height: 65%;">
                <li class="<?php if(PATHURL_ST=='dashboard_client'){echo "active";} ?>">
                    <a class="text-decoration-none m-1" style="border-radius: 5px 15px 5px 15px;" href="<?=BASEURL?>/dashboard_client"><span class="bi-speedometer2"></span> Dashboard</a>
                </li>
                <li>
                    <a class="text-decoration-none m-1" style="border-radius: 5px 15px 5px 15px;" id="logout" onclick="return logout()"><span class="bi-box-arrow-left"></span> Logout</a>
                </li>
            </ul>
        </nav>
            
        <div id="content" class="overflow-auto p-4">
            <div class="col-md-12 row justify-content-between">
                <div class="col-md-6 row justify-content-end">
                </div>
            </div>
