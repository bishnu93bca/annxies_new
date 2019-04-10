<?php
class viewProduct
{
	private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
	        
	function productCount($ExtraQryStr)
	{
        $ExtraQryStr.= ' and tp.status="Y" and tp.p_category=tpc.c_id';
        return $this->connect->rowCount(TBL_PRODUCT." tp, ".TBL_PRODUCT_CATEGORY." tpc", 'tp.id', $ExtraQryStr);
	}
    
	function getProductByLimit($logedinUser, $ExtraQryStr, $start, $limit, $orderby)
	{		        
        $ENTITY =   TBL_PRODUCT." tp 
                    LEFT JOIN ".TBL_PRODUCT_CATEGORY." c ON (tp.p_category=c.c_id) 
                    LEFT JOIN ".TBL_COMPANY." cm ON ( tp.userid = cm.user_id)";
        
        if($logedinUser)
            $ENTITY .= "LEFT JOIN ".TBL_MEMBER_FAVOURITE." mf ON (mf.favouriteId = tp.id AND mf.memberId=".$logedinUser." AND mf.favType='PRODUCT')";
        
        $fieldList = "tp.*, c.category category, c.permalink cat_permalink, c.categoryUrl categoryUrl,cm.id companyId,cm.companyname companyname";
        
        if($logedinUser)
            $fieldList .= ", mf.favouriteId, mf.memberId favouriteBy, mf.entryDate favouriteOn";
        
        $ExtraQryStr = "(".$ExtraQryStr.") and tp.status='Y' and tp.p_category = c.c_id ".$orderby;     
        return $this->connect->selectMulti($ENTITY, $fieldList, $ExtraQryStr, $start, $limit);	
        
	}
    
    function getRelatedProducts($categoryId, $ExtraQryStr)
	{
		$ExtraQryStr = "tp.status='Y' and tp.p_category = tpc.c_id and tp.p_category =".$categoryId." and ".$ExtraQryStr." group by tp.id order by tp.swapNo desc";
		return $this->connect->selectMulti(TBL_PRODUCT." tp, ".TBL_PRODUCT_CATEGORY." tpc", "tp.*, tpc.permalink cat_permalink, tpc.category category, tpc.categoryUrl ", $ExtraQryStr, 0, 9999);
	}
    
    
	function productById($productId)
	{
		$ExtraQryStr = "productId=".addslashes($productId)." and status='Y'";
		return $this->connect->selectSingle(TBL_PRODUCT, "*", $ExtraQryStr);
	}
        
	function productDetailByproductId($productId)
	{
		$ExtraQryStr = "p.id=".addslashes($productId)." and p.p_category=c.c_id and p.status='Y'";
		return $this->connect->selectSingle(TBL_PRODUCT." p, ".TBL_PRODUCT_CATEGORY." c", "p.*,c.permalink cpermalink", $ExtraQryStr);	
	}
    
	function productDetailsBypermalink($permalink,$logedinUser)
	{	       
        $ENTITY =   TBL_PRODUCT." p 
                    LEFT JOIN ".TBL_PRODUCT_CATEGORY." c ON (p.p_category=c.c_id) 
                    LEFT JOIN ".TBL_COMPANY." cm ON (p.userid = cm.user_id)
                    LEFT JOIN ".TBL_RECENTVIEW." rv ON (p.id = rv.productId)";
        
        if($logedinUser)
            $ENTITY .= "LEFT JOIN ".TBL_MEMBER_FAVOURITE." mf ON (mf.favouriteId = p.id AND mf.memberId=".$logedinUser." AND mf.favType='PRODUCT')";
        
        $fieldList = "p.*, c.permalink cpermalink, c.categoryUrl categoryUrl,cm.id companyId,cm.companyname companyname,rv.viewCount";
        
        if($logedinUser)
            $fieldList .= ", mf.favouriteId, mf.memberId favouriteBy, mf.entryDate favouriteOn";
        
        $ExtraQryStr = " p.permalink='".addslashes($permalink)."' AND p.status='Y'";         
        return $this->connect->selectSingle($ENTITY, $fieldList, $ExtraQryStr);	
	}
    
    function productUpdateById($params, $id){
         $CLAUSE = "id = ".addslashes($id);
        return $this->connect->updateQuery(TBL_PRODUCT, $params, $CLAUSE);
    }
    
    function searchProduct($sql)
	{
        return $this->connect->executeQueryNew($sql);
    }
    
    function recomendation($memberId){
       
        $ENTITY = TBL_PRODUCT." tp 
                    LEFT JOIN ".TBL_PRODUCT_CATEGORY." c ON (tp.p_category=c.c_id) 
                    LEFT JOIN ".TBL_MEMBER_FAVOURITE." mf ON (mf.favouriteId = tp.id AND mf.memberId=".$memberId.") 
                    LEFT JOIN ".TBL_RECENTVIEW." prv ON (prv.productId = tp.id AND tp.userId=".$memberId.")";

        $fieldList = "tp.id, tp.permalink propermalink, tp.p_category, mf.memberId favouriteBy, c.permalink cpermalink, c.categoryUrl";
        
		$ExtraQryStr = "mf.favType='PRODUCT' AND tp.status='Y' AND mf.memberId=".$memberId." ORDER BY tp.p_name";
        
        return $this->connect->selectMulti($ENTITY, $fieldList, $ExtraQryStr, 0, 99999);
        
    }
    
    /*---------------------------------Favourite---------------------------------------------*/
    function addToFavourite($params)
	{
		return $this->connect->insertQuery(TBL_MEMBER_FAVOURITE, $params);
	}
	
    function removeFromFavourite($favouriteId, $memberId)
	{
		 $this->connect->executeQuery("DELETE FROM ".TBL_MEMBER_FAVOURITE." WHERE memberId=".addslashes($memberId)." AND favouriteId=".addslashes($favouriteId)." AND favType='PRODUCT'");
	}
    
