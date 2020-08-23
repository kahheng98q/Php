<?php
//author: Chia Yang Jie
require_once '../DA/DatabaseConnection.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of orderDetails
 *
 * @author User
 */
class order{
    
    private $OrderID, $OrderDate, $OrderStatus, $TotalAmount, $CustomerId;
    
    public function __construct($OrderID, $OrderDate, $OrderStatus, $TotalAmount, $CustomerId) {
        $this->OrderID        = $OrderID;
        $this->OrderDate      = $OrderDate;
        $this->OrderStatus    = $OrderStatus;
        $this->TotalAmount    = $TotalAmount;
        $this->CustomerId     = $CustomerId;
    }
    
    public function getOrderID(){
        return $this->OrderID;
    }
    public function getOrderDate(){
        return $this->OrderDate;
    }
    public function getOrderStatus(){
        return $this->OrderStatus;
    }
    public function getAmount() {
        return $this->TotalAmount;
    }
    public function getCustID() {
        return $this->CustomerId;
    }
    public function setOrderID($OrderID){
        $this->OrderID = $OrderID;
    }
    public function setOrderDate($OrderDate){
        $this->OrderDate = $OrderDate;
    }
    public function setOrderStatus($OrderStatus){
        $this->OrderStatus = $OrderStatus;
    }
    public function setAmount($TotalAmount){
        $this->TotalAmount = $TotalAmount;
    }
    public function setCustID($CustomerId) {
        $this->CustomerId = $CustomerId;
    }
    
}
