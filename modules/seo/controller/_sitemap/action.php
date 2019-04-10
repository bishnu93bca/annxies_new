<?php
/************************************************************************
Site Map Section Started
************************************************************************/
if(isset($Save) && $SourceForm=='SiteMap')
{
	if($siteUrl!='')
	{
		$sObj = new SiteMapIgnore();
		$sObj->deleteIgnoreUrl($siteId, $Link);
		$skip = $_REQUEST['skip'];	
		if(sizeof($skip)>0)
		{
			foreach($skip as $ignoreUrl)
				if($ignoreUrl!='')
					$newData = $sObj->newSiteMapIgnoreUrl($siteId, $ignoreUrl, $Link);
		}
		else
			$skip[] = "";		
		$siteMapGenerator = new SiteMapGenerator($siteUrl,$skip);
		$f = fopen("../sitemap.xml","w+");
		fwrite($f,$siteMapGenerator->generateSiteMap());
		fclose($f);
		$ErrMsg = '<div class="success">Site Map Generated Successfully</div>';
	}
	else
		$ErrMsg = '<div class="error">* Marked Field(s) Are Mandatory !!</div>';
}
/************************************************************************
Site Map Section Ended
************************************************************************/
?>