    function myFavouriteProducts($memberId, $ExtraQryStr, $start, $limit)
	{
        $ENTITY = TBL_PRODUCT." tp 
                    LEFT JOIN ".TBL_PRODUCT_CATEGORY." c ON (tp.p_category=c.c_id) 
                    LEFT JOIN ".TBL_COMPANY." cm ON (tp.userid = cm.user_id)
                    LEFT JOIN ".TBL_MEMBER_FAVOURITE." mf ON (mf.favouriteId = tp.id AND mf.memberId=".$memberId.")";

        $fieldList = "tp.*, mf.memberId favouriteBy, mf.entryDate favouriteOn, c.permalink cpermalink, c.categoryUrl categoryUrl";
        
		$ExtraQryStr .= " AND mf.favType='PRODUCT' AND tp.status='Y' AND mf.memberId=".$memberId." ORDER BY tp.p_name";
        
		return $this->connect->selectMulti($ENTITY, $fieldList, $ExtraQryStr, $start, $limit);
	}
    /*---------------------------------Favourite---------------------------------------------*/
    
	function productDetailsBypermalinkAndExtraQryStr($permalink, $ExtraQryStr)
	{	
		$ExtraQryStr = $ExtraQryStr." and permalink='".addslashes($permalink)."' and status='Y'";
		return $this->connect->selectSingle(TBL_PRODUCT, "*", $ExtraQryStr);	
	}
	
	function productDetailsByproductIdAndExtraQryStr($productId, $ExtraQryStr)
	{	
		$ExtraQryStr = $ExtraQryStr." and productId=".addslashes($productId)." and status='Y'";
		return $this->connect->selectSingle(TBL_PRODUCT, "*", $ExtraQryStr);		
	}
	
	function latestProduct($ExtraQryStr, $start, $limit)
	{
		$ExtraQryStr = "tp.status='Y' and tp.p_category = tpc.c_id and ".$ExtraQryStr." group by tp.id order by tp.swapNo desc";	
        return $this->connect->selectMulti(TBL_PRODUCT." tp, ".TBL_PRODUCT_CATEGORY." tpc", "tp.*, tpc.permalink cat_permalink, tpc.category category ", $ExtraQryStr, $start, $limit);
	}
	
    function getProductBycategoryId($categoryId, $ExtraQryStr, $start, $limit)
	{
		$ExtraQryStr = "tp.status='Y' and tp.p_category = tpc.c_id and tp.p_category =".$categoryId." and ".$ExtraQryStr." group by tp.id order by tp.swapNo desc";
		return $this->connect->selectMulti(TBL_PRODUCT." tp, ".TBL_PRODUCT_CATEGORY." tpc", "* ", $ExtraQryStr, $start, $limit);
	}
	function getRelatedProductsBycategoryId($categoryId, $ExtraQryStr)
	{
		$ExtraQryStr = "tp.status='Y' and tp.p_category = tpc.c_id and tp.p_category =".$categoryId." and ".$ExtraQryStr." group by tp.id order by tp.swapNo desc";
		return $this->connect->selectMulti(TBL_PRODUCT." tp, ".TBL_PRODUCT_CATEGORY." tpc", "tp.*, tpc.permalink cat_permalink, tpc.category category ", $ExtraQryStr, 0, 9999);
	}
    
	/*---------------------------------RECENT---------------------------------------------*/
    function addToRecent($params)
	{
		return $this->connect->insertQuery(TBL_RECENTVIEW, $params);
	}
    
    function recentViewById($ExtraQryStr)
	{
		return $this->connect->selectSingle(TBL_RECENTVIEW, "*", $ExtraQryStr);
	}
    
    function updaterecentView($params, $id){
        $CLAUSE = "viewId = ".addslashes($id);
        return $this->connect->updateQuery(TBL_RECENTVIEW, $params, $CLAUSE);
    }
    
    function myRecentViewdProducts($memberId, $ExtraQryStr, $start, $limit)
	{
        $ENTITY = TBL_PRODUCT." tp 
                    LEFT JOIN ".TBL_PRODUCT_CATEGORY." c ON (tp.p_category=c.c_id) 
                    LEFT JOIN ".TBL_COMPANY." cm ON (tp.userid = cm.user_id)
                    LEFT JOIN ".TBL_RECENTVIEW." rv ON (rv.productId = tp.id AND rv.userId=".$memberId.")";

        $fieldList = "tp.*, rv.userId viewdBy,rv.viewCount viewCount, rv.entryDate viewdOn, c.permalink cpermalink, c.categoryUrl categoryUrl";
        
		$ExtraQryStr .= " AND tp.status='Y' AND rv.userId=".$memberId." ORDER BY tp.p_name";
        
		return $this->connect->selectMulti($ENTITY, $fieldList, $ExtraQryStr, $start, $limit);
        
	}
	/*----------------------------------RECENT--------------------------------------------*/
    
    function addToRecentsearch($params)
	{
		return $this->connect->insertQuery(TBL_RECENTSEARCH, $params);
	}
    
    function getRecentsearchLimit($memberId,$ExtraQryStr, $start, $limit)
	{		
		$ExtraQryStr = $ExtraQryStr."  order by entryDate DESC";
		return $this->connect->selectMulti(TBL_RECENTSEARCH, "*", $ExtraQryStr, $start, $limit);	
	}
    
    function RecentsearchCount($ExtraQryStr)
	{
        return $this->connect->rowCount(TBL_RECENTSEARCH, 'viewId', $ExtraQryStr);
	}
	
    /*----------------------------------RECENT- SEARCH-------------------------------------*/
    
}
?>