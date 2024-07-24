<?php

include('../../layouts/head.php');

include('../../layouts/auth.php');

include('../../model/leadmodel.php');
include('../../model/dropdownmodel.php');

$uid = $_SESSION["UId"];
$baseurl = $_SESSION['baseurl'];

if($_SESSION["Role"] == 1){

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
                $pagetitle = "Users List";
                include('../../layouts/header.php');
                ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <div class="container-xxl flex-wrap container-p-y">
                            <div class="row justify-content-center justify-content-md-end">
                                <div class="col-4 col-md-3 col-lg-2 mb-2">
                                    <select class="form-select" id="userType" aria-label="Default select example">
                                    <?php include("../../layouts/partials/dropdowns/usertype.php") ?>
                                    </select>
                                </div>
                                <div class="col-4 col-md-3 col-lg-2 mb-2">
                                    <select class="form-select" id="userRole" aria-label="Default select example">
                                        <?php include("../../layouts/partials/dropdowns/role.php") ?>
                                        </select>
                                </div>
                                <div class="col-4 col-md-3 col-lg-2 mb-2">
                                    <div class="mr-3 d-flex flex-wrap align-items-center justify-content-end">
                                        <input type="text" name="userSearch" class="form-control " placeholder="Search User" />
                                        <i class="fas fa-spinner fa-spin fa-sm" style="visibility:hidden"></i>
                                    </div>
                            </div>
                            <input type="hidden" id="hiddenInput" name="hiddenInput" value="">
                            <div class="col-8 col-md-3 col-lg-2 mb-2">
                            <div class="mr-3 d-flex flex-wrap align-items-center justify-content-end">
                                <a name="" id="" class="btn btn-primary w-100" href="<?php echo $baseurl?>v/users/add_user.php" role="button">Add User</a >
                            </div>
                            <input type="hidden" id="pageNo" name="page" value="1"/>

                            </div>
                            <div class="col-md-12 mt-2">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="skeleton-table table">
                                            <thead class="border-bottom">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Contact No</th>
                                                    <th>Role</th>
                                                    <th>Type</th>
                                                    <th>Team</th>
                                                    <th>Status</th>
                                                    <th colspan="2" class="text-center">Action</th>
                                                </tr>
                                                
                                            </thead>
                                            <tbody id="userdetail">
                                            </tbody>
                                            
                                        </table>                            
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
    <script src="<?php echo $baseurl ?>assets/js/bind/users/activate.js"></script>
</body>

</html>

<?php
} else {
?>
<div>
    <h1>Not Authorized</h1>
    <a href="<?php echo $baseurl ?>dashboard.php">Dashboard</a>
</div>
<?php
}
?>
