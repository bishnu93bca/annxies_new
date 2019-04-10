<?php
class Contact
{
	private $connect; 
	public function __construct(){
        $this->connect = new Site;
    }
    
    function newContact($params)
	{		
        return $this->connect->insertQuery(TBL_CONTACT, $params);
	}
    
    function getContacts($ExtraQryStr)
	{
		$ExtraQryStr .= " order by contactEntrydate desc";
		return $this->connect->selectMulti(TBL_CONTACT, "*", $ExtraQryStr, 0, 999); 
	}	
    
    function getContactsByLimit($ExtraQryStr,$start,$limit){
        
         $ENTITY =   TBL_CONTACT." c 
                    JOIN ".TBL_MEMBER." m ON (m.id = c.userId)
                    JOIN ".TBL_COUNTRIES." ct ON (ct.shortname = m.country)";

        return $this->connect->selectMulti($ENTITY, "c.*, m.address, ct.name country", $ExtraQryStr, $start, $limit);
    }
    
    function contactById($contactID)
	{
		$ExtraQryStr = " contactID=".addslashes($contactID);
		return $this->connect->selectSingle(TBL_CONTACT, "*", $ExtraQryStr); 
	}
    
	function contactByemail($email)
	{
		$ExtraQryStr = " email='".addslashes($email)."'";
		return $this->connect->selectSingle(TBL_CONTACT, "*", $ExtraQryStr);
	} 
    
    function getEmailBodyById($id){
    	$ExtraQryStr = " id=".addslashes($id);
    	return $this->connect->selectSingle(TBL_EMAIL_BODY, "*", $ExtraQryStr);
    }
    
    function deleteContactByid($contactID){
        return $this->connect->executeQuery("delete from ".TBL_CONTACT." where contactID = ".addslashes($contactID));
    }
    function contactUpdateBycontactId($params, $contactId){
    	$CLAUSE = "contactID = ".$contactId;
    	return $this->connect->updateQuery(TBL_CONTACT, $params, $CLAUSE);
    }
    function getCurlData($url)
    {							
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
        $curlData = curl_exec($curl);
        curl_close($curl);
        return $curlData;
    }
    function contactCount($ExtraQryStr)
	{
        return $this->connect->rowCount(TBL_CONTACT, 'c_id', $ExtraQryStr); 
	}
}
?>