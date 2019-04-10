<?php
if($id!='')
{
    if($action=='samdelete'){
        $obj = new Contact;
        $obj->deleteContactByid($id);
        
    }
    else
    {    
        $cObj = new MemberAdmin();

        $fetch_Existing_Lg = $cObj->getMemberInfoByid($id);
        $targetLocation = $MEDIA_FILES_ROOT."/member";

        if($fetch_Existing_Lg['profilePic'])
        {
            @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['profilePic']);
            @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['profilePic']);
            @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['profilePic']);
        }

        $params = array();
        $params['profilePic'] = "";
        $cObj->memberUpdateById($params, $id);
        //$ErrMsg = '<div class="success">Profile pic deleted successfully</div>';
        //$actionDone  = 'U'; // Update$cObj->recruiterUpdateById($params, $id);
    }
}
$decodedStr = base64_decode($redstr);
?>
<script language="javascript">
	window.location = 'index.php?<?php echo $decodedStr?>';
</script>