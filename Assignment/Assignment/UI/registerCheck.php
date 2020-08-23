<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->
<?php
    session_start();
    if(isset($_SESSION["locked"])){
    if($_SESSION["locked"]!=0){
            $dif = time() - $_SESSION["locked"];
            if ($dif >= 30){
                $_SESSION["locked"]=0;
                $_SESSION["attempt"]=0;
            }
    }}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User Check</title>
    </head>
    <body>
        <h3>
            Staff Verification
        </h3>
        
        <form action="" method="POST">
        <p>Staff Code: <input type="text" name="code" size="6"/></p>
        <?php
        if(isset($_POST['code']) && isset($_SESSION["attempt"])){
        if($_SESSION["attempt"]>2 && $_POST['code']!="123456" ){
        $_SESSION["locked"] = time();
        header("Refresh: 30");
        echo "<p>Looks like you ran out of attempt<br/>You will be able to retry after 30 seconds</p>";
        }
         else{
        ?>
        <input type="submit" name="confirm" value="Confirm"/>
        <?php
        }}
        else{
            if(isset($_SESSION["attempt"]) && $_SESSION["attempt"]>2){
            $_SESSION["locked"] = time();
            header("Refresh: 30");
            echo "<p>Looks like you ran out of attempt<br/>You will be able to retry after 30 seconds</p>";
        }
        else{
        ?>
        <input type="submit" name="confirm" value="Confirm"/>
        <?php
        }}
        ?>
        <input type="submit" name="back" value="Back"/>
        </form>
        <?php
        if(isset($_POST['back'])){
            header("Location: http://localhost/Assignment/UI/Registration.html");
            exit();
        }
        if(isset($_POST['confirm'])){
            if(!empty($_POST['code'])){
                if($_POST['code']=="123456"){
                    $_SESSION["attempt"]=0;
                    $_SESSION["locked"]=0;
                    header("Location: http://localhost/Assignment/UI/registerStaff.html");
                    exit;
                } else {
                    if(isset($_SESSION["attempt"])){
                    $left = 3 - $_SESSION["attempt"];
                    echo "<p>Wrong code entered!<br/>Attempt left: ".$left."</p>";
                    $_SESSION["attempt"] +=1;
                    }
                }
            } else {
                echo "<p>Code are needed to verify user</p>";
            }
        }
        ?>
    </body>
</html>
