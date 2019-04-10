<?php
if($id!='')
{
	$idToChange = explode("@", $id);
    $menuObj = new menu();
	foreach($idToChange as $val)
	{
        $params = array();                    
        $params['status'] = $stschgto;                
        $menuObj->moduleUpdateBymoduleId($params, $val);
	}
}
?>
<script language="javascript">
    window.location = 'index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&parent_id=<?php echo $parent_id;?>&id=<?php echo $id;?>';
</script>