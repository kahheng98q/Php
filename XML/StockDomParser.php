<?php

require_once '../Domain/FactoryMethod/StockFactory.php';
require_once 'CreateStockXML.php';
require_once '../DA/StockDA.php';

class StockDomParser {

    private $stocks;

    public function __construct($filename) {
        $da = new StockDA();
        $stockrs = $da->retrieveStockReport();
        new CreateStockXML($stockrs);
        $this->stocks = new SplObjectStorage();
        $this->readFromXML($filename);
    }

    public function readFromXML($filename) {
        $totalRevenues = 0;
        $xml = simplexml_load_file($filename);
        //Xpath
        $stockList = $xml->xpath("/stocks/stock[type='Solid']");
//Display Report
        echo "<h2>Total Solid Type Stock Sales Summary Report </h2>";
        echo '----------------------------------------------------------------------------------------------------';
        echo "<table><tr><th>Stock ID</th><th>"
        . "</th><th>Stock Name</th><th>"
        . "</th><th>Type</th><th>"
        . "</th><th>Weight</th><th>"
        . "</th><th>Total Quantity Sold</th><th>"
        . "</th><th>Total Price </th></tr><th>";
        foreach ($stockList as $stock) {
            $attr = $stock->attributes();
            echo "<tr><td>" . $attr->stockid . "</td><td>";
            echo "</td><td>" . $stock->stockName . "</td><td>";
//            echo "" . $attr->unitPrice . "";
            echo "</td><td>" . $stock->type . "</td><td>";
            echo "</td><td>" . $stock->weightUnit . "</td><td>";
            echo "</td><td>" . $stock->soldqty . "</td><td>";
            echo "</td><td>RM" . $stock->mainTotalPrice . "</td></tr>";
            $totalRevenues = $totalRevenues + (Double) $stock->mainTotalPrice;
        }
        echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
        echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><h4>TOTAL REVENUES :</h4>'
        . '</td><td>'
        . '</td><td><h4> RM' . number_format($totalRevenues, 2)
        . '</h4></td></tr>';
        echo '</table>';
    }

}

//$worker = new StockDomParser("StockXML.xml");

