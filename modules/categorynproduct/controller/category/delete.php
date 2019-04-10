<?php
if($id!='')
{
    $obj = new adminCategory;
    if($action=='categoryImg')
    {
        $cData = $obj-> categoryById($id);
        if($cData['cat_image'])
        {
            @unlink($MEDIA_FILES_ROOT.'/product/normal/'.$cData['cat_image']);
            @unlink($MEDIA_FILES_ROOT.'/product/thumb/'.$cData['cat_image']);
            @unlink($MEDIA_FILES_ROOT.'/product/large/'.$cData['cat_image']);
        }
        $params = array();
        $params['cat_image'] = '';
        $obj-> categoryUpdateBycategoryId($params, $id);
    }
    else
    {
        $cData = $obj-> categoryById($id);
    
        if($cData['cat_image'])
        {
            @unlink($MEDIA_FILES_ROOT.'/product/normal/'.$cData['cat_image']);
            @unlink($MEDIA_FILES_ROOT.'/product/thumb/'.$cData['cat_image']);
            @unlink($MEDIA_FILES_ROOT.'/product/large/'.$cData['cat_image']);
        }
        $obj->deleteCategoryBycategoryId($id);
    }
}
$decodedStr = base64_decode($redstr);	
?>
<script language="javascript">
window.location = 'index.php?<?php echo $decodedStr;?>';
</script>