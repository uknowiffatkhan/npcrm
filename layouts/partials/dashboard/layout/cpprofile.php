<?php
include_once $_SERVER['DOCUMENT_ROOT'] .$_SESSION['baseurl']. "config/db.php";
include_once $_SERVER['DOCUMENT_ROOT'] .$_SESSION['baseurl']. "model/leadmodel.php";


$conn = dbconnect();

function handlePhotoUpload($userId) {
    global $conn;

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
    $conn = dbconnect();

    $sql = "UPDATE tbl_users SET U_Photo = '$filename' WHERE U_Id = $userId";
    $result = $conn->query($sql);

   
}
function getProfilePhoto($userId) {
    global $conn;

    $sql = "SELECT U_Photo FROM tbl_users WHERE U_Id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $profilePhoto = $row['U_Photo'];
    }

    return isset($profilePhoto) ? 'uploads/' . $profilePhoto : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg';
}


$id = isset($_SESSION['UId']) ? $_SESSION['UId'] : null;

if ($id !== null) {
    $result = getCpDetails($id);

    // Check if data exists
    if ($result->num_rows > 0) {
        // Fetch the data and update leadDetails
        $row = $result->fetch_assoc();

        $cp_id = $row['Cp_Id'];
        
        // Update leadDetails with fetched data
        $leadDetails['name'] = $row['Cp_Name'];
        $leadDetails['email'] = $row['Cp_Email'];
        $leadDetails['mobile'] = $row['Cp_Mobile'];
        $leadDetails['altmobile'] = $row['Cp_AltMobile'];
        $leadDetails['location'] = $row['Cp_Location'];
        $leadDetails['pin'] = $row['Cp_Pin'];
        $leadDetails['account'] = $row['Cp_AccNo'];
        $leadDetails['ifsc'] = $row['Cp_IFSC'];
        $leadDetails['bankno'] = $row['Cp_BankNo'];
        $leadDetails['branch'] = $row['Cp_Branch'];
        $leadDetails['rerano'] = $row['Cp_ReraNo'];
        $leadDetails['gst'] = $row['Cp_gst'];

        $count = 0;
        $fieldsToCheck = array('name', 'email', 'mobile', 'altmobile', 'location', 'pin', 'account', 'ifsc', 'bankno', 'branch', 'rerano', 'gst');

        foreach ($fieldsToCheck as $field) {
            if (empty($leadDetails[$field])) {
                $count++;
            }
        }

        // Update the incomplete count in session
        $_SESSION['incomplete_profile'] = $count;

        $uploadResult = handlePhotoUpload($id);
        if ($uploadResult === true) {
            echo '<script>alert("Photo uploaded successfully!");</script>';
            echo '<script>window.location.href = "profile.php";</script>';
            exit; // Ensure script execution stops after redirect
        } elseif ($uploadResult !== false) {
            echo '<script>alert("' . $uploadResult . '");</script>';
        }
    }
}
?>


<link rel="stylesheet" href="<?php echo $baseurl ?>assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="<?php echo $baseurl ?>assets/vendor/libs/tagify/tagify.css" />

<link rel="stylesheet" href="<?php echo $baseurl ?>assets/css/lead.css?v=<?php echo $ver ?>">


