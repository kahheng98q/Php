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
        $result = $stockDA->retrieveStocks();

        echo "<table><tr><th>Stock ID</th><th>Stock Name</th><th>Unit Price</th><th>Type</th><th>QTY</th><th>Unit</th></tr><br/>";
        foreach ($result as $row) {
            echo "<tr><td>" . $row['StockID'] . "</td><td>" . $row['StockName'] . "</td><td>"
            . $row['UnitPrice'] . "</td><td>" . $row['Type'] . "</td><td>"
            . $row['Quantity'] . "</td><td>" . $stockFactory->getType($row['Type'], $row['WeightUnit'])
            . "</td></tr>";
        }
        echo "</table>";
        ?>
        <form action="InsertStock.php" method="POST">
            <input type="submit" value="Insert New Record" name="addStockbtn" />
            <p>Stock ID:<input type="text" name="StockID" value="" size="20"/></p>
            <input type="text" name="staffID" value="" size="20"/>
            <input type="submit" value="Update" name="updateStockbtn" />
            <input type="submit" value="Delete" name="DeleteStockbtn" />
        </form>
    </body>
</html>
