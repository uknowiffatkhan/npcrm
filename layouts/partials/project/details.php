<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "utils/helper.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/leadmodel.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/callmodel.php";

$uid = $_SESSION["UId"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lid = $_POST["lid"];
    $pd = getProjectDetails($lid);
    $pdnum = $pd->num_rows;
    $pdr = $pd->fetch_assoc();
}


?>
<div class="projectdetails" style="overflow-y: auto;">
<div class="accordion" id="accordionPanelsStayOpenExample">
  <div class="accordion-item">
  <h1><?php echo $pdr["Pr_Name"] ?></h1>
            <h6><?php echo $pdr["Pr_Location"] ?></h6>
            <p><b><small>Details:</small></b><br/><?php echo $pdr["Pr_Details"] ?></p>
    <h2 class="accordion-header">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
      Brochure
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
    <div class="accordion-body">
                    <hr/>
                    <div>
                        <a href="<?php echo $baseurl . $pdr["Pr_Docs"] ?>" target="_blank">View in New Tab</a>
                    </div>
                    <iframe class="iframe-brochure" src="<?php echo $baseurl . $pdr["Pr_Docs"] ?>" frameborder="0"></iframe>
                </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
      Cost Details
      </button>
    </h2>
    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
    <div class="accordion-body">
                    <hr/>
                    <div>
                    <a href="<?php echo $baseurl . $pdr["Pr_Cost_Docs"] ?>" target="_blank">View in New Tab</a>
                    </div>
                    <iframe class="iframe-cost" src="<?php echo $baseurl . $pdr["Pr_Cost_Docs"] ?>" frameborder="0"></iframe>
                </div>
    </div>
  </div>
 
</div>
   
