<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/". "/config/db.php";

$conn = dbconnect();

function handlePhotoUpload($userId) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_FILES['photo'])) {
            $file = $_FILES['photo'];

            if ($file['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $filename = uniqid('photo_') . '_' . basename($file['name']);
                $uploadPath = $uploadDir . $filename;

                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    updateProfilePhoto($userId, $filename);
                    return true;
                } else {
                    return 'Error: Unable to move the uploaded file.';
                }
            } else {
                return 'Error: File upload failed with error code ' . $file['error'];
            }
        }
    }

    return false;
}
function updateProfilePhoto($userId, $filename) {
    global $conn; // Make $conn accessible in this function

    $sql = "UPDATE tbl_users SET U_Photo = '$filename' WHERE U_ID = $userId";
    $result = $conn->query($sql);

    return isset($profilePhoto) ? 'uploads/' . $profilePhoto : '';
}

function getProfilePhoto($userId) {
    global $conn; // Make $conn accessible in this function

    $sql = "SELECT U_Photo FROM tbl_users WHERE U_ID = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $profilePhoto = $row['U_Photo'];
    }

    return isset($profilePhoto) ? 'uploads/' . $profilePhoto : '';
}
?>
