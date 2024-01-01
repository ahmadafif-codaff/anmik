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

class Models{
    private $db;

    public function __construct()
    {
        $this->db = new Database;

        // Logging::log('visit', 1, 'NetMik by Codaff Project', '');
    }

    public function select($table, $select, $where){
        $this->db->query("SELECT $select FROM $table WHERE $where");
    }

    public function where($table, $where){
        $this->db->query("SELECT * FROM $table WHERE $where");
    }

    public function limit($table, $limit){
        $this->db->query("SELECT * FROM $table LIMIT $limit");
        return $this->db->resultSet();
    }

    public function join($table, $join, $tableJoin, $value){
        $this->db->query("SELECT * FROM $table $join $tableJoin $value");
    }

    public function get(){
        return $this->db->single();
    }

    public function getAll(){
        return $this->db->resultSet();
    }

    public function getAllArr(){
        return $this->db->resultSetArr();
    }
    
    public function all($table){
        $this->db->query("SELECT * FROM $table");
        return $this->db->resultSet();
    }
    
    public function insert($table, $value){
        $this->db->query("INSERT INTO $table VALUES($value)");
        $this->db->execute();
        return $this->db->rowCount();
    }
    
    public function update($table, $value, $where){
        $this->db->query("UPDATE $table SET $value WHERE $where");
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function delete($table, $value){
        $this->db->query("DELETE FROM $table WHERE $value");
        $this->db->execute();
        return $this->db->rowCount();
    }

}

?>