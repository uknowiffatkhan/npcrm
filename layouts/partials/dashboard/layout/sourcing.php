<div class="row">
    <div class="col-md-7">
        <div class="row">
            <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0">Today's Scope of Work</h5>
                        <!-- <div>
                                                <div style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 100%;display: flex;flex-wrap: nowrap;white-space: nowrap;align-items: center;"
                                                    class="status-daterange daterange form-control form-control-sm">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span>&nbsp;<i class="fa fa-caret-down"></i>
                                                    <input type="hidden" name="startdate" />
                                                    <input type="hidden" name="enddate" />
                                                </div>
                                            </div> -->

                    </div>

                    <div class="todays-scope status-cards">
                        <div class="card mr-1">
                            <div class="card-body skeleton-body">
                                <div class="skeleton-label"></div>
                                <div class="skeleton-label skeleton-lg"></div>
                            </div>
                        </div>
                        <div class="card mr-1">
                            <div class="card-body skeleton-body">
                                <div class="skeleton-label"></div>
                                <div class="skeleton-label skeleton-lg"></div>
                            </div>
                        </div>
                        <div class="card mr-1">
                            <div class="card-body skeleton-body">
                                <div class="skeleton-label"></div>
                                <div class="skeleton-label skeleton-lg"></div>
                            </div>
                        </div>
                        <div class="card mr-1">
                            <div class="card-body skeleton-body">
                                <div class="skeleton-label"></div>
                                <div class="skeleton-label skeleton-lg"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="col-12">
                <?php if (true) { ?>
    <hr/>
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex align-items-center justify-content-between mt-1">
                <h5 class="m-0">Status Wise</h5>
                <!-- <div>
                    <div style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 100%;display: flex;flex-wrap: nowrap;white-space: nowrap;align-items: center;"
                        class="status-daterange daterange form-control form-control-sm">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span>&nbsp;<i class="fa fa-caret-down"></i>
                        <input type="hidden" name="startdate" />
                        <input type="hidden" name="enddate" />
                    </div>
                </div> -->

            </div>

            <div class="status status-cards">
                <div class="card mr-1">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-lg"></div>
                    </div>
                </div>
                <div class="card mr-1">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-lg"></div>
                    </div>
                </div>
                <div class="card mr-1">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-lg"></div>
                    </div>
                </div>
            </div>
            <hr/>
        </div>

        <?php if ($_SESSION["TypeId"] == 1 || ($_SESSION["TypeId"] == 2 && $_SESSION["Role"] == 2)) { ?>
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-between mt-5">
                    <h5 class="m-0">Source Wise</h5>
                    <!-- <div>
                        <div style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 100%;display: flex;flex-wrap: nowrap;white-space: nowrap;align-items: center;"
                            class="src-daterange daterange form-control form-control-sm">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span>&nbsp;<i class="fa fa-caret-down"></i>
                            <input type="hidden" name="startdate" />
                            <input type="hidden" name="enddate" />
                        </div>
                    </div> -->

                </div>
                <div class="source status-cards">
                    <div class="card mr-1">
                        <div class="card-body skeleton-body">
                            <div class="skeleton-label"></div>
                            <div class="skeleton-label skeleton-lg"></div>
                        </div>
                    </div>
                    <div class="card mr-1">
                        <div class="card-body skeleton-body">
                            <div class="skeleton-label"></div>
                            <div class="skeleton-label skeleton-lg"></div>
                        </div>
                    </div>
                    <div class="card mr-1">
                        <div class="card-body skeleton-body">
                            <div class="skeleton-label"></div>
                            <div class="skeleton-label skeleton-lg"></div>
                        </div>
                    </div>
                </div>
                <hr/>
            </div>
        <?php } ?>
        </div>
        
       

       

<?php } ?>
            </div>
    </div> 
    
