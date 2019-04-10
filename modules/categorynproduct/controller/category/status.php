<?php
if($id!='')
{
	$idToChange = explode("@", $id);
    $obj = new adminCategory;
	foreach($idToChange as $val)
	{
        $params = array();
        $params['status'] = $stschgto;
        $obj->categoryUpdateBycategoryId($params, $val);
	}
}
$decodedStr = base64_decode($redstr);	
?>
<script language="javascript">
window.location = 'index.php?<?php echo $decodedStr?>';
</script>