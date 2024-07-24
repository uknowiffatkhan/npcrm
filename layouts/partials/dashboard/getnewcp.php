<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../model/dashboard.php");
$uid = $_SESSION["UId"];


$sw = getNewCp($uid);
// getCpUID($cpid)
//  var_dump($sw); // Debugging to see the contents of $sw

// Check if data is retrieved successfully
if ($sw === false) {
    // Handle the case where data retrieval fails
    exit(json_encode(array('error' => 'Failed to retrieve data')));
}

// Create an array to store the fetched data
$data = array();

// Fetch each row of data and add it to the array
while ($row = $sw->fetch_assoc()) {
    $data[] = $row;
}

// Encode the data as JSON and send it to the client
echo json_encode($data);

?>
