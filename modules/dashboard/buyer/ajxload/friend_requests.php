<?php
$requestData = $eObj->friendRequests($_SESSION['FUSERID'], 0, 30);
if($requestData){
    echo json_encode($requestData);
}
?>