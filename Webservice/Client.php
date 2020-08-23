<?php
//author: Chia Yang Jie
require_once '../lib/nusoap.php';

$client = new nusoap_client("http://localhost/PhpAssignment/Webservice/getOrder.php?wsdl");
?>

<h2>Check Order Status Service Client</h2>
<form method="POST">
    <input type="text" name="cid" value="" /><br><br>
    <input type="submit" value="get order by customer-id" name="GetOrderById" /><br><br>
    <input type="submit" value="get all order" name="GetAllOrder" />
</form>

<?php
if (isset($_POST['GetAllOrder'])) {
    $result = $client->call('getAllOrder', array());
    if (empty($result))
        echo "Error";
    else {
        echo "<h2>Order Table</h2>";
        $orders = explode("*", $result);
        echo "OrderId&ensp;&ensp;&ensp;Date&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Status&ensp;&ensp;&ensp;Amount&ensp;&ensp;&ensp;CustomerId<br>";
        foreach ($orders as $row) {
            echo $row . "</br>";
        }
    }
} else if (isset($_POST['GetOrderById'])) {
    $cid = $_POST['cid'];

    $result = $client->call('getOrder', array("customerId" => $cid));
    if (empty($result))
        echo "Error";
    else {
        echo "<h2>Order Table by Customer: $cid</h2>";

        $orders = explode("*", $result);
        echo "OrderId&ensp;&ensp;&ensp;Date&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Status&ensp;&ensp;&ensp;&ensp;&ensp;Amount&ensp;&ensp;&ensp;<br>";
        foreach ($orders as $row) {
            echo $row . "</br>";
        }
    }
}
 
