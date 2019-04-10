<?php
if($_POST['ajx']==1){
if($page == 'cs-connect'){
        if($_SESSION['FUSERTYPE']=='Student'){
            $returnArr['ws']        =  $SOCKET_URI;
            $returnArr['me']        =  $_SESSION['FUSERFULLNAME'];
            $returnArr['publicId']  =  $_SESSION['PUBLICID'];
            $returnArr['myDP']      =  $_SESSION['DPURL'];
            echo json_encode($returnArr);
        }
    }
    elseif($page == 'message'){
        $fData      = $eObj -> getMemberByprofileId($track);
        $checkBlock = $eObj -> isBlocked($_SESSION['FUSERID'], $fData['id']);
        
        if(!$checkBlock){
            $friend['member'] = json_encode(array(
                                    'publicId'      => $track, 
                                    'fullname'      => $fData['fullname'], 
                                    'profilePic'    => $fData['profilePic'], 
                                    'gender'        => $fData['gender']
                                ));
            
            $friend['thread'] = $eObj -> chatIndividual($_SESSION['FUSERID'], $fData['id'], 1, 0, 30);
            
            echo json_encode($friend);
        }
        else
            echo "error>Blocked";
    }
    elseif($page == 'addproductType' || $page == 'addproduct' || $page == 'editproduct' || $page == 'viewProduct' || $page == 'deleteProduct' || $page == 'category' || $page == 'previewProduct'|| $page == 'company'){
       include($ROOT_PATH."/modules/dashboard/seller/addproduct.php"); 
    }
    elseif($page == 'addaddress' || $page == 'editaddress' || $page == 'deleteadd' || $page == 'showsidebar'){
       include($ROOT_PATH."/modules/dashboard/seller/addaddress.php"); 
    }
    elseif($page == 'addsample' || $page == 'editSample' || $page == 'viewSample' || $page == 'deleteSample' || $page == 'addqty' || $page == 'sendSample' || $page == 'viewhistory'){
       include($ROOT_PATH."/modules/dashboard/seller/addsample.php"); 
    }
    elseif($page == 'viewreq' || $page == 'deletereq' ){
       include($ROOT_PATH."/modules/dashboard/seller/viewrequirement.php"); 
    }
     elseif($page == 'viewmsz'|| $page == 'replymsz' || $page = 'mszDelete' ){
       include($ROOT_PATH."/modules/dashboard/seller/viewmsz.php"); 
    }
    elseif($page == 'viewsamplereq' || $page == 'deleteSmReq'){
       include($ROOT_PATH."/modules/dashboard/seller/viewsamplerequirement.php"); 
    }
    elseif($page == 'addcompany'){
       include($ROOT_PATH."/modules/dashboard/seller/company.php"); 
    }
    elseif($tab){
        if($page == 'study-material')
            $_SESSION['STUDY_TAB'] = $tab;
        elseif($page == 'social-media')
            $_SESSION['SOCIAL_TAB'] = $tab;
        elseif($page == 'my-favourites')
            $_SESSION['FAVOURITE_TAB'] = $tab;
        
        $ldfile                 = $tab.'.php';
        include($ROOT_PATH."/modules/dashboard/student/ajxload/".$ldfile);
    }

    
}
elseif($dtaction=='compProduct'){     
    if($rdVal){
        
        $mbObj      = new MemberView();
        $rdVal      = addslashes(trim($rdVal));
        
        if($rdVal=='Product')        
            $compDt     = $mbObj->productCategory(1, 0, 9999);
        else
            $compDt     = $mbObj->productCategory(1, 0, 9999);
        
        echo json_encode($compDt);
    }
}
elseif($dtaction=='search-product'){
    if($srcTxt){
        
        $prdObj      = new adminProductClass();
        $srcTxt      = addslashes(trim($srcTxt));
    
        $ExtraQryStr = 'p_name LIKE "%'.$srcTxt.'%" AND userid='.$_SESSION['FUSERID'];
        $orderby     = 'order by p_name ASC';

        $proDat      = $prdObj->getProductByLimit($ExtraQryStr, 0, 99999);        
        
        echo json_encode($proDat);
    }
}
elseif($dtaction=='search-tomail'){
    if($srcTxt){
        
        $cntObj      = new Contact();
        $srcTxt      = addslashes(trim($srcTxt));
   
        $ExtraQryStr = 'c.name LIKE "%'.$srcTxt.'%" AND c.contactType="P" AND c.c_id='.addslashes($cid)." group by c.userId";
        $cntData     = $cntObj->getContactsByLimit($ExtraQryStr,0,99999);       
        
        echo json_encode($cntData);
    }
}
elseif($dtaction=='addnew'){
    $mObj = new MemberView();
    $samplId     = trim(addslashes($samplId),',');    
    $ExtraQryStr = "userId=".addslashes($_SESSION['FUSERID'])." and sampleId NOT IN(".addslashes($samplId).")";    
    $sampData    = $mObj->getSample($ExtraQryStr, 0, 999999);
    

    echo json_encode($sampData);
}
elseif($dtaction=='sample-qty'){
    $mObj = new MemberView();
    
    $sampleId = addslashes($sample);
    
    $smpleQty=$mObj->sampleQtyById($sampleId);  
    
    echo $smpleQty['totalQty'];
    //echo json_encode($sampData);
}
elseif($dtaction=='category-attribute'){
    if($pid){
        $categoryId=$cid;
        include($ROOT_PATH.'/'.MODULE_PATH.'/dashboard/seller/category-ajax.php');    
        /*$cntObj      = new Contact();
        $srcTxt      = addslashes(trim($srcTxt));
   
        $ExtraQryStr = 'c.name LIKE "%'.$srcTxt.'%" AND c.contactType="P" AND c.c_id='.addslashes($cid)." group by c.userId";
        $cntData     = $cntObj->getContactsByLimit($ExtraQryStr,0,99999);       
        
        echo json_encode($cntData);*/
    }
}

?>