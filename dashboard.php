<?php 
include('./layouts/head.php');
include('./layouts/auth.php');
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}
$status = 'is not null';
$source = 'is not null';
$intin = '';

$limit = 10;
$pageno = 1;
$offset = 0;


if (isset($_GET["pgn"])) {
    $pageno = $_GET["pgn"];
}

if ($pageno > 1) {
    $offset = $limit * ($pageno - 1);
}

$data = [$search, $offset, $limit];


$res = [];
$totalpage = 0;

$totalpage = 0;
$total_no_of_pages = ceil($totalpage / $limit);

?>

<link rel="stylesheet" href="<?php echo $baseurl ?>assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="<?php echo $baseurl ?>assets/vendor/libs/tagify/tagify.css" />

<link rel="stylesheet" href="<?php echo $baseurl ?>assets/css/dashboard.css?v=<?php echo $ver ?>">

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <?php include('./layouts/sidemenu.php') ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php $pagetitle = "Dashboard";
                include('./layouts/header.php'); 
                // print_r($_SESSION);

                ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y px-5">
                        <?php if($_SESSION["TypeId"] == "0" && $_SESSION["Role"] == "1"){

                            include('./layouts/partials/dashboard/layout/admin.php');

                        }else if($_SESSION["TypeId"] == "5" && $_SESSION["Role"] == "2"){
                            
                            include('./layouts/partials/dashboard/layout/sourcing.php');
                            
                        }else if($_SESSION["TypeId"] == "4" && $_SESSION["Role"] == "2"){

                            include('./layouts/partials/dashboard/layout/cplead.php');

                        }elseif($_SESSION["TypeId"] == "7"){

                            include('./layouts/partials/dashboard/layout/reception.php');
                        }else{

                            include('./layouts/partials/dashboard/layout/member.php');

                        }?>
                        
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include('./layouts/footer.php') ?>
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


    <?php include('./layouts/foot.php') ?>

    <script src="<?php echo $baseurl ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?php echo $baseurl ?>assets/vendor/libs/tagify/tagify.js"></script>
    <?php if($_SESSION["TypeId"] == "0" && $_SESSION["Role"] == "1"){
        ?>
        <script src="<?php echo $baseurl ?>assets/js/bind/admin/admindashboard.js?v=<?php echo $ver ?>"></script>
        <?php
    }elseif($_SESSION["TypeId"] == "7"){?>
        
        <script src="<?php echo $baseurl ?>assets/js/bind/reception/reception.js?v=<?php echo $ver ?>"></script>

    <?php }
    else{
        ?>
        <script src="<?php echo $baseurl ?>assets/js/bind/dashboard.js?v=<?php echo $ver ?>"></script>    
        <?php
    }?>
    
</body>

</html>