<?php
if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dropdownmodel.php";

$rt = getVideoCallType();

?>



<?php if (isset($rt)) {
    if ($rt->num_rows > 0) {
        while ($row = $rt->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["Vc_Name"] ?>">
                <?php echo $row["Vc_Name"] ?>
            </option>
        <?php }
    }
} ?>