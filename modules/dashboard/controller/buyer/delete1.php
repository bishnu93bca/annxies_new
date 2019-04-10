<?php
echo "sdsdff";die;
//echo $editid;die;

if($id!='')
{
	$cObj = new MemberAdmin();
	            
                $fetch_Existing_Lg = $cObj->getMemberInfoByid($id);

                if($fetch_Existing_Lg['profilePic'])
                {
                    @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['profilePic']);
                    @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['profilePic']);
                    @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['profilePic']);
                }
           
                $params = array();
                $params['profilePic'] = "";
                $cObj->memberUpdateById($params, $id);


    
}
$decodedStr = base64_decode($redstr);
?>
<script language="javascript">
	window.location = 'index.php?<?php echo $decodedStr?>';
</script>