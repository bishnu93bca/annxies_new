<?php
if($id!='')
{
    $obj = new PageTitle;
	$idToDelete = explode("@", $id);
	foreach($idToDelete as $val)
	{
		if($action=="canonicaldelete")
            $obj->deleteCanonicalById($val);	
		else 
			$obj->deleteTitleMetaById($val);
	}
	$decodedStr = base64_decode($redstr);	
	?>
	<script language="javascript">
	window.location = 'index.php?<?php echo $decodedStr?>';
	</script>
	<?php
}
?>