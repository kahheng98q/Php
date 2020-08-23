<?php


class ManageStock {

    private $ManageStockID;
    private $EditDate;
    private $Operation;
    private $StockID;
    private $StaffID;

    public function __construct($ManageStockID = "", $EditDate = "", $Operation = "", $StockID = "", $StaffID = "") {
        $this->ManageStockID = $ManageStockID;
        $this->EditDate = $EditDate;
        $this->Operation = $Operation;
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
