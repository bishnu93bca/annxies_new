<?php
if($id!='')
{
	$idToDelete = explode("@", $id);
    $gcObj = new GalleryClass;
	foreach($idToDelete as $val)
	{
		if($val)
		{
            $fetch_ImgDtls = $gcObj->galleryByid($val);
			if($fetch_ImgDtls)
			{				
				if(is_file($MEDIA_FILES_ROOT.'/photo/gallery/normal/'.$fetch_ImgDtls['imagepath']))
				    @unlink($MEDIA_FILES_ROOT.'/photo/gallery/normal/'.$fetch_ImgDtls['imagepath']);
				
				if(is_file($MEDIA_FILES_ROOT.'/photo/gallery/large/'.$fetch_ImgDtls['imagepath']))
				@unlink($MEDIA_FILES_ROOT.'/photo/gallery/large/'.$fetch_ImgDtls['imagepath']);
				
				if(is_file($MEDIA_FILES_ROOT.'/photo/gallery/small/'.$fetch_ImgDtls['imagepath']))
				@unlink($MEDIA_FILES_ROOT.'/photo/gallery/small/'.$fetch_ImgDtls['imagepath']);
				
				if(is_file($MEDIA_FILES_ROOT.'/photo/gallery/thumb/'.$fetch_ImgDtls['imagepath']))
				@unlink($MEDIA_FILES_ROOT.'/photo/gallery/thumb/'.$fetch_ImgDtls['imagepath']);
				
				$gcObj->deleteGalleryByid($val);
			}
		}
	}
}
$decodedStr = base64_decode($redstr);	
?>
<script language="javascript">
window.location = 'index.php?<?php echo $decodedStr?>';
</script>