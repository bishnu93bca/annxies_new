<?php 
class admin
{
    private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
    
    function lookup($EnteredUname, $EnteredPassword) 
    {
        $ExtraQryStr = "username = '".addslashes($EnteredUname)."' and password = '".addslashes($EnteredPassword)."' and status = 'Y'" ;
        return $this->connect->selectSingle(TBL_USER, "*", $ExtraQryStr); 	
    }

    function siteDetails() 
    {
        $params = array();
        $params[] = "*";
        return $this->connect->selectQuery(TBL_SITE, $params, '', 0, 50); 	
    }

    function siteDetailsBysiteId($siteId)
    {
        $ExtraQryStr = "siteId=".addslashes($siteId);
        $params = array();
        $params[] = "*";
        return $this->connect->selectQuery(TBL_SITE, $params, $ExtraQryStr, 0, 1); 	
    }		

    function user_by_fullname($fullname) 
    {
        $ExtraQryStr = "fullname = '".addslashes($fullname)."'";
        $params = array();
        $params[] = "*";
        return $this->connect->selectQuery(TBL_USER, $params, $ExtraQryStr, 0, 1); 	
    }

    function getUserByid($id) 
    {
        $ExtraQryStr = "id = ".addslashes($id);
        $params = array();
        $params[] = "*";
        return $this->connect->selectSingle(TBL_USER, $params, $ExtraQryStr); 	
    }

    function updatePasswordByid($NewPassword, $id)
    {
        $params = array();
        $params['password'] = md5($NewPassword);
        $params['orgPassword'] = $NewPassword;
        $CLAUSE = "id = ".addslashes($id);
        return $this->connect->updateQuery(TBL_USER, $params, $CLAUSE);
    }
}
?>