
<link rel="stylesheet" href="<?php echo $baseurl ?>assets/css/lead.css">
<div class="row">
    <div class="col-md-6">
        <div class="d-flex align-items-center justify-content-evenly">
            <h5 class="m-0 me-2">Today's Report</h5>
            <div>
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
            <div class="card w-100">
                <div class="card-body">
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
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>



    </div>
    <div class="col-md-6">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="m-0">Activity Report</h5>
            <div class="d-flex">
                <div class="mr-1">
                    <select class="form-control form-control-sm" name="activityusers" style="width:150px">
                        <?php include $_SERVER['DOCUMENT_ROOT'] . $baseurl . "layouts/partials/dropdowns/users.php" ?>
                    </select>
                </div>
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
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <div class="mt-3 mb-3">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="m-0">Site Visit Plan</h5>
                <div class="d-flex">
                    <div class="mr-1">
                    <select class="form-control form-control-sm" name="visitplanusers" style="width:150px">
                        <?php include $_SERVER['DOCUMENT_ROOT'] . $baseurl . "layouts/partials/dropdowns/users.php" ?>
                    </select>
                    </div>
                </div>
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
    <div class="col-md-12">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="m-0">Lead By Source Report</h5>
            <div>
                <div style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 100%;display: flex;flex-wrap: nowrap;white-space: nowrap;align-items: center;"
                    class="sourcelead-daterange daterange form-control form-control-sm">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span>&nbsp;<i class="fa fa-caret-down"></i>
                    <input type="hidden" name="startdate" />
                    <input type="hidden" name="enddate" />
                </div>
            </div>

        </div>

        <div class="sourcelead-overview status-cards">
            <div class="card w-100">
                <div class="card-body">
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
<!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable  modal-xl">
        <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Leads</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div id="leadModal">

                </div>

        </div>
    </div>
</div>
</div>
