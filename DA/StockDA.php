<?php

require_once '../FactoryMethod/StockFactory.php';
require_once '../FactoryMethod/StockLiquid.php';

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
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            die("Database connection failed: " . $ex->getMessage());
        }
    }

    public function __construct() {
        $this->connectdb();
    }

    public function AddStock($stock) {
        $query = "Insert Into Stock (StockID,StockName,UnitPrice,Type,Quantity,WeightUnit) values (?,?,?,?,?,?)";

        try {

            $pstm = $this->db->prepare($query);
            $pstm->bindParam(1, $stock->StockID, PDO::PARAM_STR);
            $pstm->bindParam(2, $stock->StockName, PDO::PARAM_STR);
            $pstm->bindParam(3, $stock->UnitPrice, PDO::PARAM_STR);
            $pstm->bindParam(4, $stock->Type, PDO::PARAM_STR);
            $pstm->bindParam(5, $stock->Quantity, PDO::PARAM_INT);
            $pstm->bindParam(6, $stock->WeightUnit, PDO::PARAM_STR);
            $pstm->execute();

            echo "<h3>Insert Successful</h3>";
        } catch (Exception $ex) {
            echo 'Failed to insert Stock';
        }
    }

    public function UpdateStock($stock) {
        $query = "UPDATE Stock SET StockName=? ,UnitPrice=?, Type=? , Quantity=?, WeightUnit=? WHERE StockID=?";

        try {

            $pstm = $this->db->prepare($query);
            $pstm->bindParam(1, $stock->StockName, PDO::PARAM_STR);
            $pstm->bindParam(2, $stock->UnitPrice, PDO::PARAM_STR);
            $pstm->bindParam(3, $stock->Type, PDO::PARAM_STR);
            $pstm->bindParam(4, $stock->Quantity, PDO::PARAM_INT);
            $pstm->bindParam(5, $stock->WeightUnit, PDO::PARAM_STR);
            $pstm->bindParam(6, $stock->StockID, PDO::PARAM_STR);
            $pstm->execute();

            echo "<h3>Update Successful</h3>";
        } catch (PDOException $ex) {
            echo 'Failed to Update Stock';
        }
    }

    public function deleteStock($stockId) {
        $query = 'DELETE FROM Stock WHERE StockID =?';
        try {
            $pstm = $this->db->prepare($query);

            $pstm->bindParam(1, $stockId, PDO::PARAM_STR);
            $pstm->execute();
            echo "<h3>" . $stockId . "Delete Successful</h3>";
            return $pstm->rowCount();
        } catch (Exception $ex) {
            echo $ex->getMessage();
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
//                echo $rs["StockID"];
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
                "S.WeightUnit"
                . ",Count(OD.Quantity) as Soldqty,Count(OD.TotalAmount) as MainTotalPrice"
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

//    public function getID() {
////        $seq = "select Stock_Seq.nextval from dual";
//        $seq = "SELECT * FROM stock_seq";
////        $seq = "SELECT sysdate()";
//        $rs = $this->db->query($seq);
//        foreach ($rs as $row) {
//            echo $row['next_not_cached_value'];
//        }
////         echo $row['Stock_Seq.nextval'];
//        echo $rs[2];
//    }
//
//}
}

$work = new StockDA();
$S = new StockFactory();
//$shit = $S->setStock("ST008", "GOOD", "10.00", "LIQUID", 4, 3.00);
//$shit = $S->setStock("ST010", "Coke", 10.00, "LIQUID", 4, 3.00);
//$work->AddStock($shit);
//$work->UpdateStock($shit);
//$work->deleteStock("ST008")
//$gg=$work->retrieveStock("ST007");

//echo $gg['StockID'];
//$result = $work->retrieveStockReport();
//
//foreach ($result as $row) {
////            echo '1';
//    echo $row['Stockid']."<br/>";
//}
//$work->getID();
?>