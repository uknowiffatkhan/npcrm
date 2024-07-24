<?php

include('../../layouts/head.php');

include('../../layouts/auth.php');

include('../../model/leadmodel.php');

$uid = $_SESSION["UId"];
if (isset($_GET['lid'])) {
    $lid = decrypt($_GET['lid']);
    $det = getLeadById($lid, $uid);
    $det = $det->fetch_assoc();
    
    $caller = getcurrentCallerAssigned($lid);
    $caller = $caller->fetch_assoc();
    
}


?>

<style>
    .highlighted-button {
        position: fixed;
        bottom: 10px;
        right: 10px;
        padding: 10px;
        background-color: #ff5722;
        color: #fff; /* Set text color to white */
        border: none;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease;
        animation: bounce 2s infinite;
    }

    .highlighted-button:hover {
        background-color: #d84315;
        animation: none;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-10px);
        }

        60% {
            transform: translateY(-5px);
        }
    }
</style>
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
                                    <h5 class="card-title">User Details</h5>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label>Full Name<span class="text-danger fw-bold ms-1">*</span></label>
                                                    <div>
                                                    <input type="hidden" name="leadtype" value="1">
                                                    <input type="hidden" name="oldname" value="<?php echo isset($det) ? $det["Ld_Name"] : "" ?>">
                                                            <input type="text" name="fullname"
                                                            value="<?php echo isset($det) ? $det["Ld_Name"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label>Mobile No.<span class="text-danger fw-bold ms-1">*</span></label>
                                                    <div>
                                                    <?php if($_SESSION["TypeId"] == 2 && isset($det)){
                                                            ?>
                                                            <label><?php echo isset($det) ? $det["Ld_Mobile"] : "-" ?></label>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <input type="hidden" name="oldmobno" value="<?php echo isset($det) ? $det["Ld_Mobile"] : "" ?>">
                                                            <input type="text" name="mobno"
                                                            value="<?php echo isset($det) ? $det["Ld_Mobile"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                            <?php
                                                        }?>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label>Alt Mobile No.</label>
                                                    <div>
                                                    <?php if($_SESSION["TypeId"] == 2 && isset($det)){
                                                            ?>
                                                            <label><?php echo isset($det) ? $det["Ld_AltMobile"] : "-" ?></label>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <input type="hidden" name="oldaltmobno" value="<?php echo isset($det) ? $det["Ld_AltMobile"] : "" ?>">
                                                            <input type="text" name="altmobno"
                                                            value="<?php echo isset($det) ? $det["Ld_AltMobile"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                            <?php
                                                        }?>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label>Email</label>
                                                    <div>
                                                    <?php if($_SESSION["TypeId"] == 2 && isset($det)){
                                                            ?>
                                                            <label><?php echo isset($det) ? $det["Ld_Email"] : "-" ?></label>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <input type="hidden" name="oldemail" value="<?php echo isset($det) ? $det["Ld_Email"] : "" ?>">
                                                            <input type="text" name="email"
                                                            value="<?php echo isset($det) ? $det["Ld_Email"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                            <?php
                                                        }?>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label>Address</label>
                                                    <div>
                                                        <input type="hidden" name="oldaddress" value="<?php echo isset($det) ? $det["Ld_Address"] : "" ?>">
                                                        <input type="text" name="address"
                                                            value="<?php echo isset($det) ? $det["Ld_Address"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label>Reference</label>
                                                    <div>
                                                        <input type="hidden" name="oldref" value="<?php echo isset($det) ? $det["Ld_Reference"] : "" ?>">
                                                        <input type="text" name="ref"
                                                            value="<?php echo isset($det) ? $det["Ld_Reference"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label>Location</label>
                                                    <div>
                                                        <input type="hidden" name="oldlocation" value="<?php echo isset($det) ? $det["Ld_Location"] : "" ?>">
                                                        <input type="text" name="location"
                                                            value="<?php echo isset($det) ? $det["Ld_Location"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label>City</label>
                                                    <div>
                                                        <input type="hidden" name="oldcity" value="<?php echo isset($det) ? $det["Ld_City"] : "" ?>">
                                                        <input type="text" name="city"
                                                            value="<?php echo isset($det) ? $det["Ld_City"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-2">
                                                    <label>Pin</label>
                                                    <div>
                                                        <input type="hidden" name="oldpin" value="<?php echo isset($det) ? $det["Ld_Pincode"] : "" ?>">
                                                        <input type="text" name="pin"
                                                            value="<?php echo isset($det) ? $det["Ld_Pincode"] : "" ?>"
                                                            class="form-control form-control-sm" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title">Lead Details</h5>
                                            <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Source<span class="text-danger fw-bold ms-1">*</span></label>
                                                            <div>
                                                                <input type="hidden" name="oldsource" value="<?php echo isset($det) ? $det["Ld_Source"] : "" ?>">
                                                                <select name="source" class="form-control form-control-sm" <?php echo isset($det) ? "data-selected=" . $det["Ld_Source"] . "" : "" ?>>
                                                                    <?php include("../../layouts/partials/dropdowns/source.php") ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Lead Status<span class="text-danger fw-bold ms-1">*</span></label>
                                                            <div>
                                                                <input type="hidden" name="oldleadstatus" value="<?php echo isset($det) ? $det["Ld_LeadStatus"] : "" ?>">
                                                                <select name="leadstatus" class="form-control form-control-sm"
                                                                    <?php echo isset($det) ? "data-selected=" . $det["Ld_LeadStatus"] . "" : "" ?>>
                                                                    <?php include("../../layouts/partials/dropdowns/leadstatus.php") ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Project</label>
                                                            <div>
                                                                <input type="hidden" name="oldproject" value="<?php echo isset($det) ? $det["Ld_ProjectId"] : "" ?>">
                                                                <select name="project" class="form-control form-control-sm"
                                                                    <?php echo isset($det) ? "data-selected=" . $det["Ld_ProjectId"] . "" : "" ?>>
                                                                    <?php include("../../layouts/partials/dropdowns/project.php") ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Interested For</label>
                                                            <div>
                                                                <input type="hidden" name="oldinterestedfor" value="<?php echo isset($det) ? $det["Ld_InterestedIn"] : "" ?>">
                                                                <select name="interestedfor"
                                                                    class="form-control form-control-sm" <?php echo isset($det) ? "data-selected=" . $det["Ld_InterestedIn"] . "" : "" ?>>
                                                                    <?php include("../../layouts/partials/dropdowns/roomtype.php") ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Budget</label>
                                                            <div>
                                                                <input type="hidden" name="oldbudget" value="<?php echo isset($det) ? $det["Ld_Budget"] : "" ?>">
                                                                <select name="budget"
                                                                    class="form-control form-control-sm" <?php echo isset($det) ? "data-selected=" . $det["Ld_Budget"] . "" : "" ?>>
                                                                    <?php include("../../layouts/partials/dropdowns/budget.php") ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Channel Partner</label>
                                                            <div>
                                                                <input type="hidden" name="oldchannelpartner" value="<?php echo isset($det) ? $det["Cp_Id"] : "" ?>">
                                                                <select name="channelpartner"
                                                                    class="form-control form-control-sm <?php echo isset($det) ? (datediff(date('Y-m-d',strtotime($det["Alcp_CreatedDate"]))) < 45 ? "" : "select2") : "select2" ?> " <?php echo isset($det) ? "data-selected=" . $det["Cp_Id"] . "" : "" ?>
                                                                    <?php echo isset($det) ? (datediff(date('Y-m-d',strtotime($det["Alcp_CreatedDate"]))) < 45 ? "disabled" : "") : "" ?>>
                                                                    <?php include("../../layouts/partials/dropdowns/channelpartner.php") ?>
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <small><?php echo isset($det) ? (datediff(date('Y-m-d',strtotime($det["Alcp_CreatedDate"]))) < 45 ? "Blocked till ".date('d M Y',strtotime("+45 days", strtotime($det["Alcp_CreatedDate"]) )) : "") : "" ?></small>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <?php if($_SESSION["TypeId"] == 2){
                                                                    ?>
                                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Assign Caller</label>
                                                            <div>
                                                            <input type="hidden" name="oldrefuser" value="<?php echo isset($det) ? (isset($caller['Al_CallerId']) ? $caller['Al_CallerId'] : '') : ''; ?>">
                                                                <!-- <input type="hidden" name="oldrefuser" value="<?php echo isset($det) ? $caller["Al_CallerId"] : "" ?>"> -->
                                                                <select name="refuser"
                                                                    class="form-control form-control-sm" <?php echo isset($det) ? "data-selected=" . $caller["Al_CallerId"] . "" : "" ?> <?php echo isset($caller) ? "disabled" : "" ?> >
                                                                    <?php include("../../layouts/partials/dropdowns/caller.php") ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                                    <?php
                                                                }?>
                                                    
                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Lead Date<span class="text-danger fw-bold ms-1">*</span></label>
                                                            <div>

                                                                <input type="date" name="leaddate"
                                                                    value="<?php echo isset($det) ? date("Y-m-d", strtotime($det["Ld_LeadDate"])) : date('Y-m-d') ?>"
                                                                    class="form-control form-control-sm" <?php echo isset($det) ? ($det["Ld_LeadDate"] != "" ? "disabled" : "") : "" ?> />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="mb-2">
                                                            <label>Remark</label>
                                                            <div>
                                                            <?php if($_SESSION["TypeId"] == 2 && isset($det)){
                                                                    ?>
                                                                    <label><?php echo isset($det) ? $det["Ld_Remark"] : "-" ?></label>
                                                                    <?php
                                                                }
                                                                else{
                                                                    ?>
                                                                    <textarea class="form-control form-control-sm" name="remark" <?php echo isset($det) ? ($det["Ld_Remark"] != "" ? "readonly" : "" ) : "" ?>><?php echo isset($det) ? $det["Ld_Remark"] : "" ?></textarea>
                                                                    <?php
                                                                }?>
                                                                
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
                                                    <input type="hidden" name="lid" value="<?php echo $det["Ld_Id"] ?>" />
                                                    <?php
                                                } ?>
                                                <input type="hidden" name="mode"
                                                    value="<?php echo isset($det) ? "updatecplead" : "insertcplead" ?>" />
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
                        <!-- <div class="highlighted-button">
                            <a href="/profile.php" style="color:#fff">Incomplete Profile</a>
                        </div> -->

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
    <script src="<?php echo $baseurl ?>assets/js/bind/lead/cp_lead.js?v=<?php echo $ver ?>"></script>

</body>

</html>