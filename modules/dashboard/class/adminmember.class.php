<?php
class MemberAdmin
{
    private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
    
    function checkExistenceByEmail($email, $ExtraQryStr) {   
        $ExtraQryStr .= " and (email = '".addslashes($email)."' or username='".addslashes($email)."')";
        return $this->connect->selectSingle(TBL_MEMBER, "*", $ExtraQryStr);
    }
	
    function newMember($params)
	{
		return $this->connect->insertQuery(TBL_MEMBER, $params);
	}
    
    function memberCount($ExtraQryStr)
	{
		return $this->connect->rowCount(TBL_MEMBER, 'id', $ExtraQryStr); 
	}
	
	function getMemberDetails($ExtraQryStr, $start, $limit)
	{
		$ExtraQryStr .= " order by name";
		return $this->connect->selectMulti(TBL_MEMBER, "*", $ExtraQryStr, $start, $limit);
	}
	
	function getMemberInfoByid($id)
	{		
		/*$ExtraQryStr = "id=".addslashes($id);
		return $this->connect->selectSingle(TBL_MEMBER, "*", $ExtraQryStr);*/
        
        $ENTITY =   TBL_MEMBER." m 
                    LEFT JOIN ".TBL_COMPANY." c ON (c.user_id = m.id) 
                    LEFT JOIN ".TBL_PAY." p ON ( p.id_user = m.id) 
                    LEFT JOIN ".TBL_PRODUCT." r ON ( r.userid = m.id)";
                
        $ExtraQryStr = "m.id=".addslashes($id)." AND m.status='Y' group by m.id order by m.name ASC";         
        
        return $this->connect->selectSingle($ENTITY, "m.*, c.id companyId, c.companylogo, c.reviewCount, p.plan, p.mjesec valid, p.datum_start,p.id_pay,r.id productId", $ExtraQryStr);	   
        
        
	}
    
    function memberUpdateById($params, $id){
        $CLAUSE = "id = ".addslashes($id);
        return $this->connect->updateQuery(TBL_MEMBER, $params, $CLAUSE);
    }
    
	function getRandomPassword($length = 8) {
		$randstr;
		srand((double) microtime(TRUE) * 1000000);
		//our array add all letters and numbers if you wish
		$chars = array(
				'1', '2', '3', '4', '5',
				'6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k',
				'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');

		for ($rand = 0; $rand <= $length; $rand++) {
			$random = rand(0, count($chars) - 1);
			$randstr .= $chars[$random];
		}
		return $randstr;
	}

	function delete($id){
    	
         return $this->connect->executeQuery("delete from ".TBL_JOBS." where id = ".addslashes($id));

        // ALTER TABLE `tablename` DROP `columnname`;
    }

    function getMemberByEmail($email)
    {
        $ExtraQryStr = "username='".addslashes($email)."' or email='".addslashes($email)."'";
        return $this->connect->selectSingle(TBL_MEMBER, "*", $ExtraQryStr); 
    }
    function newSeller($params)
	{
		return $this->connect->insertQuery(TBL_MEMBER, $params);
	}
    
    function sellerCount($ExtraQryStr)
	{
		return $this->connect->rowCount(TBL_MEMBER, 'id', $ExtraQryStr); 
	}
    
    
    
    /*-----------------SAMPLE----------------*/  
        
    function allsampleRequest($ExtraQryStr, $start, $limit){
        $ExtraQryStr .= " order by contactEntrydate desc";
		return $this->connect->selectMulti(TBL_CONTACT, "*", $ExtraQryStr, $start, $limit);
    }   
    
