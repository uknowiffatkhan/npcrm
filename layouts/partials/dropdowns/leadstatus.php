<?php
if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dropdownmodel.php";

$ls = getLeadStatus();
$sls= getLeadStatusById(5);
$typeid = $_SESSION["TypeId"]; 

?>
<option value="">-</option>
<?php
if ($ls && $ls->num_rows > 0) {
    while ($row = $ls->fetch_assoc()) {
        $lsId = $row["Ls_Id"];
        $lsName = $row["Ls_Name"];
        if ($typeid == 5 && in_array($lsName, ["New", "Follow Up", "Interested", "Not Interested", "Hold", "Junk", "Drop"])) {
            echo "<option value=\"$lsId\">$lsName</option>";

            $subStatuses = getLeadStatusById($lsId);
            if ($subStatuses && $subStatuses->num_rows > 0) {
                while ($subrow = $subStatuses->fetch_assoc()) {
                    $subLsId = $subrow["Ls_Id"];
                    $subLsName = $subrow["Ls_Name"];
                    echo "<option value=\"$subLsId\">&emsp;&emsp;$subLsName</option>";
                }


            }
        }
        elseif ($typeid != 5) {
            echo "<option value=\"$lsId\">$lsName</option>";
            $subStatuses = getLeadStatusById($lsId);
            if($lsId= 5){
                
            }
            if ($subStatuses && $subStatuses->num_rows > 0) {
                while ($subrow = $subStatuses->fetch_assoc()) {
                    $subLsId = $subrow["Ls_Id"];
                    $subLsName = $subrow["Ls_Name"];
                    echo "<option value=\"$subLsId\">&emsp;&emsp;$subLsName</option>";
                }

            }
        }
    }
}
?>
