<?php
if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dropdownmodel.php";

// if(isset($ld)){
//     $rt = getProjectsbyLid($ld);
// }
// else{
//     $rt = getProjects();
// }

// if($rt->num_rows == 0){
//     $rt = getProjects();
// }
$rt = getProjects();

?>



<option value="">All</option>
<?php if (isset($rt)) {
    if ($rt->num_rows > 0) {
        while ($row = $rt->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["Pr_Id"]  ?>"  <?php echo ($row["Pr_Id"] == 8) ? 'selected' : '' ?>>
                <?php echo $row["Pr_Name"] ?>
            </option>
        <?php }
    }
} ?>