<?php

require_once '..\WebService\lib\nusoap.php';
require_once '..\Domain\Customer.php';
require_once '..\Domain\Staff.php';
require_once '..\DA\connectionDA.php';
require_once '..\DA\CustDA.php';
require_once '..\DA\StaffDA.php';

function validateStaff($email, $password) {
    if (getStaffLogin($email) !== 0) {
        $pass = getStaffLogin($email);
        if ($password == $pass) {
            return true;
        }
    }
}

function validateCustomer($email, $password) {
    if (getCustomerLogin($email) !== 0) {
        $pass = getCustomerLogin($email);
        if ($password == $pass) {
            return true;
        }
    }
}

function getCustomer($email) {
        try {
            $conn = connectDB();
            $UEmail = strtoupper($email);
            $sql = "SELECT * FROM Customer WHERE UPPER(CustomerEmail) = '$UEmail'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $data = $row["CustomerID"] . "|" . $row["CustomerName"] . "|" . $UEmail . "|" . $row["CustomerPassword"] . "|" . $row["DOB"] . "|" . $row["HomeAddress"];
            }
            $conn->close();
        } catch (SQLException $ex) {
            echo 'ERROR DB: ' . $ex;
        }
        return $data;
    }

function getStaff($email){
        try {
            $conn = connectDB();
            $UEmail = strtoupper($email);
            $sql = "SELECT * FROM Staff WHERE UPPER(StaffEmail) = '$UEmail'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $data = $row["StaffID"] . "|" . $row["StaffName"] . "|" . $UEmail . "|" . $row["StaffPassword"] . "|" . $row["Position"];
            }
            $conn->close();
        } catch (SQLException $ex) {
            echo 'ERROR DB: ' . $ex;
        }
        return $data;
    }

$server = new nusoap_server();
$server->configureWSDL("Mart App", "urn:martApp");

$server->register(
        "validateStaff",
        array("email" => "xsd:string", "password" => "xsd:string"),
        array("return" => "xsd:boolean"));

$server->register(
        "validateCustomer",
        array("email" => "xsd:string", "password" => "xsd:string"),
        array("return" => "xsd:boolean"));

$server->register(
        "getCustomer",
        array("email" => "xsd:string", "type" => "xsd:string"),
        array("return" => "xsd:string"));

$server->register(
        "getStaff",
        array("email" => "xsd:string", "type" => "xsd:string"),
        array("return" => "xsd:string"));

$server->service(file_get_contents("php://input"));


