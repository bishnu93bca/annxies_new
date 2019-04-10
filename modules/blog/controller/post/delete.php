<?php
$obj= new PostClass();

if($id!='')
{
	if($action=='content')
	{
		$cObj = new Content;
		$cObj->deleteContentByid($id);
	}
	else 
	{
		$idToDelete = explode("@", $id);
		foreach($idToDelete as $val)
		{
			$target_path = $MEDIA_FILES_ROOT."/blog";
	        
	        $data=$obj->blogById($val);
			
			@unlink($target_path.'/normal/'.$data['blogImage']);	
			@unlink($target_path.'/thumb/'.$data['blogImage']);
			@unlink($target_path.'/large/'.$data['blogImage']);
			$delete=$obj->deleteBolgByblogId($val);	
		}
	}
}
$decodedStr = base64_decode($redstr);	
?>
<script language="javascript">
window.location = 'index.php?<?php echo $decodedStr?>';
</script>