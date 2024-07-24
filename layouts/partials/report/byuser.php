<?php
include('../../head.php');
include('../../auth.php');
if (!isset($_SESSION)) {
    session_start();
}
print_r($_SESSION);
$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dropdownmodel.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/commonmodel.php";
// print_r($_SESSION );
$uid = $_SESSION["UId"];
?>
<div class="row">
    <div class="col-md-6">
        
    </div>
</div>
<?php
include('../../foot.php');


?>
