<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>Reset Password page</title>
    </head>
    <body>
        <?php
        
        if (isset($_POST["submit"])) {
            if (!empty($_POST["code"])) {
                $code = $_POST["code"];
                $ran = $_POST["rand"];
                if (isset($code) && $code == $ran) {
                    ?>
                    <h2>Code matched !</h2>
                    <form action="..\Domain\updatePass.php" method="POST">
                        <p>Please enter the following to reset your password:</p>
                        <p>New Password : <input type="text" name="password" size="18"/></p>
                        <p>Confirm Password : <input type="text" name="cp" size="18"/></p>
                        <input type="submit" name="update" value="Update Password"/>
                        <?php
                } else
                    echo '<p>Code not matched with the one sent. Please recheck and retype again.</p>';
            
            }else 
        echo '<p>Code are required to reset the password.</p>';}
                ?>
            </form>
    </body>
</html>