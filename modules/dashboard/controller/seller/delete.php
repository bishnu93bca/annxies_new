<?php
if($id!='')
{
	$obj     = new adminProductClass();
    if($action=='prodelete')
    {         
        $target_path     = $MEDIA_FILES_ROOT."/product";
        $pro_Details     = $obj -> productById($id);
        
        @unlink($target_path.'/normal/'.$pro_Details['p_photo']);
        @unlink($target_path.'/thumb/'.$pro_Details['photo1']);
        @unlink($target_path.'/large/'.$pro_Details['photo2']);
        @unlink($target_path.'/large/'.$pro_Details['photo3']);
        @unlink($target_path.'/large/'.$pro_Details['photo4']);
        @unlink($target_path.'/large/'.$pro_Details['photo5']);
        $delete=$obj->deleteProductByproductId($id);			
    }
    elseif($action=='review')
    {
        $cObj = new Contact;
        $idToDelete = explode("@", $id);
        foreach($idToDelete as $val)
        {
            $cObj->deleteContactByid($val);
        }
        
        $count = $cObj ->contactCount('c_id='.addslashes($c_id));
                
        $mObj  = new MemberAdmin();

        $params                     = array();
        $params['reviewCount']      = $count;

        $mObj->companyUpdateById($params, $c_id);
    }
    
}
$decodedStr = base64_decode($redstr);
?>
<script language="javascript">
	window.location = 'index.php?<?php echo $decodedStr?>';
</script>