<?php

include('./layouts/head.php');
include('./layouts/auth.php');


$roleId = isset($_SESSION['Role']) ? $_SESSION['Role'] : null;
$typeId = isset($_SESSION['TypeId']) ? $_SESSION['TypeId'] : null;

// echo "RoleId: $roleId, TypeId: $typeId";
?>

<link rel="stylesheet" href="<?php echo $baseurl ?>assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="<?php echo $baseurl ?>assets/vendor/libs/tagify/tagify.css" />

<link rel="stylesheet" href="<?php echo $baseurl ?>assets/css/lead.css?v=<?php echo $ver ?>">

</head>


<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include('./layouts/sidemenu.php') ?>
            <div class="layout-page">
                <?php $pagetitle = "Lead List";
                include('./layouts/cpHeader.php') ?>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
     
                        <?php if($roleId == "2" && $typeId=="4"){
                            
                            include('./layouts/partials/dashboard/layout/cpprofile.php');

                        }?>
                    </div>
                    <?php include('./layouts/footer.php') ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <?php include('./layouts/foot.php') ?>
    <script src="<?php echo $baseurl ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?php echo $baseurl ?>assets/vendor/libs/tagify/tagify.js"></script>
    <script src="<?php echo $baseurl ?>assets/js/bind/lead/list.js?v=<?php echo $ver ?>"></script>
</body>

</html>
