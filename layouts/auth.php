<?php

include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/commonmodel.php";



if (isset($_COOKIE["npcrm"])) {
    $log = decrypt($_COOKIE["npcrm"]);
    $log = json_decode($log, false);

    $stats = getUserStatus($log->uid);

    $_SESSION["UId"] = $log->uid;
    $_SESSION["UName"] = $log->uname;
    $_SESSION["Role"] = $log->roleid;
    $_SESSION["RoleN"] = $log->rolename;
    $_SESSION["TypeId"] = $log->typeid;
    $_SESSION["TypeName"] = $log->typename;
    $_SESSION["Status"] = $stats;
    $_SESSION["Team"] = $log->team;

    #baseurl
    $_SESSION["baseurl"]= "/npcrm/";
    
    unset($log);
}
else{
	header('Location: ' .$baseurl.'login.php');
}

?>