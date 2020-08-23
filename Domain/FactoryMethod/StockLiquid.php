<?php
//author : Cheah Kah Heng
require_once 'Stock.php';

class StockLiquid extends Stock {

    public function __construct($StockID = "", $StockName = "", $UnitPrice = 0, $Type = "", $Quantity = 0, $WeightUnit = 0) {
        parent::__construct($StockID, $StockName, $UnitPrice, $Type, $Quantity, $WeightUnit);
    }

    public function &__set($name, $value) {

        parent::__set($name, $value);
    }

    public function &__get($name) {

        return parent::__get($name);
    }

    public function getStockUnit() {
        return "liter";
    }

}
