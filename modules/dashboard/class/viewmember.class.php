<?php
class MemberView
{	
	private $connect;
    public function __construct(){
        $this->connect = new Site;
    }
	
	function authenticate($email, $password, $trackingId) 
    {
        $EnteredUsername 	= addslashes(trim($email));
        $EnteredPassword 	= md5(addslashes(trim($password)));
        $trackingId 		= addslashes($trackingId);
        $ExtraQryStr = "email = '".$EnteredUsername."' and username='".$trackingId."' and password = '".$EnteredPassword."' and status = 'Y'";
        return $this->connect->selectSingle(TBL_MEMBER, "*", $ExtraQryStr); 	
    }
    
    function logout($redirectUrl){
        session_unset();
        session_regenerate_id();
        $_SESSION['sesId'] = session_id();
        $this->connect->redirectToURL($redirectUrl);
    }    

    function newMember($params)
	{
		return $this->connect->insertQuery(TBL_MEMBER, $params);
	}
    
    function memberUpdateById($params, $id){
        $CLAUSE = "id = ".addslashes($id);
        return $this->connect->updateQuery(TBL_MEMBER, $params, $CLAUSE);
    }
    
    function getMemberByEmail($email)
    {
        $ExtraQryStr = "username='".addslashes($email)."' or email='".addslashes($email)."'";
        return $this->connect->selectSingle(TBL_MEMBER, "*", $ExtraQryStr); 
    }
    
    function getMemberById($id)
    {
        $ExtraQryStr = "id='".addslashes($id)."'";
        return $this->connect->selectSingle(TBL_MEMBER, "*", $ExtraQryStr); 
    }
    
    function getMemberPlan($id)
    {
        $ExtraQryStr = "id_user='".addslashes($id)."'";
        return $this->connect->selectSingle(TBL_PAY, "*", $ExtraQryStr); 
    }
    
    function getTempcontract($id)
    {
        $ExtraQryStr = "tmp_ses='".addslashes($id)."'";
        return $this->connect->selectSingle(TBL_PAY, "*", $ExtraQryStr); 
    }
    
    
    function getMemberByprofileId($profileId)
    {
        $ExtraQryStr = "usertype = 'Student' AND publicId = '".addslashes($profileId)."'";
        return $this->connect->selectSingle(TBL_MEMBER, "id, publicId, rgstrType, usertype, fullname, gender, profilePic, aboutMe, email, lastLogin", $ExtraQryStr); 
    }
    
    function getAnyMemberBypublicId($publicId)
    {
        $ExtraQryStr = "publicId = '".addslashes($publicId)."'";
        return $this->connect->selectSingle(TBL_MEMBER, "publicId, rgstrType, usertype, fullname, gender, profilePic, aboutMe", $ExtraQryStr); 
    }
    
    function getActiveMemberBypublicId($publicId)
    {
        $ExtraQryStr = "publicId = '".addslashes($publicId)."' status = 'Y'";
        return $this->connect->selectSingle(TBL_MEMBER, "publicId, rgstrType, usertype, fullname, gender, profilePic, aboutMe", $ExtraQryStr); 
    }    
    
    function verifyUser($email, $password) 
    {
        $EnteredUsername = addslashes(trim($email));
        $EnteredPassword = md5(addslashes(trim($password)));
        
        $ExtraQryStr = "(email = '".$EnteredUsername."' or username='".$EnteredUsername."' or publicId='".$EnteredUsername."') and password = '".$EnteredPassword."' and usertype = 'Seller' and status = 'Y'";
        return $this->connect->selectSingle(TBL_MEMBER, "*", $ExtraQryStr); 	
    }
    
    function verifyFBUser($email)
    {
        $ExtraQryStr = "username='".addslashes($email)."' and status='Y' and rgstrType='FACEBOOK'";
        return $this->connect->selectSingle(TBL_MEMBER, "*", $ExtraQryStr); 
    }
    function verifySocialUser($email, $type)
    {
    	$ExtraQryStr = "username='".addslashes($email)."' and status='Y' and rgstrType='".$type."'";
    	return $this->connect->selectSingle(TBL_MEMBER, "*", $ExtraQryStr);
    }
    function isFBUser($email){
        $ExtraQryStr = "username='".addslashes($email)."' and rgstrType='FACEBOOK' and status='Y'";
        return $this->connect->selectSingle(TBL_MEMBER, "*", $ExtraQryStr);
    }
    
	function approveMemberForNewEmail($approvedKey)
	{
		$ExtraQryStr = " approvedKey='".addslashes($approvedKey)."'";
		$approveUser = $this->connect->selectSingle(TBL_MEMBER, "tempEmail", $ExtraQryStr);
		if(!empty($approveUser)){
			if($approveUser['tempEmail'] != "")
					return "ok";
			else
				return "error>Already verified.";
		}else{
			return "error>Wrong approval key.";
		}	
	}
	
	function approveMember($approvedKey)
	{
		$ExtraQryStr = " approvedKey='".addslashes($approvedKey)."'";
		$approveUser = $this->connect->selectSingle(TBL_MEMBER, "id, usertype, status, tempEmail, createDate", $ExtraQryStr);
		if(!empty($approveUser)){
			if($approveUser['status'] == "N" && $approveUser['tempEmail']==''){
                
				$params                 = array();
                
                if($approveUser['usertype'] == 'Student')
				    $params["status"]   = "Y";
                
				$params['createDate']   = date("Y-m-d H:i:s");
                $params['approvedKey']  = '';
                
				$CLAUSE                 = " id = ".addslashes($approveUser['id']);
                
				$approved = $this->connect->updateQuery(TBL_MEMBER, $params, $CLAUSE);
				if($approved){
                    if($approveUser['usertype'] == 'Student')
                        return "success>Verified. Please log in.";
                    elseif($approveUser['usertype'] == 'Recruiter')
                        return "success>Email id verified. Please wait untill admin approves your registration.";
				}

			}elseif($approveUser['status'] == "Y" && $approveUser['tempEmail']!=''){
                $params                 = array();
                $params['tempEmail']    = '';
                $params['username']     = $approveUser['tempEmail'];
                $params['email']        = $approveUser['tempEmail'];
                $params['approvedKey']  = '';
                $CLAUSE                 = "id = '".$approveUser['id']."'";
                
				$approved = $this->connect->updateQuery(TBL_MEMBER, $params, $CLAUSE);
                if($approved){
					return "success>Verified. Please log in.";
				}
			}else{
				return "error>Already verified.";
			}
		}else{
			return "error>Wrong approval key.";
		}	
	}
	
	function checkMemberByPassKey($passwordKey)
	{
		$ExtraQryStr = " passwordKey='".$passwordKey."'";
		$userid = $this->connect->selectSingle(TBL_MEMBER, "id", $ExtraQryStr);
		
		if(!empty($userid)){
			return 1;
		}else{
			return "<span class='error'>Wrong forgot password url.</span>";
		}	
	}
	
	function memberUpdateByPassKey($params, $passwordKey){
		$CLAUSE = "passwordKey = '".$passwordKey."'";
		return $this->connect->updateQuery(TBL_MEMBER, $params, $CLAUSE);
	}
	
	function socialConnect($name, $email, $id, $type){
		$exist = $this -> getMemberByEmail($email);
		if(!$exist){
			$params                 = array();
			$params['email']        = $email;
			$params['userTypeId']   = '1';
			$params['usertype']     = 'G';
			$params['rgstrType']    = $type;
			$params['refferId']     = 0;
			$params['username']     = $email;
			$params['orgPassword']  = $password;
			$params['password']     = md5($password);
			$params['createDate']   = date("Y-m-d H:i:s");
			$uData = $this -> newUser($params);
	
			$verify = $this -> verifySocialUser($email, $type);
			if($verify){
				$userTypeData = $this -> getUserTypeDataById($verify['userTypeId']);
				$_SESSION['FUSERLOGIN']     ='ok';
				$_SESSION['FUSERTYPEID']    =$verify['userTypeId'];
				$_SESSION['FUSERTYPE']      =$userTypeData['typeSymbol'];
				$_SESSION['FUSERTYPENAME']  =$userTypeData['typeName'];
				$_SESSION['FUSEREMAIL']     =$verify['email'];
				return 'success>Account created';
			}
			else
				'error>Network error';
		}
		else{
			$verify = $this -> verifySocialUser($email, $type);
			if($verify){
				
				$userTypeData = $this -> getUserTypeDataById($verify['userTypeId']);
				$_SESSION['FUSERLOGIN']     ='ok';
				$_SESSION['FUSERTYPEID']    =$verify['userTypeId'];
				$_SESSION['FUSERTYPE']      =$userTypeData['typeSymbol'];
				$_SESSION['FUSERTYPENAME']  =$userTypeData['typeName'];
				$_SESSION['FUSEREMAIL']     =$verify['email'];
				return 'success>Login Successfull';
				
			}
			else
				return 'error>Your account suspended!';
		}		
	}
    
    function getEmailBodyById($id){
    	$ExtraQryStr = " id=".addslashes($id);
    	return $this->connect->selectSingle(TBL_EMAIL_BODY, "*", $ExtraQryStr);
    }
    
    function memberCount($ExtraQryStr)
	{
        $ExtraQryStr .= " and status='Y'";
		return $this->connect->rowCount(TBL_MEMBER, 'id', $ExtraQryStr); 
	}
	
	function getMemberList($ExtraQryStr, $start, $limit)
	{
		$ExtraQryStr .= " and status='Y' order by fullname";
		return $this->connect->selectMulti(TBL_MEMBER, "*", $ExtraQryStr, $start, $limit);
	}
    
