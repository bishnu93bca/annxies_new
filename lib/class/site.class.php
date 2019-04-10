<?php
class Site
{
    private $_results = array();
    private $_connect;

    public function __construct(){
        $this->_connect = $this->dbconnect();
    }
    
    public function __set($var,$val){
        $this->_results[$var] = $val;
    }

    public function __get($var){  
        if (isset($this->_results[$var])){
            return $this->_results[$var];
        }
        else{
            return null;
        }
    }
    
    private function dbconnect() {
        $Link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die ("<br/>Could not connect to MySQL server");
        return $Link;
    }
    
    public function dbdisconnect(){
        mysqli_close($this->_connect);
    }
    
    public function selectQuery($ENTITY, $params, $CLAUSE, $start, $limit){
        $fieldList = is_array($params) ? implode(', ', $params) : $params;
        if($fieldList=='')
            $fieldList = '*';
        if(!$CLAUSE)
            $CLAUSE = 1;
        $sql = "SELECT ".$fieldList." FROM ".$ENTITY." WHERE ".$CLAUSE." LIMIT ".$start.", ".$limit;
        $res = mysqli_query($this->_connect, $sql);		
        $records = array(); 
        if(mysqli_num_rows($res)>1){
            while ($row = mysqli_fetch_assoc($res)){
                foreach ($row as $k=>$v){
                    $this->_results[$k] = $v;
                }
                $records[] = $this->_results;
            }   
        }
        else
            $records = mysqli_fetch_assoc($res);
        return $records;  
    }
    
    public function selectMulti($ENTITY, $params, $CLAUSE, $start=0, $limit=1){
        $fieldList = is_array($params) ? implode(', ', $params) : $params;
        if($fieldList=='')
            $fieldList = '*';
        if(!$CLAUSE)
            $CLAUSE = 1;
        $sql = "SELECT ".$fieldList." FROM ".$ENTITY." WHERE ".$CLAUSE." LIMIT ".$start.", ".$limit;
        $res = mysqli_query($this->_connect, $sql);		
        $records = array(); 
        while ($row = mysqli_fetch_assoc($res)){
            foreach ($row as $k=>$v){
                $this->_results[$k] = $v;
            }
            $records[] = $this->_results;
        }   
        return $records;  
    }
    
    public function selectMultiOnLeft($ENTITY1, $ENTITY2, $params, $CLAUSE, $start=0, $limit=1){
        $fieldList = is_array($params) ? implode(', ', $params) : $params;
        if($fieldList=='')
            $fieldList = '*';
        if(!$CLAUSE)
            $CLAUSE = 1;
        $sql = "SELECT ".$fieldList." FROM ".$ENTITY1." LEFT JOIN ".$ENTITY2." ON ".$CLAUSE." LIMIT ".$start.", ".$limit;
        $res = mysqli_query($this->_connect, $sql);		
        $records = array(); 
        while ($row = mysqli_fetch_assoc($res)){
            foreach ($row as $k=>$v){
                $this->_results[$k] = $v;
            }
            $records[] = $this->_results;
        }   
        return $records;  
    }
    
    public function selectSingle($ENTITY, $params, $CLAUSE){
        $fieldList = is_array($params) ? implode(', ', $params) : $params;
        if($fieldList=='')
            $fieldList = '*';
        if(!$CLAUSE)
            $CLAUSE = 1;
        $sql = "SELECT ".$fieldList." FROM ".$ENTITY." WHERE ".$CLAUSE;
        $res = mysqli_query($this->_connect, $sql);		
        $records = array(); 
        $records = mysqli_fetch_assoc($res);
        return $records;
    }
    
    public function rowCount($ENTITY, $needle, $CLAUSE){
        if(!$CLAUSE)
            $CLAUSE = 1;
        $sql = "SELECT COUNT(".$needle.") AS count FROM ".$ENTITY." WHERE ".$CLAUSE;        
        $query=mysqli_query($this->_connect, $sql);	
        $record = mysqli_fetch_assoc($query);
		$count = $record['count'];
		return $count;
    }
    
    public function selectDistinct($ENTITY, $needle, $CLAUSE){
        if(!$CLAUSE)
            $CLAUSE = 1;
        $sql = "SELECT DISTINCT(".$needle.") AS ".$needle." FROM ".$ENTITY." WHERE ".$CLAUSE;        
        $query=mysqli_query($this->_connect, $sql);	
        $record = mysqli_fetch_assoc($query);
		$distinct = $record[$needle];
		return $distinct;
    }
    
    public function insertQuery($ENTITY, $params){
        $fields = array();
        $fieldVals = array();
        foreach($params as $param=>$pval){
            $fields[] = $param;
            $fieldVals[] = "'".addslashes($pval)."'";
        }        
        $sql = "INSERT INTO ".$ENTITY." (".implode(', ', $fields).") VALUES (".implode(', ', $fieldVals).")";
        $query=mysqli_query($this->_connect, $sql);	
		if(mysqli_affected_rows($this->_connect))
			return mysqli_insert_id($this->_connect);
		else
			return 0;
    }
    
    public function updateQuery($ENTITY, $params, $CLAUSE){
        $fields = array();
        foreach($params as $param=>$pval){
            $fields[] = $param."='".addslashes($pval)."'";
        }
        if(!$CLAUSE)
          $CLAUSE = 1;
        $sql = "UPDATE ".$ENTITY." SET ".implode(', ', $fields)." WHERE ".$CLAUSE;
        $result=mysqli_query($this->_connect, $sql) or die("Cannot execute the query");
        if(mysqli_affected_rows($this->_connect))
            return 1; 
        else									
            return 0;
    } 
    
    public function executeQuery($sql){
        $result=mysqli_query($this->_connect, $sql) or die("Cannot execute the query");
    }
    
    function getSiteBysiteId($siteId)
	{
        return $this->selectSingle(TBL_SITE, "*", "siteId=".$siteId);
	}
    
	function getSiteBysiteURL($siteURL)
	{	
        return $this->selectSingle(TBL_SITE, "*", "siteUrl='".$siteURL."'");
	}
    
	function getDefaultTitleAndMeta()
	{
        return $this->selectSingle(TBL_TITLE_AND_META, "*", "titleandMetaUrl ='/' and titleandMetaType ='D' and status = 'Y'");
	}
    
	function getTitleMetaByURL($url)
	{
		return $this->selectSingle(TBL_TITLE_AND_META, "*", "titleandMetaUrl='".$url."' and status = 'Y'");	
	}
    
    function redirectTo404($SITE_LOC_PATH){
		header("HTTP/1.0 404 Not Found");
		echo '<center class="st_404" style="margin:20px;"><h1>404</h1><h2>Page Not Found</h2>';
		echo 'The URL that you have requested could not be found.</center>';
        //header('location:'.$SITE_LOC_PATH.'/404/');
        //exit();
    }
    
    function redirectToURL($URL){
        header('location:'.$URL);
        exit();
    }
    
    function underConstruction(){
        include("underconstruction/index.php");
        exit();
    }
    
	function getcanonicalByURL($url)
	{
		return $this->selectSingle(TBL_CANONICAL, "*", "canonicalUrl='".$url."' and status = 'Y'");	
	}
}
?>