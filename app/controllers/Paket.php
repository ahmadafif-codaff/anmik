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

class Paket extends Controller{
    private $table;
    private $user;

    public function __construct()
    {
        $this->authentication()->auth();
        $this->table = 'paket';
        $this->user = $this->model('SessionModel')->user();
    }

    public function index(){
        $data['title'] = "Paket";
        $data['user'] = $this->user;

        $this->view('account/layouts/header', $data);
        $this->view('account/data');
        $this->view('account/layouts/footer', $data);
    }

    public function data(){
        $search = Filter::request('','search');
        $show = Filter::request(30,'row');
        $start = Filter::page(0, $show);

        $data['title'] = "Paket";
        $data['user'] = $this->user;

        $paket = $this->model('AllModel')->dataArr($this->table, '*', "nama LIKE '%$search%' OR harga LIKE '%$search%' OR kategori LIKE '%$search%' OR max_upload LIKE '%$search%' OR max_download LIKE '%$search%' OR kuota LIKE '%$search%' LIMIT $start,$show");
        $array = [];
        foreach ($paket as $r){
            $kategori = $r['kategori'];
            if($kategori=="Kuota"){
                $kategori .= ' <span class="text-danger">(Limited)</span>';
            }elseif($kategori=="Regular"){
                $kategori .= ' <span class="text-success">(Unlimited with FUP)</span>';
            }elseif($kategori=="Premium"){
                $kategori .= ' <span class="text-primary">(Unlimited)</span>';
            }

            $download2 = $r['bandwidth_kedua']*$r['max_download'].' Mbps ('.($r['bandwidth_kedua']*100).'%)';
            $download3 = $r['bandwidth_ketiga']*$r['max_download'].' Mbps ('.($r['bandwidth_ketiga']*100).'%)';
            $upload2 = $r['bandwidth_kedua']*$r['max_upload'].' Mbps ('.($r['bandwidth_kedua']*100).'%)';
            $upload3 = $r['bandwidth_ketiga']*$r['max_upload'].' Mbps ('.($r['bandwidth_ketiga']*100).'%)';
            $kuota = $r['kuota'].' GB';
            $kuota2 = $r['kuota_kedua']*$r['kuota'].' GB ('.($r['kuota_kedua']*100).'%)';

            if(in_array("", [$r['bandwidth_kedua'],$r['bandwidth_ketiga']])){ 
                $download2 = '<span class="text-danger">Not Available</span>';
                $download3 = '<span class="text-danger">Not Available</span>';
                $upload2 = '<span class="text-danger">Not Available</span>';
                $upload3 = '<span class="text-danger">Not Available</span>';
            }
            if($r['kuota']==""){ 
                $kuota = '<span class="text-danger">Not Available</span>';
            }
            if($r['kuota_kedua']==""){ 
                $kuota2 = '<span class="text-danger">Not Available</span>';
            }

            $p = $r;
            $p['harga_format'] = 'Rp. '.number_format($r['harga']);
            $p['kategori_ket'] = $kategori;
            $p['download2'] = $download2;
            $p['download3'] = $download3;
            $p['upload2'] = $upload2;
            $p['upload3'] = $upload3;
            $p['kuota_format'] = $kuota;
            $p['kuota2'] = $kuota2;

            $array[] = $p;
        }
        $data['data'] = json_decode(json_encode($array));
        $count_all = count($this->model('AllModel')->data($this->table, "nama LIKE '%$search%' OR harga LIKE '%$search%' OR kategori LIKE '%$search%' OR max_upload LIKE '%$search%' OR max_download LIKE '%$search%' OR kuota LIKE '%$search%'"));
        $data['count_data'] = count($data['data']) ;
        $data['no'] = $start;
        
        $data['page'] = ceil($count_all/$show);

        $this->view('account/paket', $data);
    }