    function get_general_info($id)
    {
        $ENTITY = TBL_MEMBER." m LEFT JOIN ".TBL_PAY." p ON (m.id = p.id_user) LEFT JOIN ".TBL_OFFICE." o ON (p.id_office = o.id_office)";
        $ExtraQryStr = " m.id = ".addslashes($id);
        
        $data = $this->connect->selectSingle($ENTITY, "m.name, m.surname, m.profilePic, m.phone, m.email, m.country, m.state, m.city, m.zip, m.new_phone,m.new_email, p.plan, p.mjesec, p.datum_start plan_start, p.ofcUse, o.office, o.state_code, o.office_city", $ExtraQryStr);
        
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

        
        $item=array('profilePic'=>$data['profilePic'],'phone'=>$data['phone'], 'email'=>$data['email'],  'new_email'=>$data['new_email'],  'new_phone'=>$data['new_phone'], 'country'=>$data['country'], 'office'=>$data['office'], 'state_code'=>$data['state_code'], 'state'=>$data['state'], 'city'=>$data['city'], 'zip'=>$data['zip'], 'office_city'=>$data['office_city'], 'name'=>$data['name'], 'surname'=>$data['surname'], 'mjesec'=>$data['mjesec'], 'plan_start'=>$plan_start, 'plan_end'=>$plan_end, 'used'=>$used, 'posto'=>$post, 'plan'=>$data['plan'], 'ofcUse'=>$data['ofcUse']);				

        return($item);
    }
    function get_company_info($userid){
    
        $ExtraQryStr =  " user_id=".addslashes($userid);
        
        $data = $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr);
        $item = array('companyname'=>$data['companyname'],'company_address'=>$data['company_address'], 'url'=>$data['url']);
         return($item);

    }
    
    function notification($id_user)
    {
        $ExtraQryStr = " user_id=".addslashes($id_user)." and bussiness_type=''";
        $comData = $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr);
        
        if($comData)
        {
            $html.='<span class="date">'.date('Y-m-d H:i:s').' </span><span><a href="company/" class="notibus"><b>Tell us more about your company.</b></a></span></br>';				
        }
        else
        {	
            $prodCount = $this->nrproduct($id_user);
            
            if(!$prodCount)
            {
                $html.='<span class="date">'.date('Y-m-d H:i:s').' </span><span><a href="products/" class="notibus"><b>Add your product.</b></a></span></br>';				
            }	
        }
        
        $ExtraQryStr = "id_user=".addslashes($id_user)." and email_status=1 order by id_sentemail desc";
        $sentMail = $this->connect->selectMulti(TBL_SENT_EMAIL, "*", $ExtraQryStr, 0, 5);
        foreach($sentMail as $data)
        {	
            if($data[procitano]==1)
            {
                $html.='<span class="date">'.$data[datum].' </span><span><a id="'.$data[id_sentemail].'" class="noti" style="cursor:pointer">'.$data[subject].'</a></span></br>';
            }
            else
            {
                $html.='<b><span class="date">'.$data[datum].' </span><span><a id="'.$data[id_sentemail].'" class="noti" style="cursor:pointer">'.$data[subject].'</a></span></b></br>';				  
            }
        }
        return $html;
    }
    
    function nrproduct($id_user){
        $ExtraQryStr = " userid = ".addslashes($id_user);
        return $this->connect->rowCount(TBL_PRODUCT, 'id', $ExtraQryStr, 2);
    }
    
    function reqCount($id_user){
        $ExtraQryStr = " c_id = ".addslashes($id_user)." AND contactType='P'";
        return $this->connect->rowCount(TBL_CONTACT, 'contactID', $ExtraQryStr);
    }
    function mesCount($sellerId){
        $ExtraQryStr = " sellerId = ".addslashes($sellerId);
        return $this->connect->rowCount(TBL_CONTACT, 'contactID', $ExtraQryStr);
    }
    function sampleTransuctionCount($ExtraQryStr){
        return $this->connect->rowCount(TBL_SAMPLE_QTY, 'qtyId', $ExtraQryStr);
    }
    function sampleHistoryCount($ExtraQryStr){
        return $this->connect->rowCount(TBL_SAMPLE_HISTORY, 'sendId', $ExtraQryStr);
    }
    
    /*function reqCount($id_user){
        $ExtraQryStr = " c_id = ".addslashes($id_user);
        return $this->connect->selectMulti(TBL_CONTACT, '*', $ExtraQryStr,0,99999);
    }*/
    
    function nrunread($service, $id_user)
    {
        if($service!='B')
        {            
            $ExtraQryStr = " id_user = ".addslashes($id_user)." AND service = ".addslashes($service)." AND email_status = 1";
            $nr = $this->connect->rowCount(TBL_SENT_EMAIL, 'id_sentemail', $ExtraQryStr);
        }
        
        if($service=='B')
        {            
            $ExtraQryStr = " id_user = ".addslashes($id_user);
            $nr = $this->connect->rowCount(TBL_BOOKING, 'id_booking', $ExtraQryStr);
        }
        return $nr;
    }
    
    function readcountry($shortname)
    {
        if($shortname)
            $ext = "shortname = '".addslashes($shortname)."'";
        else
            $ext = 1;
        
        $ExtraQryStr = $ext." ORDER BY name";
        $countries = $this->connect->selectMulti(TBL_COUNTRIES, "*", $ExtraQryStr, 0, 300);
          
        foreach($countries as $data)
        {
            if($shortname==$data['shortname'])
            {
                $sel='selected="selected"';
            }
            else
            {
                $sel='';
            }
            if($shortname=='')
            {
                if($data['shortname']=='IN')
                {
                    $sel='selected="selected"';
                }
            }			
            $html.='<option value="'.$data['shortname'].'" '.$sel.'>'.$data['name'].'</option>';
        }
        
        return $html;
    }
    
    function companyInfobyUserId($id_user){
        
        $ExtraQryStr = " user_id=".addslashes($id_user);
        return $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr);
    }

    function showmessage($contactID){
        
        $ExtraQryStr = "contactID=".addslashes($contactID)." order by contactEntrydate desc";                 
        $mszData = $this->connect->selectSingle(TBL_CONTACT, "*", $ExtraQryStr); 
        $date = date("d-M-Y", strtotime($mszData['contactEntrydate']));
        $time = date("h:i:s a", strtotime($mszData['contactEntrydate']));
       

      $html.='<div class="message-viewer">
        <div class="msg-detail_vw">

            <h1><button class="back btn btn-warning">Back</button>&nbsp;&nbsp;'.$mszData['subject'].'</h1>
               
            <div>
        </div>

                <div class="name_plate">
                    <div class="pull-left">
                        <strong>
                            '.$mszData['name'].'
                        </strong>
                    </div>
                    <div class="pull-right date_full">
                        <span>'.$date.'</span><br>
                        <span>'.$time.'</span>
                    </div>
                </div>
                <div class="ful_msg">
                    <p>
                    '.$mszData['contactComments'].'
                    </p>
                    
                </div>
            </div> ';


            $html.='
            <div class="detail-tabs">
                             ';
                             // <button class="btn active rply replymsz" data-id="'.$mszData['contactID'].'" data-page="replymsz" data-userid="'.$mszData['userId'].'" data-name="'.$mszData['name'].'" data-subject="'.$mszData['subject'].'" data-seller="'.$mszData['sellerId'].'">
                             //        Reply
                             //    </button>
                               //  <button class="btn active rply replymsz" data-id="'.$mszdata['contactID'].'" data-page="replymsz" data-userid="'$mszData['userid']'" data-name="'.$mszData['name'].'" data-subject="'.$mszData['subject'].'" >
                               //      Reply
                               //  </button> 

                               //  <button class="btn sply" >
                               //       Suppliers
                                    
                               // </button>
                            $html.='</div>
                           
                <div class="inbox-body inner_body_scroll" >';
                           $ExtraQry = "sellerId=".addslashes($_SESSION['FUSERID'])." AND parentId= ".$contactID;
           $data        = $this->connect->selectMulti(TBL_CONTACT, "*", $ExtraQry,0,9999);
           //print_r($data);
           
           foreach($data as $msz){           

          $html.='<table class="messag">
                  <tbody>
                  <tr class="sec-1"> 
        <td class="circle"><i class="fa fa-circle"></i></td>
        <td class="inbox-small-cells">
        <input type="checkbox" class="mail-checkbox">
         </td>
            <td>
               
            </td>
           
        </tr>
        <tr class="msg-detail viewmsz"  data-page="viewmsz" data-id="'.$msz['contactID'].'" style="cursor:pointer">
            <td class="title">'.$msz['name'].' </td>
            <td class="purpose">'.$msz['subject'].'</td>
            <td class="msg">
                
                    <p ><i class="fa fa-clock"></i>'.$msz['contactComments'].'</p>
                </td>
            
        </tr>
        <tr class="date">
        <td>
           '.date("d-M-Y H:i:s A", strtotime($msz['contactEntrydate'])).' 
        </td>
        </tr>

        <tr class="star">
        <td class="btn-group ">
            
           
            <button data-toggle="dropdown" class="btn">
                <span class="ace-icon fa fa-caret-down icon-only"></span>
            </button>
            <ul class="dropdown-menu">

            <li><a href="#" class="delete deleteMsz" data-mszId="'.$msz['contactID'].'"> Delete</a></li>
                    
                   
                
            </ul>
    </td>
    </tr>
    

    </tbody>
    </table>';

}

$html.='
</div><div class="form-group">

​<textarea type="text" name="textreply" id="textreply" rows="5" cols="10" style="width:100%;color:black;" ></textarea>
<br>
<button class="btn btn-warning active rply replymsz" data-id="'.$mszData['contactID'].'" data-page="replymsz" data-userid="'.$mszData['userId'].'" data-name="'.$mszData['name'].'" data-subject="'.$mszData['subject'].'" data-seller="'.$mszData['sellerId'].'" data-parentId="'.$mszData['parentId'].'">
    Reply
 </button></div></div>';
return $html;


    }


   function replymsz($contactID,$userid,$username,$subject,$seller,$comment){

      //$uObj = new MemberView(); 
            $params = array();  
            $params['userId'] = $_SESSION['FUSERID'];
            $params['subject']= $subject;
            $params['contactComments'] = $comment;
            $params['sellerId'] = $userid;
            $params['parentId'] = $contactID;
            $params['contactEntrydate']  = date("Y-m-d H:i:s");
            $params['name'] = $_SESSION['FUSERFULLNAME'];
            return $this->connect->insertQuery(TBL_CONTACT, $params);
           // print_r($params); 
           // $uObj->insertReply($params);

     // $html.='<div class="h-box-100 relative">
     //            <div class="h-heading">Reply Message</div>
     //                <div class="clear"></div>
     //                 <div class="col-md-12">
     //                  <form action="" method="POST" id="reply">
     //                 <div class="form-group">
     //                 <lable>To:</lable>
     //                 <input type="text"  name="toname" class="form-control" value="'.$username.'" readonly>
                     
     //                 </div>

     //                <div class="form-group">
                    
     //                  <lable>Subject:</lable>
     //                 <input type="text" name ="subject" class="form-control" value="'.$subject.'">
                    
     //                 </div>

     //                 <div class="form-group">
                    
     //                 <lable>Message:</lable>
     //                 <textarea type="text" name="comment" class="form-control" ></textarea>
                   
     //                 </div>
     //                 <div class="form-group" style="padding-bottom: 13px;">
     //                    <button type="submit" class="btn btn-primary btn-lg saveReplymsz">Send Message</button>
     //                     <input type="hidden" name="ajax" value="1">
     //                     <input type="hidden" name="SourceForm" value="saveReplymsz">
     //                     <input type="hidden" name="fromId" value="'.$seller.'"> 
     //                     <input type="hidden" name="toId" value="'.$userid.'"> 
     //                     <input type="hidden" name="contactID" value="'.$contactID.'"> 
     //                </div>
     //                 </form>
     //                 </div>

     //            </div>';
                
     //    return $html;

   }

   function insertReply($params){
      return $this->connect->insertQuery(TBL_CONTACT, $params);
   }


   function mszDelete($mszId){

 return $this->connect->executeQuery("delete from ".TBL_CONTACT." where contactID = ".addslashes($mszId));
   }

    
    function showrequirement($id){
        
        $ENTITY =   TBL_CONTACT." c 
                    JOIN ".TBL_PRODUCT." p ON ( p.id = c.proId)";
        
        $ExtraQryStr = "contactID=".addslashes($id)." order by contactEntrydate desc";                 
        $reqmData = $this->connect->selectSingle($ENTITY, "c.*, p.p_category", $ExtraQryStr);	
                
        $ExtraQryStr = "categoryId=".$reqmData['p_category']." order by attributeId";
		$cData       = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY_ATTRIBUTES, "*", $ExtraQryStr, 0, 99999);
                        
        $html.='<div class="h-box-100 relative" style="padding-bottom: 15px;">
                    <div class="h-heading">View Requirement</div>
                    <div class="clear"></div>
                    <div class="h-table"><span class="formClose">X</span>
                        <div class="col-md-12">';

                        $html.='<fieldset class="shp_add"><legend>Product Details</legend>';
                                    if(file_exists(MDFR.'/product/large/'.$reqmData[p_photo]) && $reqmData[p_photo])
                                    {
                                        $html.='<span class="pimg"><img src="'.SHWFL.'/product/thumb/'.$reqmData[p_photo].'"></span>';
                                    }    
                                    else
                                        $html.='<span class="pimg"><img src="'.TMP.'/images/noimage.jpg"></span>';

                                    $html.='<div class="clearfix mb10">
                                                <div class=""><strong>'.$reqmData['product'].'</strong></div>
                                                <div class="">'.date('d.m.Y',strtotime($reqmData['contactEntrydate'])).'</div>
                                            </div>';


                                    if($cData)
                                    {
                                        $html.='<div class="clearfix"></div>';
                                        for($row=0; $row<sizeof($cData); $row++)
                                        {
                                            $attributeData = array();

                                            $html.= '<div class="form-group"><label>'.$cData[$row]['attributeName'].'</label> ';

                                                if($cData[$row]['attributeType']=='radio' || $cData[$row]['attributeType']=='checkbox')
                                                {
                                                    $ExtraQryStr = "attributeId=".addslashes($cData[$row]['attributeId'])." and productId=".addslashes($reqmData['proId'])." order by attributeId";
                                                    $attributeData = $this->connect->selectMulti(TBL_REQUIREMENT_ATTRIBUTE, "*", $ExtraQryStr, 0, 50);  

                                                    $options = explode('@#@', $cData[$row]['attributeOptions']);

                                                    $atr = '';
                                                    foreach($options as $val)
                                                    {
                                                        $atr .=$val.', ';                     
                                                    }                        
                                                    $atrVal = rtrim($atr,', ');

                                                    $html.= '<span>'.$atrVal.'</span>';
                                                    //$html.= '<input class="form-control" type="text" value="'.$atrVal.'" name="attributeValueArray_'.$row.'[]" />';
                                                }
                                                else
                                                {
                                                    $ExtraQryStr = "productId=".addslashes($reqmData['proId'])." order by attributeId";
                                                    $attributeData = $this->connect->selectMulti(TBL_REQUIREMENT_ATTRIBUTE, "*", $ExtraQryStr, 0, 50);  

                                                    $arrayKey = searchForId('attributeId', $cData[$row]['attributeId'], $attributeData);

                                                    $html.= '<span>'.$attributeData[$arrayKey]['attributeValue'].'</span>';
                                                }
                                            $html.= '</div>';
                                        }

                                    }
                                    $html.='<div class="form-group"><label>Quantity</label> <span>'.$reqmData['qty'].' '.$reqmData['unitType'].'</span></div>
                                    <div class="form-group"><label>Order Amount</label> <span>'.$reqmData['price'].' '.$reqmData['currency'].'</span></div>                        
                                    <div class="form-group bTop" style="width: 100%;"><label>Specific Details</label><br> <span>'.nl2br($reqmData['contactComments']).'</span></div>
                                </fieldset>';
                                
                                $html.="<fieldset class='shp_add'><legend>Buyer's Details</legend>";
                                    $html.='<div class="form-group">
                                        <label> Name</label> <span>'.$reqmData['name'].'</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label> <span>'.$reqmData['email'].'</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label> <span>'.$reqmData['phone'].'</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label> <span>'.$reqmData['address'].'</span>
                                    </div>
                                    <div class="form-group">
                                        <label>State of origin</label> <span>'.$reqmData['country'].'</span>
                                    </div>
                                    <div class="form-group">
                                        <label>State</label> <span>'.$reqmData['state'].'</span>
                                    </div>
                                    <div class="form-group">
                                        <label>City</label> <span>'.$reqmData['city'].'</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Zip</label> <span>'.$reqmData['zip'].'</span>
                                    </div>
                                </fieldset>

                                <button type="button" class="btn btn-primary replyvie">Reply</button>
                        
                            <div class="clearfix"></div>
                        </div>
                    </div>';
        
        
        /* $html.='<div class="form-group">
        <label> Name</label>
         <input name="" id="" type="text" class="form-control" value="'.$reqmData['name'].'"/>
        </div>
        <div class="form-group">
        <label>Email</label>
         <input name="p_keyword" id="p_keyword" type="text" class="form-control" required value="'.$reqmData['email'].'"/>
        </div>
        <div class="form-group">
        <label>Phone</label>
         <input name="p_keyword" id="p_keyword" type="text" class="form-control" required value="'.$reqmData['phone'].'"/>
        </div>
        <div class="form-group">
        <label>Product</label>
         <input name="p_keyword" id="p_keyword" type="text" class="form-control" required value="'.$reqmData['product'].'"/>
        </div>
        <div class="form-group">
        <label>Specific Details</label>
         <input name="p_keyword" id="p_keyword" type="text" class="form-control" required value="'.$reqmData['contactComments'].'"/>
        </div>';

        if($cData)
        {            
            for($row=0; $row<sizeof($cData); $row++)
            {
                $attributeData = array();

                $html.= '<div class="form-group"><label>'.$cData[$row]['attributeName'].':</label> ';

                    if($cData[$row]['attributeType']=='radio' || $cData[$row]['attributeType']=='checkbox')
                    {
        
                        $ExtraQryStr = "attributeId=".addslashes($cData[$row]['attributeId'])." and productId=".addslashes($reqmData['proId'])." order by attributeId";
                        $attributeData = $this->connect->selectMulti(TBL_REQUIREMENT_ATTRIBUTE, "*", $ExtraQryStr, 0, 50);  
                        
                        $options = explode('@#@', $cData[$row]['attributeOptions']);
                        
                        $atr = '';
                        foreach($options as $val)
                        {
                            $atr .=$val.', ';                     
                        }                        
                        $atrVal = rtrim($atr,', ');
                        
                        $html.= '<input class="form-control" type="text" value="'.$atrVal.'" name="attributeValueArray_'.$row.'[]" />';
                    }
                    else
                    {
                        $ExtraQryStr = "productId=".addslashes($reqmData['proId'])." order by attributeId";
                        $attributeData = $this->connect->selectMulti(TBL_REQUIREMENT_ATTRIBUTE, "*", $ExtraQryStr, 0, 50);  
                        
                        $arrayKey = searchForId('attributeId', $cData[$row]['attributeId'], $attributeData);

                        $html.= '<input class="form-control" type="text" value="'.$attributeData[$arrayKey]['attributeValue'].'" name="attributeValueArray_'.$row.'[]" />';
                    }
                $html.= '</div>';
            }
            
        }
            
        $html.=
        '<div class="form-group qti">
        <label>Quantity</label>
         <input name="p_keyword" id="p_keyword" type="text" class="form-control" required value="'.$reqmData['qty'].'"/>
        </div>
        <div class="form-group qti">
        <label>Unit</label>
         <input name="p_keyword" id="p_keyword" type="text" class="form-control" required value="'.$reqmData['unitType'].'"/>
        </div>
        <div class="form-group qti">
        <label>Value</label>
         <input name="p_keyword" id="p_keyword" type="text" class="form-control" required value="'.$reqmData['price'].'"/>
        </div>
        <div class="form-group qti">
        <label>Curreny</label>
         <input name="p_keyword" id="p_keyword" type="text" class="form-control" required value="'.$reqmData['currency'].'"/>
        </div>';*/
        
        return $html;
    }
    
    function readrequirements($id_user, $slNo, $start, $limit) { 
        
        $ExtraQryStr = " user_id=".addslashes($id_user);
        $comData = $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr);
        
        
        $ExtraQryStrq = " c_id=".addslashes($comData['id']).' AND contactType="P" order by contactID desc';
        $reqData = $this->connect->selectMulti(TBL_CONTACT, "*", $ExtraQryStrq, $start, $limit);
        
                
        $html       .='<form name="" method="post"><table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Date</th>
                <th>Name</th>
                <th>Email</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th></th>
              </tr>
            </thead><tbody>';
        
            
            $f  =0;
            $c  =1;
            $q  =1;
            if($reqData){
                foreach($reqData as $data)
                {	
                    
                    
                    if(strlen($data['product'])>15)
                        $pm = substr(strip_tags($data['product']),0,12).'...';
                    else
                        $pm = $data['product'];
                    
                    
                    $html.='<tr class="tbl_'.$c.' alltr" style="'.$disp.'">
                        <td>'.$slNo.'</td>
                        <td>'.date('d.m.Y',strtotime($data['contactEntrydate'])).'</td>
                        <td>'.$data['name'].'</td>
                        <td>'.$data['email'].'</td>
                        <td title="'.$data['product'].'">'.$pm.'</td>
                        <td>'.$data['qty'].' '.$data['unitType'].'</td>
                        <td>'.$data['price'].' '.$data['currency'].'</td>
                        <td style="min-width: 60px;"> <a class="viewreq" data-page="viewreq" data-id="'.$data['contactID'].'" style="cursor:pointer"><span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="View Requirement"></span></a></td>
                      </tr>';
                    $slNo++;
                }
            }
            else{
                $html.='<tr><td align="center" colspan="9">No records found.</td></tr>';
            }
            $html.='</tbody></table>';
        
        return $html;	
    } 
    
    function readSampleRequest($id_user, $slNo, $start, $limit) { 
        
        $ExtraQryStr = " user_id=".addslashes($id_user);
        $comData = $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr);
        
        
        $ExtraQryStrq = " c_id=".addslashes($comData['id']).' AND contactType="S" order by contactID desc';
        $reqData = $this->connect->selectMulti(TBL_CONTACT, "*", $ExtraQryStrq, $start, $limit);
        
                
        $html       .='<form name="" method="post"><table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Date</th>
                <th>Request ID</th>
                <th>Product</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead><tbody>';
        
            
            $f  =0;
            $c  =1;
            $q  =1;
            if($reqData){
                foreach($reqData as $data)
                {	                    
                    if(strlen($data['product'])>20)
                        $pm = substr(strip_tags($data['product']),0,20).'...';
                    else
                        $pm = $data['product'];
                                        
                    if(strlen($data['sendStatus'])>8)
                        $sts = substr($data['sendStatus'],0,5).'...';
                    else
                        $sts = $data['sendStatus'];
                                        
                    $html.='<tr class="tbl_'.$c.' alltr" style="'.$disp.'">
                        <td>'.$slNo.'</td>
                        <td>'.date('d.m.Y',strtotime($data['contactEntrydate'])).'</td>
                        <td>'.$data['requestId'].'</td>
                        <td title="'.$data['product'].'">'.$pm.'</td>
                        <td title="'.$data['sendStatus'].'">'.$data['sendStatus'].'</td>
                        <td style="min-width: 60px;"> 
                            <a class="viewsamplereq" data-page="viewsamplereq" data-id="'.$data['contactID'].'" style="cursor:pointer"><span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="View Sample"></span></a>
                        </td>
                      </tr>';
                    $slNo++;
                }
            }
            else{
                $html.='<tr><td align="center" colspan="9">No records found.</td></tr>';
            }
            $html.='</tbody></table>';
        
        return $html;	
    }
    
    function showSampleRequest($id){
        
        /*$ExtraQryStr = " contactID=".addslashes($id);
        $reqmData = $this->connect->selectSingle(TBL_CONTACT, "*", $ExtraQryStr);*/
        
        $ENTITY =   TBL_CONTACT." c 
                    JOIN ".TBL_PRODUCT." p ON ( p.id = c.proId)";
        
        $ExtraQryStr = "contactID=".addslashes($id)." AND contactType='S' order by contactEntrydate desc";                 
        $reqmData = $this->connect->selectSingle($ENTITY, "c.*, p.p_category, p.p_photo", $ExtraQryStr);
                        
        $ExtraQryStr = "categoryId=".$reqmData['p_category']." order by attributeId";
		$cData       = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY_ATTRIBUTES, "*", $ExtraQryStr, 0, 99999);
                        
        $html.='<div class="h-box-100 relative">
                        <div class="h-heading">View Sample Request</div>
                        <div class="clear"></div>
                        <div class="h-table"><span class="formClose">X</span><div class="col-md-12">';
        
        $html.='<div class="est_left">';
                    if(file_exists(MDFR.'/product/large/'.$reqmData[p_photo]) && $reqmData[p_photo])
                    {
                        $html.='<span class="pimg"><img src="'.SHWFL.'/product/thumb/'.$reqmData[p_photo].'"></span>';
                    }    
                    else
                        $html.='<span class="pimg"><img src="'.TMP.'/images/noimage.jpg"></span>';
        
        $html.='    <div class="clearfix">
                        <div class=""><label>'.$reqmData['product'].'</label> (Request #: '.$reqmData['requestId'].')</div>
                        <div class="">'.date('d.m.Y',strtotime($reqmData['contactEntrydate'])).'</div>
                    </div>
                </div>
                <div class="est_right">
                    <div class=""><label>Status:</label> '.$reqmData['sendStatus'].'</div>
                </div>
                <div class="clear"></div>';
        $html.='<div class="editsample_left">';
                    if($cData)
                    {
                        $html.='<div class="clearfix"></div>';
                        for($row=0; $row<sizeof($cData); $row++)
                        {
                            $attributeData = array();

                            $html.= '<div class="form-group"><label>'.$cData[$row]['attributeName'].'</label> ';

                                if($cData[$row]['attributeType']=='radio' || $cData[$row]['attributeType']=='checkbox')
                                {

                                    $ExtraQryStr = "attributeId=".addslashes($cData[$row]['attributeId'])." and productId=".addslashes($reqmData['proId'])." order by attributeId";
                                    $attributeData = $this->connect->selectMulti(TBL_REQUIREMENT_ATTRIBUTE, "*", $ExtraQryStr, 0, 50);  

                                    $options = explode('@#@', $cData[$row]['attributeOptions']);

                                    $atr = '';
                                    foreach($options as $val)
                                    {
                                        $atr .=$val.', ';                     
                                    }                        
                                    $atrVal = rtrim($atr,', ');

                                    $html.= '<span>'.$atrVal.'</span>';
                                    //$html.= '<input class="form-control" type="text" value="'.$atrVal.'" name="attributeValueArray_'.$row.'[]" />';
                                }
                                else
                                {
                                    $ExtraQryStr = "productId=".addslashes($reqmData['proId'])." order by attributeId";
                                    $attributeData = $this->connect->selectMulti(TBL_REQUIREMENT_ATTRIBUTE, "*", $ExtraQryStr, 0, 50);  

                                    $arrayKey = searchForId('attributeId', $cData[$row]['attributeId'], $attributeData);

                                    $html.= '<span>'.$attributeData[$arrayKey]['attributeValue'].'</span>';
                                }
                            $html.= '</div>';
                        }
                    }
                    $html.='<div class="form-group bTop"><label>Enquiry</label><br> <span>'.nl2br($reqmData['contactComments']).'</span></div>
                </div>
                <div class="editsample_right">
                    <form id="reqSend" class="forma" method="post" >
                        <div class="form-group qti">
                            <label>Quantity</label>
                            <input name="qty" id="qty" type="text" class="form-control" required value="'.$reqmData['qty'].'"/>';
                            /*<input name="unitType" id="unitType" type="text" class="form-control" required value="'.$reqmData['unitType'].'"/>*/
                            $ch1='';
                            $ch2='';
                            $ch3='';
                            $ch4='';
                            $ch5='';
                            $ch6='';
                            $ch7='';
                            $ch8='';
                            $ch9='';
                            $ch10='';
                            $ch11='';
                            $ch12='';
                            $ch13='';
                            $ch14='';
                            $ch15='';
                            $ch16='';
                            $ch17='';
                            $ch18='';
                            $ch19='';				
                            if($reqmData['unitType']==''){$ch1='selected="selected"';}
                            if($reqmData['unitType']=='Bag/Bags'){$ch2='selected="selected"';}
                            if($reqmData['unitType']=='Barrel/Barrels'){$ch3='selected="selected"';}
                            if($reqmData['unitType']=='Cubic Meter'){$ch4='selected="selected"';}
                            if($reqmData['unitType']=='Dozen'){$ch5='selected="selected"';}	
                            if($reqmData['unitType']=='Gallon'){$ch6='selected="selected"';}
                            if($reqmData['unitType']=='Gram'){$ch7='selected="selected"';}	
                            if($reqmData['unitType']=='Kilogram'){$ch8='selected="selected"';}	
                            if($reqmData['unitType']=='Kilometer'){$ch9='selected="selected"';}	
                            if($reqmData['unitType']=='Long Ton'){$ch10='selected="selected"';}	
                            if($reqmData['unitType']=='Meter'){$ch11='selected="selected"';}	
                            if($reqmData['unitType']=='Mertic Ton'){$ch12='selected="selected"';}
                            if($reqmData['unitType']=='Ounce'){$ch13='selected="selected"';}
                            if($reqmData['unitType']=='Pair'){$ch14='selected="selected"';}
                            if($reqmData['unitType']=='pack/packs'){$ch15='selected="selected"';}
                            if($reqmData['unitType']=='Piece/Pieces'){$ch16='selected="selected"';}
                            if($reqmData['unitType']=='Pound'){$ch17='selected="selected"';}
                            if($reqmData['unitType']=='Set/Sets'){$ch18='selected="selected"';}
                            if($reqmData['unitType']=='Short Ton'){$ch19='selected="selected"';}
                            $html.='<select name="unitType" id="unitType" class="form-control">
                                <option value="" '.$ch1.'>Select Unit Type</option>
                                <option value="Bag/Bags" '.$ch2.'>Bag/Bags </option>
                                <option value="Barrel/Barrels" '.$ch3.'>Barrel/Barrels </option>
                                <option value="Cubic Meter" '.$ch4.'>Cubic Meter </option>
                                <option value="Dozen" '.$ch5.'>Dozen </option>
                                <option value="Gallon" '.$ch6.'>Gallon</option>
                                <option value="Gram" '.$ch7.'>Gram </option>
                                <option value="Kilogram" '.$ch8.'>Kilogram </option>
                                <option value="Kilometer" '.$ch9.'>Kilometer </option>
                                <option value="Long Ton" '.$ch10.'>Long Ton </option>
                                <option value="Meter" '.$ch11.'>Meter </option>
                                <option value="Mertic Ton" '.$ch12.'>Metric Ton </option>
                                <option value="Ounce" '.$ch13.'>Ounce </option>
                                <option value="Pair" '.$ch14.'>Pair</option>
                                <option value="pack/packs" '.$ch15.'>Pack/Packs </option>
                                <option value="Piece/Pieces" '.$ch16.'>Piece/Pieces </option>
                                <option value="Pound" '.$ch17.'>Pound</option>
                                <option value="Set/Sets" '.$ch18.'>Set/Sets </option>
                                <option value="Short Ton" '.$ch19.'>Short Ton</option>
                            </select>
                        </div>
                        <div class="form-group qti">
                            <label>Amount</label>
                            <input name="price" id="price" type="text" class="form-control" required value="'.$reqmData['price'].'"/>';
                            /*<input name="currency" id="currency" type="text" class="form-control" required value="'.$reqmData['currency'].'"/>*/
                            $ch1='';
                            $ch2='';
                            $ch3='';
                            $ch4='';
                            $ch5='';
                            $ch6='';
                            $ch7='';
                            $ch8='';
                            $ch9='';
                            $ch10='';
                            $ch11='';
                            $ch12='';
                            $ch13='';				
                            if($reqmData['currency']==''){$ch1='selected="selected"';}
                            if($reqmData['currency']=='USD'){$ch2='selected="selected"';}
                            if($reqmData['currency']=='GBP'){$ch3='selected="selected"';}
                            if($reqmData['currency']=='RMB'){$ch4='selected="selected"';}
                            if($reqmData['currency']=='EUR'){$ch5='selected="selected"';}	
                            if($reqmData['currency']=='AUD'){$ch6='selected="selected"';}
                            if($reqmData['currency']=='CAD'){$ch7='selected="selected"';}	
                            if($reqmData['currency']=='CHF'){$ch8='selected="selected"';}	
                            if($reqmData['currency']=='JPY'){$ch9='selected="selected"';}	
                            if($reqmData['currency']=='HKD'){$ch10='selected="selected"';}	
                            if($reqmData['currency']=='NZD'){$ch11='selected="selected"';}	
                            if($reqmData['currency']=='SGD'){$ch12='selected="selected"';}	
                            if($reqmData['currency']=='Other'){$ch13='selected="selected"';}
        
                            $html.='<select name="currency" id="currency" class="form-control">
                                <option value="" '.$ch1.'>Currency</option>
                                <option value="USD" '.$ch2.'> USD </option>
                                <option value="GBP" '.$ch3.'> GBP </option>
                                <option value="RMB" '.$ch4.'> RMB </option>
                                <option value="EUR" '.$ch5.'> EUR </option>
                                <option value="AUD" '.$ch6.'> AUD </option>
                                <option value="CAD" '.$ch7.'> CAD </option>
                                <option value="CHF" '.$ch8.'> CHF </option>
                                <option value="JPY" '.$ch9.'> JPY </option>
                                <option value="HKD" '.$ch10.'> HKD </option>
                                <option value="NZD" '.$ch11.'> NZD </option>
                                <option value="SGD" '.$ch12.'> SGD </option>
                                <option value="Other" '.$ch13.'>Other </option>
                            </select>
                        </div>    
                        <div class="form-group" style="padding-top: 13px;">';  

                        if($reqmData['sendStatus']=='Pending'){
                             $html.='<button type="submit" class="btn btn-primary btn-lg">Request Admin to Send</button>';
                        }

                        $html.='<input type="hidden" name="ajax" value="1">
                                <input type="hidden" name="SourceForm" value="sampleReqAdmin">
                                <input type="hidden" name="cid" value="'.$reqmData['contactID'].'">
                        </div>
                        <div class="errMsg"></div>
                    </form>
                </div>
                <div class="clear"></div>';
        
        $html.='<fieldset class="mt0 shp_add"><legend>Shipping Address</legend>
                <div class="form-group">
                    <label>Name</label> <span>'.$reqmData['name'].'</span>
                </div>
                <div class="form-group">
                    <label>Email</label> <span>'.$reqmData['email'].'</span>
                </div>
                <div class="form-group">
                    <label>Phone</label> <span>'.$reqmData['phone'].'</span>
                </div>
                <div class="form-group">
                    <label>Address</label> <span>'.$reqmData['address'].'</span>
                </div>
                <div class="form-group">
                    <label>State of origin</label> <span>'.$reqmData['country'].'</span>
                </div>
                <div class="form-group">
                    <label>State</label> <span>'.$reqmData['state'].'</span>
                </div>
                <div class="form-group">
                    <label>City</label> <span>'.$reqmData['city'].'</span>
                </div>
                <div class="form-group">
                    <label>Zip</label> <span>'.$reqmData['zip'].'</span>
                </div>
            </fieldset>
            <div class="clear"></div>';
        
        return $html;
    }
    
    function readcompany($id_user)
    {
        $ch1='';
        $ch2='';
        $ch3='';
        $ch4='';
        $ch5='';
        $ch6='';
        $ch7='';
        $ch8='';
        $ch9='';
        $ch10='';
        $ch11='';
        $ch12='';
        
        $ExtraQryStr    = " user_id = ".addslashes($id_user);
        $data           = $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr);
                
        
        $html.='<form id="companydata" class="forma" onsubmit="return false;" enctype="multipart/form-data">';
        $html.='<div class="row">
                 <div class="col-sm-12">
                   <div class="form-group">
                    <label>Company name</label>
                    <input name="companyname" id="companyname" type="text" class="form-control" required value="'.$data[companyname].'"/>
                </div>
            </div>';
             if($data[business_type]=='Product Based'){$ch1='selected="selected"';}
            if($data[business_type]=='Exporter'){$ch2='selected="selected"';}
            if($data[business_type]=='Importer'){$ch3='selected="selected"';}
            if($data[business_type]=='Wholesaler'){$ch4='selected="selected"';}
            if($data[business_type]=='Manufacturer'){$ch5='selected="selected"';}
            if($data[business_type]=='Retailer'){$ch6='selected="selected"';}
             if($data[business_type]=='Service Based'){$ch7='selected="selected"';}

              $html.='<div class="col-sm-6">
                        <div class="form-group">
                            <label>Business Type *</label>
                            <select name="bussiness_type" id="bussiness_type" class="form-control">
                                <option value="Product" '.$ch1.'>PRODUCT BASE</option>
                                <option value="Exporter" '.$ch2.'>Exporter</option>
                                <option value="Importer" '.$ch3.'>Importer</option>
                                <option value="Wholesaler" '.$ch4.'>Wholesaler</option>
                                <option value="Manufacturer" '.$ch5.'>Manufacturer</option>
                                <option value="Retailer" '.$ch6.'>Retailer</option>
                                <option value="Service" '.$ch7.'>SERVICE BASED</option>
                            </select>   
                       </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group" align="right" id="companydiv">
                      <label class="radioLabel">  
                            <input name="p_service" class="prType" data-uid="'.$id_user.'" data-cmpid="'.$data['id'].'" value="P" type="radio">
                            <span>Product</span>
                            <span><img src="'.$MEDIA_FILES_ROOT.'/templates/images/pro.jpg" alt="" height="80" width="80"></img></span>
                        </label>
                        <label class="radioLabel">  
                            <input name="p_service" class="prType" data-uid="'.$id_user.'" data-cmpid="'.$data['id'].'" value="S" type="radio">
                            <span>Service</span>
                            <span><img src="'.$MEDIA_FILES_ROOT.'/templates/images/service.png" alt="" height="80" width="80"></img></span>
                        </label>
                      </div>
                      </div>';
                      // <div class="col-sm-6">
                      // <div class="form-group" align="left" id="sadrzaj">
                      
                      // </div>
                      // </div>';
                      
                    
                       
                    //echo $this->showproductaddTypecategory($id_user,$cmpid);
                 
                 // echo $this->showproductaddcategory($id_user, $cmpid, $prType);

               

                    /*
                    
            $html.='<div class="col-sm-6">
                        <div class="form-group">
                            <label>Business Type *</label>
                            <select name="bussiness_type" id="bussiness_type" class="form-control">
                                <option value="Product Based" '.$ch1.'>Product Based</option>
                                <option value="Exporter" '.$ch2.'>Exporter</option>
                                <option value="Importer" '.$ch3.'>Importer</option>
                                <option value="Wholesaler" '.$ch4.'>Wholesaler</option>
                                <option value="Manufacturer" '.$ch5.'>Manufacturer</option>
                                <option value="Retailer" '.$ch6.'>Retailer</option>
                                <option value="Service Based" '.$ch7.'>Service Based</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                       <form id="" class="forma">
                    <div class="form-group clearfix">
                        <label>Product Type *</label><br>
                        <label class="radioLabel">  
                            <input name="proType" class="proType" data-uid="'.$id_user.'" data-cmpid="'.$cmpid.'" value="P" type="radio">
                            <span>Product</span>
                        </label>
                        <label class="radioLabel">  
                            <input name="proType" class="proType" data-uid="'.$id_user.'" data-cmpid="'.$cmpid.'" value="S" type="radio">
                            <span>Service</span>
                        </label>
                    </div>
                    </form>


                    <div class="h-box-100 relative">
                              <div class="clear"></div>
                             <div class="h-table">
                        <form id="productdata" class="forma" onsubmit="return false;" enctype="multipart/form-data">
                            
                                   
                            
                                    <div class="form-group">
                                        <label>*'.$ty.' Category</label>
                                        <select name="p_category" id="p_category" class="form-control">';
                                        $ExtraQryStr    = " status='Y' AND mainCategory=".$pid." AND parent_id=".$pid." order by category ASC";
                                        $data           = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr,0,9999);

                                            $html.='<option class="prCategory" value=""  data-parent="0">Select</option>';
                                            foreach($data as $dataC)
                                            {
                                                $html.='<option class="prCategory" value="'.$dataC[c_id].'" '.$sel.'  data-parent="'.$dataC[c_id].'">'.$dataC[category].'</option>';

                                                $pId        = $dataC['c_id'];

                                                $ExtraQryCh     = " status='Y' AND parent_id=".$dataC['c_id']." order by category ASC";
                                                $dataCh         = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryCh,0,9999);
                                                if($dataCh){
                                                    foreach($dataCh as $child){
                                                        $html.='<option class="cCategory" value="'.$child[c_id].'">&nbsp;&nbsp;&nbsp;&nbsp;'.$child[category].'</option>';
                                                    }
                                                }
                                            }
                                        $html.='</select>
                                    </div>
                                    <div class="categoryDetails"></div>
                                    
                                </div>
                                
                            </div>';
                            $html.='<div class="errMsg"></div>
                        </form>
                    </div>
                </div> 

                    </div>';

	

            /*$html.='<div class="form-group"></div>
            <div class="form-group">
            <label>Office Name</label>
             <input name="offName" id="offName" type="text" class="form-control" value="'.$data[offName].'"/>
            </div>
            ';*/	
            // $html.='<div class="col-sm-12"><div class="form-group proSer"></div></div>
            //         <div class="col-sm-12">
            //             <div class="form-group">
            //                 <label>Company Address</label>
            //                 <input name="company_address" id="company_address" type="text" class="form-control" value="'.$data[company_address].'"/>
            //             </div>
            //         </div>';
            /*$html.='<div class="col-sm-12">
                <div class="form-group">
                    <input type="hidden" name="companylogo" id="companylogo" value="'.$data[companylogo].'">
                    <label>Company Logo</label>';
                    if($data[companylogo]){
                        $html.='<div id="content_here_please" class="form-group"><img src="'.SHWFL.'/upload/'.$data[companylogo].'" alt="" width="30%"/></div>';
                    }
            $html.='<input type="file" name="img" id="" />
                </div>
            </div>';*/
            
            /*---------------------------*/
        
            $html.='<div class="col-sm-12">
                <div class="form-group">
                    <div class="">
                        <div class="multiImg">
                        <label>Company Logo</label>';
                        $html.='<div id="content_here_please" class="form-group">';
                    
                            if(file_exists(MDFR.'/upload/thumb/'.$data[companylogo]) && $data[companylogo])
                            {
                                $html.='<span class="pimg"><img src="'.SHWFL.'/upload/thumb/'.$data[companylogo].'"></span>';
                            } 
                            $html.='<input type="file" name="companylogo" />
                                    <input type="hidden" name="companylogo" value="'.$data[companylogo].'">
                        </div>
                    </div>';
            
            $html.='<div class="multiImg">
                        <label>Image 1</label>';
                        $html.='<div id="content_here_please" class="form-group">';
                    
                            if(file_exists(MDFR.'/upload/thumb/'.$data[image1]) && $data[image1])
                            {
                                $html.='<span class="pimg"><img src="'.SHWFL.'/upload/thumb/'.$data[image1].'"></span>';
                            } 
                            $html.='<input type="file" name="image1"/>
                                    <input type="hidden" name="image1" value="'.$data[image1].'">
                        </div>
                    </div>';
            $html.='<div class="multiImg">
                        <label>Image 2</label>';
                        $html.='<div id="content_here_please" class="form-group">';
                    
                            if(file_exists(MDFR.'/upload/thumb/'.$data[image2]) && $data[image2])
                            {
                                $html.='<span class="pimg"><img src="'.SHWFL.'/upload/thumb/'.$data[image2].'"></span>';
                            } 
                            $html.='<input type="file" name="image2" />
                                    <input type="hidden" name="image2" value="'.$data[image2].'">
                        </div>
                    </div>';
            $html.='<div class="multiImg">
                        <label>Image 3</label>';
                        $html.='<div id="content_here_please" class="form-group">';
                    
                            if(file_exists(MDFR.'/upload/thumb/'.$data[image3]) && $data[image3])
                            {
                                $html.='<span class="pimg"><img src="'.SHWFL.'/upload/thumb/'.$data[image3].'"></span>';
                            } 
                            $html.='<input type="file" name="image3" />
                                    <input type="hidden" name="image3" value="'.$data[image3].'">
                        </div>
                    </div>';
            $html.='<div class="multiImg">
                        <label>Image 4</label>';
                        $html.='<div id="content_here_please" class="form-group">';
                    
                            if(file_exists(MDFR.'/upload/thumb/'.$data[image4]) && $data[image4])
                            {
                                $html.='<span class="pimg"><img src="'.SHWFL.'/upload/thumb/'.$data[image4].'"></span>';
                            }
                            $html.='<input type="file" name="image4" />
                                    <input type="hidden" name="image4" value="'.$data[image4].'">
                        </div>
                    </div>';
            $html.='<div class="multiImg">
                        <label>Image 5</label>';
                        $html.='<div id="content_here_please" class="form-group">';
                    
                            if(file_exists(MDFR.'/upload/thumb/'.$data[image5]) && $data[image5])
                            {
                                $html.='<span class="pimg"><img src="'.SHWFL.'/upload/thumb/'.$data[image5].'"></span>';
                            } 
                            $html.='<input type="file" name="image5" />
                                    <input type="hidden" name="image5" value="'.$data[image5].'">
                        </div>
                    </div>';
        
        
        
            
            $html.='</div></div></div>';	
        
            /*---------------------------*/
            
            $html.='<div class="col-sm-12">
                <div class="form-group">
                    <label> Video Link (YouTube)</label>
                    <input name="videoUrl" id="videoUrl" type="text" class="form-control" value="'.$data[videoUrl].'"/>
                </div>
            </div>';
        
        
        
            $html.='<div class="col-sm-12"><progress value="0" max="100" id="prog" style="display:none"></progress><div id="targetLayer"></div></div>';			
            $html.='<div class="col-sm-6">
                <div class="form-group">
                    <label>Brand(s)</label>
                    <input name="brand" id="brand" type="text" class="form-control" value="'.$data[brand].'"/>
                </div>
            </div>';	
            /*<input type="button" value="Upload image" class="btn btn-default uploadimage" />*/
            $ch1='';
            $ch2='';
            $ch3='';
            $ch4='';
            $ch5='';
            $ch6='';
            $ch7='';
            $ch8='';
            $ch9='';
            $ch10='';
            $ch11='';
            $ch12='';	
            $html.='<div class="col-sm-6">
                <div class="form-group">
                    <label>*No. Of Employees </label>';
                    if($data[noofemployee]=='Less than 5 People'){$ch1='selected="selected"';}
                    if($data[noofemployee]=='11 - 50 People'){$ch2='selected="selected"';}
                    if($data[noofemployee]=='51 - 100 People'){$ch3='selected="selected"';}
                    if($data[noofemployee]=='101 - 500 People'){$ch4='selected="selected"';}
                    if($data[noofemployee]=='501 - 1000 People'){$ch5='selected="selected"';}	
                    if($data[noofemployee]=='Above 1000 People'){$ch6='selected="selected"';}	
                    $html.='<select name="noofemployee" id="noofemployee" class="form-control">
                        <option value="Less than 5 People" '.$ch1.'>Less than 5 People</option>
                        <option value="11 - 50 People" '.$ch2.'>11 - 50 People</option>
                        <option value="51 - 100 People" '.$ch3.'>51 - 100 People</option>
                        <option value="101 - 500 People" '.$ch4.'>101 - 500 People</option>
                        <option value="501 - 1000 People" '.$ch5.'>501 - 1000 People</option>
                        <option value="Above 1000 People" '.$ch6.'>Above 1000 People</option>
                    </select>
                </div>
            </div>';
            $html.='<div class="col-sm-12">
                <div class="form-group">
                    <label>Company Website URL</label>
                    <input name="url" id="url" type="text" class="form-control" value="'.$data[url].'"/>
                </div>
            </div>';
            $html.='<div class="col-sm-12">
                <div class="form-group">
                    <label>Detailed Company Introduction</label>';
                    //$html.='<input name="company_details" id="company_details" type="text" class="form-control" value="'.$data[company_details].'"/>';

                    $CKEditor = new CKEditor();            
                    $CKEditor->returnOutput = true; 
                    $CKEditor->basePath = '../../ckeditor/'; 
                    $CKEditor->config['width'] = '100%'; 
                    $CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);         
                    CKFinder::SetupCKEditor($CKEditor, '../../ckfinder/');
                    $code = $CKEditor->editor("company_details", $data['company_details']);	

                $html.=$code.'</div>
            </div>';
            
        
            $html.='<div class="col-sm-6">
                <div class="form-group">
                    <label> Year Established</label>
                    <input name="year" id="year" type="text" class="form-control" value="'.$data[year].'"/>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label> Legal Representative / Business Owner</label>
                    <input name="bussinessowner" id="bussinessowner" type="text" class="form-control" value="'.$data[bussinessowner].'"/>
                </div>
            </div>';
            $ch1='';
            $ch2='';
            $ch3='';
            $ch4='';
            $ch5='';
            $ch6='';
            $ch7='';
            $ch8='';
            $ch9='';
            $ch10='';
            $ch11='';
            $ch12='';		
            $html.='<div class="col-sm-6">
                <div class="form-group">
                    <label>Registered Capital</label>';
                    if($data[registeredcapital]==''){$ch1='selected="selected"';}
                    if($data[registeredcapital]=='Below US$100 Thousand'){$ch2='selected="selected"';}
                    if($data[registeredcapital]=='US$101 - US$500 Thousand'){$ch3='selected="selected"';}
                    if($data[registeredcapital]=='US$501 - US$1 Million'){$ch4='selected="selected"';}
                    $html.='<select name="registeredcapital" id="registeredcapital" class="form-control">
                        <option value="" '.$ch1.'> </option>
                        <option value="Below US$100 Thousand" '.$ch2.'>Below US$100 Thousand</option>
                        <option value="US$101 - US$500 Thousand" '.$ch3.'>US$101 - US$500 Thousand</option>
                        <option value="US$501 - US$1 Million" '.$ch4.'>US$501 - US$1 Million</option>
                    </select>
                </div>
            </div>';	
            $ch1='';
            $ch2='';
            $ch3='';
            $ch4='';
            $ch5='';
            $ch6='';
            $ch7='';
            $ch8='';
            $ch9='';
            $ch10='';
            $ch11='';
            $ch12='';			
            $html.='<div class="col-sm-6">
                <div class="form-group">
                    <label> Ownership Type</label>';
                    if($data[ownertype]==''){$ch1='selected="selected"';}
                    if($data[ownertype]=='Corporation/Limited Company'){$ch2='selected="selected"';}
                    if($data[ownertype]=='Partner Ship'){$ch3='selected="selected"';}
                    if($data[ownertype]=='Other'){$ch4='selected="selected"';}
                    $html.='<select name="ownertype" id="registeredcapital" class="form-control">
                        <option value="" '.$ch1.'> </option>
                        <option value="Corporation/Limited Company" '.$ch2.'>Corporation/Limited Company</option>
                        <option value="Partner Ship" '.$ch2.'>Partner Ship </option>
                        <option value="Other" '.$ch2.'>Other</option>
                    </select>
                </div>
            </div>';	
            $ch1='';
            $ch2='';
            $ch3='';
            $ch4='';
            $ch5='';
            $ch6='';
            $ch7='';
            $ch8='';
            $ch9='';
            $ch10='';
            $ch11='';
            $ch12='';		
            $mm=explode(',',$data[mainmarkets]);
            if (in_array("North America", $mm)){$ch1='checked';}
            if (in_array("South America", $mm)){$ch2='checked';}
            if (in_array("Eastern Europe", $mm)){$ch3='checked';}
            if (in_array("Southeast Asia", $mm)){$ch4='checked';}
            if (in_array("Africa", $mm)){$ch5='checked';}
            if (in_array("Oceania", $mm)){$ch6='checked';}
            if (in_array("Mid East", $mm)){$ch7='checked';}
            if (in_array("Eastern Asia", $mm)){$ch8='checked';}
            if (in_array("Westaern Europe", $mm)){$ch9='checked';}
            $html.='<div class="col-sm-12">
                <div class="form-group">
                    <label> Main Markets</label>
                    <table border="0" width="100%">
                        <tbody>
                        <tr>
                          <td><label class="input_check"><input name="mainmarkets[]" value="North America" type="checkbox"  '.$ch1.'> North America</label></td>
                          <td><label class="input_check"><input name="mainmarkets[]" value="South America" type="checkbox" '.$ch2.'> South America</label></td>
                          <td><label class="input_check"><input name="mainmarkets[]" value="Eastern Europe" type="checkbox" '.$ch3.'> Eastern Europe</label></td>
                        </tr>
                        <tr>

                          <td><label class="input_check"><input name="mainmarkets[]" value="Southeast Asia" type="checkbox" '.$ch4.'> Southeast Asia</label></td>
                          <td><label class="input_check"><input name="mainmarkets[]" value="Africa" type="checkbox" '.$ch5.'> Africa</label></td>
                          <td><label class="input_check"><input name="mainmarkets[]" value="Oceania" type="checkbox" '.$ch6.'> Oceania</label></td>
                        </tr>
                        <tr>

                          <td><label class="input_check"><input name="mainmarkets[]" value="Mid East" type="checkbox" '.$ch7.'> Mid East</label></td>
                          <td><label class="input_check"><input name="mainmarkets[]" value="Eastern Asia" type="checkbox" '.$ch8.'> Eastern Asia</label></td>
                          <td><label class="input_check"><input name="mainmarkets[]" value="Westaern Europe" type="checkbox" '.$ch9.'> Westaern Europe</label></td>
                        </tr>
                      </tbody>
                    </table> 
                </div>
            </div>';

            $html.='<div class="col-sm-6">
                <div class="form-group">
                    <label>Main Customer(s)</label>
                    <input name="maincustomer" id="maincustomer" type="text" class="form-control" value="'.$data[maincustomer].'"/>
                </div>
            </div>';
            $ch1='';
            $ch2='';
            $ch3='';
            $ch4='';
            $ch5='';
            $ch6='';
            $ch7='';
            $ch8='';
            $ch9='';
            $ch10='';
            $ch11='';
            $ch12='';
            $html.='<div class="col-sm-6">
                <div class="form-group">
                    <label>  Total Annual Sales Volume</label>';
                    if($data[toannualsalesvolume]==''){$ch1='selected="selected"';}
                    if($data[toannualsalesvolume]=='Below US$1 Million'){$ch2='selected="selected"';}
                    if($data[toannualsalesvolume]=='US$101 - US$500 Million'){$ch3='selected="selected"';}
                    if($data[toannualsalesvolume]=='US$501 - US$1 Million'){$ch4='selected="selected"';}
                    $html.='<select name="toannualsalesvolume" id="toannualsalesvolume" class="form-control">
                        <option value="" '.$ch1.'> </option>
                        <option value="Below US$1 Million" '.$ch2.'>Below US$1 Million</option>
                        <option value="US$101 - US$500 Million" '.$ch3.'>US$101 - US$500 Million </option>
                        <option value="US$501 - US$1 Million" '.$ch4.'>US$501 - US$1 Million</option>
                    </select>
                </div>
            </div>';	
            $ch1='';
            $ch2='';
            $ch3='';
            $ch4='';
            $ch5='';
            $ch6='';
            $ch7='';
            $ch8='';
            $ch9='';
            $ch10='';
            $ch11='';
            $ch12='';				
            $html.='<div class="col-sm-6">
                <div class="form-group">
                    <label>Export Percentage </label>';
                    if($data[exportpercentage]==''){$ch1='selected="selected"';}
                    if($data[exportpercentage]=='1% - 10%'){$ch2='selected="selected"';}
                    if($data[exportpercentage]=='11% - 20%'){$ch3='selected="selected"';}
                    if($data[exportpercentage]=='21% - 30%'){$ch4='selected="selected"';}
                    if($data[exportpercentage]=='31% - 40%'){$ch5='selected="selected"';}
                    if($data[exportpercentage]=='41% - 50%'){$ch6='selected="selected"';}		
                    $html.='<select name="exportpercentage" id="exportpercentage" class="form-control">
                        <option value="" '.$ch1.'> </option>
                        <option value="1% - 10%" '.$ch2.'>1% - 10%</option>
                        <option value="11% - 20%" '.$ch3.'>11% - 20% </option>
                        <option value="21% - 30%" '.$ch4.'>21% - 30%</option>
                        <option value="31% - 40%" '.$ch5.'>31% - 40%</option>
                        <option value="41% - 50%" '.$ch6.'>41% - 50%</option>
                    </select>
                </div>
            </div>';		
            $ch1='';
            $ch2='';
            $ch3='';
            $ch4='';
            $ch5='';
            $ch6='';
            $ch7='';
            $ch8='';
            $ch9='';
            $ch10='';
            $ch11='';
            $ch12='';		
            $html.='<div class="col-sm-6">
                <div class="form-group">
                    <label> Total Annual Purchase Volume</label>';
                    if($data[toannualpurchasevolume]==''){$ch1='selected="selected"';}
                    if($data[toannualpurchasevolume]=='Below US$1 Million'){$ch2='selected="selected"';}
                    if($data[toannualpurchasevolume]=='US$101 - US$500 Million'){$ch3='selected="selected"';}
                    if($data[toannualpurchasevolume]=='US$501 - US$1 Million'){$ch4='selected="selected"';}	
                    $html.='<select name="toannualpurchasevolume" id="toannualpurchasevolume" class="form-control">
                        <option value="" '.$ch1.'> </option>
                        <option value="Below US$1 Million" '.$ch2.'>Below US$1 Million</option>
                        <option value="US$101 - US$500 Million" '.$ch3.'>US$101 - US$500 Million </option>
                        <option value="US$501 - US$1 Million" '.$ch4.'>US$501 - US$1 Million</option>
                    </select>
                </div>
            </div>';	
            $ch1='';
            $ch2='';
            $ch3='';
            $ch4='';
            $ch5='';
            $ch6='';
            $ch7='';
            $ch8='';
            $ch9='';
            $ch10='';
            $ch11='';
            $ch12='';			
            $html.='<div class="col-sm-6">
                <div class="form-group">
                    <label>  Factory Size</label>';
                    if($data[factorysize]==''){$ch1='selected="selected"';}
                    if($data[factorysize]=='Below 1000 Square meter'){$ch2='selected="selected"';}
                    if($data[factorysize]=='1000 - 3000 Square meter'){$ch3='selected="selected"';}
                    if($data[factorysize]=='3000 - 5000 Square meter'){$ch4='selected="selected"';}	
                    $html.='<select name="factorysize" id="factorysize" class="form-control">
                        <option value="" '.$ch1.'> </option>
                        <option value="Below 1000 Square meter" '.$ch2.'>Below 1000 Square meter</option>
                        <option value="1000 - 3000 Square meter" '.$ch3.'>1000 - 3000 Square meter </option>
                        <option value="3000 - 5000 Square meter" '.$ch4.'>3000 - 5000 Square meter</option>
                    </select>
                </div>
            </div>';			
            $html.='<div class="col-sm-6">
                <div class="form-group">
                    <label>Factory Location </label>
                    <input name="factorylocation" id="factorylocation" type="text" class="form-control" value="'.$data[factorylocation].'"/>
                </div>
            </div>';	
            $ch1='';
            $ch2='';
            $ch3='';
            $ch4='';
            $ch5='';
            $ch6='';
            $ch7='';
            $ch8='';
            $ch9='';
            $ch10='';
            $ch11='';
            $ch12='';		
            $html.='<div class="col-sm-6">
                <div class="form-group">
                    <label>QA/QC</label>';
                    if($data[qaqc]==''){$ch1='selected="selected"';}
                    if($data[qaqc]=='In House'){$ch2='selected="selected"';}
                    if($data[qaqc]=='Third Parties'){$ch3='selected="selected"';}
                    if($data[qaqc]=='No'){$ch4='selected="selected"';}	
                    $html.='<select name="qaqc" id="qaqc" class="form-control">
                        <option value="" '.$ch1.'> </option>
                        <option value="In House" '.$ch2.'>In House</option>
                        <option value="Third Parties" '.$ch3.'>Third Parties </option>
                        <option value="No" '.$ch4.'>No</option>
                    </select>
                </div>
            </div>';	
            $ch1='';
            $ch2='';
            $ch3='';
            $ch4='';
            $ch5='';
            $ch6='';
            $ch7='';
            $ch8='';
            $ch9='';
            $ch10='';
            $ch11='';
            $ch12='';		
            $html.='<div class="col-sm-6">
                <div class="form-group">
                    <label>No. of Production Lines</label>';
                    if($data[noofprodlines]==''){$ch1='selected="selected"';}
                    if($data[noofprodlines]==1){$ch2='selected="selected"';}
                    if($data[noofprodlines]==2){$ch3='selected="selected"';}
                    if($data[noofprodlines]==3){$ch4='selected="selected"';}
                    if($data[noofprodlines]==4){$ch5='selected="selected"';}
                    if($data[noofprodlines]==5){$ch6='selected="selected"';}
                    if($data[noofprodlines]==6){$ch7='selected="selected"';}
                    if($data[noofprodlines]==7){$ch8='selected="selected"';}
                    if($data[noofprodlines]==8){$ch9='selected="selected"';}
                    if($data[noofprodlines]==9){$ch10='selected="selected"';}
                    if($data[noofprodlines]==10){$ch11='selected="selected"';}	
                    $html.='<select name="noofprodlines" id="noofprodlines" class="form-control">
                        <option value="" '.$ch1.'> </option>
                        <option value="1" '.$ch2.'>1</option>
                        <option value="2" '.$ch3.'>2 </option>
                        <option value="3" '.$ch4.'>3</option>
                        <option value="4" '.$ch5.'>4</option>
                        <option value="5" '.$ch6.'>5 </option>
                        <option value="6" '.$ch7.'>6</option>
                        <option value="7" '.$ch8.'>7</option>
                        <option value="8" '.$ch9.'>8 </option>
                        <option value="9" '.$ch10.'>9</option>
                        <option value="10" '.$ch11.'>10</option>
                    </select>
                </div>
            </div>';	
            $ch1='';
            $ch2='';
            $ch3='';
            $ch4='';
            $ch5='';
            $ch6='';
            $ch7='';
            $ch8='';
            $ch9='';
            $ch10='';
            $ch11='';
            $ch12='';		
            $html.='<div class="col-sm-6">
                <div class="form-group">
                    <label>No. of R&D Staff </label>';
                    if($data['noofrdstaff']==''){$ch1='selected="selected"';}
                    if($data['noofrdstaff']=='Less than 5 People'){$ch2='selected="selected"';}
                    if($data['noofrdstaff']=='5 - 10 People'){$ch3='selected="selected"';}
                    if($data['noofrdstaff']=='11 - 20 People'){$ch4='selected="selected"';}
                    if($data['noofrdstaff']=='21 - 30 People'){$ch5='selected="selected"';}
                    if($data['noofrdstaff']=='31 - 40 People'){$ch6='selected="selected"';}
                    if($data['noofrdstaff']=='41 - 50 People'){$ch7='selected="selected"';}
                    if($data['noofrdstaff']=='51 - 60 People'){$ch8='selected="selected"';}	
                    $html.='<select name="noofrdstaff" id="noofrdstaff" class="form-control">
                        <option value="" '.$ch1.'> </option>
                        <option value="Less than 5 People" '.$ch2.'>Less than 5 People</option>
                        <option value="5 - 10 People" '.$ch3.'>5 - 10 People</option>
                        <option value="11 - 20 People" '.$ch4.'>11 - 20 People</option>
                        <option value="21 - 30 People" '.$ch5.'>21 - 30 People</option>
                        <option value="31 - 40 People" '.$ch6.'>31 - 40 People</option>
                        <option value="41 - 50 People" '.$ch7.'>41 - 50 People</option>
                        <option value="51 - 60 People" '.$ch8.'>51 - 60 People</option>>
                    </select>
                </div>
            </div>';	
            $ch1='';
            $ch2='';
            $ch3='';
            $ch4='';
            $ch5='';
            $ch6='';
            $ch7='';
            $ch8='';
            $ch9='';
            $ch10='';
            $ch11='';
            $ch12='';			
            $html.='<div class="col-sm-6">
                <div class="form-group">
                    <label>No. of QC Staff </label>';
                    if($data['noofqcstaff']=='Less than 5 People'){$ch2='selected="selected"';}
                    if($data['noofqcstaff']=='5 - 10 People'){$ch3='selected="selected"';}
                    if($data['noofqcstaff']=='11 - 20 People'){$ch4='selected="selected"';}
                    if($data['noofqcstaff']=='21 - 30 People'){$ch5='selected="selected"';}
                    if($data['noofqcstaff']=='31 - 40 People'){$ch6='selected="selected"';}
                    if($data['noofqcstaff']=='41 - 50 People'){$ch7='selected="selected"';}
                    if($data['noofqcstaff']=='51 - 60 People'){$ch8='selected="selected"';}	
                    $html.='<select name="noofqcstaff" id="noofqcstaff" class="form-control">
                        <option value="" '.$ch1.'> </option>
                        <option value="Less than 5 People" '.$ch2.'>Less than 5 People</option>
                        <option value="5 - 10 People" '.$ch3.'>5 - 10 People</option>
                        <option value="11 - 20 People" '.$ch4.'>11 - 20 People</option>
                        <option value="21 - 30 People" '.$ch5.'>21 - 30 People</option>
                        <option value="31 - 40 People" '.$ch6.'>31 - 40 People</option>
                        <option value="41 - 50 People" '.$ch7.'>41 - 50 People</option>
                        <option value="51 - 60 People" '.$ch8.'>51 - 60 People</option>>
                    </select>
                </div>
            </div>';	
            $ch1='';
            $ch2='';
            $ch3='';
            $ch4='';
            $ch5='';
            $ch6='';
            $ch7='';
            $ch8='';
            $ch9='';
            $ch10='';
            $ch11='';
            $ch12='';			
            $mm=explode(',',$data[mgmtcertification]);
            if (in_array("HACCP", $mm)){$ch1='checked';}
            if (in_array("ISO 17799", $mm)){$ch2='checked';}
            if (in_array("ISO 9000/9001/9004/19001:200", $mm)){$ch3='checked';}
            if (in_array("QHASA 18001", $mm)){$ch4='checked';}
            if (in_array("QS-9000", $mm)){$ch5='checked';}
            if (in_array("TL 9000", $mm)){$ch6='checked';}
            if (in_array("ISO 14000/14001", $mm)){$ch7='checked';}
            if (in_array("Others", $mm)){$ch8='checked';}
            if (in_array("SA80000", $mm)){$ch9='checked';}
            $html.='<div class="col-sm-12">
                <div class="form-group">
                    <label> Main Markets</label>';
                    $html.='<table border="0" width="100%">
                        <tbody>
                            <tr>
                                <td><label class="input_check"><input name="mgmtcertification[]" value="HACCP" type="checkbox" '.$ch1.'> HACCP</label></td>
                                <td><label class="input_check"><input name="mgmtcertification[]" value="ISO 17799" type="checkbox" '.$ch2.'> ISO 17799 </label></td>
                                <td><label class="input_check"><input name="mgmtcertification[]" value="ISO 9000/9001/9004/19001:200" type="checkbox" '.$ch3.'> ISO 9000/9001/9004/19001:</label>2000 </td>
                            </tr>
                            <tr>
                                <td><label class="input_check"><input name="mgmtcertification[]" value="QHASA 18001" type="checkbox" '.$ch4.'> OHASA 18001</label></td>
                                <td><label class="input_check"><input name="mgmtcertification[]" value="QS-9000" type="checkbox" '.$ch5.'> QS-9000</label></td>
                                <td><label class="input_check"><input name="mgmtcertification[]" value="TL 9000" type="checkbox" '.$ch6.'> TL 9000</label></td>
                            </tr>
                            <tr>
                                <td><label class="input_check"><input name="mgmtcertification[]" value="ISO 14000/14001" type="checkbox" '.$ch7.'> ISO 14000/14001</label></td>
                                <td><label class="input_check"><input name="mgmtcertification[]" value="Others" type="checkbox" '.$ch8.'> OTHER</label></td>
                                <td><label class="input_check"><input name="mgmtcertification[]" value="SA80000" type="checkbox" '.$ch9.'> SA80000</label></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>';	
            $ch1='';
            $ch2='';
            $ch3='';
            $ch4='';
            $ch5='';
            $ch6='';
            $ch7='';
            $ch8='';
            $ch9='';
            $ch10='';
            $ch11='';
            $ch12='';		
            $mm=explode(',',$data[contactmant]);
            if (in_array("OEM Service Offered", $mm)){$ch1='checked';}
            if (in_array("buyer Label Offered", $mm)){$ch2='checked';}
            if (in_array("Design Service Offered", $mm)){$ch3='checked';}
            $html.='<div class="col-sm-12">
                <div class="form-group">
                    <label>Contract Manufacturing </label>';	
                    $html.='<table border="0" width="100%">
                        <tbody>
                            <tr>
                                <td><label class="input_check"><input name="contactmant[]" id="contactmant" value="OEM Service Offered" type="checkbox" '.$ch1.'> OEM Service Offered</label></td>
                                <td><label class="input_check"><input name="contactmant[]" id="contactmant" value="buyer Label Offered" type="checkbox" '.$ch2.'> Buyer Label Offered</label></td>
                                <td><label class="input_check"><input name="contactmant[]" id="contactmant" value="Design Service Offered" type="checkbox" '.$ch3.'> Design Service Offered</label></td>
                            </tr>
                        </tbody>
                    </table>';
                $html.='</div>
            </div>';																		
            
            $html.='<div class="col-sm-12">
                <div class="form-group">
                    
                    <input name="savecmp" type="submit" class="btn btn-primary btn-lg sendcompanyData compDt" value="Save">
                    <input type="hidden" name="ajax" value="1">
                    <input type="hidden" name="SourceForm" value="updateComapny">';
                    $proType = $data['P_service'];
                    if($proType == 'P')
                {
                    $html.='<a href="http://www.annexis.net/dashboard/products/" class="btn btn-primary btn-lg" role="button">Add Product</a>';
                }
                else
                {
                   $html.='<a href="http://www.annexis.net/dashboard/products/" class="btn btn-primary btn-lg" role="button">Add Service</a>';
                 
                }
                 $html.='</div>
            </div>
        </div>
        <div class="errMsg"></div>
    </form>'; 																								
    return $html;
     /*<button name="nextcmp" type="submit" class="btn btn-primary btn-lg nextPro compDt" value="nextp">Next</button>*/
     /*<!--<button name="savecmp" type="submit" id="1" class="btn btn-primary btn-lg sendcompanyData compDt" value="sendcomp">Save</button><input name="id_user" id="id_user" type="hidden" value="'.$id_user.'" /> onclick="sendcompanydata()
     <button type="submit" class="btn btn-primary btn-lg ">Preview</button>-->*/
    }


  function showCompanyCatagory(){
   
    $proType = $_REQUEST['prType'];
    if($proType =='S'){
            $pid = 2;
            $ty  = 'Service';
        }
        else{
            $pid = 1;
            $ty  = 'Product';
        }

    $html.='<label>*'.$ty.' Category</label>
            <select name="p_category" id="p_category" class="form-control">';                                                   
            $ExtraQryStr    = " status='Y' AND mainCategory=".$pid." AND parent_id=".$pid." order by category ASC";
            $data           = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr,0,9999);

                $html.='<option class="prCategory" value=""  data-parent="0">Select</option>';
                foreach($data as $dataC)
                {
                    $html.='<option class="prCategory" value="'.$dataC[c_id].'" '.$sel.'  data-parent="'.$dataC[c_id].'">'.$dataC[category].'</option>';

                    $pId        = $dataC['c_id'];

                    $ExtraQryCh     = " status='Y' AND parent_id=".$dataC['c_id']." order by category ASC";
                    $dataCh         = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryCh,0,9999);
                    if($dataCh){
                        foreach($dataCh as $child){
                            $html.='<option class="cCategory" value="'.$child[c_id].'">&nbsp;&nbsp;&nbsp;&nbsp;'.$child[category].'</option>';
                        }
                    }
                }
            $html.='</select>
            <div class="categoryDetails"></div>';

     return $html;

  }

