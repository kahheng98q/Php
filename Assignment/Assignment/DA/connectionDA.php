<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->
<?php
function connectDB(){
        $host = "localhost";
        $user = "root";
        $passsword = "";
        $db = "bianbiansql";
        try{
        return $conn = new mysqli($host,$user,$passsword,$db);
        }catch(mysqli_sql_exception $e){
            echo "Database Connection Failed!" . $e;
        }
}
            

