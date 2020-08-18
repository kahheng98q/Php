<?php

class StockDomXPath {

    private $xpath;

    public function __construct($filename) {
        $doc = new DOMDocument();
        $doc->load($filename);
        $this->xpath = new DOMXPath($doc);
    }

    public function display($expr) {
        echo "</p><p><h3>Total Solid's Stock in the Shop </h3>";
        $prices = $this->xpath->query($expr);
        foreach ($prices as $price) {
            
            echo $price->nodeValue . "<br />";
        }
    }

    public function evaluate($expr) {
        $result = $this->xpath->evaluate($expr);
        echo $result . "<br />";
    }

}
$worker = new StockDomXPath("StockXML.xml");
$worker->display("/stocks/stock[type='Solid']");