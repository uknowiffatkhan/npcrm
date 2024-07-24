<?php
if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dropdownmodel.php";

$sc = getSource();
$typeid = $_SESSION["TypeId"]; // Assuming typeid is stored in the session

?>



<option value="">-</option>

<?php 
if (isset($sc) && $sc->num_rows ) {
  
        while ($row = $sc->fetch_assoc()) {
            $scId = $row["Sc_Id"];
            $scName = $row["Sc_Name"];

            if($typeid == 5){
                echo "<option value=\"$scId\">$scName</option>";
            }elseif ($typeid != 5 && in_array($scName,["Direct","Website","Whatsapp","Urdutimes","Google Ads","Facebook Ads","Instagram Ads","Word of Mouth","Pamphlet","99Acres","Housing"])) {
                // Display all options for other typeids
                echo "<option value=\"$scId\">$scName</option>";
            }
           
         }
    } 
?>

