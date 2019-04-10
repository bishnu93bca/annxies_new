<?php
$obj = new DynamicMenu();
$objContent = new ContentView();
if($dtls)
{
	$selData = $obj->getCategoryBypermalink($dtls);
	$parentId = $selData['categoryId'];    
    if($parentId==22){
        $tbj     = new Post();	        
        $selData = $tbj->blogByPermalink($dtaction);
    }
    else
	   $selData = $obj->getCategoryByPermalinkAndparentId($dtaction, $parentId);
}
elseif($dtaction)
{
	$permalink=$dtaction;
	$parentPermalink = $pageType;
	$selData = $obj->getCategoryBypermalink($parentPermalink);
	$parentId = $selData['categoryId'];
	$selData = $obj->getCategoryByPermalinkAndparentId($permalink, $parentId); // Version1.0 implemented here.. (permalink)
}
else
{		
	$dtaction=$pageType;
	$permalink=$pageType;	
	$selData = $obj->getCategoryBypermalink($permalink); // Version1.0 implemented here.. (permalink)
}
if($parentId!=22)
{
    if($selData['categoryId']) 
    {
        $categoryId = $selData['categoryId'];
        $categoryType = $selData['categoryType'];
        $sideBar = $selData['sideBar'];
        $subMenuData = $obj->getMenuByparentId($categoryId); //For displaying short description of submenu under main menu page
        include('page.php');
    }
    else
        $siteObj->redirectTo404($SITE_LOC_PATH);
}
else{
    $categoryId=$parentId;
    include('page.php');
}
?>