function updateMemberInfo(){

       
     
        $uid       = $_REQUEST['uid'];
        $name      = $_REQUEST['name'];
        $surname   = $_REQUEST['surname'];
        $email   = $_REQUEST['email'];  
        $company   = $_REQUEST['company'];
        $companyAddress   = $_REQUEST['companyAddress'];
        $phone   = $_REQUEST['phone'];
        $new_phone   = $_REQUEST['new_phone'];  
        $new_email   = $_REQUEST['new_email'];   
        $website   = $_REQUEST['website'];
        $country   = $_REQUEST['country'];
        $state   = $_REQUEST['state'];
        $city   = $_REQUEST['city'];
        $zip   = $_REQUEST['zip'];
        $password  = $_REQUEST['password'];
        $newpassword  = $_REQUEST['newpassword'];
        $retypepassword  = $_REQUEST['retypepassword'];



        if($uid){
            $ExtraQryStr   = " id=".$uid;
            $fetch_Existing_Lg   = $this->connect->selectSingle(TBL_MEMBER, "*", $ExtraQryStr); 
                       }

                    
                    $error = 0;

                    $fObj = new FileUpload;

                    $targetLocation = UPFLD."/member";
                    $TWH[0]         = 185;      // thumb width
                    $TWH[1]         = 185;      // thumb height
                    $LWH[0]         = 450;      // large width
                    $LWH[1]         = 450;      // large height
                    $option         = 'all';    // upload, thumbnail, resize, all

                  if($_FILES['profilePic']['name'])
                  {
                   


                    if($_FILES['profilePic']['size']<=2097152)
                {
                   
                    $fileName = time();
                    if($target_image = $fObj->uploadImage($_FILES['profilePic'], $targetLocation, $fileName, $TWH, $LWH, $option)){
                        

                            if($fetch_Existing_Lg['profilePic'])
                            {
                                @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['profilePic']);
                                @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['profilePic']);
                                @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['profilePic']);
                            }
                        }
                        $params1 = array();
                        $params1['profilePic']  = $target_image;
                        $CLAUSE            = "id = '".$uid."'";
                        $result = $this->connect->updateQuery(TBL_MEMBER, $params1, $CLAUSE);

                        }

                        else{
                        $error = 1;
                        $msg_text = 'Company logo is too large to be uploaded! Your file size should be 2MB max.';
                        } 
               }   

               if($password && $newpassword=='' && $retypepassword==''){
                   
                        $msg_type       = 0;
                        $msg_text       = "Please type new password!";
                        $redirect_url   = '';
                        $error = 1;
                    }     
                    elseif($password && $newpassword && $retypepassword=='')
                    { 
                        $msg_type       = 0;
                        $msg_text       = "Please retype new password!";
                        $redirect_url   = '';
                        $error = 1;
                    }
                    elseif($password=='' && $newpassword && $retypepassword)
                    {
                        $msg_type       = 0;
                        $msg_text       = "Please type old password!";
                        $redirect_url   = '';
                        $error = 1;
                    }  
                    elseif($password=='' && $newpassword && $retypepassword=='')
                    {
                        $msg_type       = 0;
                        $msg_text       = "Please type old password!";
                        $redirect_url   = '';
                        $error = 1;
                    }  
                    elseif($password && $newpassword=='' && $retypepassword)
                    {
                        $msg_type       = 0;
                        $msg_text       = "Please type new password!";
                        $redirect_url   = '';
                        $error = 1;
                    }  
                    elseif($password=='' && $newpassword=='' && $retypepassword)
                    {
                        $msg_type       = 0;
                        $msg_text       = "Please type old and new password!";
                        $redirect_url   = '';
                        $error = 1;
                    }            

                    elseif($password && $newpassword && $retypepassword)
                    {
                       // $md5password = md5($password);
                         $ExtraQryStr = "id='".$uid."' and email = '".$email."' and ori_password = '".$password."' and usertype = 'Seller' and status = 'Y'";
                         $verify = $this->connect->selectSingle(TBL_MEMBER, "*", $ExtraQryStr); 
                         $error = 1;
                         if($verify)
                         {
                             $gObj = new genl();

                            if($gObj->validate_alpha($newpassword)) {
                                if($newpassword == $retypepassword) {

                                    $params2= array();

                                    $params2['password']      = md5($newpassword);
                                    $params2['ori_password']      = $newpassword;
                                    $params2['modifiedDate']  = date("Y-m-d H:i:s");
                                    $CLAUSE = "id = ".$uid;
                                    $result = $this->connect->updateQuery(TBL_MEMBER, $params2, $CLAUSE);
                                    $error = 0;
                                }
                                else{                                        
                                    $msg_type       = 0;
                                    $msg_text       = "Passwords do not match!";
                                    $redirect_url   = '';
                                }
                            }
                            else{                                                                           
                                $msg_type       = 0;
                                $msg_text       = "Passwords must be between 8 – 15 characters and include at least 1 capital letter, 1 non-capital letter and 1 number!";
                                $redirect_url   = '';
                            }
                         }
                        else{                                                                          
                            $msg_type       = 0;
                            $msg_text       = "Current password is incorrect";
                            $redirect_url   = '';
                            $error          = 1;
                    }
                }


                if($company || $companyAddress || $website){
                     $error = 0;
                    $params3 = array();
                    $params3['companyname'] = $company;
                     $params3['company_address'] = $companyAddress;
                      $params3['url'] = $website;
                      $CLAUSE = "user_id = ".$uid;
                        $result = $this->connect->updateQuery(TBL_COMPANY, $params3, $CLAUSE);
                       
                }
            
                    
                        
       if($error == 0)
      
