<!DOCTYPE html>

<?php
require_once '../Domain/FactoryMethod/StockFactory.php';
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

        $staffID = "S001";
        echo "<table><tr><th>Stock ID</th><th>Stock Name</th><th>Unit Price</th><th>Type</th><th>QTY</th><th>Unit</th></tr><br/>";
        foreach ($result as $row) {
            echo "<tr><td>" . $row['StockID'] . "</td><td>" . $row['StockName'] . "</td><td>"
            . $row['UnitPrice'] . "</td><td>" . $row['Type'] . "</td><td>"
            . $row['Quantity'] . "</td><td>" . $stockFactory->getType($row['Type'], $row['WeightUnit'])
            . "</td></tr>";
        }
        echo "</table>";
        ?>
        <form action="ProcessStockUI.php" method="POST">
            <?php
            echo "<input type=\"hidden\" name=\"staffid\" value=\"" . $staffID . "\"/>";
            ?>
            <input type="submit" value="Insert New Record" name="Addbtn" />
            <p>Stock ID:<input type="text" name="StockID" value="" size="20"/></p>
            <input type="submit" value="Update" name="Updatebtn" />
            <input type="submit" value="Display Stock Summary Report" name="Reportbtn" />
        </form>


    </body>
</html>
