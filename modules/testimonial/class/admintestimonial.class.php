<?php
class AdminTestimonial
{
	private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
    
    function newTestimonial($params)
	{		
        return $this->connect->insertQuery(TBL_TESTIMONIAL, $params);
	}
    
    function testimonialById($testimonialId)
	{
		$ExtraQryStr = "testimonialId=".addslashes($testimonialId);
		return $this->connect->selectSingle(TBL_TESTIMONIAL, "*", $ExtraQryStr);     
	}
    
    function testimonialCount($ExtraQryStr)
	{
        return $this->connect->rowCount(TBL_TESTIMONIAL, 'testimonialId', $ExtraQryStr); 
	}
    
    function getTestimonialsByLimit($ExtraQryStr, $start, $limit)
	{		
		$ExtraQryStr .= " order by swapNo ";
        return $this->connect->selectMulti(TBL_TESTIMONIAL, "*", $ExtraQryStr, $start, $limit); 
	}
	
	function getTestimonialBytestimonialId($testimonialId)
	{		
        $ExtraQryStr = "testimonialId=".addslashes($testimonialId);
		return $this->connect->selectSingle(TBL_TESTIMONIAL, "*", $ExtraQryStr);  	
	}
    
    function testimonialUpdateBytestimonialId($params, $testimonialId){
        $CLAUSE = "testimonialId = ".addslashes($testimonialId);
        return $this->connect->updateQuery(TBL_TESTIMONIAL, $params, $CLAUSE);
    }
    
    function deleteBytestimonialId($testimonialId){        
        return $this->connect->executeQuery("delete from ".TBL_TESTIMONIAL." where testimonialId = ".addslashes($testimonialId));
    }
}
?>