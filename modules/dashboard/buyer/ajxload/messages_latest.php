<?php
$urData             = $eObj->getLatestMessages($_SESSION['FUSERID'], 0, 10);
if($urData){
    echo json_encode($urData);
}
?>