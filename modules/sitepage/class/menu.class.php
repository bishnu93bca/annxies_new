<?php
class MenuCategory
{
	private $connect; 
	public function __construct(){
        $this->connect = new Site;
    }
    
    function checkExistence($ExtraQryStr) {        
        return $this->connect->selectSingle(TBL_MENU_CATEGORY, "*", $ExtraQryStr);
    }
    
    function newCategory($params)
	{
        return $this->connect->insertQuery(TBL_MENU_CATEGORY, $params);
	}
	
	function categoryById($categoryId)
	{
		$ExtraQryStr = "categoryId=".addslashes($categoryId);
		return $this->connect->selectSingle(TBL_MENU_CATEGORY, "*", $ExtraQryStr); 	
	}
	
	function sublinksCountById($categoryId)
	{
        return $this->connect->rowCount(TBL_MENU_CATEGORY, 'categoryId', "parentId=".addslashes($categoryId)); 
	}
	
	function categoryCount($Link)
	{
        return $this->connect->rowCount(TBL_MENU_CATEGORY, 'categoryId', "1"); 
	}
    
	function getCategory($ExtraQryStr)
	{
		$ExtraQryStr .= " order by swapNo";
		return $this->connect->selectMulti(TBL_MENU_CATEGORY, "*", $ExtraQryStr, 0, 100); 	
	}
	
	function getAllCategory()
	{		
		return $this->connect->selectMulti(TBL_MENU_CATEGORY, "*", "1", 0, 999); 
	}
	
	function getMenuByparentId($parentId)
	{
		$ExtraQryStr = "status = 'Y' and parentId=".addslashes($parentId)." order by swapno";
		return $this->connect->selectMulti(TBL_MENU_CATEGORY, "*", $ExtraQryStr, 0, 100); 
	}
    
	function getCMSMenuByparentId($parentId)
	{
		$ExtraQryStr = "status = 'Y' and parentId=".addslashes($parentId)." and moduleId=0 order by swapno";
		return $this->connect->selectMulti(TBL_MENU_CATEGORY, "*", $ExtraQryStr, 0, 100); 
	}
    
    function categoryUpdateBycategoryId($params, $categoryId){
        $CLAUSE = "categoryId = ".addslashes($categoryId);
        return $this->connect->updateQuery(TBL_MENU_CATEGORY, $params, $CLAUSE);
    }
    
    function galleryBymenucategoryId($menucategoryId){
        return $this->connect->selectMulti(TBL_GALLERY, "*", "menucategoryId = ".addslashes($menucategoryId), 0, 999); 
    }
    
    function deleteContentBymenucategoryId($menucategoryId){
        return $this->connect->executeQuery("delete from ".TBL_CONTENT." where menucategoryId = ".addslashes($menucategoryId));
    }
    
    function deleteGalleryByid($id){
        return $this->connect->executeQuery("delete from ".TBL_GALLERY." where id = ".addslashes($id));
    }
    
    function deleteMenuBycategoryId($categoryId){
        return $this->connect->executeQuery("delete from ".TBL_MENU_CATEGORY." where categoryId = ".addslashes($categoryId));
    }
    
    function deleteMenuByparentId($parentId){
        return $this->connect->executeQuery("delete from ".TBL_MENU_CATEGORY." where parentId = ".addslashes($parentId));
    }
}
?>