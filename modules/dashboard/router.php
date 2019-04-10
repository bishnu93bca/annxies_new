<?php
if($dtls=='profile'){
    $memberData = $eObj->getMemberByprofileId($dtaction);
    if($memberData){
        $publicProfile = 1;
        include("seller/home.php");
    }
    else
        $siteObj -> redirectTo404($SITE_LOC_PATH);
}
elseif($dtaction=='samplecontractsign'){
    include 'login.php';    
}
elseif($dtaction=='logout'){
    $eObj->logout($SITE_LOC_PATH.'/login/');
}   
elseif($pageType=='dashboard' || ($pageTypeArray[0] == 'dashboard' && ($dtls=='message' || $dtls=='group' || $dtls=='post'))) {
    if($_SESSION['FUSERTYPE']=='Seller')
        include ('seller/home.php');
    else
        $siteObj -> redirectTo404($SITE_LOC_PATH);
}
elseif($pageType=='request')
    include('json/request.php');
else
   $siteObj -> redirectTo404($SITE_LOC_PATH);
?>