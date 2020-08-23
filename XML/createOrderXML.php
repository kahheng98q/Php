<?php
//author: Chia Yang Jie

class createOrderXML {

    public function __construct($array) {
        $this->createXML($array);
    }

    function createXML($array) {

        $filePath = '../xml/orders.xml';
        $dom = new DOMDocument('1.0', 'UTF-8');
        $implementation = new DOMImplementation();
        $dom->appendChild($implementation->createDocumentType('orders SYSTEM \'orders.dtd\''));
        $root = $dom->createElement('orders');

        foreach ($array as $row) {

            $order = $dom->createElement('order');
            $order->setAttribute('OrderID', "O" . $row['OrderID']);
            
            $date = $dom->createElement('OrderDate', $row['OrderDate']);
            $order->appendChild($date);
            
            $status = $dom->createElement('OrderStatus',$row['OrderStatus']);
            $order->appendChild($status);
            
            $total = $dom->createElement('TotalAmount', $row['TotalAmount']);
            $order->appendChild($total);
            
            $custID = $dom->createElement('CustomerId', $row['CustomerId']);
            $order->appendChild($custID);
            
            $root->appendChild($order);
        }
        $dom->appendChild($root);
        $dom->save($filePath);
    }

}
