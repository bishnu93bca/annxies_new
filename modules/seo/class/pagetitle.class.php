<?php
class PageTitle
{
	private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
    
    function titleMetaById($titleandMetaId)
	{
		$ExtraQryStr = "titleandMetaId=".$titleandMetaId;
		return $this->connect->selectSingle(TBL_TITLE_AND_META, "*", $ExtraQryStr);     
	}
    
    function canonicalById($canonicalId)
	{
		$ExtraQryStr = "canonicalId=".$canonicalId;
		return $this->connect->selectSingle(TBL_CANONICAL, "*", $ExtraQryStr);     
	}
    
    function siteById($siteId)
	{
		$ExtraQryStr = "siteId=".$siteId;
		return $this->connect->selectSingle(TBL_SITE, "*", $ExtraQryStr);     
	}
    
    function newTitleMeta($params)
	{		
        return $this->connect->insertQuery(TBL_TITLE_AND_META, $params);
	}
    
    function newCanonical($params)
	{		
        return $this->connect->insertQuery(TBL_CANONICAL, $params);
	}
    
    function getDefaultTitleAndMeta($siteId)
	{
        $ExtraQryStr = "siteId=".$siteId." and titleandMetaType ='D'";
        return $this->connect->selectSingle(TBL_TITLE_AND_META, "*", $ExtraQryStr);
	}
    
    function getHomeTitleAndMeta($siteId)
	{
        $ExtraQryStr = "siteId=".$siteId." and titleandMetaType ='H'";
        return $this->connect->selectSingle(TBL_TITLE_AND_META, "*", $ExtraQryStr);
	}
    
    function getPageTitleandMetaBysiteId($siteId, $ExtraQryStr)
	{
		$ExtraQryStr .= " and siteId=".$siteId;
		return $this->connect->selectMulti(TBL_TITLE_AND_META, "*", $ExtraQryStr, 0, 999);          
	}
    
    function getcanonicalBysiteId($siteId, $ExtraQryStr)
	{
		$ExtraQryStr .= " and siteId=".$siteId;
		return $this->connect->selectMulti(TBL_CANONICAL, "*", $ExtraQryStr, 0, 999); 
	}
    
    function titleMetaUpdateById($params, $titleandMetaId){
        $CLAUSE = "titleandMetaId = ".$titleandMetaId;
        return $this->connect->updateQuery(TBL_TITLE_AND_META, $params, $CLAUSE);
    }
    
    function canonicalUpdateById($params, $canonicalId){
        $CLAUSE = "canonicalId = ".$canonicalId;
        return $this->connect->updateQuery(TBL_CANONICAL, $params, $CLAUSE);
    }
    
    function siteUpdateById($params, $siteId){
        $CLAUSE = "siteId = ".$siteId;
        return $this->connect->updateQuery(TBL_SITE, $params, $CLAUSE);
    }
    
    function deleteTitleMetaById($titleandMetaId){        
        return $this->connect->executeQuery("delete from ".TBL_TITLE_AND_META." where titleandMetaId = ".$titleandMetaId);
    }
    
    function deleteCanonicalById($canonicalId){        
        return $this->connect->executeQuery("delete from ".TBL_CANONICAL." where canonicalId = ".$canonicalId);
    }
}
?>