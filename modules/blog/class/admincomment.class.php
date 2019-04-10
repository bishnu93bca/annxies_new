<?php
class CommentClass
{
    private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
    
	function newComment($params)
	{
		return $this->connect->insertQuery(TBL_BLOG, $params);
	}
	function getComment($ExtraQryStr, $blogId)
	{		
		$ExtraQryStr .= " and blogType='C' and blogParent=".$blogId." and status='Y' and isApproved='Y' order by blogDate";
		return $this->connect->selectMulti(TBL_BLOG, "*", $ExtraQryStr, 0, 999); 	
	}
	function blogById($blogId)
	{
		$ExtraQryStr = "blogId=".$blogId;
		return $this->connect->selectSingle(TBL_BLOG, "*", $ExtraQryStr);     	
	}
	
	function postCount($ExtraQryStr)
	{
		$ExtraQryStr .=" and blogType='C'";
		return $this->connect->rowCount(TBL_BLOG, 'blogId', $ExtraQryStr); 
	}
	
	function getPost($ExtraQryStr, $start, $limit)
	{		
		$ExtraQryStr .=" and blogType='C' order by blogDate desc";
		return $this->connect->selectMulti(TBL_BLOG, "*", $ExtraQryStr, $start, $limit);  
	}
    
    function commentUpdateById($params, $blogId){
        $CLAUSE = "blogId = ".$blogId;
        return $this->connect->updateQuery(TBL_BLOG, $params, $CLAUSE);
    }
}
?>