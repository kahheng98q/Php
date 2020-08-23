<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->
<?php

require_once '..\Domain\Customer.php';
require_once '..\Domain\Staff.php';
require_once '..\XML\login.xml';

function getCustomerXML() {
    $doc = new DOMDocument;
    $doc->preserveWhiteSpace = false;
    $doc->load('..\XML\login.xml');
    $xpath = new DOMXPath($doc);
    $query = "//Login/user[@type = 'Customer']";
    $nodes = $xpath->query($query);
    if (!empty($nodes)){
        foreach($nodes as $node){
        return $cust = new Customer($node->childNodes[0]->nodeValue,
                $node->childNodes[1]->nodeValue, $node->childNodes[2]->nodeValue
                , $node->childNodes[3]->nodeValue, $node->childNodes[4]->nodeValue, 
                $node->childNodes[5]->nodeValue);
        }
    } else {
        echo 'No customer log in currently.';
    }
}

function getStaffXML() {
    $doc = new DOMDocument;
    $doc->preserveWhiteSpace = false;
    $doc->load('../XML/login.xml');
    $xpath = new DOMXPath($doc);
    $query = "//Login/user[@type = 'Staff']";
    $nodes = $xpath->query($query);
    if (!empty($nodes)){
        foreach($nodes as $node){
        return $staff = new Staff($node->childNodes[0]->nodeValue,
                $node->childNodes[1]->nodeValue, $node->childNodes[2]->nodeValue
                , $node->childNodes[3]->nodeValue, $node->childNodes[4]->nodeValue);
        }
    } else {
        echo 'No staff log in currently.';
    }
}