<?php
$baseurl="/npcrm/";   
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/db.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// check-rerano.php
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    $conn = dbconnect();

    // Check if rerano already exists in the database
    $query = "SELECT * FROM tbl_channelpartner WHERE Cp_Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s",  $email );
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "false"; // email already exists
    } else {
        echo "true"; // email is available
    }

    $stmt->close();
    $conn->close();
} else {
    echo "false"; // Invalid request
}
?>
