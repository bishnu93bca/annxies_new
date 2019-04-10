<?php
$decodedStr = base64_decode($redstr);
if($id!='')
{
    $obj = new adminProductClass;
    
    if($action=='galImage')
    {
        $idToDelete = explode("@", $id);
        foreach($idToDelete as $val)
        {
            $target_path    = $MEDIA_FILES_ROOT."/products";
            $data           = $obj->galleryBygalleryId($val);
            if($data)
            {
                @unlink($target_path.'/normal/'.$data['galleryImage']);	
                @unlink($target_path.'/thumb/'.$data['galleryImage']);
                @unlink($target_path.'/large/'.$data['galleryImage']);
                $obj->deleteGalleryBygalleryId($val);
            }
        }
    }
    else 
	{ 
		$obj     = new adminProductClass();
        $target_path     = $MEDIA_FILES_ROOT."/product";
        $pro_Details     = $obj -> productById($id);
        
        @unlink($target_path.'/normal/'.$pro_Details['p_photo']);
        @unlink($target_path.'/large/'.$pro_Details['p_photo']);
        @unlink($target_path.'/thumb/'.$pro_Details['p_photo']);
        @unlink($target_path.'/normal/'.$pro_Details['photo1']);
        @unlink($target_path.'/large/'.$pro_Details['photo1']);
        @unlink($target_path.'/thumb/'.$pro_Details['photo1']);
        @unlink($target_path.'/normal/'.$pro_Details['photo2']);
        @unlink($target_path.'/large/'.$pro_Details['photo2']);
        @unlink($target_path.'/thumb/'.$pro_Details['photo2']);
        @unlink($target_path.'/normal/'.$pro_Details['photo3']);
        @unlink($target_path.'/large/'.$pro_Details['photo3']);
        @unlink($target_path.'/thumb/'.$pro_Details['photo3']);
        @unlink($target_path.'/normal/'.$pro_Details['photo4']);
        @unlink($target_path.'/large/'.$pro_Details['photo4']);
        @unlink($target_path.'/thumb/'.$pro_Details['photo4']);
        @unlink($target_path.'/normal/'.$pro_Details['photo5']);
        @unlink($target_path.'/large/'.$pro_Details['photo5']);
        @unlink($target_path.'/thumb/'.$pro_Details['photo5']);
        
        $delete=$obj->deleteProductByproductId($id);	
	} 
}
?>
<script language="javascript">
window.location = 'index.php?<?php echo $decodedStr.'&galErrorMsg='.$galErrorMsg;?>';
</script>