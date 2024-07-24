<?php

if (!isset($_SESSION)) {
    session_start();
}
include_once "../config/encrypter.php";
include_once "../config/db.php";
include_once "../layouts/auth.php";
include_once "../model/leadmodel.php";
include_once "../model/callmodel.php";
include_once "../model/remindermodel.php";
include_once "../model/usermodel.php";


$conn = dbconnect();
$uid = $_SESSION["UId"];
$team = @$_SESSION["Team"][0]->Tm_Id;
$usertype = $_SESSION["TypeId"];
// print_r($_POST);exit();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_POST["mode"] == "insert") {
        $lname = mysqli_real_escape_string($conn, $_POST["fullname"]);
        $lname = mysqli_real_escape_string($conn, $_POST["fullname"]);

        $lmob = mysqli_real_escape_string($conn, $_POST["mobno"]);
        $laltmob = mysqli_real_escape_string($conn, $_POST["altmobno"]);
        $lmail = mysqli_real_escape_string($conn, $_POST["email"]);
        $lref = mysqli_real_escape_string($conn, $_POST["ref"]);
        $ladd = mysqli_real_escape_string($conn, $_POST["address"]);
        $lcity = mysqli_real_escape_string($conn, $_POST["city"]);
        $lpin = mysqli_real_escape_string($conn, $_POST["pin"]);
        $lloc = mysqli_real_escape_string($conn, $_POST["location"]);
        $lsource = mysqli_real_escape_string($conn, $_POST["source"]);
        $lstatus = mysqli_real_escape_string($conn, $_POST["leadstatus"]);
        $project = mysqli_real_escape_string($conn, $_POST["project"]);
        $lintin = mysqli_real_escape_string($conn, $_POST["interestedfor"]);
        $ldate = mysqli_real_escape_string($conn, $_POST["leaddate"]);
        $bud = mysqli_real_escape_string($conn, $_POST["budget"]);
        $cp = mysqli_real_escape_string($conn, $_POST["channelpartner"]);
        $rmk = mysqli_real_escape_string($conn, $_POST["remark"]);
        $leadtype = mysqli_real_escape_string($conn, $_POST["leadtype"]);

        if(isset($_POST["rno"])){
            $rno = mysqli_real_escape_string($conn, $_POST["rno"]);

        }else{
            $rno ="";
        }
        if(isset($_POST["redate"])){
            $redate = mysqli_real_escape_string($conn, $_POST["redate"]);

        }else{
            $redate ="";
        }

        $lid = insertLead($lname,$rno,$lmob, $laltmob, $lmail,$lref, $ladd, $lcity, $lpin, $lloc, $project, $lintin, $lsource, $lstatus, $ldate,1, $bud, $rmk,$leadtype, $uid);

        if(isset($_POST["sales"])){
            $assignsales = mysqli_real_escape_string($conn, $_POST["sales"]);
            $udet=getUserDetails($assignsales);
            $tmid = getUserTeam($assignsales);
            AssignLead($lid,$assignsales,$tmid["Tm_Id"], 0);
            // $leadate="";

            $gc = $gclast->fetch_assoc();

            
            if ($redate != "") {
                if (in_array($lstatus, [2, 4, 12, 17])) {
                    updateAssignDateTimeLead($lid, $redate, $assignsales);
                    markReminderRead($lid,$assignsales);

                    $cldate = strtotime(date("Y-m-d", strtotime($redate))) > strtotime(date('Y-m-d')) 
                        ? date("Y-m-d H:i:s", strtotime("-1 day", strtotime($redate))) 
                        : $redate;

                    insertReminder($lid, $clid, $cldate, "Lead Rescheduled On: " . $leadate, $assignsales);
                }
            } else {
                if (in_array($lstatus, [2, 4, 12, 17])) {
                    markReminderRead($lid, $assignsales);
                    $cldate = date("Y-m-d H:i:s", strtotime("-1 day", strtotime($leadate)));
                    insertReminder($lid, $clid, $cldate, "Lead Scheduled On: " . $leadate, $assignsales);
                }
            }
            

        }else{
            AssignLead($lid,$uid,$team,0);
        }
        
        if($cp != ""){
            AssignCP($lid,$cp,$uid);
        }

        $_SESSION["openlead"] = $lid;
        echo "insert/" . $lid;

    } else if ($_POST["mode"] == "update") {

        $lname = mysqli_real_escape_string($conn, $_POST["fullname"]);
        if(isset($_POST["mobno"])){
            $lmob = mysqli_real_escape_string($conn, $_POST["mobno"]);
        }
        else{
            $lmob = "";
        }
        if(isset($_POST["altmobno"])){
            $laltmob = mysqli_real_escape_string($conn, $_POST["altmobno"]);
        }
        else{
            $laltmob = "";
        }
        if(isset($_POST["email"])){
            $lmail = mysqli_real_escape_string($conn, $_POST["email"]);
        }
        else{
            $lmail = "";
        }
        $lref = mysqli_real_escape_string($conn, $_POST["ref"]);
        $ladd = mysqli_real_escape_string($conn, $_POST["address"]);
        $lcity = mysqli_real_escape_string($conn, $_POST["city"]);
        $lpin = mysqli_real_escape_string($conn, $_POST["pin"]);
        $lloc = mysqli_real_escape_string($conn, $_POST["location"]);
        $lsource = mysqli_real_escape_string($conn, $_POST["source"]);
        $lstatus = mysqli_real_escape_string($conn, $_POST["leadstatus"]);
        $project = mysqli_real_escape_string($conn, $_POST["project"]);
        $lintin = mysqli_real_escape_string($conn, $_POST["interestedfor"]);
        $bud = mysqli_real_escape_string($conn, $_POST["budget"]);

        if(isset($_POST["remark"])){
            $rmk = mysqli_real_escape_string($conn, $_POST["remark"]);
        }
        else{
            $rmk = "";
        }
        if(isset($_POST["redate"])){
            $redate = mysqli_real_escape_string($conn, $_POST["redate"]);

        }else{
            $redate ="";
        }
        $lid = mysqli_real_escape_string($conn, $_POST["lid"]);

        if(isset($_POST["channelpartner"])){
            $cp = mysqli_real_escape_string($conn, $_POST["channelpartner"]);
        }
        else{
            $cp = "";
        }

        if(isset($_POST["refuser"])){
            $caller = getcurrentCallerAssigned($lid);
            $caller = $caller->fetch_assoc();
            $assigncaller = mysqli_real_escape_string($conn, $_POST["refuser"]);
                if($caller["Al_CallerId"] != $assigncaller){
                    $tmid = getUserTeam($assigncaller);
                    AssignLead($lid, $assigncaller, $tmid["Tm_Id"], 0);
                }
        }
        else{
            $assigncaller = "";
        }


        if(isset($_POST["rno"])){
            $rno = mysqli_real_escape_string($conn, $_POST["rno"]);
        }else{
            $rno = "";
        }
        

        if(isset($_POST["sales"])){
            $sales = getcurrentSalesAssigned($lid);
            $sales = $sales->fetch_assoc();
            $assignsales = mysqli_real_escape_string($conn, $_POST["sales"]);
            $udet=getUserDetails($assignsales);
            $tmid = getUserTeam($assignsales);
            $leadate="";

                if($sales["Al_CallerId"] != $assignsales){
                    $tmid = getUserTeam($assignsales);
                    reassignLeadtoSales($lid, $assignsales, $tmid["Tm_Id"], 0);
                    markReminderRead($lid, $assignsales);
                    InactiveAllVivistCall($lid, $assignsales);
                    // $gclast = getLastConnectedCall($lid);
                    // $gc = $gclast->fetch_assoc();
                    // $leadate = date("Y-m-d H:i:s");
                    // $reasigntime = !empty($redate) ? date("Y-m-d H:i:s", strtotime($redate)) : "";
                }

                // if (!empty($redate)) {
                //     if (in_array($lstatus, [2, 4, 12, 17])) {
                //         updateAssignDateTimeLead($lid, $reasigntime, $assignsales);
                //         markReminderRead($lid, $assignsales);

                //         $cldate = strtotime(date("Y-m-d", strtotime($leadate))) > strtotime(date('Y-m-d')) 
                //             ? date("Y-m-d H:i:s", strtotime("-1 day", strtotime($leadate))) 
                //             : $reasigntime;

                //         insertReminder($lid, $clid, $cldate, "Lead Rescheduled On: " . $leadate, $assignsales);
                //     }
                // } else {
                //     if (in_array($lstatus, [2, 4, 12, 17])) {
                //         markReminderRead($lid, $assignsales);
                //         $cldate = date("Y-m-d H:i:s", strtotime("-1 day", strtotime($leadate)));
                //         insertReminder($lid, $clid, $cldate, "Lead Scheduled On: " . $leadate, $assignsales);
                //     }
                // }
            }
        
        
        if($_SESSION["TypeId"] == 2){

            updatebySales($lid, $lname , $lref, $ladd, $lcity, $lpin, $lloc, $project, $lintin, $lsource, $lstatus,$bud, $uid);
        }elseif($_SESSION["TypeId"] == 7){

            updatebyReception($lid,$rno,$lname,$lref,$ladd,$lcity,$lpin, $lloc, $project,$lintin,$lsource,$lstatus,$bud,$uid);            
        }
        else{
            updateLead($lid, $lname, $lmob, $laltmob, $lmail, $lref, $ladd, $lcity, $lpin, $lloc, $project, $lintin, $lsource, $lstatus,$bud,$rmk, $uid);
        }

        $oldname = mysqli_real_escape_string($conn, $_POST["oldname"]);
        $oldlref = mysqli_real_escape_string($conn, $_POST["oldref"]);
        $oldladd = mysqli_real_escape_string($conn, $_POST["oldaddress"]);
        $oldlcity = mysqli_real_escape_string($conn, $_POST["oldcity"]);
        $oldlpin = mysqli_real_escape_string($conn, $_POST["oldpin"]);
        $oldlloc = mysqli_real_escape_string($conn, $_POST["oldlocation"]);
        $oldlsource = mysqli_real_escape_string($conn, $_POST["oldsource"]);
        $oldlstatus = mysqli_real_escape_string($conn, $_POST["oldleadstatus"]);
        $oldproject = mysqli_real_escape_string($conn, $_POST["oldproject"]);
        $oldlintin = mysqli_real_escape_string($conn, $_POST["oldinterestedfor"]);
        $oldbud = mysqli_real_escape_string($conn, $_POST["oldbudget"]);
        $logremark = "";

        if(!empty($_POST["oldsales"])){
            $oldsales = mysqli_real_escape_string($conn, $_POST["oldsales"]);
            if($assignsales  != $oldsales ){
                $from = getUserDetails($oldsales);
                $to = getUserDetails($assignsales);
                $logremark = $logremark . ", " . "Lead Reassigned from " . $from['U_DisplayName'] . " (" . $from['U_EmpCode'] . ") => " . $to['U_DisplayName'] . " (" . $to['U_EmpCode'] . ")";


            }
        }
        
        if($lname != $oldname){
            $logremark = $logremark . ", " . "Changed Name from $oldname => $lname";
        }

        if($lname != $oldname){
            $logremark = $logremark . ", " . "Changed Name from $oldname => $lname";
        }
        if($lref != $oldlref){
            $logremark = $logremark . ", " . "Changed Reference from $oldlref => $lref";
        }
        if($ladd != $oldladd){
            $logremark = $logremark . ", " . "Changed Address from $oldladd => $ladd";
        }
        if($lcity != $oldlcity){
            $logremark = $logremark . ", " . "Changed City from $oldlcity => $lcity";
        }
        if($lpin != $oldlpin){
            $logremark = $logremark . ", " . "Changed Pincode from $oldlpin => $lpin";
        }
        if($lloc != $oldlloc){
            $logremark = $logremark . ", " . "Changed Location from $oldlloc => $lloc";
        }
        if($lsource != $oldlsource){
            $logremark = $logremark . ", " . "Changed Source from $oldlsource => $lsource";
        }
        if($lstatus != $oldlstatus){
            $logremark = $logremark . ", " . "Changed Status from $oldlstatus => $lstatus";
        }
        if($project != $oldproject){
            $logremark = $logremark . ", " . "Changed Project from $oldproject => $project";
        }
        if($lintin != $oldlintin){
            $logremark = $logremark . ", " . "Changed Interested In from $oldlintin => $lintin";
        }
        if($bud != $oldbud){
            $logremark = $logremark . ", " . "Changed Budget from $oldbud => $bud";
        }

        if($logremark != ""){
            insertAdminCall($lid, trim($logremark, ','), $uid);
        }


        if($cp != ""){
            DelAssignedCP($lid,$cp,$uid);
            AssignCP($lid,$cp,$uid);
        }
        $_SESSION["openlead"] = $lid;
        echo "update/" . $lid;

    } else if ($_POST["mode"] == "insertsourcinglead") {
        $lname = mysqli_real_escape_string($conn, $_POST["fullname"]);
        $lmob = mysqli_real_escape_string($conn, $_POST["mobno"]);
        $laltmob = mysqli_real_escape_string($conn, $_POST["altmobno"]);
        $lmail = mysqli_real_escape_string($conn, $_POST["email"]);
        $lref = mysqli_real_escape_string($conn, $_POST["ref"]);
        $ladd = mysqli_real_escape_string($conn, $_POST["address"]);
        $lpadd = mysqli_real_escape_string($conn, $_POST["paddress"]);
        $lcity = mysqli_real_escape_string($conn, $_POST["city"]);
        $lpin = mysqli_real_escape_string($conn, $_POST["pin"]);
        $lloc = mysqli_real_escape_string($conn, $_POST["location"]);
        $lsource = mysqli_real_escape_string($conn, $_POST["source"]);
        $lstatus = mysqli_real_escape_string($conn, $_POST["leadstatus"]);
        $project = mysqli_real_escape_string($conn, $_POST["project"]);
        $lrno = mysqli_real_escape_string($conn, $_POST["rno"]);
        $lgst = mysqli_real_escape_string($conn, $_POST["gst"]);
        $ldate = mysqli_real_escape_string($conn, $_POST["leaddate"]);
        $rmk = mysqli_real_escape_string($conn, $_POST["remark"]);
        $leadtype = mysqli_real_escape_string($conn, $_POST["leadtype"]);
        
        $lid = insertSouringcLead($lname, $lmob, $laltmob, $lmail, $lref, $ladd,$lpadd, $lcity, $lpin, $lloc,$project, $lsource, $lstatus,  $lrno, $lgst, date('Y-m-d H:i:s',strtotime($ldate)),$rmk, $leadtype,1,$uid);
        AssignLead($lid, $uid, $team, 0);


        if(isset( $_POST["refuser"])){
            
            $assigncaller = mysqli_real_escape_string($conn, $_POST["refuser"]);
            $tmid = getUserTeam($assigncaller);
            AssignLead($lid, $assigncaller, $tmid["Tm_Id"], 0);
        }
        else{
            $assigncaller = "";
        }
        
        // if($cp != ""){
        //     AssignCP($lid,$cp,$uid);
        // }
        $_SESSION["openlead"] = $lid;
        echo "insert/" . $lid;

    } else if ($_POST["mode"] == "updatesourcinglead") {
        $lname = mysqli_real_escape_string($conn, $_POST["fullname"]);
        if(isset($_POST["mobno"])){
            $lmob = mysqli_real_escape_string($conn, $_POST["mobno"]);
        }
        else{
            $lmob = "";
        }
        if(isset($_POST["altmobno"])){
            $laltmob = mysqli_real_escape_string($conn, $_POST["altmobno"]);
        }
        else{
            $laltmob = "";
        }
        if(isset($_POST["email"])){
            $lmail = mysqli_real_escape_string($conn, $_POST["email"]);
        }
        else{
            $lmail = "";
        }
        $lref = mysqli_real_escape_string($conn, $_POST["ref"]);
        $ladd = mysqli_real_escape_string($conn, $_POST["address"]);
        $lpadd = mysqli_real_escape_string($conn, $_POST["paddress"]);
        $lcity = mysqli_real_escape_string($conn, $_POST["city"]);
        $lpin = mysqli_real_escape_string($conn, $_POST["pin"]);
        $lloc = mysqli_real_escape_string($conn, $_POST["location"]);
        $lsource = mysqli_real_escape_string($conn, $_POST["source"]);
        $lstatus = mysqli_real_escape_string($conn, $_POST["leadstatus"]);
        $project = mysqli_real_escape_string($conn, $_POST["project"]);
        $lrno = mysqli_real_escape_string($conn, $_POST["rno"]);
        $lgst = mysqli_real_escape_string($conn, $_POST["gst"]);

        if(isset($_POST["remark"])){
            $rmk = mysqli_real_escape_string($conn, $_POST["remark"]);
        }
        else{
            $rmk = "";
        }
        
        $lid = mysqli_real_escape_string($conn, $_POST["lid"]);
        if(isset($_POST["channelpartner"])){
            $cp = mysqli_real_escape_string($conn, $_POST["channelpartner"]);
        }
        else{
            $cp = "";
        }
        if(isset($_POST["refuser"])){
            $caller = getcurrentCallerAssigned($lid);
            $caller = $caller->fetch_assoc();
            $assigncaller = mysqli_real_escape_string($conn, $_POST["refuser"]);
            if($caller["Al_CallerId"] != $assigncaller){
                $tmid = getUserTeam($assigncaller);
                AssignLead($lid, $assigncaller, $tmid["Tm_Id"], 0);
            }
        }
        else{
            $assigncaller = "";
        }
        
        updateSourcingLead($lid, $lname, $lmob, $laltmob, $lmail, $lref, $ladd,$lpadd, $lcity, $lpin, $lloc, $project,$lsource, $lstatus,$lrno,$lgst,$rmk, $uid);
        
        $oldname = mysqli_real_escape_string($conn, $_POST["oldname"]);
        $oldlref = mysqli_real_escape_string($conn, $_POST["oldref"]);
        $oldladd = mysqli_real_escape_string($conn, $_POST["oldaddress"]);
        $poldaddress = mysqli_real_escape_string($conn, $_POST["poldaddress"]);
        $oldlcity = mysqli_real_escape_string($conn, $_POST["oldcity"]);
        $oldlpin = mysqli_real_escape_string($conn, $_POST["oldpin"]);
        $oldlloc = mysqli_real_escape_string($conn, $_POST["oldlocation"]);
        $oldlsource = mysqli_real_escape_string($conn, $_POST["oldsource"]);
        $oldlstatus = mysqli_real_escape_string($conn, $_POST["oldleadstatus"]);
        $oldproject = mysqli_real_escape_string($conn, $_POST["oldproject"]);
        $oldrerano = mysqli_real_escape_string($conn, $_POST["oldrerano"]);
        $oldgst = mysqli_real_escape_string($conn, $_POST["oldgst"]);
        $logremark = "";

        if($lname != $oldname){
            $logremark = $logremark . ", " . "Changed Name from $oldname => $lname";
        }
        if($lref != $oldlref){
            $logremark = $logremark . ", " . "Changed Reference from $oldlref => $lref";
        }
        if($ladd != $oldladd){
            $logremark = $logremark . ", " . "Changed Address from $oldladd => $ladd";
        }
        if($lpadd != $poldaddress){
            $logremark = $logremark . ", " . "Changed Address from $poldaddress => $lpadd";
        }
        if($lcity != $oldlcity){
            $logremark = $logremark . ", " . "Changed City from $oldlcity => $lcity";
        }
        if($lpin != $oldlpin){
            $logremark = $logremark . ", " . "Changed Pincode from $oldlpin => $lpin";
        }
        if($lloc != $oldlloc){
            $logremark = $logremark . ", " . "Changed Location from $oldlloc => $lloc";
        }
        if($lsource != $oldlsource){
            $logremark = $logremark . ", " . "Changed Source from $oldlsource => $lsource";
        }
        if($lstatus != $oldlstatus){
            $logremark = $logremark . ", " . "Changed Status from $oldlstatus => $lstatus";
        }
        if($project != $oldproject){
            $logremark = $logremark . ", " . "Changed Project from $oldproject => $project";
        }
        if($lrno!=$oldrerano){
            $logremark = $logremark . ", " . "Changed Project from $oldrerano  => $lrno";
        }
        if($lgst!=$oldgst){
            $logremark = $logremark . ", " . "Changed Project from $oldgst  => $lgst";
        }

        if($logremark != ""){
            insertAdminCall($lid, trim($logremark, ','), $uid);
        }


        if($cp != ""){
            DelAssignedCP($lid,$cp,$uid);
            AssignCP($lid,$cp,$uid);
        }
        $_SESSION["openlead"] = $lid;
        echo "update/" . $lid;

    }  else if ($_POST["mode"] == "insertcplead") {
        $lname = mysqli_real_escape_string($conn, $_POST["fullname"]);
        $lmob = mysqli_real_escape_string($conn, $_POST["mobno"]);
        $laltmob = mysqli_real_escape_string($conn, $_POST["altmobno"]);
        $lmail = mysqli_real_escape_string($conn, $_POST["email"]);
        $lref = mysqli_real_escape_string($conn, $_POST["ref"]);
        $ladd = mysqli_real_escape_string($conn, $_POST["address"]);
        $lcity = mysqli_real_escape_string($conn, $_POST["city"]);
        $lpin = mysqli_real_escape_string($conn, $_POST["pin"]);
        $lloc = mysqli_real_escape_string($conn, $_POST["location"]);
        $lsource = mysqli_real_escape_string($conn, $_POST["source"]);
        $lstatus = mysqli_real_escape_string($conn, $_POST["leadstatus"]);
        $project = mysqli_real_escape_string($conn, $_POST["project"]);
        $lintin = mysqli_real_escape_string($conn, $_POST["interestedfor"]);
        $ldate = mysqli_real_escape_string($conn, $_POST["leaddate"]);
        $bud = mysqli_real_escape_string($conn, $_POST["budget"]);
        $rmk = mysqli_real_escape_string($conn, $_POST["remark"]);
        $leadtype = mysqli_real_escape_string($conn, $_POST["leadtype"]);


        // $lid = insertCpLead($lname, $lmob, $laltmob, $lmail, $lref, $ladd, $lcity, $lpin, $lloc, $project, $lintin, $lsource, $lstatus, $ldate, 1, $bud, $rmk,$leadtype, $uid);
        $lid = insertCpLead($lname, $lmob, $laltmob, $lmail, $lref, $ladd, $lcity, $lpin, $lloc, $project, $lintin, $lsource, $lstatus, $ldate, 0, $bud, $rmk,$leadtype, $uid);
       
       
        AssignLead($lid, $uid, $team, 0);
       
        $_SESSION["openlead"] = $lid;
        echo "insert/" . $lid;

    }else if ($_POST["mode"] == "updatecplead") {
        $lname = mysqli_real_escape_string($conn, $_POST["fullname"]);
        if(isset($_POST["mobno"])){
            $lmob = mysqli_real_escape_string($conn, $_POST["mobno"]);
        }
        else{
            $lmob = "";
        }
        if(isset($_POST["altmobno"])){
            $laltmob = mysqli_real_escape_string($conn, $_POST["altmobno"]);
        }
        else{
            $laltmob = "";
        }
        if(isset($_POST["email"])){
            $lmail = mysqli_real_escape_string($conn, $_POST["email"]);
        }
        else{
            $lmail = "";
        }
        $lref = mysqli_real_escape_string($conn, $_POST["ref"]);
        $ladd = mysqli_real_escape_string($conn, $_POST["address"]);
        $lcity = mysqli_real_escape_string($conn, $_POST["city"]);
        $lpin = mysqli_real_escape_string($conn, $_POST["pin"]);
        $lloc = mysqli_real_escape_string($conn, $_POST["location"]);
        $lsource = mysqli_real_escape_string($conn, $_POST["source"]);
        $lstatus = mysqli_real_escape_string($conn, $_POST["leadstatus"]);
        $project = mysqli_real_escape_string($conn, $_POST["project"]);
        $lintin = mysqli_real_escape_string($conn, $_POST["interestedfor"]);
        $bud = mysqli_real_escape_string($conn, $_POST["budget"]);
        if(isset($_POST["remark"])){
            $rmk = mysqli_real_escape_string($conn, $_POST["remark"]);
        }
        else{
            $rmk = "";
        }
        
        $lid = mysqli_real_escape_string($conn, $_POST["lid"]);
        if(isset($_POST["channelpartner"])){
            $cp = mysqli_real_escape_string($conn, $_POST["channelpartner"]);
        }
        else{
            $cp = "";
        }
        if(isset($_POST["refuser"])){
            $caller = getcurrentCallerAssigned($lid);
            $caller = $caller->fetch_assoc();
            $assigncaller = mysqli_real_escape_string($conn, $_POST["refuser"]);
            if($caller["Al_CallerId"] != $assigncaller){
                $tmid = getUserTeam($assigncaller);
                AssignLead($lid, $assigncaller, $tmid["Tm_Id"], 0);
            }
        }
        else{
            $assigncaller = "";
        }
        

        if($_SESSION["TypeId"] == 2){
            updatebySourceSales($lid, $lname , $lref, $ladd, $lcity, $lpin, $lloc, $project, $lintin, $lsource, $lstatus,$bud, $uid);
        }
        else{
            updateCpLead($lid, $lname, $lmob, $laltmob, $lmail, $lref, $ladd, $lcity, $lpin, $lloc, $project, $lintin, $lsource, $lstatus,$bud,$rmk, $uid);
        }
        $oldname = mysqli_real_escape_string($conn, $_POST["oldname"]);
        $oldlref = mysqli_real_escape_string($conn, $_POST["oldref"]);
        $oldladd = mysqli_real_escape_string($conn, $_POST["oldaddress"]);
        $oldlcity = mysqli_real_escape_string($conn, $_POST["oldcity"]);
        $oldlpin = mysqli_real_escape_string($conn, $_POST["oldpin"]);
        $oldlloc = mysqli_real_escape_string($conn, $_POST["oldlocation"]);
        $oldlsource = mysqli_real_escape_string($conn, $_POST["oldsource"]);
        $oldlstatus = mysqli_real_escape_string($conn, $_POST["oldleadstatus"]);
        $oldproject = mysqli_real_escape_string($conn, $_POST["oldproject"]);
        $oldlintin = mysqli_real_escape_string($conn, $_POST["oldinterestedfor"]);
        $oldbud = mysqli_real_escape_string($conn, $_POST["oldbudget"]);
        $logremark = "";

        if($lname != $oldname){
            $logremark = $logremark . ", " . "Changed Name from $oldname => $lname";
        }
        if($lref != $oldlref){
            $logremark = $logremark . ", " . "Changed Reference from $oldlref => $lref";
        }
        if($ladd != $oldladd){
            $logremark = $logremark . ", " . "Changed Address from $oldladd => $ladd";
        }
        if($lcity != $oldlcity){
            $logremark = $logremark . ", " . "Changed City from $oldlcity => $lcity";
        }
        if($lpin != $oldlpin){
            $logremark = $logremark . ", " . "Changed Pincode from $oldlpin => $lpin";
        }
        if($lloc != $oldlloc){
            $logremark = $logremark . ", " . "Changed Location from $oldlloc => $lloc";
        }
        if($lsource != $oldlsource){
            $logremark = $logremark . ", " . "Changed Source from $oldlsource => $lsource";
        }
        if($lstatus != $oldlstatus){
            $logremark = $logremark . ", " . "Changed Status from $oldlstatus => $lstatus";
        }
        if($project != $oldproject){
            $logremark = $logremark . ", " . "Changed Project from $oldproject => $project";
        }
        if($lintin != $oldlintin){
            $logremark = $logremark . ", " . "Changed Interested In from $oldlintin => $lintin";
        }
        if($bud != $oldbud){
            $logremark = $logremark . ", " . "Changed Budget from $oldbud => $bud";
        }

        if($logremark != ""){
            insertAdminCall($lid, trim($logremark, ','), $uid);
        }


        if($cp != ""){
            DelAssignedCP($lid,$cp,$uid);
            AssignCP($lid,$cp,$uid);
        }
        $_SESSION["openlead"] = $lid;
        echo "update/" . $lid;

    } else if ($_POST["mode"] == "insertconfirmcp") {
        $Cpname = mysqli_real_escape_string($conn, $_POST["fullname"]);
        $Cpmob = mysqli_real_escape_string($conn, $_POST["mobno"]);
        $Cpaltmob = mysqli_real_escape_string($conn, $_POST["altmobno"]);
        $Cpmail = mysqli_real_escape_string($conn, $_POST["email"]);
        $Cpadd = mysqli_real_escape_string($conn, $_POST["add"]);
        $Cppin = mysqli_real_escape_string($conn, $_POST["pin"]);
        $Cploc = mysqli_real_escape_string($conn, $_POST["location"]);
        $Cpdate = mysqli_real_escape_string($conn, $_POST["joindate"]);
        $Cprerano = mysqli_real_escape_string($conn, $_POST["rerano"]);
        $Cpgst = mysqli_real_escape_string($conn, $_POST["gst"]);
        $Cpaccno = mysqli_real_escape_string($conn, $_POST["accno"]);
        $Cppanno = mysqli_real_escape_string($conn, $_POST["panno"]);
        $Cpifsc = mysqli_real_escape_string($conn, $_POST["ifsc"]);
        $cpbankno = mysqli_real_escape_string($conn, $_POST["bankno"]);
        $Cpbranch = mysqli_real_escape_string($conn, $_POST["branch"]);
        $Cpcode = mysqli_real_escape_string($conn, $_POST["lead_code"]);
        $roleid = 2;
        $typeid = 4;

            $Cpid = insertConfirmCpLead($Cpname, $Cpmob, $Cpaltmob, $Cpmail, $Cpadd, $Cppin, $Cploc, $Cprerano, $Cpgst, $Cpaccno,$Cppanno, $Cpifsc, $cpbankno, $Cpbranch, $Cpcode, $Cpdate, $uid);
            
            $password = generateRandomPassword();
            $createdId = $modifyId = $uid;

            $cuid = convertCpToUser($Cpid, $Cpname, $password, $Cpmob,$Cpmail,$roleid, $typeid, $createdId, $modifyId, 'Active', 0);
            $lastTmCode = getLastTmCode($conn);
            $lastTmNumber = $lastTmCode ? intval($lastTmCode) : 1011;
            $newTmCode = $lastTmNumber + 1;

            $tid = makeTeam($cuid,$Cpcode,$newTmCode);
                Assignteam($cuid,$tid,'2',$cuid);

            // if ($leadId!='') {
            //     $softDeleteSql = $conn->prepare("UPDATE tbl_assignlead SET Al_Del = 1 WHERE Al_LeadId = ?");
            //     $softDeleteSql->bind_param("i", $leadId);
    
            //     if ($softDeleteSql->execute()) {
            //         echo "Record updated successfully in tbl_assignlead";
            //     } else {
            //         echo "Error updating record in tbl_assignlead: " . $softDeleteSql->error;
            //     }
            // }
            AssignSourceLead($Cpid,$uid,$tid,0);
            sendRegistrationEmail($Cpname, $Cpmail, $Cpmob, $password);

        $_SESSION["openlead"] = $Cpid;
        echo "insert/" . $Cpid;

    } else if ($_POST["mode"] == "updatelabel") {
        $leadid = mysqli_real_escape_string($conn, $_POST["leadid"]);
        //$status = mysqli_real_escape_string($conn, $_POST["status"]);
        $labels = mysqli_real_escape_string($conn, $_POST["labels"]);

        $labels = explode(",", $labels);

        //updateStatus($leadid, $status, $uid);
        deleteLabel($leadid, $uid);

        foreach ($labels as $l) {
            if ($l != "") {
                insertLabel($leadid, $l, $uid);
            }

        }

    } else if ($_POST["mode"] == "updateconfirmcp") {

        $Cpname = mysqli_real_escape_string($conn, $_POST["fullname"]);
        if(isset($_POST["mobno"])){
            $Cpmob = mysqli_real_escape_string($conn, $_POST["mobno"]);
        }
        else{
            $Cpmob = "";
        }
        if(isset($_POST["altmobno"])){
            $Cpaltmob = mysqli_real_escape_string($conn, $_POST["altmobno"]);
        }
        else{
            $Cpaltmob = "";
        }
        if(isset($_POST["email"])){
            $Cpmail = mysqli_real_escape_string($conn, $_POST["email"]);
        }
        else{
            $Cpmail = "";
        }
      
        $Cpadd = mysqli_real_escape_string($conn, $_POST["add"]);
        $Cppin = mysqli_real_escape_string($conn, $_POST["pin"]);
        $Cploc = mysqli_real_escape_string($conn, $_POST["location"]);
        $Cprerano = mysqli_real_escape_string($conn, $_POST["rerano"]);
        $Cpgst = mysqli_real_escape_string($conn, $_POST["gst"]);
        $Cpaccno = mysqli_real_escape_string($conn, $_POST["accno"]);
        $Cppanno = mysqli_real_escape_string($conn, $_POST["panno"]);
        $Cpifsc = mysqli_real_escape_string($conn, $_POST["ifsc"]);
        $Cpbankno = mysqli_real_escape_string($conn, $_POST["bankno"]);
        $Cpbranch = mysqli_real_escape_string($conn, $_POST["branch"]);
       

        $lid = mysqli_real_escape_string($conn, $_POST["lid"]);
        if(isset($_POST["channelpartner"])){
            $cp = mysqli_real_escape_string($conn, $_POST["channelpartner"]);
        }
        else{
            $cp = "";
        }
        if(isset($_POST["refuser"])){
            $caller = getcurrentCallerAssigned($lid);
            $caller = $caller->fetch_assoc();
            $assigncaller = mysqli_real_escape_string($conn, $_POST["refuser"]);
            if($caller["Al_CallerId"] != $assigncaller){
                $tmid = getUserTeam($assigncaller);
                AssignLead($lid, $assigncaller, $tmid["Tm_Id"], 0);
            }
        }
        else{
            $assigncaller = "";
        }
        

        if($_SESSION["TypeId"] == 2){
            updatebyConfirmCpSales($lid,$Cpname,$Cpadd,$Cppin,$Cprerano,$Cpgst,$Cpaccno,$Cppanno,$Cpifsc,$Cpbankno,$Cpbranch,$Cploc,$uid);
        }
        else{
            updateConfirmCpLead($lid, $Cpname,$Cpmob,$Cpaltmob,$Cpmail,$Cpadd,$Cppin,$Cploc,$Cprerano,$Cpgst,$Cpaccno,$Cppanno,$Cpifsc,$Cpbankno,$Cpbranch,$uid);
        }
      
        
     
        $oldname = mysqli_real_escape_string($conn, $_POST["oldname"]);
        $oldadd = mysqli_real_escape_string($conn, $_POST["oldadd"]);
        $oldpin = mysqli_real_escape_string($conn, $_POST["oldpin"]);
        $oldloc = mysqli_real_escape_string($conn, $_POST["oldlocation"]);
        $oldrerano = mysqli_real_escape_string($conn, $_POST["oldrerano"]);
        $oldgst = mysqli_real_escape_string($conn, $_POST["oldgst"]);
        $oldaccno = mysqli_real_escape_string($conn, $_POST["oldaccno"]);
        $oldpanno = mysqli_real_escape_string($conn, $_POST["oldpanno"]);
        $oldifsc = mysqli_real_escape_string($conn, $_POST["oldifsc"]);
        $oldbankno = mysqli_real_escape_string($conn, $_POST["oldbankno"]);
        $oldbranch = mysqli_real_escape_string($conn, $_POST["oldbranch"]);
        $logremark = "";

        if($Cpname != $oldname){
            $logremark = $logremark . ", " . "Changed Name from $oldname => $Cpname";
        }
    
        if($Cpadd != $oldadd){
            $logremark = $logremark . ", " . "Changed Address from $oldadd => $Cpadd";
        }
        if($Cppin != $oldpin){
            $logremark = $logremark . ", " . "Changed Pincode from $oldpin => $Cppin";
        }
        if($Cploc != $oldloc){
            $logremark = $logremark . ", " . "Changed Location from $oldloc => $Cploc";
        }
        if($Cprerano != $oldrerano){
            $logremark = $logremark . ", " . "Changed Location from $oldrerano => $Cprerano";
        }
        if($Cpgst != $oldgst){
            $logremark = $logremark . ", " . "Changed Location from $oldgst => $Cpgst";
        }
        if($Cpaccno != $oldaccno){
            $logremark = $logremark . ", " . "Changed Location from $oldaccno => $Cpaccno";
        }
        if($Cppanno != $oldpanno){
            $logremark = $logremark . ", " . "Changed Location from $oldpanno => $Cppanno";
        }
        if($Cpifsc != $oldifsc){
            $logremark = $logremark . ", " . "Changed Location from $oldifsc => $Cpifsc";
        }
        if($Cpbankno != $oldbankno){
            $logremark = $logremark . ", " . "Changed Location from $oldbankno => $Cpbankno";
        }
        if($Cpbranch != $oldbranch){
            $logremark = $logremark . ", " . "Changed Location from $oldbranch => $Cpbranch";
        }
        


        if($cp != ""){
            DelAssignedCP($lid,$cp,$uid);
            AssignCP($lid,$cp,$uid);
        }
        $_SESSION["openlead"] = $lid;
        echo "update/" . $lid;

    }else if ($_POST["mode"] == "insertcsv") {
        $nolist = "";
        $nooflist = 0;
        if ($_FILES['file']['name']) {
            $filename = explode(".", $_FILES['file']['name']);
            if ($filename[1] == 'csv') {
                $handle = fopen($_FILES['file']['tmp_name'], "r");
                $index = 0;
                while ($data = fgetcsv($handle)) //handling csv file 
                // print_r($data);
                {
                    if ($index > 0) {
                        $date = mysqli_real_escape_string($conn, $data[0]);
                        $name = mysqli_real_escape_string($conn, $data[1]);
                        $mob = mysqli_real_escape_string($conn, $data[2]);
                        $email = mysqli_real_escape_string($conn, $data[3]);
                        $loc = mysqli_real_escape_string($conn, $data[4]);
                        $project = mysqli_real_escape_string($conn, $data[5]);
                        $int = mysqli_real_escape_string($conn, $data[6]);
                        $src = mysqli_real_escape_string($conn, $data[7]);
                        $lstatus = mysqli_real_escape_string($conn, $data[8]);
                        $ref = mysqli_real_escape_string($conn, $data[9]);
                        $bud = mysqli_real_escape_string($conn, $data[10]);
                        $remark = mysqli_real_escape_string($conn, $data[11]);
                        //insert data from CSV file 

                        $dualmob = explode('/', $mob);

                        foreach ($dualmob as $i => $key) {
                            $chk = checkMobBulkInsert($key);
                            if ($chk == "false") {
                                break;
                            }
                        }

                        //$chk = checkMob($mob);

                        if ($chk == "true") {
                            if ($date != ""){
                                $date = (date('Y-m-d', strtotime($date)));
                                $lstatus = ($lstatus != "" ? $lstatus : 1);
                                if($project != ""){
                                    $pr = getProjectById($project);
                                }
                                else{
                                    $pr = "";
                                }
                                if($bud != ""){
                                    $bd = getBudgetById($bud);
                                }
                                else{
                                    $bd = "";
                                }
                                $rno="";
                                $remak = $remark . " | " . ($pr != "" ? $pr["Pr_Name"] : $pr ) . " , " . ($bd != "" ? $bd["Bd_Name"] : $bd);
                                if (count($dualmob) > 1) {
                                    $lid = insertLead($name,$rno, $dualmob[0], $dualmob[1], $email, $ref, "", "", "", $loc, $project, $int, $src, $lstatus, $date,1,$bud,$remak,1,$uid);

                                } else {
                                    $lid = insertLead($name,$rno, $dualmob[0], "", $email, $ref, "", "", "", $loc, $project, $int, $src, $lstatus, $date, 1,$bud,$remak,1,$uid);
                                    // function insertLead($name, $mob, $altmob, $email, $ref, $add, $city, $pin, $loc, $project, $intin, $source, $lstatus, $ldate, $assigned, $budget, $remark,$leadtype, $uid)

                                }

    
                                AssignLead($lid, $uid, $team, 0);
                                

                                $nooflist = $nooflist + 1;
                            }
                            
                        } else {
                            if($project != ""){
                                $pr = getProjectById($project);
                            }
                            else{
                                $pr = "";
                            }
                            if($bud != ""){
                                $bd = getBudgetById($bud);
                            }
                            else{
                                $bd = "";
                            }
                            $ldd = getleadbyMobNo($dualmob[0],"");
                            $ldd = $ldd->fetch_assoc();

                            $remak = $ldd["Ld_Remark"];
                            $ldid = $ldd["Ld_Id"];
                            $remak = $remak . " | " . $remark . " | " . ($pr != "" ? $pr["Pr_Name"] : $pr ) . " , " . ($bd != "" ? $bd["Bd_Name"] : $bd);
                            insertAdminCall($ldid, $remak, $uid);
                            MarkNewUpdateLead($ldid, $uid);
                            if($usertype == 2){
                                $salesid = checksalesassign($ldid);
                                  $assigndsales = $salesid->num_rows;
                                if($assigndsales == 0){
                                    AssignLead($ldid, $uid, $team, 0);
                                }
                            }
                            $nolist = $nolist . "$name,$mob<br/>";
                        }
                    }


                    $index = $index + 1;

                }

                fclose($handle);
                if ($nolist == "") {
                    $nolist = "No Duplicate Records Found";
                }
                echo $nooflist . "#" . $nolist;
            }
        }
    } else if ($_POST["mode"] == "insertsourcecsv") {
        $nolist = "";
        $nooflist = 0;
        if ($_FILES['file']['name']) {
            $filename = explode(".", $_FILES['file']['name']);
            if ($filename[1] == 'csv') {
                $handle = fopen($_FILES['file']['tmp_name'], "r");
                $index = 0;
                while ($data = fgetcsv($handle)) //handling csv file 
                //  print_r($data);
                {
                    if ($index > 0) {
                        // echo "came";
                        $date = mysqli_real_escape_string($conn, $data[0]);
                        $name = mysqli_real_escape_string($conn, $data[1]);
                        $mob = mysqli_real_escape_string($conn, $data[2]);
                        $email = mysqli_real_escape_string($conn, $data[3]);
                        $loc = mysqli_real_escape_string($conn, $data[4]);
                        $project = mysqli_real_escape_string($conn, $data[5]);
                        $src = mysqli_real_escape_string($conn, $data[6]);
                        $lstatus = mysqli_real_escape_string($conn, $data[7]);
                        $ref = mysqli_real_escape_string($conn, $data[8]);
                        $remark = mysqli_real_escape_string($conn, $data[9]);
            
                        //insert data from CSV file 

                        $dualmob = explode('/', $mob);

                        foreach ($dualmob as $i => $key) {
                            $chk = checkMobBulkInsert($key);
                            if ($chk == "false") {
                                break;
                            }
                        }

                        //$chk = checkMob($mob);

                        if ($chk == "true") {
                            // echo "came here";
                            if ($date != ""){
                                $date = (date('Y-m-d', strtotime($date)));
                                $lstatus = ($lstatus != "" ? $lstatus : 1);
                                if($project != ""){
                                    $pr = getProjectById($project);
                                }
                                else{
                                    $pr = "";
                                }
                                
                                $remak = $remark . " | " . ($pr != "" ? $pr["Pr_Name"] : $pr );
                                if (count($dualmob) > 1) {
                                    // echo "came";
                                    $lid = insertSouringcLead($name, $dualmob[0], $dualmob[1], $email, $ref, "", "", "", "",$loc, $project,$src, $lstatus,"","", $date,$remak,2,1,$uid);
                                } else {
                                    $lid = insertSouringcLead($name, $dualmob[0],"", $email, $ref, "", "", "", "",$loc, $project,$src, $lstatus,"","", $date,$remak,2,1,$uid);
                                }
    
    
                                AssignLead($lid, $uid, $team, 0);
                                

                                $nooflist = $nooflist + 1;
                            }
                            
                        } else {
                            if($project != ""){
                                $pr = getProjectById($project);
                            }
                            else{
                                $pr = "";
                            }
                           
                            $ldd = getleadbyMobNo($dualmob[0],"");
                            $ldd = $ldd->fetch_assoc();

                            $remak = $ldd["Ld_Remark"];
                            $ldid = $ldd["Ld_Id"];
                            $remak = $remak . " | " . $remark . " | " . ($pr != "" ? $pr["Pr_Name"] : $pr );
                            insertAdminCall($ldid, $remak, $uid);
                            MarkNewUpdateLead($ldid, $uid);
                            if($usertype == 2){
                                $salesid = checksalesassignsourcelead($ldid);
                                  $assigndsales = $salesid->num_rows;
                                if($assigndsales == 0){
                                    AssignLead($ldid, $uid, $team, 0);
                                }
                            }
                            $nolist = $nolist . "$name,$mob<br/>";
                        }
                    }


                    $index = $index + 1;

                }

                fclose($handle);
                if ($nolist == "") {
                    $nolist = "No Duplicate Records Found";
                }
                echo $nooflist . "#" . $nolist;
            }
        }
    }else if ($_POST["mode"] == "insertcsvadmin") {
        
        $msg = "";
        $type = mysqli_real_escape_string($conn, $_POST["type"]);
        $typeid = mysqli_real_escape_string($conn, $_POST["typeid"]);


        
        $ldcount = 0;
        

        $ldids = "";
        if ($type == "auto") {
            $callers = getActiveCallersList();
            $callercounts = $callers->num_rows;
            //echo $callercounts;
            if ($callercounts > 0) {
                insertleadfromadmin();
                $ldcount = getAssignLeadzeroCount();
                $breakcount = floor((float) $ldcount / (int) $callercounts);
                $cntusr = 0;
                while ($u = $callers->fetch_assoc()) {
                    $cntusr = $cntusr + 1;
                    $offset = $breakcount * $cntusr;
                    if ($cntusr == $callercounts) {
                        $ldqry = "SELECT Ld_Id FROM tbl_lead WHERE Ld_Assigned = 0";
                        $ldids = $conn->query($ldqry);
                    } else {
                        $ldqry = "SELECT Ld_Id FROM tbl_lead WHERE Ld_Assigned = 0 LIMIT 0, $breakcount";
                        $ldids = $conn->query($ldqry);
                    }

                    while ($ld = $ldids->fetch_assoc()) {
                        AssignLeadFromAdmin($ld["Ld_Id"], $u["U_Id"], $u["Tm_Id"]);
                        updateLeadAssigned($ld["Ld_Id"]);
                    }

                }
            }
            else{
                $ldqry = "DELETE FROM tbl_lead WHERE Ld_Assigned = 0";
                $ldids = $conn->query($ldqry);
                echo "nousers";
                return;
            }

        } else if ($type == "touser") {
            insertleadfromadmin();
            $t = getUserTeam($typeid);
            $ldqry = "SELECT Ld_Id FROM tbl_lead WHERE Ld_Assigned = 0";
            $ldids = $conn->query($ldqry);
            while ($ld = $ldids->fetch_assoc()) {
                AssignLeadFromAdmin($ld["Ld_Id"], $typeid, $t["Tm_Id"]);
                updateLeadAssigned($ld["Ld_Id"]);
            }
        } else if ($type == "toteam") {
            $callers = getMemberByTeam($typeid);
            $callercounts = $callers->num_rows;

            if ($callercounts > 0) {
                insertleadfromadmin();
                $ldcount = getAssignLeadzeroCount();
                $breakcount = floor((float) $ldcount / (int) $callercounts);
                $cntusr = 0;
                while ($u = $callers->fetch_assoc()) {
                    $cntusr = $cntusr + 1;
                    $offset = $breakcount * $cntusr;
                    if ($cntusr == $callercounts) {
                        $ldqry = "SELECT Ld_Id FROM tbl_lead WHERE Ld_Assigned = 0";
                        $ldids = $conn->query($ldqry);
                    } else {
                        $ldqry = "SELECT Ld_Id FROM tbl_lead WHERE Ld_Assigned = 0 LIMIT 0, $breakcount";
                        $ldids = $conn->query($ldqry);
                    }


                    while ($ld = $ldids->fetch_assoc()) {
                        AssignLeadFromAdmin($ld["Ld_Id"], $u["MemberId"], $u["TeamId"]);
                        updateLeadAssigned($ld["Ld_Id"]);
                    }

                }
            }
            else{
                $ldqry = "DELETE FROM tbl_lead WHERE Ld_Assigned = 0";
                $ldids = $conn->query($ldqry);
                echo "nousers";
                return;
            }

        } else if ($type == "byproject") {
            $callers = getMemberByProject($typeid);
            $callercounts = $callers->num_rows;

            if ($callercounts > 0) {
                insertleadfromadmin();
                $ldcount = getAssignLeadzeroCount();
                
                $breakcount = floor((float) $ldcount / (int) $callercounts);
                
                $cntusr = 0;
                while ($u = $callers->fetch_assoc()) {
                    $cntusr = $cntusr + 1;
                    $offset = $breakcount * $cntusr;
                    // if($cntusr == 1){
                    //     $ldqry = "SELECT Ld_Id FROM tbl_lead WHERE Ld_Assigned = 0 LIMIT 0, $breakcount";
                    //     $ldids = $conn->query($ldqry);    
                    // }
                    // else if($cntusr == $callercounts){
                    //     $ldqry = "SELECT Ld_Id FROM tbl_lead WHERE Ld_Assigned = 0 LIMIT $breakcount, ". ((int)$breakcount * 2);
                    //     $ldids = $conn->query($ldqry);    
                    // }
                    // else{
                    //     $ldqry = "SELECT Ld_Id FROM tbl_lead WHERE Ld_Assigned = 0 LIMIT $offset, $breakcount";
                    //     $ldids = $conn->query($ldqry);
                    // }
                    if ($cntusr == $callercounts) {
                        $ldqry = "SELECT Ld_Id FROM tbl_lead WHERE Ld_Assigned = 0";
                        
                        $ldids = $conn->query($ldqry);
                    } else {
                        $ldqry = "SELECT Ld_Id FROM tbl_lead WHERE Ld_Assigned = 0 LIMIT 0, $breakcount";
                        
                        $ldids = $conn->query($ldqry);
                    }



                    while ($ld = $ldids->fetch_assoc()) {
                        AssignLeadFromAdmin($ld["Ld_Id"], $u["U_Id"], $u["Tm_Id"]);
                        updateLeadAssigned($ld["Ld_Id"]);
                    }

                }
            }
            else{
                $ldqry = "DELETE FROM tbl_lead WHERE Ld_Assigned = 0";
                $ldids = $conn->query($ldqry);
                echo "nousers";
                return;
            }
        }

        echo $msg;

    }
    else if($_POST["mode"] == "claimlead"){
        $leadid = mysqli_real_escape_string($conn, $_POST["lid"]);

        $res = claimLead($leadid,$uid, $team);

        if($res > 0){
            echo "true";
        }
        else{
            echo "false";
        }
    }

    else if($_POST["mode"] == "setjunk"){
        $leadid = mysqli_real_escape_string($conn, $_POST["leadid"]);

        $res = updateStatus($leadid, 8, $uid);

        if($res > 0){
            echo "true";
        }
        else{
            echo "false";
        }
    }



} else if ($_SERVER['REQUEST_METHOD'] == "GET") {

}


