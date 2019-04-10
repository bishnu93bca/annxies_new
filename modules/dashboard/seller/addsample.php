<?php
if($page=='editSample' || $page=='viewSample')    
    echo $eObj->editsampleshow($_SESSION['FUSERID'],$pId,$page);
elseif($page=='deleteSample')    
    echo $eObj->deleteSampleById($pid);
elseif($page=='addqty')
    echo $eObj->showqtyadd($_SESSION['FUSERID'],$valP);
elseif($page=='sendSample')
    echo $eObj->sendQty($_SESSION['FUSERID'],$valP);
elseif($page=='viewhistory')
    echo $eObj->viewhistory($_SESSION['FUSERID'],$pId);
else
    echo $eObj->showsampleadd($_SESSION['FUSERID']);
?>