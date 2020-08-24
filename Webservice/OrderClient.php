<?php
/**
 * @author Joseph Yeak Jian King
 */
require_once '../lib/nusoap.php';

$client = new nusoap_client("http://localhost/PhpAssignment/WebService/OrderServer.php?wsdl");
?>

<h3> Order Details Viewer </h3>
<form  method="POST">
    <p>Order ID: <input type="text" name="orderID" value="" size="4"/></p>
    <input type="submit" value="Search" name="searchBtn" />
</form>


<?php

if (isset($_POST['searchBtn'])) {
    $orderID = $_POST['orderID'];

    $response = $client->call('retrieveOrderDetails', array("orderID" => $orderID));
    if (empty($response))
        echo "No such order";
    else {
        echo "<h3>Order Details List:<br />";
        //echo $response;
        $orderArray = explode("|", $response);
        //$orderArray = $response;

        foreach ($orderArray as $order) {
            echo $order . "<br/>";
        }
        
        echo '</h3>';
    }
}