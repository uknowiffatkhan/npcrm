<?php  

include_once $_SERVER['DOCUMENT_ROOT'] . "propertybooking/config/db.php";

include_once $_SERVER['DOCUMENT_ROOT'] . 'propertybooking/utils/mailer/Exception.php';
include_once $_SERVER['DOCUMENT_ROOT'] . 'propertybooking/utils/mailer/PHPMailer.php';
include_once $_SERVER['DOCUMENT_ROOT'] . 'propertybooking/utils/mailer/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


function send($mcid, $to, $cc, $bcc, $sub, $body, $attach){

    $conn = dbconnect();
    $sql = "SELECT * FROM `tbl_mailconfig` WHERE Mc_Id = $mcid";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = $result["Mc_Smtp"]; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = $result["Mc_Username"]; //SMTP username
        $mail->Password = $result["Mc_Password"]; //SMTP password
        $mail->SMTPSecure = $result["Mc_SmtpType"]; //Enable implicit TLS encryption
        $mail->Port = $result["Mc_SmtpPort"]; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($result["Mc_SetFrom"]);
        // $mail->addAddress('irfan.shaikh@acaira.in', 'Joe User');     //Add a recipient
        $mail->addAddress($to); //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = $sub;
        $mail->Body = $body;

        $mail->send();
        return true;

      } catch (Exception $e) {
        //echo "Error: Something Went Wrong";
        return false;
      }

}



?>