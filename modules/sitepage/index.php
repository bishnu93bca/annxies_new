<ul class="menu">  
    
	<?php
	$dobj = new DynamicMenu();
    $ExtraQryStr = 'siteId='.addslashes($siteId);
	$selData = $dobj -> getMenu($ExtraQryStr);	
	for($i=0;$i<sizeof($selData);$i++) 
	{
		if($pageType == $selData[$i]['permalink'])	
		{		
			$class               = 'class="active"';
			$moduleId            = $selData[$i]['moduleId'];
			$insideBannerImage   = $selData[$i]['categoryImage'];
			$pageId              = $selData[$i]['categoryId'];
			$pmenuId             = $selData[$i]['categoryId'];
			$page                = $selData[$i]['categoryName'];
		}
		else
			$class = '';			
		if($i==0)
			$categoryName =	$selData[$i]['categoryName'];
		elseif($i==sizeof($selData)-1)
			$categoryName =	$selData[$i]['categoryName'];
		else
			$categoryName =	$selData[$i]['categoryName'];	

		$submenu = $dobj -> getMenuByparentId($selData[$i]['categoryId']);			
		if($submenu)
		{
			if($selData[$i]['categoryUrl']!='')
				echo '<li '.$class.'><a href="'.$selData[$i]['categoryUrl'].'" title="'.$categoryName.'">'.$categoryName.'<span class="li-arrow"></span></a>';
			else
				echo '<li '.$class.'><a href="'.$SITE_LOC_PATH.'/'.$selData[$i]['permalink'].'/">'.$categoryName.'</a><span class="li-arrow"></span>';	
			echo '<ul class="sub-menu">';
			for($j=0;$j<sizeof($submenu);$j++)
			{									
				if($dtls && $dtls==$submenu[$j]['permalink'])
				{					
					$moduleId  = $submenu[$j]['moduleId'];
					$pageId    = $submenu[$j]['categoryId'];
					$subpage   = $submenu[$j]['categoryName'];
				}
				elseif($dtaction==$submenu[$j]['permalink'] && $pageType==$selData[$i]['permalink'])
				{
					$moduleId  = $submenu[$j]['moduleId'];
					$pageId    = $submenu[$j]['categoryId'];
					$subpage   = $submenu[$j]['categoryName'];
				}				
									
                if($submenu[$j]['categoryUrl']!='')
                    echo '<li><a href="'.$submenu[$j]['categoryUrl'].'" title="'.strip_tags($submenu[$j]['categoryName']).'">'.strip_tags($submenu[$j]['categoryName']).'</a>';				
                else
                    echo '<li><a href="'.$SITE_LOC_PATH.'/'.$selData[$i]['permalink'].'/'.$submenu[$j]['permalink'].'/" title="'.strip_tags($submenu[$j]['categoryName']).'">'.strip_tags($submenu[$j]['categoryName']).'</a>';

                echo '</li>';
			}
			echo '</ul>';
		}
        elseif($selData[$i]['categoryId']==27)
		{
            echo '<li '.$class.'><a href="javascript:void(0)" title="'.$categoryName.'">'.$categoryName.'</a>';
            echo '<span class="li-arrow"></span>';
            
            $pkObj    = new MemberView();
            $pack     = $pkObj->packageList(1, 0, 4);
            echo '<ul class="sub-menu"">';
            foreach($pack as $pckg){
                echo '<li ><a href="'.$SITE_LOC_PATH.'/'.$selData[$i]['permalink'].'/'.$pckg['permalink'].'/" title="'.$pckg['name'].'">'.$pckg['name'].'</a>';
            }
            echo '<li ><a href="'.$SITE_LOC_PATH.'/'.$selData[$i]['permalink'].'/compare-packages/" title="Compare Packages">Compare Packages</a>';
            echo '</ul>';
		}
		else
		{
			if($selData[$i]['categoryUrl']!='')
				echo '<li '.$class.'><a href="'.$selData[$i]['categoryUrl'].'" title="'.$categoryName.'">'.$categoryName.'</a>';
			else
				echo '<li '.$class.'><a href="'.$SITE_LOC_PATH.'/'.$selData[$i]['permalink'].'/" title="'.$categoryName.'">'.$categoryName.'</a>';
		}
		echo '</li>'; 
	}
	?>	
</ul>

<?php
$breadcrumb = '<div class="breadcrumb"><ul class="clearfix">';
$breadcrumb .= '<li><a href="'.$SITE_LOC_PATH.'/">Home</a></li>';
if($dtls)
{
    $pageTypeArrayUrl = $SITE_LOC_PATH.'/';
	foreach($pageTypeArray as $page){
        $pageTypeArrayUrl .= $page.'/';
        if($page!='products')
            $breadcrumb .= '<li><a href="'.$pageTypeArrayUrl.'">'.ucwords(str_replace('-',' ',$page)).'</a></li>';
    }
    
    if($dtls!='item')
	   $breadcrumb .= '<li><a href="'.$SITE_LOC_PATH.'/'.$pageType.'/'.$dtls.'/">'.ucwords(str_replace('-',' ',$dtls)).'</a></li>';
	$breadcrumb .= '<li>'.ucwords(str_replace('-',' ',$dtaction)).'</li>';	
}
elseif($dtaction)
{
    if($pageType!='products')
	$breadcrumb .= '<li><a href="'.$SITE_LOC_PATH.'/'.$pageType.'/">'.ucwords(str_replace('-',' ',$pageType)).'</a></li>';	
	$breadcrumb .= '<li>'.ucwords(str_replace('-',' ',$dtaction)).'</li>';	
}
else
	$breadcrumb .= '<li>'.ucwords(str_replace('-',' ',$pageType)).'</li>';
$breadcrumb .='</ul></div>';
?>