    function samplebyId($id){
        
        $ENTITY =   TBL_SAMPLE." sm
                    JOIN ".TBL_MEMBER." m ON ( sm.userId = m.id)";
                    /*LEFT JOIN ".TBL_SAMPLE_ATTRIBUTE." sa ON ( sm.sampleId = sa.sampleId)*/
        
        $ExtraQryStr = "sampleId=".addslashes($id);                 
        return $this->connect->selectSingle($ENTITY, "sm.*, m.name sname, m.surname ssurname, m.email semail, m.id sid, m.phone sphone, m.address saddress, m.country scountry, m.state sstate, m.city scity, m.zip szip", $ExtraQryStr);        
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
    
    function getSampleQtyDetails($ExtraQryStr, $start, $limit)
	{ 
        $ExtraQryStr .= " order by entryDate desc ";
        return $this->connect->selectMulti(TBL_SAMPLE_QTY, "*", $ExtraQryStr, $start, $limit); 
	}
    
    function newsampleContract($params)
	{
		return $this->connect->insertQuery(TBL_CONTRACT, $params);
	}
    
    function getSampleByLimit($ExtraQryStr, $start, $limit)
	{	        	
		$ExtraQryStr .= " and status='Y' order by productName ASC";
		return $this->connect->selectMulti(TBL_SAMPLE, "*", $ExtraQryStr, $start, $limit);        
	}
    
    function sampleCount($ExtraQryStr){
        return $this->connect->rowCount(TBL_SAMPLE, 'sampleId', $ExtraQryStr);
    }
    
    function sampleRequests($ExtraQryStr){
        return $this->connect->rowCount(TBL_CONTACT, 'contactId', $ExtraQryStr);
    }
    
    function sampleRequestCount($id){
        $ExtraQryStr = " userId = ".addslashes($id)." AND contactType='S'";
        return $this->connect->rowCount(TBL_CONTACT, 'contactId', $ExtraQryStr);
    }    
    
    function sampleRequest($id, $start, $limit){
        
        $ENTITY =   TBL_CONTACT." c 
                    LEFT JOIN ".TBL_REQUIREMENT_ATTRIBUTE." r ON ( c.contactId = r.contactId)";
                
        $ExtraQryStr = "c.userId=".addslashes($id)." AND c.contactType='S' order by c.contactEntrydate desc";         
        
        return $this->connect->selectMulti($ENTITY, "c.*, r.attributeId, r.attributeValue, r.attributeValue", $ExtraQryStr, $start, $limit);	
    }
    
    
    /*---------------------------------*/  
    function getSellerDetails($ExtraQryStr, $start, $limit)
	{          
        $ENTITY =   TBL_MEMBER." m 
                    LEFT JOIN ".TBL_COMPANY." c ON (c.user_id = m.id) 
                    LEFT JOIN ".TBL_PAY." p ON ( p.id_user = m.id) 
                    LEFT JOIN ".TBL_PRODUCT." r ON ( r.userid = m.id)";
                
        $ExtraQryStr .= " AND m.status='Y' group by m.id order by m.name ASC";         
        
        return $this->connect->selectMulti($ENTITY, "m.*, c.id companyId, c.companylogo, c.reviewCount, p.plan, p.mjesec valid, p.datum_start,p.id_pay,r.id productId", $ExtraQryStr, $start, $limit);	   
	}
    
    
	
	function getSellerInfoByid($id)
	{		
		$ExtraQryStr = "id=".addslashes($id);
		return $this->connect->selectSingle(TBL_MEMBER, "*", $ExtraQryStr);
	}
    
    function sellerUpdateById($params, $id){
        $CLAUSE = "id = ".addslashes($id);
        return $this->connect->updateQuery(TBL_MEMBER, $params, $CLAUSE);
    }
    /*-------------------------------------------------------------*/
    function getCompanyInfoByuserid($id)
	{		
		$ExtraQryStr = "user_id=".addslashes($id);
		return $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr);
	}
    function companyUpdateById($params, $id){
        $CLAUSE = "id = ".addslashes($id);
        return $this->connect->updateQuery(TBL_COMPANY, $params, $CLAUSE);
    }
    function getMembershipInfoByuserid($id)
	{		
		$ExtraQryStr = "id_user=".addslashes($id);
		return $this->connect->selectSingle(TBL_PAY, "*", $ExtraQryStr);
	}
    /*---------------State and Office------------------------------*/
    
    function checkExistenceOffice($ExtraQryStr) {        
        return $this->connect->selectSingle(TBL_OFFICE, "*", $ExtraQryStr);
    }
    function newOffice($params)
	{
		return $this->connect->insertQuery(TBL_OFFICE, $params);
	}
	function getOfficeDetails($ExtraQryStr, $start, $limit)
	{
		$ExtraQryStr .= " order by id_office";
		return $this->connect->selectMulti(TBL_OFFICE, "*", $ExtraQryStr, $start, $limit);
	}
    
    function officeCount($ExtraQryStr)
	{
		return $this->connect->rowCount(TBL_OFFICE, 'id_office', $ExtraQryStr); 
	}
    
