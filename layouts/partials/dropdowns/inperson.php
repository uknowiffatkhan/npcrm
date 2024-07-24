<?php
if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dropdownmodel.php";

$rt = getInPersonType();

?>



<?php if (isset($rt)) {
    if ($rt->num_rows > 0) {
        while ($row = $rt->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["Ip_Name"] ?>">
                <?php echo $row["Ip_Name"] ?>
            </option>
        <?php }
    }
} ?>