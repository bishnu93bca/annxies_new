<?php
class adminProductClass
{
	private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
    
    /*-----------------------------------------Product-----------------------------------------------*/
    
    function checkExistence($ExtraQryStr) {        
        return $this->connect->selectSingle(TBL_PRODUCT, "*", $ExtraQryStr);
    }
    
    function newProduct($params)
	{
		return $this->connect->insertQuery(TBL_PRODUCT, $params);
	}
    
    function productUpdateByproductId($params, $productId){
        $CLAUSE = "id = ".addslashes($productId);
        return $this->connect->updateQuery(TBL_PRODUCT, $params, $CLAUSE);
    }
    
	function productById($productId)
	{
		$ExtraQryStr = "id=".addslashes($productId);
		return $this->connect->selectSingle(TBL_PRODUCT, "*", $ExtraQryStr);  
	}
	function productCount($ExtraQryStr)
	{
		return $this->connect->rowCount(TBL_PRODUCT, 'id', $ExtraQryStr); 
	}
	function getProduct($ExtraQryStr)
	{		
		$ExtraQryStr = $ExtraQryStr." order by swapNo";
        return $this->connect->selectMulti(TBL_PRODUCT, "*", $ExtraQryStr, 0, 999);    
	}
	function getProductWithCategory($ExtraQryStr)
	{
		$ExtraQryStr = "c.categoryId=p.categoryId and ".$ExtraQryStr." order by swapNo";
		return $this->connect->selectMulti(TBL_PRODUCT." p, ".TBL_PRODUCT_CATEGORY." c ", "p.*, c.category", $ExtraQryStr, 0, 999);    
	}	
	function getProductByLimit($ExtraQryStr, $start, $limit)
	{	
		$ExtraQryStr .= " order by p_name ASC";
		return $this->connect->selectMulti(TBL_PRODUCT, "*", $ExtraQryStr, $start, $limit);  
	}
	function getAllProduct()
	{	
		$ExtraQryStr .= " order by swapNo";
		return $this->connect->selectMulti(TBL_PRODUCT, "*", $ExtraQryStr, 0, 999);  
	}
	function getProductBycategoryId($categoryId)
	{	
		$ExtraQryStr = "categoryId=".addslashes($categoryId)." order by swapNo";
		return $this->connect->selectMulti(TBL_PRODUCT, "*", $ExtraQryStr, 0, 999);  
	}
    
    function deleteProductByproductId($productId){        
        return $this->connect->executeQuery("delete from ".TBL_PRODUCT." where id = ".addslashes($productId));
    }
    
	function getReqAttributeByproductId($ExtraQryStr, $productId, $start, $limit)
	{		
		$ExtraQryStr .= " and productId=".addslashes($productId)." order by attributeId";
		return $this->connect->selectMulti(TBL_REQUIREMENT_ATTRIBUTE, "*", $ExtraQryStr, $start, $limit);  
	}
    function deletereqproductAttr($proAttrId){        
        return $this->connect->executeQuery("DELETE FROM ".TBL_REQUIREMENT_ATTRIBUTE." WHERE proAttrId = ".addslashes($proAttrId));
    }
    /*-------------------------------------------Product---------------------------------------------*/
    
    
	function sampleCount($ExtraQryStr)
	{
		return $this->connect->rowCount(TBL_SAMPLE, 'sampleId', $ExtraQryStr); 
	}
	function getSampleByLimit($ExtraQryStr, $start, $limit)
	{	
		$ExtraQryStr .= " order by productName ASC";
		return $this->connect->selectMulti(TBL_SAMPLE, "*", $ExtraQryStr, $start, $limit);  
	}
    
    function sampleUpdateBysampleId($params, $sampleId){
        $CLAUSE = "sampleId = ".addslashes($sampleId);
        return $this->connect->updateQuery(TBL_SAMPLE, $params, $CLAUSE);
    }
    
	function sampleById($sampleId)
	{
		$ExtraQryStr = "sampleId=".addslashes($sampleId);
		return $this->connect->selectSingle(TBL_SAMPLE, "*", $ExtraQryStr);  
	}
    
	function getAttributeBysampleId($ExtraQryStr, $sampleId, $start, $limit)
	{		
		$ExtraQryStr .= " and sampleId=".addslashes($sampleId)." order by attributeId";
		return $this->connect->selectMulti(TBL_SAMPLE_ATTRIBUTES, "*", $ExtraQryStr, $start, $limit);  
	}
    /*-----------------------------------------------Gallery-----------------------------------------------------*/
    function newGallery($params)
	{
		return $this->connect->insertQuery(TBL_PRODUCT_GALLERY, $params);
	}
    
    function galleryBygalleryId($galleryId)
	{
		$ExtraQryStr = "galleryId=".addslashes($galleryId);
		return $this->connect->selectSingle(TBL_PRODUCT_GALLERY, "*", $ExtraQryStr);  
	}
    
    function getGalleryByproductId($productId)
    {
        $ExtraQryStr = "productId=".addslashes($productId);
        return $this->connect->selectMulti(TBL_PRODUCT_GALLERY, "*", $ExtraQryStr, 0, 999);  
    }
    function getLinkAttribute($productId){
    	$ExtraQryStr = "productId = ".addslashes($productId);
    	return $this->connect->selectMulti(TBL_PRODUCT_ATTRIBUTES, "*", $ExtraQryStr, 0, 999);
    }
    function getAttributeByproductId($ExtraQryStr, $productId, $start, $limit)
	{		
		$ExtraQryStr .= " and productId=".addslashes($productId)." order by attributeId";
		return $this->connect->selectMulti(TBL_PRODUCT_ATTRIBUTES, "*", $ExtraQryStr, $start, $limit);  
	}
        
    function galleryUpdateBygalleryId($params, $galleryId){
        $CLAUSE = "galleryId = ".addslashes($galleryId);
        return $this->connect->updateQuery(TBL_PRODUCT_GALLERY, $params, $CLAUSE);
    }
    
    function deleteGalleryBygalleryId($galleryId){
        return $this->connect->executeQuery("DELETE FROM ".TBL_PRODUCT_GALLERY." WHERE galleryId = ".addslashes($galleryId));
    }
    /*-----------------------------------------------Gallery-----------------------------------------------------*/
    /*	function getCategory()
	{
		$ExtraQryStr = "status='Y' order by swapNo";
		return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr, 0, 999);  
	}
	function categoryById($categoryId)
	{
		$ExtraQryStr = "categoryId=".addslashes($categoryId);
		return $this->connect->selectSingle(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr);  
	}
	function getTempGalleryBysessionId($sessionId)
	{
		$ExtraQryStr = "sessionId='".addslashes($sessionId)."'";
        return $this->connect->selectMulti("tbl_temp_gallery", "*", $ExtraQryStr, 0, 999);  	
	}*/
	
    /*-----------------------------------------------Gallery-----------------------------------------------------*/
    
}
?>
