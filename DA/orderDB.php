<?php
//author: Chia Yang Jie
class orderDB {

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

    public function getOrderByCust($cid) {
        $query = "SELECT * FROM orders WHERE CustomerId='" . $cid . "'";
        $rs = $this->db->query($query);
        if ($rs === false) {
            echo 'Record not Found';
        } else {
            return $rs;
        }
    }

    public function retrieveAllOrder() {
        $query = "Select * from orders";
        $rs = $this->db->query($query);
        if ($rs === false) {
            echo 'Record not Found';
        } else {
            return $rs;
        }
    }

}

?>