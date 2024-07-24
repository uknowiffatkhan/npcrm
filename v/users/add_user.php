<?php

include('../../layouts/head.php');

include('../../layouts/auth.php');

include('../../model/usermodel.php');
include('../../model/dropdownmodel.php');

echo '<script>var sessionTypeId = ' . json_encode($_SESSION["TypeId"]) . ';</script>';

$uid = $_SESSION["UId"];

if (isset($_GET['uid'])) {
    $user_id = decrypt($_GET['uid']);
    $det = getUserDetails($user_id);
}

$code = "";
$empcode = getEmpCode($code);

if ($empcode) {
    $row = mysqli_fetch_assoc($empcode);
    $lastEmpCode = $row['U_EmpCode'];
    $newEmpCode = $lastEmpCode + 1;
     
    $EmpCode = str_pad($newEmpCode, 3, '0', STR_PAD_LEFT);
} else {
     echo "Last Emp_code is not there in last lead";
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
                $pagetitle = "User Form";



                include('../../layouts/header.php')
                    ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <input type="hidden" name="openuser" value="<?php echo isset($_SESSION["openuser"]) ? strval($_SESSION["openuser"]) : "" ?>">
                  
                        <form id="adduser">
                            <div class="">

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label>Full Name<span class="text-danger fw-bold ms-1">*</span></label>
                                                    <div>
                                        
                                                    <input type="hidden" name="Emp_code" id="EmpCodeField"value="<?php echo   $EmpCode; ?>">
                                                    <input type="hidden" name="oldname" value="<?php echo isset($det) ? $det["U_FullName"] : "" ?>">
                                                            <input type="text" name="fullname"
                                                            value="<?php echo isset($det) ? $det["U_FullName"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label>Username<span class="text-danger fw-bold ms-1">*</span></label>
                                                    <div>
                                                    <input type="hidden" name="oldusername" value="<?php echo isset($det) ? $det["U_Username"] : "" ?>">
                                                            <input type="text" name="username"
                                                            value="<?php echo isset($det) ? $det["U_Username"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label>Display Name<span class="text-danger fw-bold ms-1">*</span></label>
                                                    <div>
                                                    <input type="hidden" name="olddname" value="<?php echo isset($det) ? $det["U_DisplayName"] : "" ?>">
                                                            <input type="text" name="dname"
                                                            value="<?php echo isset($det) ? $det["U_DisplayName"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                        
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label>Mobile No.<span class="text-danger fw-bold ms-1">*</span></label>
                                                    <div>
                                                    
                                                            <input type="hidden" name="oldmobno" value="<?php echo isset($det) ? $det["U_Mobile"] : "" ?>">
                                                            <input type="text" name="mobno"
                                                            value="<?php echo isset($det) ? $det["U_Mobile"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label>Email</label>
                                                    <div>
                                                    
                                                            <input type="hidden" name="oldemail" value="<?php echo isset($det) ? $det["U_Email"] : "" ?>">
                                                            <input type="email" name="email"
                                                            value="<?php echo isset($det) ? $det["U_Email"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label>User Type<span class="text-danger fw-bold ms-1">*</span></label>
                                                    <div>
                                                    <input type="hidden" name="olduserType" value="<?php echo isset($det) ? $det["U_TypeId"] : "" ?>">
                                                    <select class="form-control form-control-sm" 
                                                            <?php echo isset($det) ? "data-selected='" . $det["U_TypeId"] . "'" : "" ?> 
                                                            name="userType" id="userType" aria-label="Default select example">
                                                        <?php include("../../layouts/partials/dropdowns/usertype.php") ?>
                                                    </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label>User Role<span class="text-danger fw-bold ms-1">*</span></label>
                                                    <div>
                                                    <input type="hidden" name="olduserRole" value="<?php echo isset($det) ? $det["U_RoleId"] : "" ?>">
                                                    <select class="form-control form-control-sm" name="userRole" id="userRole" aria-label="Default select example"
                                                    <?php echo isset($det) ? "data-selected='" . $det["U_RoleId"] . "'" : "" ?> 
                                                    >
                                                        <?php include("../../layouts/partials/dropdowns/role.php") ?>

                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                                      <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label>User Team<span class="text-danger fw-bold ms-1">*</span></label> 

                                                    <button type="button" class="btn btn-link float-end "   style="--bs-btn-padding-y: .10rem; --bs-btn-padding-x: .5rem; font-size: .70rem;display:none;"  data-bs-toggle="modal" data-bs-target="#teamModal" id="addTeamBtn" >
                                                    <i class="fa-solid fa-plus mx-1"></i>Create Team
                                                    </button>

                                                    <div>
                                                    <input type="hidden" name="olduserTeam" value="<?php echo isset($det) ? $det["Tm_Id"] : "" ?>"  >
                                                    <select class="form-control form-control-sm" name="userTeam" id="userTeam" aria-label="Default select example"<?php echo isset($det) ? "data-selected='" . $det["Tm_Id"] . "'" : "" ?> >
                                                    <!-- <?php include("../../layouts/partials/dropdowns/team.php") ?> -->
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label>Address</label>
                                                    <div>
                                                            <input type="hidden" name="oldadd" value="<?php echo isset($det) ? $det["U_Address"] : "" ?>">
                                                            <input type="text" name="add"
                                                            value="<?php echo isset($det) ? $det["U_Address"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                    
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label>Location</label>
                                                    <div>
                                                        <input type="hidden" name="oldlocation" value="<?php echo isset($det) ? $det["U_Location"] : "" ?>">
                                                        <input type="text" name="location"
                                                            value="<?php echo isset($det) ? $det["U_Location"] : "" ?>"
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
                                                        <label>Aadhaar Card No</label>
                                                        <div>
                                                            <input type="hidden" name="oldadharno" value="<?php echo isset($det) ? $det["U_AdhaarNo"] : "" ?>">
                                                            <input type="text" name="adharno"
                                                                value="<?php echo isset($det) ? $det["U_AdhaarNo"] : "" ?>"
                                                                class="form-control form-control-sm" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label>Pan No</label>
                                                        <div>
                                                            <input type="hidden" name="oldpanno" value="<?php echo isset($det) ? $det["U_PanNo"] : "" ?>">
                                                            <input type="text" name="panno"
                                                                value="<?php echo isset($det) ? $det["U_PanNo"] : "" ?>"
                                                                class="form-control form-control-sm" />
                                                        </div>
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
                                                    <input type="hidden" name="uid" value="<?php echo $det["U_Id"] ?>" />
                                                    <?php
                                                } ?>
                                                <input type="hidden" name="mode"
                                                    value="<?php echo isset($det) ? "updateuser" : "insertuser" ?>" />
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

                        <!-- Modal -->
                        <div class="modal fade modal-md p-5" id="teamModal" tabindex="-1" aria-labelledby="teamModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="teamModalLabel">Team</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="createTeam">

                            <div class="modal-body">
                                <div class="col-12">
                                    <div class="my-1">
                                         <label>Team Name</label>
                                    </div>
                                    <div>
                                        <input type="text" name="tname" class="form-control form-control-sm" />
                                    </div>
                                </div>

                               <div class="col-12 mt-3">
                                    <div class="mb-1">
                                                <label>Team Parent</label>
                                    </div>
                                    <div>
                                    <select class="form-control form-control-sm" name="teamParent" id="teamParent" aria-label="Default select example">
                                        <?php include("../../layouts/partials/dropdowns/team.php") ?>
                                    </select>

                                    </div>
                                    <input type="hidden" name="mode"
                                    value="<?php echo isset($det) ? "updateteam" : "insertteam" ?>" />
                                </div>


                                <div class="modal-footer">
                                <button class="btn btn-primary" type="submit" id="teamSubmit" name="teamSubmit">Create</button>

                                </div>
                                </form>

                        </div>
                        </div>

                        </div>

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

    <script src="<?php echo $baseurl ?>assets/js/bind/users/add_user.js?v=<?php echo $ver ?>"></script>

</body>

</html>