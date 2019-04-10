<?php
class MyAccount
{	
	private $connect; 
	public function __construct(){
        $this->connect = new Site;
    }
    
    function getAccountDetailsByuserId($userId)
	{
        $params = array();
        $params[] = "usr.*";
        $params[] = "st.*";
        $ExtraQryStr = "usr.id = ".$userId." and st.siteId = usr.siteId";
		return $this->connect->selectSingle(TBL_USER." usr, ".TBL_SITE." st", $params, $ExtraQryStr); 	
	}
}
?>