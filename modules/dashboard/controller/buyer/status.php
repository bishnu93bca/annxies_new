<?php
if($id!='')
{
    if($action=='samstatus'){
        $obj = new Contact;
        $params = array();
        $params['status']=$stschgto;
        $obj->contactUpdateBycontactId($params, $id);
        
    }
    else{
        $idToChange = explode("@", $id);
        $obj = new MemberAdmin;
        foreach($idToChange as $val)
        {
            $params = array();
            $params['status'] = $stschgto;
            $obj->memberUpdateById($params, $val);
        }
    }
	
}
$decodedStr = base64_decode($redstr);
?>
<script language="javascript">window.location = 'index.php?<?php echo $decodedStr?>';</script>