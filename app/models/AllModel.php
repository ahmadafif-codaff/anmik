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

class AllModel extends Models{

    public function data($table, $where){
        $this->where($table, $where);
        return $this->getAll();
    }

    public function dataArr($table, $select, $where){
        $this->select($table, $select, $where);
        return $this->getAllArr();
    }

    public function dataJoin($table,  $join, $tableJoin, $value){
        $this->join($table, $join, $tableJoin, $value);
        return $this->getAll();
    }

    public function whereGet($table, $where){
        $this->where($table, $where);
        return $this->get();
    }
    
}

?>