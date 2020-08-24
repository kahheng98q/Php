<!DOCTYPE html>
<!--
Joseph Yeak Jian King
-->

<?php
require_once '../Domain/Composite/OrderComposite.php';
require_once '../Domain/Composite/PaymentComposite.php';
require_once '../Domain/Customer.php';
require_once '../XML/UserDetails.php';

$cust = getCustomerXML();
$customerID = $cust->getId();

$path = "../XML/Cart.xml";
if (file_exists($path)) {
    unlink($path);
}

//$customerID = "C001";
?>

<?php
if (isset($_POST['payBtn'])) {
    $paymentComposite = new PaymentComposite();
    $makePayment = $paymentComposite->Pay($customerID);
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

        <form action="CartPage.php" method="POST">
            <?php echo "<input type=\"hidden\" name=\"custID\" value=\"" . $customerID . "\"/>"; ?>
            <input type="submit" value="Cart" name="chgCart"/>

        <h1>Order Page</h1>
        <?php
        $orderComposite = new OrderComposite();
        $showStock = $orderComposite->RetrieveStock();
        echo $showStock;
        ?>

        <br/><br/>
        <form action="OrderPage.php" method="POST">
            Stock ID:<input type = "text" name = "stockId" value = "" required/><br/><br/>
            Quantity:<input type = "number" name = "quantity" value = "" min="1" required/><br/><br/>

            <input type="submit" value="Add to Cart" name="addBtn" />
        </form>

        <?php
        if (isset($_POST['addBtn'])) {
            $stockID = $_POST['stockId'];
            $quantity = $_POST['quantity'];

            $addCart = $orderComposite->AddToCart($stockID, $quantity, $customerID);
        }
        ?>
    </body>
</html>
