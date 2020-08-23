<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->
<?php
    $_SESSION["attempt"]=0;
    $_SESSION["lock"]=0;
session_start();
    $_SESSION["attempt"];
    $_SESSION["lock"];
    
    if(isset($_SESSION["lock"])){
    header("Refresh:30");
    if($_SESSION["lock"]!=0){
        echo "<p>Looks like you ran out of attempt<br/>You will be able to retry after 30 seconds</p>";
            $dif = time() - $_SESSION["lock"];
            if ($dif >= 30){
                $_SESSION["lock"]=0;
                $_SESSION["attempt"]=0;
            }
    }}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Login Page</title>
    <body>
        <h2>User Authentication</h2>
        <form action="..\Domain\process_login.php" method="POST">
            <p>Email :<input type="text" name="email" size="30"/></p>
            <p>Password :<input type="text" name="password" size="18"/></p>
            <a name="forgot" href="..\UI\Forgot.html">Forgot password?</a>
            <a name="reg" href="..\UI\Registration.html">New to the web?</a><br><br>
            <input type="submit" name="login" value="Login" 
                <?php if(isset($_SESSION["attempt"]) && $_SESSION["attempt"]>2){ ?> disabled <?php }else ?> enabled 
                style='text-align: center;font-size: 25'/>
        </form>
    </body>
</html>
