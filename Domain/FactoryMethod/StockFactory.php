<?php

//author : Cheah Kah Heng
require_once 'StockLiquid.php';
require_once 'StockSolid.php';

class StockFactory {

    private $type;

    public function getType($stockType, $unit) {
        if (strcasecmp($stockType, "SOLID") == 0) {
            $this->type = new StockSolid();
        } else if (strcasecmp($stockType, "LIQUID") == 0) {
            $this->type = new StockLiquid();
        }return $unit . $this->type->getStockUnit();
    }

    public function setStock($StockID, $StockName, $UnitPrice, $Type, $Quantity, $Volume) {
        if (strcasecmp(strtoupper($Type), "SOLID") == 0) {
            return new StockSolid($StockID, $StockName, $UnitPrice, $Type, $Quantity, $Volume);
        } else if (strcasecmp(strtoupper($Type), "LIQUID") == 0) {
            return new StockLiquid($StockID, $StockName, $UnitPrice, $Type, $Quantity, $Volume);
        } else {
            echo "Invalid Stock information.";
        }
    }

}
