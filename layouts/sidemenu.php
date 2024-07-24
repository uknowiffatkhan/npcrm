<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="<?php echo $baseurl ?>dashboard.php" class="app-brand-link">

      <h6 class="demo menu-text fw-bolder text-sm-end">GREEN CITY</h6>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item <?php echo str_contains($_SERVER['PHP_SELF'], "dashboard.php") ? "active" : "" ?>">
      <a href="<?php echo $baseurl ?>dashboard.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>
      <!-- Admin -->
    <?php if ($_SESSION["TypeId"] == "0" && $_SESSION["Role"] == "1") { ?>
      <li class="menu-item <?php echo str_contains($_SERVER['PHP_SELF'], "import.php") ? "active" : "" ?>">
        <a href="<?php echo $baseurl ?>v/lead/import.php" class="menu-link">
          <i class="menu-icon tf-icons bx bx-upload"></i>
          <div data-i18n="Analytics">Import Lead</div>
        </a>
      </li>
      <li class="menu-item <?php echo str_contains($_SERVER['PHP_SELF'], "activate.php") ? "active" : "" ?>">
        <a href="<?php echo $baseurl ?>v/users/activate.php" class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Analytics">Users List</div>
        </a>
      </li>
      <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "team/team.php") ? "active" : "" ?>">
      <a href="<?php echo $baseurl ?>v/team/team.php" class="menu-link">
      <i class="fa-solid fa-users-viewfinder"></i>
        <div class ="ms-3" data-i18n="Without menu">Team</div>
      </a>
    </li>
        <!-- Source manager Team Leader  -->
    <?php } elseif ($_SESSION["TypeId"] == "5" && $_SESSION["Role"] == "2")  { ?>
      <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead") && !str_contains($_SERVER['REQUEST_URI'], "cp") ? "open active" : "" ?>" style="">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Layouts">Lead</div>
        </a>
        <ul class="menu-sub">
        <?php if (empty($_SESSION['AId'])) : ?>

          <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead/source.php") ? "active" : "" ?>">
            <a href="<?php echo $baseurl ?>v/lead/source.php" class="menu-link">
              <div data-i18n="Without menu">Add Lead</div>
            </a>
          </li>
          <?php endif;?>
          <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead/cp_list.php") ? "active" : "" ?>">
            <a href="<?php echo $baseurl ?>v/lead/cp_list.php" class="menu-link">
              <div data-i18n="Without menu">Lead Lists</div>
            </a>
          </li>
          <?php if (empty($_SESSION['AId'])) : ?>
          <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead/import.php") ? "active" : "" ?>">
            <a href="<?php echo $baseurl ?>v/lead/import.php" class="menu-link">
              <div data-i18n="Without menu">Import Lead</div>
            </a>
          </li>
          <?php endif;?>
          
        </ul>
      </li>
    
      <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead") && str_contains($_SERVER['REQUEST_URI'], "cp") ? "open active" : "" ?>" style="">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Layouts"> Channel Partner Lead</div>
        </a>

      <ul class="menu-sub">
      <?php if (empty($_SESSION['AId'])) : ?>

        <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead/add_cp.php") ? "active" : "" ?>">
            <a href="<?php echo $baseurl ?>v/lead/add_cp.php" class="menu-link">
              <div data-i18n="Without menu">Add Channel Partner</div>
            </a>
          </li>
          <?php endif;?>

        <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead/confirmcp_lead.php") ? "active" : "" ?>">
          <a href="<?php echo $baseurl ?>v/lead/confirmcp_lead.php" class="menu-link">
            <div data-i18n="Without menu">Channel Partner Lists</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "team/team.php") ? "active" : "" ?>">
            <a href="<?php echo $baseurl ?>v/team/team.php" class="menu-link">
            <i class="fa-solid fa-users-viewfinder"></i>
              <div class ="ms-3" data-i18n="Without menu">Team</div>
            </a>
          </li>
      <li class="menu-item <?php echo str_contains($_SERVER['PHP_SELF'], "reminder.php") ? "active" : "" ?>">
      <a href="<?php echo $baseurl ?>v/reminder.php" class="menu-link">
        <i class="menu-icon bx bx-notepad"></i>
        <div data-i18n="Analytics">Calender</div>
      </a>
    </li>
    <!-- Channel Patner   -->
    <!-- && $_SESSION["Role"] == "1" -->
    <?php }elseif ($_SESSION["TypeId"] == "4" )  { ?>
      <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead") ? "open active" : "" ?>" style="">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Layouts">Lead</div>
        </a>

        <ul class="menu-sub">
        <?php if (empty($_SESSION['AId'])) : ?>

          <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead/cp_lead.php") ? "active" : "" ?>">
            <a href="<?php echo $baseurl ?>v/lead/cp_lead.php" class="menu-link">
              <div data-i18n="Without menu">Add Lead</div>
            </a>
          </li>
          <?php endif;?>
          <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead/list.php") ? "active" : "" ?>">
            <a href="<?php echo $baseurl ?>v/lead/list.php" class="menu-link">
              <div data-i18n="Without menu">Lead Lists</div>
            </a>
          </li>
          <?php if (empty($_SESSION['AId'])) : ?>

          <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead/import.php") ? "active" : "" ?>">
            <a href="<?php echo $baseurl ?>v/lead/import.php" class="menu-link">
              <div data-i18n="Without menu">Import Lead</div>
            </a>
          </li>
          <?php endif;?>
         
        </ul>
      </li>
      <?php if ($_SESSION["Role"] == "2") :?>
        <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "team/team.php") ? "active" : "" ?>">
      <a href="<?php echo $baseurl ?>v/team/team.php" class="menu-link">
      <i class="fa-solid fa-users-viewfinder"></i>
        <div class ="ms-3" data-i18n="Without menu">Team</div>
      </a>
    </li>
    <?php endif; ?>
      <li class="menu-item <?php echo str_contains($_SERVER['PHP_SELF'], "reminder.php") ? "active" : "" ?>">
      <a href="<?php echo $baseurl ?>v/reminder.php" class="menu-link">
        <i class="menu-icon bx bx-notepad"></i>
        <div data-i18n="Analytics">Calender</div>
      </a>
    </li>
    <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "cp/overview.php") ? "active" : "" ?>">
      <a href="<?php echo $baseurl ?>v/cp/overview.php" class="menu-link">
      <i class="fa-solid fa-chart-line"></i>
        <div class ="ms-3" data-i18n="Without menu">Overview</div>
      </a>
    </li>
    <?php } elseif($_SESSION["TypeId"] == "7"){?>

      <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead") ? "open active" : "" ?>" style="">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Layouts">Lead</div>
        </a>

        <ul class="menu-sub">
        <?php if (empty($_SESSION['AId'])) : ?>
          <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead/modify.php") ? "active" : "" ?>">
            <a href="<?php echo $baseurl ?>v/lead/modify.php" class="menu-link">
              <div data-i18n="Without menu">Add Lead</div>
            </a>
          </li>
          <?php endif;?>

          <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead/list.php") ? "active" : "" ?>">
          <a href="<?php echo $baseurl ?>v/lead/list.php?type=all&visitrange=<?php echo date('Y-m-d') ?>_<?php echo date('Y-m-d') ?>" class="menu-link">
          <div data-i18n="Without menu">Lead Lists</div>
            </a>
          </li>

        </ul>
      </li>
      <li class="menu-item <?php echo str_contains($_SERVER['PHP_SELF'], "reminder.php") ? "active" : "" ?>">
      <a href="<?php echo $baseurl ?>v/reminder.php" class="menu-link">
        <i class="menu-icon bx bx-notepad"></i>
        <div data-i18n="Analytics">Calender</div>
      </a>
    </li>
    
   

    <?php }else{ ?>
      <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead") ? "open active" : "" ?>" style="">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Layouts">Lead</div>
        </a>

        <ul class="menu-sub">
        <?php if (empty($_SESSION['AId'])) : ?>
          <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead/modify.php") ? "active" : "" ?>">
            <a href="<?php echo $baseurl ?>v/lead/modify.php" class="menu-link">
              <div data-i18n="Without menu">Add Lead</div>
            </a>
          </li>
          <?php endif;?>

          <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead/list.php") ? "active" : "" ?>">
            <a href="<?php echo $baseurl ?>v/lead/list.php" class="menu-link">
              <div data-i18n="Without menu">Lead Lists</div>
            </a>
          </li>
          <?php if (empty($_SESSION['AId'])) : ?>

          <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "lead/import.php") ? "active" : "" ?>">
            <a href="<?php echo $baseurl ?>v/lead/import.php" class="menu-link">
              <div data-i18n="Without menu">Import Lead</div>
            </a>
          </li>
          <?php endif;?>

        </ul>
      </li>
      <?php if ($_SESSION["Role"] == "2") :?>
        <li class="menu-item <?php echo str_contains($_SERVER['REQUEST_URI'], "team/team.php") ? "active" : "" ?>">
      <a href="<?php echo $baseurl ?>v/team/team.php" class="menu-link">
      <i class="fa-solid fa-users-viewfinder"></i>
        <div class ="ms-3" data-i18n="Without menu">Team</div>
      </a>
    </li>
    <?php endif; ?>
      <li class="menu-item <?php echo str_contains($_SERVER['PHP_SELF'], "reminder.php") ? "active" : "" ?>">
      <a href="<?php echo $baseurl ?>v/reminder.php" class="menu-link">
        <i class="menu-icon bx bx-notepad"></i>
        <div data-i18n="Analytics">Calender</div>
      </a>
    </li>
    
   
    <?php } ?>
    
  </ul>
</aside>