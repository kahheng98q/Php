<?php

require_once '../FactoryMethod/StockFactory.php';

class StockDomParser {

    private $stocks;
    private $xpath;

    public function __construct($filename) {
        $this->stocks = new SplObjectStorage();
        $this->readFromXML($filename);
//        $this->display();
    }

    public function readFromXML($filename) {
        $xml = simplexml_load_file($filename);
        $stockList = $xml->xpath("/stocks/stock[type='Solid']");
        echo "<h2>Stock Total Sales summary report </h2>";
        foreach ($stockList as $stock) {
            $attr = $stock->attributes();
            echo "" . $attr->stockid . "";
            echo "" . $stock->stockName . "";
            echo "" . $attr->unitPrice . "";
            echo "" . $stock->type . "";
            echo "" . $stock->weightUnit . "";
            echo "" . $attr->soldqty . "";
            echo "" . $stock->mainTotalPrice . "<br/>";
        }
    }

//    public function display() {
//        echo "<h2>Stock Listing </h2>";
//        foreach ($this->stocks as $st) {
//            echo $st->StockID . "\n";
//        }
//        //            $stocktmp = $stockFactory->setStock($attr->stockid,
//                    $stock->stockName,
//                    $stock->unitPrice,
//                    $stock->type,
//                    $stock->quantity,
//                    $stock->weightUnit);
//
//    }
}

$worker = new StockDomParser("StockXML.xml");

