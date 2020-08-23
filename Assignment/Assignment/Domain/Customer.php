<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->
<?php
require_once 'User.php';

class Customer extends User{
    private $DOB;
    private $address;
    
    public function __construct($id, $name, $email, $pass, $DOB, $address) {
        parent::__construct($id, $name, $email, $pass);
        $this->DOB = $DOB;
        $this->address = $address;
    }
    function getDOB() {
        return $this->DOB;
    }

    function getAddress() {
        return $this->address;
    }

    function setDOB($DOB): void {
        $this->DOB = $DOB;
    }

    function setAddress($address): void {
        $this->address = $address;
    }    
    
    public function getLoginDetails($email) {
        return $this->pass;
    }

}

