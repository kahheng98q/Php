<!DOCTYPE html>
<!--
Joseph Yeak Jian King
-->

<?php
require_once '../DA/Composite/PaymentComposite.php';
//require_once '../Domain/Customer.php';
//require_once '../Domain/UserDetails.php';

//$cust = getCustomerXML();
//$customerID = $cust->getId();
//$customerID = "C001";
$customerID = $_POST["custID"];   
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Payment Page</h1>
        <?php
//            $customerID = $_POST["customerID"];

            $paymentComposite = new PaymentComposite();
            $showOrder = $paymentComposite->ShowOrderDetails($customerID);
            echo $showOrder;
            
        ?>
        
        <form action="OrderPage.php" method="POST">
            <br/><br/>
            Card Number:<br/><input type = "text" pattern=".{16}" name = "quantity" value = "" title="Must 16 digit" maxlength="16" required/><br/><br/>
            Month:<br/><select name="mm">
                <option>01</option>
                <option>02</option>
                <option>03</option>
                <option>04</option>
                <option>05</option>
                <option>06</option>
                <option>07</option>
                <option>08</option>
                <option>09</option>
                <option>10</option>
                <option>11</option>
                <option>12</option>
            </select><br/><br/>
            Year: <br/><select name="yyyy">
                <option>2020</option>
                <option>2021</option>
                <option>2022</option>
                <option>2023</option>
                <option>2024</option>
                <option>2025</option>
                <option>2026</option>
                <option>2027</option>
                <option>2028</option>
                <option>2029</option>
                <option>2030</option>
            </select>
            <br/><br/>
            CVV:<br/><input type = "number" name = "stockId" value = "" maxlength="4" required/><br/><br/>
            Cardholder Name:<br/><input type = "text" name = "" value = "" required/><br/><br/>
            
            <?php echo "<input type=\"hidden\" name=\"custID\" value=\"" . $customerID . "\"/>"; ?>
            <input type="submit" value="Pay" name="payBtn" />
        </form>
        
    </body>
</html>
