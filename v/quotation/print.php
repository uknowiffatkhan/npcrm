<?php
$baseurl="/npcrm/";   

include('../../layouts/auth.php');
include('../../utils/helper.php');
include('../../model/leadmodel.php');
include('../../model/quotemodel.php');

$uid = $_SESSION["UId"];

if (isset($_GET["qid"])) {
    $qid = $_GET['qid'];
    $det = getQuoteById($qid, $uid);
    $det = $det->fetch_assoc();

    $qp = getQuotePlansById($qid, $uid);
}




?>

<head>
    <style>
        table {
            border-collapse: collapse
        }

        table td {
            border: 1px solid #ddd;
            font-size: 0.8rem;
            font-weight: 600;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        label {
            font-size: 0.8rem;
        }

        p {
            margin: 0;
        }
    </style>
</head>




<div style="width:8.3in;font-family:arial;padding-top:2rem;">
    <div style="width:7in;margin:auto;">


        <div style="display:flex;flex-wrap:nowrap;align-items:center;justify-content:space-between">
            <div>
                <p style="font-size:0.8rem;font-weight:600;">Neral Property</p>
                <p style="font-size:0.8rem;">Shop No. 2,3 & 4, <br>Sunrise Apartment, Mamdapur,<br> Neral - 410 101</p>

            </div>

            <div style="text-align:right">
                <img src="../../assets/img/logo-final-246.png" />

            </div>
        </div>
        <hr>
        <div style="display:flex;flex-wrap:nowrap;align-items:center;justify-content:space-between">
            <div>
                <!-- <small>Revised</small> -->
                <h1 style="font-weight:500;margin:0;">QUOTATION</h1>

            </div>
            <div style="text-align:right">
                <p style="margin:0;font-size:1.8rem;font-weight:500">
                    <?php echo $det["Qt_Code"] ?>
                </p>
                <p style="margin:0;font-size:0.9rem;display:flex;flex-wrap:nowrap"><span
                        style="font-size:0.7rem">&#128197;:</span>
                    <?php echo date('d-m-Y', strtotime($det["Qt_Date"])) ?>
                </p>
            </div>


        </div>
        <div style="display:flex;flex-wrap:wrap;margin:2rem 0 1rem;">

            <div style="padding:0 1.5rem 0 0;margin-top:0.7rem;">
                <label>Name</label>
                <p style="font-weight:600;font-size: 0.9rem;text-transform: uppercase;">
                    <?php echo $det["Qt_Name"] ?>
                </p>
            </div>
            <div style="padding:0 1.5rem 0 0;margin-top:0.7rem;">
                <label>Mobile No.</label>
                <p style="font-weight:600;font-size: 0.9rem;text-transform: uppercase;">
                    <?php echo $det["Qt_Mobile"] ?>
                </p>
            </div>
            <div style="padding:0 1rem;"></div>
            <div style="padding:0 1.5rem 0 0;margin-top:0.7rem;">
                <label>Project Name</label>
                <p style="font-weight:600;font-size: 0.9rem;text-transform: uppercase;">
                    <?php echo $det["Pr_Name"] ?>
                </p>
            </div>
        </div>
        <div style="display:flex;flex-wrap:wrap;margin:1rem 0;">
            <div style="padding:0 1.5rem 0 0;margin-top:0.7rem;">
                <label>Configuration</label>
                <p style="font-weight:600;font-size: 0.9rem;text-transform: uppercase;">
                    <?php echo $det["Qpd_Config"] ?>
                </p>
            </div>
            <div style="padding:0 1.5rem 0 0;margin-top:0.7rem;">
                <label>Room / Shop Details</label>
                <p style="font-weight:600;font-size: 0.9rem;text-transform: uppercase;">
                    <?php echo $det["Qpd_Phase"];
                    echo ($det["Qpd_Phase"] != "" ? " - " : ""); ?>
                    <?php echo $det["Qpd_Wing"];
                    echo ($det["Qpd_Wing"] != "" ? " - " : ""); ?>
                    <?php echo $det["Qpd_Floor"] . " Floor";
                    echo ($det["Qpd_Floor"] != "" ? " - " : ""); ?>
                    <?php echo $det["Qpd_Roomno"] ?>
                </p>
            </div>
            <div style="padding:0 1.5rem 0 0;margin-top:0.7rem;">
                <label>Saleable Area</label>
                <p style="font-weight:600;font-size: 0.9rem;text-transform: uppercase;">
                    <?php echo $det["Qpd_Saleable"] ?> sq. ft.
                </p>
            </div>
            <div style="padding:0 1.5rem 0 0;margin-top:0.7rem;">
                <label>Carpet Area</label>
                <p style="font-weight:600;font-size: 0.9rem;text-transform: uppercase;">
                    <?php echo $det["Qpd_Carpet"] ?> sq. ft.
                </p>
            </div>
            <!-- <div style="padding:0 1.5rem 0 0;margin-top:0.7rem">
            <label>Rate per sq. ft.</label>
            <p style="font-weight:600;">₹ 1,200</p>
        </div> -->
        </div>
        <!-- <div style="display:flex;flex-wrap:wrap;margin:1.5rem 0 1rem;">
        <div style="padding:0 1.3rem 0 0;">
            <label>Agreement Value</label>
            <p style="font-weight:500;font-size:1.3rem">₹ 10,00,000</p>
        </div>
        <div style="padding:0 1.3rem 0 0;">
            <label>Development Charges</label>
            <p style="font-weight:500;font-size:1.3rem">₹ 80,000</p>
        </div>
        <div style="padding:0 1.3rem 0 0;">
            <label>Govt. / Paper Work</label>
            <p style="font-weight:500;font-size:1.3rem">₹ 80,000</p>
        </div>
        <div style="padding:0 1.3rem 0 0;">
            <label>Total Amount</label>
            <p style="font-weight:500;font-size:1.3rem">₹ 11,60,000</p>
        </div>
    </div> -->
        <hr>
        <!-- <h1 style="margin:0;text-align:center;background: #1d6395;color: #fff;">Sukoon Residency</h1>
    <h3 style="margin:0;background: #e1ae20;font-size: 1rem;padding: 0.3rem;text-align: center;">Client Details</h3>
        <table style="width:100%;background:#eee;border-collapse: collapse;">
        <tr>
            <td style="padding:0.2rem 1rem;">Client Name</td>
            <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">Kamaluddin Khan</td>
        </tr>
        <tr>
            <td style="padding:0.2rem 1rem;">Client Mobile</td>
            <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">+91 897 546 2134</td>
        </tr>
        </table>
    <h3 style="margin:1rem 0 0 0;background: #b76109;color: #fff;font-size: 1rem;padding: 0.3rem;text-align: center;">Project Details</h3>
    <table style="width:100%;background:#eee;border-collapse: collapse;">
        
        <tr>
            <td style="padding:0.2rem 1rem;">Configuration</td>
            <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">2BHK</td>
        </tr>
        <tr>
            <td style="padding:0.2rem 1rem;">Wing</td>
            <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">A Wing</td>
        </tr>
        <tr>
            <td style="padding:0.2rem 1rem;">Floor</td>
            <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">1st Floor</td>
        </tr>
        <tr>
            <td style="padding:0.2rem 1rem;">Room No.</td>
            <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">101</td>
        </tr>
        <tr>
            <td style="padding:0.2rem 1rem;">Saleable Area sq. ft.</td>
            <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">640 sq. ft.</td>
        </tr>
        <tr>
            <td style="padding:0.2rem 1rem;">Carpet Area sq. ft.</td>
            <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">320 sq. ft.</td>
        </tr>

    </table>-->

        <h3
            style="margin:1rem 0 0 0;background: #206789;color: #fff;font-size: 1rem;padding: 0.3rem;text-align: center;">
            Project Amount Details</h3>
        <table style="width:100%;background:#eee">
            <?php if ($det["Qpd_Agreevalue"] != "" && $det["Qpd_Agreevalue"] != "0") {
                ?>
                <tr>
                    <td style="padding:0.2rem 1rem;">Agreement Value</td>
                    <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">₹
                        <?php echo format_curr($det["Qpd_Agreevalue"]) ?>
                    </td>
                </tr>
                <?php
            } ?>
            <?php if ($det["Qpd_Development"] != "" && $det["Qpd_Development"] != "0") {
                ?>
                <tr>
                    <td style="padding:0.2rem 1rem;">Development Charges</td>
                    <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">₹
                        <?php echo format_curr($det["Qpd_Development"]) ?>
                    </td>
                </tr>
                <?php
            } ?>
            <?php if ($det["Qpd_Registration"] != "" && $det["Qpd_Registration"] != "0") {
                ?>
                <tr>
                    <td style="padding:0.2rem 1rem;">Paper Work / Registration</td>
                    <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">₹
                        <?php echo format_curr($det["Qpd_Registration"]) ?>
                    </td>
                </tr>
                <?php
            } ?>
            <?php if ($det["Qpd_ClubMembersip"] != "" && $det["Qpd_ClubMembersip"] != "0") {
                ?>
                <tr>
                    <td style="padding:0.2rem 1rem;">Club Membership</td>
                    <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">₹
                        <?php echo format_curr($det["Qpd_ClubMembersip"]) ?>
                    </td>
                </tr>
                <?php
            } ?>
            <?php if ($det["Qpd_ParkingCharge"] != "" && $det["Qpd_ParkingCharge"] != "0") {
                ?>
                <tr>
                    <td style="padding:0.2rem 1rem;">Parking Charges</td>
                    <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">₹
                        <?php echo format_curr($det["Qpd_ParkingCharge"]) ?>
                    </td>
                </tr>
                <?php
            } ?>
            <?php if ($det["Qpd_SocietyOtherCharge"] != "" && $det["Qpd_SocietyOtherCharge"] != "0") {
                ?>
                <tr>
                    <td style="padding:0.2rem 1rem;">Society / Other Charges</td>
                    <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">₹
                        <?php echo format_curr($det["Qpd_SocietyOtherCharge"]) ?>
                    </td>
                </tr>
                <?php
            } ?>
            <?php if ($det["Qpd_LegalCharge"] != "" && $det["Qpd_LegalCharge"] != "0") {
                ?>
                <tr>
                    <td style="padding:0.2rem 1rem;">Legal Charges</td>
                    <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">₹
                        <?php echo format_curr($det["Qpd_LegalCharge"]) ?>
                    </td>
                </tr>
                <?php
            } ?>
            <?php if ($det["Qpd_Stampduty"] != "" && $det["Qpd_Stampduty"] != "0") {
                ?>
                <tr>
                    <td style="padding:0.2rem 1rem;">Stamp Duty</td>
                    <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">₹
                        <?php echo format_curr($det["Qpd_Stampduty"]) ?>
                    </td>
                </tr>
                <?php
            } ?>
            <?php if ($det["Qpd_GovtTax"] != "" && $det["Qpd_GovtTax"] != "0") {
                ?>
                <tr>
                    <td style="padding:0.2rem 1rem;">GST / Other Taxes</td>
                    <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">₹
                        <?php echo format_curr($det["Qpd_GovtTax"]) ?>
                    </td>
                </tr>
                <?php
            } ?>
            <?php if ($det["Qpd_Totalvalue"] != "" && $det["Qpd_Totalvalue"] != "0") {
                ?>
                <tr>
                    <td style="padding:0.2rem 1rem;font-size:1.1rem;">Total Amount</td>
                    <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;font-size:1.1rem;">₹
                        <?php echo format_curr($det["Qpd_Totalvalue"]) ?>
                    </td>
                </tr>
                <?php
            } ?>










        </table>

        <h3
            style="margin:1rem 0 0 0;background: #1e600e;color: #fff;font-size: 1rem;padding: 0.3rem;text-align: center;">
            Payment Scheme</h3>
        <table style="width:100%;background:#eee">
            <tbody>
                <?php
                if (isset($qp) && $qp->num_rows > 0) {
                    while ($r = $qp->fetch_assoc()) {
                        ?>
                        <tr>
                            <td style="padding:0.2rem 1rem;">
                                <?php echo $r["Ppp_Particular"] ?>
                                <?php echo $r["Ppp_Type"] != "Once" ? " (" . $r["Ppp_Type"] . ": " . $r["Ppp_Amount"] . "x" . $r["Ppp_Duration"] . ")" : "" ?>
                            </td>
                            <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">₹
                                <?php echo format_curr($r["Ppp_TotalAmount"]) ?>
                            </td>
                        </tr>
                        <!-- <tr>
                        <td style="padding:0.2rem 1rem;">Down Payment</td>
                        <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">₹ 50,000</td>
                    </tr>
                    <tr>
                        <td style="padding:0.2rem 1rem;">Monthly EMI (₹ 12,000 x 60)</td>
                        <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">₹ 50,000</td>
                    </tr>
                    <tr>
                        <td style="padding:0.2rem 1rem;">Possession</td>
                        <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;">₹ 50,000</td>
                    </tr> -->
                        <?php
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr style="color: #0e611c;font-weight: 700;">
                    <td style="padding:0.2rem 1rem;font-size:1.1rem;">Total Amount</td>
                    <td style="text-align:right;font-weight:bold;padding:0.2rem 1rem;font-size:1.1rem;">₹
                        <?php echo format_curr($det["Qpd_Totalvalue"]) ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <hr>
        <div>
            <p style="font-size:0.8rem;font-weight:600;"><b>Note:</b></p>
            <p style="font-size:0.7rem;font-weight:600;">This document does not bind the parties as this is not
                considered
                as a contract. This only presents the best price offered by the company as a response to the inquiry of
                the
                client on <?php echo date('M, d Y', strtotime($det["Qt_Date"])) ?>. Further details will be provided should the client ask for additional
                information.
                We assure prompt response to your future orders and inquiries.</p>
        </div>
        <div style="margin:1rem 0;">
            <ul style="padding:0 1.1rem;font-size:0.6rem;font-weight:600;">
                <li>This quotation is valid for 1 day.</li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <div style="display:flex;align-items:center;justify-content:space-between;margin:1.5rem 0 1rem;">
                <div>
                    <p style="font-size:0.8rem;font-weight:600">Salesman:</p>
                    <p style="font-size:0.8rem;font-weight:500">Name: <span style="font-weight:600"><?php echo $det["U_FullName"] ?></span></p>
                    <p style="font-size:0.8rem;font-weight:500">Mobile No.: <span style="font-weight:600"><?php echo $det["U_Mobile"] ?></span></p>
                </div>
                <div>
                    <hr>
                    <p style="font-size:0.9rem;font-weight:600">Sign & Stamp</p>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    window.print();
</script>