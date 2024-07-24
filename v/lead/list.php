<?php include('../../layouts/head.php');
include('../../layouts/auth.php');

$url_components = parse_url($_SERVER["REQUEST_URI"]);
if (isset($url_components['query'])) {
    parse_str($url_components['query'], $params);
}


?>

<link rel="stylesheet" href="<?php echo $baseurl ?>assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="<?php echo $baseurl ?>assets/vendor/libs/tagify/tagify.css" />

<link rel="stylesheet" href="<?php echo $baseurl ?>assets/css/lead.css?v=<?php echo $ver ?>">

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
                <?php $pagetitle = "Lead List";
                include('../../layouts/header.php') ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <input type="hidden" name="misc"
                        value="<?php echo (isset($params['misc']) ? $params['misc'] : "") ?>" />
                    <input type="hidden" name="uid"
                        value="<?php echo (isset($params['uid']) ? decrypt($params['uid']) : "") ?>" />
                        <input type="hidden" name="cid"
                        value="<?php echo (isset($params['cid']) ? decrypt($params['cid']) : "") ?>" />
                    <input type="hidden" name="masterfilterlisttype"
                        value="<?php echo (isset($params['type']) ? $params['type'] : "") ?>" />
                    <input type="hidden" name="masterfilterfiltertype"
                        value="<?php echo (isset($params['filtertype']) ? $params['filtertype'] : "") ?>" />
                    <input type="hidden" name="masterfilterfilter"
                        value="<?php echo (isset($params['filter']) ? $params['filter'] : "") ?>" />
                    <input type="hidden" name="masterfilterdate"
                        value="<?php echo (isset($params['range']) ? $params['range'] : (isset($params['visitrange']) ? $params['visitrange'] : "")) ?>" />
                        <input type="hidden" name="fromDate"
                        value="<?php echo (isset($params['fromDate']) ? $params['fromDate'] : "") ?>" />
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <div class="">
                            <div class="row">
                                <div class="col-12">

                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center filter-bar">
                                                <div class="d-flex align-items-center">
                                                    <?php if($_SESSION['TypeId'] != 7 ): ?>
                                                        <label class="btn btn-sm btn-listtype checked">
                                                            <input type="radio"  name="filtertype" class="d-none" value="statuswise"
                                                            checked /><i
                                                        class="fas fa-align-left rotate-90"></i></label>
                                                    <?php endif;?>
                                                    
                                                    <label class="btn btn-sm btn-listtype ">
                
                                                    <input type="radio" name="filtertype" class="d-none" value="alllist"   /><i
                                                            class="fas fa-list"></i></label>
                                                    <button type="button" class="btn btn-sm" id="reload"><i
                                                            class="fas fa-rotate"></i></button>
                                                    <div class="mx-3"></div>

                                                    <div class="d-flex align-items-center statuswisefilter mr-3">
                                                        <select class="form-control form-control-sm" name="statuswise">
                                                            <option value="leadstatus">Status Wise</option>
                                                            <option value="source">Source Wise</option>
                                                            <option value="interest">Interest Wise</option>
                                                            <option value="time" <?php echo (isset($params['wisefilter']) ? ($params['wisefilter'] == "time" ? "selected" : "") : "") ?>>Time Wise</option>
                                                        </select>
                                            
                                                    </div>

                                                    <div class="search-input">
                                                        <i class="fas fa-search"></i>
                                                        <input type="text" class="form-control form-control-sm" name="leadsearch" />
                                                    </div>
                                                </div>

                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3 d-flex align-items-center">
                                                        <select class="form-control form-control-sm mr-3" name="dateby">
                                                            <option value="lead">By Lead Date</option>
                                                            <option value="lastcall">By Last Call Date</option>
                                                            <option value="visitplan" <?php echo (isset($params['visitrange']) ? "selected" : "") ?>>By Visit Plan</option>
                                                        </select>
                                                        <div style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 100%;display: flex;flex-wrap: nowrap;white-space: nowrap;align-items: center;" class="daterange">
                                                            <i class="fa fa-calendar"></i>&nbsp;
                                                            <span></span>&nbsp;<i class="fa fa-caret-down"></i>
                                                            <input type="hidden" name="startdate" />
                                                            <input type="hidden" name="enddate" />
                                                        </div>
                                                    </div>
                                                    <div class="mr-3">
                                                        <span id="all-count">- Leads</span>
                                                    </div>
                                                    <?php if($_SESSION['TypeId'] != 7 ): ?>
                                                        <div>
                                                        <button type="button"
                                                            class="btn btn-sm filter-btn showfilter"><i
                                                                class="fas fa-filter"></i>&nbsp; Filter</button>
                                                    </div>
                                                    <?php endif;?>
                                                   
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body">
                                            <div class="list-container">



                                            </div>

                                        </div>
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

    <script src="<?php echo $baseurl ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?php echo $baseurl ?>assets/vendor/libs/tagify/tagify.js"></script>
    <script src="<?php echo $baseurl ?>assets/js/bind/lead/list.js?v=<?php echo $ver ?>"></script>
</body>

</html>