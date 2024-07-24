<?php 
$ver = "1.2";

$baseurl="/npcrm/";   
include $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/db.php";
include $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/encrypter.php";


?>


<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed layout-menu-collapsed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Dashboard | Neral Property CRM</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo $baseurl?>assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?php echo $baseurl?>assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="<?php echo $baseurl?>assets/vendor/libs/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="<?php echo $baseurl?>assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo $baseurl?>assets/vendor/css/rtl/core.css?v=<?php echo $ver ?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php echo $baseurl?>assets/vendor/css/rtl/theme-default.css?v=<?php echo $ver ?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php echo $baseurl?>assets/css/demo.css?v=<?php echo $ver ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />


    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo $baseurl?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?php echo $baseurl?>assets/vendor/libs/typeahead-js/typeahead.css" />


    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo $baseurl?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="<?php echo $baseurl?>assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="<?php echo $baseurl?>assets/js/daterangepicker.css" />
    <link rel="stylesheet" href="<?php echo $baseurl?>assets/vendor/libs/select2/select2.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="<?php echo $baseurl?>assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?php echo $baseurl?>assets/js/config.js"></script>