<?php

include('../../layouts/head.php');

include('../../layouts/auth.php');


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
                $pagetitle = "Upload Lead";



                include('../../layouts/header.php')
                    ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <form id="importform">
                            <div class="">

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <?php if($_SESSION["TypeId"] == "0" && $_SESSION["Role"] == "1"){?>
                                            <div class="col-md-4">
                                                <div class="d-grid">
                                                    <div class="d-flex mb-2">
                                                        <div class="form-check">
                                                            <input name="type" class="form-check-input"
                                                                type="radio" value="auto" id="auto" checked="">
                                                            <label class="form-check-label" for="auto">
                                                                Auto Distribution
                                                            </label>
                                                        </div>

                                                    </div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="form-check mr-3">
                                                            <input name="type" class="form-check-input"
                                                                type="radio" value="touser" id="touser">
                                                            <label class="form-check-label" for="touser">
                                                                To User
                                                            </label>
                                                        </div>
                                                        <div style="width:45%">
                                                            <select class="form-control form-control-sm" name="users">
                                                                <?php include("../../layouts/partials/dropdowns/users.php") ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="form-check mr-3">
                                                            <input name="type" class="form-check-input"
                                                                type="radio" value="toteam" id="toteam">
                                                            <label class="form-check-label" for="toteam">
                                                                To Team
                                                            </label>
                                                        </div>
                                                        <div style="width:45%">
                                                            <select class="form-control form-control-sm" name="teams">
                                                                <?php include("../../layouts/partials/dropdowns/team.php") ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="d-flex align-items-center mb-2">
                                                        <div class="form-check mr-3">
                                                            <input name="type" class="form-check-input"
                                                                type="radio" value="byproject" id="byproject">
                                                            <label class="form-check-label" for="byproject">
                                                                By Project
                                                            </label>
                                                        </div>
                                                        <div style="width:45%">
                                                            <select class="form-control form-control-sm" name="projects">
                                                                <?php include("../../layouts/partials/dropdowns/project.php") ?>
                                                            </select>
                                                        </div>
                                                    </div> -->

                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="col-md-5">
                                                <div class="mb-2">
                                                    <label class="d-flex justify-content-between">CSV File Upload
                                                        <small><a href="javascript:;" data-bs-toggle="modal"
                                                                data-bs-target="#modalCenter">How to import
                                                                Lead?</a></small></label>
                                                    <div>
                                                        <input type="file" name="file" accept=".csv"
                                                            class="form-control form-control-sm">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label>&nbsp;</label>
                                                    <div>
                                                        <span class="result"></span>
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

                                            <input type="hidden" name="mode" value="<?php echo $_SESSION["Role"] == "1" ? "insertcsvadmin" : ($_SESSION["TypeId"] == "5" ? "insertsourcecsv" : "insertcsv") ?>" />
                                                <button type="button"
                                                    class="btn btn-transparent text-danger">Cancel</button>
                                                <button type="submit" value="true" name="submit"
                                                    class="btn btn-info">Import</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="leadlist">

                                </div>
                            </div>
                        </form>

                        <div class="modal fade" id="modalCenter" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">How to import lead</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="import-guide">
                                            <h6>Steps to follow:</h6>
                                            <p>1. Download sample excel file from <a
                                                    href="../../assets/img/how-to-import-lead/Import Lead CRM.xlsm"
                                                    download>here</a></p>
                                            <p>2. Open the downloaded sample file.</p>
                                            <p>3. Enable Macros if prompted after opening it</p>
                                            <img src="../../assets/img/how-to-import-lead/step-1.png" class="w-100" />
                                            <p>*All required feilds are highlighted in red color.</p>
                                            <img src="../../assets/img/how-to-import-lead/step-3.png" class="w-100" />
                                            <p>*All date must be formatted in "dd-mm-yyyy" (date-month-year).</p>
                                            <p>*Do not save name with any numeric character.</p>
                                            <p>4. Clear dummy data row.</p>
                                            <p>5. Add new leads into rows to import in CRM.</p>
                                            <p>6. Select Option from dropdown for columns Project, Interested For,
                                                Source and Lead Status</p>
                                            <img src="../../assets/img/how-to-import-lead/step-2.png" class="w-100" />
                                            <p>7. After inserting new lead rows. Click on "Save As"->"CSV(Comma
                                                Delimited)(*.csv)"</p>
                                            <img src="../../assets/img/how-to-import-lead/step-4.png" class="w-100" />
                                            <p>8. Choose saved CSV formatted file and click on "Import" button.</p>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-label-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
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
    <script src="<?php echo $baseurl ?>assets/js/bind/lead/import.js?v=<?php echo $ver ?>"></script>

</body>

</html>