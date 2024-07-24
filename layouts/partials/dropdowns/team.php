<?php
if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dropdownmodel.php";

if (isset($_POST['mode'])) {
    $urole =$_POST['role'] ;
    $utype =$_POST['type'] ;

    $rt = AllTeams($utype,$urole);

}else{
    $rt = AllTeams();

}

?>



<option value="">-</option>
<?php if (isset($rt)) {
    if ($rt->num_rows > 0) {
        while ($row = $rt->fetch_assoc()) {
            ?>
<option value="<?php echo $row['Tm_Id']?>">
    <?php echo $row['Tm_Name'] . " [ Team-Code - " . $row['Tm_Code'] . " ]"; ?>
</option>

        <?php }
    }
} ?>