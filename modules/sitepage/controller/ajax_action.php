<?php
if($_REQUEST['ajax'])
{
	include('../../../ext_include.php');
	if($id!='')
	{
		$menuObj = new MenuCategory;
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
                $params['status'] = $stschgto;
                $menuObj -> categoryUpdateBycategoryId($params, $val);
			}
		}	
	}
}
?>