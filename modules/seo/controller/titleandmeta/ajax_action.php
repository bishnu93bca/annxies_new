<?php
if($_REQUEST['ajax'])
{
	include('../../../../ext_include.php');
    $obj = new PageTitle;
	if($id!='')
	{
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
                $obj->titleMetaUpdateById($params, $val);
			}
			if($action=='delete')
                $obj->deleteTitleMetaById($val);
		}		
	}
}
?>