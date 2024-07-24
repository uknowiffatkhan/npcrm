<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "utils/helper.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/leadmodel.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/commonmodel.php";

$uid = $_SESSION["UId"];
$roleid = $_SESSION["Role"];
$typeid = $_SESSION["TypeId"];

$userdet='';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = dbconnect();
    $search = mysqli_real_escape_string($conn, $_POST["search"]);
    $type = mysqli_real_escape_string($conn, $_POST["type"]);
    $role = mysqli_real_escape_string($conn, $_POST["role"]);
    $page = mysqli_real_escape_string($conn, $_POST["page"]);

    $userdet = getAllUsers($search,$type,$role,$page);
}
if($userdet){
 
    if ($userdet->num_rows > 0) {
 
        while ($u = $userdet->fetch_assoc()) {?>

<tr>
                    <td>
                        <input type="hidden" name="uid" value="<?php echo $u["U_Id"]?>">
                    <?php echo $u["U_Username"] . (($u["U_EmpCode"] != "") ? ' [EC - '.$u["U_EmpCode"].']' : (($u["Cp_Code"] != "") ? ' ['.$u["Cp_Code"].']' : '-')); ?>
                    </td>
                    <td><?php echo (($u["U_Mobile"] != "") ? $u["U_Mobile"] : '-') ?></td>

                    <td><?php echo $u["Rl_Name"] ?></td>
                    <td><?php echo $u["UType_Name"] ?></td>
                    <td><?php echo (($u["Tm_Name"]  != "") ? $u["Tm_Name"]  : '-') ?></td>
                    <td>
                        <label class="switch switch-success">
                            <input type="checkbox" class="switch-input" data-val="<?php echo $u["U_Id"] ?>" <?php echo $u["U_Status"] == "Active" ? "checked" : "" ?>>
                            <span class="switch-toggle-slider">
                                <span class="switch-on">
                                    <i class="bx bx-check"></i>
                                </span>
                                <span class="switch-off">
                                    <i class="bx bx-x"></i>
                                </span>
                            </span>
                        </label>
                    </td>
                    <td>
    <a class="btn btn-primary" href="<?php echo $_SESSION['baseurl'] ?>ulogin.php?uid=<?php echo urlencode(encrypt($u['U_Id'])) ?>" role="button">Login</a>
</td>
<td>
    <a class="btn btn-secondary" href="<?php echo $_SESSION['baseurl'] ?>v/users/add_user.php?uid=<?php echo urlencode(encrypt($u['U_Id'])) ?>" role="button">Edit</a>
</td>
                </tr>
<?php
}
    }
}

?>