</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .layout-wrapper {
        background-color: #fff;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .list-container {
        padding: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    .edit-btn {
        background-color: #4caf50;
        color: #fff;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 4px;
    }

    .profile-section {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .profile-label {
        font-weight: bold;
        width: 100px;
    }

    .profile-value {
        flex-grow: 1;
    }

    .fw-bold {
        color: #C8C8C8;
        font-size: 15px;
        font-weight: bold;
    }

    .lead-details {
        color: #686868;
        font-size: 18px;
    }

    .card2 {
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
    }
</style>


                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="">
                            <div class="row">
                                <div class="col-2">
                                    <div class="card">
                                    <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <div class="col-md-2 border-right">
                                            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                                                

                                                <!-- Display the user's profile photo -->
                                                <img class="rounded-circle mt-5" width="150px" src="<?php echo getProfilePhoto($id); ?>">


                                                <!-- Display the user's profile photo -->
                                            


                                                <!-- Form for uploading a new photo -->
                                                <form action="" method="post" enctype="multipart/form-data">
</br>
                                                    <input type="file" name="photo" id="photo" accept="image/*" style="display: none;">
                                                    <!-- Button to trigger file input -->
                                                    <label for="photo" class="btn btn-primary mb-3">Choose Photo</label>
                                                    <!-- Submit button for uploading the selected file -->
                                                    <input type="submit" name="submit" value="Upload" class="btn btn-primary">
                                                </form>
                                                <!-- Optional: Add a space or other elements for styling -->
                                                <span> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    </div>
                                    <div class="col-md-10 text-center mt-4">
                                                <div class="mb-1">
                                                <a href="<?php echo $baseurl ?>v/lead/add_cp.php?cpid=<?php echo urlencode(encrypt($cp_id))?>" class="btn btn-primary">Edit Profile</a>

                                                </div>
                                            </div>
                                </div>

                                <div class="col-7">
                                    <div class="card2">
                                        <div class="card-body">
                                            <!-- User Details Section -->
                                            <div class="details-blk">
                                                <h5 class="card-title mb-4">User Details</h5>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="mobileNumber1" class="fw-bold"><small>Name
                                                                    :</small></label>
                                                            <div class="lead-details" id="name">
                                                            <?php echo isset($leadDetails['name']) ? $leadDetails['name'] : '-'; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="mobileNumber1" class="fw-bold"><small>Email
                                                                    :</small></label>
                                                            <div class="lead-details" id="email">
                                                            <?php echo isset($leadDetails['email']) ? $leadDetails['email'] : '-'; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="mobileNumber1" class="fw-bold"><small>Mobile
                                                                    :</small></label>
                                                            <div class="lead-details" id="mob">
                                                            <?php echo isset($leadDetails['mobile']) ? $leadDetails['mobile'] : '-'; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="mobileNumber1" class="fw-bold"><small>Alt Mobile
                                                                    :</small></label>
                                                            <div class="lead-details" id="altmob">
                                                            <?php echo isset($leadDetails['altmobile']) ? $leadDetails['altmobile'] : '-'; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="mobileNumber1" class="fw-bold"><small>Location
                                                                    :</small></label>
                                                            <div class="lead-details" id="location">
                                                            <?php echo isset($leadDetails['location']) ? $leadDetails['location'] : '-'; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="mobileNumber1" class="fw-bold"><small>Pin
                                                                    :</small></label>
                                                            <div class="lead-details" id="pin">
                                                            <?php echo isset($leadDetails['pin']) ? $leadDetails['pin'] : '-'; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                    
                                        <!-- Space between sections -->
                                            <div class="mt-4"></div>

                                            <!-- Account Details Section -->
                                            <div class="card2">
                                            <div class="card-body">
                                            <div class="details-blk">
                                                <h5 class="card-title mb-4">Account Details</h5>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="mobileNumber1" class="fw-bold"><small>Account
                                                                    Number :</small></label>
                                                            <div class="lead-details" id="account">
                                                            <?php echo isset($leadDetails['account']) ? $leadDetails['account'] : '-'; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="mobileNumber1" class="fw-bold"><small>IFSC
                                                                    Code :</small></label>
                                                            <div class="lead-details" id="ifsc">
                                                            <?php echo isset($leadDetails['ifsc']) ? $leadDetails['ifsc'] : '-'; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="mobileNumber1" class="fw-bold"><small>Bank
                                                                    Number :</small></label>
                                                            <div class="lead-details" id="bankno">
                                                            <?php echo isset($leadDetails['bankno']) ? $leadDetails['bankno'] : '-'; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="mobileNumber1" class="fw-bold"><small>Branch Name :</small></label>
                                                            <div class="lead-details" id="branch">
                                                            <?php echo isset($leadDetails['branch']) ? $leadDetails['branch'] : '-'; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                            <!-- Space between sections -->
                                            <div class="mt-4"></div>

                                            <!-- Other Details Section -->
                                            <div class="card2">
                                            <div class="card-body">
                                            <div class="details-blk">
                                                <h5 class="card-title mb-4">Other Details</h5>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="mobileNumber1" class="fw-bold"><small>Rera
                                                                    Number :</small></label>
                                                            <div class="lead-details" id="rera">
                                                            <?php echo isset($leadDetails['rerano']) ? $leadDetails['rerano'] : '-'; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label for="mobileNumber1" class="fw-bold"><small>GST
                                                                    Number :</small></label>
                                                            <div class="lead-details" id="gst">
                                                            <?php echo isset($leadDetails['gst']) ? $leadDetails['gst'] : '-'; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="content-backdrop fade"></div>
                </div>
            
    <script src="<?php echo $baseurl ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?php echo $baseurl ?>assets/vendor/libs/tagify/tagify.js"></script>
    <script src="<?php echo $baseurl ?>assets/js/bind/lead/list.js?v=<?php echo $ver ?>"></script>
 



</body>

</html>
