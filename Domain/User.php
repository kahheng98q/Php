<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->
<?php
abstract class User {
    private $id;
    private $name;
    private $email;
    private $pass;
    
    function __construct($id, $name, $email, $pass) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->pass = $pass;
    }
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getEmail() {
        return $this->email;
    }

    function getPass() {
        return $this->pass;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setName($name): void {
        $this->name = $name;
    }

    function setEmail($email): void {
        $this->email = $email;
    }

    function setPass($pass): void {
        $this->pass = $pass;
    }

    public abstract function getLoginDetails($email);
}
