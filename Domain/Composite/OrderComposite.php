<?php

/*
Joseph Yeak Jian King
 */

require_once '../Security/OrderSecurity.php';

class OrderComposite {

    private $host = 'localhost';
    private $dbName = "bianbiansql";
    private $user = 'root';
    private $db = "";

    public function databaseConnection() {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName;
            $this->db = new PDO($dsn, $this->user);
        } catch (PDOException $ex) {
            die("Database connection failed: " . $ex->getMessage());
        }
    }

    public function __construct() {
        $this->databaseConnection();
    }

    public function RetrieveStock() {
        $query = "SELECT * FROM STOCK";
        $resultSet = $this->db->query($query);

        echo"<h2>Stock List</h2>";
        echo "<table>";
        echo "<tr><th>Stock ID</th><th>Name</th><th>Quantity Left</th><th>Price</th></tr>";
        foreach ($resultSet as $row) {
            echo "<tr><td>" . $row["StockID"] .
            "</td><td>" . $row["StockName"] .
            "</td><td>" . $row["Quantity"] .
            "</td><td>" . $row["UnitPrice"] . "</td></tr>";
        }
        echo "</table>";
    }

    public function AddToCart($stockID, $quantity, $customerID) {
        try {
            $price = 0;
            $subPrice = 0;
            $getQuantity = 0;

            if (empty($stockID) || empty($quantity)) {
                echo '<script language="javascript"> alert("Please fill in the item and quantity.") </script>';
            } else {
                $orderSecurity = new OrderSecurity();
                $checkStockAvailable = $orderSecurity->CheckStockAvailable($stockID);
                $checkStockQuantity = $orderSecurity->CheckStockQuantity($stockID, $quantity);
                $checkStockInCart = $orderSecurity->CheckStockInCart($customerID, $stockID);

                if ($checkStockAvailable == true) {
                    if ($checkStockQuantity == true) {
                        if ($checkStockInCart == false) {
                            $count = 1;
                            $cartID = "";

                            $query1 = "SELECT * FROM STOCK WHERE StockID='" . $stockID . "'";
                            $resultSet1 = $this->db->query($query1);

                            foreach ($resultSet1 as $row1) {
                                $price = $row1["UnitPrice"];
                            }

                            $subPrice = $price * $quantity;

                            $query = "SELECT * FROM CART";
                            $resultSet = $this->db->query($query);

                            $cartID = "C00" . $count;
                            foreach ($resultSet as $row) {
                                if ($cartID == $row["CartID"]) {
                                    $count ++;
                                }

                                if ($count < 10) {
                                    $cartID = "C00" . $count;
                                } else if ($count >= 10) {
                                    $cartID = "C0" . $count;
                                } else if ($count >= 100) {
                                    $cartID = "C" . $count;
                                }
                            }

                            $pstmt = $this->db->PREPARE("INSERT INTO CART (CartID,Quantity,SubPrice,CustomerID,StockID) VALUES(?,?,?,?,?)");
                            $pstmt->bindParam(1, $cartID, PDO::PARAM_STR);
                            $pstmt->bindParam(2, $quantity, PDO::PARAM_INT);
                            $pstmt->bindParam(3, $subPrice, PDO::PARAM_STR);
                            $pstmt->bindParam(4, $customerID, PDO::PARAM_STR);
                            $pstmt->bindParam(5, $stockID, PDO::PARAM_STR);
                            $pstmt->execute();
                            echo '<script language="javascript"> alert("Item added to cart.") </script>';
                        } else {
                            $newQuantity = 0;
                            $currentQuantity = 0;
                            $newSubTotal = 0;

                            $query5 = "SELECT * FROM CART WHERE StockID='" . $stockID . "' AND CustomerID='" . $customerID . "'";
                            $resultSet5 = $this->db->query($query5);

                            foreach ($resultSet5 as $row5) {
                                $newQuantity = $row5["Quantity"] + $quantity;
                            }

                            $query7 = "SELECT * FROM Stock WHERE StockID='" . $stockID . "'";
                            $resultSet7 = $this->db->query($query7);

                            foreach ($resultSet7 as $row7) {
                                $currentQuantity = $row7["Quantity"];
                                $newSubTotal = $newQuantity * $row7["UnitPrice"];
                            }

                            if ($newQuantity > $currentQuantity) {
                                echo '<script language="javascript"> alert("Not enought stock") </script>';
                            } else {
                                $query6 = "UPDATE CART SET Quantity=?, SubPrice=? WHERE StockID='" . $stockID . "' AND CustomerID='" . $customerID . "'";
                                $stmt1 = $this->db->prepare($query6);
                                $stmt1->bindParam(1, $newQuantity, PDO::PARAM_INT);
                                $stmt1->bindParam(2, $newSubTotal, PDO::PARAM_STR);
                                $stmt1->execute();
                                echo '<script language="javascript"> alert("Quantity updated.") </script>';
                            }
                        }
                    } else {
                        echo '<script language="javascript"> alert("Not enought stock") </script>';
                    }
                } else {
                    echo '<script language="javascript"> alert("No such item in our stock") </script>';
                }
            }
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public function getOrderDetailServer($orderID) {
        $query = "SELECT * FROM OrderDetail OD, Stock S WHERE OD.OrderID='" . $orderID . "' AND OD.StockID=S.StockID";

        $resultSet = $this->db->query($query);
        if ($resultSet == false) {
            echo 'Record not Found';
        } else {
            return $resultSet;
        }
    }

    public function getOrderHistory($customerID) {
        try {
            $query = "SELECT * FROM Orders WHERE CustomerID='" . $customerID . "'";
            $resultSet = $this->db->query($query);

            echo"<h1>Order History</h1>";
            echo "<table>";
            echo "<tr><th>OrderID</th><th>Order Date</th><th>Order Status</th><th>Total Amount</th></tr>";
            foreach ($resultSet as $row) {
                echo "<tr><td>" . $row["OrderID"] .
                "</td><td>" . $row["OrderDate"] .
                "</td><td>" . $row["OrderStatus"] .
                "</td><td>" . $row["TotalAmount"] . "</td></tr>";
            }
            echo "</table>";
        } catch (Exception $ex) {
            
        }
    }

}
