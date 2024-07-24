<?php 
$baseurl="/npcrm/";   
date_default_timezone_set('Asia/Kolkata');

function dbconnect()
{
    $servername = "localhost";

    $username = "root";

    $password = "";

    $dbname = "db_np_crm";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {

        die("Connection failed: " . $conn->connect_error);

    }

    return $conn;
}

?>