<?php
//author : Cheah Kah Heng
abstract class Stock {

    private $StockID;
    private $StockName;
    private $Type;
    private $UnitPrice;
    private $Quantity;
    private $WeightUnit;

    public function __construct($StockID, $StockName,$UnitPrice, $Type,  $Quantity, $WeightUnit) {
        $this->StockID = $StockID;
        $this->StockName = $StockName;
        $this->Type = $Type;
        $this->UnitPrice = $UnitPrice;
        $this->Quantity = $Quantity;
        $this->WeightUnit = $WeightUnit;
    }

    public function &__set($name, $value) {
        $this->$name = $value;
    }

    public function &__get($name) {
        return $this->$name;
    }

}