	function getOfficeInfoByid($id)
	{		
		$ExtraQryStr = "id_office=".addslashes($id);
		return $this->connect->selectSingle(TBL_OFFICE, "*", $ExtraQryStr);
	}
    function officeUpdateById($params, $id){
        $CLAUSE = "id_office = ".addslashes($id);
        return $this->connect->updateQuery(TBL_OFFICE, $params, $CLAUSE);
    }
    
	function deleteOffice($id){    	
         return $this->connect->executeQuery("delete from ".TBL_OFFICE." where id_office = ".addslashes($id));
    }
    
    function readstate($state)
    {
        $ExtraQryStr = " 1";
		$records = $this->connect->selectMulti(TBL_STATES, "*", $ExtraQryStr, 0, 100);
                
        foreach($records as $data)
        {
            if($data[state_code]==$state)
            {
                $sel='selected="selected"';
            }
            else
            {
                $sel='';
            }
            $html.='<option value="'.$data[state_code].'" '.$sel.'>'.$data[state].'</option>';
        }
        return $html;
    }
    
    function stateBycode($country)
	{ 
        $ExtraQryStr = "state_code='".$country."' order by state asc ";
        return $this->connect->selectSingle(TBL_STATES, "*", $ExtraQryStr); 
	}
    
    
    function newGallery($params)
	{
		return $this->connect->insertQuery(TBL_OFFICE_GALLERY, $params);
	}
    
    function getGalleryByofficeId($officeId)
    {
        $ExtraQryStr = "officeId=".addslashes($officeId);
        return $this->connect->selectMulti(TBL_OFFICE_GALLERY, "*", $ExtraQryStr, 0, 999);  
    }
    
    function deleteGalleryBygalleryId($galleryId){        
        return $this->connect->executeQuery("delete from ".TBL_OFFICE_GALLERY." where galleryId=".addslashes($galleryId));
    }
    
    function galleryBygalleryId($galleryId)
	{
		$ExtraQryStr = "galleryId=".addslashes($galleryId);
		return $this->connect->selectSingle(TBL_OFFICE_GALLERY, "*", $ExtraQryStr);  
	}
    function galleryUpdateBygalleryId($params, $galleryId){
        $CLAUSE = "galleryId = ".addslashes($galleryId);
        return $this->connect->updateQuery(TBL_OFFICE_GALLERY, $params, $CLAUSE);
    }
    /*-----------------------package---------------------------*/
    
    function checkExistencePackage($ExtraQryStr) 
    {        
        return $this->connect->selectSingle(TBL_PACKAGE, "*", $ExtraQryStr);
    }
    function newPackage($params)
	{
		return $this->connect->insertQuery(TBL_PACKAGE, $params);
	}
	function getPackageDetails($ExtraQryStr, $start, $limit)
	{
		$ExtraQryStr .= " order by packageId";
		return $this->connect->selectMulti(TBL_PACKAGE, "*", $ExtraQryStr, $start, $limit);
	}
    
    function packageCount($ExtraQryStr)
	{
		return $this->connect->rowCount(TBL_PACKAGE, 'packageId', $ExtraQryStr); 
	}
    
	function getPackageInfoByid($id)
	{		
		$ExtraQryStr = "packageId=".addslashes($id);
		return $this->connect->selectSingle(TBL_PACKAGE, "*", $ExtraQryStr);
	}
    function packageUpdateById($params, $id){
        $CLAUSE = "packageId = ".addslashes($id);
        return $this->connect->updateQuery(TBL_PACKAGE, $params, $CLAUSE);
    }
    
	function deletePackage($id){    	
         return $this->connect->executeQuery("delete from ".TBL_PACKAGE." where packageId = ".addslashes($id));
    } 
    /*-----------------------------------------------------------------------*/
    function get_general_info($id)
    {
        $ENTITY = TBL_MEMBER." m LEFT JOIN ".TBL_PAY." p ON (m.id = p.id_user) LEFT JOIN ".TBL_OFFICE." o ON (p.id_office = o.id_office)";
        $ExtraQryStr = " m.id = ".addslashes($id);
        
        $data = $this->connect->selectSingle($ENTITY, "m.name, m.surname, m.phone, m.email, m.country, p.plan, p.mjesec, p.datum_start plan_start, p.ofcUse, o.office, o.office_city", $ExtraQryStr);
        
        $plan_start =$data['plan_start'];
        
        $datum_end  =date('Y-m-d', strtotime("+".$data['mjesec']." months", strtotime($plan_start)));
        $plan_end   =$datum_end;
        $danas      =date('Y-m-d');

        $date1      = strtotime($plan_start." 0:00:00");
        $date2      = strtotime($datum_end." 23:59:59");
        $pomA       =  (int)(($date2-$date1)/86400);  


        $date1=date_create($plan_start);
        $date2=date_create($danas);
        $diff=date_diff($date1,$date2);
        $used=$diff->format("%m M / %d d");


        $postotakB=date_diff($date1,$date2);
        $pom2=$postotakB->format("%d");
        $pomB=(int)$pom2;

        @$post=($pomB/$pomA)*100;

        $post=(int)$post;

        
        $item=array('phone'=>$data['phone'], 'email'=>$data['email'], 'country'=>$data['country'], 'office'=>$data['office'], 'office_city'=>$data['office_city'], 'name'=>$data['name'], 'surname'=>$data['surname'], 'mjesec'=>$data['mjesec'], 'plan_start'=>$plan_start, 'plan_end'=>$plan_end, 'used'=>$used, 'posto'=>$post, 'plan'=>$data['plan'], 'ofcUse'=>$data['ofcUse']);				

        return($item);
    }    
    
