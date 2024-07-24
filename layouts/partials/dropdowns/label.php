<?php
if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dropdownmodel.php";

$lb = getLabels();

?>




<?php if (isset($lb)) {
    if ($lb->num_rows > 0) {
        if($type=="arr"){
            $arr = "";
            while ($row = $lb->fetch_assoc()) {
                $arr = $arr . '{value:"' . $row["Lb_Id"] . '",name:"'.$row["Lb_Name"].'"},';
                
            }
            $arr = trim($arr,",");
            echo json_encode($arr);
        }
        else{
            while ($row = $lb->fetch_assoc()) {
                ?>
                <option value="<?php echo $row["Lb_Id"] ?>">
                    <?php echo $row["Lb_Name"] ?>
                </option>
            <?php }
        }
        
    }
} ?>