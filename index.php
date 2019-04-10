<?php
while(list($key,$val)=each($_REQUEST))
	$$key = htmlspecialchars(trim(stripslashes($val)));

include("include.php");
$token = NoCSRF::generate('csrf_token');
/*------------------------------------------------------------------
If the site is disabled
--------------------------------------------------------------------*/
if($siteStatus!='Y')
   // $siteObj->underConstruction();
/*-------------------------------------------------------------------
pages_user.php  is for Pagination.
--------------------------------------------------------------------*/
include($ROOT_PATH."/lib/includes/pages_user.php");
//Defining Title Tag and Meta Tag---------Start----------------------
if($pageType!='request'){
    $explodedTitle = explode('/', $_SERVER['REQUEST_URI']);
    $titleWords = '';
    $i=0;
    for($k=sizeof($explodedTitle); $k>0; $k--)
    {
        if($explodedTitle[$k-1]!='' && !strstr($explodedTitle[$k-1],'?'))
            $titleWords .= ucwords(strtolower(str_replace('-',' ',$explodedTitle[$k-1]))).' | ';
        if($explodedTitle[$i]!='' && $explodedTitle[$i]!='home' && !strstr($explodedTitle[$i],'?'))
        {
            if($i<2)
                $linkWrd .= ' - <a href="'.$SITE_LOC_PATH.'/'.$explodedTitle[$i].'/">'.ucwords(strtolower(str_replace('-',' ',$explodedTitle[$i]))).'</a>';
            else
                $linkWrd .= ' - <a href="#">'.ucwords(strtolower(str_replace('-',' ',$explodedTitle[$i]))).'</a>';
        }
        $i++;
    }

    $sel_ConfigDtls = $siteObj -> getDefaultTitleAndMeta();
    if($sel_ConfigDtls)
    {
        $TitleofSite       = $sel_ConfigDtls['pageTitleText'];
        $MetaKeyOfSite     = $sel_ConfigDtls['metaTag'];
        $MetaDescOfSite    = $sel_ConfigDtls['metaDescription'];
        $MetaRobots        = $sel_ConfigDtls['metaRobots'];
    }
    $StringPath = $_SERVER['REQUEST_URI'];
    $StringPath = str_replace($DOMAIN, '', $StringPath);
    //----------------------add canonical--------
    $can_ConfigDtls = $siteObj -> getcanonicalByURL($StringPath);
    if($can_ConfigDtls)
        $canonical=strip_tags($can_ConfigDtls['canonicalText']);
    //--------------------add canonical---------
    $sel_ConfigDtls = $siteObj -> getTitleMetaByURL($StringPath);
    if($sel_ConfigDtls)
    {
        if(strip_tags($sel_ConfigDtls['pageTitleText'])!='')
            $TitleofSite = strip_tags($sel_ConfigDtls['pageTitleText']);
        else
            $TitleofSite = $defaultTitle.$titleWords;
        if(strip_tags($sel_ConfigDtls['metaTag'])!='')
            $MetaKeyOfSite = strip_tags($sel_ConfigDtls['metaTag']);
        else
            $MetaKeyOfSite = $defaultmetaKey;
        if(strip_tags($sel_ConfigDtls['metaDescription'])!='')
            $MetaDescOfSite = strip_tags($sel_ConfigDtls['metaDescription']);
        else
            $MetaDescOfSite = $defaultmetaDesc;
        $MetaRobots =$sel_ConfigDtls['metaRobots'];
    }
    else
        $TitleofSite = $titleWords.$TitleofSite;
    //------------------------------------------------------------------------END
}

$pageTypeArray = explode('/', $pageType);
if($pageType!='request')
    include(TMPL_PATH."/inc/header.php");
if($pageType!='404'){
    if($pageType)
    {	
        if(!$moduleId)
        {
            $obj = new DynamicMenu();
            $parentPermalink = $pageTypeArray[0];
            $selData = $obj->getCategoryBypermalink($parentPermalink);
            $moduleId = $selData['moduleId'];	
        }
        if($moduleId)
        {
            $mData = $mObj -> getModuleBymoduleId($moduleId);	
            if($dtaction)
                $pagename = MODULE_PATH.'/'.$mData['parent_dir'].'/index.php';	
            else
                $pagename = MODULE_PATH.'/'.$mData['parent_dir'].'/index.php';
        }
        else{
            $eObj = new MemberView();
            $memberData = $eObj->getMemberByprofileId($pageType);
            if($memberData)
                $pagename = MODULE_PATH.'/dashboard/student/public_profile.php';
            else
                $pagename = MODULE_PATH.'/content/index.php';
        }
        include($pagename);
    }
    else
        include(TMPL_PATH."/home.php");    
}
else
    include("404.php");
if($pageType!='request')
    include(TMPL_PATH."/inc/footer.php");
?>