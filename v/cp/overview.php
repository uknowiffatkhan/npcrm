<?php
   include('../../layouts/head.php');
   
   include('../../layouts/auth.php');
   
   include('../../model/leadmodel.php');
   
   $uid = $_SESSION["UId"];
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
               $pagetitle = "Overview";
               
               
               
               include('../../layouts/header.php')
                   ?>
            <!-- / Navbar -->
            <!-- Content wrapper -->
            <div class="content-wrapper">
               <div class="container-xxl flex-grow-1 container-p-y">
                  <div class="row">
                     <div class="col-12">
                        <div class="card mb-4">
                           <div class="card-body">
                              <div class="container-fluid">
                                 <div class="row">
                                    <div class="">
                                       <div class="card-header text-center fs-4 fw-medum ">
                                          Portfolio Performance
                                       </div>
                                       <div class="card-body ">
                                          <div class="accordion" id="accordionExample">
                                             <div class="accordion-item">
                                                <h2 class="accordion-header mx-5 mb-2">
                                                   <div class="row justify-content-center alidn-item-center gx-2 gy-2">
                                                      <div class="col-xxl-4 col-lg-4 col-md-6 col-12">
                                                         <div class="card card-raised border-bottom-0 border-end-0 border-top-0 border-danger border-4">
                                                            <div class="card-body px-2 py-3">
                                                               <div class="d-flex  align-items-center mb-2">
                                                                  <div class="ms-2 me-4 ">
                                                                     <div class="rounded-circle  bg-danger text-white px-3 py-2" style="width: 60px; height: 60px;justify-content: center;display: flex;align-items: center;">
                                                                        <i class="fa-solid fa-people-roof fa-xs"></i>                                                                    
                                                                     </div>
                                                                  </div>
                                                                  <div>
                                                                     <div class="card-text" style="font-size: 20px;">Total Booking</div>
                                                                     <div class="display-6">888</div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-xxl-4 col-lg-4 col-md-6 col-12">
                                                         <div class="card card-raised border-bottom-0 border-end-0 border-top-0 border-warning border-4">
                                                            <div class="card-body px-2 py-3">
                                                               <div class="d-flex  align-items-center mb-2">
                                                                  <div class="ms-2 me-4 ">
                                                                     <div class="rounded-circle bg-warning text-white" style="width: 60px; height: 60px;justify-content: center;display: flex;align-items: center;">
                                                                        <i class="fa-solid fa-people-group fa-xs"></i>
                                                                     </div>
                                                                  </div>
                                                                  <div>
                                                                     <div class="card-text" style="font-size: 20px;">Total Leads</div>
                                                                     <div class="display-6">110</div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-xxl-4 col-lg-4 col-md-6 col-12 ">
                                                         <div class="card card-raised border-bottom-0 border-end-0 border-top-0 border-primary border-4">
                                                            <div class="card-body px-2 py-3">
                                                               <div class="d-flex align-items-center mb-2">
                                                                  <div class="ms-2 me-4 ">
                                                                     <div class="rounded-circle bg-primary text-white " style="width: 60px; height: 60px;justify-content: center;display: flex;align-items: center;">
                                                                        <i class="fa-solid fa-indian-rupee-sign fa-sm"></i>                                                                    
                                                                     </div>
                                                                  </div>
                                                                  <div >
                                                                     <div class="card-text" style="font-size: 20px;">Total Revenue</div>
                                                                     <div class="display-6">101.1K</div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      </div>
                                                   </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                                   <div class="accordion-body">
                                                      <div class="row gx-2 gy-1">
                                                         <div class="col-xxl-3 col-lg-3 col-md-6 col-6">
                                                            <div class="card card-raised border-bottom-0 border-end-0 border-top-0 border-primary border-4">
                                                               <div class="card-body px-2 py-3">
                                                                  <div class="d-flex mb-2">
                                                                     <div class="ms-2 me-4 ">
                                                                        <div class="rounded-circle bg-primary text-white px-3 py-2" style="width: 60px; height: 60px;justify-content: center;display: flex;align-items: center;">
                                                                           <i class="fa-solid fa-hand-holding-hand fa-xl"></i>
                                                                        </div>
                                                                     </div>
                                                                     <div>
                                                                        <div class="display-5">101.1K</div>
                                                                        <div class="card-text">Eligible</div>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <div class="col-xxl-3 col-lg-3 col-md-6 col-6 ">
                                                            <div class="card card-raised border-bottom-0 border-end-0 border-top-0 border-warning border-4">
                                                               <div class="card-body  px-2 py-3">
                                                                  <div class="d-flex mb-2">
                                                                     <div class="ms-2 me-4 ">
                                                                        <div class="rounded-circle bg-warning text-white px-3 py-2" style="width: 60px; height: 60px;justify-content: center;display: flex;align-items: center;">
                                                                           <i class="fa-solid fa-hand-holding-dollar fa-xl"></i>
                                                                        </div>
                                                                     </div>
                                                                     <div>
                                                                        <div class="display-5">12.2K</div>
                                                                        <div class="card-text">Paid</div>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <div class="col-xxl-3 col-lg-3 col-md-6 col-6 ">
                                                            <div class="card card-raised border-bottom-0 border-end-0 border-top-0 border-secondary border-4">
                                                               <div class="card-body  px-2 py-3">
                                                                  <div class="d-flex mb-2">
                                                                     <div class="ms-2 me-4 ">
                                                                        <div class="rounded-circle bg-secondary text-white px-3 py-2" style="width: 60px; height: 60px;justify-content: center;display: flex;align-items: center;">
                                                                           <i class="fa-solid fa-wallet"></i>
                                                                        </div>
                                                                     </div>
                                                                     <div>
                                                                        <div class="display-5">5.3K</div>
                                                                        <div class="card-text">Balance</div>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <div class="col-xxl-3 col-lg-3 col-md-6 col-6 ">
                                                            <div class="card card-raised border-bottom-0 border-end-0 border-top-0 border-info border-4">
                                                               <div class="card-body  px-2 py-3">
                                                                  <div class="d-flex mb-2">
                                                                     <div class="ms-2 me-4 ">
                                                                        <div class="rounded-circle bg-info text-white px-3 py-2" style="width: 60px; height: 60px;justify-content: center;display: flex;align-items: center;">
                                                                        <i class="fa-solid fa-pause"></i>
                                                                        </div>
                                                                     </div>
                                                                     <div>
                                                                        <div class="display-5">15.49K</div>
                                                                        <div class="card-text">On Hold</div>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="card-footer text-body-secondary text-center d-flex justify-content-center align-content-center border border-start-0 border-bottom-0 border-end-0 py-1">
                                          <p><button class="accordion-button text-center " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa-solid fa-chevron-down"></i></button> </p>
                                       </div>
                                       <div class="row mt-2">
                                          <div class="col-6">
                                          <div class="card border-1 p-2">
                                             <div class="table-responsive">
                                                <table class="table table-hover table-light table-striped">
                                                   <thead>
                                                      <tr>
                                                      <th>Flat</th>
                                                      <th>Owner</th>
                                                      <th>Count</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody class="results_section">  
                                                         <tr class="resultTotalTr "> 
                                                            <td class="blue">1 BHK</td>
                                                            <td class="blue">SBD</td>
                                                            <td class="blue">152</td>
                                                      </tr>                                                                                  
                                                         <tr class="resultTotalTr "> 
                                                            <td class="blue">1 BHK- FS</td>
                                                            <td class="blue">Landlord</td>
                                                            <td class="blue">20</td>
                                                      </tr>
                                                      <tr class="resultTotalTr "> 
                                                            <td class="blue">2 BHK- FS</td>
                                                            <td class="blue">Landlord</td>
                                                            <td class="blue">14</td>
                                                      </tr>                                                                                
                                                   
                                                         <tr class="resultTotalTr ">
                                                            <td class="blue">SHOP</td>
                                                            <td class="blue">Investor</td>
                                                            <td class="blue">41</td>
                                                      </tr> 
                                                   </tbody>
                                                </table>
                                             </div>
                                          </div>
                                          </div>
                                          <div class="col-6"></div>
                                       </div>
                                       
                                    </div>
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
   <!-- <script src="<?php echo $baseurl ?>assets/js/bind/lead/source.js?v=<?php echo $ver ?>"></script> -->
</body>
</html>