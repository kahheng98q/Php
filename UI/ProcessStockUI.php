<!DOCTYPE html>

<?php
require_once '../DA/StockDA.php';
require_once '../XML/StockDomParser.php';
require_once '../Security/StockSecurity.php';
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
        $stockSecurity = new StockSecurity();
        $staffID = $_POST["staffid"];

        if (isset($_POST['Addbtn'])) {
            ?>
            <h3> Add new Stock</h3>
            <form  action="ProcessStockUI.php" method="POST">
                <?php
                echo "<input type=\"hidden\" name=\"staffid\" value=\"" . $staffID . "\"/>";
                ?>
                <p>Stock Name:<input type="text" name="StockName" value="" size="20"/></p>
                <p> Unit Price:<input type="text" name="UnitPrice" value="" size="20"/></p>
                <p> Type:<input type="text" name="Type" value="" size="20"/></p>
                <p> Quantity:<input type="text" name="Quantity" value="" size="20"/></p>
                <p> Weight Unit:<input type="text" name="WeightUnit" value="" size="20"/></p>
                <input type="submit" value="Add" name="insertStockbtn" />
            </form>
            <?php
        } elseif (isset($_POST['Updatebtn'])) {
            $stockid = $_POST["StockID"];
            $rs = $stockDA->retrieveStock($stockid);
            if ($rs === false) {
                echo 'Record Not Found';
            } else {
                ?>
                <h3> Update Stock</h3>
                <form action="ProcessStockUI.php" method="POST">
                    <?php
                    echo "<input type=\"hidden\" name=\"UpdateStockid\" value=\"" . $stockid . "\"/>";
                    echo "<input type=\"hidden\" name=\"staffid\" value=\"" . $staffID . "\"/>";
                    echo "<p>Stock Name:<input type=\"text\" name=\"UpdateStockName\" value=\"" . $rs['StockName'] . "\" size=\"20\"/></p>";
                    echo "<p>Unit Price:<input type=\"text\" name=\"UpdateUnitPrice\" value=\"" . $rs['UnitPrice'] . "\" size=\"20\"/></p>";
                    echo "<p>Type: <input type=\"text\" name=\"UpdateType\" value=\"" . $rs['Type'] . "\" size=\"20\"/></p>";
                    echo "<p>Quantity:<input type=\"text\" name=\"UpdateQuantity\" value=\"" . $rs['Quantity'] . "\" size=\"20\"/></p>";
                    echo "<p>Weight Unit:<input type=\"text\" name=\"UpdateWeightUnit\" value=\"" . $rs['WeightUnit'] . "\" size=\"20\"/></p>";
                    ?>

                    <input type="submit" value="update" name="UpdateStockbtn" />
                </form>

                <?php
            }
        } else if (isset($_POST['Reportbtn'])) {

            $stockParser = new StockDomParser("../XML/StockXML.xml");
        } else if (isset($_POST['insertStockbtn'])) {// insert btn 

            $stockname = $_POST["StockName"];
            $stockprice = $_POST["UnitPrice"];
            $stocktype = $_POST["Type"];
            $stockqty = $_POST["Quantity"];
            $stockUnit = $_POST["WeightUnit"];
//validate the data
            if ($stockSecurity->validateStock($stockprice,$stockqty,$stockUnit,$stocktype)) {
                $stock = $stockFactory->setStock(null, $stockname, $stockprice, $stocktype, $stockqty, $stockUnit);
                echo 'True';
                $stockDA->AddStock($stock, $staffID);
            }
        } else if (isset($_POST['UpdateStockbtn'])) {// update btn

            $stockid = $_POST["UpdateStockid"];
            $stockname = $_POST["UpdateStockName"];
            $stockprice = $_POST["UpdateUnitPrice"];
            $stocktype = $_POST["UpdateType"];
            $stockqty = $_POST["UpdateQuantity"];
            $stockUnit = $_POST["UpdateWeightUnit"];
//validate the data
            if ($stockSecurity->validateStock($stockprice,$stockqty,$stockUnit,$stocktype)) {
                $stock = $stockFactory->setStock($stockid, $stockname, $stockprice, $stocktype, $stockqty, $stockUnit);
                echo 'True';
                $stockDA->UpdateStock($stock, $staffID);
            }
        }
        ?> <br/> <br/>

        <form action="ManageStockUI.php" method="POST">
            <input type="submit" value="Back" name="backbtn" />
        </form>


    </body>
</html>
