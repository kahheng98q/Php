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
require_once '../FactoryMethod/StockFactory.php';
require_once '../DA/StockDA.php';

class CreateStockXML {

    function createXMLfile($stockArray) {

        $filePath = 'StockXML.xml';
        $dom = new DOMDocument('1.0', 'utf-8');
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
            $stock->setAttribute('stockid', $stockid);
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

$da = new StockDA();
$stockrs = $da->retrieveStockReport();
$work = new CreateStockXML();
$work->createXMLfile($stockrs);
