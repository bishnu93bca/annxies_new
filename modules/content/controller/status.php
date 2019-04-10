<?php
if($action=='content')
{
	if($id!='')
	{
        $cmsObj = new Content;
		$idToChange = explode("@", $id);
		foreach($idToChange as $val)
		{
            $params = array();
            $params['contentStatus'] = $stschgto;
            $cmsObj->contentUpdateBycontentID($params, $val);
		}
	}
}

if($action=='gallery' || $action=='video')
{
	if($id!='')
	{
        $gcObj = new GalleryClass;
		$idToChange = explode("@", $id);
		foreach($idToChange as $val)
		{
            $params = array();
            $params['status'] = $stschgto;
            $gcObj->galleryUpdateByid($params, $val);
		}
	}
}
$decodedStr = base64_decode($redstr);
?>
<script language="javascript">
window.location = 'index.php?<?php echo $decodedStr?>';
</script>