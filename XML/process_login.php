<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->
<?php

require_once '..\DA\StaffDA.php';
require_once '..\DA\CustDA.php';
require_once '..\XML\login.xml';


session_start();

$xml = simplexml_load_file("..\XML\login.xml");
$sxe = new SimpleXMLElement($xml->asXML());

if (isset($_POST['login'])) {

    unset($sxe->user[0]);
    $err = "";
    if (empty($_POST['email'])) {
        $err .= "Please enter your email to login.\\n";
    }
    if (empty($_POST['password'])) {
        $err .= "Please enter your password to login.\\n";
    }
    if (strcmp($err, "") !== 0) {
        echo '<script>alert("' . $err . '");window.location.href="http://localhost/PhpAssignment/UI/Login.php";</script>';
        exit;
    }

    $err = "";
    $email = $_POST['email'];
    $passs = $_POST['password'];
    if (getStaffLogin($email) !== 0) {
        $pass = getStaffLogin($email);
        if ($pass == $passs) {
            echo "Login granted";
            $_SESSION["attempt"] = 0;
            $_SESSION["lock"] = 0;
            $staff = retrieveStaff();
            $user = $sxe->addChild('user');
            $user->addAttribute('type', "Staff");
            $user->addChild('id', $staff->getId());
            $user->addChild('name', $staff->getName());
            $user->addChild('email', $staff->getEmail());
            $user->addChild('password', $staff->getPass());
            $user->addChild('position', $staff->getPosition());
            $sxe->asXML("..\XML\login.xml");
            //getStaffXML();
            header("Location: http://localhost/PhpAssignment/XML/login.xml");
            
        } else {
            if (isset($_SESSION["attempt"])) {
                $left = 2 - $_SESSION["attempt"];
            }
            $err .= "Wrong email or password. "
                    . " Please recheck the login details."
                    . "\\nAttempt left: " . $left;

            if (isset($_SESSION["attempt"])) {
                $_SESSION["attempt"] += 1;
                if ($_SESSION["attempt"] > 2) {
                    $_SESSION["lock"] = time();
                    header("Refresh: 30");
                }
            }
        }
    } else {
        if (getCustomerLogin($email) !== 0) {
            $pass = getCustomerLogin($email);
            if ($pass == $passs) {
                echo "Login granted";
                $_SESSION["attempt"] = 0;
                $_SESSION["lock"] = 0;
                $cust = retrieveCustomer();
                $user = $sxe->addChild('user');
                $user->addAttribute('type', "Customer");
                $user->addChild('id', $cust->getId());
                $user->addChild('name', $cust->getName());
                $user->addChild('email', $cust->getEmail());
                $user->addChild('password', $cust->getPass());
                $user->addChild('dob', $cust->getDOB());
                $user->addChild('address', $cust->getAddress());
                $sxe->asXML("..\XML\login.xml");
                //getCusotmerXML();
                header("Location: http://localhost/PhpAssignment/XML/login.xml");
            } else {
                if (isset($_SESSION["attempt"])) {
                    $left = 2 - $_SESSION["attempt"];
                }
                $err .= "Wrong email or password. "
                        . " Please recheck the login details."
                        . "\\nAttempt left: " . $left;

                if (isset($_SESSION["attempt"])) {
                    $_SESSION["attempt"] += 1;
                    if ($_SESSION["attempt"] > 2) {
                        $_SESSION["lock"] = time();
                        header("Refresh: 30");
                        echo "<p>Looks like you ran out of attempt<br/>You will be able to retry after 30 seconds</p>";
                    }
                }
            }
        } else {
            $err .= "No account found under this email, "
                    . "please register for a new account :)";
        }
    }
    if (strcmp($err, "") != 0) {
        echo '<script>alert("' . $err . '");window.location.href="http://localhost/PhpAssignment/UI/Login.php";</script>';
    }
}
   
   

