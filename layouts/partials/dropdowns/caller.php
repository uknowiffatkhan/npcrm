<?php
if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dropdownmodel.php";

if($_SESSION["TypeId"] == 1){
    $rt = getUserBytype(2);
}
else{
    $rt = getUserBytype(1);
}


?>



<option value="">-</option>
<?php if (isset($rt)) {
    if ($rt->num_rows > 0) {
        while ($row = $rt->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["U_Id"] ?>">
                <?php echo $row["U_DisplayName"] . " [" . $row["UType_Name"] . "," . $row["Rl_Name"] . "," . $row["Tm_Name"] . "]"?>
            </option>
        <?php }
    }
} ?>