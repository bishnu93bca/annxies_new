<?php
if($id!='')
{
    $gcObj = new GalleryClass;
	$idToChange = explode("@", $id);
	foreach($idToChange as $val)
	{
		if($val){
            $params = array();
            $params['status'] = $stschgto;
            $gcObj->galleryUpdateByid($params, $val);
        }
	}
}
$decodedStr = base64_decode($redstr);	
?>
<script language="javascript">
window.location = 'index.php?<?php echo $decodedStr?>';
</script>