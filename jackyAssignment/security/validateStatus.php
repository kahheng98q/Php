<?php
//author: Chia Yang Jie
class validateStatus {

    public function __construct() {
        
    }

    public function validateStatus($orderId, $orderStatus) {
        $err = "";
        if ($orderStatus == 'Complete') {
            $err .= "This order has been cancel or received, please try on another order.";
        }
        echo $err;
        if (strcmp($err, "") != 0) {
            
            return false;
        } else {
            return true;
        }
    }

}
