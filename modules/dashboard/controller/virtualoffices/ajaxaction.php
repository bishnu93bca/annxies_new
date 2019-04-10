<?php
if($_POST['ajax']=='1') include ('../../../../ext_include.php');
if($action)
{
	$obj   = new MemberAdmin;    
    if($action=='delete'){
        $galData    = $obj -> galleryBygalleryId($id);
        
        @unlink($MEDIA_FILES_ROOT.'/office/normal/'.$galData['galleryImage']);
        @unlink($MEDIA_FILES_ROOT.'/office/thumb/'.$galData['galleryImage']);
        @unlink($MEDIA_FILES_ROOT.'/office/large/'.$galData['galleryImage']);
        
        $fetch_details = $obj->getOfficeInfoByid($editid);
        if($fetch_details['img_office']==$galData['galleryImage']){
            $params                     = array();
            $params['img_office']     = '';
            $obj -> officeUpdateById($params, $editid);
        }
        
        $obj -> deleteGalleryBygalleryId($id);
        echo 'success';
    }
    if($action=='status'){
        $params           = array();
        $params['status'] = $stschgto;
        $obj -> galleryUpdateBygalleryId($params, $id);
        echo 'success';
    }
    if($action=='primary'){
        $params                     = array();
        $params['img_office']     = $signImage;
        $obj -> officeUpdateById($params, $editid);
        echo 'success';
    }
}
?>