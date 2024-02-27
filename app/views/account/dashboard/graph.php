
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

$graph_frequency = PATHURL_ND;
$maxh_frequency = 'max_'.explode('_',PATHURL_ND)[1];
foreach ($data[$graph_frequency] as $r){
    $max = $data[$maxh_frequency]['max'];

    $graph1st = $r['graph1st'];
    $graph2nd = $r['graph2nd'];

    $height1 = 3+($graph1st/$max)*95;
    $height2 = 3+($graph2nd/$max)*95;

    $download = Format::bytes($graph1st, 'byte');
    $upload = Format::bytes($graph2nd, 'byte');

    if(PATHURL_ND=='graph_daily'){
        $hour = $r['hour'];
        $minutes = $r['minutes'];
        if($hour<10){
            $hour = '0'.$hour;
        }
        if($minutes<10){
            $minutes = '0'.$minutes;
        }
        $time = $hour.':'.$minutes;
    
        $hours = '';
        if($minutes=='00'){
            $hours = '<div class="" style="margin-right:-10px; font-size:small;">'.$hour.'</div>';
        }

        $width = 3.5;
        $box = ' <br>Time : '.$time;
        $graph_bottom = $hours;
    }

    if(PATHURL_ND=='graph_monthly'){
        $year = $r['year'];
        $month = $r['month'];
        $monthname = $r['monthname'];
        $day = $r['day'];
        $dayname = $r['dayname'];

        $width = 10;
        $box = ' <br>Date : '.$dayname.', '.$day.' '.$monthname.' '.$year;
        $graph_bottom = $day;
    }

    if(PATHURL_ND=='graph_yearly'){
        $year = $r['year'];
        $month = $r['month'];
        $monthname = $r['monthname'];

        $width = 30;
        $box = ' <br>Date : '.$monthname.' '.$year;
        $graph_bottom = $monthname;
    }

    ?>
    <div class="h-100">
        <div class="h-100 d-flex align-items-end pb-2 text-light">
            <?php
                if($graph1st!=0){
                    echo '<div class="bg-danger shadow graph"  style="height:'.$height1.'%; width:'.$width.'px; margin-right:1px;"><div class="box-graph bg-danger text-start rounded p-2 shadow ms-3">Download : '.$download.$box.'</div></div>';
                }
                if($graph2nd!=0){
                    echo '<div class="bg-primary-dark shadow graph"  style="height:'.$height2.'%; width:'.$width.'px; margin-right:1px;"><div class="box-graph bg-primary-dark text-start rounded p-2 shadow ms-3">Upload : '.$upload.$box.'</div></div>';
                }
                ?>
        </div>
        <div class="me-1 text-center" style="margin-top:-10px;"><?=$graph_bottom?></div>
    </div>
    <?php
}?>
<style>
    .box-graph{
        display:none;
        position:absolute;
        width:170px;
        margin-top:-20px;
        transition: all 0.2s;
    }
    .graph:hover .box-graph{
        display:block;
    }
</style>
<script>
    $(document).ready(function(){
        $(".graph").mousemove(function(){
            graph();
        })
    })
    function graph(){
        $(".box-graph").css("top", event.pageY);
        let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
        if (isMobile) {
            if(event.pageX>=220){
                $(".box-graph").css("left", event.pageX-200); 
            }else{
                $(".box-graph").css("left", event.pageX);
            }
        }else{
            if(event.pageX>=720){
                $(".box-graph").css("left", event.pageX-200); 
            }else{
                $(".box-graph").css("left", event.pageX);
            }
        }
        // $(".a").html(event.pageX);
    }
</script>