    function monthlyUsage($id_user, $plan, $plan_start, $plan_end, $mjesec, $ofcUse)
    {
        if($mjesec){
            $html = '<div class="table examTable">
                        <ul class="table_head ui-sortable">
                            <li class="sl">Sl.</li>
                            <li class="u_name" style="width:45%">Monthly Window</li>
                            <li class="t_days" style="width:20%">Allowed Hours</li>
                            <li class="t_days" style="width:15%">Hours Used</li>
                            <li class="sl" style="width:15%">Available</li> 
                        </ul>
                        <ul class="table_elem">';                        
                        $mss = date('M j, Y', strtotime($plan_start));
                        $totalOfcUse = $totalUsedHr = $totalAvlHr = 0;
            
                        for($loop = 0; $loop < $mjesec; $loop++) 
                        {
                            $mss = date('M j, Y', strtotime($mss));
                            $mse = date('M j, Y', strtotime($plan_start.' + '.($loop+1).' month'));


                            $ExtraQryStr = "id_user='".$id_user."' AND datum_from >= '".date('Y-m-d', strtotime($mss))."' AND datum_from <= '".date('Y-m-d', strtotime($mse))."'";
                            $data = $this->connect->selectSingle(TBL_BOOKING, "SUM(hour) as totalHour", $ExtraQryStr);


                            $totalHour  = ($data['totalHour'])? $data['totalHour'].' hr(s)':'-';
                            $hrLeft     = $ofcUse - $data['totalHour'];

                            $available  = ($hrLeft>0)? $hrLeft.' hr(s)':'-';

                            $html       .= '
                                <li>
                                    <span class="sl">'.($loop+1).'</span>
                                    <span class="u_name" style="width:45%">'.$mss.' ~ '.$mse.'</span> 
                                    <span class="t_days" style="width:20%">'.$ofcUse.' hrs</span> 
                                    <span class="t_days" style="width:15%">'.$totalHour.'</span> 
                                    <span class="sl" style="width:15%">'.$available.'</span> 
                                </li>';
                            $mss = date('M j, Y', strtotime($mse.' + 1 day')); 

                            $totalOfcUse += $ofcUse;
                            $totalUsedHr += $totalHour;
                            $totalAvlHr  += $hrLeft;
                        }    
            
             $html.='<li>
                <span style="width:1%" ></span>
                <span style="width:44%" ><strong>'.strtoupper($plan).' Membership ('.date('M j, Y', strtotime($plan_start)).' ~ '.date('M j, Y', strtotime($plan_end)).')</strong></span>
                <span class="sl" style="width:12%"  ><strong>'.$totalOfcUse.' hrs</strong></span> 
                <span class="sl" style="width:28%"  ><strong>'.$totalUsedHr.' hr(s)</strong></span>
                <span class="sl" style="width:15%"  ><strong>'.$totalAvlHr.' hr(s)</strong></span>
            </li>';

            $html .= '</tbody></table>';
            
                        
            $html .=   '</ul>
                    </div>';
            
            return $html;
        }
    }
    
