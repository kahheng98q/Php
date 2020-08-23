<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '..\PHPMailer-master\src\Exception.php';
require '..\PHPMailer-master\src\PHPMailer.php';
require '..\PHPMailer-master\src\SMTP.php';
require_once '..\DA\CustDA.php';
require_once '..\DA\StaffDA.php';

if (isset($_POST["send"])) {
    if (empty($_POST["email"])) {
        echo 'Email are required to reset password!';
        exit();
    }
    
    $_SESSION["to"] = "";
    $email = $_POST["email"];
    $emailCheck = requestEmailS($email);
    if ($emailCheck == false)
        $emailCheck = requestEmailC($email);
    if ($emailCheck == false) {
        echo 'Only user email are allowed to be used to reset password.';
        exit();
    } else {
        session_start();
        $_SESSION["to"]=$email;
        $ran = mt_rand(100000, 999999);
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->Host = "smtp.gmail.com";
        $mail->Username = "jarenywl-am17@student.tarc.edu.my";
        $mail->Password = "Wljaren#8";

        $mail->IsHTML(true);
        $mail->AddAddress($email, "$emailCheck");
        $mail->SetFrom("Convenient-Mart@gmail.com", "Convenience Store System");
        //$mail->AddReplyTo("reply-to-email@domain", "reply-to-name");
        //$mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
        date_default_timezone_set('Asia/kuala_lumpur');
        $mail->Subject = "Password Reset Request";
        $content = "Dear Honourable User, <b>" . $emailCheck
                . "<br/></b>Your account under this email from the <b>J3H Convenient Store</b> has requested a reset of password at the exact time <b>"
                . date("h:i:sa") . "<b> <br/>The code for the reset is: <b>" . $ran . "</b>";
        $mail->MsgHTML($content);
        if (!$mail->Send()) {
            echo "Error while sending Email.";
            var_dump($mail);
        } else {
            echo "Email sent successfully.<br/>Please enter the reset code accordingly.";
            echo '<form action="..\UI\ResetPassword.php" method="POST"><p>Reset Code: <input type="text" id="code" name="code" size="6"/></p>';
            echo '<input type="text" name="rand" value="'.$ran.'" style="visibility: hidden"/><br/>';
            echo '<input type="submit" name="submit" value="Reset Password"/></form>';
            
        }
    }
}