    public function store(){
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $kategori = $_POST['kategori'];
        $max_upload = $_POST['max_upload'];
        $max_download = $_POST['max_download'];
        $bandwidth_kedua = $_POST['bandwidth_kedua'];
        $bandwidth_ketiga = $_POST['bandwidth_ketiga'];
        $kuota = $_POST['kuota'];
        $kuota_kedua = $_POST['kuota_kedua'];

        $harga         = explode('Rp. ',addslashes($_POST['harga']))[1];
        $harga         = explode('.',$harga)[0].explode('.',$harga)[1].explode('.',$harga)[2].explode('.',$harga)[3].explode('.',$harga)[4].explode('.',$harga)[5];

        $rules = [
                    "nama"=>"$nama=required|unique",
                    "harga"=>"$harga=required",
                    "kategori"=>"$kategori=required",
                    "max_upload"=>"$max_upload=required",
                    "max_download"=>"$max_download=required",
                ];

        if($kategori=='Premium'){
            $bandwidth_kedua = '';
            $bandwidth_ketiga = '';
            $kuota = '';
            $kuota_kedua = '';
        }

        if($kategori=='Kuota'){
            $bandwidth_kedua = '';
            $bandwidth_ketiga = '';
            $kuota_kedua = '';

            $rules += [
                        "kuota"=>"$kuota=required",
                    ];
        }

        if($kategori=='Regular'){
            $rules += [
                        "bandwidth_kedua"=>"$bandwidth_kedua=required",
                        "bandwidth_ketiga"=>"$bandwidth_ketiga=required",
                        "kuota"=>"$kuota=required",
                        "kuota_kedua"=>"$kuota_kedua=required",
                    ];
        }

        Validator::validate($rules, $this->table);

        if($this->model('AllModel')->insert($this->table, "null, '$nama', '$harga','$kategori', '$max_upload', '$max_download', '$bandwidth_kedua', '$bandwidth_ketiga', '$kuota', '$kuota_kedua'")){
            Logging::log('tambah_paket', 1, "Paket <i>$nama</i> kategori <i>$kategori</i> ditambahkan", $this->user->username);
            Flasher::success('tambah', $this->table);
        }else{
            Logging::log('tambah_paket', 0, "Paket <i>$nama</i> kategori <i>$kategori</i> gagal ditambahkan", $this->user->username);
            Flasher::error('tambah', $this->table);
        }
    }

    public function edit($id){
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $kategori = $_POST['kategori'];
        $max_upload = $_POST['max_upload'];
        $max_download = $_POST['max_download'];
        $bandwidth_kedua = $_POST['bandwidth_kedua'];
        $bandwidth_ketiga = $_POST['bandwidth_ketiga'];
        $kuota = $_POST['kuota'];
        $kuota_kedua = $_POST['kuota_kedua'];

        $harga         = explode('Rp. ',addslashes($_POST['harga']))[1];
        $harga         = explode('.',$harga)[0].explode('.',$harga)[1].explode('.',$harga)[2].explode('.',$harga)[3].explode('.',$harga)[4].explode('.',$harga)[5];

        $rules = [
                    "nama"=>"$nama=required",
                    "harga"=>"$harga=required",
                    "kategori"=>"$kategori=required",
                    "max_upload"=>"$max_upload=required",
                    "max_download"=>"$max_download=required",
                ];

        if($kategori=='Premium'){
            $bandwidth_kedua = '';
            $bandwidth_ketiga = '';
            $kuota = '';
            $kuota_kedua = '';
        }

        if($kategori=='Kuota'){
            $bandwidth_kedua = '';
            $bandwidth_ketiga = '';
            $kuota_kedua = '';

            $rules += [
                        "kuota"=>"$kuota=required",
                    ];
        }

        if($kategori=='Regular'){
            $rules += [
                        "bandwidth_kedua"=>"$bandwidth_kedua=required",
                        "bandwidth_ketiga"=>"$bandwidth_ketiga=required",
                        "kuota"=>"$kuota=required",
                        "kuota_kedua"=>"$kuota_kedua=required",
                    ];
        }

        $data = $this->model('AllModel')->whereGet("$this->table", "id_$this->table='$id'");
        
        if($nama!=$data->nama){
            $rules['nama'] = "$nama=required|unique";
        }

        Validator::validate($rules, $this->table);

        if($this->model('AllModel')->update($this->table, "nama='$nama', harga='$harga', kategori='$kategori', max_upload='$max_upload', max_download='$max_download', bandwidth_kedua='$bandwidth_kedua', bandwidth_ketiga='$bandwidth_ketiga', kuota='$kuota', kuota_kedua='$kuota_kedua'", "id_$this->table='$id'")>0){
            $edit = "";
            if($nama!=$data->nama||$kategori!=$data->kategori){
                $edit = "menjadi ";
            }
            if($nama!=$data->nama){
                $edit .= "<i>$nama</i> ";
            }
            if($kategori!=$data->kategori){
                $edit .= "kategori <i>$kategori</i>";
            }
            Logging::log('edit_paket', 1, "Paket <i>$data->nama</i> kategori <i>$data->kategori</i> diubah $edit", $this->user->username);
            Flasher::success('ubah', $this->table);
        }else{
            Logging::log('edit_paket', 0, "Paket <i>$nama</i> kategori <i>$kategori</i> gagal diubah", $this->user->username);
            Flasher::error('ubah', $this->table);
        }
    }

    public function drop($id){
        $data = $this->model('AllModel')->whereGet("$this->table", "id_$this->table='$id'");
        if($this->model('AllModel')->delete($this->table, "id_$this->table='$id'")>0){
            Logging::log('hapus_paket', 1, "Paket <i>$data->nama</i> kategori <i>$data->kategori</i> dihapus", $this->user->username);
            Flasher::success('hapus', $this->table);
        }else{
            Logging::log('hapus_paket', 0, "Paket <i>$data->nama</i> kategori <i>$data->kategori</i> gagal dihapus", $this->user->username);
            Flasher::error('hapus', $this->table);
        }
    }
}

?>