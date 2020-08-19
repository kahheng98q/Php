<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ManageStock
 *
 * @author user
 */
class ManageStock {

    private $ManageStockID;
    private $EditDate;
    private $Operation;
    private $StockID;
    private $StaffID;

    public function connectdb() {
        try {

            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName;
            $this->db = new PDO($dsn, $this->user, $this->pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            die("Database connection failed: " . $ex->getMessage());
        }
    }

    public function __construct($ManageStockID = "", $EditDate = "", $Operation = "", $StockID = "", $StaffID = "") {
        $this->ManageStockID = $ManageStockID;
        $this->EditDate = $EditDate;
        $this->Operation = $Operation;
        $this->StockID = $StockID;
        $this->StaffID = $StaffID;
    }

    public function &__set($name, $value) {
        $this->$name = $value;
    }

    public function &__get($name) {
        return $this->$name;
    }

}
