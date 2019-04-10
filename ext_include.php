<?php
/*------------------------------------------------------------------
Fetching all server request.
--------------------------------------------------------------------*/
while(list($key,$val)=each($_REQUEST))
	$$key = htmlspecialchars(trim(stripslashes($val))); 
include("config.php");
/*------------------------------------------------------------------
Include class files for individual modules
--------------------------------------------------------------------*/
$mObj=new menu();
$menudata= $mObj -> getModules();
for($i=0; $i<sizeof($menudata); $i++)
{
	if(file_exists($ROOT_PATH.'/'.MODULE_PATH.'/'.$menudata[$i]['parent_dir'].'/class/'.CLASS_PATH))
		include($ROOT_PATH.'/'.MODULE_PATH.'/'.$menudata[$i]['parent_dir'].'/class/'.CLASS_PATH);	
}
?>