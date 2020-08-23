<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->
<?php
require_once 'lib/nusoap.php';

$client = new nusoap_client("http://localhost/Assignment/WebService/LoginSOAPService.php");
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login Page(Client)</title>
    </head>
    <body>
        <h2>User Authentication Client's Web Service (SOAP)</h2>
        <form method="POST">
            <p>Email :<input type="text" name="email" size="30"/></p>
            <p>Password :<input type="text" name="password" size="18"/></p>
            <a name="forgot" href="..\UI\Forgot.html">Forgot password?</a>
            <a name="reg" href="..\UI\Registration.html">New to the web?</a><br><br>
            <input type="submit" name="login" value="Login" style='text-align: center;font-size: 25'/>
        </form>
    </body>
</html>
        <?php
        try{
        if (isset($_POST['login'])) {
                $email = $_POST['email'];
                $pass = $_POST['password'];
                $response = $client->call('validateStaff',
                        array("email" => $email, "password" => $pass));
                if ($response == false) {
                    $response = $client->call('validateCustomer',
                            array("email" => $email, "password" => $pass));
                    if ($response == false) {
                        echo 'ERROR: Login Web Services!';
                    } else {
                        $user = $client->call('getCustomer',
                        array("email" => $email));
                        $customer = explode("|",$user);
                        echo 'Customer Details are as follow :<br/>';
                        foreach($customer as $data){
                            echo $data ."<br/>";
                        }
                    }
                } else {
                    $user = $client->call('getStaff',
                        array("email" => $email));
                        $staff = explode("|",$user);
                        echo 'Staff Details are as follow :<br/>';
                    foreach($staff as $data){
                            echo $data ."<br/>";
                        }
                }     
        }}catch(Exception $ex){
            echo "ERROR: Login Web Services!";
        }
        ?>
