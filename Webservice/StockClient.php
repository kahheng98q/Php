<?php
//author : Cheah Kah Heng
require_once '../lib/nusoap.php';

$client = new nusoap_client("http://localhost/PhpAssignment/Webservice/StockWebServer.php?wsdl");
?>

<h3> Loan Web Service Client</h3>
<form  method="POST">
    <p>Stock ID: <input type="text" name="stockid" value="" size="20"/></p>
    <input type="submit" value="Get All Stocks" name="getStockList" />
    <input type="submit" value="Get A Stock by ID" name="getAStock" />
</form>


<?php
if (isset($_POST['getStockList'])) {

    $response = $client->call('getAllStocks', array());
    if (empty($response))
        echo "Error";
    else {
        echo "<h3>Stock List:<br />";
        $stockArray = explode("|", $response);

        foreach ($stockArray as $stock) {
            if ($stock != "") {
                echo " $stock<br/>";
            }
        }
        echo '</h3>';
    }
} elseif (isset($_POST['getAStock'])) {
    $stockid = $_POST['stockid'];

    $response = $client->call('getStock', array("stockid" => $stockid));

    if (empty($response))
        echo "No Record found with stockid: $stockid";
    else {
        echo "<h3>Stock information: <br/>" . $response . "</h3>";
    }
}