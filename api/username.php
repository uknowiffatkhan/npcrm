<?php

$baseurl="/npcrm/";   
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/db.php";

header("Access-Control-Allow-Origin:  https://pehlaghar.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
// check-username.php

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $conn = dbconnect();
    // Check if username already exists in the database
    $query = "SELECT * FROM tbl_channelpartner WHERE Cp_UserName = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "false"; // Username already exists
    } else {
        echo "true"; // Username is available
    }

    $stmt->close();
    $conn->close();
} else {
    echo "false"; // Invalid request
}
?>
