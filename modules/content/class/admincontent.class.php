<?php
class Content
{
	private $connect; 
	public function __construct(){
        $this->connect = new Site;
    }
    
    function checkExistence($ExtraQryStr) {        
        return $this->connect->selectSingle(TBL_CONTENT, "*", $ExtraQryStr);
    }
    
    function newContent($params)
	{
        return $this->connect->insertQuery(TBL_CONTENT, $params);
	}
    
    function content_details($ExtraQryStr)
	{	
        return $this->connect->selectMulti(TBL_CONTENT, "*", $ExtraQryStr, 0, 50); 
	}
	
	function categoryById($categoryId)
	{
		$ExtraQryStr = "categoryId=".$categoryId;
		return $this->connect->selectSingle(TBL_MENU_CATEGORY, "*", $ExtraQryStr); 	
	}
	
	function categoryByparentId($parentId)
	{
		$ExtraQryStr = "parentId=".$parentId." and status='Y'";
        return $this->connect->selectMulti(TBL_MENU_CATEGORY, "*", $ExtraQryStr, 0, 50); 
	}
	
    function cmsCategoryByparentId($parentId)
	{
		$ExtraQryStr = "parentId=".$parentId." and status='Y' and moduleId=0";
        return $this->connect->selectMulti(TBL_MENU_CATEGORY, "*", $ExtraQryStr, 0, 50); 
	}
    
	function getContentBycontentID($contentID)
	{
		$ExtraQryStr = "contentID=".$contentID;
		return $this->connect->selectSingle(TBL_CONTENT, "*", $ExtraQryStr); 	
	}
	
	function getContentBymenucategoryId($menucategoryId)
	{
		$ExtraQryStr = "menucategoryId=".$menucategoryId;
		return $this->connect->selectSingle(TBL_CONTENT, "*", $ExtraQryStr);	
	}
	
	function getContentListBymenucategoryId($menucategoryId)
	{
		$ExtraQryStr = "menucategoryId=".$menucategoryId;
        return $this->connect->selectSingle(TBL_CONTENT, "*", $ExtraQryStr, 0, 50);
	}
	
	function getContentListBymenucategoryIds($menucategoryIds)
	{
		$ExtraQryStr = "menucategoryId in (".$menucategoryIds.")";
		return $this->connect->selectMulti(TBL_CONTENT, "*", $ExtraQryStr, 0, 50);
	}
    
    function deleteGalleryByid($id){
        return $this->connect->executeQuery("delete from ".TBL_GALLERY." where id = ".$id);
    }
    
    function deleteContentByid($contentID){
        return $this->connect->executeQuery("delete from ".TBL_CONTENT." where contentID = ".$contentID);
    }
    
    function contentUpdateBycontentID($params, $contentID){
        $CLAUSE = "contentID = ".$contentID;
        return $this->connect->updateQuery(TBL_CONTENT, $params, $CLAUSE);
    }
}
?>