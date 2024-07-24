<style>
    body{
        background: #dde1e78f;
    }
    .highlighted-button {
        position: fixed;
        bottom: 10px;
        right: 10px;
        padding: 10px;
        background-color: #ff5722;
        color: #fff; /* Set text color to white */
        border: none;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease;
        animation: bounce 2s infinite;
    }

    .highlighted-button:hover {
        background-color: #d84315;
        animation: none;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-10px);
        }

        60% {
            transform: translateY(-5px);
        }
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="<?php echo $baseurl ?>assets/js/bind/lead/commonProfileStatus.js"></script>
<div class="row">
    <div class="col-12 col-md-7">
        <div class="col-12">
        <div class="p-2 box-shadow box2">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="m-1">Today's Scope of Work</h5>
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

                <div class="todays-scope status-cards   ">
                    <div class="card mr-1 ">
                        <div class="card-body skeleton-body ">
                            <div class="skeleton-label"></div>
                            <div class="skeleton-label skeleton-lg"></div>
                        </div>
                    </div>
                    <div class="card mr-1  ">
                        <div class="card-body skeleton-body">
                            <div class="skeleton-label"></div>
                            <div class="skeleton-label skeleton-lg"></div>
                        </div>
                    </div>
                    <div class="card mr-1 ">
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
        <hr>
        </div>
        <div>
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="m-0">Site Visit Plan</h5>
            </div>

            <div class="site-visit-plan status-cards">
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
        <div class="overview">
        <div class="card mr-1">
                        <div class="card-body skeleton-body">
                            <div class="skeleton-label"></div>
                            <div class="skeleton-label skeleton-lg"></div>
                        </div>
                    </div>
        </div>

        <div class="col-12">
        <div class="row">
            <div class="col-md-6 mt-2">
                <div class="d-flex align-items-center justify-content-between" >
                    <h5 class="m-2 mb-0">Status Wise</h5>
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
                <div class="status status-cards mt-2" >
                <div class="card w-100"  style="height: 300px;">
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
            <div class="col-md-6  mt-2">
                <div class="d-flex align-items-center justify-content-between ">
                <h5 class="m-2 mb-0">Interest Wise</h5>

                    <!-- <div>
                        <div style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 100%;display: flex;flex-wrap: nowrap;white-space: nowrap;align-items: center;"
                            class="int-daterange daterange form-control form-control-sm">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span>&nbsp;<i class="fa fa-caret-down"></i>
                            <input type="hidden" name="startdate" />
                            <input type="hidden" name="enddate" />
                        </div>
                    </div> -->

                </div>

                <div class="interest status-cards mt-2">
                    <div class="card  w-100">
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
                <!-- <hr/> -->
            </div>
        </div>
        </div>
    </div>
<div class="col-12 col-md-5">
        <div class="d-flex flex-wrap align-items-center justify-content-center ">
            
                <div class="col-12 col-md-4 text-center ">
                <h5 class="pt-1">Activity Report</h5>
                </div>
                    <?php if ($_SESSION["Role"] == 2) {
                        ?>
                        <div  class="col-6 col-md-4">
                            <select class="form-control form-control-sm box " name="activityusers" style="width:150px">
                                <?php include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "layouts/partials/dropdowns/users.php" ?>
                            </select>
                        </div>
                        <?php
                    } ?>

                    <div style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width:fit-content;display: flex;flex-wrap: nowrap;white-space: nowrap;align-items: center;"
                    class="col-6 col-md-4 activityreport-daterange daterange form-control form-control-sm box activityreport-daterange daterange form-control form-control-sm box">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span>&nbsp;<i class="fa fa-caret-down"></i>
                        <input type="hidden" name="startdate" />
                        <input type="hidden" name="enddate" />
                    </div>

        </div>
        <div class="activityreport status-cards ">
            <div class="d-flex w-100  align-items-center">
                <div class="card" style="width:100% ;height:300px;" >
                    <div class="card-body skeleton-body" >
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

<div class="col-md-6"></div>


</div>

