<?php

/*
Joseph Yeak Jian King
 */

class PaymentComposite {
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
    
    public function ShowOrderDetails($customerID) {
        try {
            $query = "SELECT * FROM Customer WHERE CustomerID='" . $customerID . "'";
            $resultSet = $this->db->query($query);

            foreach ($resultSet as $row) {
                echo "Name: " . $row["CustomerName"];
                echo "<br/>";
                echo "Address: " . $row["HomeAddress"];
                echo "<br/><br/>";
            }


            $totalPrice = 0;
            $no = 1;

            $query2 = "SELECT * FROM CART WHERE CustomerID='" . $customerID . "'";
            $resultSet2 = $this->db->query($query2);

            echo "<table>";
            echo "<tr><th>No</th><th>Stock ID</th><th>Quantity</th><th>Sub Price</th></tr>";
            foreach ($resultSet2 as $row2) {
                echo "<tr><td>" . $no++ .
                "</td><td>" . $row2["StockID"] .
                "</td><td>" . $row2["Quantity"] .
                "</td><td>" . $row2["SubPrice"] . "</td></tr>";

                $totalPrice += $row2["SubPrice"];
            }
            echo "</table>";

            echo "</br></br>Total Price: RM " . $totalPrice;
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public function Pay($customerID) {
        try {
            $datas = array();
            $totalPrice = 0;
            $orderID = "";
            $count = 1;
            $odID = "";
            $count2 = 1;
            $orderStatus = "Paid";
            $currentDate = date("Y/m/d");
                    
            $query = "SELECT * FROM CART WHERE CustomerID='" . $customerID . "'";
            $resultSet = $this->db->query($query);

            foreach ($resultSet as $row) {
                $totalPrice += $row["SubPrice"];
                $datas[] = $row;
            }

            $query4 = "SELECT * FROM Orders";
            $resultSet4 = $this->db->query($query4);

            $orderID = "O00" . $count;
            foreach ($resultSet4 as $row4) {
                if ($orderID == $row4["OrderID"]) {
                    $count ++;
                }

                if ($count < 10) {
                    $orderID = "O00" . $count;
                } else if ($count >= 10) {
                    $orderID = "O0" . $count;
                } else if ($count >= 100) {
                    $orderID = "O" . $count;
                }
            }

            $pstmt = $this->db->PREPARE("INSERT INTO Orders (OrderID,OrderDate,OrderStatus,TotalAmount,CustomerID) VALUES(?,?,?,?,?)");
            $pstmt->bindParam(1, $orderID, PDO::PARAM_STR);
            $pstmt->bindParam(2, $currentDate, PDO::PARAM_STR);
            $pstmt->bindParam(3, $orderStatus, PDO::PARAM_STR);
            $pstmt->bindParam(4, $totalPrice, PDO::PARAM_STR);
            $pstmt->bindParam(5, $customerID, PDO::PARAM_STR);
            $pstmt->execute();

            $query2 = "SELECT * FROM Orderdetail";
            $resultSet2 = $this->db->query($query2);

            $odID = "D000" . $count2;
            foreach ($resultSet2 as $row2) {
                if ($odID == $row2["OrderdetailID"]) {
                    $count2++;
                }

                if ($count2 < 10) {
                    $odID = "D000" . $count2;
                } else if ($count >= 10) {
                    $odID = "D00" . $count2;
                } else if ($count >= 100) {
                    $odID = "D0" . $count2;
                } else if ($count >= 1000) {
                    $odID = "D" . $count2;
                }
            }

            foreach ($datas as $data) {

                if ($count2 < 10) {
                    $odID = "D000" . $count2;
                } else if ($count2 >= 10) {
                    $odID = "D00" . $count2;
                } else if ($count2 >= 100) {
                    $odID = "D0" . $count2;
                } else if ($count2 >= 1000) {
                    $odID = "D" . $count2;
                }

                $pstmt = $this->db->PREPARE("INSERT INTO Orderdetail (OrderdetailID,SubPrice,Quantity,OrderID,StockID) VALUES(?,?,?,?,?)");
                $pstmt->bindParam(1, $odID, PDO::PARAM_STR);
                $pstmt->bindParam(2, $data['SubPrice'], PDO::PARAM_STR);
                $pstmt->bindParam(3, $data['Quantity'], PDO::PARAM_INT);
                $pstmt->bindParam(4, $orderID, PDO::PARAM_STR);
                $pstmt->bindParam(5, $data['StockID'], PDO::PARAM_STR);
                $pstmt->execute();
                $count2++;
            }

            $query3 = 'DELETE FROM Cart WHERE CustomerID=?';
            $pstm3 = $this->db->prepare($query3);
            $pstm3->bindParam(1, $customerID, PDO::PARAM_STR);
            $pstm3->execute();

            echo '<script language="javascript"> alert("Thank You.") </script>';
        } catch (Exception $ex) {
            echo '<script language="javascript"> alert("GG") </script>';
        }
    }

}
