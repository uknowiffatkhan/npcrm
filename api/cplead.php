<?php

header("Access-Control-Allow-Origin: https://pehlaghar.com/"); // Replace * with your actual frontend domain
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$baseurl="/npcrm/";   

include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl. "config/db.php";
require $_SERVER['DOCUMENT_ROOT'] . $baseurl. "mailer/PHPMailer.php";
require $_SERVER['DOCUMENT_ROOT'] . $baseurl. "mailer/SMTP.php";
require $_SERVER['DOCUMENT_ROOT'] . $baseurl. "mailer/Exception.php";
$conn = dbconnect();

ini_set("SMTP", "smtp.gmail.com");
ini_set("smtp_port", "587");
ini_set("sendmail_from", "khaniffat230920@gmail.com");


// Allow cross-origin resource sharing (CORS)

// Handle POST request from frontend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have form fields named 'name', 'mobile', 'email', 'username', 'password', 'confirmpassword', and 'lead_code'
    $name = $_POST['name'];
    $mobile = $_POST['mobno'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $roleid = $_POST['roleid'];
    $typeid = $_POST['typeid'];
    $createdId = $_POST['createdId'];
    $modifyId = $_POST['modifyId'];
    $status =$_POST['status'];
    $del =$_POST['del'];

    // Fetch the last CP Code just before the insert


    $lastCpCode = getLastCpCode($conn);
    $lastCpNumber = $lastCpCode ? intval(substr($lastCpCode, 3)) : 20240000;
    $newCpCode = 'GC-' . str_pad($lastCpNumber + 1, 8, '0', STR_PAD_LEFT);
    // Perform SQL insert
    $insertSql = "INSERT INTO tbl_channelpartner (Cp_Name, Cp_Mobile, Cp_Email,Cp_CreatedId,Cp_ModifiedId,Cp_Status,Cp_Del, Cp_Code) 
                  VALUES ('$name', '$mobile','$email','$createdId','$modifyId','$status','$del', '$newCpCode')";

    if ($conn->query($insertSql) === TRUE) {

        // Fetch the last inserted primary key
        $lastInsertId = $conn->insert_id;

        // Perform another insert with the retrieved primary key
        $secondInsertSql = "INSERT INTO tbl_users (U_RefrenceIdCp, U_Username, U_Password,U_ConfirmPassword,U_FullName,U_DisplayName,U_RoleId,U_TypeId,U_CreatedId,U_ModifiedId,U_Status,U_Del) 
                            VALUES ('$lastInsertId', '$mobile', '$password',' $confirmpassword','$name','$name','$roleid','$typeid','$createdId','$modifyId','Inactive','$del')";
        
        if ($conn->query($secondInsertSql) === TRUE) {

                $mail = new PHPMailer(true); // Set to true for exceptions

                try {
                    // PHPMailer configuration - SMTP settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                    $mail->SMTPAuth = true;

                

                    $mail->Username = '';
                    $mail->Password = ''; // Replace with your Gmail App Password

             

                    // Add recipient
                    $mail->addAddress($_POST['email'], $_POST['name']);

                    // Email subject and body
                    $mail->Subject = 'CP Login From Pehlaghar';
                    $mail->Body = "Hello " . $_POST['name'] . ",\n\n"
                        . "Thank you for registering!\n"
                        . "Your username: " . $mobile . "\n"
                        . "Your password: " . $password . "\n"
                        . "Please keep your login credentials secure.\n\n";

                    // Send the email
                    $mail->send();
                    echo "Record inserted successfully. Email sent to the user.";
                } catch (Exception $e) {
                    echo "Error sending email: " . $mail->ErrorInfo;
                }
        
            echo "Record inserted successfully";
        } 
        else
        {
            echo "Error in second insert: " . $secondInsertSql . "<br>" . $conn->error;
        }
    } 
    else 
    {
        echo "Error in first insert: " . $insertSql . "<br>" . $conn->error;
    }
    
}
// Close the connection
$conn->close();

function getLastCpCode($conn)
{
    $query = "SELECT Cp_Code FROM tbl_channelpartner ORDER BY Cp_Id DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['Cp_Code'];
    }
    return '';
}

?>
