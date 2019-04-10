<?php
class viewCategory
{
	private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
    
    function getLeafNode(&$categoryEndChildId, $catid)
	{
        $record = $this -> getCategory("parentId ='".$catid."'");
		foreach($record as $rk=>$rv){
            $categoryEndChildId[] = $record[$rk]["categoryId"];
            $catLeafData = $this -> getLeafNode($categoryEndChildId,$record[$rk]["categoryId"]);		
		}
		return $categoryEndChildId;
	}
    
    function categoryById($categoryId)
	{
		$ExtraQryStr = " status='Y' and categoryId=".$categoryId;
		return $this->connect->selectSingle(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr);     
	}
    
    function categoryCount($ExtraQryStr)
	{
        return $this->connect->rowCount(TBL_PRODUCT_CATEGORY, 'categoryId', $ExtraQryStr); 
	}
	
	function categoryDetailsBypermalink($permalink)
	{		
		$ExtraQryStr = "permalink='".addslashes($permalink)."' and status='Y'";
		return $this->connect->selectSingle(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr);	
	}
    
    function categoryDetailsByUrl($categoryUrl)
	{		
		$ExtraQryStr = "categoryUrl='".addslashes($categoryUrl)."' and status='Y'";
		return $this->connect->selectSingle(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr);	
	}
    
    function getCategoryDetailsBypermalinkAndparentId($permalink, $parentId)
	{		
		$ExtraQryStr = "permalink='".addslashes($permalink)."' and parentId=".addslashes($parentId)." and status='Y'";
		return $this->connect->selectSingle(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr);	
	}
	
	function getCategory($ExtraQryStr)
	{		
		$ExtraQryStr = "status='Y' and ".$ExtraQryStr." order by swapNo";
		return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr, 0, 999);	
	}
		
	function getCategoryLimit($ExtraQryStr, $start, $limit)
	{		
		$ExtraQryStr = " status='Y' and ".$ExtraQryStr." order by swapNo";
		return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr, $start, $limit);	
	}
	
		
	function getCategoryLimitByCollection($ExtraQryStr, $start, $limit)
	{		
		$ExtraQryStr = " status='Y' and ".$ExtraQryStr." order by swapNo";
		return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr, $start, $limit);	
	}
	
	function getAllCategory()
	{		
		$ExtraQryStr = "status='Y' order by categoryName ASC";
		return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr, 0, 999);	
	}
    /*-----*/
	function getCategoryByparentId($parentId)
	{		
		$ExtraQryStr = "parentId=".$parentId." and status='Y' order by swapNo";
        return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr, 0, 999); 
	}
    
	function getParentCategory()
	{		
		$ExtraQryStr = "status='Y' AND parentId=0 ";
		return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr, 0, 999);	
	}
        
	function recursiveCategory($parentId,$sitelink,$nbsp, $selectedId,$kk)
	{
		$kk++;
		$data = $this -> getCategoryByparentId($parentId);
        if(count($data)>0)
            echo '<span></span><ul class="category_sub'. $kk.'">';
		$nbsp .= '';
		for($j=0; $j<sizeof($data); $j++)
		{	
            echo '<li><a href="'.$sitelink.'/product'.$data[$j]['categoryUrl'].'">'.$nbsp.$data[$j]['categoryName'].'</a>';
            $parentId = $data[$j]['categoryId'];
            $this -> recursiveCategory($parentId,$sitelink, $nbsp, $selectedId,$kk);	
            echo '</li>';
		}
        if(count($data)>0)
            echo '</ul>';
	}

	function recursiveCategoryM($parentId,$sitelink,$nbsp, $selectedId,$kk)
	{
		$kk++;
		$data = $this -> getCategoryByparentId($parentId);
        if(count($data)>0)
            echo '<span></span><i class="fa fa-angle-right" aria-hidden="true"></i><ul class="submenu submenu2">';//'. $kk.'
		$nbsp .= '';
		for($j=0; $j<sizeof($data); $j++)
		{	
            echo '<li><a href="'.$sitelink.'/product'.$data[$j]['categoryUrl'].'">'.$nbsp.$data[$j]['categoryName'].'</a>';
            $parentId = $data[$j]['categoryId'];
            $this -> recursiveCategoryM($parentId,$sitelink, $nbsp, $selectedId,$kk);	
            echo '</li>';
		}
        if(count($data)>0)
            echo '</ul>';
	}

	function getAttributeByCategoryId($ExtraQryStr, $categoryId, $start, $limit)
	{		
		$ExtraQryStr = $ExtraQryStr." and categoryId=".$categoryId." order by attributeId";
		return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY_ATTRIBUTES, "*", $ExtraQryStr, $start, $limit);
	}	
}
?>
