<?php
/*class adminSampleClass
{
	private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
    
    -----------------------------------------Product-----------------------------------------------
    
    function checkExistence($ExtraQryStr) {        
        return $this->connect->selectSingle(TBL_SAMPLE, "*", $ExtraQryStr);
    }
    
    function sampleRequestbyId($id){
        
        $ENTITY =   TBL_CONTACT." c 
                    JOIN ".TBL_PRODUCT." p ON ( p.id = c.proId)
                    JOIN ".TBL_MEMBER." m ON ( p.userid = m.id)
                    LEFT JOIN ".TBL_SAMPLE." sm ON ( m.id = sm.userId AND  c.proId= sm.proId)";
        
        $ExtraQryStr = "contactID=".addslashes($id)." AND contactType='S' order by contactEntrydate desc";                 
        return $this->connect->selectSingle($ENTITY, "c.*, p.p_category, p.p_photo, m.name sname, m.surname ssurname, m.email semail, m.id sid, m.phone sphone, m.address saddress, m.country scountry, m.state sstate, m.city scity, m.zip szip, sm.totalQty, sm.sampleId", $ExtraQryStr);        
    }
    
    function sampleDetail($ExtraQryStr){
        return $this->connect->selectSingle(TBL_SAMPLE, '*', $ExtraQryStr);
    }
    
    function sampleUpdateBysampleId($params, $id){
        $CLAUSE = "sampleId = ".$id;
        return $this->connect->updateQuery(TBL_SAMPLE, $params, $CLAUSE);
    }
    
    function newSampleHistory($params)
	{
		return $this->connect->insertQuery(TBL_SAMPLE_HISTORY, $params);
	}
    
    function newSampleQty($params)
	{
		return $this->connect->insertQuery(TBL_SAMPLE_QTY, $params);
	}
    
    function getSampleByLimit($ExtraQryStr, $start, $limit)
	{	        	
		$ExtraQryStr .= " and status='Y' order by productName ASC";
		return $this->connect->selectMulti(TBL_SAMPLE, "*", $ExtraQryStr, $start, $limit);         
	}
    
    function sampleRequests($ExtraQryStr){
        return $this->connect->rowCount(TBL_CONTACT, 'contactId', $ExtraQryStr);
    }
    
    function allsampleRequest($ExtraQryStr, $start, $limit){
        $ExtraQryStr .= " order by contactEntrydate desc";
		return $this->connect->selectMulti(TBL_CONTACT, "*", $ExtraQryStr, $start, $limit);
    }
    
}*/
?>
