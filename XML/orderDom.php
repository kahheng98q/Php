<?php
//author: Chia Yang Jie
require_once 'createOrderXML.php';
require_once '../DA/DatabaseConnection.php';
?>

<style>
    td{
        text-align: center;
    }
</style>
<?php
class orderDom {
    
    private $orders;
    
    public function __construct($filename) {
        $db = DatabaseConnection::getInstance();
        $orderArray = $db->retrieveAllOrder();
        new createOrderXML($orderArray);
        $this->orders = new SplObjectStorage();
        $this->readFile($filename);
    }

    public function readFile($filename) {
        $xml = simplexml_load_file($filename);
        $orderGet = $xml->xpath("/orders/order[OrderStatus='Pending']");
        echo "<h3>Total order received report</h3>";
        echo "<table width='70%'><tr><th>Order Id</th><th>Date</th><th>TotalAmount</th><th>Customer Id</th></tr>";
        echo "<tr></tr>";
        $count = 0;
       
        foreach ($orderGet as $orderr) {
            $count=$count+1;
            $attr = $orderr->attributes();
            echo "<tr><td>" . $attr->OrderID . "</td><td>" . $orderr->OrderDate . "</td><td>" ."RM". $orderr->TotalAmount . "</td><td>" . $orderr->CustomerId . "</td><td>";
        }
      
        echo '</table>';
        echo "<h4>Total order completed: $count</h4>";
    }
}