{
                    $i=0;
                    $params1                     = array();
                    
                  
                    $params1['name']      = $name;
                    $params1['email']     = $email;
                    $params1['phone']     = $phone;
                    $params1['new_phone'] = $new_phone;
                    $params1['new_email'] = $new_email;
                    $params1['country']   = $country;
                    $params1['state']     = $state;
                    $params1['city']      = $city;
                    $params1['zip']       = $zip;
                
        
        $CLAUSE = "id = ".$uid;
        $result = $this->connect->updateQuery(TBL_MEMBER, $params1, $CLAUSE);
        $error =0;
        $msg_text ='Account data uploaded succesfully';


                       $_SESSION['FUSERLOGIN']     = 'ok';
                        $_SESSION['FUSERID']        = $uid;
                        $_SESSION['FUSERNAME']      = $name;
                        $_SESSION['FUSERPHONE']     = $phone;
                        $_SESSION['FUSERNEW_PHONE'] = $new_phone;
                        $_SESSION['FUSERCOMPANY']   = $company;
                        $_SESSION['FUSERWEBSITE']   = $website;
                        $_SESSION['FUSERNEW_EMAIl'] = $new_email;
                        $_SESSION['FUSERSURNAME']   = $surname;
                        $_SESSION['FUSERCOUNTRY']   = $country;
                        $_SESSION['FUSERSTATE']     = $state;
                        $_SESSION['FUSERCITY']      = $city;
                        $_SESSION['FUSERZIP']       = $zip;



            
        }
        
        $result_arr = array();     
        $result_arr['msg']       = $msg_text;
        $result_arr['error'] = $error;        
        // $result_arr['email']       = $ExtraQryStr;
        // $result_arr['password'] = $verify;           
       return json_encode($result_arr);

      
       //$result_arr=array('msg'=>$msg_text,'error'=>$error);
      // echo json_encode($result_arr);  
   
}


    
    function sendcompanydata($id_user)
    {         
        if($id_user){
           $ExtraQryStr   = " user_id=".$id_user;
            $compData     = $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr); 
        }
        /*if($_FILES['img']['name'])
        {
            if($_FILES['img']['size']<=2097152) // max 2MB
            {
                $extension_lg_array = pathinfo($_FILES['img']['name']);

                if($extension_lg_array['basename']){
                    $extension_lg = strtolower($extension_lg_array['extension']);
                    $chat = $extension_lg_array['basename'];
                }
                $fObj           = new FileUpload;
                $target_file    = rand().'.'.$extension_lg;
                $targetLocation = UPFLD."/upload/".$target_file;
                $fObj->moveUploadedFile($_FILES['img'], $targetLocation);
                
                $params                 = array();
                $params['companylogo']  = $target_file;
                $CLAUSE                 = "user_id = '".$id_user."'";
                //$result = $this->connect->updateQuery(TBL_COMPANY, $params, $CLAUSE);
            }
            else{
                $error = 1;
                $msg_text = 'Company logo is too large to be uploaded! Your file size should be 2MB max.';
            }
        }*/
        $error = 0;
        $fObj           = new FileUpload;            
        $targetLocation = UPFLD."/upload"; 

        $TWH[0]         = 309;      // thumb width
        $TWH[1]         = 205;      // thumb height
        $LWH[0]         = 640;      // large width
        $LWH[1]         = 424;      // large height
        $option         = 'all';    // upload, thumbnail, resize, all 

        if($_FILES['companylogo']['size']<=2097152) // max 2MB
        {
            $fileName = time();
            if($target_image = $fObj->uploadImage($_FILES['companylogo'], $targetLocation, $fileName, $TWH, $LWH, $option)){	

                if($compData['companylogo'])
                {
                    @unlink($targetLocation.'/normal/'.$compData['companylogo']);
                    @unlink($targetLocation.'/thumb/'.$compData['companylogo']);	
                    @unlink($targetLocation.'/large/'.$compData['companylogo']);
                }
                $params = array();
                $params['companylogo']  = $target_image;
                $CLAUSE                 = "user_id = '".$id_user."'";
                $result = $this->connect->updateQuery(TBL_COMPANY, $params, $CLAUSE);
            }
        }
        else{
            $error = 1;
            $msg_text = 'Company logo is too large to be uploaded! Your file size should be 2MB max.';
        }
        if($_FILES['image1']['size']<=2097152) // max 2MB
        {
            $fileName1 = time().'1';
            if($target_image1 = $fObj->uploadImage($_FILES['image1'], $targetLocation, $fileName1, $TWH, $LWH, $option)){	

                if($compData['image1'])
                {
                    @unlink($targetLocation.'/normal/'.$compData['image1']);
                    @unlink($targetLocation.'/thumb/'.$compData['image1']);	
                    @unlink($targetLocation.'/large/'.$compData['image1']);
                }
                $params = array();
                $params['image1']  = $target_image1;
                $CLAUSE            = "user_id = '".$id_user."'";
                $result = $this->connect->updateQuery(TBL_COMPANY, $params, $CLAUSE);
            }
        }
        else{
            $error = 1;
            $msg_text = 'Image 1 is too large to be uploaded! Your file size should be 2MB max.';
        }
        if($_FILES['image2']['size']<=2097152) // max 2MB
        {
            $fileName2 = time().'2';
            if($target_image2 = $fObj->uploadImage($_FILES['image2'], $targetLocation, $fileName2, $TWH, $LWH, $option)){	

                if($compData['image2'])
                {
                    @unlink($targetLocation.'/normal/'.$compData['image2']);
                    @unlink($targetLocation.'/thumb/'.$compData['image2']);	
                    @unlink($targetLocation.'/large/'.$compData['image2']);
                }
                $params = array();
                $params['image2']  = $target_image2;
                $CLAUSE            = "user_id = '".$id_user."'";
                $result = $this->connect->updateQuery(TBL_COMPANY, $params, $CLAUSE);
            }
        }
        else{
            $error = 1;
            $msg_text = 'Image 2 is too large to be uploaded! Your file size should be 2MB max.';
        }
        
        if($_FILES['image3']['size']<=2097152) // max 2MB
        {
            $fileName3 = time().'3';
            if($target_image3 = $fObj->uploadImage($_FILES['image3'], $targetLocation, $fileName3, $TWH, $LWH, $option)){	

                if($compData['image3'])
                {
                    @unlink($targetLocation.'/normal/'.$compData['image3']);
                    @unlink($targetLocation.'/thumb/'.$compData['image3']);	
                    @unlink($targetLocation.'/large/'.$compData['image3']);
                }
                $params = array();
                $params['image3']  = $target_image3;
                $CLAUSE            = "user_id = '".$id_user."'";
                $result = $this->connect->updateQuery(TBL_COMPANY, $params, $CLAUSE);
            }
        }
        else{
            $error = 1;
            $msg_text = 'Image 3 is too large to be uploaded! Your file size should be 2MB max.';
        }
        
        if($_FILES['image4']['size']<=2097152) // max 2MB
        {
            $fileName4 = time().'4';
            if($target_image4 = $fObj->uploadImage($_FILES['image4'], $targetLocation, $fileName4, $TWH, $LWH, $option)){	

                if($compData['image4'])
                {
                    @unlink($targetLocation.'/normal/'.$compData['image4']);
                    @unlink($targetLocation.'/thumb/'.$compData['image4']);	
                    @unlink($targetLocation.'/large/'.$compData['image4']);
                }
                $params = array();
                $params['image4']  = $target_image4;
                $CLAUSE            = "user_id = '".$id_user."'";
                $result = $this->connect->updateQuery(TBL_COMPANY, $params, $CLAUSE);
            }
        }
        else{
            $error = 1;
            $msg_text = 'Image 4 is too large to be uploaded! Your file size should be 2MB max.';
        }
        
        if($_FILES['image5']['size']<=2097152) // max 2MB
        {
            $fileName5 = time().'5';
            if($target_image5 = $fObj->uploadImage($_FILES['image5'], $targetLocation, $fileName5, $TWH, $LWH, $option)){	

                if($compData['image5'])
                {
                    @unlink($targetLocation.'/normal/'.$compData['image5']);
                    @unlink($targetLocation.'/thumb/'.$compData['image5']);	
                    @unlink($targetLocation.'/large/'.$compData['image5']);
                }
                $params = array();
                $params['image5']  = $target_image5;
                $CLAUSE            = "user_id = '".$id_user."'";
                $result = $this->connect->updateQuery(TBL_COMPANY, $params, $CLAUSE);
            }
        }
        else{
            $error = 1;
            $msg_text = 'Image 5 is too large to be uploaded! Your file size should be 2MB max.';
        }
        
        
        $i=0;
        $params1                     = array();
        
        foreach ($_REQUEST as $name => $value)
        {             
            if($name!='func' and $name!='slika' and $name!='SourceForm' and $name!='id_user' and $name!='ajax' and $name!='companylogo' and $name!='image1' and $name!='image2' and $name!='image3' and $name!='image4' and $name!='image5' and $name!='ajx' and $name!='page' and $name!='nextp' and $name!='pageType')
            {                             
              if($name=='noofrdstaff')
              {
                  $name='noofrdstaff';
              }
              if($name=='mainmarkets')
              {
                  $val='';
                  foreach($_REQUEST['mainmarkets'] as $mm)
                  {
                      $val.=$mm.',';
                  }
                  $value=substr($val, 0, -1);
              } 
              if($name=='mgmtcertification')
              {
                  $val='';
                  foreach($_REQUEST['mgmtcertification'] as $mm)
                  {
                      $val.=$mm.',';
                  }
                  $value=substr($val, 0, -1);
              }
              if($name=='contactmant')
              {
                  $val='';
                  foreach($_REQUEST['contactmant'] as $mm)
                  {
                      $val.=$mm.',';
                  }
                  $value=substr($val, 0, -1);
              }	
              if($name=='img')
              {
                $name='companylogo';
              }	 
                
             $params1[$name] = addslashes($value);

            }
        }
                
        
        $CLAUSE = "user_id = ".$id_user;
        $result = $this->connect->updateQuery(TBL_COMPANY, $params1, $CLAUSE);
        /*if($result){*/
            $error =0;
            $msg_text ='Company data uploaded succesfully';
        /*}
        else{
            $error = 1;
            $msg_text   = 'Error!';
        }  */      
        
        
       //  $result_arr = array();     
       //  $result_arr['msg']		= $msg_text;
       //  $result_arr['error']	= $error;            
       // echo json_encode($result_arr);

      
       $result_arr=array('msg'=>$msg_text,'error'=>$error);
       echo json_encode($result_arr);
    }
    
    function reademail($id_user, $serv, $start, $limit)
    {
        $html.='<table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>From</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>';
        
        $ExtraQryStr = "id_user=".addslashes($id_user)." AND email_status = 1 AND service = '".addslashes($serv)."' ORDER BY id_sentemail DESC";
        $sentMail = $this->connect->selectMulti(TBL_SENT_EMAIL, "*", $ExtraQryStr, $start, $limit);
        
        foreach($sentMail as $data)
        {	
            $f++;
            if($data[procitano]==1)
            {
                $bold='';
            }
            else
            {
                $bold='font-weight:bold;';
            }

            if($q==6)
            {
                $c++;
                $q=0;
            }
            if($c==1)
            {
                $disp='';
            }
            else
            {
                //$disp='display:none;';
            }
            //check reply//forw
            $rep='';
            $forw='';
            if($data[rep]==1)
            {
                $rep='<a onclick="openreply('.$data[id_sentemail].')" style="cursor:pointer"><span class="glyphicon glyphicon-share-alt grey_font" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Replied"></span></a>';
            }
            if($data[forw]==1)
            {
                $forw='<a onclick="openforw('.$data[id_sentemail].')" style="cursor:pointer"><span class="glyphicon glyphicon-transfer grey_font" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Forwared"></span></a>';
            }			

            $html.='         <tr class="tbl_'.$c.' alltr" style="'.$bold.$disp.'">
                    <th scope="row">'.$f.'</th>
                    <td>'.$rep.' '.$forw.' '.$data[subject].'</td>
                    <td>'.$data[froma].'</td>
                    <td>'.$data[datum].'</td>
                    <td><a id="'.$data[id_sentemail].'" class="noti" style="cursor:pointer"><button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Open">
                        <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></button></a> <a id="'.$data[id_sentemail].'" class="remove_mail" style="cursor:pointer"><button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Delete">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a></td>
                  </tr>';
            $q++;
        }
        $html.='</tbody></table>';
        return $html;
    }    
    
  function getMessages($SId)
  {
    $ExtraQryStr = "sellerId=".addslashes($SId)." AND parentId=0 ORDER BY contactID DESC" ;
    $data        = $this->connect->selectMulti(TBL_CONTACT, "*", $ExtraQryStr,0,9999);
    return $data;
      

  }


    function readpaperemail($id_user, $start, $limit)
    {
        $html.='<table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Subject</th>
                <th>From</th>
                <th>Date</th>
                <th></th>
              </tr>
            </thead><tbody>';
        
        $ExtraQryStr = "id_user=".addslashes($id_user)." AND email_status = 1 AND service = 3 ORDER BY id_sentemail DESC";
        $sentMail = $this->connect->selectMulti(TBL_SENT_EMAIL, "*", $ExtraQryStr, $start, $limit);
        
        if($sentMail){        
            foreach($sentMail as $data)
            {
                $f++;
                if($data[procitano]==1)
                {
                    $bold='';
                }
                else
                {
                    $bold='font-weight:bold;';
                }

                if($q==6)
                {
                    $c++;
                    $q=0;
                }
                if($c==1)
                {
                    $disp='';
                }
                else
                {
                    //$disp='display:none;';
                }

                //check reply//forw
                $rep='';
                $forw='';
                if($data[rep]==1)
                {
                            $rep='<a onclick="openreply('.$data[id_sentemail].')" style="cursor:pointer"><span class="glyphicon glyphicon-share-alt grey_font" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Replied"></span></a>';
                }
                if($data[forw]==1)
                {
                    $forw='<a onclick="openforw('.$data[id_sentemail].')" style="cursor:pointer"><span class="glyphicon glyphicon-transfer grey_font" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Forwared"></span></a>';
                }			

                $html.='         <tr class="tbl_'.$c.' alltr" style="'.$bold.$disp.'">
                    <th scope="row">'.$f.'</th>
                    <td>'.$rep.' '.$forw.' '.$data[subject].'</td>
                    <td>'.$data[froma].'</td>
                    <td>'.$data[datum].'</td>
                    <td><a id="'.$data[id_sentemail].'" class="noti" style="cursor:pointer"><button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Open">
                        <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></button></a> <a id="'.$data[id_sentemail].'" class="remove_mail" style="cursor:pointer"><button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Delete">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></td>
                  </tr>';
            }
        }
        else{
            $html.='<tr><td align="center" colspan="5">No records found.</td></tr>';
        }
        $html.='</tbody></table>';
        return $html;
    }    
    
    /*------------------ADDRESS---START-----------------------------*/
    function readcompanyaddress($id_user, $start, $limit) { 
    
        $ExtraQryStr = " user_id=".addslashes($id_user);
        $comData = $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr); 
        
        
        $ExtraQryStra = " compId=".addslashes($comData['id'])." AND userId=".addslashes($id_user);
        $addData = $this->connect->selectMulti(TBL_COMPANY_ADDRESS, "*", $ExtraQryStra,0,99999); 
        /*
        <th>Show on side bar</th>
        <td><a class="addShow" href="javascript:void(0)" data-id="'.$data['id'].'" data-side="'.$data['sideBar'].'">'.$data['sideBar'].'</a></td>        
        */
        
            $html    ='<form name="" method="post" ><table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Country</th> 
                    <th>State</th>  
                    <th>City</th>  
                    <th>Address</th>
                    <th>Telephone</th>
                    <th></th>
                  </tr>
                </thead><tbody>';
        $f  =0;
        $c  =1;
        $q  =1;
        if($addData)
        {
            foreach($addData as $data)
            {	
                 $ExtraQryStrC   = " shortname='".addslashes($data['country'])."'";
                 $ctdata         = $this->connect->selectSingle(TBL_COUNTRIES, "*", $ExtraQryStrC);

                
                
                    $f++;
                    $html.='<tr class="tbl_'.$c.' alltr" style="'.$disp.'">
                        <td>'.$f.'</td>
                        <td>'.$ctdata['name'].'</td>
                        <td>'.$data['state'].'</td>
                        <td>'.$data['city'].'</td>
                        <td>'.$data['address'].'</td>
                        <td>'.$data['phone'].'</td>
                        <td> <a class="editAddress" data-id="'.$data['id'].'" data-page="editaddress" style="cursor:pointer"><span class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="Edit Address"></span></a> <a class="deleteAddress" data-id="'.$data['id'].'"  data-page="deleteadd" style="cursor:pointer">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Delete Address"></span></a></td>
                      </tr>';
                }
            }
            else{
                $html.='<tr><td align="center" colspan="6">No records found.</td></tr>';
            }
        
        
        
        $html.='</tbody></table>';
        $html.='<div class="form-group clearfix"><button data-page="addaddress" data-val="'.$comData['id'].'" type="button" class="btn btn-primary btn-lg pull-right newAddress" value="'.$id_user.'>'.$numr.'" >Add new address</button></form></div>';
        
        return $html;	
    
    }
    
    function showaddress($uid){
       
        $ExtraQryStr = " user_id=".addslashes($uid);
        $comData = $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr); 
        
        $html='<div class="h-box-100 relative">
                        <div class="h-heading">Add Address</div>
                        <div class="clear"></div>
                        <div class="h-table"><span class="formClose">X</span><div class="col-md-12"><form id="address" class="forma" onsubmit="return false;">';
        
		$html.='
		<div class="form-group">
		<label>Address</label>
        <input name="address" id="add" type="text" class="form-control"></input>
		</div>
		';		
        
        $html.='
		<div class="form-group">
		<label>State of origin</label>
        <select name="country" id="country" class="form-control">';
           
        if($shortname)
            $ext = "shortname = '".addslashes($shortname)."'";
        else
            $ext = 1; 
        $ExtraQryStr = $ext." ORDER BY name";
        $countries = $this->connect->selectMulti(TBL_COUNTRIES, "*", $ExtraQryStr, 0, 300);
          
        foreach($countries as $data)
        {

            if($shortname==$data['shortname'])
            {
                $sel='selected="selected"';
            }
            else
            {
                $sel='';
            }
            if($shortname=='')
            {
                if($data['shortname']=='IN')
                {
                    $sel='selected="selected"';
                }
            }			
            $html.='<option value="'.$data['shortname'].'" '.$sel.'>'.$data['name'].'</option>';
        }
        
        $html.='</select>
		</div>
		';
        $html.='
		<div class="form-group">
		<label>State</label>
        <input name="state" id="state" value="'.$data['state'].'" type="text" class="form-control"></input>
		</div>
		';
        $html.='
		<div class="form-group">
		<label>City</label>
        <input name="city" id="city" value="'.$data['city'].'" type="text" class="form-control"></input>
		</div>
		';
        
        
			
		$html.='
		<div class="form-group">
		<label>Phone No<span class="phone_check text-danger"></span></label>
		<input name="phone" id="phone" type="text" class="form-control"></input>
		</div>
		';		
		$html.='
		<div class="form-group">
		<label>Email<span class="email_check text-danger"></span></label>
		<input name="email" id="email" type="text" class="form-control"></input>
		</div>
		';	
		$html.='
		<div class="form-group">
		<label>Voice mail</label>
		<input name="voiceMail" id="voiceMail" type="text" class="form-control"></input>
		</div>
		';	
		$html.='
		<div class="form-group">
		<label>website</label>
		<input name="website" id="website" type="text" class="form-control"></input>
		</div>
		';				
		$html.='
		<div class="form-group">
		 <input name="id" id="" type="hidden" value="'.$uid.'" />
		 <input name="cid" id="" type="hidden" value="'.$comData['id'].'" />
		 
         <input type="submit" value="Save" class="btn btn-primary btn-lg">
         <input type="hidden" name="ajax" value="1">
         <input type="hidden" name="SourceForm" value="addAddress">
         
		 </div>';	
        $html.='<div class="errMsg"></div></form></div>';	
        /* <button type="submit" class="btn btn-primary btn-lg addAddress">Save</button>*/
        
        return $html;
    }
    
    function countryBycode($code){
        $ExtraQryStr   = " shortname='".addslashes($code)."'";
        $data          = $this->connect->selectSingle(TBL_COUNTRIES, "*", $ExtraQryStr);
    }
    
    function editaddress($uid,$id)
    {
        
        $ExtraQryStr   = " id=".addslashes($id);
        $data          = $this->connect->selectSingle(TBL_COMPANY_ADDRESS, "*", $ExtraQryStr);

        $html='<div class="h-box-100 relative">
                        <div class="h-heading">Edit Address</div>
                        <div class="clear"></div>
                        <div class="h-table"><span class="formClose">X</span><div class="col-md-12"><form id="address" class="forma" onsubmit="return false;">';
                
        $ExtraQryStr = "1 ORDER BY name";
        $countries = $this->connect->selectMulti(TBL_COUNTRIES, "*", $ExtraQryStr, 0, 300);
        
        
        $html.='
		<div class="form-group">
		<label>Address</label>
        <input name="address" id="add" value="'.$data['address'].'" type="text" class="form-control"></input>
		</div>
		';	
        
        $html.='<div class="form-group">
                    <label for="">State of origin</label>
                    <select name="country" id="country" class="form-control">';
                    foreach($countries as $cudata)
                    {
                        if($data['country']==$cudata['shortname'])
                        {
                            $sel='selected="selected"';
                        }
                        else
                        {
                            $sel='';
                        }
                        if($data['country']=='')
                        {
                            if($cudata['shortname']=='IN')
                            {
                                $sel='selected="selected"';
                            }
                        }			
                        $html.='<option value="'.$cudata['shortname'].'" '.$sel.'>'.$cudata['name'].'</option>';
                    }                    
                    $html.='</select>
                </div>
        ';
        $html.='
		<div class="form-group">
		<label>State</label>
        <input name="state" id="state" value="'.$data['state'].'" type="text" class="form-control"></input>
		</div>
		';
        $html.='
		<div class="form-group">
		<label>City</label>
        <input name="city" id="city" value="'.$data['city'].'" type="text" class="form-control"></input>
		</div>
		';
        	
		$html.='
		<div class="form-group">
		<label>Phone No</label>
		<input name="phone" id="phone" value="'.$data['phone'].'" type="text" class="form-control"></input>
		</div>
		';	
		$html.='
		<div class="form-group">
		<label>Voice mail</label>
		<input name="voiceMail" value="'.$data['voiceMail'].'" id="voiceMail" type="text" class="form-control"></input>
		</div>
		';	
		$html.='
		<div class="form-group">
		<label>website</label>
		<input name="website" value="'.$data['website'].'" id="website" type="text" class="form-control"></input>
		</div>
		';		
		$html.='
		<div class="form-group">
		<label>Email</label>
		<input name="email" value="'.$data['email'].'" id="email" type="text" class="form-control"></input>
		</div>
		';			
		$html.='
		<div class="form-group">
		 <input name="id" id="" type="hidden" value="'.$uid.'" />
		 <input name="cid" id="" type="hidden" value="'.$data['compId'].'" />
		 <input name="addId" id="" type="hidden" value="'.$data['id'].'" />
         <input type="submit" value="Save" class="btn btn-primary btn-lg">
         
         
         
		 
         <input type="hidden" name="ajax" value="1">
         <input type="hidden" name="SourceForm" value="addAddress">
		 </div>';	
        
        $html.='<div class="errMsg"></div></form></div>';	
        /*<button type="submit" class="btn btn-primary btn-lg addAddress">Save</button>*/
        
        return $html;
}    
    
    function newAddress($params)
	{		
        return $this->connect->insertQuery(TBL_COMPANY_ADDRESS, $params);
	}
    
    function addUpdateByaddressId($params, $addId){
        $CLAUSE = "id = ".$addId;
        return $this->connect->updateQuery(TBL_COMPANY_ADDRESS, $params, $CLAUSE);
    }
    
    function deleteAddressById($id){
        $this->connect->executeQuery("delete from ".TBL_COMPANY_ADDRESS." where id = ".$id);
        
        $html = '<div class="successmsg">Address deleted successfully.</div><div class="clearfix"></div>';
        return $html;
    }
    
    
    /*------------------ADDRESS--------------------------------*/
    
    /*------------------PRODUCT----START----------------------------*/
    
    function readproduct($id_user,$slNo, $start, $limit) { 
        $ExtraQryStr    = "user_id=".addslashes($id_user);
        $comData        = $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr);
        

        if(!$comData)
        {
            $html       .='<b>You have to add Company data. <a href="../company/">Use this link.</a></b>';
        }
        else
        {
            $proType = $comData['P_service'];

            $html       .='<form name="" method="post"><table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>';
                    if($proType == 'P'){
                     $html .='<th colspan="2">Products</th>';
                 }
                 else{
                    $html .='<th colspan="2">Services</th>';
                 }
                    $html .='<th>Brief description</th>
                    <th>Price range</th>
                    <th>Status</th>
                   <th>Edit</th>
                   <th>View</th>
                   <th>Delete</th>
                   </tr>
                </thead><tbody>';
            $ExtraQryStr = "userid=".$id_user;
            $productData = $this->connect->selectMulti(TBL_PRODUCT, "*", $ExtraQryStr, $start, $limit);
            $numr = sizeof($productData);
            
            $f  =0;
            $c  =1;
            $q  =1;
            if($productData){
                foreach($productData as $data)
                {	
                    $f++;
                    $img    ='';
                    if(file_exists(MDFR.'/product/large/'.$data[p_photo]) && $data[p_photo])
                    {
                        $img='<img alt="'.$data[p_name].'" src="'.SHWFL.'/product/thumb/'.$data[p_photo].'" style="width:50px; height: 50px; min-height: inherit; margin: 0;" class="thumbnail">';
                    }
                    else
                        $img='<img alt="'.$data[p_name].'" src="'.TMP.'/images/noimage.jpg" style="width:50px; height: 50px; min-height: inherit; margin: 0;" class="thumbnail" >';
                    
                    if(strlen($data[p_bdes])>50) 
                        $cnt = '...';
                    else
                        $cnt = ''; //onclick="editproductshow('.$data[id].')"
                    
                    $html.='<tr class="tbl_'.$c.' alltr" style="'.$disp.'">
                        <td>'.$slNo.'/20</td>
                        <td>'.$img.'</td>
                        <td>'.stripslashes($data[p_name]).'</td>
                        <td>'.substr($data[p_bdes],0,50).$cnt.'</td>
                        <td>'.$data[range1].' - '.$data[range2].' '.$data[p_price].'</td>';
                        if($data['status'] == 0){

                            $html.='<td><a href="#"><span class="glyphicon glyphicon-time" data-toggle="tooltip" data-placement="top" title="Pending" ></span></a></td>';
                        }
                            else{
                        $html.='<td><a href="#"><span class="glyphicon glyphicon-ok" data-toggle="tooltip" data-placement="top" title="Accepted"></span></a></td>';
                        
                    }
                        $html.='<td> <a class="editproductshow" data-id="'.$data[id].'" data-page="editproduct" data-type="'.$data[proType].'" style="cursor:pointer"><span class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="Edit product"></span></a> 
                        </td>
                        <td>
                          <a class="viewProduct" data-id="'.$data[id].'" data-page="viewProduct" data-type="'.$data[proType].'" style="cursor:pointer"><span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="View Product"></span></a>   
                            </td>
                        <td><a class="deleteproduct" data-id="'.$data[id].'" data-page="deleteProduct" style="cursor:pointer">
                         <span class="glyphicon glyphicon-remove" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Delete"></span></a>
                          </td>
                          
                      </tr>';
                    $slNo++;
                }
            }

            else{
                $html.='<tr><td align="center" colspan="6">No records found.</td></tr>';
            }
       
            $html.='</tbody></table>';

        

          if($proType == "P")
            {
            $html.='
                    <button type="button" class="btn btn-primary btn-lg pull-right addnewProduct" value="'.$id_user.'>'.$numr.'" >Add new product</button>
             </form></div><div class="clear"></div>';
         }
         else{
             $html.='
                    <button type="button" class="btn btn-primary btn-lg pull-right addnewProduct" value="'.$id_user.'>'.$numr.'" >Add new service</button>
             </form></div><div class="clear"></div>';
         }
        }
        return $html;	
    }    
    
    
     function proPreview()
    {
       $data = $_REQUEST['data'];
       $result = json_decode($data, true);
    // $html.='<div class="h-box-100 relative">
      
    //         <div class="col-md-12" style="height:7%;padding-top: 12px; background: #3467d5;">
    //         <div  style="
    //         display: block;
    //         float: left;
    // margin: 0 30px 0 0;
    // padding: 6px 10px;
    // background: #fff;
    // -webkit-border-radius: 3px;
    // border-radius: 3px;"><img src="http://www.annexisdirectory.com/templates/images/logo.png" alt="Annexis Business Solutions." style="height:30">
    // </div>
    // <div class="col-md-7"  style="padding-top:12px;">
    // <ul style="margin: 0;
    // padding: 0;
    // font-size: 14px;
    // color: #fff;
    // text-transform: capitalize;">
    // <li style="display:inline; padding-right: 10px;">Home</li>
    // <li style="display:inline; padding-right: 10px;">Product</li>
    // <li style="display:inline; padding-right: 10px;">Service</li>
    // <li style="display:inline; padding-right: 10px;">supplier</li>
    // <ul>
    // </div>
    // </div>
            
    //         <div class="col-md-6" style="height:50%;padding-top: 20px;"><img src="'.$result['image'].'" width="100%"></div>
    //         <div class="col-md-6"><h1>'.$result['p_name'].'</h1></div>
    //        <div class="row margintop30">
    //         <div class="col-md-6" style="padding-bottom: 15px;
    // margin-bottom: 15px;border-bottom: 1px solid #000;"><strong>Description: </strong>
    // '.$result['p_bdes'].'
    // </div>

    //          <div class="col-md-6" style="padding-bottom: 15px; margin-bottom: 15px;border-bottom: 1px solid #000;">
    //          <strong>Price: </strong>'.$result['p_price'].' '.$result['range1'].' - '.$result['range2'].'</div>
         
             
    //       <div class="col-md-6" style="padding-bottom: 15px;margin-bottom: 15px;border-bottom: 1px solid #000;">
    //         <strong style="color: #3b3a3b;font-size: 18px;">Qty:</strong>
    //         <span class="qty_block">
    //             <input style="padding-right: 35px; vertical-align: top;text-align: center;" name="qty[]" value="'.$result['p_min_quanity'].'" type="text" readonly="">
                
    //         </span>
    //    </div>
    //    <div class="col-md-6" style="padding-bottom: 15px;margin-bottom: 15px;border-bottom: 1px solid #000;">
    //     <input type="text" style="background: #ff7800;border-radius: 3px;
    // color: #fff;
    // font-size: 12px;
    // line-height: 40px;
    // height: 40px;
    // min-width: 80px;
    // text-align: center;
    // vertical-align: top;
    // -moz-transition: all 300ms ease-in-out 0s;
    // -webkit-transition: all 300ms ease-in-out 0s;
    // transition: all 300ms ease-in-out 0s;
    // z-index: 0;" value="REQUEST SAMPLE"> 

    // <input type="text" style="background: #084bb7;border-radius: 3px;
    // color: #fff;
    // font-size: 12px;
    // line-height: 40px;
    // height: 40px;
    // min-width: 80px;
    // text-align: center;
    // vertical-align: top;
    // -moz-transition: all 300ms ease-in-out 0s;
    // -webkit-transition: all 300ms ease-in-out 0s;
    // transition: all 300ms ease-in-out 0s;
    // z-index: 0;" value="Contact supplier"> 
         

    //         </div>

    //         <div class="col-md-6" style="padding-bottom: 15px;margin-bottom: 15px;border-bottom: 1px solid #000;">
                            
    //                                 </div>
    //         </div>
             
        
    //     <div class="col-md-12" ><b>Product Related Models</b></div>
    //    <div class="col-md-12">
    //        <div class="col-md-3" ><img src="'.$result['image1'].'" ></div>

    //        <div class="col-md-3"><img src="'.$result['image2'].'" ></div>
        
    //      <div class="col-md-3" ><img src="'.$result['image3'].'" ></div>
        
    //    <div class="col-md-3" ><img src="'.$result['image4'].'"></div>

       
    //     </div>                
    //   </div>
$html.='<div class="col-md-12" style="height:7%;padding-top: 12px; background: #3467d5;">
            <div  style="
            display: block;
            float: left;
    margin: 0 30px 0 0;
    padding: 6px 10px;
    background: #fff;
    -webkit-border-radius: 3px;
    border-radius: 3px;"><img src="http://www.annexisdirectory.com/templates/images/logo.png" alt="Annexis Business Solutions." style="height:30">
    </div>
    <div class="col-md-7"  style="padding-top:12px;">
    <ul style="margin: 0;
    padding: 0;
    font-size: 14px;
    color: #fff;
    text-transform: capitalize;">
    <li style="display:inline; padding-right: 10px;">Home</li>
    <li style="display:inline; padding-right: 10px;">Product</li>
    <li style="display:inline; padding-right: 10px;">Service</li>
    <li style="display:inline; padding-right: 10px;">supplier</li>
    <ul>
    </div>
    </div>
<div class="card">

            <div class="container-fliud">
                <div class="wrapper row">
                    <div class="preview col-md-6">
                        
                        <div class="preview-pic tab-content">
                          <div class="tab-pane active" id="pic-1"><img src="'.$result['image'].'" /></div>
                          <div class="tab-pane" id="pic-2"><img src="'.$result['image1'].' " /></div>
                          <div class="tab-pane" id="pic-3"><img src="'.$result['image2'].' " /></div>
                          <div class="tab-pane" id="pic-4"><img src="'.$result['image3'].' " /></div>
                          <div class="tab-pane" id="pic-5"><img src="'.$result['image4'].' " /></div>
                        </div>
                        <ul class="preview-thumbnail nav nav-tabs">
                          <li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="'.$result['image'].'" /></a></li>
                          <li><a data-target="#pic-2" data-toggle="tab"><img src="'.$result['image1'].'" /></a></li>
                          <li><a data-target="#pic-3" data-toggle="tab"><img src="'.$result['image2'].'" /></a></li>
                          <li><a data-target="#pic-4" data-toggle="tab"><img src="'.$result['image3'].'" /></a></li>
                          <li><a data-target="#pic-5" data-toggle="tab"><img src="'.$result['image4'].'" /></a></li>
                        </ul>
                        
                    </div>
                    <div class="details col-md-6">
                        <h3 class="product-title">'.$result['p_name'].' </h3>
                        <div class="rating">
                            <div class="stars">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                            <span class="review-no"><b>Description:</b></span>
                        </div>
                        <p class="product-description" style="padding-bottom: 15px;margin-bottom: 15px;border-bottom: 1px solid #000;">Suspendisse quos? Tempus cras iure temporibus? Eu laudantium cubilia sem sem! Repudiandae et! Massa senectus enim minim sociosqu delectus posuere.</p>
                        <h4 class="price" style="padding-bottom: 15px;margin-bottom: 15px;border-bottom: 1px solid #000;">Price: <span>'.$result['p_price'].' '.$result['range1'].' '.$result['range2'].'</span></h4>
                     
                        <h4 class="sizes" style="padding-bottom: 15px;margin-bottom: 15px;border-bottom: 1px solid #000;">Qty:
         <span class="qty_block">
             <input style="padding-right:23px; vertical-align: top;text-align: center;width: 100" name="qty[]" value="'.$result['p_min_quanity'].'" type="text" readonly="">
                
           </span>   
                        </h4>
                        <p class="price" style="padding-bottom: 15px;margin-bottom: 15px;border-bottom: 1px solid #000;">
                            <button class="add-to-cart btn btn-default" type="button">REQUEST SAMPLE</button>
                            <button class="suppler btn btn-default"  type="button">CONTACT SUPPLIER</button>
                        </p>
                        <div class="action" style="padding-bottom: 15px;margin-bottom: 15px;border-bottom: 1px solid #000;">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>';
      
          

        echo $html;
    }  
    
	function deleteAttributeByproductId($productId){        
        return $this->connect->executeQuery("delete from ".TBL_PRODUCT_ATTRIBUTES." where productId = ".addslashes($productId));
    }
	function deleteAttributeBysampleId($sampleId){
        
        return $this->connect->executeQuery("delete from ".TBL_SAMPLE_ATTRIBUTES." where sampleId = ".addslashes($sampleId));
    }
    
    function newAttribute($params)
	{		
        return $this->connect->insertQuery(TBL_PRODUCT_ATTRIBUTES, $params);
	}
    function newSampleAttribute($params)
	{		
        return $this->connect->insertQuery(TBL_SAMPLE_ATTRIBUTES, $params);
	}
    
    function getAttributeByCId($ExtraQryStr, $categoryId, $start, $limit)
	{		
		$ExtraQryStr .= " and categoryId=".$categoryId." order by attributeId";
        return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY_ATTRIBUTES, "*", $ExtraQryStr, $start, $limit); 
	}
    
    function getAttributeByproductId($ExtraQryStr, $productId, $start, $limit)
	{		
		$ExtraQryStr .= " and productId=".addslashes($productId)." order by attributeId";
		return $this->connect->selectMulti(TBL_PRODUCT_ATTRIBUTES, "*", $ExtraQryStr, $start, $limit);  
	}
    
    function viewProductShow($uid){
        $pid= $_REQUEST['pid'];
        

      $ExtraQryStr   = " id=".addslashes($pid);

        $data          = $this->connect->selectSingle(TBL_PRODUCT, "*", $ExtraQryStr);
        
        $html.='<div class="col-md-12" style="height:7%;padding-top: 12px; background: #3467d5;">
            <div  style="
            display: block;
            float: left;
    margin: 0 30px 0 0;
    padding: 6px 10px;
    background: #fff;
    -webkit-border-radius: 3px;
    border-radius: 3px;"><img src="http://www.annexisdirectory.com/templates/images/logo.png" alt="Annexis Business Solutions." style="height:30">
    </div>
    <div class="col-md-7"  style="padding-top:12px;">
    <ul style="margin: 0;
    padding: 0;
    font-size: 14px;
    color: #fff;
    text-transform: capitalize;">
    <li style="display:inline; padding-right: 10px;">Home</li>
    <li style="display:inline; padding-right: 10px;">Product</li>
    <li style="display:inline; padding-right: 10px;">Service</li>
    <li style="display:inline; padding-right: 10px;">supplier</li>
    <ul>
    </div>
    </div>
<div class="card">

            <div class="container-fliud">
                <div class="wrapper row">
                    <div class="preview col-md-6">
                        
                        <div class="preview-pic tab-content">
                          <div class="tab-pane active" id="pic-1"><img src="'.SHWFL.'/product/thumb/'.$data[p_photo].'" /></div>
                          <div class="tab-pane" id="pic-2"><img src="'.SHWFL.'/product/thumb/'.$data[p_photo1].' " /></div>
                          <div class="tab-pane" id="pic-3"><img src="'.SHWFL.'/product/thumb/'.$data[p_photo2].'" /></div>
                          <div class="tab-pane" id="pic-4"><img src="'.SHWFL.'/product/thumb/'.$data[p_photo3].'" /></div>
                          <div class="tab-pane" id="pic-5"><img src="'.SHWFL.'/product/thumb/'.$data[p_photo4].'" /></div>
                        </div>
                        <ul class="preview-thumbnail nav nav-tabs">
                          <li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="'.SHWFL.'/product/thumb/'.$data[p_photo].'" /></a></li>
                          <li><a data-target="#pic-2" data-toggle="tab"><img src="'.SHWFL.'/product/thumb/'.$data[p_photo1].'" /></a></li>
                          <li><a data-target="#pic-3" data-toggle="tab"><img src="'.SHWFL.'/product/thumb/'.$data[p_photo2].'" /></a></li>
                          <li><a data-target="#pic-4" data-toggle="tab"><img src="'.SHWFL.'/product/thumb/'.$data[p_photo3].'" /></a></li>
                          <li><a data-target="#pic-5" data-toggle="tab"><img src="'.SHWFL.'/product/thumb/'.$data[p_photo4].'" /></a></li>
                        </ul>
                        
                    </div>
                    <div class="details col-md-6">
                        <h3 class="product-title">'.$data[p_name].' </h3>
                        <div class="rating">
                            <div class="stars">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>';
                            if(strlen($data[p_bdes])>50) 
                        $cnt = '...';
                    else
                        $cnt = '';
                            $html.='
                        </div>
                        <span class="review-no" style=""><b>Description:</b> <p class="product-description" style="">'.substr($data[p_bdes],0,50).$cnt.'</p></span>
                       
                        <h4 class="price" style="padding-bottom: 15px;margin-bottom: 15px;border-bottom: 1px solid #000;">Price: <span>'.$data[p_price].' '.$data[range1].' '.$data[range2].'</span></h4>
                     
                        <h4 class="sizes" style="padding-bottom: 15px;margin-bottom: 15px;border-bottom: 1px solid #000;">Qty:
         <span class="qty_block">
             <input style="padding-right:23px; vertical-align: top;text-align: center;width: 100" name="qty[]" value="'.$data[p_min_quanity].'" type="text" readonly="">
                
           </span>   
                        </h4>
                        <p class="price" style="padding-bottom: 15px;margin-bottom: 15px;border-bottom: 1px solid #000;">
                            <button class="add-to-cart btn btn-default" type="button">REQUEST SAMPLE</button>
                            <button class="suppler btn btn-default"  type="button">CONTACT SUPPLIER</button>
                        </p>
                        <div class="action" style="padding-bottom: 15px;margin-bottom: 15px;border-bottom: 1px solid #000;">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>';
      
          

        echo $html;



    }
    
    function editproductshow($uid,$id,$proType)
    {
	   if($proType=='S'){
            $pid = 2;
            $ty  = 'Service';
        }
        else{
            $pid = 1;
            $ty  = 'Product';
        }

        $ExtraQryStr   = " id=".addslashes($id);
        $data          = $this->connect->selectSingle(TBL_PRODUCT, "*", $ExtraQryStr);
        
        $html.='
        <div class="h-box-100 relative">
            <div class="h-heading">Edit '.$ty.'</div>
            <div class="clear"></div>
            <div class="h-table"><span class="formClose">X</span>           
                <div class="">
                    <form id="proDataEdit" class="forma" onsubmit="return false;">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>*'.$ty.' Name</label>
                                    <input name="p_name" id="p_name" type="text" class="form-control" required value="'.htmlspecialchars($data[p_name]).'"/>
                                    <input name="permalink" id="permalink" type="hidden" class="form-control" value="'.$data[permalink].'"/>
                                </div>';
                                $ch1='';
                                $ch2='';
                                $ch3='';
                                $ch4='';
                                $ch5='';
                                $ch6='';
                                $ch7='';
                                $ch8='';
                                $ch9='';
                                $ch10='';
                                $ch11='';
                                $ch12='';
                                $ch13='';				
                                if($data[p_price]==''){$ch1='selected="selected"';}
                                if($data[p_price]=='USD'){$ch2='selected="selected"';}
                                if($data[p_price]=='GBP'){$ch3='selected="selected"';}
                                if($data[p_price]=='RMB'){$ch4='selected="selected"';}
                                if($data[p_price]=='EUR'){$ch5='selected="selected"';}	
                                if($data[p_price]=='AUD'){$ch6='selected="selected"';}
                                if($data[p_price]=='CAD'){$ch7='selected="selected"';}	
                                if($data[p_price]=='CHF'){$ch8='selected="selected"';}	
                                if($data[p_price]=='JPY'){$ch9='selected="selected"';}	
                                if($data[p_price]=='HKD'){$ch10='selected="selected"';}	
                                if($data[p_price]=='NZD'){$ch11='selected="selected"';}	
                                if($data[p_price]=='SGD'){$ch12='selected="selected"';}	
                                if($data[p_price]=='Other'){$ch13='selected="selected"';}
        
                                $html.='<div class="form-group" style="width:70px;  margin-right:10px; float:left;">
                                    <label>*Quantity</label>
                                    <input name="p_min_quanity"  id="p_min_quanity" type="text" class="form-control qtyinput" required value="'.$data[p_min_quanity].'"/>
                                </div>
                                <div class="form-group">
                                    <label>*Price </label><br />
                                    <select name="p_price" id="p_price" class="form-control" style="width:95px;  margin-right:5px; display:inline-block;" required>
                                        <option value="" '.$ch1.'>Currency</option>
                                        <option value="USD" '.$ch2.'> USD </option>
                                        <option value="GBP" '.$ch3.'> GBP </option>
                                        <option value="RMB" '.$ch4.'> RMB </option>
                                        <option value="EUR" '.$ch5.'> EUR </option>
                                        <option value="AUD" '.$ch6.'> AUD </option>
                                        <option value="CAD" '.$ch7.'> CAD </option>
                                        <option value="CHF" '.$ch8.'> CHF </option>
                                        <option value="JPY" '.$ch9.'> JPY </option>
                                        <option value="HKD" '.$ch10.'> HKD </option>
                                        <option value="NZD" '.$ch11.'> NZD </option>
                                        <option value="SGD" '.$ch12.'> SGD </option>
                                        <option value="Other" '.$ch13.'>Other </option>
                                    </select>
                                    <input name="range1" id="range1" type="text" class="form-control" value="'.$data[range1].'"  style="width:70px; display:inline-block;" required/> - 
                                    <input name="range2" id="range2" type="text" class="form-control" value="'.$data[range2].'"  style="width:70px; display:inline-block;" required/>
                                </div>';
                                $html.='<div class="form-group">
                                    <label>*'.$ty.' Category</label>
                                    <select name="p_category" id="p_category" class="form-control">';	

                                        $ExtraQryStr    = " status='Y' AND mainCategory=".$pid." AND parent_id=".$pid." order by category ASC";
                                        $data1           = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr,0,9999);
                                        foreach($data1 as $dataC)
                                        {
                                            if($dataC[c_id]==$data[p_category])
                                            {
                                                $sel='selected="selected"';
                                            }
                                            else
                                            {
                                                $sel='';
                                            }

                                            $html.='<option value="'.$dataC[c_id].'" '.$sel.'>'.$dataC[category].'</option>';

                                            $pId        = $dataC['c_id'];

                                            $ExtraQryCh     = " status='Y' AND parent_id=".$dataC['c_id']." order by category ASC";
                                            $dataCh         = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryCh,0,9999);

                                            if($dataCh)
                                            {
                                                foreach($dataCh as $child){

                                                    if($child[c_id]==$data[p_category])
                                                    {
                                                        $sel='selected="selected"';
                                                    }
                                                    else
                                                    {
                                                        $sel='';
                                                    }

                                                    $html.='<option class="cCategory" value="'.$child[c_id].'">&nbsp;&nbsp;&nbsp;&nbsp;'.$child[category].'</option>';
                                                }
                                            }
                                        }

                                    $html.='</select>
                                </div>
                                <div class="categoryDetails">
                                    <div class="form-group">
                                        <fieldset class="full_form_group">
                                            <legend>Category Attributes</legend>
                                            <div class="">';
                                            $cData = $this->getAttributeByCId(1, $data[p_category], 0, 99999);    
                                            for($row=0; $row<sizeof($cData); $row++)
                                            {
                                                $attributeData = array();
                                                $html.='<div class="form-group">';
                                                    $html.='<label>'.$cData[$row]['attributeName'].'</label> ';
                                                    if($cData[$row]['attributeType']=='radio' || $cData[$row]['attributeType']=='checkbox')
                                                    {
                                                        $attributeData = $this->getAttributeByproductId("attributeId='".$cData[$row]['attributeId']."'", $id, 0, 50);
                                                        $options = explode('@#@', $cData[$row]['attributeOptions']);
                                                        echo '<div class="col2">';
                                                            foreach($options as $val)
                                                            {
                                                                if($data['id'] && in_array_r($val, $attributeData))
                                                                $chk = 'checked';
                                                                else
                                                                $chk = '';

                                                                $html.='<label class="input_check">
                                                                    <input type="'.$cData[$row]['attributeType'].'"  name="attributeValueArray_'.$row.'[]" value="'.$val.'" '.$chk.'>
                                                                    <span>'.$val.'</span>
                                                                </label>';
                                                            }
                                                        echo '</div>';
                                                    }
                                                    else
                                                    {
                                                        $attributeData = $this->getAttributeByproductId(1, $id, 0, 50);

                                                        $arrayKey = searchForId('attributeId', $cData[$row]['attributeId'], $attributeData);
                                                        $html.='<input class="form-control" type="text" value="'.$attributeData[$arrayKey]['attributeValue'].'" name="attributeValueArray_'.$row.'[]">';
                                                    }
                                                $html.='</div>';
                                            }

                                                $html.='<input type="hidden" name="attributeIdArray[]" value="'.$cData[$row]['attributeId'].'">';
                                            $html.='</div>
                                        </fieldset>
                                    </div>
                                </div>';
                                
                            $html.='</div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>*'.$ty.' Keyword</label>
                                    <div class="tagpanel"><input name="p_keyword" id="tags_1" type="text" class="form-control tags" required value="'.$data[p_keyword].'"/></div>
                                </div>
                                <div class="form-group">
                                    <fieldset class="full_form_group">
                                        <legend>Gallery Image</legend>
                                        <div class="multiImg">
                                            <div class="form-group">
                                                <label>'.$ty.' main image</label>
                                                <div id="content_here_please">';
                                                    if($data[p_photo])
                                                    {
                                                        $html.='<img src="'.SHWFL.'/product/thumb/'.$data[p_photo].'" width="30%">';
                                                    }
                                                $html.='</div>
                                                <input type="file" name="img" id="image" />
                                                <input type="hidden" name="image1" id="photo1" value="'.$data[photo1].'">
                                            </div>
                                        </div>
                                        <div class="multiImg">
                                            <div class="form-group">
                                                <label>'.$ty.' image 1</label>
                                                <div id="content_here_please1">';
                                                    if($data[photo1])
                                                    {
                                                        $html.='<img src="'.SHWFL.'/product/thumb/'.$data[photo1].'" width="30%">';
                                                    }			
                                                $html.='</div>
                                                <input type="file" name="img1" id="image11"   />
                                                <input type="hidden" name="image2" id="photo2" value="'.$data[photo2].'">
                                            </div>
                                        </div>
                                        <div class="multiImg">
                                            <div class="form-group">
                                                <label>'.$ty.' image 2</label>
                                                <div id="content_here_please2">';
                                                    if($data[photo2])
                                                    {
                                                        $html.='<img src="'.SHWFL.'/product/thumb/'.$data[photo2].'" width="30%">';
                                                    }				
                                                $html.='</div>
                                                <input type="file" name="img2" id="image21" />
                                                <input type="hidden" name="image3" id="photo3" value="'.$data[photo3].'">
                                            </div>
                                        </div>
                                        <div class="multiImg">
                                            <div class="form-group">
                                                <label>'.$ty.' image 3</label>
                                                <div id="content_here_please3">';
                                                    if($data[photo3])
                                                    {
                                                        $html.='<img src="'.SHWFL.'/product/thumb/'.$data[photo3].'" width="30%">';
                                                    }				
                                                $html.='</div>
                                                <input type="file" name="img3" id="image31" />
                                                <input type="hidden" name="image4" id="photo4" value="'.$data[photo4].'">
                                            </div>
                                        </div>
                                        <div class="multiImg">
                                            <div class="form-group">
                                                <label>'.$ty.' image 4</label>
                                                <div id="content_here_please4">';
                                                    if($data[photo4])
                                                    {
                                                        $html.='<img src="'.SHWFL.'/product/thumb/'.$data[photo4].'" width="30%">';
                                                    }				
                                                $html.='</div>
                                                <input type="file" name="img4" id="image41" />
                                                <input type="hidden" name="image5" id="photo5" value="'.$data[photo5].'">
                                            </div>
                                        </div>
                                        <div class="multiImg">
                                            <div class="form-group">
                                                <label>'.$ty.' image 5</label>';
                                                $html.='<div id="content_here_please5">';
                                                    if($data[photo5])
                                                    {
                                                        $html.='<img src="'.SHWFL.'/product/thumb/'.$data[photo5].'" width="30%">';
                                                    }
                                                $html.='</div>
                                                <input type="file" name="img5" id="image51" />
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>';

                            $html.='<input name="country" type="hidden" value="95" />';

                            $ch1='';
                            $ch2='';
                            $ch3='';
                            $ch4='';
                            $ch5='';
                            $ch6='';
                            $ch7='';
                            $ch8='';
                            $ch9='';
                            $ch10='';
                            $ch11='';
                            $ch12='';
                            $ch13='';				
                            if($data[paymenttype]=='L/C'){$ch1='checked';}
                            if($data[paymenttype]=='D/A'){$ch2='checked';}
                            if($data[paymenttype]=='D/P'){$ch3='checked';}
                            if($data[paymenttype]=='T/T'){$ch4='checked';}
                            if($data[paymenttype]=='Western Union'){$ch5='checked';}	
                            if($data[paymenttype]=='MoneyGram'){$ch6='checked';}
                            if($data[paymenttype]==''){$ch7='checked';}	

                            $html.='<div class="col-sm-12">
                                <div class="form-group">
                                    <label>Payment Terms<br /></label>
                                    <div class="col4">
                                        <label class="input_check">	
                                            <input name="paymenttype" id="pt1" value="L/C" type="radio" '.$ch1.'>
                                            <span>L/C</span>
                                        </label>
                                        <label class="input_check">	
                                            <input name="paymenttype" id="pt2" value="D/A" type="radio" '.$ch2.'>
                                            <span>D/A </span>
                                        </label>
                                        <label class="input_check">	
                                            <input name="paymenttype" id="pt3" value="D/P" type="radio" '.$ch3.'>
                                            <span>D/P</span>
                                        </label>
                                        <label class="input_check">	
                                            <input name="paymenttype" id="pt4" value="T/T" type="radio" '.$ch4.'>
                                            <span>T/T</span>
                                        </label>
                                        <label class="input_check">	
                                            <input name="paymenttype" id="pt5" value="Western Union" type="radio" '.$ch5.'>
                                            <span>Western Union</span>
                                        </label>
                                        <label class="input_check">	
                                            <input name="paymenttype" id="pt6" value="MoneyGram" type="radio" '.$ch6.'>
                                            <span>MoneyGram</span>
                                        </label>
                                        <label class="input_check">	
                                            <input name="paymenttype" id="pt7" value="Others" type="radio" '.$ch7.'>
                                            <span> Others</span>
                                        </label>
                                    </div>
                                </div>
                            </div>';				
                            $html.='';

                            $ch1='';
                            $ch2='';
                            $ch3='';
                            $ch4='';
                            $ch5='';
                            $ch6='';
                            $ch7='';
                            $ch8='';
                            $ch9='';
                            $ch10='';
                            $ch11='';
                            $ch12='';
                            $ch13='';
                            $ch14='';
                            $ch15='';
                            $ch16='';
                            $ch17='';
                            $ch18='';
                            $ch19='';				
                            if($data[p_ctype]==''){$ch1='selected="selected"';}
                            if($data[p_ctype]=='Bag/Bags'){$ch2='selected="selected"';}
                            if($data[p_ctype]=='Barrel/Barrels'){$ch3='selected="selected"';}
                            if($data[p_ctype]=='Cubic Meter'){$ch4='selected="selected"';}
                            if($data[p_ctype]=='Dozen'){$ch5='selected="selected"';}	
                            if($data[p_ctype]=='Gallon'){$ch6='selected="selected"';}
                            if($data[p_ctype]=='Gram'){$ch7='selected="selected"';}	
                            if($data[p_ctype]=='Kilogram'){$ch8='selected="selected"';}	
                            if($data[p_ctype]=='Kilometer'){$ch9='selected="selected"';}	
                            if($data[p_ctype]=='Long Ton'){$ch10='selected="selected"';}	
                            if($data[p_ctype]=='Meter'){$ch11='selected="selected"';}	
                            if($data[p_ctype]=='Mertic Ton'){$ch12='selected="selected"';}
                            if($data[p_ctype]=='Ounce'){$ch13='selected="selected"';}
                            if($data[p_ctype]=='Pair'){$ch14='selected="selected"';}
                            if($data[p_ctype]=='pack/packs'){$ch15='selected="selected"';}
                            if($data[p_ctype]=='Piece/Pieces'){$ch16='selected="selected"';}
                            if($data[p_ctype]=='Pound'){$ch17='selected="selected"';}
                            if($data[p_ctype]=='Set/Sets'){$ch18='selected="selected"';}
                            if($data[p_ctype]=='Short Ton'){$ch19='selected="selected"';}
        
                            $html.='<div class="col-sm-6">
                                <div class="form-group">
                                    <label>Production Capacity </label><br />
                                    <input name="p_capaacity" id="p_capaacity" type="text" class="form-control qtyinput" value="'.$data[p_capaacity].'"  style="width:70px; margin-right: 5px; display:inline-block;"/>
                                    <select name="p_ctype" id="p_ctype" class="form-control" style="width:95px;  margin-right:5px; display:inline-block;">
                                        <option value="" '.$ch1.'>Unit</option>
                                        <option value="Bag/Bags" '.$ch2.'>Bag/Bags </option>
                                        <option value="Barrel/Barrels" '.$ch3.'>Barrel/Barrels </option>
                                        <option value="Cubic Meter" '.$ch4.'>Cubic Meter </option>
                                        <option value="Dozen" '.$ch5.'>Dozen </option>
                                        <option value="Gallon" '.$ch6.'>Gallon</option>
                                        <option value="Gram" '.$ch7.'>Gram </option>
                                        <option value="Kilogram" '.$ch8.'>Kilogram </option>
                                        <option value="Kilometer" '.$ch9.'>Kilometer </option>
                                        <option value="Long Ton" '.$ch10.'>Long Ton </option>
                                        <option value="Meter" '.$ch11.'>Meter </option>
                                        <option value="Mertic Ton" '.$ch12.'>Metric Ton </option>
                                        <option value="Ounce" '.$ch13.'>Ounce </option>
                                        <option value="Pair" '.$ch14.'>Pair</option>
                                        <option value="pack/packs" '.$ch15.'>Pack/Packs </option>
                                        <option value="Piece/Pieces" '.$ch16.'>Piece/Pieces </option>
                                        <option value="Pound" '.$ch17.'>Pound</option>
                                        <option value="Set/Sets" '.$ch18.'>Set/Sets </option>
                                        <option value="Short Ton" '.$ch19.'>Short Ton</option>
                                    </select> ';

                                    $ch1='';
                                    $ch2='';
                                    $ch3='';
                                    $ch4='';
                                    $ch5='';
                                    $ch6='';
                                    $ch7='';
                                    $ch8='';
                                    $ch9='';
                                    $ch10='';
                                    $ch11='';
                                    $ch12='';
                                    $ch13='';
                                    $ch14='';
                                    $ch15='';
                                    $ch16='';
                                    $ch17='';
                                    $ch18='';
                                    $ch19='';				
                                    if($data[percapacity]==''){$ch1='selected="selected"';}
                                    if($data[percapacity]=='Day'){$ch2='selected="selected"';}
                                    if($data[percapacity]=='Week'){$ch3='selected="selected"';}
                                    if($data[percapacity]=='Month'){$ch4='selected="selected"';}
                                    if($data[percapacity]=='Year'){$ch5='selected="selected"';}	

                                    $html.='<select name="percapacity" id="percapacity" class="form-control" style="width:95px; display:inline-block;">
                                        <option value="" '.$ch1.'>Time</option>
                                        <option value="Day" '.$ch2.'>Day</option>
                                        <option value="Week" '.$ch3.'>Week</option>
                                        <option value="Month" '.$ch4.'>Month</option>
                                        <option value="Year" '.$ch5.'>Year</option>
                                    </select>
                                </div>';
                                $pdt=explode(' ',$data[p_delivertytime]);
                                $html.='<div class="form-group">
                                    <label>Delivery Time </label><br />
                                    <input name="p_delivertytime0" id="p_delivertytime0" type="text" class="form-control" value="'.$pdt[0].'"  style="width:70px; margin-right: 5px; display:inline-block;"/>';

                                    $ch1='';
                                    $ch2='';
                                    $ch3='';
                                    $ch4='';
                                    $ch5='';
                                    $ch6='';
                                    $ch7='';
                                    $ch8='';
                                    $ch9='';
                                    $ch10='';
                                    $ch11='';
                                    $ch12='';
                                    $ch13='';
                                    $ch14='';
                                    $ch15='';
                                    $ch16='';
                                    $ch17='';
                                    $ch18='';
                                    $ch19='';				
                                    if($pdt[1]==''){$ch1='selected="selected"';}
                                    if($pdt[1]=='Day'){$ch2='selected="selected"';}
                                    if($pdt[1]=='Week'){$ch3='selected="selected"';}
                                    if($pdt[1]=='Month'){$ch4='selected="selected"';}
                                    if($pdt[1]=='Year'){$ch5='selected="selected"';}
        
                                    $html.='<select name="p_delivertytime1" id="p_delivertytime1" class="form-control" style="width:95px; display:inline-block;">
                                        <option value="" '.$ch1.'>Time</option>
                                        <option value="Day" '.$ch2.'>Day</option>
                                        <option value="Week" '.$ch3.'>Week</option>
                                        <option value="Month" '.$ch4.'>Month</option>
                                        <option value="Year" '.$ch5.'>Year</option>
                                    </select>
                                </div>';
                            $html.='</div>';

                            
                            
                            $html.='<input type="hidden" name="image" id="companylogo" value="'.$data[p_photo].'">';
                            $html.='<div class="col-sm-12">
                                <div class="form-group">
                                    <label>Packaging Details</label>
                                    <textarea name="p_packingdetails" id="p_packingdetails" type="text" class="form-control">'.$data[p_packingdetails].'</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Brief Description</label>
                                    <textarea name="p_bdes" id="p_bdes" type="text" class="form-control">'.$data[p_bdes].'</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Detailed Description</label>
                                    <textarea name="p_ddes" id="p_ddes" type="text" class="form-control" style="height:140px;">'.$data[p_ddes].'</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input name="id" id="id_product" type="hidden" value="'.$id.'" />
                                    <input name="userid" id="userid" type="hidden" value="'.$data[userid].'" />
                                    <button type="submit" class="btn btn-primary btn-lg proData">Save</button> 

                                    <input type="hidden" name="ajax" value="1">
                                    <input type="hidden" name="proType" value="'.$proType.'">
                                    <input type="hidden" name="SourceForm" value="editProduct">
                                </div>
                            </div>';	
                            //$html.='<button type="button" class="btn btn-primary btn-lg proPreview">Preview</button>';
                        $html.='</div>
                        <div class="errMsg"></div>
                    </form>
                </div>
            </div>
        </div>';			 						
        echo $html;	
    }
    
    function addproduct($id_user,$id) 
    {  
        if($id){
           $ExtraQryStr   = " id=".$id;
            $dataP         = $this->connect->selectSingle(TBL_PRODUCT, "*", $ExtraQryStr); 
        }
        
        //permalink--------------
        $ENTITY = TBL_PRODUCT;
        $permalink = $_REQUEST['p_name'];
        if($id)	
            $ExtraQryStr = 'id!='.$id;	
        else
            $ExtraQryStr = 1;

        $permalink = createPermalink($ENTITY, $permalink, $ExtraQryStr);
        //permalink---------------    
        
        $params1 = array();
        
        $params1['userid']              = $_REQUEST['userid'];
        $params1['p_name']              = $_REQUEST['p_name'];
        $params1['permalink']           = $permalink;
        $params1['p_keyword']           = $_REQUEST['p_keyword'];
        $params1['p_category']          = $_REQUEST['p_category'];
        $params1['country']             = $_REQUEST['country'];
        $params1['p_bdes']              = $_REQUEST['p_bdes'];
        $params1['p_ddes']              = $_REQUEST['p_ddes'];
        $params1['p_price']             = $_REQUEST['p_price'];
        $params1['range1']              = $_REQUEST['range1'];
        $params1['range2']              = $_REQUEST['range2'];
        $params1['paymenttype']         = $_REQUEST['paymenttype'];
        $params1['p_min_quanity']       = $_REQUEST['p_min_quanity'];
        $params1['p_capaacity']         = $_REQUEST['p_capaacity'];
        $params1['p_ctype']             = $_REQUEST['p_ctype'];
        $params1['percapacity']         = $_REQUEST['percapacity'];
        $params1['p_delivertytime']     = $_REQUEST['p_delivertytime0'].' '.$_REQUEST['p_delivertytime1'];
        $params1['p_packingdetails']    = $_REQUEST['p_packingdetails'];
        $params1['proType']             = $_REQUEST['proType'];
        $params1['specification1']     = $_REQUEST['specification1'];
        $params1['specification2']       = $_REQUEST['specification2'];
        $params1['pay_structure']        = $_REQUEST['pay_structure'];

        $params1['entryDate']           = date('Y-m-d H:i:s');
        
        if(!$id){
            $params1['status']              = 0;
            $instid = $this->connect->insertQuery(TBL_PRODUCT, $params1);
            
            $error = 0;
            $msg_text = 'Product added succesfully';
            $result_arr = array();
            $result_arr['msg']		= $msg_text;
            $result_arr['error']	= $error;
            echo json_encode($result_arr);   
        }
        else{
            $CLAUSE = "id = '".$id."'";
            $result = $this->connect->updateQuery(TBL_PRODUCT, $params1, $CLAUSE);
            
            $instid =   $id;
            
            $error = 0;
            $msg_text = 'Product updated succesfully';
            $result_arr = array();
            $result_arr['msg']		= $msg_text;
            $result_arr['error']	= $error;
            echo json_encode($result_arr);  
        }
        
        if($instid){
            $attributeIdArray= $_REQUEST['attributeIdArray'];
                        
            if(sizeof($attributeIdArray)>0)
            { 
                $this->deleteAttributeByproductId($instid);
                
                for($i=0;$i<sizeof($attributeIdArray);$i++)
                {
                    $attributeValueArray = $_REQUEST['attributeValueArray_'.$i];

                    for($j=0;$j<sizeof($attributeValueArray);$j++)
                    {
                        if($attributeValueArray[$j])
                        {
                            $params = array();
                            $params['attributeId']      = $attributeIdArray[$i];
                            $params['productId']        = $instid;
                            $params['attributeValue']   = $attributeValueArray[$j];
                            $this->newAttribute($params);
                        }
                    }
                }
            }
            
            $fObj           = new FileUpload;
            
            $targetLocation1 = UPFLD."/product"; 

            $TWH[0]         = 309;      // thumb width
            $TWH[1]         = 205;      // thumb height
            $LWH[0]         = 640;      // large width
            $LWH[1]         = 424;      // large height
            $option         = 'all';    // upload, thumbnail, resize, all 
              
            if($_FILES['img']['size']<=2097152) // max 2MB
            {
                $fileName = time();
                if($target_image = $fObj->uploadImage($_FILES['img'], $targetLocation1, $fileName, $TWH, $LWH, $option)){	
                    
                    if($dataP['p_photo'])
                    {
                        @unlink($targetLocation.'/normal/'.$dataP['p_photo']);
                        @unlink($targetLocation.'/thumb/'.$dataP['p_photo']);	
                        @unlink($targetLocation.'/large/'.$dataP['p_photo']);
                    }
                    $params = array();
                    $params['p_photo'] = $target_image;
                    $CLAUSE = "id = '".$instid."'";
                    $result = $this->connect->updateQuery(TBL_PRODUCT, $params, $CLAUSE);
                }
            }
            else{
                $error = 1;
                $msg_text = 'Product main image is too large to be uploaded! Your file size should be 2MB max.';
            }
            
            if($_FILES['img1']['size']<=2097152) // max 2MB
            {
                if($_FILES['img1']['name'] && substr($_FILES['img1']['type'],0,5)=='image')
                {                    
                    $fileName1 = time().'1';
                    if($target_image1 = $fObj->uploadImage($_FILES['img1'], $targetLocation1, $fileName1, $TWH, $LWH, $option)){	
                        
                        if($dataP['photo1'])
                        {
                            @unlink($targetLocation.'/normal/'.$dataP['photo1']);
                            @unlink($targetLocation.'/thumb/'.$dataP['photo1']);	
                            @unlink($targetLocation.'/large/'.$dataP['photo1']);
                        }                        

                        $params = array();
                        $params['photo1'] = $target_image1;
                        $CLAUSE = "id = '".$instid."'";
                        $result = $this->connect->updateQuery(TBL_PRODUCT, $params, $CLAUSE);
                    }
                }
            }
            else{
                $error = 1;
                $msg_text = 'Product image 1 is too large to be uploaded! Your file size should be 2MB max.';
            }
            
            if($_FILES['img2']['size']<=2097152) // max 2MB
            {
                if($_FILES['img2']['name'] && substr($_FILES['img2']['type'],0,5)=='image')
                {
                    $fileName2 = time().'2';
                    if($target_image2 = $fObj->uploadImage($_FILES['img2'], $targetLocation1, $fileName2, $TWH, $LWH, $option)){	
                        
                        if($dataP['photo2'])
                        {
                            @unlink($targetLocation.'/normal/'.$dataP['photo2']);
                            @unlink($targetLocation.'/thumb/'.$dataP['photo2']);	
                            @unlink($targetLocation.'/large/'.$dataP['photo2']);
                        }                        

                        $params = array();
                        $params['photo2'] = $target_image2;
                        $CLAUSE = "id = '".$instid."'";
                        $result = $this->connect->updateQuery(TBL_PRODUCT, $params, $CLAUSE);
                    }
                }
            }
            else{
                $error = 1;
                $msg_text = 'Product image 2 is too large to be uploaded! Your file size should be 2MB max.';
            }
            
            if($_FILES['img3']['size']<=2097152) // max 2MB
            {
                if($_FILES['img3']['name'] && substr($_FILES['img3']['type'],0,5)=='image')
                {
                    $fileName3 = time().'3';
                    if($target_image3 = $fObj->uploadImage($_FILES['img3'], $targetLocation1, $fileName3, $TWH, $LWH, $option)){	

                        if($dataP['photo3'])
                        {
                            @unlink($targetLocation.'/normal/'.$dataP['photo3']);
                            @unlink($targetLocation.'/thumb/'.$dataP['photo3']);	
                            @unlink($targetLocation.'/large/'.$dataP['photo3']);
                        }
                        
                        
                        $params = array();
                        $params['photo3'] = $target_image3;
                        $CLAUSE = "id = '".$instid."'";
                        $result = $this->connect->updateQuery(TBL_PRODUCT, $params, $CLAUSE);
                    }
                }
            }
            else{
                $error = 1;
                $msg_text = 'Product image 3 is too large to be uploaded! Your file size should be 2MB max.';
            }
            
            if($_FILES['img4']['size']<=2097152) // max 2MB
            {
                if($_FILES['img4']['name'] && substr($_FILES['img4']['type'],0,5)=='image')
                {
                    $fileName4 = time().'4';
                    if($target_image4 = $fObj->uploadImage($_FILES['img4'], $targetLocation1, $fileName4, $TWH, $LWH, $option)){	
                        
                        if($dataP['photo4'])
                        {
                            @unlink($targetLocation.'/normal/'.$dataP['photo4']);
                            @unlink($targetLocation.'/thumb/'.$dataP['photo4']);	
                            @unlink($targetLocation.'/large/'.$dataP['photo4']);
                        }

                        $params = array();
                        $params['photo4'] = $target_image4;
                        $CLAUSE = "id = '".$instid."'";
                        $result = $this->connect->updateQuery(TBL_PRODUCT, $params, $CLAUSE);
                    }
                }
            }
            else{
                $error = 1;
                $msg_text = 'Product image 4 is too large to be uploaded! Your file size should be 2MB max.';
            }
            
            if($_FILES['img5']['size']<=2097152) // max 2MB
            {
                if($_FILES['img5']['name'] && substr($_FILES['img5']['type'],0,5)=='image')
                {
                    $fileName5 = time().'5';
                    if($target_image5 = $fObj->uploadImage($_FILES['img5'], $targetLocation1, $fileName5, $TWH, $LWH, $option)){
                        
                        if($dataP['photo5'])
                        {
                            @unlink($targetLocation.'/normal/'.$dataP['photo5']);
                            @unlink($targetLocation.'/thumb/'.$dataP['photo5']);	
                            @unlink($targetLocation.'/large/'.$dataP['photo5']);
                        }
                        $params = array();
                        $params['photo5'] = $target_image5;
                        $CLAUSE = "id = '".$instid."'";
                        $result = $this->connect->updateQuery(TBL_PRODUCT, $params, $CLAUSE);
                    }
                }
            }
            else{
                $error = 1;
                $msg_text = 'Product image 5 is too large to be uploaded! Your file size should be 2MB max.';
            }
            
        }
        
       /* $error = 0;
        $msg_text = 'Product added succesfully';
        $result_arr = array();
        $result_arr['msg']		= $msg_text;
        $result_arr['error']	= $error;
        echo json_encode($result_arr);  */ 
    }
    
    /*function editproduct($id)
    {
        $ExtraQryStr   = " id=".$id;
        $dataP         = $this->connect->selectSingle(TBL_PRODUCT, "*", $ExtraQryStr); 
        
        $fObj = new FileUpload;
        $targetLocation = UPFLD."/product";

        $TWH[0]         = 309;      // thumb width
        $TWH[1]         = 205;      // thumb height
        $LWH[0]         = 640;      // large width
        $LWH[1]         = 424;      // large height
        $option         = 'all';    // upload, thumbnail, resize, all       
        
        if($_FILES['img']['size']<=2097152) // max 2MB
        {      
            if($_FILES['img']['name'] && substr($_FILES['img']['type'],0,5)=='image')
            {
                $fileName = time();
                if($target_image = $fObj->uploadImage($_FILES['img'], $targetLocation, $fileName, $TWH, $LWH, $option)){	
               
                    if($dataP['p_photo'])
                    {
                        @unlink($targetLocation.'/normal/'.$dataP['p_photo']);
                        @unlink($targetLocation.'/thumb/'.$dataP['p_photo']);	
                        @unlink($targetLocation.'/large/'.$dataP['p_photo']);
                    }
                }
            }
        }
        else{
            $error = 1;
            $msg_text = 'Product main image is too large to be uploaded! Your file size should be 2MB max.';
        }
        
        if($_FILES['img1']['size']<=2097152) // max 2MB
        {      
            if($_FILES['img1']['name'] && substr($_FILES['img1']['type'],0,5)=='image')
            {
                $fileName1 = time().'1';
                if($target_image1 = $fObj->uploadImage($_FILES['img1'], $targetLocation, $fileName1, $TWH, $LWH, $option)){	               
                    if($dataP['photo1'])
                    {
                        @unlink($targetLocation.'/normal/'.$dataP['photo1']);
                        @unlink($targetLocation.'/thumb/'.$dataP['photo1']);	
                        @unlink($targetLocation.'/large/'.$dataP['photo1']);
                    }
                }
            }
        }
        else{
            $error = 1;
            $msg_text = 'Product image 1 is too large to be uploaded! Your file size should be 2MB max.';
        }
        
        if($_FILES['img2']['size']<=2097152) // max 2MB
        {      
            if($_FILES['img2']['name'] && substr($_FILES['img2']['type'],0,5)=='image')
            {
                $fileName2 = time().'2';
                if($target_image2 = $fObj->uploadImage($_FILES['img2'], $targetLocation, $fileName2, $TWH, $LWH, $option)){	               
                    if($dataP['photo2'])
                    {
                        @unlink($targetLocation.'/normal/'.$dataP['photo2']);
                        @unlink($targetLocation.'/thumb/'.$dataP['photo2']);	
                        @unlink($targetLocation.'/large/'.$dataP['photo2']);
                    }
                }
            }
        }
        else{
            $error = 1;
            $msg_text = 'Product image 2 is too large to be uploaded! Your file size should be 2MB max.';
        }
        
        if($_FILES['img3']['size']<=2097152) // max 2MB
        {      
            if($_FILES['img3']['name'] && substr($_FILES['img3']['type'],0,5)=='image')
            {
                $fileName3= time().'3';
                if($target_image3 = $fObj->uploadImage($_FILES['img3'], $targetLocation, $fileName3, $TWH, $LWH, $option)){	               
                    if($dataP['photo3'])
                    {
                        @unlink($targetLocation.'/normal/'.$dataP['photo3']);
                        @unlink($targetLocation.'/thumb/'.$dataP['photo3']);	
                        @unlink($targetLocation.'/large/'.$dataP['photo3']);
                    }
                }
            }
        }
        else{
            $error = 1;
            $msg_text = 'Product image 3 is too large to be uploaded! Your file size should be 2MB max.';
        }
        
        if($_FILES['img4']['size']<=2097152) // max 2MB
        {      
            if($_FILES['img4']['name'] && substr($_FILES['img4']['type'],0,5)=='image')
            {
                $fileName4= time().'4';
                if($target_image4 = $fObj->uploadImage($_FILES['img4'], $targetLocation, $fileName4, $TWH, $LWH, $option)){	               
                    if($dataP['photo4'])
                    {
                        @unlink($targetLocation.'/normal/'.$dataP['photo4']);
                        @unlink($targetLocation.'/thumb/'.$dataP['photo4']);	
                        @unlink($targetLocation.'/large/'.$dataP['photo4']);
                    }
                }
            }
        }
        else{
            $error = 1;
            $msg_text = 'Product image 4 is too large to be uploaded! Your file size should be 2MB max.';
        }
        
        if($_FILES['img5']['size']<=2097152) // max 2MB
        {      
            if($_FILES['img5']['name'] && substr($_FILES['img5']['type'],0,5)=='image')
            {
                $fileName5= time().'5';
                if($target_image5 = $fObj->uploadImage($_FILES['img5'], $targetLocation, $fileName5, $TWH, $LWH, $option)){	               
                    if($dataP['photo5'])
                    {
                        @unlink($targetLocation.'/normal/'.$dataP['photo5']);
                        @unlink($targetLocation.'/thumb/'.$dataP['photo5']);	
                        @unlink($targetLocation.'/large/'.$dataP['photo5']);
                    }
                }
            }
        }
        else{
            $error = 1;
            $msg_text = 'Product image 5 is too large to be uploaded! Your file size should be 2MB max.';
        }
        
        $params1 = array();
        foreach ($_REQUEST as $name => $value) 
        {
            if($name!='func' and $name!='id' and $name!='p_delivertytime1' and $name!='ajax' and $name!='SourceForm')
            {
                if($name=='p_name')
                {
                    $value=$_REQUEST['p_name'];
                    $name='p_name';
                    
                    //permalink--------------
                    $ENTITY = TBL_PRODUCT;
                    $permalink = $value;
                    if($id)	
                        $ExtraQryStr = 'id!='.$id;	
                    else
                        $ExtraQryStr = 1;
                    
                    $permalink = createPermalink($ENTITY, $permalink, $ExtraQryStr);
                    //permalink---------------    
                    
                }
                if($name=='permalink'){                    
                    $value=$permalink;
                    $name='permalink';
                }
                if($name=='p_delivertytime0')
                {
                    $value=$_REQUEST[p_delivertytime0].' '.$_REQUEST[p_delivertytime1];
                    $name='p_delivertytime';
                }
                if($name=='image')
                {
                    $name='p_photo';
                    if($target_image!='')
                        $value=$target_image;
                    else
                        $value=$_REQUEST['image'];
                }	
                if($name=='image1')
                {
                    $name='photo1';
                    if($target_image1!='')
                        $value=$target_image1;
                    else
                        $value=$_REQUEST['image1'];
                }
                if($name=='image2')
                {
                    $name='photo2';
                    if($target_image2!='')
                        $value=$target_image2;
                    else
                        $value=$_REQUEST['image2'];
                }	
                if($name=='image3')
                {
                    $name='photo3';
                    if($target_image3!='')
                        $value=$target_image3;
                    else
                        $value=$_REQUEST['image3'];
                }
                if($name=='image4')
                {
                    $name='photo4';
                    if($target_image4!='')
                        $value=$target_image4;
                    else
                        $value=$_REQUEST['image4'];
                }		
                if($name=='image5')
                {
                    $name='photo5';
                    if($target_image5!='')
                        $value=$target_image5;
                    else
                        $value=$_REQUEST['image5'];
                }																
                $params1[$name] = $value;
            }
        }
        
        $CLAUSE = "id = '".$id."'";
        $result = $this->connect->updateQuery(TBL_PRODUCT, $params1, $CLAUSE);

        $error = 0;
        $msg_text = 'Product updated succesfully';
        $result_arr = array();
        $result_arr['msg']		= $msg_text;
        $result_arr['error']	= $error;
        echo json_encode($result_arr);  
    }*/
    
    function deleteReqId($id){  
        return $this->connect->executeQuery("delete from ".TBL_CONTACT." where contactID = ".$id);
    }
    
    function deleteProductByproductId($id){  
        
        $ExtraQryStr    = " id=".addslashes($id);
        $data          = $this->connect->selectSingle(TBL_PRODUCT, "*", $ExtraQryStr);
        if($data){
            $delPath = UPFLD."/product";
            @unlink($delPath.'/normal/'.$data['p_photo']);
            @unlink($delPath.'/large/'.$data['p_photo']);
            @unlink($delPath.'/thumb/'.$data['p_photo']);
            @unlink($delPath.'/normal/'.$data['photo1']);
            @unlink($delPath.'/large/'.$data['photo1']);
            @unlink($delPath.'/thumb/'.$data['photo1']);
            @unlink($delPath.'/normal/'.$data['photo2']);
            @unlink($delPath.'/large/'.$data['photo2']);
            @unlink($delPath.'/thumb/'.$data['photo2']);
            @unlink($delPath.'/normal/'.$data['photo3']);
            @unlink($delPath.'/large/'.$data['photo3']);
            @unlink($delPath.'/thumb/'.$data['photo3']);
            @unlink($delPath.'/normal/'.$data['photo4']);
            @unlink($delPath.'/large/'.$data['photo4']);
            @unlink($delPath.'/thumb/'.$data['photo4']);
            @unlink($delPath.'/normal/'.$data['photo5']);
            @unlink($delPath.'/large/'.$data['photo5']);
            @unlink($delPath.'/thumb/'.$data['photo5']);	
        }
        
        $this->connect->executeQuery("delete from ".TBL_PRODUCT." where id = ".$id);
        
        $html = '<div class="successmsg">Product deleted successfully.</div><div class="clearfix"></div>';
        return $html;
    }  
    /*------start_of----*/
    function showproductaddTypecategory($id_user,$cmpid){
       $html.='
        <div class="col-sm-6">
                      <div class="form-group">
                      <label class="radioLabel">  
                            <input name="p_category" class="prType" data-uid="'.$id_user.'" data-cmpid="'.$cmpid.'" value="P" type="radio">
                            <span>Product</span>
                        </label>
                        <label class="radioLabel">  
                            <input name="p_category" class="prType" data-uid="'.$id_user.'" data-cmpid="'.$cmpid.'" value="S" type="radio">
                            <span>Service</span>
                        </label>
                      </div>
                      </div>
        ';
        
        return $html;  

    }
    

    function showproductaddcategory($id_user, $cmpid, $prType)
    { 
        if($prType=='S'){
            $pid = 2;
            $ty  = 'Service';
        }
        else{
            $pid = 1;
            $ty  = 'Product';
        }
        

            $html.='
            
            <div class="h-box-100 relative" style="min-height: 0px  !important;">
               <div class="clear"></div>
                <div class="h-table">            
                    <div class="">
                        <form id="productdata" class="forma" onsubmit="return false;" enctype="multipart/form-data">
                            <div class="row">';
                                $html.='<div class="col-sm-6">
                                    <div class="form-group">
                                        <label>*'.$ty.' Category</label>
                                        <select name="p_category" id="p_category" class="form-control">';                                                   
                                        $ExtraQryStr    = " status='Y' AND mainCategory=".$pid." AND parent_id=".$pid." order by category ASC";
                                        $data           = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr,0,9999);

                                            $html.='<option class="prCategory" value=""  data-parent="0">Select</option>';
                                            foreach($data as $dataC)
                                            {
                                                $html.='<option class="prCategory" value="'.$dataC[c_id].'" '.$sel.'  data-parent="'.$dataC[c_id].'">'.$dataC[category].'</option>';

                                                $pId        = $dataC['c_id'];

                                                $ExtraQryCh     = " status='Y' AND parent_id=".$dataC['c_id']." order by category ASC";
                                                $dataCh         = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryCh,0,9999);
                                                if($dataCh){
                                                    foreach($dataCh as $child){
                                                        $html.='<option class="cCategory" value="'.$child[c_id].'">&nbsp;&nbsp;&nbsp;&nbsp;'.$child[category].'</option>';
                                                    }
                                                }
                                            }
                                        $html.='</select>
                                    </div>
                                    <div class="categoryDetails"></div>
                                    
                                </div>
                                
                               
                                                              
                            </div>';
                            $html.='<div class="errMsg"></div>
                        </form>
                    </div>
                </div>
            </div>';            
            /*<button type="button" class="btn btn-primary btn-lg" onclick="preview()">Preview</button>                 */
    echo $html;                                         
    }
    /*----end_of---------*/
    function showproductaddType($id_user,$cmpid){

        $ExtraQryStr = "userid=".$id_user;
        $productData = $this->connect->selectMulti(TBL_PRODUCT,"*",$ExtraQryStr,"0","30");
        $numr = sizeof($productData);
        if($numr < 20 )
        {

         $ExtraQryStr = " user_id=".addslashes($id_user);
        $comData = $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr); 
        $proType = $comData['p_service'];

            if($proType=='S'){
            $pid = 2;
            $ty  = 'Service';
        }
        else{
            $pid = 1;
            $ty  = 'Product';
        }
       $html.='
            
            <div class="h-box-100 relative">
                <div class="h-heading">Add '.$ty.'</div>
                <div class="clear"></div>
                <div class="h-table"><span class="formClose">X</span>            
                    <div class="">
                        <form id="productdata" class="forma" onsubmit="return false;" enctype="multipart/form-data">
                            <div class="row">';
                                $html.='<div class="col-sm-6">
                                    <div class="form-group">
                                        <label>*'.$ty.' Name</label>
                                        <input name="p_name" id="p_name" type="text" class="form-control" required value="'.htmlspecialchars($data[p_name]).'"/>
                                        <input name="permalink" id="permalink" type="hidden" class="form-control" value="'.$data[permalink].'"/>
                                    </div>';

                                     $html.='
                                      <div class="form-group">
                                        <label>*'.$ty.' Category</label>
                                        <select name="p_category" id="p_category" class="form-control">';                                                   
                                        $ExtraQryStr    = " status='Y' AND mainCategory=".$pid." AND parent_id=".$pid." order by category ASC";
                                        $data           = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr,0,9999);

                                            $html.='<option class="prCategory" value=""  data-parent="0">Select</option>';
                                            foreach($data as $dataC)
                                            {
                                                $html.='<option class="prCategory" value="'.$dataC[c_id].'" '.$sel.'  data-parent="'.$dataC[c_id].'">'.$dataC[category].'</option>';

                                                $pId        = $dataC['c_id'];

                                                $ExtraQryCh     = " status='Y' AND parent_id=".$dataC['c_id']." order by category ASC";
                                                $dataCh         = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryCh,0,9999);
                                                if($dataCh){
                                                    foreach($dataCh as $child){
                                                        $html.='<option class="cCategory" value="'.$child[c_id].'">&nbsp;&nbsp;&nbsp;&nbsp;'.$child[category].'</option>';
                                                    }
                                                }
                                            }
                                        $html.='</select>
                                        <div class="categoryDetails"></div>
                                        
                                    </div>';
                                     $html.='
                                        <div class="form-group">
                                        <label>*'.$ty.' Keyword</label>
                                            <div class="tagpanel"><input name="p_keyword" id="tags_1" type="text" class="form-control tags" required value="'.$data[p_keyword].'"/></div>
                                            
                                            </div>

                               ';
                                    if($ty == 'Service'){
                                   $html.='<div class="form-group">
                                        <label>'.$ty.' Pay Structure</label><br />
                                        <select name="pay_structure" id="pay_structure" class="form-control" style="width:100px; margin-right:5px; display:inline-block;">
                                            <option value="">Select</option>
                                            <option value="Hourly"> Hourly </option>
                                            <option value="Fixed"> Fixed </option>
                                            <option value="Hourly + Fixed"> Hourly + Fixed </option>
                                            <option value="Ask For Price">Ask For Price </option>
                                        </select>
                                        </div>';
                                }

                                    $html.='<div class="form-group">
                                        <label>*Price</label><br />
                                        <select name="p_price" id="p_price" class="form-control" style="width:100px; margin-right:5px; display:inline-block;">
                                            <option value="">Currency</option>
                                            <option value="USD"> USD </option>
                                            <option value="GBP"> GBP </option>
                                            <option value="RMB"> RMB </option>
                                            <option value="EUR"> EUR </option>
                                            <option value="AUD"> AUD </option>
                                            <option value="CAD"> CAD </option>
                                            <option value="CHF"> CHF </option>
                                            <option value="JPY"> JPY </option>
                                            <option value="HKD"> HKD </option>
                                            <option value="NZD"> NZD </option>
                                            <option value="SGD"> SGD </option>
                                            <option value="Other">Other </option>
                                        </select>
                                        <input name="range1" id="range1" type="text" class="form-control" value="'.$data[range1].'"  style="width:100px; display:inline-block;"/> - 
                                        <input name="range2" id="range2" type="text" class="form-control" value="'.$data[range2].'"  style="width:100px; display:inline-block;"/>
                                    </div>';
                                    
                                    if($ty == 'Product'){

                                     $html.='<div class="form-group" style="width:100%; margin-right:10px; float:left;">
                                        <label>*Minimum '.$ty.' Quantity</label>
                                        <input name="p_min_quanity" id="p_min_quanity" type="text" class="form-control qtyinput" required value="'.$data[p_min_quanity].'"/>
                                    </div>
                                     ';
                                }
                                
                                      
                                $html.='</div>
                                <div class="col-sm-6">';
                                    $html.='<input type="hidden" name="image" id="companylogo" value="'.$data[p_photo].'">';
                                    $html.='<div class="form-group">
                                        <fieldset class="full_form_group">
                                            <legend>Gallery Image</legend>
                                            <div class="multiImg">
                                                <div class="form-group">
                                                    <label>'.$ty.' main image</label>
                                                    <div id="content_here_please"></div>
                                                    <input type="file"  name="img" id="image1" class="fileUpload"/> 
                                                    
                                                     <img alt="your image" class="dvPreview" src="#" style="display:none;max-width: 100px; max-height: 100px;">
                                                   
                                                    <input type="hidden" name="image1" id="photo1" value="'.$data[photo1].'">
                                                </div>

                                            </div>
                                            <div class="multiImg">
                                                <div class="form-group">
                                                    <label>'.$ty.' image 1</label>
                                                    <div id="content_here_please1"></div>
                                                    <input type="file" name="img1" id="image11" class="fileUpload"/>
                                                    <img alt="your image" class="dvPreview" src="#" style="display:none;max-width: 100px; max-height: 100px;">
                                                    <input type="hidden" name="image2" id="photo2" value="'.$data[photo2].'">
                                                </div>
                                            </div>
                                            <div class="multiImg">
                                                <div class="form-group">
                                                    <label>'.$ty.' image 2</label>
                                                    <div id="content_here_please2"></div>
                                                    <input type="file" name="img2" id="image21" class="fileUpload"/>
                                                    <img alt="your image" class="dvPreview" src="#" style="display:none;max-width: 100px; max-height: 100px;">
                                                    
                                                    <input type="hidden" name="image3" id="photo3" value="'.$data[photo3].'">
                                                </div>
                                            </div>
                                            <div class="multiImg">
                                                <div class="form-group">
                                                    <label>'.$ty.' image 3</label>
                                                    <div id="content_here_please3"></div>
                                                    <input type="file" name="img3" id="image31" class="fileUpload"/>
                                                    <img alt="your image" class="dvPreview" src="#" style="display:none;max-width: 100px; max-height: 100px;">
                                                    
                                                    <input type="hidden" name="image4" id="photo4" value="'.$data[photo4].'">
                                                </div>
                                            </div>
                                            <div class="multiImg">
                                                <div class="form-group">
                                                    <label>'.$ty.' image 4</label>
                                                    <div id="content_here_please4"></div>
                                                    <input type="file" name="img4" id="image41" class="fileUpload"/>
                                                    <img alt="your image" class="dvPreview" src="#" style="display:none;max-width: 100px; max-height: 100px;">
                                                    
                                                    <input type="hidden" name="image5" id="photo5" value="'.$data[photo5].'">
                                                </div>
                                            </div>
                                            <div class="multiImg">
                                                <div class="form-group">
                                                    <label>'.$ty.' image 5</label>
                                                    <div id="content_here_please5"></div>
                                                    <input type="file" name="img5" id="image51" class="fileUpload" />
                                                    <img alt="your image" class="dvPreview" src="#" style="display:none;max-width: 100px; max-height: 100px;">
                                                    
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                   
                                </div>';
                                $html.='  <div class="col-sm-12">
                                    <div class="form-group" id="cpdes">
                                        
                                        <label>*Brief Description</label>';
                                        //$html.='<input name="company_details" id="company_details" type="text" class="form-control" value="'.$data[company_details].'"/>';

                                        $CKEditor = new CKEditor();            
                                        $CKEditor->returnOutput = true; 
                                        $CKEditor->basePath = '../../ckeditor/'; 
                                        $CKEditor->config['width'] = '100%'; 
                                        $CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);         
                                        CKFinder::SetupCKEditor($CKEditor, '../../ckfinder/');
                                        $code = $CKEditor->editor("p_bdes", $data['p_bdes']); 

                                         $html.=$code.'</div>
                                </div>';
                                $html.='<input name="country" type="hidden" value="95" />';

                                if($ty == 'Service'){

                                $html.='<div class="col-sm-12">
                                   
                                        </div>';
                                    }

                                    
                                   
                                
                                    $html.='<div class="col-sm-12">
                                            <div class="form-group" id="ckbdes">                                    
                                            <label>*Detailed Description</label>';
                                            //$html.='<input name="company_details" id="company_details" type="text" class="form-control" value="'.$data[company_details].'"/>';

                                            $CKEditor = new CKEditor();            
                                            $CKEditor->returnOutput = true; 
                                            $CKEditor->basePath = '../../ckeditor/'; 
                                            $CKEditor->config['width'] = '100%'; 
                                            $CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);         
                                            CKFinder::SetupCKEditor($CKEditor, '../../ckfinder/');
                                            $code = $CKEditor->editor("p_ddes", $data['p_ddes']); 

                                             $html.=$code.'</div>

                                    </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Payment Terms<br/></label>
                                        <div class="col4" id="pt">
                                            <label class="input_check">
                                                <input name="paymenttype" id="pt1" value="L/C" type="radio">
                                                <span>L/C</span>
                                            </label>
                                            <label class="input_check">
                                                <input name="paymenttype" id="pt2" value="D/A" type="radio">
                                                <span>D/A </span>
                                            </label>
                                            <label class="input_check">
                                                <input name="paymenttype" id="pt3" value="D/P" type="radio">
                                                <span>D/P</span>
                                            </label>
                                            <label class="input_check">
                                                <input name="paymenttype" id="pt4" value="T/T" type="radio">
                                                <span>T/T</span>
                                            </label>
                                            <label class="input_check">
                                                <input name="paymenttype" id="pt5" value="Western Union" type="radio">
                                                <span>Western Union</span>
                                            </label>
                                            <label class="input_check">
                                                <input name="paymenttype" id="pt6" value="MoneyGram" type="radio">
                                                <span>MoneyGram</span>
                                            </label>
                                            <label class="input_check">
                                                <input name="paymenttype" id="pt7" value="" type="radio">
                                                <span> Others</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Production Capacity </label><br />
                                        <input name="p_capaacity" id="p_capaacity" type="text" class="form-control" value="'.$data[p_capaacity].'"  style="width:70px; margin-right:5px; display:inline-block;"/>
                                        <select name="p_ctype" id="p_ctype" class="form-control" style="width:95px; margin-right:5px; display:inline-block;">
                                            <option value="">Unit</option>
                                            <option value="Bag/Bags">Bag/Bags </option>
                                            <option value="Barrel/Barrels">Barrel/Barrels </option>
                                            <option value="Cubic Meter">Cubic Meter </option>
                                            <option value="Dozen">Dozen </option>
                                            <option value="Gallon">Gallon</option>
                                            <option value="Gram">Gram </option>
                                            <option value="Kilogram">Kilogram </option>
                                            <option value="Kilometer">Kilometer </option>
                                            <option value="Long Ton">Long Ton </option>
                                            <option value="Meter">Meter </option>
                                            <option value="Mertic Ton">Metric Ton </option>
                                            <option value="Ounce">Ounce </option>
                                            <option value="Pair">Pair</option>
                                            <option value="pack/packs">Pack/Packs </option>
                                            <option value="Piece/Pieces">Piece/Pieces </option>
                                            <option value="Pound">Pound</option>
                                            <option value="Set/Sets">Set/Sets </option>
                                            <option value="Short Ton">Short Ton</option>
                                        </select>
                                        <select name="percapacity" id="percapacity" class="form-control" style="width:95px; display:inline-block;">
                                            <option value="">Time</option>
                                            <option value="Day">Day</option>
                                            <option value="Week">Week</option>
                                            <option value="Month">Month</option>
                                            <option value="Year">Year</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Delivery Time </label><br />
                                        <input name="p_delivertytime0" id="p_delivertytime0" type="text" class="form-control" value="'.$data[p_delivertytime].'"  style="width:70px; margin-right:5px; display:inline-block;"/>
                                        <select name="p_delivertytime1" id="p_delivertytime1" class="form-control" style="width:95px; display:inline-block;">
                                            <option value="">Time</option>
                                            <option value="Day">Day</option>
                                            <option value="Week">Week</option>
                                            <option value="Month">Month</option>
                                            <option value="Year">Year</option>
                                        </select>
                                    </div>
                                </div>';
                                if($ty == 'Product'){

                                 $html.='<div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Packaging Details</label>
                                        <textarea name="p_packingdetails" id="p_packingdetails" type="text" class="form-control">'.$data[p_packingdetails].'</textarea>
                                    </div>
                                </div>';
                              
                               }
                                 $html.='</div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg proData">Save</button> 
                                        <input name="userid" id="userid" type="hidden" value="'.$id_user.'" />
                                        <input type="hidden" name="ajax" value="1">
                                        <input type="hidden" name="proType" value="'.$proType.'">
                                        <input type="hidden" name="SourceForm" value="addProduct">
                                        <button type="button" class="btn btn-primary btn-lg previewProduct">Preview</button>   
                                    </div>
                                </div>
                            </div>';
                            $html.='<div class="errMsg"></div>
                        </form>
                        <div id="previewPro"><!--<div class="alert alert-warning" role="alert"></div>--></div>
                    </div>
                </div>
            </div>';            
            /*<button type="button" class="btn btn-primary btn-lg" onclick="preview()">Preview</button>                 */
             
    }
    else{
         $html.='
        <div class="h-box-100 minheight p0 relative">
            <div class="h-heading">Warning</div>
            <div class="clear"></div>
            <div class="h-table"><span class="formClose">X</span>           
            <div class="col-md-12">
                <form id="" class="forma">
                    <div class="form-group clearfix">
                        <table>
                        <tr><td align="center" colspan="6">Sorry! Your product Adding Limit is Over </td></tr>

                        </table>
                    </div>
                </form>
            </div>
        </div>
        ';
    }
        return $html;	
    }
    

    
    // function showproductadd($id_user, $cmpid, $proType)
    // { 
    //     if($proType=='S'){
    //         $pid = 2;
    //         $ty  = 'Service';
    //     }
    //     else{
    //         $pid = 1;
    //         $ty  = 'Product';
    //     }
        

    //         $html.='
            
    //         <div class="h-box-100 relative">
    //             <div class="h-heading">Add '.$ty.'</div>
    //             <div class="clear"></div>
    //             <div class="h-table"><span class="formClose">X</span>            
    //                 <div class="">
    //                     <form id="productdata" class="forma" onsubmit="return false;" enctype="multipart/form-data">
    //                         <div class="row">';
    //                             $html.='<div class="col-sm-6">
    //                                 <div class="form-group">
    //                                     <label>*'.$ty.' Name</label>
    //                                     <input name="p_name" id="p_name" type="text" class="form-control" required value="'.htmlspecialchars($data[p_name]).'"/>
    //                                     <input name="permalink" id="permalink" type="hidden" class="form-control" value="'.$data[permalink].'"/>
    //                                 </div>';
    //                                 if($ty == 'Service'){
    //                                $html.='<div class="form-group">
    //                                     <label>'.$ty.' Pay Structure</label><br />
    //                                     <select name="pay_structure" id="pay_structure" class="form-control" style="width:100px; margin-right:5px; display:inline-block;">
    //                                         <option value="">Select</option>
    //                                         <option value="Hourly"> Hourly </option>
    //                                         <option value="Fixed"> Fixed </option>
    //                                         <option value="Hourly + Fixed"> Hourly + Fixed </option>
    //                                         <option value="Ask For Price">Ask For Price </option>
    //                                     </select>
    //                                     </div>';
    //                             }

    //                                 $html.='<div class="form-group">
    //                                     <label>*Price</label><br />
    //                                     <select name="p_price" id="p_price" class="form-control" style="width:100px; margin-right:5px; display:inline-block;">
    //                                         <option value="">Currency</option>
    //                                         <option value="USD"> USD </option>
    //                                         <option value="GBP"> GBP </option>
    //                                         <option value="RMB"> RMB </option>
    //                                         <option value="EUR"> EUR </option>
    //                                         <option value="AUD"> AUD </option>
    //                                         <option value="CAD"> CAD </option>
    //                                         <option value="CHF"> CHF </option>
    //                                         <option value="JPY"> JPY </option>
    //                                         <option value="HKD"> HKD </option>
    //                                         <option value="NZD"> NZD </option>
    //                                         <option value="SGD"> SGD </option>
    //                                         <option value="Other">Other </option>
    //                                     </select>
    //                                     <input name="range1" id="range1" type="text" class="form-control" value="'.$data[range1].'"  style="width:100px; display:inline-block;"/> - 
    //                                     <input name="range2" id="range2" type="text" class="form-control" value="'.$data[range2].'"  style="width:100px; display:inline-block;"/>
    //                                 </div>';
                                    
    //                                 if($ty == 'Product'){

    //                                  $html.='<div class="form-group" style="width:100%; margin-right:10px; float:left;">
    //                                     <label>*Minimum '.$ty.' Quantity</label>
    //                                     <input name="p_min_quanity" id="p_min_quanity" type="text" class="form-control qtyinput" required value="'.$data[p_min_quanity].'"/>
    //                                 </div>
    //                                  ';
    //                             }
    //                                $html.='
    //                                  <label>*'.$ty.' Keyword</label>
    //                                     <div class="form-group">
    //                                         <div class="tagpanel"><input name="p_keyword" id="tags_1" type="text" class="form-control tags" required value="'.$data[p_keyword].'"/></div>
    //                                         </div>
    //                                         </div>
    //                            ';
                                    
    //                             $html.='<div class="col-sm-6">';
    //                                 $html.='<input type="hidden" name="image" id="companylogo" value="'.$data[p_photo].'">';
    //                                 $html.='<div class="form-group">
    //                                     <fieldset class="full_form_group">
    //                                         <legend>Gallery Image</legend>
    //                                         <div class="multiImg">
    //                                             <div class="form-group">
    //                                                 <label>'.$ty.' main image</label>
    //                                                 <div id="content_here_please"></div>
    //                                                 <input type="file"  name="img" id="image1" class="fileUpload"/> 
                                                    
    //                                                  <img alt="your image" class="dvPreview" src="#" style="display:none;max-width: 100px; max-height: 100px;">
                                                   
    //                                                 <input type="hidden" name="image1" id="photo1" value="'.$data[photo1].'">
    //                                             </div>

    //                                         </div>
    //                                         <div class="multiImg">
    //                                             <div class="form-group">
    //                                                 <label>'.$ty.' image 1</label>
    //                                                 <div id="content_here_please1"></div>
    //                                                 <input type="file" name="img1" id="image11" class="fileUpload"/>
    //                                                 <img alt="your image" class="dvPreview" src="#" style="display:none;max-width: 100px; max-height: 100px;">
    //                                                 <input type="hidden" name="image2" id="photo2" value="'.$data[photo2].'">
    //                                             </div>
    //                                         </div>
    //                                         <div class="multiImg">
    //                                             <div class="form-group">
    //                                                 <label>'.$ty.' image 2</label>
    //                                                 <div id="content_here_please2"></div>
    //                                                 <input type="file" name="img2" id="image21" class="fileUpload"/>
    //                                                 <img alt="your image" class="dvPreview" src="#" style="display:none;max-width: 100px; max-height: 100px;">
                                                    
    //                                                 <input type="hidden" name="image3" id="photo3" value="'.$data[photo3].'">
    //                                             </div>
    //                                         </div>
    //                                         <div class="multiImg">
    //                                             <div class="form-group">
    //                                                 <label>'.$ty.' image 3</label>
    //                                                 <div id="content_here_please3"></div>
    //                                                 <input type="file" name="img3" id="image31" class="fileUpload"/>
    //                                                 <img alt="your image" class="dvPreview" src="#" style="display:none;max-width: 100px; max-height: 100px;">
                                                    
    //                                                 <input type="hidden" name="image4" id="photo4" value="'.$data[photo4].'">
    //                                             </div>
    //                                         </div>
    //                                         <div class="multiImg">
    //                                             <div class="form-group">
    //                                                 <label>'.$ty.' image 4</label>
    //                                                 <div id="content_here_please4"></div>
    //                                                 <input type="file" name="img4" id="image41" class="fileUpload"/>
    //                                                 <img alt="your image" class="dvPreview" src="#" style="display:none;max-width: 100px; max-height: 100px;">
                                                    
    //                                                 <input type="hidden" name="image5" id="photo5" value="'.$data[photo5].'">
    //                                             </div>
    //                                         </div>
    //                                         <div class="multiImg">
    //                                             <div class="form-group">
    //                                                 <label>'.$ty.' image 5</label>
    //                                                 <div id="content_here_please5"></div>
    //                                                 <input type="file" name="img5" id="image51" class="fileUpload" />
    //                                                 <img alt="your image" class="dvPreview" src="#" style="display:none;max-width: 100px; max-height: 100px;">
                                                    
    //                                             </div>
    //                                         </div>
    //                                     </fieldset>
    //                                 </div>
                                   
    //                             </div>';
    //                             $html.='  <div class="col-sm-12">
    //                                 <div class="form-group" id="cpdes">
                                        
    //                                     <label>*Brief Description</label>';
    //                                     //$html.='<input name="company_details" id="company_details" type="text" class="form-control" value="'.$data[company_details].'"/>';

    //                                     $CKEditor = new CKEditor();            
    //                                     $CKEditor->returnOutput = true; 
    //                                     $CKEditor->basePath = '../../ckeditor/'; 
    //                                     $CKEditor->config['width'] = '100%'; 
    //                                     $CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);         
    //                                     CKFinder::SetupCKEditor($CKEditor, '../../ckfinder/');
    //                                     $code = $CKEditor->editor("p_bdes", $data['p_bdes']); 

    //                                      $html.=$code.'</div>
    //                             </div>';
    //                             $html.='<input name="country" type="hidden" value="95" />';

    //                             if($ty == 'Service'){

    //                             $html.='<div class="col-sm-12">
                                   
    //                                     </div>';
    //                                 }

    //                                  $html.='<div class="col-sm-12">
    //                                   <div class="form-group">
    //                                     <label>*'.$ty.' Category</label>
    //                                     <select name="p_category" id="p_category" class="form-control">';                                                   
    //                                     $ExtraQryStr    = " status='Y' AND mainCategory=".$pid." AND parent_id=".$pid." order by category ASC";
    //                                     $data           = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr,0,9999);

    //                                         $html.='<option class="prCategory" value=""  data-parent="0">Select</option>';
    //                                         foreach($data as $dataC)
    //                                         {
    //                                             $html.='<option class="prCategory" value="'.$dataC[c_id].'" '.$sel.'  data-parent="'.$dataC[c_id].'">'.$dataC[category].'</option>';

    //                                             $pId        = $dataC['c_id'];

    //                                             $ExtraQryCh     = " status='Y' AND parent_id=".$dataC['c_id']." order by category ASC";
    //                                             $dataCh         = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryCh,0,9999);
    //                                             if($dataCh){
    //                                                 foreach($dataCh as $child){
    //                                                     $html.='<option class="cCategory" value="'.$child[c_id].'">&nbsp;&nbsp;&nbsp;&nbsp;'.$child[category].'</option>';
    //                                                 }
    //                                             }
    //                                         }
    //                                     $html.='</select>
    //                                     <div class="categoryDetails"></div>
    //                                 </div>';
                                   
                                
    //                                 $html.='<div class="col-sm-12">
    //                                         <div class="form-group" id="ckbdes">                                    
    //                                         <label>*Detailed Description</label>';
    //                                         //$html.='<input name="company_details" id="company_details" type="text" class="form-control" value="'.$data[company_details].'"/>';

    //                                         $CKEditor = new CKEditor();            
    //                                         $CKEditor->returnOutput = true; 
    //                                         $CKEditor->basePath = '../../ckeditor/'; 
    //                                         $CKEditor->config['width'] = '100%'; 
    //                                         $CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);         
    //                                         CKFinder::SetupCKEditor($CKEditor, '../../ckfinder/');
    //                                         $code = $CKEditor->editor("p_ddes", $data['p_ddes']); 

    //                                          $html.=$code.'</div>

    //                                 </div>

    //                                 <div class="form-group">
    //                                     <label>Payment Terms<br/></label>
    //                                     <div class="col4" id="pt">
    //                                         <label class="input_check">
    //                                             <input name="paymenttype" id="pt1" value="L/C" type="radio">
    //                                             <span>L/C</span>
    //                                         </label>
    //                                         <label class="input_check">
    //                                             <input name="paymenttype" id="pt2" value="D/A" type="radio">
    //                                             <span>D/A </span>
    //                                         </label>
    //                                         <label class="input_check">
    //                                             <input name="paymenttype" id="pt3" value="D/P" type="radio">
    //                                             <span>D/P</span>
    //                                         </label>
    //                                         <label class="input_check">
    //                                             <input name="paymenttype" id="pt4" value="T/T" type="radio">
    //                                             <span>T/T</span>
    //                                         </label>
    //                                         <label class="input_check">
    //                                             <input name="paymenttype" id="pt5" value="Western Union" type="radio">
    //                                             <span>Western Union</span>
    //                                         </label>
    //                                         <label class="input_check">
    //                                             <input name="paymenttype" id="pt6" value="MoneyGram" type="radio">
    //                                             <span>MoneyGram</span>
    //                                         </label>
    //                                         <label class="input_check">
    //                                             <input name="paymenttype" id="pt7" value="" type="radio">
    //                                             <span> Others</span>
    //                                         </label>
    //                                     </div>
    //                                 </div>
    //                             </div>
    //                             <div class="col-sm-6">
    //                                 <div class="form-group">
    //                                     <label>Production Capacity </label><br />
    //                                     <input name="p_capaacity" id="p_capaacity" type="text" class="form-control" value="'.$data[p_capaacity].'"  style="width:70px; margin-right:5px; display:inline-block;"/>
    //                                     <select name="p_ctype" id="p_ctype" class="form-control" style="width:95px; margin-right:5px; display:inline-block;">
    //                                         <option value="">Unit</option>
    //                                         <option value="Bag/Bags">Bag/Bags </option>
    //                                         <option value="Barrel/Barrels">Barrel/Barrels </option>
    //                                         <option value="Cubic Meter">Cubic Meter </option>
    //                                         <option value="Dozen">Dozen </option>
    //                                         <option value="Gallon">Gallon</option>
    //                                         <option value="Gram">Gram </option>
    //                                         <option value="Kilogram">Kilogram </option>
    //                                         <option value="Kilometer">Kilometer </option>
    //                                         <option value="Long Ton">Long Ton </option>
    //                                         <option value="Meter">Meter </option>
    //                                         <option value="Mertic Ton">Metric Ton </option>
    //                                         <option value="Ounce">Ounce </option>
    //                                         <option value="Pair">Pair</option>
    //                                         <option value="pack/packs">Pack/Packs </option>
    //                                         <option value="Piece/Pieces">Piece/Pieces </option>
    //                                         <option value="Pound">Pound</option>
    //                                         <option value="Set/Sets">Set/Sets </option>
    //                                         <option value="Short Ton">Short Ton</option>
    //                                     </select>
    //                                     <select name="percapacity" id="percapacity" class="form-control" style="width:95px; display:inline-block;">
    //                                         <option value="">Time</option>
    //                                         <option value="Day">Day</option>
    //                                         <option value="Week">Week</option>
    //                                         <option value="Month">Month</option>
    //                                         <option value="Year">Year</option>
    //                                     </select>
    //                                 </div>
                                    
    //                                 <div class="form-group">
    //                                     <label>Delivery Time </label><br />
    //                                     <input name="p_delivertytime0" id="p_delivertytime0" type="text" class="form-control" value="'.$data[p_delivertytime].'"  style="width:70px; margin-right:5px; display:inline-block;"/>
    //                                     <select name="p_delivertytime1" id="p_delivertytime1" class="form-control" style="width:95px; display:inline-block;">
    //                                         <option value="">Time</option>
    //                                         <option value="Day">Day</option>
    //                                         <option value="Week">Week</option>
    //                                         <option value="Month">Month</option>
    //                                         <option value="Year">Year</option>
    //                                     </select>
    //                                 </div>
    //                             </div>';
    //                             if($ty == 'Product'){

    //                              $html.='<div class="col-sm-12">
    //                                 <div class="form-group">
    //                                     <label>Packaging Details</label>
    //                                     <textarea name="p_packingdetails" id="p_packingdetails" type="text" class="form-control">'.$data[p_packingdetails].'</textarea>
    //                                 </div>
    //                             </div>';
                              
    //                            }
    //                              $html.='</div>
    //                             <div class="col-sm-12">
    //                                 <div class="form-group">
    //                                     <button type="submit" class="btn btn-primary btn-lg proData">Save</button> 
    //                                     <input name="userid" id="userid" type="hidden" value="'.$id_user.'" />
    //                                     <input type="hidden" name="ajax" value="1">
    //                                     <input type="hidden" name="proType" value="'.$proType.'">
    //                                     <input type="hidden" name="SourceForm" value="addProduct">
    //                                     <button type="button" class="btn btn-primary btn-lg previewProduct">Preview</button>   
    //                                 </div>
    //                             </div>
    //                         </div>';
    //                         $html.='<div class="errMsg"></div>
    //                     </form>
    //                     <div id="previewPro"><!--<div class="alert alert-warning" role="alert"></div>--></div>
    //                 </div>
    //             </div>
    //         </div>';		 	
    //         /*<button type="button" class="btn btn-primary btn-lg" onclick="preview()">Preview</button>					*/
    // echo $html;											
    // }
        

 
    function productCategory($ExtraQryStr, $start, $limit)
    {
        $ExtraQryStr    = " parent_id='' order by category asc";
        return $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr, $start, $limit);
    }
    
    /*------------------PRODUCT--------------------------------*/
    /*------------------SAMPLE------START--------------------------*/
    
    
    function smproduct($id_user){
        $ExtraQryStr = " userId = ".addslashes($id_user);
        return $this->connect->rowCount(TBL_SAMPLE, 'sampleId', $ExtraQryStr);
    }
    function smpRequestCount($id){
        $ExtraQryStr = " c_id = ".addslashes($id)." AND contactType='S'";
        return $this->connect->rowCount(TBL_CONTACT, 'contactId', $ExtraQryStr);
    }
    
    function smpRequest($id){
        
        $ENTITY =   TBL_CONTACT." c 
                    LEFT JOIN ".TBL_REQUIREMENT_ATTRIBUTE." r ON ( c.contactId = r.contactId)";
                
        $ExtraQryStr = "c.c_id=".addslashes($id)." AND c.contactType='S' order by c.contactEntrydate desc";         
        
        return $this->connect->selectMulti($ENTITY, "c.*, r.attributeId, r.attributeValue, r.attributeValue", $ExtraQryStr, 0, 9999);	
    }
    
    function newSampleQty($params)
	{
		return $this->connect->insertQuery(TBL_SAMPLE_QTY, $params);
	}
    function newSampleHistory($params)
	{
		return $this->connect->insertQuery(TBL_SAMPLE_HISTORY, $params);
	}
    
    function sampleQtyUpdateByqtyId($params, $id){
        $CLAUSE = "qtyId = ".$id;
        return $this->connect->updateQuery(TBL_SAMPLE_QTY, $params, $CLAUSE);
    }
    
    function checkSampleExistence($ExtraQryStr) { 
        return $this->connect->selectSingle(TBL_SAMPLE, "*", $ExtraQryStr);
    }
    
    function newSample($params)
	{		
        return $this->connect->insertQuery(TBL_SAMPLE, $params);
	}
    
    function sampleUpdateBysampleId($params, $id){
        $CLAUSE = "sampleId = ".$id;
        return $this->connect->updateQuery(TBL_SAMPLE, $params, $CLAUSE);
    }
    
    function readsample($id_user, $slNo, $start, $limit) { 
        
        $ExtraQryStr = " user_id=".addslashes($id_user);
        $comData = $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr);
        
         $html ='<div class="smplBox fleft"><div class="search_form">
                        <form method="get" id="srch_frm">
                            <input type="text" autocomplete="off" placeholder="Search" name="search" id="srch_txt" value="" class="form-control">
                            <div id="pname" class="autosearch"></div>
                        </form>
                    </div></div>';
            
        
        
        $html .='<div class="smplBox fright"><div class="">
                    <button type="button" data-page="addsample" data-id="'.$comData['id'].'" class="btn btn-default btn-black addSample mr10" value="'.$id_user.'>'.$numr.'" >Add New Sample</button>                    
                </div></div><div class="clearfix"></div>';      
        
        /*
         <a href="'.SITEDASH.'/samples/approved-samples/" class="" data-id="'.$data['sampleId'].'" data-page="" style="cursor:pointer"><span class="btn btn-default btn-black" data-placement="top" title="Approved Samples">Approved Samples</span></a>
        */
        
        $ExtraQryStr = " userId=".addslashes($id_user).' AND isApproved="Sample Received"';
        $receivedData = $this->connect->selectMulti(TBL_SAMPLE, "*", $ExtraQryStr, $start, $limit);
        if($receivedData)
        {  
           $html       .=' approved samples  ';
            $html       .='<form name="" method="post"><table class="table table-striped" id="samplData">
            <thead>
              <tr>
                <th>#</th>
                <th></th>
                <th>Sample</th>
                <th>Qty</th>
                <th>Status</th>
                <th></th>
                <th style="min-width: 60px;"></th>
              </tr>
            </thead><tbody>';
                    
            $f  =0;
            $c  =1;
            $q  =1;
            if($receivedData){
                foreach($receivedData as $rdata)
                {  
                    $img    ='';
                                        
                    if(file_exists(UPFLD.'/product/thumb/'.$rdata['productImage']) && $rdata['productImage'])
                    {
                        $img='<img src="'.SHWFL.'/product/thumb/'.$rdata['productImage'].'" width="50px; class="thumbnail">';
                    }
                    elseif(file_exists(UPFLD.'/sample/thumb/'.$rdata['productImage']) && $rdata['productImage'])
                    {
                        $img='<img src="'.SHWFL.'/sample/thumb/'.$rdata['productImage'].'" width="50px; class="thumbnail">';
                    } 
                    else
                        $img='<img src="'.TMP.'/images/noimage.jpg">';
                    
                    
                    if(strlen($rdata['productName'])>40) 
                        $cnt = '...';
                    else
                        $cnt = '';
                    if($rdata['p_keyword'])
                        $ky = '<div class="keyWrd">SKU# '.str_replace(",",", ",$rdata['p_keyword']).'</div>';
                    else
                        $ky = '';
                    
                    $html.='<tr class="tbl_'.$c.' alltr" style="'.$disp.'">
                        <td>'.$slNo.'</td>
                        <td><a class="viewSample" data-id="'.$rdata['sampleId'].'" data-page="viewSample" style="cursor:pointer">'.$img.'</a></td>
                        <td><a class="viewSample" data-id="'.$rdata['sampleId'].'" data-page="viewSample" style="cursor:pointer">'.substr($rdata['productName'],0,40).$cnt.'</a>'.$ky.'
                            <div class="sampleAction">
                                <a class="viewSample" data-id="'.$rdata['sampleId'].'" data-page="viewSample" style="cursor:pointer"><span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="View Product"></span> View</a>                       
                            </div>
                        </td>
                        
                        <td>'.$rdata['totalQty'].' BAGS</td>
                        <td>'.$rdata['isApproved'].'</td>
                        <td> <a href="'.SITEDASH.'/samples/inventory/?sample='.$rdata['permalink'].'" class="" data-id="'.$rdata['sampleId'].'" data-page="" style="cursor:pointer"><span class="btn btn-primary" data-placement="top" title="Inventory">Inventory</span></a> </td>
                        <td> <a href="'.SITEDASH.'/samples/sent-history/?sample='.$rdata['permalink'].'" class="" data-id="'.$rdata['sampleId'].'" data-page="" style="cursor:pointer">
                            <span class="btn btn-primary" title="Sent History">Sent History</span></a></td>                        
                        
                      </tr>';
                     $slNo++;
                }
            }
            else{
                $html.='<tr><td align="center" colspan="7">No records found.</td></tr>';
            }
            $html.='</tbody></table></form>';
            
            
            
            
            
        }
        $html       .='<form name="" method="post"><table class="table table-striped" id="samplData">
            <thead>
              <tr>
                <th>#</th>
                <th></th>
                <th>Sample</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Request #</th>
                <th style="min-width: 60px;"></th>
              </tr>
            </thead><tbody>';
        
            $ExtraQryStr = " userId=".addslashes($id_user).' AND isApproved!="Sample Received"';
            $productData = $this->connect->selectMulti(TBL_SAMPLE, "*", $ExtraQryStr, $start, $limit);
            
            $f  =0;
            $c  =1;
            $q  =1;
            if($productData){
                foreach($productData as $data)
                {  
                    $img    ='';
                                        
                    if(file_exists(UPFLD.'/product/thumb/'.$data['productImage']) && $data['productImage'])
                    {
                        $img='<img src="'.SHWFL.'/product/thumb/'.$data['productImage'].'" width="50px; class="thumbnail">';
                    }
                    elseif(file_exists(UPFLD.'/sample/thumb/'.$data['productImage']) && $data['productImage'])
                    {
                        $img='<img src="'.SHWFL.'/sample/thumb/'.$data['productImage'].'" width="50px; class="thumbnail">';
                    } 
                    else
                        $img='<img src="'.TMP.'/images/noimage.jpg">';
                    
                    
                    if(strlen($data['productName'])>40) 
                        $cnt = '...';
                    else
                        $cnt = '';
                    if($data['p_keyword'])
                        $ky = '<div class="keyWrd">SKU# '.str_replace(",",", ",$data['p_keyword']).'</div>';
                    else
                        $ky = '';
                    
                    $html.='<tr class="tbl_'.$c.' alltr" style="'.$disp.'">
                        <td>'.$slNo.'</td>
                        <td><a title="'.$data['productName'].'" class="viewSample" data-id="'.$data['sampleId'].'" data-page="viewSample" style="cursor:pointer">'.$img.'</a></td>
                        <td><a title="'.$data['productName'].'" class="viewSample" data-id="'.$data['sampleId'].'" data-page="viewSample" style="cursor:pointer">'.substr($data['productName'],0,40).$cnt.'</a>'.$ky.'
                        </td>
                        <td>'.$data['totalQty'].' BAGS</td>
                        <td>'.$data['isApproved'].'</td>
                        <td>'.$data['sampleReqId'].'</td>
                        <td>
                            <a class="viewSample" data-id="'.$data['sampleId'].'" data-page="viewSample" style="cursor:pointer"><span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="View Product"></span></a> 
                            
                            <a class="editSample" data-id="'.$data['sampleId'].'" data-page="editSample" style="cursor:pointer"><span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" title="Edit Product"></span></a> 
                            
                            <a class="deleteSample" data-id="'.$data['sampleId'].'" data-page="deleteSample" style="cursor:pointer">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Delete"></span></a>  
                        
                        </td>                        
                        
                      </tr>';
                     $slNo++;
                }
            }
            else{
                $html.='<tr><td align="center" colspan="6">No records found.</td></tr>';
            }
            $html.='</tbody>
            </table>
        </form>';
        
        
        
        
        
        return $html;
        
    }   
    
    function readapprovedsample($id_user, $slNo, $start, $limit) { 
        
        $ExtraQryStr = " user_id=".addslashes($id_user);
        $comData = $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr);
        
         $html ='<div class="smplBox fleft"><div class="search_form">
                        <form method="get" id="srch_frm">
                            <input type="text" autocomplete="off" placeholder="Search" name="search" id="srch_txt" value="" class="form-control">
                            <div id="pname" class="autosearch"></div>
                        </form>
                    </div></div>';
            
        
        
        $html .='<div class="smplBox fright"><div class="">
                    <button type="button" data-page="addsample" data-id="'.$comData['id'].'" class="btn btn-default btn-black addSample mr10" value="'.$id_user.'>'.$numr.'" >Add New Sample</button>                    
                </div></div><div class="clearfix"></div>';
        /*
        <a href="'.SITEDASH.'/samples/approved-samples/" class="" data-id="'.$data['sampleId'].'" data-page="" style="cursor:pointer"><span class="btn btn-default btn-black" data-placement="top" title="Approved Samples">Approved Samples</span></a>
        */
            
        
        $html       .='<form name="" method="post"><table class="table table-striped" id="samplData">
            <thead>
              <tr>
                <th>#</th>
                <th></th>
                <th>Sample</th>
                <th>Qty</th>
                <th>Status</th>
                <th></th>
                <th style="min-width: 60px;"></th>
              </tr>
            </thead><tbody>';
        
            $ExtraQryStr = " userId=".addslashes($id_user).' AND isApproved="Sample Received"';
            $productData = $this->connect->selectMulti(TBL_SAMPLE, "*", $ExtraQryStr, $start, $limit);
            
            $f  =0;
            $c  =1;
            $q  =1;
            if($productData){
                foreach($productData as $data)
                {  
                    $img    ='';
                                        
                    if(file_exists(UPFLD.'/product/thumb/'.$data['productImage']) && $data['productImage'])
                    {
                        $img='<img src="'.SHWFL.'/product/thumb/'.$data['productImage'].'" width="50px; class="thumbnail">';
                    }
                    elseif(file_exists(UPFLD.'/sample/thumb/'.$data['productImage']) && $data['productImage'])
                    {
                        $img='<img src="'.SHWFL.'/sample/thumb/'.$data['productImage'].'" width="50px; class="thumbnail">';
                    } 
                    else
                        $img='<img src="'.TMP.'/images/noimage.jpg">';
                    
                    
                    if(strlen($data['productName'])>40) 
                        $cnt = '...';
                    else
                        $cnt = '';
                    if($data['p_keyword'])
                        $ky = '<div class="keyWrd">SKU# '.str_replace(",",", ",$data['p_keyword']).'</div>';
                    else
                        $ky = '';
                    
                    $html.='<tr class="tbl_'.$c.' alltr" style="'.$disp.'">
                        <td>'.$slNo.'</td>
                        <td><a class="viewSample" data-id="'.$data['sampleId'].'" data-page="viewSample" style="cursor:pointer">'.$img.'</a></td>
                        <td><a class="viewSample" data-id="'.$data['sampleId'].'" data-page="viewSample" style="cursor:pointer">'.substr($data['productName'],0,40).$cnt.'</a>'.$ky.'
                            <div class="sampleAction">
                                <a class="viewSample" data-id="'.$data['sampleId'].'" data-page="viewSample" style="cursor:pointer"><span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="View Product"></span> View</a>                       
                            </div>
                        </td>
                        
                        <td>'.$data['totalQty'].' BAGS</td>
                        <td>'.$data['isApproved'].'</td>
                        <td> <a href="'.SITEDASH.'/samples/inventory/?sample='.$data['permalink'].'" class="" data-id="'.$data['sampleId'].'" data-page="" style="cursor:pointer"><span class="btn btn-primary" data-placement="top" title="Inventory">Inventory</span></a> </td>
                        <td> <a href="'.SITEDASH.'/samples/sent-history/?sample='.$data['permalink'].'" class="" data-id="'.$data['sampleId'].'" data-page="" style="cursor:pointer">
                            <span class="btn btn-primary" title="Sent History">Sent History</span></a></td>                        
                        
                      </tr>';
                     $slNo++;
                }
            }
            else{
                $html.='<tr><td align="center" colspan="7">No records found.</td></tr>';
            }
            $html.='</tbody></table></form>';
        
        return $html;
        
    }   
    
    function showsampleadd($id_user)
    { 
        $ExtraQryStr = " user_id=".addslashes($id_user);
        $comData = $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr);     
        
        
        $html.='<div class="h-box-100 relative">
            <div class="h-heading">Add Sample</div>
            <div class="clear"></div>
            <div class="h-table"> <span class="formClose">X</span> 
                <div class="">
                    <form id="sampledata" class="forma" onsubmit="return false;" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group relative">
                                    <label>*Product Name</label>
                                    <input name="permalink" id="permalink" type="hidden" class="form-control" value="'.$data[permalink].'"/>
                                    <input type="text" autocomplete="off" class="form-control" id="sampleName" name="sampleName" data-comp="'.$comData['id'].'" placeholder="Product Name" required>
                                    <div id="smname" class="autosearch"></div>
                                </div>
                                <div class="form-group">
                                    <label>*Quantity</label><br>
                                    <input name="qty" id="qty" type="text" class="form-control qtyinput" required value="'.$data[p_min_quanity].'" style="width:70px; margin-right:5px; display:inline-block;"/>
                                    <select name="unitType" id="p_ctype" class="form-control" style="width:120px; display:inline-block;">
                                        <option value="" '.$ch1.'>Unit</option>
                                        <option value="Bag/Bags" '.$ch2.'>Bag/Bags </option>
                                        <option value="Barrel/Barrels" '.$ch3.'>Barrel/Barrels </option>
                                        <option value="Cubic Meter" '.$ch4.'>Cubic Meter </option>
                                        <option value="Dozen" '.$ch5.'>Dozen </option>
                                        <option value="Gallon" '.$ch6.'>Gallon</option>
                                        <option value="Gram" '.$ch7.'>Gram </option>
                                        <option value="Kilogram" '.$ch8.'>Kilogram </option>
                                        <option value="Kilometer" '.$ch9.'>Kilometer </option>
                                        <option value="Long Ton" '.$ch10.'>Long Ton </option>
                                        <option value="Meter" '.$ch11.'>Meter </option>
                                        <option value="Mertic Ton" '.$ch12.'>Metric Ton </option>
                                        <option value="Ounce" '.$ch13.'>Ounce </option>
                                        <option value="Pair" '.$ch14.'>Pair</option>
                                        <option value="pack/packs" '.$ch15.'>Pack/Packs </option>
                                        <option value="Piece/Pieces" '.$ch16.'>Piece/Pieces </option>
                                        <option value="Pound" '.$ch17.'>Pound</option>
                                        <option value="Set/Sets" '.$ch18.'>Set/Sets </option>
                                        <option value="Short Ton" '.$ch19.'>Short Ton</option>
                                    </select>
                                </div>
                                <div class="form-group qtc smCr">
                                    <label>Price</label><br />
                                    <select name="currency" id="currency" class="form-control" style="width:95px;  margin-right:5px; display:inline-block;">
                                        <option value="" '.$ch1.'>Currency</option>
                                        <option value="USD" '.$ch2.'> USD </option>
                                        <option value="GBP" '.$ch3.'> GBP </option>
                                        <option value="RMB" '.$ch4.'> RMB </option>
                                        <option value="EUR" '.$ch5.'> EUR </option>
                                        <option value="AUD" '.$ch6.'> AUD </option>
                                        <option value="CAD" '.$ch7.'> CAD </option>
                                        <option value="CHF" '.$ch8.'> CHF </option>
                                        <option value="JPY" '.$ch9.'> JPY </option>
                                        <option value="HKD" '.$ch10.'> HKD </option>
                                        <option value="NZD" '.$ch11.'> NZD </option>
                                        <option value="SGD" '.$ch12.'> SGD </option>
                                        <option value="Other" '.$ch13.'>Other </option>
                                    </select>
                                    <input name="range1" id="range1" type="text" class="form-control qtyinput" value="'.$data[range1].'"  style="width:70px; display:inline-block;"/> - 
                                    <input name="range2" id="range2" type="text" class="form-control qtyinput" value="'.$data[range2].'"  style="width:70px; display:inline-block;"/>
                                </div>
                                <div class="form-group">
                                    <label>*Product Category</label>
                                    <select name="p_category" id="p_category" class="form-control">';	

                                        $ExtraQryStr    = " status='Y' AND mainCategory=1 order by category ASC";

                                        $data1           = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr,0,9999);
                                        foreach($data1 as $dataC)
                                        {
                                            if($dataC[c_id]==$data[p_category])
                                            {
                                                $sel='selected="selected"';
                                            }
                                            else
                                            {
                                                $sel='';
                                            }

                                            $html.='<option value="'.$dataC[c_id].'" '.$sel.'>'.$dataC[category].'</option>';

                                            $pId        = $dataC['c_id'];

                                            $ExtraQryCh     = " status='Y' AND parent_id=".$dataC['c_id']." order by category ASC";
                                            $dataCh         = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryCh,0,9999);

                                            if($dataCh)
                                            {
                                                foreach($dataCh as $child){

                                                    if($child[c_id]==$data[p_category])
                                                    {
                                                        $sel='selected="selected"';
                                                    }
                                                    else
                                                    {
                                                        $sel='';
                                                    }

                                                    $html.='<option class="cCategory" value="'.$child[c_id].'">&nbsp;&nbsp;&nbsp;&nbsp;'.$child[category].'</option>';
                                                }
                                            }
                                        }

                                    $html.='</select>
                                </div>
                                <div class="categoryDetails"></div>';        
        
                            $html.='</div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Product Keyword</label>
                                    <div class="tagpanel"><input name="p_keyword" id="tags_1" type="text" class="form-control tags" required value="'.$data[p_keyword].'"/></div>
                                    
                                </div>
                                <div class="form-group">
                                    <fieldset class="full_form_group">
                                        <legend>Product Image</legend>
                                        <div id="proImg">
                                            <input type="file" name="proimg" id="" />
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div id="pdesc">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" type="text" class="form-control" style="height:140px;"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input name="userid" id="userid" type="hidden" value="'.$id_user.'" />    
                                    <input name="compId" id="userid" type="hidden" value="'.$comData['id'].'" />           
                                    <input name="proid" id="proid" type="hidden" value="" />           
                                    <input type="submit" value="Save" class="btn btn-primary btn-lg">
                                    <input type="hidden" name="ajax" value="1">
                                    <input type="hidden" name="SourceForm" value="addSample">
                                </div>
                            </div>
                        </div>
                        <div class="errMsg"></div>
                    </form>
                </div>
            </div>
        </div>';
    echo $html;											
    }
    
    function deleteSampleById($id){  
        
        $ExtraQryStr   = " sampleId=".addslashes($id);
        $data          = $this->connect->selectSingle(TBL_SAMPLE, "*", $ExtraQryStr);
        if($data){
            $delPath = UPFLD."/sample";
            @unlink($delPath.'/normal/'.$data['productImage']);
            @unlink($delPath.'/large/'.$data['productImage']);
            @unlink($delPath.'/thumb/'.$data['productImage']);	
        }
        
        $del=$this->connect->executeQuery("delete from ".TBL_SAMPLE." where sampleId = ".$id);
        
        $ExtraQryStr = "userId=".addslashes($_SESSION['FUSERID']);
        $countRow = $this->sampleCount($ExtraQryStr);
        
        $param = array();
        $param['sampleCount'] = $countRow;
        $this-> memberUpdateById($param, $_SESSION['FUSERID']);
      
        
        $html = '<div class="successmsg">Sample deleted successfully.</div><div class="clearfix"></div>';
        return $html;
    }
    
    function editsampleshow($uid,$id,$page)
    {        
        $ExtraQryStr = " user_id=".addslashes($uid);
        $comData = $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr);  
        
        $ENTITY =   TBL_SAMPLE." s 
                    LEFT JOIN ".TBL_SAMPLE_QTY." sq ON (sq.userId = s.userId AND sq.sampleId = s.sampleId)";

        $ExtraQryStr = "s.userId=".addslashes($uid)." AND s.sampleId=".addslashes($id)." AND s.status='Y' order by s.productName ASC";         
        $smpData = $this->connect->selectSingle($ENTITY, "s.*, sq.qtyId, sq.ct, sq.inStock, sq.entryDate", $ExtraQryStr);        
                
        $ExtraQryStr = "categoryId=".$smpData['proCid']." order by attributeId";
		$cData       = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY_ATTRIBUTES, "*", $ExtraQryStr, 0, 99999);
                    
        if($page=='editSample')
            $hd='Edit';
        else
            $hd='View';
        
        $html.='<div class="h-box-100 relative">
            <div class="h-heading">'.$hd.' Sample</div>
            <div class="clear"></div>
            <div class="h-table"> <span class="formClose">X</span> 
                <div class="">
                    <form id="editsampledata" class="forma" onsubmit="return false;" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group relative">
                                    <label>*Product Name</label>
                                    <input name="permalink" id="permalink" type="hidden" class="form-control" value="'.$smpData[permalink].'"/>                                    
                                    
                                    <input type="text" autocomplete="off" class="form-control" id="sampleName" name="sampleName" data-comp="'.$comData['id'].'" placeholder="Product Name" value="'.$smpData['productName'].'" required>                                    
                                    <div id="smname" class="autosearch"></div>
                                </div>';
        
                                $ch1='';
                                $ch2='';
                                $ch3='';
                                $ch4='';
                                $ch5='';
                                $ch6='';
                                $ch7='';
                                $ch8='';
                                $ch9='';
                                $ch10='';
                                $ch11='';
                                $ch12='';
                                $ch13='';
                                $ch14='';
                                $ch15='';
                                $ch16='';
                                $ch17='';
                                $ch18='';
                                $ch19='';				
                                if($smpData['unitType']==''){$ch1='selected="selected"';}
                                if($smpData['unitType']=='Bag/Bags'){$ch2='selected="selected"';}
                                if($smpData['unitType']=='Barrel/Barrels'){$ch3='selected="selected"';}
                                if($smpData['unitType']=='Cubic Meter'){$ch4='selected="selected"';}
                                if($smpData['unitType']=='Dozen'){$ch5='selected="selected"';}	
                                if($smpData['unitType']=='Gallon'){$ch6='selected="selected"';}
                                if($smpData['unitType']=='Gram'){$ch7='selected="selected"';}	
                                if($smpData['unitType']=='Kilogram'){$ch8='selected="selected"';}	
                                if($smpData['unitType']=='Kilometer'){$ch9='selected="selected"';}	
                                if($smpData['unitType']=='Long Ton'){$ch10='selected="selected"';}	
                                if($smpData['unitType']=='Meter'){$ch11='selected="selected"';}	
                                if($smpData['unitType']=='Mertic Ton'){$ch12='selected="selected"';}
                                if($smpData['unitType']=='Ounce'){$ch13='selected="selected"';}
                                if($smpData['unitType']=='Pair'){$ch14='selected="selected"';}
                                if($smpData['unitType']=='pack/packs'){$ch15='selected="selected"';}
                                if($smpData['unitType']=='Piece/Pieces'){$ch16='selected="selected"';}
                                if($smpData['unitType']=='Pound'){$ch17='selected="selected"';}
                                if($smpData['unitType']=='Set/Sets'){$ch18='selected="selected"';}
                                if($smpData['unitType']=='Short Ton'){$ch19='selected="selected"';}
        
                                $html.='<div class="form-group">
                                    <label>*Quantity</label><br>
                                    <input name="qty" id="qty" type="text" class="form-control qtyinput" required value="'.$smpData[qty].'" style="width:70px; margin-right:5px; display:inline-block;"/>
                                    <select name="unitType" id="p_ctype" class="form-control" style="width:120px; display:inline-block;">
                                        <option value="" '.$ch1.'>Unit</option>
                                        <option value="Bag/Bags" '.$ch2.'>Bag/Bags </option>
                                        <option value="Barrel/Barrels" '.$ch3.'>Barrel/Barrels </option>
                                        <option value="Cubic Meter" '.$ch4.'>Cubic Meter </option>
                                        <option value="Dozen" '.$ch5.'>Dozen </option>
                                        <option value="Gallon" '.$ch6.'>Gallon</option>
                                        <option value="Gram" '.$ch7.'>Gram </option>
                                        <option value="Kilogram" '.$ch8.'>Kilogram </option>
                                        <option value="Kilometer" '.$ch9.'>Kilometer </option>
                                        <option value="Long Ton" '.$ch10.'>Long Ton </option>
                                        <option value="Meter" '.$ch11.'>Meter </option>
                                        <option value="Mertic Ton" '.$ch12.'>Metric Ton </option>
                                        <option value="Ounce" '.$ch13.'>Ounce </option>
                                        <option value="Pair" '.$ch14.'>Pair</option>
                                        <option value="pack/packs" '.$ch15.'>Pack/Packs </option>
                                        <option value="Piece/Pieces" '.$ch16.'>Piece/Pieces </option>
                                        <option value="Pound" '.$ch17.'>Pound</option>
                                        <option value="Set/Sets" '.$ch18.'>Set/Sets </option>
                                        <option value="Short Ton" '.$ch19.'>Short Ton</option>
                                    </select>
                                </div>';
                                if($smpData['currency']==''){$ch1='selected="selected"';}
                                if($smpData['currency']=='USD'){$ch2='selected="selected"';}
                                if($smpData['currency']=='GBP'){$ch3='selected="selected"';}
                                if($smpData['currency']=='RMB'){$ch4='selected="selected"';}
                                if($smpData['currency']=='EUR'){$ch5='selected="selected"';}	
                                if($smpData['currency']=='AUD'){$ch6='selected="selected"';}
                                if($smpData['currency']=='CAD'){$ch7='selected="selected"';}	
                                if($smpData['currency']=='CHF'){$ch8='selected="selected"';}	
                                if($smpData['currency']=='JPY'){$ch9='selected="selected"';}	
                                if($smpData['currency']=='HKD'){$ch10='selected="selected"';}	
                                if($smpData['currency']=='NZD'){$ch11='selected="selected"';}	
                                if($smpData['currency']=='SGD'){$ch12='selected="selected"';}	
                                if($smpData['currency']=='Other'){$ch13='selected="selected"';}	
        
                                $html.='<div class="form-group qtc smCr">
                                    <label>Price</label><br />
                                    <select name="currency" id="currency" class="form-control" style="width:95px;  margin-right:5px; display:inline-block;">
                                        <option value="" '.$ch1.'>Currency</option>
                                        <option value="USD" '.$ch2.'> USD </option>
                                        <option value="GBP" '.$ch3.'> GBP </option>
                                        <option value="RMB" '.$ch4.'> RMB </option>
                                        <option value="EUR" '.$ch5.'> EUR </option>
                                        <option value="AUD" '.$ch6.'> AUD </option>
                                        <option value="CAD" '.$ch7.'> CAD </option>
                                        <option value="CHF" '.$ch8.'> CHF </option>
                                        <option value="JPY" '.$ch9.'> JPY </option>
                                        <option value="HKD" '.$ch10.'> HKD </option>
                                        <option value="NZD" '.$ch11.'> NZD </option>
                                        <option value="SGD" '.$ch12.'> SGD </option>
                                        <option value="Other" '.$ch13.'>Other </option>
                                    </select>
                                    <input name="range1" id="range1" type="text" class="form-control qtyinput" value="'.$smpData[range1].'"  style="width:70px; display:inline-block;"/> - 
                                    <input name="range2" id="range2" type="text" class="form-control qtyinput" value="'.$smpData[range2].'"  style="width:70px; display:inline-block;"/>
                                </div>
                                <div class="form-group">
                                    <label>*Product Category</label>
                                    <select name="p_category" id="p_category" class="form-control">';	

                                        $ExtraQryStr    = " status='Y' AND mainCategory=1 order by category ASC";

                                        $data1           = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryStr,0,9999);
                                        foreach($data1 as $dataC)
                                        {
                                            if($dataC[c_id]==$smpData[proCid])
                                            {
                                                $sel='selected="selected"';
                                            }
                                            else
                                            {
                                                $sel='';
                                            }

                                            $html.='<option value="'.$dataC[c_id].'" '.$sel.'>'.$dataC[category].'</option>';

                                            $pId        = $dataC['c_id'];

                                            $ExtraQryCh     = " status='Y' AND parent_id=".$dataC['c_id']." order by category ASC";
                                            $dataCh         = $this->connect->selectMulti(TBL_PRODUCT_CATEGORY, "*", $ExtraQryCh,0,9999);

                                            if($dataCh)
                                            {
                                                foreach($dataCh as $child){

                                                    if($child[c_id]==$smpData[proCid])
                                                    {
                                                        $sel='selected="selected"';
                                                    }
                                                    else
                                                    {
                                                        $sel='';
                                                    }

                                                    $html.='<option class="cCategory" value="'.$child[c_id].'">&nbsp;&nbsp;&nbsp;&nbsp;'.$child[category].'</option>';
                                                }
                                            }
                                        }

                                    $html.='</select>
                                </div>
                                <div class="categoryDetails">';
        
                            $html.='</div></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Product Keyword</label>
                                    <div class="tagpanel"><input name="p_keyword" id="tags_1" type="text" class="form-control tags" required value="'.$smpData[p_keyword].'"/></div>
                                    
                                </div>
                                <div class="form-group">
                                    <fieldset class="full_form_group">
                                        <legend>Product Image</legend>
                                        <div id="proImg">';
                                            if(file_exists(UPFLD.'/product/thumb/'.$smpData['productImage']) && $smpData['productImage'])
                                            {
                                                $html.='<img src="'.SHWFL.'/product/thumb/'.$smpData['productImage'].'" width="30%">';
                                            }
                                            elseif(file_exists(UPFLD.'/sample/thumb/'.$smpData['productImage']) && $smpData['productImage'])
                                            {
                                                $html.='<img src="'.SHWFL.'/sample/thumb/'.$smpData['productImage'].'" width="30%">';
                                            }
                                            else
                                                $html.='<img src="'.TMP.'/images/noimage.jpg">';
                                        
                                            if($page=='editSample'){
                                                $html.='<input type="file" name="proimg" />';
                                                $html.='<input type="hidden" name="proImg" value="'.$smpData['productImage'].'" />';
                                            }
        
                                           $html.='
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div id="pdesc">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" type="text" class="form-control" style="height:140px;">'.$smpData['description'].'</textarea>
                                    </div>
                                </div>
                            </div>';
                            if($page=='editSample'){

                                $html.='<div class="clear"></div>
                                <div class="form-group">
                                 <input name="userid" id="userid" type="hidden" value="'.$uid.'" />             
                                 <input name="editId" id="userid" type="hidden" value="'.$id.'" />             
                                 <input name="compId" id="userid" type="hidden" value="'.$comData['id'].'" />             
                                 <input name="proid" id="proid" type="hidden" value="'.$smpData['proId'].'" />                    
                                 <input name="qtyId" id="qtyId" type="hidden" value="'.$smpData['qtyId'].'" />                    
                                 <input type="submit" value="Save" class="btn btn-primary btn-lg">
                                 </div>
                                 <input type="hidden" name="ajax" value="1">
                                 <input type="hidden" name="SourceForm" value="editSample">';	
                                $html.='<div class="errMsg"></div></form></div></div></div>';	 		        
                            } 
                        $html.='</div>
                        <div class="errMsg"></div>
                    </form>
                </div>
            </div>
        </div>'; 
    echo $html;	
    }
    
    function sendsample($uid, $start, $limit){
        
        $ExtraQryStr = " user_id=".addslashes($uid);
        $comData = $this->connect->selectSingle(TBL_COMPANY, "*", $ExtraQryStr);    

        $ExtraQryStr ="userId=".addslashes($uid);        
        $samData = $this->connect->selectMulti(TBL_SAMPLE, "*", $ExtraQryStr, $start, $limit ); 
        
      $html = '      
        <div class="form-group clearfix">
            <form name="" method="post" id="sendsample">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label style="line-height: 34px;">Sample</label>
                        <select name="sample[]" class="sample form-control" style="width: 80%; height: 34px;" required>
                            <option value="">Select</option>';
                            foreach($samData as $sm){
                                $html.= '<option value="'.$sm['sampleId'].'">'.$sm['productName'].'</option>';
                            }
                        $html.= '</select>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label style="line-height: 34px;">Qty</label>
                        <span class="qty_block">
                            <span class="minus_value">minus</span>
                            <input class="qty_input form-control" id="smQt" name="qty[]" value="1" type="text" readonly="">
                            <span class="add_value">add</span>
                        </span>
                    </div>
                    <div id="newSmpl"></div>
                    <div class="col-sm-6 text-right newSmp">
                        <a href="javascript:void(0)" class="addnew" data-cid="'.$comData['id'].'">+ add new</a>
                    </div>
                    <input type="hidden" class="selectSmp" name="selectSmp" val="">
                </div>
                    
                <div class="">
                    <div class="form-group relative">
                        <label>To</label>
                        <input autocomplete="off" name="uname" id="uto" data-cid="'.$comData['id'].'" type="text" class="form-control" required="" value="">  
                        <div id="umail" class="autosearch"></div>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input name="uphone" id="uphone" type="text" class="form-control" required="" value="">                    
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="uemail" id="uemail" type="text" class="form-control" required="" value="">                    
                    </div>
                    <div class="form-group">
                        <label>Adress</label>
		                <textarea name="uadd" id="uadd" type="text" class="form-control"></textarea>                  
                    </div>
                </div>
                
                
                <div class="form-group">
                    <input name="utoId" id="utoId" type="hidden" value="">
                    <button type="submit" class="btn btn-primary btn-lg">Send</button> 
                    <input type="hidden" name="ajax" value="1">
                    <input type="hidden" name="SourceForm" value="sampleSend">
                </div>
                
                <div class="errMsg"></div>
            </form>
        </div>
      ';/*
                    <input type="submit" value="Send" class="btn btn-primary btn-lg">*/
        
      return  $html;
    }
    
	function sampleById($sampleId)
	{
		$ExtraQryStr = "sampleId=".addslashes($sampleId);
		return $this->connect->selectSingle(TBL_SAMPLE, "*", $ExtraQryStr);
	}
	function sampleByproductId($productId)
	{
		$ExtraQryStr = "proId=".addslashes($productId);
		return $this->connect->selectSingle(TBL_SAMPLE, "*", $ExtraQryStr);
	}
	function sampleQtyById($sampleId)
	{
		$ExtraQryStr = "sampleId=".addslashes($sampleId)." order by sampleId desc";
		return $this->connect->selectSingle(TBL_SAMPLE, "*", $ExtraQryStr);
	}
    
	function sampleCount($ExtraQryStr)
	{
		return $this->connect->rowCount(TBL_SAMPLE, 'sampleId', $ExtraQryStr); 
	}
    
	function getSampleBypermalink($permalink)
	{	
        /*$ExtraQryStr = "tc.permalink='".addslashes($permalink)."' and tp.userId=tc.userId and tp.sampleId=tc.sampleId";
		$fieldList   = "tc.*,tp.qtyId,tp.sampleId,tp.ct,tp.inStock,tp.entryDate";
		return $this->connect->selectSingle(TBL_SAMPLE." tc, ".TBL_SAMPLE_QTY." tp", $fieldList, $ExtraQryStr); */
     		
		$ExtraQryStr = "permalink='".addslashes($permalink)."' and status='Y'";
		return $this->connect->selectSingle(TBL_SAMPLE, "*", $ExtraQryStr); 		

        
	}
    
    function getSampleQty($ExtraQryStr, $start, $limit)
	{ 
        $ExtraQryStr .= " order by entryDate desc ";
        return $this->connect->selectMulti(TBL_SAMPLE_QTY, "*", $ExtraQryStr, $start, $limit); 
	}
    
    function getSampleHistory($ExtraQryStr, $start, $limit)
	{ 
        $ExtraQryStr .= " order by contactEntrydate desc ";
        return $this->connect->selectMulti(TBL_CONTACT, "*", $ExtraQryStr, $start, $limit); 
	}
    
    function viewhistory($uid,$pId){
        
        $ExtraQryStr = "c.contactID='".addslashes($pId)."' and p.proId=c.proId";
		$fieldList   = "c.*,p.productName";
		$histyData   = $this->connect->selectSingle(TBL_CONTACT." c, ".TBL_SAMPLE." p", $fieldList, $ExtraQryStr); 
        
        
        $html.='<div class="h-box-100 relative">
                    <div class="h-heading">View History</div>
                        <div class="clear"></div>
                            <div class="h-table">
                                <span class="formClose">X</span><div class="col-md-12">';
        $html.='<div class=""> Request #: '.$histyData['requestId'].'</div>
        
        <fieldset class="mt0 shp_add"><legend>Shipping Address</legend>
                <div class="form-group">
                    <label>Name</label> <span>'.$histyData['name'].'</span>
                </div>
                <div class="form-group">
                    <label>Email</label> <span>'.$histyData['email'].'</span>
                </div>
                <div class="form-group">
                    <label>Phone</label> <span>'.$histyData['phone'].'</span>
                </div>
                <div class="form-group">
                    <label>Address</label> <span>'.$histyData['address'].'</span>
                </div>
                <div class="form-group">
                    <label>State of origin</label> <span>'.$histyData['country'].'</span>
                </div>
                <div class="form-group">
                    <label>State</label> <span>'.$histyData['state'].'</span>
                </div>
                <div class="form-group">
                    <label>City</label> <span>'.$histyData['city'].'</span>
                </div>
                <div class="form-group">
                    <label>Zip</label> <span>'.$histyData['zip'].'</span>
                </div>
            </fieldset>';
        
        return $html;
        
        
    }
    
    
    function getSample($ExtraQryStr, $start, $limit)
	{ 
        $ExtraQryStr .= " order by entryDate desc ";
        return $this->connect->selectMulti(TBL_SAMPLE, "*", $ExtraQryStr, $start, $limit); 
	}
    
	function getLastsampleQty($ExtraQryStr)
	{
		return $this->connect->selectSingle(TBL_SAMPLE_QTY, "*", $ExtraQryStr);
	}
        
    function showqtyadd($id_user,$valP)
    { 
        $html.='<div class="h-box-100 relative">
                    <div class="h-heading">Add Qty</div>
                    <div class="clear"></div>
                    <div class="h-table"> <span class="formClose">X</span> 
        <div class="col-md-12"><form id="addQty" class="forma" onsubmit="return false;" enctype="multipart/form-data">';
        $html.='<div class="form-group relative">
        </div>';	
        $html.='
        <div class="form-group qti">
        <label>*Quantity</label>
         <input name="qty" id="qty" type="text" class="form-control qtyinput" required value="'.$data[p_min_quanity].'"/>
        </div>';

        $html.='
        <div class="form-group" style="padding-top: 13px;">
         <input name="userid" id="userid" type="hidden" value="'.$id_user.'" />             
         <input name="sampleId" id="sampleId" type="hidden" value="'.$valP.'" />           
         <input type="submit" value="Save" class="btn btn-primary btn-lg">
         </div>
         <input type="hidden" name="ajax" value="1">
         <input type="hidden" name="SourceForm" value="addQty">';	
        $html.='<div class="errMsg"></div></form></div></div>    
        </div>';		 	
        echo $html;											
    }
        
    /*------------------SAMPLE--------------------------------*/
    
    
    function readbooking($id_user, $ofcUse, $start, $limit)
    {
        $ENTITY = TBL_BOOKING." b JOIN ".TBL_OFFICE." o ON (b.id_office = o.id_office)";
        $ExtraQryStr = "b.id_user=".addslashes($id_user)." ORDER BY b.startTime";
       
        $bookingData = $this->connect->selectMulti($ENTITY, "b.*, o.office", $ExtraQryStr, $start, $limit);
                
        $f          = 0;
        $c          = 1;
        $q          = 1;
        $usageHr    = 0;

        if($bookingData) {
            $html.= '<table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Office</th>
                                <th>Status</th>
                                <th>Mesage</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Usage</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>';


            foreach($bookingData as $data)
            {	
                $f++;

                if($q==6)
                {
                    $c++;
                    $q=0;
                }
                /*if($c==1)
                {
                    $disp='';
                }
                else
                {
                    $disp='display:none;';
                }*/

                if($data[book_status]==0)
                {
                    $book_status='<span class="text-danger"><b>In progress</b></span>';
                }
                elseif($data[book_status]==1)
                {
                    $book_status='<span class="text-success"><b>Booked</b></span>';
                }
                else
                {
                    $book_status='<span class="text-danger"><b>Rejected</b></span>';
                }

                
                $startTime  = (strtotime($data[startTime])>0)? date('h:i A', strtotime($data[startTime])):'-';
                $hour       = ($data[hour]>0)? $data[hour].' hr(s)':'-';

                $usageHr    += $data[hour]; 

                $html.='<tr class="tbl_'.$c.' alltr" style="'.$disp.'">
                    <td>'.$f.'</td>
                    <td>'.$data[office].'</td>
                    <td>'.$book_status.'</td>
                    <td> <a id="'.$data[id_booking].'" class="ticket_booking" style="cursor:pointer"><button type="button" class="btn btnmsg" data-toggle="tooltip" data-placement="top" title="Booking ticket request">
                        <span class="glyphicon glyphicon-comment" aria-hidden="true"></span></button></a><!-- <a id="'.$data[id_booking].'" class="remove_booking" style="cursor:pointer"><button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Delete">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></a>--></td>

                    <td>'.date('M j, Y', strtotime($data[datum_from])).'</td>
                    <td>'.$startTime.'</td>
                    <td>'.$hour.'</td>';

                if(strtotime($data[datum_from])>time() && !$data['book_status']){
                    if(!$data['isConfirmed']){
                        $html .= '<td><button type="button" data-id="'.$data[id_booking].'" title="Edit Schedule" class="btn btnmsg edtbk"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button></td>';	

                        $html .= '<td><button type="button" data-id="'.$data[id_booking].'" title="Confirm Schedule" class="btn btn-primary cnfbk">Confirm</button></td>';
                    }
                    else{
                        $html .= '<td></td><td></td>';	
                    }
                }
                else{
                    $html .= '<td></td><td></td>';	
                }

                $html .= '</tr>';
            }

            if($usageHr){

                $html.='<tr class="usgsum"><td colspan="5">Note:- Allowed hours per month: '.$ofcUse.' hrs.</td><td>Total Usage</td><td>'.$usageHr.' hr(s)</td><td colspan="2"></td></tr>';
            }

            $html.='</tbody></table>';
            return $html;
        }
    }
        
    function userconfirmbook($id_booking)
    {        
        $ExtraQryStr1   = " id_user=".$_SESSION['FUSERID']." and id_booking=".addslashes($id_booking)." AND isConfirmed = '0' AND book_status = 0";
        $dataQ         = $this->connect->selectSingle(TBL_BOOKING, "*", $ExtraQryStr1);    
       
        if(sizeof($dataQ)>0){ 
            $error      = 0;
            $gitem  = $this->get_general_info($_SESSION['FUSERID']);
        }
        else
            $res['error'] = 'Something went wrong. Please close window and try again.';

        if($error)
            echo json_encode($res);
        else{
            $sqlO       = "id_office=".addslashes($dataQ['id_office']);
            $dataO      = $this->connect->selectSingle(TBL_OFFICE, "*", $sqlO);    
            
            $res['startDate']   = date('M j, Y', strtotime($dataQ['datum_from']));
            $res['startTime']   = date('h:i A', strtotime($dataQ['startTime']));
            $res['hour']        = $dataQ['hour'];
            $res['ofcUse']      = $gitem['ofcUse'];
            $res['office']      = $dataO['office'];
            
            echo json_encode($res);
        }     
    }
    
    function setconfirmbook() {
        $id_booking = $_REQUEST['id_booking'];
        $hour       = $_REQUEST['hour'];

        $ExtraQryStr1   = " id_user=".$_SESSION['FUSERID']." and id_booking=".addslashes($id_booking)." AND isConfirmed = '0' AND book_status = 0";
        $dataQ         = $this->connect->selectSingle(TBL_BOOKING, "*", $ExtraQryStr1); 
        
        if(sizeof($dataQ)>0){
            $error      = 0;
            $params = array();
            $params['isConfirmed'] = '1';
            $CLAUSE = "id_user=".$_SESSION['FUSERID']." AND id_booking = ".addslashes($id_booking);
        }
        else{
            $error        = 1;
            $res['error'] = 'Something went wrong. Please close window and try again.';
        }
        
        if($error)
            echo json_encode($res);
        else{
            
            $result = $this->connect->updateQuery(TBL_BOOKING, $params, $CLAUSE);

            $res['success'] = 'Done. Please wait...';
            echo json_encode($res);
        }

    }
    
    function addbook() 
    {
        $id_office  = $_REQUEST['id_office'];

        $startDateArr  = $_REQUEST['startDate'];
        $startTimeArr  = $_REQUEST['startTime'];

        $hourArr       = $_REQUEST['hour'];
        $people        = $_REQUEST['people'];

        $error      = 0;
        $errorMsg   = array();

        $gitem      = $this->get_general_info($_SESSION['FUSERID']);

        $plan_start = $gitem['plan_start'];
        $plan_end   = $gitem['plan_end'];

        $ofcUse     = $gitem['ofcUse'];
        $mjesec     = $gitem['mjesec'];

        $sqlArr = array();

        foreach($startDateArr as $key=>$startDate){
            if(strtotime($startDate)>0){

                $hour       = $hourArr[$key];

                $startTime  = date('Y-m-d H:i:s', strtotime($startDate.' '.$startTimeArr[$key]));
                $endTime    = date('Y-m-d H:i:s', strtotime($startTime.' + '.$hour.' hour'));

                $datum_from = date('Y-m-d', strtotime($startTime));
                
                if(strtotime($datum_from) >= strtotime($plan_start) && strtotime($datum_from) <= strtotime($plan_end)){
                    if($hour && $startTimeArr[$key]){
                      
                        $datetime1  = new DateTime($plan_start);
                        $datetime2  = new DateTime($datum_from);
                        $interval   = $datetime1->diff($datetime2);
                        $y          = $interval->format('%y');
                        $m          = $interval->format('%m');
                        $d          = $interval->format('%d');                    

                        if(!$y){

                            if($d)
                                $diff = $m + 1;
                            else
                                $diff = $m;

                            if(!$diff)
                                $diff = 1;

                            $plan_span  = date('Y-m-d', strtotime($plan_start.' + '.$diff.' month'));

                            $ExtraQryStrB1 = "id_user='".$_SESSION['FUSERID']."' AND datum_from >= '".$plan_start."' AND datum_from <= '".$plan_span."'";
                            
                            $data = $this->connect->selectSingle(TBL_BOOKING, "SUM(hour) AS totalHour", $ExtraQryStrB1);
                            
                            $totalHour  = $data['totalHour'] + $hour;
                            $totalAllowedHour = $ofcUse * $diff;

                            if($totalHour <= $totalAllowedHour){
                               
                                $check_span  = date('Y-m-d', strtotime($plan_start.' + '.$diff.' month'));
                                
                                for($diff = $diff +1; $diff <= $mjesec; $diff++){
                                    $plan_span     = date('Y-m-d', strtotime($plan_span.' + 1 day'));
                                    
                                    $ExtraQryStr = "id_user='".$_SESSION['FUSERID']."' AND datum_from >= '".$plan_span."' AND datum_from <= '".$check_span."'";
                                    $chkdata = $this->connect->selectSingle(TBL_BOOKING, "SUM(hour) AS totalHour", $ExtraQryStr);
                                    
                                    if($chkdata['totalHour']>0){
                                        $error              = 1;
                                        $errorMsg['msg']    = 'Future schedule exists under '.date('M j, Y', strtotime($plan_span)).' ~ '.date('M j, Y', strtotime($check_span)).' window. So booking not possible for '.date('M j, Y', strtotime($datum_from)).'.';
                                        break;
                                    }
                                    else{
                                        $plan_span  = $check_span;
                                        $check_span = date('Y-m-d', strtotime($check_span.' + 1 month'));
                                    }
                                }

                                if(!$error){
                                    $sqlArr = array();
                                    $sqlArr['datum_from'] = $datum_from;
                                    $sqlArr['id_office']  = $id_office;
                                    $sqlArr['id_user']    = $_SESSION['FUSERID'];
                                    $sqlArr['hour']       = $hour;
                                    $sqlArr['startTime']  = $startTime;
                                    $sqlArr['endTime']    = $endTime;
                                    $sqlArr['people']     = $people;
                                }
                            }
                            else{
                                $error      = 1;
                                $errorMsg['msg'] = 'Please check office usage limit per month.';
                            }
                         }
                        else{
                            $error      = 1;
                            $errorMsg['msg'] = 'Selected date '.date('M j, Y', strtotime($datum_from)).' is out of your membership plan window.';
                        }
                   }
                    else{
                        $error      = 1;
                        $errorMsg['msg'] = 'Please select duration (hour) for '.date('M j, Y', strtotime($datum_from));
                    }
                }
                else {
                    $error      = 1;
                    $errorMsg['msg'] = 'Selected date '.date('M j, Y', strtotime($datum_from)).' is out of your membership plan window.';
                }
            }
            else{
                $error      = 1;
                $errorMsg['msg'] = 'Please select date.';
            }
        }
        if(!$error && sizeof($sqlArr)>0){     
               $this->connect->insertQuery(TBL_BOOKING, $sqlArr);
            echo 1;
        }else{
            echo json_encode($errorMsg);
        }
    }
    
    function editbook($id_booking)
    {
        $ExtraQryStr1   = " id_user=".$_SESSION['FUSERID']." and id_booking=".addslashes($id_booking)." AND isConfirmed = '0'";
        $dataQ         = $this->connect->selectSingle(TBL_BOOKING, "*", $ExtraQryStr1);
        
        if(sizeof($dataQ)>0)
        {
            $error      = 0;
            $datum_from = $dataQ['datum_from'];
            $gitem      = $this->get_general_info($_SESSION['FUSERID']);
            $plan_start = $gitem['plan_start'];
            $plan_end   = $gitem['plan_end'];

            $ofcUse     = $gitem['ofcUse'];
            $mjesec     = $gitem['mjesec'];
            
            $datetime1  = new DateTime($plan_start);
            $datetime2  = new DateTime($datum_from);
            $interval   = $datetime1->diff($datetime2);

            $m          = $interval->format('%m');
            $d          = $interval->format('%d');
            
            if($d)
                $diff = $m + 1;
            else
                $diff = $m;

            if(!$diff)
                $diff = 1;

            $plan_span  = date('Y-m-d', strtotime($plan_start.' + '.$diff.' month'));
            $check_span = date('Y-m-d', strtotime($plan_span.' + 1 month'));
            
            for($diff = $diff +1; $diff <= $mjesec; $diff++){
                $plan_span     = date('Y-m-d', strtotime($plan_span.' + 1 day'));              
                
                $ExtraQryStr = "id_user='".$_SESSION['FUSERID']."' AND datum_from >= '".$plan_span."' AND datum_from <= '".$check_span."'";
                $chkdata = $this->connect->selectSingle(TBL_BOOKING, "SUM(hour) AS totalHour", $ExtraQryStr);
                
                if($chkdata['totalHour']>0){
                    $error              = 1;
                    $res['error']      = 'Future schedule exists under '.date('M j, Y', strtotime($plan_span)).' ~ '.date('M j, Y', strtotime($check_span)).' window. So you can not edit schedule for '.date('M j, Y', strtotime($datum_from)).'.';
                    break;
                }
                else{
                    $plan_span  = $check_span;
                    $check_span = date('Y-m-d', strtotime($check_span.' + 1 month'));
                }
            }
        }
        else
            $res['error'] = 'Something went wrong. Please close window and try again.';
        
        if($error)
            echo json_encode($res);
        else{
            
            
            $sqlO       = " id_office=".$dataQ['id_office'];
            $dataO      = $this->connect->selectSingle(TBL_OFFICE, "*", $sqlO);

            $res['startDate']   = date('d-m-Y', strtotime($dataQ['datum_from']));
            $res['startTime']   = date('h:i A', strtotime($dataQ['startTime']));
            $res['hour']        = $dataQ['hour'];
            $res['ofcUse']      = $gitem['ofcUse'];
            $res['office']      = $dataO['office'];

            echo json_encode($res);
        }

    }
    
    function updatebook() 
    {
        $id_booking = $_REQUEST['id_booking'];
        $startTime  = $_REQUEST['startTime'];
        $datum_from = $_REQUEST['startDate'];
        $hour       = $_REQUEST['hour'];
        
        $ExtraQryStr1   = " id_user=".$_SESSION['FUSERID']." and id_booking=".addslashes($id_booking)." AND isConfirmed = '0'";
        $dataQ         = $this->connect->selectSingle(TBL_BOOKING, "*", $ExtraQryStr1);
        
        if(sizeof($dataQ)>0)
        {
            $error      = 0;

            $gitem  = $this->get_general_info($_SESSION['FUSERID']);
            $plan_start = $gitem['plan_start'];
            $plan_end   = $gitem['plan_end'];

            $ofcUse     = $gitem['ofcUse'];
            $mjesec     = $gitem['mjesec'];

            if(strtotime($datum_from) >= strtotime($plan_start) && strtotime($datum_from) <= strtotime($plan_end)){
                $datetime1  = new DateTime($plan_start);
                $datetime2  = new DateTime($datum_from);
                $interval   = $datetime1->diff($datetime2);

                $m          = $interval->format('%m');
                $d          = $interval->format('%d');

                if($d)
                    $diff = $m + 1;
                else
                    $diff = $m;

                if(!$diff)
                    $diff = 1;

                $plan_span  = date('Y-m-d', strtotime($plan_start.' + '.$diff.' month'));
                $check_span = date('Y-m-d', strtotime($plan_span.' + 1 month'));

                for($diff = $diff +1; $diff <= $mjesec; $diff++){
                    $plan_span     = date('Y-m-d', strtotime($plan_span.' + 1 day'));

                  /*  $chksql        = "SELECT SUM(hour) as totalHour FROM tbl_booking WHERE id_user='".$_SESSION['id_user']."' AND datum_from >= '".$plan_span."' AND datum_from <= '".$check_span."' AND id_booking <> ".addslashes($id_booking);

                    $dbquery    = new DbQuery($chksql);
                    $result     = $dbquery->query();
                    $chkdata    = $dbquery->fetchassoc();*/
                    
                    $ExtraQryStr = "id_user='".$_SESSION['FUSERID']."' AND datum_from >= '".$plan_span."' AND datum_from <= '".$check_span."'";
                    $chkdata = $this->connect->selectSingle(TBL_BOOKING, "SUM(hour) AS totalHour", $ExtraQryStr);

                    if($chkdata['totalHour']>0){
                        $error             = 1;
                        $res['error']      = 'Future schedule exists under '.date('M j, Y', strtotime($plan_span)).' ~ '.date('M j, Y', strtotime($check_span)).' window. Please select other date.';
                        break;
                    }
                    else{
                        $plan_span  = $check_span;
                        $check_span = date('Y-m-d', strtotime($check_span.' + 1 month'));
                    }
                }

                if(!$error){         

                    if(!$y){

                        if($d)
                            $diff = $m + 1;
                        else
                            $diff = $m;

                        if(!$diff)
                            $diff = 1;

                        $plan_span  = date('Y-m-d', strtotime($plan_start.' + '.$diff.' month'));
                        
                        $ExtraQryStr = "id_user='".$_SESSION['FUSERID']."' AND datum_from >= '".$plan_start."' AND datum_from <= '".$plan_span."' AND id_booking != ".addslashes($id_booking);
                        $datah = $this->connect->selectSingle(TBL_BOOKING, "SUM(hour) AS totalHour", $ExtraQryStr);

                        $totalHour          = $datah['totalHour'] + $hour;
                        $totalAllowedHour   = $ofcUse * $diff;

                        if($totalHour <= $totalAllowedHour){
                            $startTime  = date('Y-m-d H:i:s', strtotime($datum_from.' '.$startTime));
                            $endTime    = date('Y-m-d H:i:s', strtotime($startTime.' + '.$hour.' hour'));

                            $params = array();
                            $params['datum_from']  = addslashes(date('Y-m-d', strtotime($datum_from)));
                            $params['startTime']    = $startTime;
                            $params['endTime']    = $endTime;
                            $params['hour']       = $hour;
                            $CLAUSE = "id_user=".$_SESSION['FUSERID']." AND id_booking = ".addslashes($id_booking);
                        }
                        else{
                            $error      = 1;
                            $res['error'] = 'Please check office usage limit per month.';
                        }
                    }
                    else{
                        $error      = 1;
                        $res['error'] = 'Selected date '.date('M j, Y', strtotime($datum_from)).' is out of your membership plan window.';
                    }
                }
            }
            else{
                $error        = 1;
                $res['error'] = 'Selected date '.date('M j, Y', strtotime($datum_from)).' is out of your membership plan window.';
            }
            
        }
        else{
            $error        = 1;
            $res['error'] = 'Something went wrong. Please close window and try again.';
        }

        if($error)
            echo json_encode($res);
        else{
            /*
            $dbquery    = new DbQuery($updatesql);
            $result     = $dbquery->query();*/
            $result = $this->connect->updateQuery(TBL_BOOKING, $params, $CLAUSE);
            $res['success'] = 'Data updated successfully. Please wait...';
            echo json_encode($res);
        }

    }
    
    function monthlyUsage($id_user, $plan, $plan_start, $plan_end, $mjesec, $ofcUse)
    {
        if($mjesec){
            $html = '<table class="table table-striped">
                <thead>
                    <th>#</th>
                    <th>Monthly Window</th>
                    <th align="center">Allowed Hours</th>
                    <th align="center">Hours Used</th>
                    <th align="center">Available</th>
                </thead>
                <tbody>';

            $mss = date('M j, Y', strtotime($plan_start));

            $totalOfcUse = $totalUsedHr = $totalAvlHr = 0;

            for($loop = 0; $loop < $mjesec; $loop++) {
                $mss = date('M j, Y', strtotime($mss));
                $mse = date('M j, Y', strtotime($plan_start.' + '.($loop+1).' month'));
                
                
                $ExtraQryStr = "id_user='".$id_user."' AND datum_from >= '".date('Y-m-d', strtotime($mss))."' AND datum_from <= '".date('Y-m-d', strtotime($mse))."'";
                $data = $this->connect->selectSingle(TBL_BOOKING, "SUM(hour) as totalHour", $ExtraQryStr);
                

                $totalHour  = ($data['totalHour'])? $data['totalHour'].' hr(s)':'-';
                $hrLeft     = $ofcUse - $data['totalHour'];

                $available  = ($hrLeft>0)? $hrLeft.' hr(s)':'-';

                $html       .= '
                    <tr>
                        <td>'.($loop+1).'</td>
                        <td>'.$mss.' ~ '.$mse.'</td>
                        <td align="center">'.$ofcUse.' hrs</td>
                        <td align="center">'.$totalHour.'</td>
                        <td align="center">'.$available.'</td>
                    </tr>';
                $mss = date('M j, Y', strtotime($mse.' + 1 day')); 

                $totalOfcUse += $ofcUse;
                $totalUsedHr += $totalHour;
                $totalAvlHr  += $hrLeft;
            }

            $html.='<tr class="usgsum">

                <td colspan="2">'.strtoupper($plan).' Membership ('.date('M j, Y', strtotime($plan_start)).' ~ '.date('M j, Y', strtotime($plan_end)).')</td>
                <td align="center">'.$totalOfcUse.' hrs</td>
                <td align="center">'.$totalUsedHr.' hr(s)</td>
                <td align="center">'.$totalAvlHr.' hr(s)</td>
            </tr>';

            $html .= '</tbody></table>';

            return $html;
        }
    }
    function geocode($address)
    {
        // url encode the address
        $address = urlencode($address);

        // google map geocode api url
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyDFD-m9c8XJHazAEsE_pUafUAiPCFnUbmE";

        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $resp = json_decode($resp_json, true);

        // response status will be 'OK', if able to geocode given address 
        if($resp['status']=='OK'){

            // get the important data
            $lati = $resp['results'][0]['geometry']['location']['lat'];
            $longi = $resp['results'][0]['geometry']['location']['lng'];
            $formatted_address = $resp['results'][0]['formatted_address'];

            // verify if data is complete
            if($lati && $longi && $formatted_address){

                // put the data in the array

                $item=array('latoff'=>$lati,'longoff'=>$longi);
            return $item;

            }else{
                return false;
            }

        }else{
            return false;
        }
    }
    
    
    function checkusr()
    {
        $msg=1;
        $username=$_REQUEST['username'];
        $email=$_REQUEST['email'];	
        $phone=$_REQUEST['phone'];
        $company=$_REQUEST['company'];
        $password=$_REQUEST['password'];
        
        $ExtraQryStr = "username='".$username."'";
        $data        = $this->connect->selectMulti(TBL_MEMBER, "*", $ExtraQryStr);
        
        if(sizeof($data)>0){            
            $msg=2;
            echo $msg;
            exit();
        }        
        $ExtraQryMl = "email='".$email."'";
        $dataEm     = $this->connect->selectMulti(TBL_MEMBER, "*", $ExtraQryMl);
        
        if(sizeof($dataEm)>0){  
            $msg=3;
            echo $msg;
            exit();
        }      
        $ExtraQryPh = "phone='".$phone."'";
        $dataPh     = $this->connect->selectMulti(TBL_MEMBER, "*", $ExtraQryPh);
        
        if(sizeof($dataPh)>0){  
            $msg=4;
            echo $msg;
            exit();
        }     
        $ExtraQryCm = "company_name='".$company."'";
        $dataCm     = $this->connect->selectMulti(TBL_MEMBER, "*", $ExtraQryCm);
        
        if(sizeof($dataCm)>0){  
            $msg=5;
            echo $msg;
            exit();
        } 	
        
        $gObj = new genl();
        if($gObj->validate_alphanumeric($password)){ 
            $ok='ok';
        }
        else{
            $msg=6;
        }
        
        
        echo $msg;	
    }    
    
    function adduser()
    {
        $tmp_ses       =uniqid();
        $id_office     =$_REQUEST['office_name'];
        $name          =$_REQUEST['name'];
        $surname       =$_REQUEST['surname'];
        $username      =$_REQUEST['username'];
        $password      =$_REQUEST['password'];
        $country       =$_REQUEST['country'];
        $address       =$_REQUEST['address'];
        $state         =$_REQUEST['state'];
        $city          =$_REQUEST['city'];
        $zip           =$_REQUEST['zip'];
        $phone         =$_REQUEST['phone'];
        $email         =$_REQUEST['email'];
        $plan          =$_REQUEST['blankRadio'];
        $mjesec        =$_REQUEST['blankRadioA'];
        $company       =$_REQUEST['company'];
        $pass          =md5($password);
        $ori_password  =$password;
        $stat          =1;

        $datum_start   =date('Y-m-d');

        $total         = $_SESSION['pkgArr'][$plan]['price'] * $mjesec;

        if($plan=='standard')
        {        
            if($mjesec==15)
                $total=79;
        }

        $uData = array();
        $uData['publicId']  = time();
        $uData['name']      = $name;
        $uData['surname']   = $surname;
        $uData['username']  = $username;
        $uData['password']  = $pass;
        $uData['ori_password']  = $ori_password;
        $uData['pos']       = 2;
        $uData['country']   = $country;
        $uData['address']   = $address;
        $uData['state']     = $state;
        $uData['city']      = $city;
        $uData['zip']       = $zip;
        $uData['createDate']= date("Y-m-d H:i:s");
        $uData['phone']     = $phone;
        $uData['email']     = $email;
        $uData['status']    = $stat;
		$uData['usertype'] = 'Buyer';

        $this->connect->insertQuery(TBL_MEMBER, $uData);

        $ExtraQryStr = "1 order by id desc";
        $data        = $this->connect->selectSingle(TBL_MEMBER,'*',$ExtraQryStr);
        
        $ExtraQryStr = "name='".$plan."'";
        $plandata    = $this->connect->selectSingle(TBL_PACKAGE,'*',$ExtraQryStr);

        $id_user    = $data['id'];
        $user_email = $data['email'];

        $pyData = array();
        $pyData['id_user']      = $id_user;
        $pyData['id_office']    = $id_office;
        $pyData['plan']         = $plan;
        $pyData['mjesec']       = $mjesec;
        $pyData['datum_start']  = $datum_start;
        $pyData['ofcUse']       = $_SESSION['pkgArr'][$plan]['ofcUse'];
        $pyData['tmp_ses']      = $tmp_ses;

        $this->connect->insertQuery(TBL_PAY, $pyData);

        $ExtraQryStrP = "1 order by id_pay desc";
        $dataP        = $this->connect->selectSingle(TBL_PAY,'*',$ExtraQryStrP);

        $idpay    = $dataP['id_pay'];


        $params            = array();
        $params['id_user'] = $id_user;

        $this->connect->insertQuery(TBL_EMAIL, $params);

                
        //permalink--------------
        $ENTITY      = TBL_COMPANY;
        $ppermalink  = $company;		
        $cpermalink  = createPermalink($ENTITY, $ppermalink, 1);
        //permalink---------------	
        
        
        $params                 = array();
        $params['user_id']      = $id_user;
        $params['companyname']  = $company;
        $params['permalink']    = $cpermalink;
        $params['add_date']     = date("Y-m-d H:i:s");

        $this->connect->insertQuery(TBL_COMPANY, $params);

        $params                 = array();
        $params['id_user']      = $id_user;
        $params['tmp_ses']      = $tmp_ses;

        $this->connect->insertQuery(TBL_CONTRACT, $params);

        $ExtraQryStrO = "id_office=".$id_office;
        $datao        = $this->connect->selectSingle(TBL_OFFICE,'*',$ExtraQryStrO);

        $to         = 'ria@eclick.co.in';//admin@annexis.net
        $from       = "From: ".SITE_NAME."<order@annexis.net>";
        $subject    = 'New Order';	

        if($plan!='standard')
            $Offc= $datao['office'].", ".$datao['office_city'];
        
        $message .='<table width="100%" style="background:#fff; border:none; border-collapse:collapse; margin:0 auto;">
                    <tr>
                    <td style="padding:35px 25px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#686767;">
                    <table style="width:100%; border:none; border-collapse:collapse;">
                    
                    <tr>
                            <td style="vertical-align:top;">
                                <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800; line-height: normal">New Order From '.$name.' '.$surname.'</div>
                                <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div>';
                    if($Offc){
                       $message .='<div style="padding:0 0 10px;"><strong>Office</strong>: '.$Offc.'</div>'; 
                    } 
           
       $message .='<div style="padding:0 0 10px;"><strong>Package Ordered</strong> :'.strtoupper($plan).'</div></td>
                  </tr>                    
                  <tr>
                    <td style="vertical-align:top;">
                            <table style="width:100%; border:none; border-collapse:collapse;">
                                <tr>
                                    <td style="vertical-align:top; width:247px; text-align:center; padding-top:3px;">
                                        <img src="'.TMP.'/assets/images/box-top.png" width="247" height="14" alt="top" style="display:block;">
                                        <div style="border-left:3px solid #dedddd; border-right:3px solid #dedddd;">
                                            <div style="padding:15px 0;">
                                                <img src="'.SHWFL.'/package/large/'.$plandata['image'].'" width="70" height="70" alt="'.$plan.'">
                                            </div>
                                            <div style="font-size:24px; color:#3289ae; font-weight:bold; padding-bottom:3px;">'.strtoupper($plan).' Membership Package</div>
                                            <div style="font-size:16px; color:#2c2c2c; font-weight:bold; padding-bottom:15px;">'.strtoupper($mjesec).' Months</div>
                                        </div>
                                        <img src="'.TMP.'/assets/images/box-bottom.png" width="247" height="14" alt="bottom" style="display:block;">
                                    </td>

                                    <td style="vertical-align:top; padding-left:20px;">
                                        <div style="font-size:18px; font-weight:bold; color:#000; padding-bottom:16px;">Package Benefits</div>
                                        <table style="width:100%; border:none; border-collapse:collapse;">
                                            '.$plandata['contractDesc'].'
                                        </table>
                                    </td>
                                </tr>
                            </table>
        </td></tr></table></td></tr></table>';
        
        sendEmail($to, $from, $subject, $message);


        $contractlnk=SITELOC.'/register/contractsign?validation='.$tmp_ses;

        //$email_to='site-control@eclickapps.com';
        $email_to=$user_email;

        $email_subject = "Contract link"; // The Subject of the email
        
        $email_txt .='
        <table width="100%" style="background:#fff; border:none; border-collapse:collapse; margin:0 auto;">
                    <tr>
                    <td style="padding:35px 25px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#686767;">
                    <table style="width:100%; border:none; border-collapse:collapse;">
                    
                    <tr>
                            <td style="vertical-align:top;">
                                <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800; line-height: normal">Welcome to Annexis.net Business Solutions</div>
                                <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div>';
        
            $email_txt .='<div style="padding:0 0 10px;">Dear '.$name.' '.$surname.',</div> 
            <div style="padding:0 0 10px;">Congratulations on your selection for the <span style="font-weight:bold; color:#3289ae;">'.strtoupper($plan).'</span> package.</div>
            <div style="padding:0 0 10px;">We look forward to serving you and providing all your business needs.</div>
            <div style="padding:0 0 10px;">Your account activation and setup is in progress and will be completed upon verification of your payment.</div>
            <div style="padding:0 0 10px;">If you selected Standard plan you have free 30 days Trial.</div>

            <div style="padding:0 0 10px;"><strong>To complete the registration procedure please sign the contract.</strong></div>
            <div style="padding:0 0 40px;text-align: center;"><a href="'.$contractlnk.'" target="_blank" style="display: inline-block; height: 40px; line-height: 40px; padding: 0 30px; background: #1BACEB; color: #fff; font-weight: bold; -webkit-border-radius: 20px; border-radius: 20px; text-decoration: none;">Sign Contract</a></div>
            <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div>';
           $email_txt .='</td>
                        </tr>
                    <tr>
                        <td style="vertical-align:top;">
                                <table style="width:100%; border:none; border-collapse:collapse;">
                                    <tr>
                                        <td style="vertical-align:top; width:247px; text-align:center; padding-top:3px;">
                                            <img src="'.TMP.'/assets/images/box-top.png" width="247" height="14" alt="top" style="display:block;">
                                            <div style="border-left:3px solid #dedddd; border-right:3px solid #dedddd;">
                                                <div style="padding:15px 0;">
                                                    <img src="'.SHWFL.'/package/large/'.$plandata['image'].'" width="70" height="70" alt="'.$plan.'">
                                                </div>
                                                <div style="font-size:24px; color:#3289ae; font-weight:bold; padding-bottom:3px;">'.strtoupper($plan).' Membership Package</div>
                                                <div style="font-size:16px; color:#2c2c2c; font-weight:bold; padding-bottom:15px;">'.strtoupper($mjesec).' Months</div>
                                            </div>
                                            <img src="'.TMP.'/assets/images/box-bottom.png" width="247" height="14" alt="bottom" style="display:block;">
                                        </td>

                                        <td style="vertical-align:top; padding-left:20px;">
                                            <div style="font-size:18px; font-weight:bold; color:#000; padding-bottom:16px;">Package Benefits</div>
                                            <table style="width:100%; border:none; border-collapse:collapse;">
                                                '.$plandata['contractDesc'].'
                                            </table>
                                        </td>
                                    </tr>
                                </table>
        </td></tr></table></td></tr></table>';

        sendEmail($email_to, $from, $email_subject, $email_txt);


        $_REQUEST['idu']=$id_user;
        $_REQUEST['id_pay']=$idpay;
        //include"pdf/pdfprintA.php";

       // $html ='<div class="row paddingtb20"><div class="col-md-12">';

         //if($plan=='standard')
        //{
            
           

          //   $html.='<div class="alert alert-danger" role="alert"> Congratulations for signing the contract with Annexis on package. Please find your signed contract file attached herewith.
 
     // </div>';

           
      //  }
       //  else
        // {
        //   $html.='<div class="alert alert-danger" role="alert"> Congratulations for signing the contract with Annexis on package. Please find your signed contract file attached herewith.

           // </div>';  
        // }

      //  $html.='</div></h1></h></div>';

        //echo $html;

//}
       $html='<div class="container">
  
  
    <!-- Modal -->
    <div id="MyModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    
     <!-- Modal content-->
         <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       
       </div>
       <div class="modal-body">
       <h3 class="alert alert-danger" role="alert">Congratulations for sign up the contract with Annexis on <span style="color: #3289ae; text-transform: uppercase;">'.$plan.' </span> package. Please find your signed contract file attached herewith. </h3>
       </div>
       <div class="modal-footer">

     <a href="http://www.annexis.net" class="btn btn-secondary">ok</a>
        </div>
    </div>
   </div>
  </div>
 </div>';

 $html2='<div class="container">
  
  
    <!-- Modal -->
    <div id="MyModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    
     <!-- Modal content-->
         <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       
       </div>
       <div class="modal-body">
       <h3 class="alert alert-danger" role="alert">Congratulations for signing the contract with Annexis on <span style="color: #3289ae; text-transform: uppercase;">'.$plan.' </span> package. Please find your signed contract file attached herewith. </h3>
       </div>
       <div class="modal-footer">

     <a href="http://www.annexis.net" class="btn btn-secondary">ok</a>
        </div>
    </div>
   </div>
  </div>
 </div>';
    echo '<script>
    jQuery(document).ready(function() {
        jQuery("#MyModal").modal();
    });
    </script>';

 if ($plan =='standard')
    {
    echo $html;
    }

else
    {
   echo $html2;
}
        	    
  }
    
    function getContractInfo($val){
        
        $ExtraQryStr = "tmp_ses='".addslashes($val)."' and sign=0";
        return $this->connect->selectSingle(TBL_CONTRACT, "*", $ExtraQryStr);
    }
    
    function getsampleContractInfo($val){        
        $ENTITY =   TBL_CONTRACT." c 
                    LEFT JOIN ".TBL_SAMPLE." sm ON (c.id_user = sm.sampleId) 
                    LEFT JOIN ".TBL_MEMBER." m ON ( sm.userId = m.id)";
                
        $ExtraQryStr = "c.tmp_ses='".addslashes($val)."' and sign=0";
        
        return $this->connect->selectSingle($ENTITY, "c.*, sm.shippingCharge,sm.shippingCharge1,sm.setUp,sm.scurrency,sm.sampleId,m.name", $ExtraQryStr);	
    }
    
    function generatePDF($sourceUrl, $destinationFile){ 
       shell_exec('xvfb-run -a -s "-screen 0 1024x768x24" wkhtmltopdf "$@" --margin-bottom 20mm --margin-top 7mm '.$sourceUrl.' '.$destinationFile);
    }
    
    function signaturecont()
    {
        $id_contract    = $_REQUEST['id_contract'];
        $img            = $_REQUEST['img'];

        $simg = str_replace('data:image/png;base64,', '', $img);
        file_put_contents(UPFLD.'/contract/sign-'.$id_contract.'.jpg', base64_decode($simg));

        $img_path='sign-'.$id_contract.'.jpg';

        $params      = array();
        $params['img'] = $img_path;
        $params['sign'] = 1;
                
        $CLAUSE = "id_contract=".$id_contract;
        $this->connect->updateQuery(TBL_CONTRACT, $params, $CLAUSE);
                
        $ExtraQryStr = "id_contract=".$id_contract;
        $data = $this->connect->selectSingle(TBL_CONTRACT, '*', $ExtraQryStr); 

        $ExtraQryStrP = "tmp_ses='".$data['tmp_ses']."'";
        $dataP        = $this->connect->selectSingle(TBL_PAY, '*', $ExtraQryStrP);
        
        $plan=$dataP['plan'];
        
        
        $params         = array();
        $params['status'] = 'Y';
        
        $CLAUSE = "id=".$data['id_user'];

        $result = $this->connect->updateQuery(TBL_MEMBER, $params, $CLAUSE);
        
        $ExtraQryStrU = "id='".$data['id_user']."'";
        $dataU        = $this->connect->selectSingle(TBL_MEMBER, '*', $ExtraQryStrU);
        
        $sourceUrl 		= SITELOC.'/dashboard/signpdf/contractsign_pdf?validation='.$data['tmp_ses'];
        $filename       = 'cont-'.$id_contract.'.pdf';
        $filepath       = UPFLD.'/contract/'.$filename;

        $this->generatePDF($sourceUrl, $filepath);

        //$to         = 'site-control@eclickapps.com';
        $to         = $dataU['email'];
        $from       = "From: ".SITE_NAME."<".SITE_EMAIL.">";
        $subject    = 'Signed Contract';	
        $msg        = '<div style="padding-bottom:40px;">Dear <span style="font-weight:bold; color:#3289ae;">'.$dataU['name'].' '.$dataU['surname'].',</span></div>
                        <div style="padding-bottom:17px;">Congratulations for signing the contract with Annexis on <span style="font-weight:bold; color:#3289ae;">'.strtoupper($plan).'</span> package. Please find your signed contract file attached herewith.</div>

                        <div style="padding-bottom:17px; font-weight:bold;">Your account is activated now.</div>
                        
                        <div style="padding-bottom:17px;">Your login credentials:</div>
                        <div style="padding-bottom:17px; line-height:20px;">Username: '.$dataU['username'].'.<br>Password: '.$dataU['ori_password'].'</div>

                        <div style="padding:0 0 22px; text-align: center;">
                            <a href="'.SITELOC.'/login/" style="display: inline-block; height: 40px; line-height: 40px; padding: 0 30px; background: #1BACEB; color: #fff; font-weight: bold; -webkit-border-radius: 20px; border-radius: 20px; text-decoration: none;">Login to Annexis</a>
                        </div>';

        if($plan!='standard'){
            $msg        .= '<div style="padding-bottom:17px;">Account setup is in progress and will be completed upon verification of your payment.</div>

                        <div style="padding-bottom:5px; color:#000; font-weight:bold;">Payment Option # 1:</div>
                        <div style="padding-bottom:17px;">Please use the link below to confirm your order and submit your payment.</div>
                        <div style="padding-bottom:17px; line-height:20px;">Here is the link for Citibank Quick Pay.<br>
                            <a style="color:#1baceb; text-decoration:none;" href="https://www.chase.citibank/online-banking/quickpay">https://www.chase.citibank/online-banking/quickpay</a><br>
                            Send payment to <a style="color:#1baceb; text-decoration:none;" href="payment.annexis@annexis.net">payment.annexis@annexis.net</a>
    </div>
                        <div style="padding-bottom:17px;">Your credit card or bank statement will show a charge from "Annexis.net" (Annexis Business Solutions).</div>
                        <div style="padding-bottom:5px; color:#000; font-weight:bold;">Payment Option # 2:</div>
                        <div style="padding-bottom:17px;">If you choose to process via bank wire, please use the following information to submit wire 
    transfer: </div>
                        <div style="border-bottom:1px solid #c5c5c4; margin-bottom:22px; line-height:0; font-size:0;">&nbsp;</div>
                        <div style="padding-bottom:5px; color:#000; font-weight:bold;">Beneficiary Information:</div>
                        <table style="width:100%; border-collapse:collapse; border:none;" cellspacing="0" cellpadding="0">
                          <tr>
                            <td style="padding:4px 4px 4px 0; vertical-align:top;">Bank Name:</td>
                            <td style="padding:2px; vertical-align:top;">Citibank</td>
                          </tr>
                          <tr>
                            <td style="padding:4px 4px 4px 0; vertical-align:top;">Bank Address:</td>
                            <td style="padding:2px; vertical-align:top; line-height:20px;">1152 U.S. 1 <br> Palm Beach Garden, Florida 33410</td>
                          </tr>
                          <tr>
                            <td style="padding:4px 4px 4px 0; vertical-align:top;">Swift Code:	</td>
                            <td style="padding:2px; vertical-align:top;">CITIUS33</td>
                          </tr>
                          <tr>
                            <td style="padding:4px 4px 4px 0; vertical-align:top;">Bank ABA:</td>
                            <td style="padding:2px; vertical-align:top;">266086554</td>
                          </tr>
                          <tr>
                            <td style="padding:4px 4px 4px 0; vertical-align:top;">Beneficiary Name:</td>
                            <td style="padding:2px; vertical-align:top;">ANNEXIS Business Solutions</td>
                          </tr>
                          <tr>
                            <td style="padding:4px 4px 4px 0; vertical-align:top;">Beneficiary Account No.:</td>
                            <td style="padding:2px; vertical-align:top;">1111111111</td>
                          </tr>
                          <tr>
                            <td style="padding:4px 4px 4px 0; vertical-align:top;">Beneficiary Address: </td>
                            <td style="padding:2px; vertical-align:top; line-height:20px;">121 SE Bella Strano<br>
                        Port St. Lucie, Florida 34984</td>
                          </tr>
                          <tr>
                            <td style="padding:4px 4px 4px 0; vertical-align:top;">Beneficiary Tel. No.:</td>
                            <td style="padding:2px; vertical-align:top;">1(800) 816-9554</td>
                          </tr>
                        </table>';
        }		
        sendEmail($to, $from, $subject, $msg, $filepath, $filename);

	    $msg        = '<div style="padding-bottom:40px;">Dear <span style="font-weight:bold; color:#3289ae;">'.$dataU['name'].' '.$dataU['surname'].',</span></div>
                        <div style="padding-bottom:17px;">Congratulations for signing the contract with Annexis on <span style="font-weight:bold; color:#3289ae;">'.strtoupper($plan).'</span> package. Please find your signed contract file attached herewith.</div>

                        <div style="padding-bottom:17px; font-weight:bold;">Your account is activated now.</div>
                        
                        <div style="padding-bottom:17px;">Your login credentials:</div>
                        <div style="padding-bottom:17px; line-height:20px;">Username: '.$dataU['username'].'.<br>Password: '.$dataU['ori_password'].'</div>

                        <div style="padding:0 0 22px; text-align: center;">
                            <a href="'.SITELOC.'/login/" style="display: inline-block; height: 40px; line-height: 40px; padding: 0 30px; background: #1BACEB; color: #fff; font-weight: bold; -webkit-border-radius: 20px; border-radius: 20px; text-decoration: none;">Login to Annexis</a>
                        </div>';


		echo  '<div class="container">
	
    <!-- Modal -->
    <div id="Modalcredentials_show" class="modal fade" role="dialog">
    <div class="modal-dialog">

     <!-- Modal content-->
         <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>

       </div>
       <div class="modal-body">
       <h3 class="alert alert-danger" role="alert">'. $msg .' </h3>
       
       </div>
       <div class="modal-footer">
     			<a href="http://www.annexis.net" class="btn btn-secondary">ok</a>
        </div>
    </div>
   </div>
  </div>
 </div>';

    echo '<script>
           jQuery(document).ready(function() {
	           jQuery("#Modalcredentials_show").modal();
           });
    </script>';

    }
    
    function signaturesamplecont()
    {
        $id_contract    = $_REQUEST['id_contract'];
        $sampleId       = $_REQUEST['sampleId'];
        $img            = $_REQUEST['img'];
       
        $simg = str_replace('data:image/png;base64,', '', $img);
        file_put_contents(UPFLD.'/samplecontract/sign-'.$id_contract.'.jpg', base64_decode($simg));

        $img_path='sign-'.$id_contract.'.jpg';

        $params                 = array();
        $params['img']          = $img_path;
        $params['sign']         = 1;
        $params['contractFor']  = 'S';
                
        $CLAUSE = "id_contract=".$id_contract;
        $this->connect->updateQuery(TBL_CONTRACT, $params, $CLAUSE);        
        
        $params                 = array();
        $params['isApproved']  = 'Sample Contract Signed';
                
        $CLAUSE = "sampleId=".$sampleId;
        $this->connect->updateQuery(TBL_SAMPLE, $params, $CLAUSE);
                
        $ExtraQryStr = "id_contract=".$id_contract;
        $data = $this->connect->selectSingle(TBL_CONTRACT, '*', $ExtraQryStr); 
        
        
        $ENTITY =   TBL_SAMPLE." s 
                    JOIN ".TBL_MEMBER." m ON (s.userId = m.id)";

        $ExtraQryStr = "s.sampleId=".addslashes($sampleId);         
        $dataU = $this->connect->selectSingle($ENTITY, "s.*, m.name,m.surname,m.email", $ExtraQryStr);
        

        $sourceUrl 		= SITELOC.'/dashboard/signsamplepdf/contractsign_pdf?validation='.$data['tmp_ses'];
        $filename       = 'cont-'.$id_contract.'.pdf';
        $filepath       = UPFLD.'/samplecontract/'.$filename;

        $this->generatePDF($sourceUrl, $filepath);

        //$to         = 'site-control@eclickapps.com';
        $to         = $dataU['email'];
        $from       = "From: ".SITE_NAME."<".SITE_EMAIL.">";
        $subject    = 'Signed Sample Contract';	
        $msg        = '<div style="padding-bottom:40px;">Dear <span style="font-weight:bold; color:#3289ae;">'.$dataU['name'].' '.$dataU['surname'].',</span></div>
                        <div style="padding-bottom:17px;">Congratulations for signing the contract with Annexis on. </div>


                        <div style="padding:0 0 22px; text-align: center;">
                            <a href="'.SITELOC.'/dashboard/" style="display: inline-block; height: 40px; line-height: 40px; padding: 0 30px; background: #1BACEB; color: #fff; font-weight: bold; -webkit-border-radius: 20px; border-radius: 20px; text-decoration: none;">Login to Annexis</a>
                        </div>';
				
        sendEmail($to, $from, $subject, $msg);				
    }
    
    
    function getavoffice()
    {   
        $id = '';
        $ExtraQryStr = "1";
        $dataOf = $this->connect->selectMulti(TBL_PAY, "*", $ExtraQryStr,0,999999);
        foreach($dataOf as $data)
        {
           $id.='id_office!='.$data[id_office].' and '; 
        }
        
        $ExtraQryStrB = "DATE(datum_to)>DATE(NOW()";
        $dataB = $this->connect->selectMulti(TBL_BOOKING, "*", $ExtraQryStrB,0,999999);
        
        foreach($dataB as $data)
        {
            $id.='id_office!='.$data[id_office].' and ';
        }
        
        $id=substr($id,0,-4);
        if($id!='')	
        {
            $sql = $id." order by state_code";
        }
        else
        {
            $sql = "order by state_code";	
        }
        $data = $this->connect->selectSingle(TBL_OFFICE, "*", $sql,0,999999);
        
        $simg=0;
        $posss=strpos($id, 'id_office!='.$dataF[id_office]);
        if ($posss!= false)
        {
            $simg=1;
        }
        

        $item=array('state_code'=>$data[state_code],'office_city'=>$data[office_city],'office_address'=>$data[office],         'people'=>$data[people], 'selectedDate'=>$data[selectedDate], 'startTime'=>$data[startTime], 'endTime'=>$data[endTime], 'showimg'=>$simg);

        return $item;
    }
    
