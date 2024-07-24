<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../../model/leadmodel.php");
$uid = $_SESSION["UId"];

$search="";
if(isset($_POST['search'])){
    $search = $_POST['search'];
}

$sl = getSiteVisitPlanLead($uid,$search);


?>

<?php

if ($sl->num_rows > 0) {
    while ($r = $sl->fetch_assoc()) {
        $sales = getcurrentSalesAssigned($r['Ld_Id']);
        $sales = $sales->fetch_assoc();
        ?>
        <tr class="<?php echo isset($sales) ? 'table-success' : ''; ?>">

                           <td class="w-30">
                              <h6 class="text-sm mb-0"><?= $r['Ld_Name']?></h6>
                           </td>
                           <td>
                              <h6 class="text-sm mb-0"><?= $r['Ld_Mobile']?></h6>
                           </td>
                           <td>
                              <h6 class="text-sm mb-0"><?= $r['Cl_ActionDate']?></h6>
                           </td>
                           <td class="align-middle text-sm">
                              <h6 class="text-sm mb-0"><?= $r['assignedto']?></h6>
                           </td>
                           <td class="align-middle text-sm  py-3 ">
                            <?php if(empty($r['Ld_RNo'])) : ?>
                                <a target="_blank" href="<?php echo $baseurl ?>v/lead/modify.php?lid=<?php echo $r["Ld_Id"] ? urlencode(encrypt($r["Ld_Id"])) : "" ?>" class="btn btn-sm btn-primary"><b>Confirm</b></a>
                                <?php endif;?>
                            </p>
                           </td>
                        </tr>
        <?php
    }

} else {
    ?>
    <tr>
        <td class="text-center fw-bold" colspan="5">
        No Visiting Found
        </td>
</tr>
    <?php
}
?>