    function readbooking($id_user, $ofcUse, $start, $limit, $pageType, $dtls, $page, $parentId, $moduleId, $type, $redirectString)
    {
        $ENTITY = TBL_BOOKING." b JOIN ".TBL_OFFICE." o ON (b.id_office = o.id_office)";
        $ExtraQryStr = "b.id_user=".addslashes($id_user)." ORDER BY b.startTime";
       
        $bookingData = $this->connect->selectMulti($ENTITY, "b.*, o.office", $ExtraQryStr, $start, $limit);
                
        $f          = 0;
        $c          = 1;
        $q          = 1;
        $usageHr    = 0;

        if($bookingData) {
            $html.= '<div class="table examTable">
                        <ul class="table_head ui-sortable">
                            <li class="sl">Sl.</li>
                            <li class="u_name" style="width:40%">Office</li>
                            <li class="t_days" style="width:10%">Status</li>
                            <li class="sl" style="width:8%">Date</li> 
                            <li class="sl" style="width:8%">Time</li> 
                            <li class="sl" style="width:8%">Usage</li> 
                            <li class="sl" style="width:12%">Status</li> 
                            <li class="sl" style="width:8%">Confirm</li> 
                        </ul>
                        <ul class="table_elem">';  

                        foreach($bookingData as $data)
                        {	
                            $f++;
                            if($q==6)
                            {
                                $c++;
                                $q=0;
                            }

                            if($data[book_status]==0)
                            {   
                                $chk  = 'selected';
                                $book_status='<span class="text-danger"><b>In progress</b></span>';
                            }
                            elseif($data[book_status]==1)
                            {
                                $chk2  = 'selected';
                                $book_status='<span class="text-success"><b>Booked</b></span>';
                            }
                            else
                            {
                                $chk3  = 'selected';
                                $book_status='<span class="text-success"><b>Rejected</b></span>';
                            }


                            $startTime  = (strtotime($data[startTime])>0)? date('h:i A', strtotime($data[startTime])):'-';
                            $hour       = ($data[hour]>0)? $data[hour].' hr(s)':'-';

                            $usageHr    += $data[hour]; 

                            $html.=' <li>
                                    <span class="sl">'.$f.'</span>
                                    <span class="u_name" style="width:40%">'.$data['office'].'</span> 
                                    <span class="t_days" style="width:10%">'.$book_status.'</span> 
                                    <span class="sl" style="width:8%">'.date('M j, Y', strtotime($data[datum_from])).'</span> 
                                    <span class="sl" style="width:8%">'.$startTime.'</span> 
                                    <span class="sl" style="width:8%">'.$hour.'</span>';
                                                        
                            $html.='<span class="sl" style="width:12%"><select name="book_status" class="book_status" style="width:96px;">
                                        <option value="">Status</option>
                                        <option value="0#'.$data['id_booking'].'" '.$chk.'>In progress</option>
                                        <option value="1#'.$data['id_booking'].'" '.$chk2.'>Confirm</option>
                                        <option value="2#'.$data['id_booking'].'" '.$chk3.'>Reject</option>
                                    </select></span>';
                            
                            if($data['isConfirmed']==1){
                                $conStatus = '<img src="images/active.png" alt="Active" width="15" border="0" />';
                                $status="0";
                            }
                            else{
                                $conStatus = '<img src="images/inactive.png" alt="Inactive" width="15" border="0" />';
						        $status="1";
                            }
                            
                            if(strtotime($data[datum_from])>time() && !$data['book_status']){
                               $a = "index.php?pageType=".$pageType."&dtls=".$dtls."&stschgto=".$status."&dtaction=status&action=bookingstatus&editid=".$id_user."&id=".$data['id_booking']."&page=".$page."&parentId=".$parentId."&moduleId=".$moduleId."&type=".$type."&redstr=".$redirectString;
                            }
                            else
                                $a= '#';
                            
                           $html.='<span class="sl" style="width:8%">
                                    <a href='.$a.'>'.$conStatus.'</a>
                                  </span>';
                                    
                                    
                           $html.=' </li>';
                        }
            
                      if($usageHr){
                            $html.='<li>
                                <span style="width:1%" ></span>
                                <span style="width:44%" ><strong>Note:- Allowed hours per month: '.$ofcUse.' hrs.</strong></span>
                                <span style="width:22%" ></span>
                                <span style="width:22%"><strong>Total Usage: '.$usageHr.' hr(s)</strong></span> 
                            </li>';
                      }
                        
                        
            $html .=   '</ul>
                    </div>';
            return $html;
        }
    }
    
    function bookingUpdateById($params, $id){
        $CLAUSE = "id_booking = ".addslashes($id);
        return $this->connect->updateQuery(TBL_BOOKING, $params, $CLAUSE);
    }
    
    
}
?>