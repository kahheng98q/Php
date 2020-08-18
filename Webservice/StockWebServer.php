<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StockWebService
 *
 * @author user
 */
require_once '../lib/nusoap.php';
require_once '../DA/StockDA.php';
require_once '../FactoryMethod/StockFactory.php';

function getAllStocks() {
    $stockDA = new StockDA();
    $rs = $stockDA->retrieveStocks();
    $outputstr = "";
    $stockFactory = new StockFactory();
    foreach ($rs as $row) {

        $outputstr .= $row['StockID'] . ". " . $row['StockName'] . "&nbsp;&nbsp;&nbsp; RM"
                . $row['UnitPrice'] . "&nbsp;&nbsp;&nbsp;" . $row['Type'] . "&nbsp;&nbsp;&nbsp;"
                . $row['Quantity'] . "qty&nbsp;&nbsp;&nbsp;" . $stockFactory->getType($row['Type'], $row['WeightUnit'])
                . "|";
    }

//    echo $outputstr;
    return $outputstr;
//    return"1231231231";
}

function getStock($stockid) {
    $stockDA = new StockDA();
    $rs = $stockDA->retrieveStock($stockid);
    $stockFactory = new StockFactory();
//    return "123133";
    $outputstr = $rs['StockID'] . ". " . $rs['StockName'] . "&nbsp;&nbsp;&nbsp; RM"
            . $rs['UnitPrice'] . "&nbsp;&nbsp;&nbsp;" . $rs['Type'] . "&nbsp;&nbsp;&nbsp;"
            . $rs['Quantity'] . "qty&nbsp;&nbsp;&nbsp;" . $stockFactory->getType($rs['Type'], $rs['WeightUnit']);
    return $outputstr;
}

$server = new nusoap_server();
$server->configureWSDL("Stock List", "urn:stockList");

$server->register("getAllStocks",
        array(),
        array("return" => "xsd:string"));

$server->register("getStock",
        array("stockid" => "xsd:string"),
        array("return" => "xsd:string"));

$server->service(file_get_contents("php://input"));
