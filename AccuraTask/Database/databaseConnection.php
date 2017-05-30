<?php

class DatabaseConnection{
    private $conn;

    public function connectToDB(){
        require_once 'Database/config.php';
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        return $this->conn;
    }
}