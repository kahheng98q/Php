
<?php
//author: Chia Yang Jie
require_once '../Domain/order.php';
require_once '../Security/validateStatus.php';

class DatabaseConnection {

    private static $instance = null;
    private $mydb;

    public function __construct() {
        $host = 'localhost';
        $dbName = 'bianbiansql';
        $user = 'root';
        $password = '';
        $dsn = "mysql:host=$host;dbname=$dbName";
        $this->mydb = new PDO($dsn, $user, $password);
        try {
            $this->mydb = new PDO($dsn, $user, $password);
            //echo "<p>success to connect database</p>";
        } catch (PDOException $ex) {
            echo "<p>error: " . $ex->getMessage() . "</p>";
            exit;
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    public function retrieveTable() {

        $query = "SELECT * FROM orders";
        $resultSet = $this->mydb->query($query);
        echo "<form id ='updateT' action = 'updateOrderShipping.php' method = 'POST'>";
        echo "<table style='width:80%'>";
        echo "<tr><th>Order Id</th><th>Date</th><th>Status</th><th>Amount</th><th>Customer Id</th><th colspan='2'>Update Order</th></tr>";
        $count = 0;
        foreach ($resultSet as $row) {
            $count + 1;
            echo "<p><tr>";
            echo "<td>" . $row['OrderID'] . "</td>";
            echo "<td>" . $row['OrderDate'] . "</td>";
            echo "<td>" . $row['OrderStatus'] . "</td>";
            echo "<td>" . $row['TotalAmount'] . "</td>";
            echo "<td>" . $row['CustomerID'] . "</td>";
            if ($row['OrderStatus'] == "Pending") {
                echo "<td><button type='submit' value='" . $row['OrderID'] . " Sending' name = 'updateOrder'>update</button></td>";
                echo "<td><button type='submit' value='" . $row['OrderID'] . " Cancel' name = 'cancelOrder'>cancel</button></td>";
            } else {
                if ($row['OrderStatus'] == "Sending") {
                    echo "<td><button type='submit' value='" . $row['OrderID'] . " Received' name = 'updateOrder'>update</button></td>";
                    echo "<td><button type='submit' value='" . $row['OrderID'] . " Complete' name = 'cancelOrder'>cancel</button></td>";
                } else {
                    echo "<td><button type='submit' value='" . $row['OrderID'] . " Complete' name = 'updateOrder'>update</button></td>";
                    echo "<td><button type='submit' value='" . $row['OrderID'] . " Complete' name = 'cancelOrder'>cancel</button></td>";
                }
            }
            echo "</tr></p>";
        }
        echo "</table></form>";
    }

    public function retrieveAllOrder() {

        $query = "SELECT * FROM orders";
        $resultSet = $this->mydb->query($query);
        if ($resultSet === false) {
            echo 'No record';
        } else {
            return $resultSet;
        }
    }
    public function getOrderByCust($cid) {
        $query = "SELECT * FROM orders WHERE CustomerId='" . $cid . "'";
        $rs = $this->mydb->query($query);
        if ($rs === false) {
            echo 'Record not Found';
        } else {
            echo "<br>";
            echo "<table>";
            echo "<tr><th>OrderId</th><th>Date</th><th>Status</th><th>Amount</th></tr>";
            foreach($rs as $row){
             echo "<tr>";
            echo "<td>" . $row['OrderID'] . "</td>";
            echo "<td>" . $row['OrderDate'] . "</td>";
            echo "<td>" . $row['OrderStatus'] . "</td>";
            echo "<td>RM" . $row['TotalAmount'] . "</td>";
            echo "</tr></table>";
            }
        }
    }

    public function updateTable($orderId, $status) {
        $valid = new validateStatus();
        if ($valid->validateStatus($orderId, $status)) {
            try {
                $query = "SELECT * FROM orders WHERE OrderID=?";
                $stmt = $this->mydb->prepare($query);
                $stmt->bindParam(1, $orderId, PDO::PARAM_STR);
                $stmt->execute();
                $totalRows = $stmt->rowCount();
                if ($totalRows == 0) {
                    return null;
                } else {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $order = new order($orderId, $row['OrderDate'], $status, $row['TotalAmount'], $row['CustomerId']);
                    try {
                        $sql = "UPDATE orders SET OrderStatus ='" . $order->getOrderStatus() . "' WHERE OrderID='" . $order->getOrderID() . "'";
                        $pstmt = $this->mydb->prepare($sql);
                        $pstmt->execute();
                    } catch (PDOException $e) {
                        echo $sql . "<br>" . $e->getMessage();
                    }
                }
            } catch (PDOException $ex) {
                echo $sql . "<br>" . $ex->getMessage();
            }
            return true;
        }else{
            return false;
        }
        
    }

    public function closeConnection() {
        $this->mydb = null;
    }

}
?>
     


