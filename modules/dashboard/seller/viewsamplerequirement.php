<?php
if($page=='deleteSmReq')
    echo $eObj->deleteReqId($pid);
else
    echo $eObj->showSampleRequest($pId);
?>