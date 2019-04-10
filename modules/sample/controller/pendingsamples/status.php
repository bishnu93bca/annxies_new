<?php
if($id!='')
{
	$obj = new MemberAdmin;
    $params = array();
    $params['isApproved']=$stschgto;
    $obj->sampleUpdateBysampleId($params, $id);
	$decodedStr = base64_decode($redstr);	
	?>
	<script language="javascript">window.location = 'index.php?<?php echo $decodedStr?>';</script>
	<?php
}
?>