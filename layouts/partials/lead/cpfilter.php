<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dropdownmodel.php";


$pin = getPin();
$loc = getLoc();


?>


<div class="filter-blk p-3">
    <h5><i class="fas fa-filter"></i> Filter</h5>
    <div class="accordion mt-3" id="accordionWithIcon">
       
   
        <div class="accordion-item card">
            <h2 class="accordion-header d-flex align-items-center">
                <button type="button" class="accordion-button" data-bs-toggle="collapse"
                    data-bs-target="#accordionWithIcon-3" aria-expanded="true">
                    Pin
                </button>
            </h2>
            <div id="accordionWithIcon-3" class="accordion-collapse collapse border-top" style="">
                <div class="accordion-body">
                    <?php if (isset($pin)) {
                        if ($pin->num_rows > 0) {
                            $pinind = 0;
                            while ($row = $pin->fetch_assoc()) {
                                $pinind++;
                                ?>
                                <div class="form-check form-check-primary mt-1">
                                    <input class="form-check-input" type="checkbox" name="pin[]" value="<?php echo $row["Cp_Pin"] ?>"
                                        id="<?php echo "P" . $pinind ?>">
                                    <label class="form-check-label" for="<?php echo "P" . $pinind ?>"><?php echo $row["Cp_Pin"] ?></label>
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
                    Location
                </button>
            </h2>
            <div id="accordionWithIcon-4" class="accordion-collapse collapse border-top" style="">
                <div class="accordion-body">
                    <?php if (isset($loc)) {
                        if ($loc->num_rows > 0) {
                            $locind = 0;
                            while ($row = $loc->fetch_assoc()) {
                                $locind++;
                                ?>
                                <div class="form-check form-check-primary mt-1">
                                    <input class="form-check-input" type="checkbox" name="loc[]" value="<?php echo $row["Cp_Location"] ?>"
                                        id="<?php echo "l" . $locind ?>">
                                    <label class="form-check-label" for="<?php echo "l" . $locind ?>"><?php echo $row["Cp_Location"] ?></label>
                                </div>
                            <?php }
                        }
                    } ?>
                </div>
            </div>
        </div>


    <div class="sticky-btn">
        <button type="button" id="filterapply" class="btn btn-sm btn-primary">Apply</button>
        <button type="button" id="filterclear" class="btn btn-sm btn-clean">Clear</button>
    </div>
</div>