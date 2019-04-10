<?php
if($id!='')
{    
    $pobj       = new adminProductClass();
    $obj        = new MemberAdmin;
    
    if($action=='samstatus')
    {   
        $params           = array();
        $params['status'] = $stschgto;        
        $pobj->sampleUpdateBysampleId($params, $id);        
    }
    elseif($action=='prostatus')
    {   
        $params           = array();
        $params['status'] = $stschgto;        
        $pobj->productUpdateByproductId($params, $id);        
    }
    elseif($action=='review')
    {    
        $cnObj = new Contact();
        
        $params = array();
        $params['status'] = $stschgto;
        $cnObj->contactUpdateBycontactId($params, $id);
     
    }
    elseif($action=='bookingstatus')
    {           
        $params                = array();
        $params['isConfirmed'] = $stschgto;        
        $obj->bookingUpdateById($params, $id);        
    }
    else
    {
        $idToChange       = explode("@", $id);
        $params           = array();
        $params['status'] = $stschgto;
        $obj->sellerUpdateById($params, $id);        
    }
    
}
$decodedStr = base64_decode($redstr);
?>
<script language="javascript">window.location = 'index.php?<?php echo $decodedStr?>';</script>