<?php

/*
Joseph Yeak Jian King
 */

require_once '../Domain/Composite/CartComposite.php';
require_once 'CreateCartXML.php';

class CartDomParser {
    private $carts;
    
    public function __construct($filename) {
        $this->carts = new SplObjectStorage();
        $this->readXML($filename);
    }
    
    public function readXML($filename) {
        $count = 1;
        $totalPrice = 0;
        $xml = simplexml_load_file($filename);
        
        $cartList = $xml->xpath("/carts/cart");

        echo "<h2>Your Cart</h2>";
        echo '----------------------------------------------------------------------------------------------------';
        echo "<table><tr><th>NO</th><th>"
        . "</th><th>Stock ID</th><th>"
        . "</th><th>Stock Name</th><th>"
        . "</th><th>Quantity</th><th>"
        . "</th><th>Sub Price</th></tr><th>";

        foreach ($cartList as $cart) {
            $attr = $cart->attributes();
            echo "<tr><td>" . $count . "</td><td>";
            echo "</td><td>" . $cart->StockID . "</td><td>";
            echo "</td><td>" . $cart->StockName . "</td><td>";
            echo "</td><td>" . $cart->Quantity . "</td><td>";
            echo "</td><td>RM" . $cart->SubPrice . "</td></tr>";
            
            $totalPrice += (Double) $cart->SubPrice;
            $count++;
        }
        echo "</table><br/><br/>";
        echo "<b>Total Amount: RM</b>".$totalPrice;
        
    }
}