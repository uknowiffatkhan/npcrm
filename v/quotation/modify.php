<?php

include('../../layouts/head.php');

include('../../layouts/auth.php');

include('../../model/leadmodel.php');
include('../../model/quotemodel.php');

$uid = $_SESSION["UId"];
if (isset($_GET['lid'])) {
    $lid = decrypt($_GET['lid']);
    echo $lid;
    $det = getLeadById($lid, $uid);
    $det = $det->fetch_assoc();
} else if (isset($_GET['qid'])) {
    $qid = decrypt($_GET['qid']);
    $det = getQuoteById($qid, $uid);
    $det = $det->fetch_assoc();

    $qp = getQuotePlansById($qid, $uid);
}


?>
<style>
    label {
        font-size: 0.7rem;
        font-weight: 600
    }

    .valuesblk input {
        font-size: 1rem !important;
        font-weight: 600 !important;
    }

    .valuesblk label {
        font-size: 1rem;
    }

    .valuesblk table {
        width: 100%;
        border: 1px solid #a9a9a9;
        padding: 1rem;
        border-collapse: separate;
    }

    .valuesblk table td:last-child {
        width: 30%;
    }
</style>
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
                $pagetitle = "Lead Form";



                include('../../layouts/header.php')
                    ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <form id="quotationform">
                            <div class="">

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <h5>Client Details</h5>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label>Full Name <span class="text-danger">*</span></label>
                                                            <div>
                                                                <input type="text" name="fullname"
                                                                    value="<?php echo isset($det) ? $det["Ld_Name"] : "" ?>"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <label>Mobile No. <span class="text-danger">*</span></label>
                                                            <div>
                                                                <input type="text" name="mobno"
                                                                    value="<?php echo isset($det) ? $det["Ld_Mobile"] : "" ?>"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-2">
                                                <div class="mb-2">
                                                    <label>Alt Mobile No.</label>
                                                    <div>
                                                        <input type="text" name="altmobno"
                                                            value="<?php echo isset($det) ? (isset($det["Ld_AltMobile"]) ? $det["Ld_AltMobile"] : "") : "" ?>"
                                                            class="form-control form-control-sm" />
                                                    </div>
                                                </div>
                                            </div> -->




                                                </div>
                                                <hr>
                                                <h5>Project Details</h5>
                                                <div class="row mt-3">
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <label>Project <span class="text-danger">*</span></label>
                                                            <div>
                                                                <select name="project"
                                                                    class="form-control form-control-sm" <?php echo isset($det) ? "data-selected=" . $det["Qt_PId"] . "" : "" ?>>
                                                                    <?php include("../../layouts/partials/dropdowns/project.php") ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Configuration <span
                                                                    class="text-danger">*</span></label>
                                                            <div>
                                                                <input type="text" name="config"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_Config"]) ? $det["Qpd_Config"] : "") : "" ?>"
                                                                    placeholder="ex. 1 BHK"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <label>Phase/Block
                                                                <!-- <span class="text-danger">*</span> -->
                                                            </label>
                                                            <div>
                                                                <input type="text" name="phase"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_Phase"]) ? $det["Qpd_Phase"] : "") : "" ?>"
                                                                    placeholder="ex. Phase 1"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Wing <span class="text-danger">*</span></label>
                                                            <div>
                                                                <input type="text" name="wing"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_Wing"]) ? $det["Qpd_Wing"] : "") : "" ?>"
                                                                    placeholder="ex. A Wing"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <label>Floor <span class="text-danger">*</span></label>
                                                            <div>
                                                                <input type="text" name="floor"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_Floor"]) ? $det["Qpd_Floor"] : "") : "" ?>"
                                                                    placeholder="ex. 1st"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <label>Room / Shop No. <span class="text-danger">*</span></label>
                                                            <div>
                                                                <input type="number" min="0" min="0" name="roomno"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_Roomno"]) ? $det["Qpd_Roomno"] : "") : "" ?>"
                                                                    placeholder="ex. 102"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <label>Saleable Area sq. ft. <span
                                                                    class="text-danger">*</span></label>
                                                            <div>
                                                                <input type="number" min="0" name="saleable"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_Saleable"]) ? $det["Qpd_Saleable"] : "") : "" ?>"
                                                                    placeholder="ex. 640"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <label>Carpet Area sq. ft. <span
                                                                    class="text-danger">*</span></label>
                                                            <div>
                                                                <input type="number" min="0" name="carpet"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_Carpet"]) ? $det["Qpd_Carpet"] : "") : "" ?>"
                                                                    placeholder="ex. 320"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3 ">
                                                    <!-- <div class="col-md-2">
                                                <div class="mb-2">
                                                    <label>Agreement Value <span class="text-danger">*</span></label>
                                                    <div>
                                                        <input type="number" min="0" name="agreement"
                                                            value="<?php echo isset($det) ? (isset($det["Qpd_Agreevalue"]) ? $det["Qpd_Agreevalue"] : "") : "" ?>"
                                                            placeholder="ex. 1100000"
                                                            class="form-control form-control-sm" />
                                                    </div>
                                                </div>
                                            </div> -->
                                                    <!-- <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Development <span
                                                                    class="text-danger">*</span></label>
                                                            <div>
                                                                <input type="number" min="0" name="development"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_Development"]) ? $det["Qpd_Development"] : "") : "" ?>"
                                                                    placeholder="ex. 40000"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Paper Work / Registration</label>
                                                            <div>
                                                                <input type="number" min="0" name="development"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_Development"]) ? $det["Qpd_Development"] : "") : "" ?>"
                                                                    placeholder="ex. 40000"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Club Membership</label>
                                                            <div>
                                                                <input type="number" min="0" name="development"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_Development"]) ? $det["Qpd_Development"] : "") : "" ?>"
                                                                    placeholder="ex. 40000"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Parking Charges</label>
                                                            <div>
                                                                <input type="number" min="0" name="development"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_Development"]) ? $det["Qpd_Development"] : "") : "" ?>"
                                                                    placeholder="ex. 40000"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Society / Other Charges</label>
                                                            <div>
                                                                <input type="number" min="0" name="development"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_Development"]) ? $det["Qpd_Development"] : "") : "" ?>"
                                                                    placeholder="ex. 40000"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Legal Charges <span
                                                                    class="text-danger">*</span></label>
                                                            <div>
                                                                <input type="number" min="0" name="development"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_Development"]) ? $det["Qpd_Development"] : "") : "" ?>"
                                                                    placeholder="ex. 40000"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Stamp Duty <span class="text-danger">*</span></label>
                                                            <div>
                                                                <input type="number" min="0" name="development"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_Development"]) ? $det["Qpd_Development"] : "") : "" ?>"
                                                                    placeholder="ex. 40000"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>GST / Other tax <span
                                                                    class="text-danger">*</span></label>
                                                            <div>
                                                                <input type="number" min="0" name="govtcharge"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_GovtTax"]) ? $det["Qpd_GovtTax"] : "") : "" ?>"
                                                                    placeholder="ex. 40000"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <!-- <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label>Total Value <span
                                                                    class="text-danger">*</span></label>
                                                            <div>
                                                                <input type="number" min="0" name="totalvalue"
                                                                    value="<?php echo isset($det) ? (isset($det["Qpd_Totalvalue"]) ? $det["Qpd_Totalvalue"] : "") : "" ?>"
                                                                    placeholder="ex. 1180000"
                                                                    class="form-control form-control-sm" readonly />
                                                            </div>
                                                        </div>
                                                    </div> -->

                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label>Est. Booking Date <span
                                                                    class="text-danger">*</span></label>
                                                            <div>
                                                                <input type="datetime-local" name="estbooking"
                                                                    value="<?php echo isset($det) ? (isset($det["Qt_BookEstDate"]) ? date('Y-m-d H:i:s', strtotime($det["Qt_BookEstDate"])) : "") : "" ?>"
                                                                    class="form-control form-control-sm" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-5 valuesblk">
                                                <table class="">
                                                    <tr>
                                                        <td>
                                                            <label>Agreement Value <span
                                                                    class="text-danger">*</span></label>
                                                        </td>
                                                        <td><input type="number" min="0" name="agreement"
                                                                value="<?php echo isset($det) ? (isset($det["Qpd_Agreevalue"]) ? $det["Qpd_Agreevalue"] : "") : "" ?>"
                                                                placeholder="ex. 1100000"
                                                                class="form-control form-control-sm" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label>Development <span
                                                                    class="text-danger">*</span></label>
                                                        </td>
                                                        <td><input type="number" min="0" name="development"
                                                                value="<?php echo isset($det) ? (isset($det["Qpd_Development"]) ? $det["Qpd_Development"] : "") : "" ?>"
                                                                placeholder="ex. 40000"
                                                                class="form-control form-control-sm" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label>Paper Work / Registration</label>
                                                        </td>
                                                        <td><input type="number" min="0" name="registration"
                                                                value="<?php echo isset($det) ? (isset($det["Qpd_Registration"]) ? $det["Qpd_Registration"] : "") : "" ?>"
                                                                placeholder="ex. 40000"
                                                                class="form-control form-control-sm" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label>Club Membership</label>
                                                        </td>
                                                        <td><input type="number" min="0" name="clubmembersip"
                                                                value="<?php echo isset($det) ? (isset($det["Qpd_ClubMembersip"]) ? $det["Qpd_ClubMembersip"] : "") : "" ?>"
                                                                placeholder="ex. 40000"
                                                                class="form-control form-control-sm" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label>Parking Charges</label>
                                                        </td>
                                                        <td><input type="number" min="0" name="parking"
                                                                value="<?php echo isset($det) ? (isset($det["Qpd_ParkingCharge"]) ? $det["Qpd_ParkingCharge"] : "") : "" ?>"
                                                                placeholder="ex. 40000"
                                                                class="form-control form-control-sm" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label>Society / Other Charges</label>
                                                        </td>
                                                        <td><input type="number" min="0" name="society"
                                                                value="<?php echo isset($det) ? (isset($det["Qpd_SocietyOtherCharge"]) ? $det["Qpd_SocietyOtherCharge"] : "") : "" ?>"
                                                                placeholder="ex. 40000"
                                                                class="form-control form-control-sm" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label>Legal Charges</label>
                                                        </td>
                                                        <td><input type="number" min="0" name="legal"
                                                                value="<?php echo isset($det) ? (isset($det["Qpd_LegalCharge"]) ? $det["Qpd_LegalCharge"] : "") : "" ?>"
                                                                placeholder="ex. 40000"
                                                                class="form-control form-control-sm" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label>Stamp Duty</label>
                                                        </td>
                                                        <td><input type="number" min="0" name="stampduty"
                                                                value="<?php echo isset($det) ? (isset($det["Qpd_Stampduty"]) ? $det["Qpd_Stampduty"] : "") : "" ?>"
                                                                placeholder="ex. 40000"
                                                                class="form-control form-control-sm" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label>GST / Other tax <span
                                                                    class="text-danger">*</span></label>
                                                        </td>
                                                        <td><input type="number" min="0" name="govtcharge"
                                                                value="<?php echo isset($det) ? (isset($det["Qpd_GovtTax"]) ? $det["Qpd_GovtTax"] : "") : "" ?>"
                                                                placeholder="ex. 40000"
                                                                class="form-control form-control-sm" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label>Total Value <span
                                                                    class="text-danger">*</span></label>
                                                        </td>
                                                        <td><input type="number" min="0" name="totalvalue"
                                                                value="<?php echo isset($det) ? (isset($det["Qpd_Totalvalue"]) ? $det["Qpd_Totalvalue"] : "") : "" ?>"
                                                                placeholder="ex. 1180000"
                                                                class="form-control form-control-sm ttl" readonly />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                    </div>

                                </div>



                                <div class="d-none" id="clonerow">
                                    <table>
                                        <tr>
                                            <td>
                                                <div>
                                                    <input type="text" data-name="part[]"
                                                        class="form-control form-control-sm part"
                                                        placeholder="ex. Booking Amount" />
                                                </div>
                                            </td>
                                            <td>
                                                <div><input type="number" min="0" data-name="amount[]"
                                                        class="form-control form-control-sm amount"
                                                        placeholder="ex. 50000" />
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <select class="form-control form-control-sm type"
                                                        data-name="type[]">
                                                        <option value="Once">Once</option>
                                                        <option value="Monthly">Monthly</option>
                                                        <option value="Quaterly">Quaterly</option>
                                                        <option value="Yearly">Yearly</option>
                                                        <option value="Quantity">Quantity</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="number" min="0"
                                                        class="form-control form-control-sm dur d-none"
                                                        data-name="dur[]" placeholder="ex. 36" />
                                                    <span class="nodur">-</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="hidden" data-name="totalramount[]" />
                                                    <span class="total"></span>
                                                </div>
                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger clearrow"><i
                                                        class="bx bx-trash bx-xs"></i></button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <table class="table" id="quotation">
                                            <thead>
                                                <tr>

                                                    <th>Particular</th>
                                                    <th>Amount</th>
                                                    <th>Type</th>
                                                    <th>Duration</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($qp) && $qp->num_rows > 0) {
                                                    while ($r = $qp->fetch_assoc()) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    <input type="text" name="part[]"
                                                                        value="<?php echo $r["Ppp_Particular"] ?>"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="ex. Booking Amount" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div><input type="text" name="amount[]"
                                                                        value="<?php echo $r["Ppp_Amount"] ?>"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="ex. 50000" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    <select class="form-control form-control-sm" name="type[]"
                                                                        data-selected="<?php echo $r["Ppp_Type"] ?>">
                                                                        <option value="Once">Once</option>
                                                                        <option value="Monthly">Monthly</option>
                                                                        <option value="Quaterly">Quaterly</option>
                                                                        <option value="Yearly">Yearly</option>
                                                                        <option value="Quantity">Quantity</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div><input type="text"
                                                                        class="form-control form-control-sm dur <?php echo $r["Ppp_Duration"] != "" ? "" : "d-none" ?> "
                                                                        value="<?php echo $r["Ppp_Duration"] ?>" name="dur[]"
                                                                        placeholder="ex. 36" />
                                                                    <span
                                                                        class="nodur <?php echo $r["Ppp_Duration"] != "" ? "d-none" : "" ?>">-</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    <input type="hidden" name="totalramount[]"
                                                                        value="<?php echo $r["Ppp_TotalAmount"] ?>" />
                                                                    <span class="total"></span>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-danger clearrow"><i
                                                                        class="bx bx-trash bx-xs"></i></button>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><b><span class="totalamount"></span></b></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>

                                        </table>
                                        <div class="mt-3">
                                            <button type="button" id="addrow2" value="true"
                                                class="btn btn-sm btn-info">Add</button>

                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-end">
                                            <div>
                                                <?php if (isset($det)) {
                                                    ?>
                                                    <input type="hidden" name="lid"
                                                        value="<?php echo (isset($det["Ld_Id"]) ? $det["Ld_Id"] : $det["Qt_LdId"]) ?>" />
                                                    <?php
                                                }
                                                if (isset($det) && isset($det["Qt_Id"])) {
                                                    ?>
                                                    <input type="hidden" name="qid" value="<?php echo $det["Qt_Id"] ?>" />
                                                    <?php
                                                } ?>
                                                <input type="hidden" name="mode"
                                                    value="<?php echo isset($qid) ? "update" : "insert" ?>" />
                                                <button type="button"
                                                    class="btn btn-transparent text-danger">Cancel</button>
                                                <button type="submit" value="true" name="submit" class="btn btn-info"
                                                    disabled>Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>


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
    <script src="<?php echo $baseurl ?>assets/js/bind/quotation/modify.js?v=<?php echo $ver ?>"></script>

</body>

</html>