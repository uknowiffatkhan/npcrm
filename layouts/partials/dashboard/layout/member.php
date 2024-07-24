<div class="row">
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
        <hr/>
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



    </div>
    <div class="col-12 col-md-6">
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
                            </div> -->
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
        <?php
    } ?>
        <div class="col-md-6">
            <div class="d-flex align-items-center justify-content-between mt-5">
                <h5 class="m-0">Interest Wise</h5>
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
            <div class="interest status-cards">
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
    </div>
<?php
} ?>

