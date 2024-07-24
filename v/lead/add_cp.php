<?php

include('../../layouts/head.php');

include('../../layouts/auth.php');

include('../../model/leadmodel.php');

// if (isset($_SESSION['UId'])) {
//     // Display the contents of the session variable
//     echo '<pre>';
//     print_r($_SESSION);
//     echo '</pre>';
// }

// $cp_id = isset($_GET['cp_id']) ? $_GET['cp_id'] : null;
echo '<script>var sessionTypeId = ' . json_encode($_SESSION["TypeId"]) . ';</script>';




$uid = $_SESSION["UId"];
if (isset($_GET['cpid'])) {
    $cpid = decrypt($_GET['cpid']);
    $det = getCpLeadById($cpid, $uid);
    $det = $det->fetch_assoc();
    
    $caller = getcurrentCpCallerAssigned($cpid);
    $caller = $caller->fetch_assoc();
    
}

$code = "";
$cpcode = getCpCode($code);

$newLeadCode = 'Gc-20240001'; 
if ($cpcode) {
    $row = mysqli_fetch_assoc($cpcode);

    if ($row && isset($row['Cp_Code'])) {
        $lastLeadNumber = intval(substr($row['Cp_Code'], 3)) + 1;
        $newLeadCode = 'Gc-' . str_pad($lastLeadNumber, 6, '0', STR_PAD_LEFT);
    }
    
} else {
     echo "Last Cp_code is not there in last lead";
    }

