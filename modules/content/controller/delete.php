<?php
if($action=='video')
{
	if($id!='')
	{
        $cmsObj = new Content;
		$idToDelete = explode("@", $id);
		foreach($idToDelete as $val)
		{
            $cmsObj->deleteGalleryByid($val);
		}
	}
}

if($action=='gallery')
{
	if($id!='')
	{
        $cmsObj = new Content;
		$idToDelete = explode("@", $id);
		foreach($idToDelete as $val)
		{
            $cmsObj->deleteGalleryByid($val);
		}
	}
}

if($action=='banner')
{
	if($id!='')
	{	
        $mcObj = new MenuCategory;
		$fetch_Existing_Lg = $mcObj->categoryById($id);
		
		if($fetch_Existing_Lg['imagepath'])
		{
			@unlink($MEDIA_FILES_ROOT.'/menu/normal/'.$fetch_Existing_Lg['imagepath']);			
		}

        $params = array();
        $params['categoryImage'] = '';
        $mcObj->categoryUpdateBycategoryId($params, $id);
	}
}

if($action=='content')
{
	if($id!='')
	{
        $cmsObj = new Content;
		$idToDelete = explode("@", $id);
        $imgData = $cmsObj->getContentBycontentID($id);
		foreach($idToDelete as $val)
		{
            if($imgData['ImageName'])
            {
                @unlink($MEDIA_FILES_ROOT.'/menu/normal/'.$imgData['ImageName']);		@unlink($MEDIA_FILES_ROOT.'/menu/large/'.$imgData['ImageName']);		
                @unlink($MEDIA_FILES_ROOT.'/menu/thumb/'.$imgData['ImageName']);		
                
            }
            $cmsObj->deleteContentByid($val);
		}
	}
}
$decodedStr = base64_decode($redstr);
?>
<script language="javascript">
window.location = 'index.php?<?php echo $decodedStr?>';
</script>