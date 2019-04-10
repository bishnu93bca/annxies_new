<?php
class ViewTestimonial
{
    private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
	function getTestimonial($ExtraQryStr, $start, $limit)
	{
		$ExtraQryStr = $ExtraQryStr." order by swapNo" ;
		return $this->connect->selectMulti(TBL_TESTIMONIAL, "*", $ExtraQryStr, $start, $limit);  			
	}
    
    function newTestimonial($params)
	{		
        return $this->connect->insertQuery(TBL_TESTIMONIAL, $params);
	}
    
    function testimonialUpdateBytestimonialId($params, $testimonialId){
        $CLAUSE = "testimonialId = ".addslashes($testimonialId);
        return $this->connect->updateQuery(TBL_TESTIMONIAL, $params, $CLAUSE);
    }
	
	function getTestimonialByLimit($ExtraQryStr, $start, $limit)
	{		
        $ExtraQryStr .= " and status='Y' order by entryDate desc";
        return $this->connect->selectMulti(TBL_TESTIMONIAL, "*", $ExtraQryStr, $start, $limit); 
	}
	
	function countTestimonial($ExtraQryStr)
	{		
		$ExtraQryStr .= " and status='Y'";
		return $this->connect->rowCount(TBL_TESTIMONIAL, 'testimonialId', $ExtraQryStr); 	
	}
	
	function getTestimonialBytestimonialId($testimonialId)
	{		
		$ExtraQryStr = "testimonialId=".addslashes($testimonialId)." and status='Y'";
		return $this->connect->selectSingle(TBL_TESTIMONIAL, "*", $ExtraQryStr); 	
	}
	function getTestimonialBypermalink($permalink)
	{		
		$ExtraQryStr = "permalink='".addslashes($permalink)."' and status='Y'";
		return $this->connect->selectSingle(TBL_TESTIMONIAL, "*", $ExtraQryStr); 		
	}
}
?>