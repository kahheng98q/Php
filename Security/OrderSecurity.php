<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderSecurity
 *
 * @author user
 */
class OrderSecurity {

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

    public function CheckStockAvailable($stockID) {
        try {
            $checkStockID = false;

            $query2 = "SELECT * FROM STOCK";
            $resultSet2 = $this->db->query($query2);

            foreach ($resultSet2 as $row2) {
                if ($stockID == $row2["StockID"]) {
                    $checkStockID = true;
                    break;
                } else {
                    $checkStockID = false;
                }
            }
            return $checkStockID;
        } catch (Exception $ex) {
            
        }
    }

    public function CheckStockQuantity($stockID, $quantity) {
        try {
            $checkStockQuantity = false;

            $query3 = "SELECT * FROM STOCK  WHERE StockID='" . $stockID . "'";
            $resultSet3 = $this->db->query($query3);

            foreach ($resultSet3 as $row3) {
                if ($quantity > $row3["Quantity"]) {
                    $checkStockQuantity = false;
                } else {
                    $checkStockQuantity = true;
                }
            }
            return $checkStockQuantity;
        } catch (Exception $ex) {
            
        }
    }

    public function CheckStockInCart($customerID, $stockID) {
        try {
            $findStock = false;

            $query4 = "SELECT * FROM CART WHERE CustomerID='" . $customerID . "'";
            $resultSet4 = $this->db->query($query4);

            foreach ($resultSet4 as $row4) {
                if ($stockID == $row4["StockID"]) {
                    $findStock = true;
                }
                if (!$resultSet4) {
                    $findStock = false;
                }
            }
            return $findStock;
        } catch (Exception $ex) {
            
        }
    }

    public function CheckItemInCartDelete($stockID, $customerID) {
        try {
            $checkStockID = true;

            $query2 = "SELECT * FROM CART WHERE CustomerID='" . $customerID . "'";
            $resultSet2 = $this->db->query($query2);

            foreach ($resultSet2 as $row2) {
                if ($stockID != $row2["StockID"]) {
                    $checkStockID = false;
                } else {
                    $checkStockID = true;
                }
            }
            return $checkStockID;
        } catch (Exception $ex) {
            
        }
    }

}
