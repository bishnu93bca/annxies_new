<?php
$obj= new PostClass();

if($id!='')
{
	if($action=='content')
	{
		$cObj = new Content;
		$params = array();
		$params['contentStatus'] = $stschgto;
		$cObj->contentUpdateBycontentID($params, $id);
	}
	else
	{
		$idToChange = explode("@", $id);
		foreach($idToChange as $val)
		{
	        $params = array();
	        if($isApprovedchgto)
	            $params['isApproved'] = $isApprovedchgto;
	        else
	            $params['status'] = $stschgto;
	        
	        $update = $obj ->blogUpdateByblogId($params, $val);
		}
	}
}
$decodedStr = base64_decode($redstr);	
?>
<script language="javascript">
window.location = 'index.php?<?php echo $decodedStr?>';
</script>