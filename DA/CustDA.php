<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->
<?php

require_once '..\DA\connectionDA.php';
require_once '..\Domain\Customer.php';
$id = "";

function getCustomerLogin($email) {
    $UEmail = strtoupper($email);
    try {
        $conn = connectDB();
        $sql = "SELECT CustomerPassword, CustomerID FROM Customer WHERE UPPER(CustomerEmail) = '$UEmail'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $GLOBALS['id'] = $row["CustomerID"];
            return $row["CustomerPassword"];
        } else
            return 0;
        $conn->close();
    } catch (SQLException $ex) {
        echo 'ERROR DB: ' . $ex;
    }
}

function retrieveCustomer() {
    try {
        $conn = connectDB();
        $id = $GLOBALS['id'];
        $sql = "SELECT * FROM Customer WHERE CustomerID = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cust = new Customer($id, $row["CustomerName"], $row["CustomerEmail"], $row["CustomerPassword"], $row["DOB"], $row["HomeAddress"]);
        }
        $conn->close();
    } catch (SQLException $ex) {
        echo 'ERROR DB: ' . $ex;
    }
    return $cust;
}

function getLastCustomerID() {
    try {
        $conn = connectDB();
        $sql = "SELECT CustomerID FROM Customer ORDER BY CustomerID DESC";
        $result = $conn->query($sql);
        $lastID = "";
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $lastID = $row["CustomerID"];
        }
        $conn->close();
    } catch (SQLException $ex) {
        echo 'ERROR DB: ' . $ex;
    }
    return $lastID;
}

function createCustomer(Customer $customer) {
    try {
        $conn = connectDB();


        $stmt = $conn->prepare("INSERT INTO Customer VALUE (?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $a, $b, $c, $d, $e, $f);

        $a = $customer->getId();
        $b = $customer->getName();
        $c = $customer->getEmail();
        $d = $customer->getPass();
        $e = $customer->getDOB();
        $f = $customer->getAddress();
        $stmt->execute();
        $stmt->close();
        $conn->close();
    } catch (SQLException $ex) {
        echo 'error: ' . $ex;
    }
}

function requestEmailC($email) {
    try {
        $conn = connectDB();

        $UEmail = strtoupper($email);
        $sql = "SELECT * FROM Customer WHERE UPPER(CustomerEmail) = '$UEmail'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["CustomerName"];
        } else
            return false;
        $conn->close();
    } catch (SQLException $ex) {
        echo 'ERROR DB: ' . $ex;
    }
}

function updatePasswordC($email, $password) {
    try {
        $conn = connectDB();

        $UEmail = strtoupper($email);
        $stmt = $conn->prepare("UPDATE Customer SET CustomerPassword = ? WHERE UPPER(CustomerEmail) = '$UEmail'");
        $stmt->bind_param("s", $a);

        $a = $password;
        $stmt->execute();
        $stmt->close();
        $conn->close();
    } catch (SQLException $ex) {
        echo 'ERROR DB: ' . $ex;
    }
}

