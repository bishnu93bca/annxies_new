<?php
$urData             = $eObj->getUnreadNotifications($_SESSION['FUSERID'], 0, 10);
if($urData){
    echo json_encode($urData);
}
?>