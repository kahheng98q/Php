<?php
//author: Chia Yang Jie
require_once '../lib/nusoap.php';
require_once '../DA/orderDB.php';

function getAllOrder() {
    $db = new orderDB();
    $rs = $db->retrieveAllOrder();
    $output = "";
    foreach ($rs as $row) {

            $output .= $row['OrderID'] . "&ensp;&ensp;&ensp;" . $row['OrderDate'] . "&ensp;&ensp;&ensp;" . $row['OrderStatus'] . "&ensp;&ensp;&ensp;" . $row['TotalAmount'] . "&ensp;&ensp;&ensp;" . $row['CustomerID'] . "*";

    }
    return $output;
}

function getOrder($customerId) {
    $db = new orderDB();
    $rs = $db->getOrderByCust($customerId);
    $output = "";
    foreach ($rs as $row) {
        $output .= $row['OrderID'] . "&ensp;&ensp;&ensp;" . $row['OrderDate'] . "&ensp;&ensp;&ensp;" . $row['OrderStatus'] . "&ensp;&ensp;&ensp;" . $row['TotalAmount'] . "*";
    }
    return $output;
}

$server = new nusoap_server();

$server->configureWSDL("order status app", "urn:orderStatusApp");

$server->register("getAllOrder",
        array(),
        array("return" => "xsd:string"));

$server->register("getOrder",
        array("customerId" => "xsd:string"),
        array("return" => "xsd:string"));


$server->service(file_get_contents("php://input"));
