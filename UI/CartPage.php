<!DOCTYPE html>
<!--
Joseph Yeak Jian King
-->
<?php
require_once '../Domain/Composite/CartComposite.php';
require_once '../XML/CartDomParser.php';
//require_once '../Domain/Customer.php';
//require_once '../Domain/UserDetails.php';

//$cust = getCustomerXML();
//$customerID = $cust->getId();


$customerID = $_POST["custID"];           
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="OrderPage.php" method="POST">
            <?php echo "<input type=\"hidden\" name=\"custID\" value=\"" . $customerID . "\"/>"; ?>
            <input type="submit" value="Back" name="backToOrder"/>
        </form>
        
        <?php
        $cartComposite = new CartComposite();
//        $showCart = $cartComposite->RetrieveCart();
//        echo $showCart;
        //$customerID= "CU01";
        
        $cartComposite = new CartComposite();
        $showCart = $cartComposite->retrieveForXML($customerID);
        new CreateCartXML($showCart);
        
        $cartParser = new CartDomParser("../XML/Cart.xml");
        ?>
        
        <form action="CartPage.php" method="POST">
            <br/><br/>
            Stock ID:<input type = "text" name = "stockId" value = "" />
            <?php echo "<input type=\"hidden\" name=\"custID\" value=\"" . $customerID . "\"/>"; ?>
            <input type="submit" value="Delete" name="deleteBtn" />
            <br/><br/>
        </form>
        
        <?php
        if (isset($_POST['deleteBtn'])) {
            $stockID = $_POST['stockId'];

            //$customerID = "CU01";
            $addCart = $cartComposite->DeleteCartItem($stockID, $customerID);
        }
        ?>
        
        <form action="PaymentPage.php" method="POST">
            <br/><br/>
            <?php echo "<input type=\"hidden\" name=\"custID\" value=\"" . $customerID . "\"/>"; ?>
            <input type="submit" value="Place Order" name="orderBtn" />
            <br/><br/>
        </form>
    </body>
</html>
