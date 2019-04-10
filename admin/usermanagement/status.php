<?php
if($id!='')
{
	$idToChange = explode("@", $id);
	$siteIdToChange = explode("@", $siteId);
	$uObj = new user;
	foreach($idToChange as $key=>$val)
	{
        $uObj->user_status_update($val, $stschgto);
	}
    
	foreach($siteIdToChange as $key=>$val)
	{
        $uObj->site_status_update($val, $stschgto);
	}
}
?>
<script language="javascript">
window.location = 'index.php?pageType=<?php echo $pageType;?>';
</script>