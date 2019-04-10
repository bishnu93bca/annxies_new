<?php
class DynamicMenu
{
	private $connect; 
	public function __construct(){
        $this->connect = new Site;
    }
    
    function getMenu($ExtraQryStr)
	{
		$ExtraQryStr .= " and status = 'Y' and hiddenMenu='N' and parentId=0 and isTopMenu='Y' order by swapNo";
		return $this->connect->selectMulti(TBL_MENU_CATEGORY, "*", $ExtraQryStr, 0, 50); 
	}

	function getFooterMenu($ExtraQryStr)
	{
        $ExtraQryStr .= " and status = 'Y' and hiddenMenu='N' and isFooterMenu='Y' order by swapNo";
        return $this->connect->selectMulti(TBL_MENU_CATEGORY, "*", $ExtraQryStr, 0, 50); 
	}		

	function getMenuByparentId($parentId)
	{
        return $this->connect->selectMulti(TBL_MENU_CATEGORY, "*", "status = 'Y' and hiddenMenu='N' and parentId=".addslashes($parentId)." order by swapno", 0, 50); 
	}

	function getSubTopMenuByparentId($parentId)
	{
        return $this->connect->selectMulti(TBL_MENU_CATEGORY, "*", "status = 'Y' and hiddenMenu='N' and parentId=".addslashes($parentId)." and isTopMenu='Y' order by swapno", 0, 50); 
	}

	function getMenuByparentIdAndsiteId($parentId)
	{
        return $this->connect->selectMulti(TBL_MENU_CATEGORY, "*", "status = 'Y' and hiddenMenu='N' and parentId=".addslashes($parentId)." order by swapno", 0, 50);
	}	

	function  getCategoryBycategoryId($categoryId)
	{
        return $this->connect->selectSingle(TBL_MENU_CATEGORY, "*", "categoryId='".addslashes($categoryId)."' and status='Y' and hiddenMenu='N'");
	}

	function  getCategoryBycategoryName($categoryName)
	{
        return $this->connect->selectSingle(TBL_MENU_CATEGORY, "*", "categoryName='".addslashes($categoryName)."' and status='Y' and hiddenMenu='N'");
	}

	function  getCategoryBycategoryNameAndparentId($categoryName, $parentId)
	{
        return $this->connect->selectSingle(TBL_MENU_CATEGORY, "*", "categoryName='".addslashes($categoryName)."' and parentId=".addslashes($parentId)." and status='Y' and hiddenMenu='N'", 0, 50);
	}

	function getCategoryBypermalink($permalink)
	{
        return $this->connect->selectSingle(TBL_MENU_CATEGORY, "*", "permalink='".addslashes($permalink)."'");
	}

	function  getCategoryByPermalinkAndparentId($permalink, $parentId)
	{
        return $this->connect->selectSingle(TBL_MENU_CATEGORY, "*", "permalink='".addslashes($permalink)."' and parentId=".addslashes($parentId)." and status='Y' and hiddenMenu='N'", 0, 50);
	}
}
?>