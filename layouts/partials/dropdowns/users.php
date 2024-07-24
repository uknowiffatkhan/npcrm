<?php
if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dropdownmodel.php";
$uid= $_SESSION["UId"];
$team = $_SESSION["Team"][0]->Tm_Id;
$roleid = $_SESSION["Role"];
if($roleid == 2){
    $rt = getUsers($team);    
}
else{
    $rt = getUsers();
}


?>


<option disabled selected>-</option>

<?php if (isset($rt)) {
    if ($rt->num_rows > 0) {
        while ($row = $rt->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["U_Id"] ?>" <?php  echo $row["U_Id"]  == $uid ? 'selected' : ''  ?>>
                <?php echo $row["U_DisplayName"] . " [" . $row["UType_Name"] . "," . $row["Rl_Name"] . "," . $row["Tm_Name"] . "]"?>
            </option>
        <?php }
    }
} ?>