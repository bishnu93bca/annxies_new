<?php
class Comment
{
    private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
    
    function newComment($params)
	{
		return $this->connect->insertQuery(TBL_BLOG, $params);
	}
	
    
	function blogById($blogId)
	{
		$ExtraQryStr = "blogId=".addslashes($blogId)." and status='Y'";
		return $this->connect->selectSingle(TBL_BLOG, "*", $ExtraQryStr); 	
	}
	
	function postCount($ExtraQryStr,$siteId,$Link,$blogId)
	{
		$sql = "SELECT COUNT(blogId) FROM  ".TBL_BLOG." WHERE blogType='C' and status='Y' and blogParent=$blogId";
		$query = mysql_query("$sql");
		$count = @mysql_result($query,0,0);
		return $count;
	}
    function commentCount($ExtraQryStr, $blogId)
	{
		$ExtraQryStr .= " and blogParent = '".$blogId."' and blogType='C' and status='Y' and isApproved='Y' ";
		return $this->connect->rowCount(TBL_BLOG, 'blogId', $ExtraQryStr); 
	}
	
	function getComment($ExtraQryStr, $blogId)
	{		
		$ExtraQryStr .= " and blogType='C' and blogParent=".$blogId." and status='Y' and isApproved='Y' order by blogDate";
		return $this->connect->selectMulti(TBL_BLOG, "*", $ExtraQryStr, 0, 999); 	
	}
	
	function getCommentByHeading($ExtraQryStr, $blog)
	{		
		$ExtraQryStr .= " and blogType='P'  and status='Y' order by blogDate";
		return $this->connect->selectMulti(TBL_BLOG, "*", $ExtraQryStr, 0, 999);
	}
	
	function getCommentIDByHeading($blog)
	{		
		$ExtraQryStr = "blogTitle='".addslashes($blog)."' and status='Y' order by blogDate";
		return $this->connect->selectMulti(TBL_BLOG, "*", $ExtraQryStr, 0, 999);
	}
	
	function getCommentIDBypermalink($permalink)
	{		
		$ExtraQryStr = "permalink='".addslashes($permalink)."' and status='Y' order by blogDate";
		return $this->connect->selectMulti(TBL_BLOG, "*", $ExtraQryStr, 0, 999);
	}	
	function CommentUpdateByblogId($params, $blogId){
		$CLAUSE = "blogId = ".$blogId;
		return $this->connect->updateQuery(TBL_BLOG, $params, $CLAUSE);
	}	
}
?>