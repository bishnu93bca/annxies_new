<?php
class gallery
{
    private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
    
    function gallery_count($ExtraQryStr)
	{
		return $this->connect->rowCount(TBL_GALLERY, 'id', $ExtraQryStr); 
	}

	function gallery_details($ExtraQryStr, $start, $limit, $orderType, $order)
	{
        $ExtraQryStr .= " and galleryType='P' order by ".$orderType." ".$order;
        return $this->connect->selectMulti(TBL_GALLERY, "*", $ExtraQryStr, $start, $limit); 
	}	
	
	function galleryDetailsBymenucategoryId($menucategoryId)
	{
		$ExtraQryStr = "menucategoryId=".addslashes($menucategoryId)." and status='Y' and galleryType='P' order by swapNo";
		return $this->connect->selectMulti(TBL_GALLERY, "*", $ExtraQryStr, $start, $limit); 		
	}
	
	function videoDetailsBymenucategoryId($menucategoryId, $start, $limit)
	{
		$ExtraQryStr = "menucategoryId=".addslashes($menucategoryId)." and status='Y' and galleryType='V'";
		return $this->connect->selectMulti(TBL_GALLERY, "*", $ExtraQryStr, $start, $limit); 	
	}
    
	function gallery_list($id, $start, $limit)
	{
		$ExtraQryStr = "status = 'Y' and galleryType='P' order by swapno desc";
        return $this->connect->selectMulti(TBL_GALLERY, "*", $ExtraQryStr, $start, $limit);
	}

	function galleryBygalleryCategoryId($galleryCategoryId, $start, $limit)
	{
		$ExtraQryStr = "status='Y' and galleryCategoryId=".addslashes($galleryCategoryId)." and siteId=36 and galleryType='P' order by swapno";
        return $this->connect->selectMulti(TBL_GALLERY, "*", $ExtraQryStr, $start, $limit);
	}
}
?>