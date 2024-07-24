<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dropdownmodel.php";


$ls = getLeadStatus();
$sc = getSource();
$intin = getRoomType();
$lb = getLabels();

?>


<div class="filter-blk p-3">
    <h5><i class="fas fa-filter"></i> Filter</h5>
    <div class="accordion mt-3" id="accordionWithIcon">

    <?php if ($_SESSION["TypeId"] == "1" && $_SESSION["Role"] == "3") { ?>
        <div class="card accordion-item">
            <h2 class="accordion-header d-flex align-items-center">
                <button type="button" class="accordion-button" data-bs-toggle="collapse"
                    data-bs-target="#accordionWithIcon-1" aria-expanded="true">
                    Lead Status
                </button>
            </h2>

            <div id="accordionWithIcon-1" class="accordion-collapse collapse border-top" style="">
    <div class="accordion-body">
        <?php if (isset($ls)) {
            if ($ls->num_rows > 0) {
                $lsind = 0;
                while ($row = $ls->fetch_assoc()) {
                    $lsind++;
                    ?>
                    <div class="form-check form-check-primary mt-1">
                        <input class="form-check-input" type="checkbox" name="leadstat[]"
                            value="<?php echo $row["Ls_Id"] ?>" id="<?php echo "l" . $lsind ?>">
                        
                        <label class="form-check-label" for="<?php echo "l" . $lsind ?>"><?php echo $row["Ls_Name"] ?></label>
                        <?php
                                $subStatuses = getLeadStatusById($row["Ls_Id"]);
                                    if ($subStatuses && $subStatuses->num_rows > 0) {
                                        while ($subrow = $subStatuses->fetch_assoc()) {
                                            ?>
                                            <div class="form-check form-check-secondary">
                                                <input class="form-check-input" type="checkbox" name="leadstat[]"
                                                    value="<?php echo $subrow["Ls_Id"] ?>" id="<?php echo "l" . $subrow["Ls_Id"] ?>">
                                                <label class="form-check-label ml-4" for="<?php echo "l" . $subrow["Ls_Id"] ?>"><?php echo $subrow["Ls_Name"] ?></label>
                                            </div>
                                            <?php
                                        }
                                    }?>
                        </div>
                <?php }
            }
        } ?>
    </div>
</div>

   
        <div class="accordion-item card">
            <h2 class="accordion-header d-flex align-items-center">
                <button type="button" class="accordion-button" data-bs-toggle="collapse"
                    data-bs-target="#accordionWithIcon-3" aria-expanded="true">
                    Source
                </button>
            </h2>
            <div id="accordionWithIcon-3" class="accordion-collapse collapse border-top" style="">
                <div class="accordion-body">
                    <?php if (isset($sc)) {
                        if ($sc->num_rows > 0) {
                            $scind = 0;
                            while ($row = $sc->fetch_assoc()) {
                                $scind++;
                                ?>
                                <div class="form-check form-check-primary mt-1">
                                    <input class="form-check-input" type="checkbox" name="src[]" value="<?php echo $row["Sc_Id"] ?>"
                                        id="<?php echo "s" . $scind ?>">
                                    <label class="form-check-label" for="<?php echo "s" . $scind ?>"><?php echo $row["Sc_Name"] ?></label>
                                </div>
                            <?php }
                        }
                    } ?>
                </div>
            </div>
        </div>
        <div class="accordion-item card">
            <h2 class="accordion-header d-flex align-items-center">
                <button type="button" class="accordion-button" data-bs-toggle="collapse"
                    data-bs-target="#accordionWithIcon-4" aria-expanded="true">
                    Label
                </button>
            </h2>
            <div id="accordionWithIcon-4" class="accordion-collapse collapse border-top" style="">
                <div class="accordion-body">
                    <?php if (isset($lb)) {
                        if ($lb->num_rows > 0) {
                            $lbind = 0;
                            while ($row = $lb->fetch_assoc()) {
                                $lbind++;
                                ?>
                                <div class="form-check form-check-primary mt-1">
                                    <input class="form-check-input" type="checkbox" name="lb[]" value="<?php echo $row["Lb_Id"] ?>"
                                        id="<?php echo "l" . $lbind ?>">
                                    <label class="form-check-label" for="<?php echo "s" . $lbind ?>"><?php echo $row["Lb_Name"] ?></label>
                                </div>
                            <?php }
                        }
                    } ?>
                </div>
            </div>
        </div>
<?php } else { ?>
    <div class="card accordion-item">
            <h2 class="accordion-header d-flex align-items-center">
                <button type="button" class="accordion-button" data-bs-toggle="collapse"
                    data-bs-target="#accordionWithIcon-1" aria-expanded="true">
                    Lead Status
                </button>
            </h2>

            <div id="accordionWithIcon-1" class="accordion-collapse collapse border-top" style="">
                <div class="accordion-body">
                    <?php if (isset($ls)) {
                        if ($ls->num_rows > 0) {
                            $lsind = 0;
                            while ($row = $ls->fetch_assoc()) {
                                $lsind++;
                                ?>
                                <div class="form-check form-check-primary mt-1">
                                    <input class="form-check-input" type="checkbox" name="leadstat[]"
                                        value="<?php echo $row["Ls_Id"] ?>" id="<?php echo "l" . $lsind ?>">
                                    <label class="form-check-label" for="<?php echo "l" . $lsind ?>"><?php echo $row["Ls_Name"] ?></label>
                                </div>
                                <?php
                                $subStatuses = getLeadStatusById($row["Ls_Id"]);
                                    if ($subStatuses && $subStatuses->num_rows > 0) {
                                        while ($subrow = $subStatuses->fetch_assoc()) {
                                            ?>
                                            <div class="form-check form-check-secondary" style="margin-left: 25px;">
                                                <input class="form-check-input" type="checkbox" name="leadstat[]"
                                                    value="<?php echo $subrow["Ls_Id"] ?>" id="<?php echo "l" . $subrow["Ls_Id"] ?>">
                                                <label class="form-check-label ml-4" for="<?php echo "l" . $subrow["Ls_Id"] ?>"><?php echo $subrow["Ls_Name"] ?></label>
                                            </div>
                                            <?php
                                        }
                                    }?>
                            <?php }
                        }
                    } ?>
                </div>
            </div>
        </div>

        <div class="accordion-item card">
            <h2 class="accordion-header d-flex align-items-center">
                <button type="button" class="accordion-button" data-bs-toggle="collapse"
                    data-bs-target="#accordionWithIcon-2" aria-expanded="true">
                    Interested In
                </button>
            </h2>
            <div id="accordionWithIcon-2" class="accordion-collapse collapse border-top" style="">
                <div class="accordion-body">
                    <?php if (isset($intin)) {
                        if ($intin->num_rows > 0) {
                            $intind = 0;
                            while ($row = $intin->fetch_assoc()) {
                                $intind++;
                                ?>
                                <div class="form-check form-check-primary mt-1">
                                    <input class="form-check-input" type="checkbox" name="intin[]"
                                        value="<?php echo $row["Rt_Id"] ?>" id="<?php echo "i" . $intind ?>">
                                    <label class="form-check-label" for="<?php echo "i" . $intind ?>"><?php echo $row["Rt_Name"] ?></label>
                                </div>
                            <?php }
                        }
                    } ?>
                </div>
            </div>
        </div>

        <div class="accordion-item card">
            <h2 class="accordion-header d-flex align-items-center">
                <button type="button" class="accordion-button" data-bs-toggle="collapse"
                    data-bs-target="#accordionWithIcon-3" aria-expanded="true">
                    Source
                </button>
            </h2>
            <div id="accordionWithIcon-3" class="accordion-collapse collapse border-top" style="">
                <div class="accordion-body">
                    <?php if (isset($sc)) {
                        if ($sc->num_rows > 0) {
                            $scind = 0;
                            while ($row = $sc->fetch_assoc()) {
                                $scind++;
                                ?>
                                <div class="form-check form-check-primary mt-1">
                                    <input class="form-check-input" type="checkbox" name="src[]" value="<?php echo $row["Sc_Id"] ?>"
                                        id="<?php echo "s" . $scind ?>">
                                    <label class="form-check-label" for="<?php echo "s" . $scind ?>"><?php echo $row["Sc_Name"] ?></label>
                                </div>
                            <?php }
                        }
                    } ?>
                </div>
            </div>
        </div>
        <div class="accordion-item card">
            <h2 class="accordion-header d-flex align-items-center">
                <button type="button" class="accordion-button" data-bs-toggle="collapse"
                    data-bs-target="#accordionWithIcon-4" aria-expanded="true">
                    Label
                </button>
            </h2>
            <div id="accordionWithIcon-4" class="accordion-collapse collapse border-top" style="">
                <div class="accordion-body">
                    <?php if (isset($lb)) {
                        if ($lb->num_rows > 0) {
                            $lbind = 0;
                            while ($row = $lb->fetch_assoc()) {
                                $lbind++;
                                ?>
                                <div class="form-check form-check-primary mt-1">
                                    <input class="form-check-input" type="checkbox" name="lb[]" value="<?php echo $row["Lb_Id"] ?>"
                                        id="<?php echo "l" . $lbind ?>">
                                    <label class="form-check-label" for="<?php echo "s" . $lbind ?>"><?php echo $row["Lb_Name"] ?></label>
                                </div>
                                
                            <?php }
                        }
                    } ?>
                </div>
            </div>
        </div>
<?php } ?>
        
    </div>
    <div class="sticky-btn">
        <button type="button" id="filterapply" class="btn btn-sm btn-primary">Apply</button>
        <button type="button" id="filterclear" class="btn btn-sm btn-clean">Clear</button>
    </div>
</div>