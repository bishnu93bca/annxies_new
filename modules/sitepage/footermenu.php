<ul class="unstyled">
	<?php
	$dobj = new DynamicMenu();
    $ExtraQryStr = 'siteId='.addslashes($siteId);
	$selData = $dobj -> getFooterMenu($ExtraQryStr);
	
	if($selData)
	{
		for($i=0;$i<sizeof($selData);$i++) 
		{
			if($pageType == $selData[$i]['permalink'])		
				$class = 'class="active"';
			else
				$class = '';
				
			if($i==0)
				$categoryName =	strip_tags($selData[$i]['categoryName']);
			elseif($i==sizeof($selData)-1)
				$categoryName =	strip_tags($selData[$i]['categoryName']);
			else
				$categoryName =	strip_tags($selData[$i]['categoryName']);
				
			$submenu = $dobj -> getMenuByparentId($selData[$i]['categoryId'],$Link);		
			
			if($selData[$i]['categoryUrl']!='')
				echo '<li><a href="'.$selData[$i]['categoryUrl'].'" title="'.$categoryName.'" '.$class.'>'.$categoryName.'</a></li>';
			else
				echo '<li><a href="'.$SITE_LOC_PATH.'/'.$selData[$i]['permalink'].'/" title="'.$categoryName.'" '.$class.'>'.$categoryName.'</a></li>';
		}
		
	}
	?>	
</ul>