<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateStockXML
 *
 * @author user
 */
require_once '../Domain/FactoryMethod/StockFactory.php';


class CreateStockXML {

    public function __construct($stockArray) {
        $this->createXMLfile($stockArray);
    }

    function createXMLfile($stockArray) {

        $filePath = '../XML/StockXML.xml';
        $dom = new DOMDocument('1.0', 'UTF-8');
        $implementation = new DOMImplementation();
        $dom->appendChild($implementation->createDocumentType('stocks SYSTEM \'Stocks.dtd\''));
        $root = $dom->createElement('stocks');

        foreach ($stockArray as $row) {

            $stockid = $row['Stockid'];
            $stockName = $row['StockName'];
            $stockunitPrice = $row['UnitPrice'];
            $stocktype = $row['Type'];
            $stockweightUnit = $row['WeightUnit'];
            $stockqty = $row['Soldqty'];
            $stocktotalPrice = $row['MainTotalPrice'];


            $stock = $dom->createElement('stock');
            $stock->setAttribute('stockid', "ST" . $stockid);
            $name = $dom->createElement('stockName', $stockName);
            $stock->appendChild($name);
            $price = $dom->createElement('unitPrice', $stockunitPrice);
            $stock->appendChild($price);
            $type = $dom->createElement('type', $stocktype);
            $stock->appendChild($type);
            $weightUnit = $dom->createElement('weightUnit', $stockweightUnit);
            $stock->appendChild($weightUnit);
            $qty = $dom->createElement('soldqty', $stockqty);
            $stock->appendChild($qty);
            $totalPrice = $dom->createElement('mainTotalPrice', $stocktotalPrice);
            $stock->appendChild($totalPrice);

            $root->appendChild($stock);
        }
        $dom->appendChild($root);
        $dom->save($filePath);
    }

}

//$da = new StockDA();
//$stockrs = $da->retrieveStockReport();
//$work = new CreateStockXML($stockrs);

