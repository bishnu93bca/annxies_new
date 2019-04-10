<?php
class GalleryClass
{
	private $connect; 
	public function __construct(){
        $this->connect = new Site;
    }
    
    function newGallery($params)
	{
        return $this->connect->insertQuery(TBL_GALLERY, $params);
	}
    
    function gallery_count()
	{
		$needle = 'id';
        $CLAUSE = "1";
		return $this->connect->rowCount(TBL_GALLERY, $needle, $CLAUSE); 
	}
	
	function gallery_details($ExtraQryStr, $orderType, $order)
	{
		$ExtraQryStr .= " order by ".$orderType." ".$order;
		return $this->connect->selectMulti(TBL_GALLERY, "*", $ExtraQryStr, 0, 999); 
	}
    
    function galleryByid($id)
	{
		$ExtraQryStr .= " id = ".$id;
		return $this->connect->selectSingle(TBL_GALLERY, "*", $ExtraQryStr); 
	}
	
	function getTempGallery()
	{
		return $this->connect->selectMulti("tbl_temp_gallery", "*", "1", 0, 999); 	
	}
    
    function getTempGalleryBysessionId($sessionId)
	{
		return $this->connect->selectMulti("tbl_temp_gallery", "*", "sessionId='".addslashes($sessionId)."'", 0, 999); 	
	}
	
	function galleryDetailsBymenucategoryId($menucategoryId)
	{
		$ExtraQryStr = "menucategoryId=".$menucategoryId." and galleryType='P'  order by swapNo";
        return $this->connect->selectMulti(TBL_GALLERY, "*", $ExtraQryStr, 0, 999);	
	}
	
	function videoDetailsBymenucategoryId($menucategoryId)
	{
		$ExtraQryStr = "menucategoryId=".$menucategoryId." and galleryType='V'";
		return $this->connect->selectMulti(TBL_GALLERY, "*", $ExtraQryStr, 0, 999);			
	}
	
	function allgalleryDetailsBygalleryCategoryId($galleryCategoryId)
	{
		$ExtraQryStr = "galleryCategoryId=".$galleryCategoryId." order by swapno";
		return $this->connect->selectMulti(TBL_GALLERY, "*", $ExtraQryStr, 0, 999);			
	}
	
	function galleryDetailsBygalleryCategoryId($galleryCategoryId, $start, $limit)
	{
		$ExtraQryStr = "galleryCategoryId=".$galleryCategoryId." order by swapno";
		return $this->connect->selectMulti(TBL_GALLERY, "*", $ExtraQryStr, $start, $limit);	
	}
	
	function onScrollGalleryDetailsBygalleryCategoryId($galleryCategoryId, $id, $start, $limit)
	{
		$ExtraQryStr = "galleryCategoryId=".$galleryCategoryId." and id < ".$id." ORDER BY id DESC";
		return $this->connect->selectMulti(TBL_GALLERY, "*", $ExtraQryStr, $start, $limit);		
	}
	
	function getCategory()
	{		
		$ExtraQryStr = "order by swapNo";
		return $this->connect->selectMulti(TBL_GALLERY_CATEGORY, "*", $ExtraQryStr, 0, 999);
	}
	function categoryById($categoryId)
	{
		$ExtraQryStr = "categoryId=".$categoryId;
		return $this->connect->selectSingle(TBL_GALLERY_CATEGORY, "*", $ExtraQryStr);
	}
	
	function getDistinctmenucategoryIdFromGallery()
	{        
        $needle = "menucategoryId";
        $CLAUSE = " menucategoryId!=0 and menucategoryId!='' and status='Y' order by menucategoryId";
        return $this->connect->selectDistinct(TBL_GALLERY, $needle, $CLAUSE);		
	}
	
	function downloadDetailsBymenucategoryId($menucategoryId)
	{
		$ExtraQryStr = "menucategoryId=".$menucategoryId." and galleryType='D'";
		return $this->connect->selectMulti(TBL_GALLERY, "*", $ExtraQryStr, 0, 999);	
	}
    
    function galleryUpdateByid($params, $id){
        $CLAUSE = "id = ".$id;
        return $this->connect->updateQuery(TBL_GALLERY, $params, $CLAUSE);
    }
    
    function deleteTempGallery(){
        return $this->connect->executeQuery("delete from tbl_temp_gallery");
    }
    
    function deleteTempGalleryBysessionId($sessionId){
        return $this->connect->executeQuery("delete from tbl_temp_gallery where sessionId='".addslashes($sessionId)."'");
    }
    
    function deleteGalleryByid($id){
        return $this->connect->executeQuery("delete from ".TBL_GALLERY." where id=".$id);
    }
}
?>