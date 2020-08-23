<?php
//author: Chia Yang Jie
require_once '../DA/DatabaseConnection.php';
?>
<html>

    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="uTable">

            <br><h1>Shipping Update Table</h1><br>
            <?php
            $db = DatabaseConnection::getInstance();
            $db->retrieveTable();
            if (isset($_POST['updateOrder'])) {
                $order = $_POST['updateOrder'];
                list($orderId, $status) = explode(' ', $order);
                if ($db->updateTable($orderId, $status) == true) {
                    header("Location: http://localhost/Assignment/UI/resultUpdate.php");
                    exit;
                }
            } else if (isset($_POST['cancelOrder'])) {
                $order = $_POST['cancelOrder'];
                list($orderId, $status) = explode(' ', $order);
                if ($db->updateTable($orderId, $status) == true) {
                    header("Location: http://localhost/Assignment/UI/resultUpdate.php");
                    exit;
                }
            } else {
                echo "</br>Please press button to perform action";
            }
            $db->closeConnection();
            ?> 
        </div>
    </body>

    <style>
        table,th,td{
            border: 2px solid black;
            border-collapse: collapse;
        }
        table, td{
            text-align: center;
        }
        th,td{
            padding: 15px;
        }
        th {
            background-color: #99CCFF;

        }
        tr:nth-child(even){
            background-color: #E1E3FF;
        }
        tr:nth-child(odd){
            background-color: #fff;
        }
    </style>
</html>


