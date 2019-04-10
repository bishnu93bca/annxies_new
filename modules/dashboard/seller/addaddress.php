<?php
if($page=='editaddress')
    echo $eObj->editaddress($_SESSION['FUSERID'],$pId);
elseif($page=='deleteadd')
    echo $eObj->deleteAddressById($pid);
elseif($page=='showsidebar'){
    
    if($sidebar=='N')
        $sidebar = 'Y';
    else
        $sidebar = 'N';
    
    $params = array();
    $params['sideBar'] = $sidebar;
    $eObj->addUpdateByaddressId($params, $addId);
    echo '<div class="successmsg">Address edited successfully.</div><div class="clearfix"></div>';
    
}
else
    echo $eObj->showaddress($_SESSION['FUSERID']);
?>