</div>    

    <div class="col-md-5">
        <div class="d-flex align-items-center justify-content-center">
                <h5 class="m-0">Activity Report</h5>
                <div class="d-flex">
                    <?php if ($_SESSION["Role"] == 2) {
                        ?>
                        <div class="mr-1">
                            <select class="form-control form-control-sm" name="activityusers" style="width:150px">
                                <?php include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "layouts/partials/dropdowns/users.php" ?>
                            </select>
                        </div>
                        <?php
                    } ?>

                    <div style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 100%;display: flex;flex-wrap: nowrap;white-space: nowrap;align-items: center;"
                        class="activityreport-daterange daterange form-control form-control-sm">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span>&nbsp;<i class="fa fa-caret-down"></i>
                        <input type="hidden" name="startdate" />
                        <input type="hidden" name="enddate" />
                    </div>
                </div>

            </div>
            <div class="activityreport status-cards">
                <div class="d-flex w-100 align-items-center">
                    <div class="card mr-1" style="width:35%">
                        <div class="card-body skeleton-body">
                            <div class="skeleton-label"></div>
                            <div class="skeleton-label skeleton-md"></div>
                        </div>
                    </div>
                    <div class="card mr-1">
                        <div class="card-body skeleton-body">
                            <div class="skeleton-label"></div>
                            <div class="skeleton-label skeleton-md"></div>
                        </div>
                    </div>
                    <div class="card mr-1">
                        <div class="card-body skeleton-body">
                            <div class="skeleton-label"></div>
                            <div class="skeleton-label skeleton-md"></div>
                        </div>
                    </div>
                </div>
                <div class="card w-100">
                    <div class="card-body">
                        <table class="skeleton-table table">
                            <thead>
                                <tr>
                                    <td><div class="skeleton-label skeleton-w-full"></div></td>
                                    <td><div class="skeleton-label skeleton-w-full"></div></td>
                                    <td><div class="skeleton-label skeleton-w-full"></div></td>
                                    <td><div class="skeleton-label skeleton-w-full"></div></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><div class="skeleton-label skeleton-w-full"></div></td>
                                    <td><div class="skeleton-label skeleton-w-full"></div></td>
                                    <td><div class="skeleton-label skeleton-w-full"></div></td>
                                    <td><div class="skeleton-label skeleton-w-full"></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
    
    </div>
    <?php if (true) { ?>
    <div class="col-md-12 box-shadow px-4 mb-3">
        <div class="row">
            <div class="d-flex align-items-center justify-content-between text-white ">
                <h3 class="col-8 m-0 p-0">Channel Partner</h3>
                <div class="col-2 ccp status-card m-0 p-0"></div>
                <div class="col-2 ccpl status-card"></div>
                <!-- <button type="button" class="btn btn-warning">
                Cp Leads<span class="badge ccpl status-card m-0 text-bg-dark mx-2"></span>
                </button> -->
                <!-- <div class="col-2 card bg-info">
                        <div class="card-body">
                            <div class=""><span>Confirm Channel Partner </span>-<span class="ccp status-card"></span></div>
                            <!-- <div class=" ccp status-card"></div> 
                        </div>
                    </div>
                    <div class="col-2 card w-15 mx-2  bg-warning text-white ">
                        <div class="card-body">
                            <div class="">Cp Leads <span class="ccpl status-card"></span></div>
                            <!-- <div class="ccpl status-card"></div> 
                        </div>
                    </div> -->
            </div>
            </div>
            <!-- Table for Confirm Leads and CP Leads -->
            <!-- <div class="table-responsive" style="margin-top:10px">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Confirm Channel Partner</th>
                            <th>CP Leads</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Placeholder rows for confirmed and CP leads
                        <tr>
                            <td class="ccp status-card"></td>
                            <td class="ccpl status-card"></td>     
                        </tr>
                    
            
                    </tbody>
                </table>
            </div> -->
             <!-- <hr/> -->

             <div class="d-flex align-items-center justify-content-between">
                <!-- <h5 class="m-0">Latest Channel Partner List</h5> -->
            </div>
            <!-- Table for Confirm Leads and CP Leads -->
            <div class="table-responsive" style="margin-top:2px">
                <table id="latestChannelPartnerListTable" class="table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Leads</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <!-- Placeholder rows for confirmed and CP leads -->
                        <tr>
                            <td></td>
                            <td ></td>
                            <td></td>
                            <td></td>
                        </tr>
                    
                        <!-- End placeholder rows -->
                    </tbody>
                </table>
            </div>
             <!-- <hr/> -->
        </div>







































   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
<!--    
        <div class="col-md-6">
        <div>
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="m-0">Today's Scope of Work</h5>
                <!-- <div>
                                        <div style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 100%;display: flex;flex-wrap: nowrap;white-space: nowrap;align-items: center;"
                                            class="status-daterange daterange form-control form-control-sm">
                                            <i class="fa fa-calendar"></i>&nbsp;
                                            <span></span>&nbsp;<i class="fa fa-caret-down"></i>
                                            <input type="hidden" name="startdate" />
                                            <input type="hidden" name="enddate" />
                                        </div>
                                    </div>

            </div>

            <div class="todays-scope status-cards">
                <div class="card mr-1">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-lg"></div>
                    </div>
                </div>
                <div class="card mr-1">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-lg"></div>
                    </div>
                </div>
                <div class="card mr-1">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-lg"></div>
                    </div>
                </div>
                <div class="card mr-1">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-lg"></div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <?php } ?>

































    <div class="col-md-6">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="m-0">Activity Report</h5>
            <div class="d-flex">
                <?php if ($_SESSION["Role"] == 2) {
                    ?>
                    <div class="mr-1">
                        <select class="form-control form-control-sm" name="activityusers" style="width:150px">
                            <?php include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "layouts/partials/dropdowns/users.php" ?>
                        </select>
                    </div>
                    <?php
                } ?>

                <div style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 100%;display: flex;flex-wrap: nowrap;white-space: nowrap;align-items: center;"
                    class="activityreport-daterange daterange form-control form-control-sm">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span>&nbsp;<i class="fa fa-caret-down"></i>
                    <input type="hidden" name="startdate" />
                    <input type="hidden" name="enddate" />
                </div>
            </div>

        </div>
        <div class="activityreport status-cards">
            <div class="d-flex w-100 align-items-center">
                <div class="card mr-1" style="width:35%">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-md"></div>
                    </div>
                </div>
                <div class="card mr-1">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-md"></div>
                    </div>
                </div>
                <div class="card mr-1">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-md"></div>
                    </div>
                </div>
            </div>
            <div class="card w-100">
                <div class="card-body">
                    <table class="skeleton-table table">
                        <thead>
                            <tr>
                                <td><div class="skeleton-label skeleton-w-full"></div></td>
                                <td><div class="skeleton-label skeleton-w-full"></div></td>
                                <td><div class="skeleton-label skeleton-w-full"></div></td>
                                <td><div class="skeleton-label skeleton-w-full"></div></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><div class="skeleton-label skeleton-w-full"></div></td>
                                <td><div class="skeleton-label skeleton-w-full"></div></td>
                                <td><div class="skeleton-label skeleton-w-full"></div></td>
                                <td><div class="skeleton-label skeleton-w-full"></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- <div class="col-md-2">
                                <h5 class="mb-0">Last 10 Lead Called</h5>
                                <div class="leads-card">

                                </div>
                            </div> -->
    <!-- <div class="col-md-3">
                            <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="m-0">Call Logs</h5>
                                    <div>
                                        <div style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 100%;display: flex;flex-wrap: nowrap;white-space: nowrap;align-items: center;"
                                            class="clog-daterange daterange form-control form-control-sm">
                                            <i class="fa fa-calendar"></i>&nbsp;
                                            <span></span>&nbsp;<i class="fa fa-caret-down"></i>
                                            <input type="hidden" name="startdate" />
                                            <input type="hidden" name="enddate" />
                                        </div>
                                    </div>

                                </div>
                                <div class="calllogs-cards">


                                </div>
                            </div> 
</div>
<?php if (true) { ?>
    <hr/>
    <div class="row">
        <div class="col-md-6">
            <div class="d-flex align-items-center justify-content-between mt-5">
                <h5 class="m-0">Status Wise</h5>
                <!-- <div>
                    <div style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 100%;display: flex;flex-wrap: nowrap;white-space: nowrap;align-items: center;"
                        class="status-daterange daterange form-control form-control-sm">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span>&nbsp;<i class="fa fa-caret-down"></i>
                        <input type="hidden" name="startdate" />
                        <input type="hidden" name="enddate" />
                    </div>
                </div> 

            </div>

            <div class="status status-cards">
                <div class="card mr-1">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-lg"></div>
                    </div>
                </div>
                <div class="card mr-1">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-lg"></div>
                    </div>
                </div>
                <div class="card mr-1">
                    <div class="card-body skeleton-body">
                        <div class="skeleton-label"></div>
                        <div class="skeleton-label skeleton-lg"></div>
                    </div>
                </div>
            </div>
            <hr/>
        </div>

        <?php if ($_SESSION["TypeId"] == 1 || ($_SESSION["TypeId"] == 2 && $_SESSION["Role"] == 2)) { ?>
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-between mt-5">
                    <h5 class="m-0">Source Wise</h5>
                    <!-- <div>
                        <div style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 100%;display: flex;flex-wrap: nowrap;white-space: nowrap;align-items: center;"
                            class="src-daterange daterange form-control form-control-sm">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span>&nbsp;<i class="fa fa-caret-down"></i>
                            <input type="hidden" name="startdate" />
                            <input type="hidden" name="enddate" />
                        </div>
                    </div> 

                </div>
                <div class="source status-cards">
                    <div class="card mr-1">
                        <div class="card-body skeleton-body">
                            <div class="skeleton-label"></div>
                            <div class="skeleton-label skeleton-lg"></div>
                        </div>
                    </div>
                    <div class="card mr-1">
                        <div class="card-body skeleton-body">
                            <div class="skeleton-label"></div>
                            <div class="skeleton-label skeleton-lg"></div>
                        </div>
                    </div>
                    <div class="card mr-1">
                        <div class="card-body skeleton-body">
                            <div class="skeleton-label"></div>
                            <div class="skeleton-label skeleton-lg"></div>
                        </div>
                    </div>
                </div>
                <hr/>
            </div>
        <?php } ?>
        
        <div class="col-md-6">
            <div class="d-flex align-items-center justify-content-between mt-5">
                <h5 class="m-0">Channel Partner</h5>
            </div>
            <!-- Table for Confirm Leads and CP Leads 
            <div class="table-responsive" style="margin-top:10px">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Confirm Channel Partner</th>
                            <th>CP Leads</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Placeholder rows for confirmed and CP leads 
                        <tr>
                            <td class="ccp status-card"></td>
                            <td class="ccpl status-card"></td>     
                        </tr>
                    
            
                    </tbody>
                </table>
            </div>
             <hr/>

             <div class="d-flex align-items-center justify-content-between mt-5">
                <h5 class="m-0">Latest Channel Partner List</h5>
            </div>
            <!-- Table for Confirm Leads and CP Leads 
            <div class="table-responsive" style="margin-top:10px">
                <table id="latestChannelPartnerListTable" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Leads</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Placeholder rows for confirmed and CP leads 
                        <tr>
                            <td></td>
                            <td ></td>
                            <td></td>
                            <td></td>
                            
                        </tr>
                    
                        <!-- End placeholder rows -
                    </tbody>
                </table>
            </div>
             <hr/>
        </div>

       
    </div>
<?php } ?> -->