<?php
if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dropdownmodel.php";

$team = $_SESSION["Team"][0]->Tm_Id;
$pteam = $_SESSION["Team"][0]->Tm_Id;


if($_SESSION["TypeId"] == "0" && $_SESSION["Role"] == "1"){

    $rt = getTeams();

}else{
    $rt = getTeams($team);

}
?>



<option value="">-</option>
<?php if (isset($rt)) {
    if ($rt->num_rows > 0) {
        while ($row = $rt->fetch_assoc()) {
            ?>
<option value="<?php echo $row['Tm_Id'] . (isset($row['Tm_parent_team_id']) ? '-' . $row['Tm_parent_team_id'] : ''); ?>" <?php echo $row['Tm_Id'] == $team ? 'selected' : ''; ?>>
    <?php echo $row['Tm_Name'] . " [ Team-Code - " . $row['Tm_Code'] . " ]"; ?>
</option>

        <?php }
    }
} ?>