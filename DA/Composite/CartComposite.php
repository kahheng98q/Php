<?php
require_once '../Security/OrderSecurity.php';

/*
Joseph Yeak Jian King
 */

class CartComposite {
    private $host = 'localhost';
    private $dbName = "bianbiansql";
    private $user = 'root';
    private $db = "";

    public function databaseConnection() {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName;
            $this->db = new PDO($dsn, $this->user);
        } catch (PDOException $ex) {
            die("Database connection failed: " . $ex->getMessage());
        }
    }

    public function __construct() {
        $this->databaseConnection();
    }

    public function DeleteCartItem($stockID, $customerID) {
        try {
            $orderSecurity = new OrderSecurity();
            $checkItemInCartDelete = $orderSecurity->CheckItemInCartDelete($stockID, $customerID);

            if ($checkItemInCartDelete == true) {
                $query = 'DELETE FROM Cart WHERE StockID=? AND CustomerID=?';
                $pstm = $this->db->prepare($query);

                $pstm->bindParam(1, $stockID, PDO::PARAM_STR);
                $pstm->bindParam(2, $customerID, PDO::PARAM_STR);
                $pstm->execute();
                echo '<script language="javascript"> alert("Item was deleted.") </script>';
            } else {
                echo '<script language="javascript"> alert("No such item in your cart.") </script>';
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function retrieveForXML($customerID) {
        $query = "SELECT C.CartID,C.StockID,S.StockName,C.Quantity,C.SubPrice FROM Cart C, Stock S WHERE customerID='".$customerID."' AND C.StockID=S.StockID";
        $resultSet = $this->db->query($query);
        if ($resultSet === false) {
            echo 'Record not Found';
        } else {
            return $resultSet;
        }
    }
}