<?php
if($_REQUEST['ajax'])
{
	include('../../../../ext_include.php');
	if($id!='')
	{
		$obj = new adminCategory();
		$id=rtrim($id,"@");
		$idToDelete = explode("@", $id);
		foreach($idToDelete as $val)
		{
			if($action=='active' || $action=='inactive')
			{		
				if($action=='active')
					$stschgto='Y';
				else
					$stschgto='N';	
				
				$params = array();
				$params['status']     = $stschgto;
				$obj->categoryUpdateBycategoryId($params, $val);
			}
			if($action=='delete')
			{
                $cData =$obj->categoryById($val);
                if($cData['cat_image'])
                {
                    @unlink($MEDIA_FILES_ROOT.'/product/normal/'.$cData['cat_image']);
                    @unlink($MEDIA_FILES_ROOT.'/product/thumb/'.$cData['cat_image']);
                    @unlink($MEDIA_FILES_ROOT.'/product/large/'.$cData['cat_image']);
                }
                
				$obj->deleteCategoryBycategoryId($val);
			}
		}		
	}
}
?>