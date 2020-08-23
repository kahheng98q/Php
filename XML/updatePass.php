<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->
<?php
require_once '..\DA\CustDA.php';
require_once '..\DA\StaffDA.php';
require '..\PHPMailer-master\src\PHPMailer.php';

session_start();
if (isset($_POST["update"])) {
    if (empty($_POST["password"]) && empty($_POST["cp"])) {
        echo '<p>Password(s) are to be filled in to be reset.</p>';
        exit();
    }else{
        if(isset($_POST["password"])&& isset($_POST["cp"]) && isset($_SESSION["to"])){
        $p1 = $_POST["password"];
        $p2 = $_POST["cp"];
        if ($p1 == $p2) {
            $email = $_SESSION["to"];
            if (empty(getStaffLogin($email))) {
                updatePasswordC($email, $p2);
                echo '<script>alert("Password has been successfully updated.");window.location.href="http://localhost/Assignment/UI/Login.php";</script>';
                exit;
            } else {
                updatePasswordS($email, $p2);
                echo '<script>alert("Password has been successfully updated.");window.location.href="http://localhost/Assignment/UI/Login.php";</script>';
                exit;
            }
        } else 
            echo '<p>The passwords do not match with one another, please retype.</p>';
        }
        
    } 
}


