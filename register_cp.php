<?php



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$baseurl="/npcrm/";  

include_once $_SERVER['DOCUMENT_ROOT'] .$baseurl. "config/db.php";
require $_SERVER['DOCUMENT_ROOT'] . $baseurl. "mailer/PHPMailer.php";
require $_SERVER['DOCUMENT_ROOT'] . $baseurl. "mailer/SMTP.php";
require $_SERVER['DOCUMENT_ROOT'] . $baseurl. "mailer/Exception.php";


ini_set("SMTP", "smtp.gmail.com");
ini_set("smtp_port", "587");
ini_set("sendmail_from", "khaniffat230920@gmail.com");

$conn = dbconnect();

// print_r($_POST);exit();
// Handle POST request from frontend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have form fields named 'name', 'mobile', 'email', 'username', 'password', 'confirmpassword', and 'lead_code'
    $leadId = $_POST['id'] ;
    // $leadId = $_POST['leadid'] ;
    echo "Lead ID: " . $leadId; // or use var_dump($leadId) for debugging
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $altMobile = $_POST["altMobile"];
    $email = $_POST['email'];
    $rerano = $_POST['Rerano'];
    $username = $_POST['username'];
    $roleid = $_POST['roleId'];
    $typeid = $_POST['typeId'];
    $createdId = $_POST['createdId'];
    $modifyId = $_POST['modifyId'];
    $status = $_POST['status'];
    $del = $_POST['del'];
    $uid = $_POST["uid"];
    echo "uid ID: " . $uid; 
    $team_id = $_POST["team_id"];
    //print_r($team_id);
    echo "Team ID: " . $team_id; 

    if ($uid != "") {
        $modifyId = $createdId = $uid;
    }
    
    // Fetch the last CP Code just before the insert
    $lastCpCode = getLastCpCode($conn);
    $lastCpNumber = $lastCpCode ? intval(substr($lastCpCode, 3)) : 20240000;
    $newCpCode = 'GC-' . str_pad($lastCpNumber + 1, 8, '0', STR_PAD_LEFT);


    $lastTeamid = getLastTeamCode($conn);


    // Perform SQL insert
    $insertSql = "INSERT INTO tbl_channelpartner (Cp_Name, Cp_Mobile,Cp_AltMobile, Cp_Email,Cp_ReraNo,Cp_CreatedId,Cp_ModifiedId,Cp_Status,Cp_Del, Cp_Code) 
                  VALUES ('$name', '$mobile','$altMobile','$email','$rerano','$createdId','$modifyId','$status','$del', '$newCpCode')";

    if ($conn->query($insertSql) === TRUE) {
        $lastInsertId = $conn->insert_id;
        

        $query = "SELECT Cp_Code FROM tbl_channelpartner WHERE Cp_Id = $lastInsertId ";
        $cpcode = $conn->query($query);
        while ($row = $cpcode->fetch_assoc()) {
                $cpc = $row['Cp_Code'];
                $randomPassword = generateRandomPassword();
              
                $secondInsertSql = "INSERT INTO tbl_users (U_RefrenceIdCp, U_Username,U_Password,U_FullName,U_DisplayName,U_Mobile,U_Email,U_RoleId,U_TypeId,U_CreatedId,U_ModifiedId,U_Status,U_Del) 
                                 VALUES ('$lastInsertId', '$username', '$randomPassword','$name','$name','$mobile','$email','$roleid','$typeid','$createdId','$modifyId','Inactive','$del')";
     
             if ($conn->query($secondInsertSql) === TRUE) {
                 $lastUserInsertId = $conn->insert_id;

            
                 $cpt = "INSERT INTO `tbl_team`(`Tm_Name`,`Tm_CreatedDate`, `Tm_CreatedId`, `Tm_Status`, `Tm_Del`) 
                 VALUES ('$cpc', NOW() ,'$lastUserInsertId', 'Active', '0')";
                 $conn->query($cpt);
                 $lastInsertTeamId = $conn->insert_id;

                 $tm = "INSERT INTO `tbl_teammap`(`tm_m_role`,`tm_m_uid`,`team_id`, `tm_m_CreatedDate`, `tm_m_Status`, `tm_m_Del`) 
                 VALUES (2,'$lastUserInsertId',$lastInsertTeamId, NOW() , 'Active', '0')";
                 $conn->query($tm);
                 $tm_id = $conn->insert_id;

                 $sql = "INSERT INTO `tbl_assigncpsource`(`AC_CpId`,`AC_UId`,`AC_TeamId`, `AC_CreatedId`,`AC_ModifiedId`, `AC_Del`) VALUES 
                 ($lastInsertId, $uid,$lastInsertTeamId,$uid,$uid,0)";
                  $sql = $conn->query($sql);
      
                 $cptid = $conn->insert_id;
     
                 if ($leadId) {
                    
                     $softDeleteSql = $conn->prepare("UPDATE tbl_assignlead SET Al_Del = 1 WHERE Al_LeadId = ?");
                     $softDeleteSql->bind_param("i", $leadId);
                     if ($softDeleteSql->execute()) {

                         echo "Record updated successfully in tbl_assignlead";
                     } else {
                         echo "Error updating record in tbl_assignlead: " . $softDeleteSql->error;
                     }
                 } else {
                     echo "Not getting Lead Id";
                 }
         
                 $softDeleteSql->close();          
     
                 // Fetch the password from the database
                 $getPasswordSql = "SELECT U_Password FROM tbl_users WHERE U_Id = '$lastUserInsertId'";
                 $result = $conn->query($getPasswordSql);
     
                 if ($result && $row = $result->fetch_assoc()) {
                     $hashedPassword = $row['U_Password'];
     
                     $mail = new PHPMailer(true); // Set to true for exceptions
     
                     try {
                         // PHPMailer configuration - SMTP settings
                         $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                         $mail->isSMTP();
                         $mail->Host = 'smtp.gmail.com';
                         $mail->Port = 465;
                         $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                         $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                         $mail->SMTPAuth = true;
                         $mail->SMTPDebug  = 0;

                         // Sender email address and password
                         $mail->Username = 'khaniffat230920@gmail.com';
                         $mail->Password = 'vitz mygp fbht mnlt'; // Replace with your Gmail App Password
     
                         // Set 'from' and 'reply-to' addresses
                         $mail->setFrom('khaniffat230920@gmail.com', 'Iffat');
                         $mail->addReplyTo('khaniffat230920@gmail.com', 'Iffat');
     
                         // Add recipient
                         $mail->addAddress($_POST['email'], $_POST['name']);
     
     
                         // Email subject and body
                         $mail->Subject = 'CP Login From Pehlaghar';
                         $mail->Body = "Hello " . $_POST['name'] . ",\n\n"
                             . "Thank you for registering!\n"
                             . "Your username: " . $_POST['username'] . "\n"
                             . "Your password: " . $randomPassword . "\n"
                             . "Please keep your login credentials secure.\n\n";
     
                         // Send the email
                         $mail->send();
                         echo "Record inserted successfully. Email sent to the user.";
                     } catch (Exception $e) {
                         echo "Error sending email: " . $mail->ErrorInfo;
                     }
                 } else {
                     echo "Error in getting password: " . $getPasswordSql . "<br>" . $conn->error;
                 }
             } else {
                 echo "Error in second insert: " . $secondInsertSql . "<br>" . $conn->error;
             }
        }


      
    } else {
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

    // Default to an empty string if no record is found
    return '';
}
function getLastTeamCode($conn)
{
    $query = "SELECT Tm_Id FROM tbl_team ORDER BY Tm_Id DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['Tm_Id'];
    }

    return '';
}
function getCpUid($conn,$cpid)
{
    $query = "SELECT U_Id FROM tbl_users ORDER BY U_Id DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['U_Id'];
    }

    return '';
}



function generateRandomPassword($length = 6)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    
    // Loop to generate 6 random characters
    for ($i = 0; $i < $length; $i++) {
        // Append a randomly selected character from the character set
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $password;
}

function AssignCpLead($lastInsertId, $uid, $teamid)
{
    $conn = dbconnect();

    $sql = "INSERT INTO `tbl_assigncpsource`(`AC_CpId`,`AC_UId`,`AC_TeamId`, `AC_CreatedId`,`AC_ModifiedId`, `AC_Del`) VALUES 
                        ($lastInsertId,$uid,$teamid,$uid,$uid,0)";
    $sql = $conn->query($sql);
    return $conn->insert_id;
}



?>
