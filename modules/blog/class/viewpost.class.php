<?php
class Post
{
    private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
	
	function postCount($ExtraQryStr)
	{
		$ExtraQryStr .= " and blogType='P' and status='Y'";
		return $this->connect->rowCount(TBL_BLOG, 'blogId', $ExtraQryStr); 
	}
	
	function getPostByLimit($ExtraQryStr, $start, $limit)
	{		
		$ExtraQryStr .= " and status='Y' order by blogDate desc";
		return $this->connect->selectMulti(TBL_BLOG, "*", $ExtraQryStr, $start, $limit); 
	}
	
	function blogByPermalink($permalink)
	{
		$ExtraQryStr = "permalink='".addslashes($permalink)."' and status='Y'";
		return $this->connect->selectSingle(TBL_BLOG, "*", $ExtraQryStr); 
	}
	function getarchivesByyear($ExtraQryStr)
	{
		//return $this->connect->executeQuery("delete from ".TBL_CART_TEMP." where sessionId = '".addslashes($sessionId)."'");
		return $this->connect->executeQueryNew("SELECT DISTINCT MONTHNAME(blogDate) AS 'Month' FROM ".TBL_BLOG." where $ExtraQryStr ORDER BY blogDate DESC");
	}	
    function getblogByLimit($ExtraQryStr, $start, $limit)
	{
		$ExtraQryStr = "(".$ExtraQryStr.") and tb.status='Y' and tb.categoryId = tbc.categoryId order by tb.swapNo";
		return $this->connect->selectMulti(TBL_BLOG." tb, ".TBL_BLOG_CATEGORY." tbc", "tb.*, tbc.permalink cat_permalink", $ExtraQryStr, $start, $limit);
	}
    function blogByPermalinkandExtraQryStr($permalink,$ExtraQryStr)
	{
		$ExtraQryStr .= " and permalink='".addslashes($permalink)."' and status='Y'";
		return $this->connect->selectSingle(TBL_BLOG, "*", $ExtraQryStr); 
	}
}
?>