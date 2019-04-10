<?php
if($id!='')
{
	if($action=='up')
	{
		$swapNo = $swapNo-1;
		if($swapNo<0)
			$swapNo =0;
		
	}
	
	if($action=='down')
		$swapNo = $swapNo+1;
		
	mysql_query("update ".TBL_GALLERY." set swapno = '".$swapNo."' where id = $id");
}
?>
<script language="javascript">
window.location = 'index.php?pageType=<?php echo $pageType;?>&editid=<?php echo $editid;?>';
</script>