?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <?php include('../../layouts/sidemenu.php') ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php
                $pagetitle = "Lead Form";



                include('../../layouts/header.php')
                    ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <input type="hidden" name="openlead" value="<?php echo isset($_SESSION["openlead"]) ? strval($_SESSION["openlead"]) : "" ?>">
                  
                        <form id="customerform">
                            <div class="">

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label>Full Name</label>
                                                    <div>
                                        
                                                    <input type="hidden" name="lead_code" id="leadCodeField"value="<?php echo $newLeadCode; ?>">
                                                    <input type="hidden" name="oldname" value="<?php echo isset($det) ? $det["Cp_Name"] : "" ?>">
                                                            <input type="text" name="fullname"
                                                            value="<?php echo isset($det) ? $det["Cp_Name"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label>Mobile No.</label>
                                                    <div>
                                                    <?php if($_SESSION["TypeId"] == 2 && isset($det)){
                                                            ?>
                                                            <label><?php echo isset($det) ? $det["Cp_Mobile"] : "-" ?></label>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <input type="hidden" name="oldmobno" value="<?php echo isset($det) ? $det["Cp_Mobile"] : "" ?>">
                                                            <input type="text" name="mobno"
                                                            value="<?php echo isset($det) ? $det["Cp_Mobile"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                            <?php
                                                        }?>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label>Alt Mobile No.</label>
                                                    <div>
                                                    <?php if($_SESSION["TypeId"] == 2 && isset($det)){
                                                            ?>
                                                            <label><?php echo isset($det) ? $det["Cp_AltMobile"] : "-" ?></label>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <input type="hidden" name="oldaltmobno" value="<?php echo isset($det) ? $det["Cp_AltMobile"] : "" ?>">
                                                            <input type="text" name="altmobno"
                                                            value="<?php echo isset($det) ? $det["Cp_AltMobile"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                            <?php
                                                        }?>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label>Email</label>
                                                    <div>
                                                    <?php if($_SESSION["TypeId"] == 2 && isset($det)){
                                                            ?>
                                                            <label><?php echo isset($det) ? $det["Cp_Email"] : "-" ?></label>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <input type="hidden" name="oldemail" value="<?php echo isset($det) ? $det["Cp_Email"] : "" ?>">
                                                            <input type="email" name="email"
                                                            value="<?php echo isset($det) ? $det["Cp_Email"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                            <?php
                                                        }?>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label>Address</label>
                                                    <div>
                                                    <?php if($_SESSION["TypeId"] == 2 && isset($det)){
                                                            ?>
                                                            <label><?php echo isset($det) ? $det["Cp_Address"] : "-" ?></label>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <input type="hidden" name="oldadd" value="<?php echo isset($det) ? $det["Cp_Address"] : "" ?>">
                                                            <input type="text" name="add"
                                                            value="<?php echo isset($det) ? $det["Cp_Address"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                            <?php
                                                        }?>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label>Pin</label>
                                                    <div>
                                                        <input type="hidden" name="oldpin" value="<?php echo isset($det) ? $det["Cp_Pin"] : "" ?>">
                                                        <input type="text" name="pin"
                                                            value="<?php echo isset($det) ? $det["Cp_Pin"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label>Location</label>
                                                    <div>
                                                        <input type="hidden" name="oldlocation" value="<?php echo isset($det) ? $det["Cp_Location"] : "" ?>">
                                                        <input type="text" name="location"
                                                            value="<?php echo isset($det) ? $det["Cp_Location"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                           
                                    <div class="card mb-4">
                                         <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label>Rera Number</label>
                                                        <div>
                                                            <input type="hidden" name="oldrerano" value="<?php echo isset($det) ? $det["Cp_ReraNo"] : "" ?>">
                                                            <input type="text" name="rerano"
                                                                value="<?php echo isset($det) ? $det["Cp_ReraNo"] : "" ?>"
                                                                class="form-control form-control-sm" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label>Pan No</label>
                                                        <div>
                                                            <input type="hidden" name="oldpanno" value="<?php echo isset($det) ? $det["Cp_PanNo"] : "" ?>">
                                                            <input type="text" name="panno"
                                                                value="<?php echo isset($det) ? $det["Cp_PanNo"] : "" ?>"
                                                                class="form-control form-control-sm" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label>GST Number</label>
                                                        <div>
                                                            <input type="hidden" name="oldgst" value="<?php echo isset($det) ? $det["Cp_gst"] : "" ?>">
                                                            <input type="text" name="gst"
                                                                value="<?php echo isset($det) ? $det["Cp_gst"] : "" ?>"
                                                                class="form-control form-control-sm" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label>Joining Date</label>
                                                        <div>
                                                        <input type="hidden" name="oldjoindate" value="<?php echo isset($det) ? $det["Cp_JoiningDate"] : "" ?>">
                                                            <input type="date" name="joindate"
                                                                value="<?php echo isset($det) ? date("Y-m-d", strtotime($det["Cp_JoiningDate"])) : "" ?>"
                                                                class="form-control form-control-sm" <?php echo isset($det) ? ($det["Cp_JoiningDate"] != "" ? "disabled" : "") : "" ?> />
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>  
                                        </div>
                                    </div>


                                    <div class="card mb-4">
                                         <div class="card-body">
                                         <div class="row">
                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label>Account No</label>
                                                        <div>
                                                            <input type="hidden" name="oldaccno" value="<?php echo isset($det) ? $det["Cp_AccNo"] : "" ?>">
                                                            <input type="text" name="accno"
                                                                value="<?php echo isset($det) ? $det["Cp_AccNo"] : "" ?>"
                                                                class="form-control form-control-sm" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label>IFSC No</label>
                                                        <div>
                                                            <input type="hidden" name="oldifsc" value="<?php echo isset($det) ? $det["Cp_IFSC"] : "" ?>">
                                                            <input type="text" name="ifsc"
                                                                value="<?php echo isset($det) ? $det["Cp_IFSC"] : "" ?>"
                                                                class="form-control form-control-sm" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label>Bank No</label>
                                                        <div>
                                                            <input type="hidden" name="oldbankno" value="<?php echo isset($det) ? $det["Cp_BankNo"] : "" ?>">
                                                            <input type="text" name="bankno"
                                                                value="<?php echo isset($det) ? $det["Cp_BankNo"] : "" ?>"
                                                                class="form-control form-control-sm" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label>Branch Name</label>
                                                        <div>
                                                            <input type="hidden" name="oldbranch" value="<?php echo isset($det) ? $det["Cp_Branch"] : "" ?>">
                                                            <input type="text" name="branch"
                                                                value="<?php echo isset($det) ? $det["Cp_Branch"] : "" ?>"
                                                                class="form-control form-control-sm" />
                                                        </div>
                                                    </div>
                                                </div>

                                        </div>
                                    </div>
                               
                            </div>

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-end">
                                            <div>
                                                <?php if (isset($det)) {
                                                    ?>
                                                    <input type="hidden" name="lid" value="<?php echo $det["Cp_Id"] ?>" />
                                                    <?php
                                                } ?>
                                                <input type="hidden" name="mode"
                                                    value="<?php echo isset($det) ? "updateconfirmcp" : "insertconfirmcp" ?>" />
                                                <button type="button"
                                                    class="btn btn-transparent text-danger">Cancel</button>
                                                <button type="submit" value="true" name="submit"
                                                    class="btn btn-info">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                            </div>
                        </form>


                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include('../../layouts/footer.php') ?>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->


    <?php include('../../layouts/foot.php') ?>

    <script src="<?php echo $baseurl ?>assets/js/bind/lead/add_cp.js?v=<?php echo $ver ?>"></script>

</body>

</html>