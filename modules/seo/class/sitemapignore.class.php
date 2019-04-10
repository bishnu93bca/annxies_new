<?php
class SiteMapIgnore
{
	function newSiteMapIgnoreUrl($siteId, $ignoreUrl, $Link)
	{
		$query="insert into ".TBL_SITEMAP_IGNORE." (siteId, ignoreUrl, entryDate) values (".$siteId.",'".addslashes($ignoreUrl)."',NOW())";
		
		$result=mysql_query($query,$Link);	
		if(mysql_affected_rows()>0)
			return(mysql_insert_id());
		else
			return 0;
	}
	function deleteIgnoreUrl($siteId, $Link)
	{
		mysql_query("delete from ".TBL_SITEMAP_IGNORE." where siteId=".$siteId);	
	}	
	function siteMapIgnoreUrl($siteId,$Link)
	{
		$query ="select * from ".TBL_SITEMAP_IGNORE." where siteId=$siteId";
		$result=mysql_query($query,$Link);
		$count=0;
		if(mysql_num_rows($result)>0)
		{
			while($record=mysql_fetch_assoc($result))
			{
				$data[$count]=array(
									"ignoreId"=>$record["ignoreId"],
									"siteId"=>$record["siteId"],
									"ignoreUrl"=>$record["ignoreUrl"],							
									"entryDate"=>$record["entryDate"]																	
									);
				$count++;
			}
			return $data;
		}
		else
			return;
	}	
	function siteMapIgnoreUrlByignoreUrl($siteId,$ignoreUrl,$Link)
	{
		$query ="select * from ".TBL_SITEMAP_IGNORE." where siteId=".$siteId." and '".addslashes($ignoreUrl)."' like 
		CONCAT((SELECT ignoreUrl FROM ".TBL_SITEMAP_IGNORE." WHERE siteId=".$siteId." limit 0,1), '%')";
		$result=mysql_query($query,$Link);
		$count=0;
		if(mysql_num_rows($result)>0)
		{
			while($record=mysql_fetch_assoc($result))
			{
				$data[$count]=array(
									"ignoreId"=>$record["ignoreId"],
									"siteId"=>$record["siteId"],
									"ignoreUrl"=>$record["ignoreUrl"],							
									"entryDate"=>$record["entryDate"]																	
									);
				$count++;
			}
			return $data;
		}
		else
			return;
	}	
}
?>