<?php
if($id!='')
{
    $mObj = new MemberAdmin();
    $target_path    = $MEDIA_FILES_ROOT."/package";
			
	if($action=='content')
	{ 
		$cObj = new Content;
		$cObj->deleteContentByid($id);
	}    
	elseif($action=='packageImage')
	{
		$idToDelete = explode("@", $id);
		foreach($idToDelete as $val)
		{
			$data           = $mObj->getPackageInfoByid($val);
			if($data)
			{
				@unlink($target_path.'/normal/'.$data['image']);
				@unlink($target_path.'/thumb/'.$data['image']);
				@unlink($target_path.'/large/'.$data['image']);
				$params = array();
				$params['image'] = '';
				$mObj->packageUpdateById($params, $val);
			}
		}
	}
	else
	{
	    $idToDelete = explode("@", $id);
		foreach($idToDelete as $val)
		{
            $data           = $mObj->getPackageInfoByid($val);
			if($data['image'])
			{
				@unlink($target_path.'/normal/'.$data['image']);
				@unlink($target_path.'/thumb/'.$data['image']);
				@unlink($target_path.'/large/'.$data['image']);
            }
		    $mObj->deletePackage($val);
		}
	}
}
$decodedStr = base64_decode($redstr);
?>
<script language="javascript">
window.location = 'index.php?<?php echo $decodedStr?>';
</script>
