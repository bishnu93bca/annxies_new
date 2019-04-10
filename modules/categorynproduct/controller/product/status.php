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
    elseif($action=='galImage')
    {
        $idToChange = explode("@", $id);
        $obj = new adminProductClass;
        foreach($idToChange as $val)
        {
            $params = array();
            $params['status'] = $stschgto;
            $obj->galleryUpdateBygalleryId($params, $val);
        }
    }
    elseif($action=='proVid')
    {
        $idToChange = explode("@", $id);
        $obj = new adminProductClass;
        foreach($idToChange as $val)
        {
            $params = array();
            $params['status'] = $stschgto;
            $obj->VideoUpdateByvidId($params, $val);
        }
    }
    else
    {
        $idToChange = explode("@", $id);
        $obj = new adminProductClass;
        foreach($idToChange as $val)
        {
            $params = array();
            $params['status'] = $stschgto;
            $obj->productUpdateByproductId($params, $val);
        }
    }
    
	$decodedStr = base64_decode($redstr);	
	?>
	<script language="javascript">
	window.location = 'index.php?<?php echo $decodedStr?>';
	</script>	
	<?php
}/*

if($dtaction=='content')
{
    $obj = new adminProductClass;
	$idToChange = explode("@", $id);
	foreach($idToChange as $val)
	{
        $params = array();
        $params['status'] = $stschgto;
        $obj->productUpdateByproductId($params, $val);
	}
	$decodedStr = base64_decode($redstr);	
	?>
	<script language="javascript">
	window.location = 'index.php?<?php echo $decodedStr?>';
	</script>	
	<?php
}
elseif($id!='' && $statusaction!='yes')
{
    $obj = new adminProductClass;
	$idToChange = explode("@", $id);
	foreach($idToChange as $val)
	{
        $params = array();
        $params['status'] = $stschgto;
        $obj->productUpdateByproductId($params, $val);
	}
	$decodedStr = base64_decode($redstr);	
	?>
	<script language="javascript">
	window.location = 'index.php?<?php echo $decodedStr?>';
	</script>	
	<?php
}
elseif($id!='' && $action=='content')
{
    $obj = new Content;
	$idToChange = explode("@", $id);
	foreach($idToChange as $val)
	{
        $params = array();
        $params['status'] = $stschgto;
        $obj->contentUpdateBycontentID($params, $val);
	}
	$decodedStr = base64_decode($redstr);	
	?>
	<script language="javascript">
	window.location = 'index.php?<?php echo $decodedStr?>';
	</script>	
	<?php
}
elseif($id!='' && $rwvaction=='yes')
{
	$obj = new adminProductClass;
	$params = array();
	$params['status'] = $stschgto;
    $proData = $obj -> reviewUpdateByreviewId($params, $id);
    $decodedStr = base64_decode($redstr);
    ?>
	<script language="javascript">	
		window.location = 'index.php?<?php echo $decodedStr.'&galErrorMsg='.$galErrorMsg;?>';
	</script>	
	<?php
}
elseif($id!='' && $statusaction=='yes')
{
    $obj = new adminProductClass;
    $proData = $obj -> productById($productId);
	$idToChange = explode("@", $id);
	foreach($idToChange as $val)
	{
        $fetch_ImgDtls = $obj->galleryBygalleryId($val);
        if($proData['productImage']!=$fetch_ImgDtls['galleryImage']){
            if($val){
                $params = array();
                $params['status'] = $stschgto;
                $obj->galleryUpdateBygalleryId($params, $val);
            }
            $galErrorMsg = '';
        }
        else
            $galErrorMsg = '<div class="error">Service Main Image can not be deleted or edited!</div>';
	}
	$decodedStr = base64_decode($redstr);
	?>	
	<script language="javascript">	
	window.location = 'index.php?<?php echo $decodedStr.'&galErrorMsg='.$galErrorMsg;?>';
	</script>	
	<?php 
}*/
?>