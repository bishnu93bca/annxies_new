<?php
class user
{
    private $connect; 
	public function __construct(){
        $this->connect = new Site;
    }
    
    function user_count($ExtraQryStr)
	{
        $needle = 'id';
		return $this->connect->rowCount(TBL_USER, $needle, $ExtraQryStr); 
	}
	
	function user_details($start, $limit)
	{
		$ExtraQryStr = "usertype!='A'";
		return $this->connect->selectMulti(TBL_USER, "*", $ExtraQryStr, $start, $limit); 	
	}
	
	function user_by_id($user_id)
	{
		$ExtraQryStr = "id=".$user_id;
		return $this->connect->selectSingle(TBL_USER, "*", $ExtraQryStr); 		
	}
    
    function user_by_username($username)
	{
		$ExtraQryStr = "username=".addslashes($username);
		return $this->connect->selectSinle(TBL_USER, "*", $ExtraQryStr); 		
	}
	
	function getSiteBysiteId($siteId)
	{
		$ExtraQryStr = "siteId=".$siteId;
		return $this->connect->selectSingle(TBL_SITE, "*", $ExtraQryStr); 		
	}

	function user_status_update($id, $status)
	{
		return $this->connect->executeQuery("UPDATE ".TBL_USER." SET status='".addslashes($status)."' where id = ".$id);
	}
    
    function site_status_update($id, $status)
	{
		return $this->connect->executeQuery("UPDATE ".TBL_SITE." SET status='".addslashes($status)."' where siteId = ".$id);
	}
    
    function userUpdate($params, $id){
        $CLAUSE = "id = ".$id;
        return $this->connect->updateQuery(TBL_USER, $params, $CLAUSE);
    }
}

class UserClass
{
	function user_count($ExtraQryStr, $Link)
	{        
        $needle = 'id';
        $ExtraQryStr = "usertype!='A'";
		return $this->connect->rowCount(TBL_USER, $needle, $ExtraQryStr); 
	}
    
	function user_details()
	{	
        return $this->connect->selectQuery(TBL_USER, "*", "usertype!='A'", 0, 100); 	
	}	
	
	function user_by_id($user_id, $Link)
	{
		return $this->connect->selectQuery(TBL_USER, "*", "id = ".$user_id, 0, 1); 	
	}
	
	function getSiteBysiteId($siteId, $Link)
	{
		return $this->connect->selectQuery(TBL_SITE, "*", "siteId = ".$siteId, 0, 1); 	
	}
	
	function user_status_update($id, $status)
	{
		return $this->connect->executeQuery("UPDATE ".TBL_USER." SET status='".addslashes($status)."' where id = ".$id);
	}
}
?>