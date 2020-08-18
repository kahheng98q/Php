<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once '../FactoryMethod/StockLiquid.php';
require_once '../DA/StockDA.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $stockFactory = new StockFactory();
        $stockDA = new StockDA();


        if (isset($_POST['addStockbtn'])) {
            $staffID = $_POST["staffID"];
            ?>
            <h3> Add new Stock</h3>
            <form  action="InsertStock.php" method="POST">
                <p>Stock Name:<input type="text" name="StockName" value="" size="20"/></p>
                <p> Unit Price:<input type="text" name="UnitPrice" value="" size="20"/></p>
                <p> Type:<input type="text" name="Type" value="" size="20"/></p>
                <p> Quantity:<input type="text" name="Quantity" value="" size="20"/></p>
                <p> Weight Unit:<input type="text" name="WeightUnit" value="" size="20"/></p>
                <input type="submit" value="Add" name="insertStockbtn" />
            </form>
            <?php
        } elseif (isset($_POST['updateStockbtn'])) {
            $stockid = $_POST["StockID"];
            $rs = $stockDA->retrieveStock($stockid);
            if ($rs === false) {
                echo 'Record Not Found';
            } else {
                ?>
                <h3> Update Stock</h3>
                <form action="InsertStock.php" method="POST">
                    <?php
                    echo "<input type=\"hidden\" name=\"UpdateStockid\" value=\"" . $stockid . "\"/>";
                    ?>
                    <p>Stock Name:<input type="text" name="UpdateStockName" value="" size="20"/></p>
                    <p> Unit Price:<input type="text" name="UpdateUnitPrice" value="" size="20"/></p>
                    <p> Type:<input type="text" name="UpdateType" value="" size="20"/></p>
                    <p> Quantity:<input type="text" name="UpdateQuantity" value="" size="20"/></p>
                    <p> Weight Unit:<input type="text" name="UpdateWeightUnit" value="" size="20"/></p>
                    <input type="submit" value="update" name="UpdateStockbtn" />
                </form>

                <?php
            }
        } elseif (isset($_POST['DeleteStockbtn'])) {
            $stockid = $_POST["StockID"];
            $rs = $stockDA->retrieveStock($stockid);
            if ($rs === false) {
                echo 'Record Not Found';
            } else {
                $stockDA->deleteStock($stockid);
            }
        } else if (isset($_POST['insertStockbtn'])) {

            $stockname = $_POST["StockName"];
            $stockprice = $_POST["UnitPrice"];
            $stocktype = $_POST["Type"];
            $stockqty = $_POST["Quantity"];
            $stockUnit = $_POST["WeightUnit"];
//            $stock=$stockFactory->setStock($StockID, $StockName, $UnitPrice, $Type, $Volume, $Quantity);

            echo $stockname . $stockprice . $stocktype . $stockqty . $stockUnit;
        } else if (isset($_POST['UpdateStockbtn'])) {
            $stockid = $_POST["UpdateStockid"];
            $stockname = $_POST["UpdateStockName"];
            $stockprice = $_POST["UpdateUnitPrice"];
            $stocktype = $_POST["UpdateType"];
            $stockqty = $_POST["UpdateQuantity"];
            $stockUnit = $_POST["UpdateWeightUnit"];
            $stock = $stockFactory->setStock($stockid, $stockname, $stockprice, $stocktype, $stockqty, $stockUnit);
            $stockDA->UpdateStock($stock);
            echo $stockid . $stockname . $stockprice . $stocktype . $stockqty . $stockUnit;
        }
        ?> <br/> <br/>

        <form action="ManageStock.php" method="POST">
            <input type="submit" value="Back" name="backbtn" />
        </form>


    </body>
</html>
