<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->
<?php
require_once 'User.php';

class Staff extends User{
    private $position;
    
    public function __construct($id, $name, $email, $pass, $position) {
        parent::__construct($id, $name, $email, $pass);
        $this->position = $position;
    }
    function getPosition() {
        return $this->position;
    }

    function setPosition($position): void {
        $this->position = $position;
    }
    
        public function getLoginDetails($email) {
        return $this->pass;
    }

}