//    function readstate($state)
//    {
//        $ExtraQryStr = " 1";
//		$records = $this->connect->selectMulti(TBL_STATES, "*", $ExtraQryStr, 0, 100);
//
//        foreach($records as $data)
//        {
//            if($data[state_code]==$state)
//            {
//                $sel='selected="selected"';
//            }
//            else
//            {
//                $sel='';
//            }
//            $html.='<option value="'.$data[state_code].'" '.$sel.'>'.$data[state].'</option>';
//        }
//        return $html;
//    }

	function readstate($state)
	{
		$ExtraQryStr = "1";
		$records = $this->connect->selectMulti(TBL_STATES, "*", $ExtraQryStr, 0, 100);

		foreach($records as $data)
		{
			if($data[state_code]=="AK")
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



    function readoffice($state_code,$office_city)
    { 
        $html = '';
        $extQ = "state_code='".$state_code."' GROUP BY office_city order by office_city";
        $offc = $this->connect->selectMulti(TBL_OFFICE, "*", $extQ, 0, 1000);
        
        
        foreach($offc as $data){
             if($data['office_city']==$office_city)
                $fcsel='selected';
            else
                $fcsel='';  
            
            $html.='<option value="'.$data['office_city'].'" '.$fcsel.'>'.$data['office_city'].'</option>';
        }
        echo $html;
    }
    
    function readofficenamebyId($office_name){
        $ExtraQryStr = "id_office=".$office_name;
        return $this->connect->selectSingle(TBL_OFFICE, "*", $ExtraQryStr, 0, 999999);
    }
    
    function readofficename($office_name,$office)
    {   
        $html = '';
        $ExtraQryStr = "office_city='".$office_name."' order by office";
        $records = $this->connect->selectMulti(TBL_OFFICE, "*", $ExtraQryStr, 0, 999999);
        foreach($records as $data){
            
            if($data['office']==$office)
                $oSel = 'selected';
            else
                $oSel = '';
            
            $html.='<option value="'.$data['id_office'].'" '.$oSel.'>'.$data['office'].'</option>';
        }
        echo $html;
    }
    
    function getmap($address)
    { 
        $html = '';
        $ExtraQryStr = "office_city='".$address."' order by office"; 
        $records = $this->connect->selectSingle(TBL_OFFICE, "*", $ExtraQryStr, 0, 999999);
        
        echo $html = $records['office'];
    }

    function get_web_page($url)
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => 'UTF-8',       // handle all encodings
            CURLOPT_USERAGENT      => $_SERVER['HTTP_USER_AGENT'], // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 1200,      // timeout on connect
            CURLOPT_TIMEOUT        => 1200,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }
    
    function getcoordinate($address)
    {
        //$address=$_REQUEST['address'];
        // url encode the address
        $address = urlencode($address);

        // google map geocode api url
        $url = "http://maps.google.com/maps/api/geocode/json?address={$address}";

        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $resp = json_decode($resp_json, true);

        // response status will be 'OK', if able to geocode given address 
        if($resp['status']=='OK'){

            // get the important data
            $lati = $resp['results'][0]['geometry']['location']['lat'];
            $longi = $resp['results'][0]['geometry']['location']['lng'];
            $formatted_address = $resp['results'][0]['formatted_address'];

            // verify if data is complete
            if($lati && $longi && $formatted_address){

                // put the data in the array

            echo $lati.','.$longi;

            }else{
                return false;
            }

        }else{
            return false;
        }	
    }
    
    function readofficeimg($id_office)
    {
        $ExtraQryStr = "id_office=".$id_office;
        $record = $this->connect->selectSingle(TBL_OFFICE, "*", $ExtraQryStr);
        
        if($record['img_office'])
        {
            $imgsrc='<img src="'.SHWFL.'/office/large/'.$record['img_office'].'">';	
        }
        else{
            $matA=$record['office_url'];
            $resultA=$this->get_web_page($matA);

            preg_match_all('/(?<=<img width="650" height="300" class="rsTmb" src=")(.*?)(?=\/><\/a>)/s', $resultA['content'], $name);
            $ime=str_replace('"','',$name[0][0]);
            $img=str_replace('../','http://www.appalmighty.com/appalmightycoder2/',$ime);
            $imgsrc='<img src="'.$img.'">';	            
        }
        echo $imgsrc;
    }
    
    function officeCount($ExtraQryStr){
        return $this->connect->rowCount(TBL_OFFICE, 'id_office', $ExtraQryStr); 
    }
    
    function stateList($ExtraQryStr, $start, $limit)
	{ 
        $ExtraQryStr .= " order by state asc ";
        return $this->connect->selectMulti(TBL_STATES, "*", $ExtraQryStr, $start, $limit); 
	}
    
    function stateByCode($state_code)
	{ 
        $ExtraQryStr = "state_code='".$state_code."'";
        return $this->connect->selectSingle(TBL_STATES, "*", $ExtraQryStr); 
	}
    
    function officeListBystate($ExtraQryStr, $start, $limit)
	{ 
        $ExtraQryStr .= " AND status='Y' order by office_city asc ";
        return $this->connect->selectMulti(TBL_OFFICE, "*", $ExtraQryStr, $start, $limit); 
	}
	function getOfficeBypermalink($permalink)
	{		
		$ExtraQryStr = "permalink='".addslashes($permalink)."' and status='Y'";
		return $this->connect->selectSingle(TBL_OFFICE, "*", $ExtraQryStr); 		
	}
    function gallery_detailsByofficeId($officeId, $start, $limit)
	{		
		$ExtraQryStr = "officeId=".$officeId." and status='Y' order by swapNo desc";				
		return $this->connect->selectMulti(TBL_OFFICE_GALLERY, "*", $ExtraQryStr, $start, $limit);
	}
    function packageList($ExtraQryStr, $start, $limit)
	{ 
        $ExtraQryStr .= " order by packageId asc ";
        return $this->connect->selectMulti(TBL_PACKAGE, "*", $ExtraQryStr, $start, $limit); 
	}
	function getPackageBypermalink($permalink)
	{		
		$ExtraQryStr = "permalink='".addslashes($permalink)."' and status='Y'";
		return $this->connect->selectSingle(TBL_PACKAGE, "*", $ExtraQryStr); 		
	}
}

?>
