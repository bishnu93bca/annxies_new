<?php
$brdcrmbObj = new MenuCategory();
$categoryParentName=$data[$i]['categoryName'];
if($parentId>0)
{				
	$ExtraQryStr = "categoryId= $parentId";
	$data = $brdcrmbObj -> getCategory($ExtraQryStr,$_SESSION['SITE_ID']);
	for($i=0; $i<sizeof($data); $i++)
	{	
		$categoryParentName=$data[$i]['categoryName'];
		$permalinkParentName=$data[$i]['permalink'].'/';
		
		$cparentId=$data[$i]['parentId'];	
		$pRow=0;
		$parentNameArray='';
		$permalinkArray ='';
		
		$concatinateName='';
		$concatinatePermalink='';															
		while($cparentId!=0)
		{
			$name=$brdcrmbObj -> categoryById($cparentId,$Link);
			$cparentId=$name['parentId'];
			$parentNameArray[$pRow] =$name['categoryName'];	
			$permalinkArray[$pRow] =$name['permalink'];	
			$pRow++;							
		}							
									
		if($parentNameArray!='')
		{
			$parentNameArray=array_reverse($parentNameArray);
			
			$permalinkArray=array_reverse($permalinkArray);	
			
			for($pna=0;$pna<sizeof($parentNameArray);$pna++)
			{
				$concatinateName .=$parentNameArray[$pna].' <span>→</span> ';
				
				if($permalinkArray[$pna]!=$permalink)
				{
					$concatinatePermalink .=$permalinkArray[$pna].'/';
				}
			}
				
			$categoryParentName=$concatinateName.$categoryParentName;	
			
			$permalinkParentName=$concatinatePermalink.$permalinkParentName;							
		}																	
	}
}	
else
	$categoryParentName='Parent Level';				
?>