<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderServer
 *
 * @author Joseph Yeak Jian King
 */
require_once '../lib/nusoap.php';
require_once '../Domain/Composite/OrderComposite.php';

function retrieveOrderDetails($OrderID) {
    $orderComposite = new OrderComposite();
    $rs = $orderComposite->getOrderDetailsServer($OrderID);

    $result = "";
    $result .= "<table>";
    foreach ($rs as $row) {
        $result .= "<tr><td>" . $row['StockID'] . "</td><td>" . $row['StockName'] . "</td><td>"
            . $row['Quantity'] . "</td><td>" . $row['SubPrice'] . "</td></tr>" . "|";
    }
    $result .= "</table>";   
    return $result;
}

$server = new nusoap_server();
$server->configureWSDL("Order Details", "urn:orderDetails");

$server->register("retrieveOrderDetails",
        array("orderID" => "xsd:string"),
        array("return" => "xsd:string"));

$server->service(file_get_contents("php://input"));