function insertleadfromadmin(){
    $nolist = "";
    $nooflist = 0;
    $connn = dbconnect();
    $uid = $_SESSION["UId"];
    // $team = @$_SESSION["Team"][0]->Tm_Id;
    if ($_FILES['file']['name']) {
        $filename = explode(".", $_FILES['file']['name']);
        if ($filename[1] == 'csv') {
            $handle = fopen($_FILES['file']['tmp_name'], "r");
            $index = 0;
            while ($data = fgetcsv($handle)) //handling csv file 
            {
                if ($index > 0) {
                    $date = mysqli_real_escape_string($connn, $data[0]);
                    $name = mysqli_real_escape_string($connn, $data[1]);
                    $mob = mysqli_real_escape_string($connn, $data[2]);
                    $email = mysqli_real_escape_string($connn, $data[3]);
                    $loc = mysqli_real_escape_string($connn, $data[4]);
                    $project = mysqli_real_escape_string($connn, $data[5]);
                    $int = mysqli_real_escape_string($connn, $data[6]);
                    $src = mysqli_real_escape_string($connn, $data[7]);
                    $lstatus = mysqli_real_escape_string($connn, $data[8]);
                    $ref = mysqli_real_escape_string($connn, $data[9]);
                    $bud = mysqli_real_escape_string($connn, $data[10]);
                    $remark = mysqli_real_escape_string($connn, $data[11]);
                    //insert data from CSV file 

                    $dualmob = explode('/', $mob);

                    foreach ($dualmob as $i => $key) {
                        $chk = checkMobBulkInsert($key);
                        if ($chk == "false") {
                            break;
                        }
                    }

                    //$chk = checkMob($mob);

                    if ($chk == "true") {
                        if ($date != "") {
                            $date = (date('Y-m-d', strtotime($date)));
                            $lstatus = ($lstatus != "" ? $lstatus : 1);
                            if($project != ""){
                                $pr = getProjectById($project);
                            }
                            else{
                                $pr = "";
                            }
                            if($bud != ""){
                                $bd = getBudgetById($bud);
                            }
                            else{
                                $bd = "";
                            }

                            $rno="";

                            $remak = $remark . " | " . ($pr != "" ? $pr["Pr_Name"] : $pr ) . " , " . ($bd != "" ? $bd["Bd_Name"] : $bd);
                            if (count($dualmob) > 1) {
                                $lid = insertLead($name,$rno, $dualmob[0], $dualmob[1], $email, $ref, "", "", "", $loc, $project, $int, $src, $lstatus, $date, 0, $bud,$remak,1,$uid);
                               
                            } else {
                                $lid = insertLead($name,$rno, $dualmob[0], "", $email, $ref, "", "", "", $loc, $project, $int, $src, $lstatus, $date, 0, $bud,$remak,1, $uid);

                            }

                            $nooflist = $nooflist + 1;
                        }

                    } else {
                        if($project != ""){
                            $pr = getProjectById($project);
                        }
                        else{
                            $pr = "";
                        }
                        if($bud != ""){
                            $bd = getBudgetById($bud);
                        }
                        else{
                            $bd = "";
                        }
                        
                        $ldd = "";
                        foreach ($dualmob as $i => $key) {
                        	$ldd = getleadbyMobNo($key,"");
                        	if ($ldd->num_rows > 0) {
                            	break;
                        	}
                    	}
                        $ldd = $ldd->fetch_assoc();

                        $remak = $ldd["Ld_Remark"];
                        $ldid = $ldd["Ld_Id"];
                        $remak = $remak . " | " . $remark . " | " . ($pr != "" ? $pr["Pr_Name"] : $pr ) . " , " . ($bd != "" ? $bd["Bd_Name"] : $bd);
                        insertAdminCall($ldid, $remak, $uid);
                        MarkNewUpdateLead($ldid, $uid);
                        $nolist = $nolist . "$name,$mob<br/>";
                    }
                }

                $index = $index + 1;

            }

            fclose($handle);
            if ($nolist == "") {
                $nolist = "No Duplicate Records Found";
            }
            echo $nooflist . "#" . $nolist;
        }
    }
}




?>