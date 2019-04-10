<?php
if(!empty($id))
{
	$idToDelete = explode("@", $id);
	foreach($idToDelete as $val)
	{ 
		/*---------------------------------------------------------------------------------------------------------
		delete module and submodule
		---------------------------------------------------------------------------------------------------------*/		
		$menuObj = new menu();
        $menuObj->deleteModuleBymoduleId($val);
        $menuObj->deleteModuleByparentId($val);		
		/*---------------------------------------------------------------------------------------------------------
		set new access permission for modules.
		---------------------------------------------------------------------------------------------------------*/		
		$permission_array = explode(',',$_SESSION['PERMISSION']);
		
		$key = array_search($val,$permission_array);
		if(isset($key)){
			unset($permission_array[$key]);
		}
		$_SESSION['PERMISSION'] = implode(',',$permission_array);

        $menuObj->updateUserPermission($_SESSION['UID'], $_SESSION['PERMISSION']);
	}
}
?>
<script language="javascript">
    window.location = 'index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&parent_id=<?php echo $parent_id;?>';
</script>