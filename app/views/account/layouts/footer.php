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
            <br>
            <p class="text-secondary">© 2023 Codaff Project. All right reserved. ANMIK version 2.0</p>
            <br>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="<?=BASEURL?>/js/ajax-jquery-3.4.1/jquery.min.js"></script>
    <script src="<?=BASEURL?>/js/sweatalert2/sweetalert2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/7qrbxnkdphzuvnmchzx0u6qnfiptzke1ui5awvuz1mg24wyy/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <?php
        require 'script/main.php';
        require 'script/logout.php';
        require 'script/reboot_mikrotik.php';
        if(!in_array(PATHURL_ST, ['dashboard', 'pengaturan'])){
            require 'script/data.php'; // !dashboard!pengaturan
        }
        if(!in_array(PATHURL_ST, ['dashboard', 'log','dhcp'])){
            require 'script/data_add_edit.php'; // !dashboard!log!dhcp
        }
        if(!in_array(PATHURL_ST, ['dashboard', 'log', 'pengaturan'])){
            require 'script/data_delete.php'; // !dashboard!log!pengaturan
        }
        if(!in_array(PATHURL_ST, ['dashboard', 'log', 'pengaturan', 'paket'])){
            require 'script/data_set_action.php'; // !dashboard!log!pengaturan!paket
        }
        if(!in_array(PATHURL_ST, ['dhcp', 'log'])){
            require 'script/'.PATHURL_ST.'.php'; // !dhcp!log
        }
    ?>
</body>
</html>