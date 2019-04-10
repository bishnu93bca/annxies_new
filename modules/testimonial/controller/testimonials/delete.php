<?php
if($id!='')
{
	if($action=='content')
	{ 
		$cObj = new Content;
		$cObj->deleteContentByid($id);
	}
	elseif($action=='image')
	{
		$cmsObj = new Content;
		$idToDelete = explode("@", $id);
		foreach($idToDelete as $val)
		{
			$fetch_Existing_Lg = $cmsObj->getContentBycontentID($id);
			if($fetch_Existing_Lg['imageName'])
			{
				@unlink($MEDIA_FILES_ROOT.'/menu/normal/'.$fetch_Existing_Lg['imageName']);
				@unlink($MEDIA_FILES_ROOT.'/menu/thumb/'.$fetch_Existing_Lg['imageName']);
				@unlink($MEDIA_FILES_ROOT.'/menu/large/'.$fetch_Existing_Lg['imageName']);
			}
			$params = array();
			$params['imageName'] = '';
			$cmsObj->contentUpdateBycontentID($params,$val);
		}
	}
    
	elseif($action=='Testimonialimage')
	{
		$obj = new AdminTestimonial();
		$idToDelete = explode("@", $id);
		foreach($idToDelete as $val)
		{
			$target_path    = $MEDIA_FILES_ROOT."/testimonials";
			$data           = $obj->testimonialById($val);
			if($data)
			{
				@unlink($target_path.'/normal/'.$data['imageName']);
				@unlink($target_path.'/thumb/'.$data['imageName']);
				@unlink($target_path.'/large/'.$data['imageName']);
				$params = array();
				$params['imageName'] = '';
				$obj->testimonialUpdateBytestimonialId($params, $val);
			}
		}
	}
	else
	{
	    $obj = new AdminTestimonial;
		$idToDelete = explode("@", $id);
		foreach($idToDelete as $val)
		{	
            
            $fetch_Existing_Lg = $obj->getTestimonialBytestimonialId($id);
			if($fetch_Existing_Lg['imageName'])
			{
				@unlink($MEDIA_FILES_ROOT.'/testimonials/normal/'.$fetch_Existing_Lg['imageName']);
				@unlink($MEDIA_FILES_ROOT.'/testimonials/thumb/'.$fetch_Existing_Lg['imageName']);
				@unlink($MEDIA_FILES_ROOT.'/testimonials/large/'.$fetch_Existing_Lg['imageName']);
			}
			$params = array();
			$params['imageName'] = '';
            
		$obj->deleteBytestimonialId($val);
		}
	}
}
$decodedStr = base64_decode($redstr);
?>
<script language="javascript">
window.location = 'index.php?<?php echo $decodedStr?>';
</script>
