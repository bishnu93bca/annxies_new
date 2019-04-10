<?php
class menu
{
    private $connect; 
	public function __construct(){
        $this->connect = new Site;
    }
    
    function newModule($params)
    {        
        return $this->connect->insertQuery(TBL_MODULE, $params);
    }
    
    function menu_count($ExtraQryStr)
	{
        $needle = 'menu_id';
        $CLAUSE = "parent_id=0";
		return $this->connect->rowCount(TBL_MODULE, $needle, $CLAUSE); 
	}
	
	function submenucount($menu_id)
	{
		$needle = 'menu_id';
        $CLAUSE = "parent_id=$menu_id ORDER BY display_order";
		return $this->connect->rowCount(TBL_MODULE, $needle, $CLAUSE); 
	}
	
	function menu_details($ExtraQryStr, $start, $limit)
	{
        $ExtraQryStr .= " ORDER BY display_order";
		return $this->connect->selectMulti(TBL_MODULE, "*", $ExtraQryStr, 0, 50); 	
	}
    
	function menu_details_by_parent_id()
	{
        $ExtraQryStr = "parent_id=0 and status='Y' ORDER BY display_order";
		return $this->connect->selectMulti(TBL_MODULE, "*", $ExtraQryStr, 0, 50); 	
	}
	
    function menuByid($menu_id)
	{
		$ExtraQryStr = "menu_id=".$menu_id;
		return $this->connect->selectSingle(TBL_MODULE, "*", $ExtraQryStr); 	
	}
    
	function menu_by_id($menu_id)
	{
		$ExtraQryStr = "menu_id=$menu_id and status='Y'";
		return $this->connect->selectQuery(TBL_MODULE, "*", $ExtraQryStr, 0, 50); 	
	}
	
	function get_menu()
	{		
		$ExtraQryStr = "status='Y' ORDER BY display_order";
		return $this->connect->selectQuery(TBL_MODULE, "*", $ExtraQryStr, 0, 50); 
	}
	
	function getModules()
	{		
		$ExtraQryStr = "status='Y' and parent_id=0 ORDER BY display_order";
		return $this->connect->selectQuery(TBL_MODULE, "*", $ExtraQryStr, 0, 50);
	}
	
	function getAllMenu()
	{		
		$ExtraQryStr = "status='Y' ORDER BY menu_id";
		return $this->connect->selectQuery(TBL_MODULE, "*", $ExtraQryStr, 0, 50);
	}
	
	function get_submenu($ExtraQryStr, $menu_id)
	{	
		$ExtraQryStr = "parent_id=$menu_id ORDER BY display_order";			
		return $this->connect->selectQuery(TBL_MODULE, "*", $ExtraQryStr, 0, 50);
	}
	
	function welcomepage_main_menu()
    {
		$ExtraQryStr = "parent_id=0 AND status='Y' ORDER BY display_order";
		return $this->connect->selectMulti(TBL_MODULE, "*", $ExtraQryStr, 0, 50);
    }
		
	function welcomepage_sub_menu($mm_id)
	{
		$ExtraQryStr = "parent_id=".$mm_id." AND status='Y' ORDER BY display_order";
		return $this->connect->selectMulti(TBL_MODULE, "*", $ExtraQryStr, 0, 50);
	}
	
	function getModulePackagesAndAddons()
	{
		$ExtraQryStr = "parent_id=0 and type!='D' and status='Y' ORDER BY display_order";
		return $this->connect->selectMulti(TBL_MODULE, "*", $ExtraQryStr, 0, 100);
	}
	
	function getModulePackagesByparent_Id($parent_Id)
	{
		$ExtraQryStr = "parent_id=".$parent_Id." AND type!='D' AND status='Y' ORDER BY display_order";
        return $this->connect->selectMulti(TBL_MODULE, "*", $ExtraQryStr, 0, 50);
	}
	
	function getModuleByparent_Id($parent_Id)
	{
		$ExtraQryStr = "parent_id=".$parent_Id." AND status='Y' ORDER BY display_order";
		return $this->connect->selectMulti(TBL_MODULE, "*", $ExtraQryStr, 0, 50);
	}
	
	function getModuleBymoduleId($moduleId)
	{
		$ExtraQryStr = "menu_id=$moduleId and status='Y'";
		return $this->connect->selectQuery(TBL_MODULE, "*", $ExtraQryStr, 0, 50);
	}
    
    function deleteModuleBymoduleId($menu_id){
        return $this->connect->executeQuery("delete from ".TBL_MODULE." where menu_id = ".$menu_id);
    }
    
    function deleteModuleByparentId($parent_Id){
        return $this->connect->executeQuery("delete from ".TBL_MODULE." where parent_Id = ".$parent_Id);
    }
    
    function updateUserPermission($userId, $permission){
        return $this->connect->executeQuery("update ".TBL_USER." set permission='".$permission."' where id=".$userId);
    }
    
    function checkExistence($ExtraQryStr) {        
        return $this->connect->selectQuery("select * from ".TBL_MODULE." where ".$ExtraQryStr);
    }
    
    function moduleUpdateBymoduleId($params, $menu_id){
        $CLAUSE = "menu_id = ".$menu_id;
        return $this->connect->updateQuery(TBL_MODULE, $params, $CLAUSE);
    }
}
?>