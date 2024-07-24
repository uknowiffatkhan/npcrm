<style>
   .bg-danger-gradient {
   background-image: linear-gradient(to right, #ba2124 0%, #9f1c1f 100%);
   }
   .bg-success-gradient {
   background-image: linear-gradient(to right, #107e64 0%, #1f8617 100%);
   }
   #calenderDropdown .row{
      width: 100% !important;
   }
</style>
<div class="row justify-content-between  align-item-end">
   <div class="col-9">
      <div class="row mx-1 gy-2 ">
         <div class="col-6 card py-2">
            <div class="card-header mb-2">
               <span class="fw-bold fs-4 mb-0" id="reception_time_day"><?php echo date('l')?></span> 
               <p class="fw-bold fs-4 mb-0" id="reception_time"><?php echo date('Y-m-d g:i:s')?></p>
            </div>
            <div class="col-12">
               <div class="d-flex gap-3 " id="site_visit_plan">
                  <div class="card flex-fill" >
                     <div class="card-header p-3 bg-danger-gradient text-center px-4">
                        <i class="fa-solid fa-building-user fa-2xl text-white"></i>
                     </div>
                     <div class="card-body pt-0 p-3 text-center">
                     <div class="skeleton-label"></div>
                     <div class="skeleton-label md"></div>
                     <hr class="horizontal dark my-3">
                     <div class="skeleton-label"></div>
                     </div>
                     </div>

                  <div class="card flex-fill">
                     <div class="card-header p-3 bg-success-gradient text-center px-4">
                        <i class="fa-solid fa-building-user fa-2xl text-white"></i>
                     </div>
                     <div class="card-body pt-0 p-3 text-center">
                     <div class="skeleton-label"></div>
                        <div class="skeleton-label md"></div>
                        <hr class="horizontal dark my-3">
                        <div class="skeleton-label"></div>
                        </div>
                  </div>
                  </div>
            </div>
         </div>
         <div class="col-6">
            <div class="card h-100 justify-content-center align-items-center p-3" id="reception_calender">
            </div>
         </div>
         <div class="col-12 ps-0">
            <div class="card ">
               <div class="card-header pb-2 d-flex justify-content-between">
                  <span class="fs-3 mb-0 fw-bold" >Today Customer</span>
                  <input type="text" name="visitleadsearch" class="form-control form-control-sm mr-1 float-end w-50 float-end" placeholder="Search Sales Person">
               </div>
               <div class="table-responsive pb-5 ">
                  <table class="table align-items-center ">
                     <thead>
                        <tr>
                           <td>
                              <p class="text-xs font-weight-bold mb-0">Name</p>
                           </td>
                           <td>
                              <p class="text-xs font-weight-bold mb-0">Mobile No:</p>
                           </td>
                           <td>
                              <p class="text-xs font-weight-bold mb-0">Visting Date</p>
                           </td>
                           <td>
                              <p class="text-xs font-weight-bold mb-0">Lead Assign To </p>
                           </td>
                           <td>
                              <p class="text-xs font-weight-bold mb-0">Site Visit </p>
                           </td>
                        </tr>
                     </thead>
                     <tbody id="visit_planned_lead">
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
                            </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-3 card p-0">
      <div class="card-header pb-0 p-3">
         <span class="fw-bold mb-0">Available Sales Person</span>
         <span class="fw-bold mb-0">
         <input type="text" name="salesearch" class="form-control form-control-sm mr-1" placeholder="Search Sales Person">
         </span>
      </div>
      <div class="card-body p-3">
         <ul class="list-group" id="sale_List">
            <li class="list-group-item border-1 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
            <div class="card mr-1 w-100">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-md"></div>
                    </div>
            </div>
            </li>
            <li class="list-group-item border-1 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
            <div class="card mr-1 w-100">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-md"></div>
                    </div>
            </li>
            <li class="list-group-item border-1 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
            <div class="card mr-1 w-100">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-md"></div>
                    </div>
            </li>
            <li class="list-group-item border-1 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
            <div class="card mr-1 w-100" >
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-md"></div>
                    </div>
            </li>
         </ul>
      </div>
   </div>
</div>
</div>

