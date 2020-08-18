<?php

require_once '../Domain/ManageStock.php';

class ManageStockDA {

    public function AddManageStock($manageStock) {
        $query = "Insert Into ManageStock (ManageStockID,EditDate,StockID,StaffID) values (?,?,?,?)";
//        $rs = $this->db->query($query);

        try {
            $pstm = $this->db->prepare($query);
            $pstm->bindParam(1, $stock->ManageStockID, PDO::PARAM_STR);
            $pstm->bindParam(2, $stock->EditDate, PDO::PARAM_STR);
            $pstm->bindParam(3, $stock->StockID, PDO::PARAM_STR);
            $pstm->bindParam(4, $stock->StaffID, PDO::PARAM_STR);
            $pstm->execute();

           
        } catch (Exception $ex) {
            echo 'Failed to Manage Stock Record';
        }
    }

}
