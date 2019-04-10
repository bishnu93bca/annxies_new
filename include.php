<?php
include("config.php");
/*------------------------------------------------------------------
Include class files for individual modules
--------------------------------------------------------------------*/
$mObj=new menu();
$menudata= $mObj -> getModules();
//$pageType;
for($i=0;$i<sizeof($menudata);$i++)
{
	if(file_exists($ROOT_PATH.'/'.MODULE_PATH.'/'.$menudata[$i]['parent_dir'].'/class/'.CLASS_PATH))
		include($ROOT_PATH.'/'.MODULE_PATH.'/'.$menudata[$i]['parent_dir'].'/class/'.CLASS_PATH);	

	if($pageType!=ADMIN_PATH){
		if(file_exists($ROOT_PATH.'/'.MODULE_PATH.'/'.$menudata[$i]['parent_dir'].'/action.php')){
            if($_POST){
                include($ROOT_PATH.'/'.MODULE_PATH.'/'.$menudata[$i]['parent_dir'].'/action.php');
            }
        }
	}
}
?>