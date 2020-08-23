<?php
//author : Cheah Kah Heng
require_once '../Domain/FactoryMethod/StockFactory.php';
require_once 'ManageStockDA.php';
require_once '../Domain/ManageStock.php';

class StockDA {

    private $dbName = "bianbiansql";
    private $pass = "";
    private $host = 'localhost';
    private $user = "root";
    private $db;

    public function connectdb() {
        try {

            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName;
            $this->db = new PDO($dsn, $this->user, $this->pass);
          
        } catch (PDOException $ex) {
            die("Database connection failed: " . $ex->getMessage());
        }
    }

    public function __construct() {
        $this->connectdb();
    }

    public function AddStock($stock, $staffid) {
        $query = "Insert Into Stock (StockName,UnitPrice,Type,Quantity,WeightUnit) values (?,?,?,?,?)";
        $manageStockDA = new ManageStockDA();
        try {
            $pstm = $this->db->prepare($query);

            $pstm->bindParam(1, $stock->StockName, PDO::PARAM_STR);
            $pstm->bindParam(2, $stock->UnitPrice, PDO::PARAM_STR);
            $pstm->bindParam(3, $stock->Type, PDO::PARAM_STR);
            $pstm->bindParam(4, $stock->Quantity, PDO::PARAM_INT);
            $pstm->bindParam(5, $stock->WeightUnit, PDO::PARAM_STR);
            $pstm->execute();
            $last_id = $this->db->lastInsertId();
            $manageStock = new ManageStock(null, date("Y-m-d"), "Insert", $last_id, $staffid);

            $manageStockDA->AddManageStock($manageStock);
            echo "<h3>Insert Successful</h3>";
        } catch (Exception $ex) {
            echo 'Failed to insert Stock'.$ex->getMessage();
        }
    }

    public function UpdateStock($stock, $staffid) {
        $query = "UPDATE Stock SET StockName=? ,UnitPrice=?, Type=? , Quantity=?, WeightUnit=? WHERE StockID=?";
        $manageStockDA = new ManageStockDA();
        try {

            $pstm = $this->db->prepare($query);
            $pstm->bindParam(1, $stock->StockName, PDO::PARAM_STR);
            $pstm->bindParam(2, $stock->UnitPrice, PDO::PARAM_STR);
            $pstm->bindParam(3, $stock->Type, PDO::PARAM_STR);
            $pstm->bindParam(4, $stock->Quantity, PDO::PARAM_INT);
            $pstm->bindParam(5, $stock->WeightUnit, PDO::PARAM_STR);
            $pstm->bindParam(6, $stock->StockID, PDO::PARAM_STR);
            $pstm->execute();
            $manageStock = new ManageStock(null, date("Y-m-d"), "Update", $stock->StockID, $staffid);
            $manageStockDA->AddManageStock($manageStock);
            echo "<h3>Update Successful</h3>";
        } catch (PDOException $ex) {
            echo 'Failed to Update Stock';
        }
    }


    public function retrieveStocks() {
        $query = "Select * from Stock";
        $rs = $this->db->query($query);
        if ($rs === false) {
            echo 'Record not Found';
        } else {
            return $rs;
        }
    }

    public function retrieveStock($stockId) {
        $query = "Select * from Stock where StockID=?";
        try {
            $pstm = $this->db->prepare($query);
            $pstm->bindParam(1, $stockId, PDO::PARAM_STR);
            $pstm->execute();
            $rs = $pstm->fetch();
            if ($rs === false) {
                return $rs;
            } else {
                return $rs;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
//      
        }
        return $rs;
    }

    public function retrieveStockReport() {
        $query = "Select S.Stockid,S.StockName,S.UnitPrice,S.Type, " .
                "S.WeightUnit, SUM(OD.Quantity) as Soldqty,SUM(OD.SubPrice) as MainTotalPrice"
                . " from Stock S, Orderdetail OD "
                . "Where S.Stockid=OD.Stockid "
                . "Group by OD.Stockid";
        try {
            $pstm = $this->db->prepare($query);

            $pstm->execute();
            $rs = $pstm->fetchAll();
            if ($rs === false) {
                echo 'Without Data';
            } else {
                return $rs;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

}

?>