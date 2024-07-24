<?php 

$baseurl="/npcrm/";   
include $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/db.php";
include $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/encrypter.php";;


function distributeLeads (){


    $conn = dbconnect();

    


    $ouqry = "SELECT * FROM `tbl_users` WHERE U_RoleId = 2 AND U_Online = 1";
    $onlineusers = $conn->query($ouqry);
    $onlineuserscount = $onlineusers->num_rows;

    $ldlistqry = "SELECT COUNT(Ld_Id) as 'ldcount' FROM tbl_lead WHERE Ld_Assigned = 0";
    $ldcount = $conn->query($ldlistqry);
    $ldcount = $ldcount->fetch_assoc();
    $ldcount = $ldcount["ldcount"];


    

    if($onlineuserscount > 0){
        $breakcount = floor((float)$ldcount / (int)$onlineuserscount);
        // echo $breakcount;

        $cntusr = 0;
        $della = "DELETE FROM `tbl_assignlead` WHERE `Al_New` = 1";
        $della = $conn->query($della);
        while($u = $onlineusers->fetch_assoc()){
            $cntusr = $cntusr + 1;
            $offset = $breakcount * $cntusr;
            if($cntusr == 1){
                $ldqry = "SELECT Ld_Id FROM tbl_lead WHERE Ld_Assigned = 0 LIMIT 0, $breakcount";
                $ldids = $conn->query($ldqry);    
            }
            else if($cntusr == $onlineuserscount){
                $ldqry = "SELECT Ld_Id FROM tbl_lead WHERE Ld_Assigned = 0 LIMIT $breakcount, ". ((int)$breakcount * 2);
                $ldids = $conn->query($ldqry);    
            }
            else{
                $ldqry = "SELECT Ld_Id FROM tbl_lead WHERE Ld_Assigned = 0 LIMIT $offset, $breakcount";
                $ldids = $conn->query($ldqry);
            }
            
            
            
            while($ld = $ldids->fetch_assoc()){
                $ldaqry = "INSERT INTO `tbl_assignlead`(`Al_CallerId`, `Al_LeadId`, `Al_New`, `Al_CreatedId`, `Al_ModifiedId`, `Al_Del`) VALUES 
                        (".$u["U_Id"].",".$ld["Ld_Id"].",1,1,1,0)";
                $ldaqry = $conn->query($ldaqry);
            }

        }
    }




    // if($onlineusers->num_rows > 0){
    //     $usercount = $onlineusers->num_rows;
    //     $onlineusers = $onlineusers->fetch_array();



    //     $leadlistqry = "SELECT * FROM tbl_lead WHERE Ld_Assigned = 0";
    //     $leadlist = $conn->query($leadlistqry);

    //     if($leadlist->num_rows > 0){
    //         $leadcount = $leadlist->num_rows;
    //         $leadlist = $leadlist->fetch_array();
            
    
    //     }
    // }

    



}
distributeLeads ();

?>