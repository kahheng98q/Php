<?php
//author: Chia Yang Jie
    require_once '../XML/orderDom.php';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="viewOrderReport.php" method="POST">
            <input type="submit" value="view order received report" name="submit" />
        </form>
    </body>
</html>
<?php
       
        if(isset($_POST['submit']))
        {
            $orderParser = new orderDom("../XML/orders.xml");
        }
        ?>