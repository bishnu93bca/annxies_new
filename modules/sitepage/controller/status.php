<?php
if($id!='')
{
	$menuObj = new MenuCategory;
    if($tmchgto!='')
	{	
		$idToChange = explode("@", $id);
		foreach($idToChange as $val)
		{
            $params = array();
            $params['isTopMenu'] = $tmchgto;
            $menuObj->categoryUpdateBycategoryId($params, $val);
		}
	}
	
	if($cntchgto!='')
	{
		$idToChange = explode("@", $id);
		foreach($idToChange as $val)
		{
            $params = array();
            $params['isContent'] = $cntchgto;
            $menuObj->categoryUpdateBycategoryId($params, $val);
		}
	}
	
	if($glrchgto!='')
	{
		$idToChange = explode("@", $id);
		foreach($idToChange as $val)
		{
            $params = array();
            $params['isGallery'] = $glrchgto;
            $menuObj->categoryUpdateBycategoryId($params, $val);
		}
	}
	
	if($vidchgto!='')
	{
		$idToChange = explode("@", $id);
		foreach($idToChange as $val)
		{
            $params = array();
            $params['isVideo'] = $vidchgto;
            $menuObj->categoryUpdateBycategoryId($params, $val);
		}
	}
	
	if($stschgto!='')
	{
		$idToChange = explode("@", $id);
		foreach($idToChange as $val)
		{
            $params = array();
            $params['status'] = $stschgto;
            $menuObj->categoryUpdateBycategoryId($params, $val);
		}
	}
}
$decodedStr = base64_decode($redstr);
?>
<script language="javascript">
window.location = 'index.php?<?php echo $decodedStr?>';
</script>