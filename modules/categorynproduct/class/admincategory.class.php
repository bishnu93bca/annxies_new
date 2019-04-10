<?php
class adminCategory
{    
    private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
    
    function checkExistence($ExtraQryStr) {        
        return $this->connect->selectSingle(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr);
    }
    
    function categoryCount($ExtraQryStr)
	{
        return $this->connect->rowCount(TBL_PRODUCT_CATEGORY, 'c_id', $ExtraQryStr); 
	}
    
    function getCategoryByLimit($ExtraQryStr, $start, $limit)
	{		
		$ExtraQryStr .= " order by category ASC";
        return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr, $start, $limit);        
	}
    
    function newCategory($params)
	{		
        return $this->connect->insertQuery(TBL_PRODUCT_CATEGORY, $params);
	}
    
	function categoryById($categoryId)
	{
		$ExtraQryStr = "c_id=".$categoryId;
		return $this->connect->selectSingle(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr);     
	}

	function getMainCategoryByParentId($categoryId)
	{
		$ExtraQryStr = "c_id=".$categoryId;
        return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr, 0, 999);    
	}

	function getCategory($ExtraQryStr)
	{		
		$ExtraQryStr .= " order by c_id asc";
        return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr, 0, 999);  
	}

	function getAllCategory()
	{		
        echo $ExtraQryStr = " order by category";
        return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr, 0, 999); 
	}

	function getCategoryByparentId($parentId)
	{		
		$ExtraQryStr = "parent_id=".$parentId." order by category";
        return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr, 0, 999); 
	}

	function recursiveCategory($parentId, $editid, $nbsp, $selectedId)
	{
		//echo $selectedId;
		$data = $this -> getCategoryByparentId($parentId);
		$nbsp .= '&nbsp;&nbsp;';
		for($j=0; $j<sizeof($data); $j++)
		{
			if($data[$j]['c_id']!=$editid)
			{
				if($data[$j]['c_id']==$selectedId)
					echo '<option value="'.$data[$j]['c_id'].'" selected>'.$nbsp.$data[$j]['category'].'</option>';	
				else
					echo '<option value="'.$data[$j]['c_id'].'">'.$nbsp.$data[$j]['category'].'</option>';
				$parentId = $data[$j]['c_id'];
				$this -> recursiveCategory($parentId, $editid, $nbsp, $selectedId);
			}
		}
	}
    function categoryUpdateBycategoryId($params, $categoryId){
        $CLAUSE = "c_id = ".$categoryId;
        return $this->connect->updateQuery(TBL_PRODUCT_CATEGORY, $params, $CLAUSE);
    }
    
    function deleteCategoryBycategoryId($categoryId)
    {        
        return $this->connect->executeQuery("delete from ".TBL_PRODUCT_CATEGORY." where c_id = ".$categoryId);
    }
    
    /*----------------------------TBL_PRODUCT_CATEGORY_ATTRIBUTES--------------------------------*/
    
    function newAttribute($params)
	{		
        return $this->connect->insertQuery(TBL_PRODUCT_CATEGORY_ATTRIBUTES, $params);
	}
    
	function getAttributeByCategoryId($ExtraQryStr, $categoryId, $start, $limit)
	{		
		$ExtraQryStr .= " and categoryId=".$categoryId." order by attributeId";
        return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY_ATTRIBUTES, "*", $ExtraQryStr, $start, $limit); 
	}
    
	function countAttributeByCategoryId($ExtraQryStr, $categoryId)
	{		
		$ExtraQryStr = $ExtraQryStr." and categoryId=".$categoryId;

        return $this->connect->rowCount(TBL_PRODUCT_ATTRIBUTES, 'proAttrId', $ExtraQryStr); 
	}
    
    function categoryAttributeUpdateBycategoryIdattributeId($params, $categoryId, $attributeId){
        $CLAUSE = "attributeId = ".$attributeId." and categoryId = ".$categoryId;
        return $this->connect->updateQuery(TBL_PRODUCT_CATEGORY_ATTRIBUTES, $params, $CLAUSE);
    }
    
    function deleteAttributeBycategoryId($categoryId, $ExtraQryStr){        
        return $this->connect->executeQuery("delete from ".TBL_PRODUCT_CATEGORY_ATTRIBUTES." where categoryId = ".$categoryId." and ".$ExtraQryStr);
    }
	function getAttributeById($attrId)
	{		
		$ExtraQryStr = "attributeId=".$attrId;
        return $this->connect->selectSingle(TBL_PRODUCT_CATEGORY_ATTRIBUTES, "attributeName", $ExtraQryStr); 
	}
    
}
?>
