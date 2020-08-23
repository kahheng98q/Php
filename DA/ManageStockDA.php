<?php

require_once '../Domain/ManageStock.php';

class ManageStockDA {

    private $dbName = "bianbiansql";
    private $pass = "";
    private $host = 'localhost';
    private $user = "root";
    private $db;

    public function connectdb() {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName;
            $this->db = new PDO($dsn, $this->user, $this->pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            die("Database connection failed: " . $ex->getMessage());
        }
    }

    public function __construct() {
        $this->connectdb();
    }

    public function AddManageStock($manageStock) {
        $query = "Insert Into ManageStock (EditDate,Operation,StockID,StaffID) values (?,?,?,?)";

        try {
            $pstm = $this->db->prepare($query);
            $pstm->bindParam(1, $manageStock->EditDate, PDO::PARAM_STR);
            $pstm->bindParam(2, $manageStock->Operation, PDO::PARAM_STR);
            $pstm->bindParam(3, $manageStock->StockID, PDO::PARAM_STR);
            $pstm->bindParam(4, $manageStock->StaffID, PDO::PARAM_STR);
            $pstm->execute();
            
        } catch (Exception $ex) {
            echo 'Failed to Manage Stock Record';
        }
    }

}
