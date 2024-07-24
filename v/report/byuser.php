<?php include('../../layouts/head.php');
include('../../layouts/auth.php');

$team = $_SESSION["Team"];


?>

<link rel="stylesheet" href="<?php echo $baseurl ?>assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="<?php echo $baseurl ?>assets/vendor/libs/tagify/tagify.css" />


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
                <?php $pagetitle = "By User Report";
                include('../../layouts/header.php') ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card">
                            <div class="card-body">
                                <form id="userform">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control form-control-sm" name="users">
                                                <?php include("../../layouts/partials/dropdowns/users.php") ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 100%;display: flex;flex-wrap: nowrap;white-space: nowrap;align-items: center;"
                                                class="daterange form-control form-control-sm">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span>&nbsp;<i class="fa fa-caret-down"></i>
                                                <input type="hidden" name="startdate" />
                                                <input type="hidden" name="enddate" />
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div id="data-container">

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

    <script src="<?php echo $baseurl ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?php echo $baseurl ?>assets/vendor/libs/tagify/tagify.js"></script>
    <script src="<?php echo $baseurl ?>assets/js/bind/report/byuser.js"></script>

</body>

</html>