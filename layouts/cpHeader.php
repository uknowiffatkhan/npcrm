<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <h4 class="mb-0">
                <?php echo $pagetitle ?>
            </h4>
            
            

        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li>
                <div class="d-none d-lg-flex mr-3">
                    <?php if($_SESSION["UId"] != 1){
                     if (empty($_SESSION['AId'])) :
                        ?><a href="<?php echo $baseurl ?>v/lead/cp_lead.php">+ Add Lead</a><?php
                     endif;
                    }?>
                    
                    <!-- <span class="px-3"></span> -->
                    <!-- <a href="<?php echo $baseurl ?>v/lead/source.php">+ Create Quotation</a> -->
                </div>
            </li>
            <li>
                <div class="mr-3 d-flex flex-nowrap align-items-center justify-content-center">
                    <input type="text" name="globalsearch" class="form-control form-control-sm mr-1"
                        placeholder="Global Search" />
                        <i class="fas fa-spinner fa-spin fa-sm" style="visibility:hidden"></i>
                </div>
                <div id="quicksearchcont" class="d-none">
                    
                </div>
            </li>
            <li class="nav-item navbar-dropdown dropdown-user dropdown notifications">
                <a class="nav-link dropdown-toggle d-flex align-items-center show-arrow" href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="notify-here">
                        <i class="far fa-bell"></i>
                        <img class="d-none" src="<?php echo $baseurl ?>assets/img/icons/notification.gif" />
                        <span></span>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="p-2">No Reminder</li>
                </ul>
            </li>
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-<?php echo $_SESSION["Status"] == 1 ? "online" : "offline" ?>">
                        <img src="<?php echo $baseurl ?>assets/img/avatars/1.jpg" alt
                            class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div
                                        class="avatar avatar-<?php echo $_SESSION["Status"] == 1 ? "online" : "offline" ?>">
                                        <img src="<?php echo $baseurl ?>assets/img/avatars/1.jpg" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">
                                        <?php echo $_SESSION["UName"] ?>
                                    </span>
                                    <div class="d-grid">
                                        <small class="text-muted">
                                            <?php echo $_SESSION["RoleN"] ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo $baseurl ?>profile.php">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo $baseurl ?>logout.php">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>