<?php
if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dropdownmodel.php";

$ls = getCallStatus();
$ms = getMessageStatus();
$mt = getMeetingStatus();

?>



<option value="">-</option>
<optgroup  label="Call">
<?php if (isset($ls)) {
    if ($ls->num_rows > 0) {
        while ($row = $ls->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["Cs_Id"] ?>">
                <?php echo $row["Cs_Name"] ?>
            </option>
        <?php }
    }
} ?>
</optgroup>
<optgroup label="Message">
<?php if (isset($ms)) {
    if ($ms->num_rows > 0) {
        while ($row = $ms->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["Cs_Id"] ?>">
                <?php echo $row["Cs_Name"] ?>
            </option>
        <?php }
    }
} ?>
</optgroup>
<optgroup label="Meeting">
<?php if (isset($mt)) {
    if ($mt->num_rows > 0) {
        while ($row = $mt->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["Cs_Id"] ?>">
                <?php echo $row["Cs_Name"] ?>
            </option>
        <?php }
    }
} ?>
</optgroup>
