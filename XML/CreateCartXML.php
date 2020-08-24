<?php

/*
Joseph Yeak Jian King
 */
class CreateCartXML {
    public function __construct($cartArray) {
        $this->createXMLfile($cartArray);
    }

    function createXMLfile($cartArray) {
        $path = "../XML/Cart.xml";
        if (file_exists($path)){
            unlink($path);
        }
        
        $path = '../XML/Cart.xml';
        $dom = new DOMDocument('1.0', 'UTF-8');
        $implementation = new DOMImplementation();
        $dom->appendChild($implementation->createDocumentType('carts SYSTEM \'Cart.dtd\''));
        $root = $dom->createElement('carts');

        foreach ($cartArray as $row) {

            $cartID = $row['CartID'];
            $stockID = $row['StockID'];
            $stockName = $row['StockName'];
            $quantity = $row['Quantity'];
            $subPrice = $row['SubPrice'];


            $cart = $dom->createElement('cart');
            $cart->setAttribute('CartID', $cartID);
            $sID = $dom->createElement('StockID', $stockID);
            $cart->appendChild($sID);
            $sName = $dom->createElement('StockName', $stockName);
            $cart->appendChild($sName);
            $qtt = $dom->createElement('Quantity', $quantity);
            $cart->appendChild($qtt);
            $price = $dom->createElement('SubPrice', $subPrice);
            $cart->appendChild($price);

            $root->appendChild($cart);
        }
        $dom->appendChild($root);
        $dom->save($path);
    }
}
