<?php
require_once '../DA/DatabaseConnection.php';
require_once '../XML/UserDetails.php';
require_once '../Domain/Customer.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $customer =getCustomerXML();
        $c =$customer->getId();
        $db = DatabaseConnection::getInstance();
        $result = $db->getOrderByCust($c);
        ?>
    </body>
</html>
