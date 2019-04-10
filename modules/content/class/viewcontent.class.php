<?php
class ContentView
{
    private $connect; 
	public function __construct(){
        $this->connect = new Site;
    }
    
	function getContentBycontentID($contentID)
	{
		return $this->connect->selectSingle(TBL_CONTENT, "*", "contentID=".addslashes($contentID)." and contentStatus='Y'"); 	
	}
	function getContentBymenuID($menucategoryId)
	{
		return $this->connect->selectSingle(TBL_CONTENT, "*", "menucategoryId=".addslashes($menucategoryId)." and contentStatus='Y'"); 	
	}
    
	function getContentBycontentHeading($contentHeading)
	{
		$ExtraQryStr = "contentHeading='".addslashes($contentHeading)."' and contentStatus='Y'";
		return $this->connect->selectSingle(TBL_CONTENT, "*", $ExtraQryStr); 
	}
    
	function getContentBycontentHeadingAndsiteId($contentHeading)
	{
		$ExtraQryStr = "contentHeading='".addslashes($contentHeading)."' and contentStatus='Y'";
		return $this->connect->selectSingle(TBL_CONTENT, "*", $ExtraQryStr); 
	}
	
	function countContentbymenucategoryId($menucategoryId)
	{
        $needle = 'contentID';
        $CLAUSE = "menucategoryId=".addslashes($menucategoryId)." and contentStatus='Y'";
		return $this->connect->rowCount(TBL_CONTENT, $needle, $CLAUSE); 
	}

	function getContentbymenucategoryId($menucategoryId, $start, $limit)
	{
		$ExtraQryStr = "menucategoryId=".addslashes($menucategoryId)." and contentStatus='Y' order by contentSwapNo desc";
		return $this->connect->selectMulti(TBL_CONTENT, "*", $ExtraQryStr, $start, $limit);
	}	

	function countGallerybymenucategoryId($menucategoryId)
	{
        $needle = 'id';
        $CLAUSE = "menucategoryId=".addslashes($menucategoryId)." and galleryType='P' and status='Y'";
		return $this->connect->rowCount(TBL_GALLERY, $needle, $CLAUSE);
	}
	
	function getGallerybymenucategoryId($menucategoryId, $start, $limit)
	{
		$ExtraQryStr = "menucategoryId=".addslashes($menucategoryId)." and galleryType='P' and status='Y' order by swapNo";
        return $this->connect->selectMulti(TBL_GALLERY, "*", $ExtraQryStr, $start, $limit);
	}	

	function getGallerybyimagepath($imagepath, $start, $limit)
	{
		$ExtraQryStr = "imagepath='".addslashes($imagepath)."' and status='Y' order by swapNo";
        return $this->connect->selectMulti(TBL_GALLERY, "*", $ExtraQryStr, $start, $limit);
	}

	function getGalleryCategoryBymenucategoryId($menucategoryId)
	{
		$ExtraQryStr = "menucategoryId=".addslashes($menucategoryId)." and status='Y'";
		return $this->connect->selectSingle(TBL_GALLERY_CATEGORY, "*", $ExtraQryStr);
	}

	function getGallerybycategoryId($galleryCategoryId, $start, $limit)
	{
		$ExtraQryStr = "galleryCategoryId=".addslashes($galleryCategoryId)." and status='Y' order by swapNo";
		return $this->connect->selectMulti(TBL_GALLERY, "*", $ExtraQryStr, $start,$limit);
	}

	function getContentbymenucategoryIdAndPermalink($menucategoryId, $permalink)
	{
		$ExtraQryStr = "menucategoryId=".addslashes($menucategoryId)." and contentStatus='Y' and permalink='".addslashes($permalink)."' order by contentSwapNo";
        return $this->connect->selectSingle(TBL_CONTENT, "*", $ExtraQryStr);
	}
	
	function getContentbyPermalink($permalink)
	{
		$ExtraQryStr = "contentStatus='Y' and permalink='".addslashes($permalink)."' order by contentSwapNo";
        return $this->connect->selectSingle(TBL_CONTENT, "*", $ExtraQryStr);
	}
}
?>