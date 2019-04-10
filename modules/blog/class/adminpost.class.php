<?php
class PostClass
{
    private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
    
    function checkExistence($ExtraQryStr) {        
        return $this->connect->selectSingle(TBL_BLOG, "*", $ExtraQryStr);
    }
    
	function newPost($params)
	{
		return $this->connect->insertQuery(TBL_BLOG, $params);
	}
	
	function blogById($blogId)
	{
		$ExtraQryStr = "blogId = ".$blogId;
		return $this->connect->selectSingle(TBL_BLOG, "*", $ExtraQryStr); 	
	}
	
	function postCount($ExtraQryStr)
	{
		$ExtraQryStr .= " and blogType='P'";
		return $this->connect->rowCount(TBL_BLOG, 'blogId', $ExtraQryStr); 
	}
	
	function getPost($ExtraQryStr, $start, $limit)
	{		
		$ExtraQryStr .= " and blogType='P' order by swapNo";
		return $this->connect->selectMulti(TBL_BLOG, "*", $ExtraQryStr, $start, $limit);  
	}
	
	function getPostLast($ExtraQryStr, $start, $limit)
	{		
		$ExtraQryStr .= " and blogType = 'P' order by blogDate desc";
		return $this->connect->selectMulti(TBL_BLOG, "*", $ExtraQryStr, $start, $limit);  
	}
	
	function getComment($ExtraQryStr, $blogId, $start, $limit)
	{		
		$ExtraQryStr .= " and blogType='C' and blogParent = ".$blogId." order by blogDate DESC";
		return $this->connect->selectMulti(TBL_BLOG, "*", $ExtraQryStr, $start, $limit); 
    }
    function blogUpdateByblogId($params, $blogId){
        $CLAUSE = "blogId = ".$blogId;
        return $this->connect->updateQuery(TBL_BLOG, $params, $CLAUSE);
    }
    function deleteBolgByblogId($blogId){        
        return $this->connect->executeQuery("delete from ".TBL_BLOG." where blogId = ".$blogId);
    }
}
?>