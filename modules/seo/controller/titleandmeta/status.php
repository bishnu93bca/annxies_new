<?php
if($id!='')
{
	$obj = new PageTitle;
	$idToChange = explode("@", $id);
	foreach($idToChange as $val)
	{
		if($action=="canonicalstatus")
		{
            $params = array();
            $params['status'] = $stschgto;
            $obj->canonicalUpdateById($params, $val);
		}
		else 
		{
            $params = array();
            $params['status'] = $stschgto;
            $obj->titleMetaUpdateById($params, $val);
		}	
	}
	$decodedStr = base64_decode($redstr);
	?>
	<script language="javascript">
		window.location = 'index.php?<?php echo $decodedStr?>';
	</script>
	<?php
}
?>