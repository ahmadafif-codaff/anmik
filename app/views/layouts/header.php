<?php
/* 
    ******************************************
    ANMIK
    Copyright © 2023 Codaff Project

    By :
        Ahmaf Afif
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?=BASEURL?>/img/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="../assets/css/bootstrap-5.2.0-dist/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?=BASEURL?>/css/style.css">
    <style>
        .front-home{
            background-image: 
            /* linear-gradient(to right top, #ffffff71, #ffffff71), */
            linear-gradient(to right top, #e2e0ff71, #edebff71),
            /* linear-gradient(to right top, #c3bfff71, #e5e3ff71), */
            <?='url('.BASEURL.'/img/background2.png)'?>;
            background-size: cover;
            background-position: center;
            /* backdrop-filter: blur(5px); */
        }
        .d-flex{
            justify-content: center;
        }
        @media (max-width: 768px) {
            .d-flex{
                justify-content: center;
            }
            .fullwide .col-md-5{
                width: 100%;
            }
        }

    </style>
    <title><?=$data['title']?> ANMIK</title>
    </head>
    <body class="bg-light-blue front-home">
        
