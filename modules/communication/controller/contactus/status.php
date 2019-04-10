<?php
if($id!='')
{
	if($action=='content')
	{
		$cObj = new Content;
        $params = array();
        $params['contentStatus'] = $stschgto;
        $cObj->contentUpdateBycontentID($params, $id);
	}
}
$decodedStr = base64_decode($redstr);

?>
<script language="javascript">
window.location = 'index.php?<?php echo $decodedStr?>';
</script>