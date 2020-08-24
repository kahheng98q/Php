<!--
Joseph Yeak Jian King
-->
<?php

require_once '../lib/nusoap.php';
require_once '../Domain/Composite/OrderComposite.php';

function retrieveOrderDetails($orderID) {
    $orderComposite = new OrderComposite();
    $rs = $orderComposite->getOrderDetailServer($orderID);
    $result = "";
    $result .= "<table>";
    $result .= "<tr><th>Stock ID</th><th>Stock Name</th><th>Quantity</th><th>Sub Price</th></tr>|";
    foreach ($rs as $row) {
        $result .= "<tr><td>" . $row['StockID'] . "</td><td>" . $row['StockName'] . "</td><td>"
            . $row['Quantity'] . "</td><td>" . $row['SubPrice'] . "</td></tr>|";
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



