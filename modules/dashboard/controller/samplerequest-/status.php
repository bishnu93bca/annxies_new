<?php
if($id!='')
{
	$obj = new Contact;
    $params = array();
    $params['status']=$stschgto;
    $obj->contactUpdateBycontactId($params, $id);
	$decodedStr = base64_decode($redstr);	
	?>
	<script language="javascript">window.location = 'index.php?<?php echo $decodedStr?>';</script>
	<?php
}
?>