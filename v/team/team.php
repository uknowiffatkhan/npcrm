<?php
   include('../../layouts/head.php');
   include('../../layouts/auth.php');
   include('../../model/usermodel.php');
   include('../../model/dropdownmodel.php');
   
   echo '<script>var sessionTypeId = ' . json_encode($_SESSION["TypeId"]) . ';</script>';
   
   
   $uid = $_SESSION["UId"];
   
   ?>
</head>
<style>
   #calendar {
   max-width: 900px;
   margin: 40px auto;
   }
   .fc-event-lunch {
   background-color: green;
   }
   .overview .card  {
   margin:0px 10px 10px;
   }
   .overview .card .card-body {
   padding: 8px;
   width: 6rem;
   }
   .overview .card .card-body label {
   font-size: 10px;
   }
   .overview .card .card-body.box2  {
   box-shadow: none;
   }
   .overview .card .card-body h1 {
   font-size: 20px;
   }
</style>
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
               $pagetitle = "Team";
               include('../../layouts/header.php');
               ?>
            <!-- / Navbar -->
            <!-- Content wrapper -->
            <div class="content-wrapper">
               <div class="container-fluid flex-grow-1 flex-row-reverse ">
                  <div class="row justify-content-end">
                     <div>
                        <div class="col-2 float-end mt-2">
                           <select class="form-control form-control-sm" id="teamview">
                           <?php include("../../layouts/partials/dropdowns/teams.php") ?>
                           </select>
                        </div>
                        <div class="col float-end mt-2 mx-1 ">
                        <div style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;min-width: 100px;display: flex;flex-wrap: nowrap;white-space: nowrap;align-items: center;font-size:10px" class="team-daterange">
                            <i class="fa fa-calendar"></i>&nbsp;
                                <span></span>&nbsp;<i class="fa fa-caret-down"></i>
                                    <input type="hidden" name="startdate" />
                                        <input type="hidden" name="enddate" />
                                                        </div>
                        </div>
                        
                     </div>
                     <div class="col-lg-12" id="memberview">
                        <div class="card mb-4">
                           <div class="card-body px-0 pt-0 pb-2">
                              <div class="table-responsive p-0 " >
                                 <table class="skeleton-table table">
                                    <thead>
                                       <tr>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                                 <table class="skeleton-table table">
                                    <thead>
                                       <tr>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                          <td>
                                             <div class="skeleton-label skeleton-w-full"></div>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
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
   <script src="<?php echo $baseurl ?>assets/js/bind/team/team.js?v=<?php echo $ver ?>"></script>
</body>
</html>