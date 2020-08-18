<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ManageStock
 *
 * @author user
 */
class ManageStock {

    private $ManageStockID;
    private $EditDate;
    private $StockID;
    private $StaffID;

    public function __construct($ManageStockID="", $EditDate="", $StockID="", $StaffID="") {
        $this->ManageStockID = $ManageStockID;
        $this->EditDate = $EditDate;
        $this->StockID = $StockID;
        $this->StaffID = $StaffID;
    }

    public function &__set($name, $value) {
        $this->$name = $value;
    }

    public function &__get($name) {
        return $this->$name;
    }

}
