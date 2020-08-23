<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->
<?php
require_once '..\DA\CustDA.php';
require_once '..\DA\StaffDA.php';

if (isset($_POST['staff'])) {
    $_SESSION["attempt"] = 0;
    $_SESSION["locked"] = 0;
    header("Location: http://localhost/Assignment/UI/registerCheck.php");
    exit();
}
$err = "";
if (isset($_POST['register'])) {
    if (empty($_POST['name'])) {
        $err .= "Name are required.\\n";
    }
    if (empty($_POST['email'])) {
        $err .= "Email are required.\\n";
    }
    if (empty($_POST['pass'])) {
        $err .= "Password are required.\\n";
    }
    if (empty($_POST['dob'])) {
        $err .= "Date of Birth are required.\\n";
    }
    if (empty($_POST['add'])) {
        $err .= "Home Address are required.\\n";
    }
    if (strcmp($err, "") != 0) {
         echo '<script>alert("'.$err.'");window.location.href="http://localhost/Assignment/UI/Registration.html";</script>';
        exit;
    }
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $dob = $_POST['dob'];
    $add = $_POST['add'];
    if (!preg_match('/^[a-zA-Z ]+$/', $name)) {
        $err .= "Only alphabets and space are allowed for name.\\n";
    }
    if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $email)) {
        $err .= "Email entered aren't valid.\\n";
    }
    if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/',$pass)){
        $err .= "Password entered doen't not match the requirement.\\n";
    }
    if (strcmp($err, "") != 0) {
        echo '<script>alert("'.$err.'");window.location.href="http://localhost/Assignment/UI/Registration.html";</script>';
    } else {
        $id = substr(getLastCustomerID(),1);
        $id = (int)$id+1;
        if($id<10)
            $id = "C00" . (String)$id;
        else if ($id <100)
            $id = "C0" . (String)$id;
        else if ($id <1000)
            $id = "C" . (String)$id;
        
        $cust = new Customer($id, $name, $email, $pass, $dob, $add);
        createCustomer($cust);
        echo '<script>alert("Customer Registered Successful!");window.location.href="http://localhost/Assignment/UI/Login.php";</script>';
    }
}
if (isset($_POST['registerS'])) {
    if(empty($_POST['id'])){
        $err .= "ID are required.\\n";
    }
    if (empty($_POST['nameS'])) {
        $err .= "Name are required.\\n";
    }
    if (empty($_POST['emailS'])) {
        $err .= "Email are required.\\n";
    }
    if (empty($_POST['passS'])) {
        $err .= "Password are required.\\n";
    }
    if (empty($_POST['position'])) {
        $err .= "Home Address are required.\\n";
    }
    if (strcmp($err, "") != 0) {
        echo '<script>alert("'.$err.'");window.location.href="http://localhost/Assignment/UI/Registration.html";</script>';
        exit;
    }
    $Sid = $_POST['id'];
    $name = $_POST['nameS'];
    $email = $_POST['emailS'];
    $pass = $_POST['passS'];
    $position = $_POST['position'];
    if(!preg_match('/^[0-9]{2}[A-Z]{3}[0-9]{2}$/',$Sid)){
        $err .= "Staff ID aren't following the format.\\n";
    }
    if (!preg_match('/^[a-zA-Z ]+$/', $name)) {
        $err .= "Only alphabets and space are allowed for name.\\n";
    }
    if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $email)) {
        $err .= "Email entered aren't valid.\\n";
    }
    if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/',$pass)){
        $err .= "Password entered doen't not match the requirement.\\n";
    }
    if (strcmp($err, "") != 0) {
        echo $err;
    } else {  
        $staff = new Staff($Sid, $name, $email, $pass, $position);
        createStaff($staff);
        echo '<script>alert("Staff Registered Successful!");window.location.href="http://localhost/Assignment/UI/Login.php";</script>';
    }
}

