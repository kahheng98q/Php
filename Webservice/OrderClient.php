<!--
Joseph Yeak Jian King
-->
<?php
require_once '../lib/nusoap.php';
require_once '../Domain/Composite/OrderComposite.php';

$client = new nusoap_client("http://localhost/PhpAssignment/Webservice/OrderService.php?wsdl");

$customerID = $_POST["custID"];
?>


<form action="../UI/OrderPage.php" method="POST">
    <?php echo "<input type=\"hidden\" name=\"custID\" value=\"" . $customerID . "\"/>"; ?>
    <input type="submit" value="Back" name="backToOrder"/>
</form>

<?php
$orderComposite = new OrderComposite();
$orderHistory = $orderComposite->getOrderHistory($customerID);
echo $orderHistory;
?>

<form  action="OrderClient.php" method="POST">
    <p>-------------------------------------------------------------------------------------------------------</p>
    <h3>Order Details List:</h3>
    Order ID: <input type="text" name="orderID" value=""/><br/><br/>
    <?php echo "<input type=\"hidden\" name=\"custID\" value=\"" . $customerID . "\"/>"; ?>
    <input type="submit" value="Search" name="searchBtn" />
</form>

<?php
if (isset($_POST['searchBtn'])) {
    $orderID = $_POST['orderID'];
    $customerID = $_POST['custID'];

    $response = $client->call('retrieveOrderDetails', array("orderID" => $orderID));
    if (empty($response))
        echo "No such order";
    else {
        $orderArray = explode("|", $response);

        foreach ($orderArray as $order) {
            echo $order . "<br/>";
        }
    }
}