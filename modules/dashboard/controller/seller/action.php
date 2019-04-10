<?php
//Update Booking Status --------------------------
if(isset($Save) && $SourceForm == 'AddBooking'){    
    $rObj     	= new MemberAdmin();    
    $params = array();
    $params['book_status'] 			= $book_status;
    $rObj->bookingUpdateById($params, $id);
    
    $ErrMsg 				= '<div class="success">Data updated successfully</div>';    
}
//==========================================================================
if(isset($Save) && $SourceForm == 'ResetPassword')
{
	if($password!='')
	{
		if($email) 
		{
            $obj = new MemberAdmin;
			$sel_Details = $obj->getRecruiterInfoByid($IdToEdit); 
			if(sizeof($sel_Details)>0)
			{
				$params = array();
                $params['password']     = md5($password);
                $params['ori_password'] = addslashes($password);
                
                $obj->recruiterUpdateById($params, $IdToEdit);
                
				$_SESSION['ErrMsg'] = '<div class="success">Data Updated Successfully</div>';	
                
                if($sendmail)
				{
					$to = $email;
					$from="From: Administrator<".SITE_EMAIL.">";
					$subject=SITE_NAME." :: Change Password";
					$msg="Dear Recruiter,<br><br>
					Your password reset successfully.<br><br>
					New Password is : ".$password."<br><br>									 
					<br><br>
					Regards,<br>
					".SITE_NAME;
					sendEmail($to,$from,$subject,$msg);			
				}
                
				$decodedStr = base64_decode($redstr);
				?>
				<script language="javascript">window.location = 'index.php?<?php echo $decodedStr?>';</script>
				<?php 				
			}
			else
				$ErrMsg = '<div class="error">Incorrect Email.</div>';			
		}
		else
			$ErrMsg = '<div class="error">Email field is empty.</div>';		
	}
	else
		$ErrMsg = '<div class="error">Password field is empty.</div>';
}
//-----------------------------------------
elseif(isset($Save) || isset($SaveNext) && $SourceForm == 'AddRecruiter'){
	$rObj     	= new MemberAdmin();
	$gObj 		= new genl();

    if($fullname && $aboutMe && $phone && $email) {
        
        if($gObj->validate_email($email)) {

            if($IdToEdit)
                $ExtraQryStr = 'id!='.$IdToEdit;
            else
                $ExtraQryStr = 1;
            
            $exist = $rObj -> checkExistenceByEmail($email, $ExtraQryStr);
            
            if(!$exist){
                
                if(strlen($password)>=8 || $IdToEdit) {

                    if($gObj->validate_alpha($password) || $IdToEdit){

                        if($password==$cnfrm_password || $IdToEdit){

                            $params = array();
                            $params['fullname'] 			= $fullname;
                            $params['gender']               = $gender;
                            $params['aboutMe'] 				= $aboutMe;
                            $params['phone'] 			    = $phone;
                            $params['city'] 				= $city;
                            $params['state'] 				= $state;
                            $params['country'] 			    = $country;
                            $params['usertype'] 			= "Recruiter";
                            $params['email']                = $email;
                            $params['username']             = $email;
                            $params['publicId']             = time();
                            $params['companyId']            = $companyId;
                            $params['status'] 				= $status;


                            if($IdToEdit){				
                                $rObj->recruiterUpdateById($params, $IdToEdit);
                                $ErrMsg = '<div class="success">Data updated successfully</div>';
                                $actionDone  = 'U'; // Update
                            }
                            else{
                                $params['password']     = md5($password);
                                $params['modifiedDate'] = date('Y-m-d H:i:s');
                                $params['createDate']   = date('Y-m-d H:i:s');
                                $IdToEdit 				= $rObj->newRecruiter($params);
                                $editid 				= $IdToEdit;

                                $_SESSION['ErrMsg'] = '<div class="success">Data inserted successfully.</div>';
                                $actionDone  = 'I'; // Insert
                            }

                            if($_FILES['profilePic']['name'] && substr($_FILES['profilePic']['type'],0,5)=='image') {
                                $fObj = new FileUpload;
                                $targetLocation = $MEDIA_FILES_ROOT."/member";
                                $TWH[0]         = 185;      // thumb width
                                $TWH[1]         = 185;      // thumb height
                                $LWH[0]         = 450;      // large width
                                $LWH[1]         = 450;      // large height
                                $option         = 'all';    // upload, thumbnail, resize, all

                                $fileName = time();
                                if($target_image = $fObj->uploadImage($_FILES['profilePic'], $targetLocation, $fileName, $TWH, $LWH, $option)){
                                    if($IdToEdit){
                                        $fetch_Existing_Lg = $rObj->getRecruiterInfoByid($IdToEdit);

                                        if($fetch_Existing_Lg['profilePic']) {
                                            @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['profilePic']);
                                            @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['profilePic']);
                                            @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['profilePic']);
                                        }
                                    }
                                    $params = array();
                                    $params['profilePic'] = $target_image;
                                    $rObj->recruiterUpdateById($params, $IdToEdit);
                                }
                            }
                        }
                        else
                            $ErrMsg = '<div class="error">Passwords do not match!</div>';  
                    }
                    else
                        $ErrMsg = '<div class="error">Password needs 1 capital, 1 non-capital, 1 digit!</div>';  
                }
                else
                    $ErrMsg = '<div class="error">Password must be at least 8 characters!</div>';  
            }
            else
                $ErrMsg = '<div class="error">Email already registered!</div>';  
        }
        else
            $ErrMsg = '<div class="error">Invalid email address!</div>'; 
        
        if(isset($SaveNext)){
            ?>
            <script language="javascript">
                window.location = 'index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=<?php echo $dtaction;?>&moduleId=<?php echo $moduleId;?>';
            </script>
            <?php
        }
    }
    else
        $ErrMsg = '<div class="error">Fields marked with (*) are mandatory</div>';  
}

//-----------------------------------------
elseif(isset($Save) && $SourceForm=='RecruiterPassword')
{
	$rObj     	 = new MemberAdmin();
	
	if($NewPassword && $ReNewPassword)
	{
		$cData = $rObj -> getRecruiterInfoByid($recruiterId);
		if($NewPassword == $ReNewPassword)
		{
			$params = array();
			$params['password'] = md5($NewPassword);
			$update = $rObj -> recruiterUpdateById($params, $recruiterId);
			if($update){
				$to 		= $cData['email'];
				$from		= "From: ".SITE_NAME."<".SITE_EMAIL.">";
				$subject 	= SITE_NAME.' :: Password changed';
				$message 	= "Dear ".$cData['fname'].' '.$cData['lname'].',<br>
				Here is your new password: '.$NewPassword.'<br><br>
				Thanks,<br>'.SITE_NAME;
				
				sendEmail($to, $from, $subject, $message);

				$ErrMsg = '<div class="success">Password changed successfully</div>';
			}
			else
				$ErrMsg = '<div class="error">Error! Unable to change password.</div>';
		}
		else
			$ErrMsg = '<div class="warning">New password does not match!</div>';
	}
	else
		$ErrMsg = '<div class="error">Fields marked with (*) are mandatory!</div>';
}
//-----------------------------------------
elseif(isset($Save) && $SourceForm == 'AddChild'){
	$chObj     	= new MemberAdmin();

	if($fname && $dob && $bloodGroup && $gender && $eyeColour && $hairColour){		
		$params = array();
		$params['recruiterId'] 			= $recruiterId;
		$params['fname'] 				= $fname;
		$params['lname'] 				= $lname;
		$params['dob'] 					= $dob;
		$params['gender'] 				= $gender;
		$params['weight'] 				= $weight;
		$params['height'] 				= $height;
		$params['bloodGroup'] 			= $bloodGroup;
		$params['eyeColour'] 			= $eyeColour;
		$params['hairColour'] 			= $hairColour;
		$params['allergies'] 			= $allergies;
		$params['medicalConditions'] 	= $medicalConditions;
		$params['healthCard'] 			= $healthCard;

		if($IdToEdit){
			$chObj->childUpdateById($params, $IdToEdit);
			$editid 		= $IdToEdit;
			$ErrMsg 		= '<div class="success">Data updated successfully</div>';
			$actionDone  	= 'U'; // Update
		}
		else{
			$params['entryDate'] 	= date('Y-m-d H:i:s');
			$editid 				= $chObj->newChild($params);
			
			$cData 	= $chObj->getrecruiterInfoByid($recruiterId);
			$params = array();
			$params['child'] 		= $cData['child']+1;
			$chObj->recruiterupdateById($params, $recruiterId);
			$ErrMsg 				= '<div class="success">Data inserted successfully</div>';			
			$actionDone  			= 'I'; // Insert			
		}
		
		if($_FILES['photo']['name'] && substr($_FILES['photo']['type'],0,5)=='image')
		{
			$fObj = new FileUpload;
			$targetLocation = $MEDIA_FILES_ROOT."/child"; 
			$TWH[0]         = 250;      // thumb width
			$TWH[1]         = 250;      // thumb height
			$LWH[0]         = 450;      // large width
			$LWH[1]         = 450;      // large height
			$option         = 'all';    // upload, thumbnail, resize, all 

			$fileName = time();
			if($target_image = $fObj->uploadImage($_FILES['photo'], $targetLocation, $fileName, $TWH, $LWH, $option)){	
				if($IdToEdit){
					$fetch_Existing_Lg = $chObj->getChildInfoByid($IdToEdit);
					
					if($fetch_Existing_Lg['photo'])
					{
						@unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['photo']);
						@unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['photo']);	
						@unlink($targetLocation.'/large/'.$fetch_Existing_Lg['photo']);
					}
				}
				$params = array();
				$params['photo'] = $target_image;
				$chObj->childUpdateById($params, $editid);
			}
		}
		
		if($actionDone=='I' && !$cData['contact']){
			$_SESSION['ErrMsg']	= '<div class="success">Child added successfully. Please add emergency contact.</div>';
			$siteObj->redirectToURL('index.php?pageType=dashboard&dtls=recruiterinfo&dtaction=addcontact&recruiterId='.$recruiterId.'&moduleId=217');
		}
	}
	else
		$ErrMsg = '<div class="error">Fields marked with (*) are mandatory</div>';
}
//-----------------------------------------
elseif(isset($Save) && $SourceForm == 'AddContact') {
	$cnObj     	= new MemberAdmin();

	if($fname && $relationship && $address && $phone && $city && $province && $zip) {
		$params = array();
		$params['recruiterId'] 			= $recruiterId ;
		$params['fname'] 				= $fname;
		$params['lname'] 				= $lname;
		$params['address'] 				= $address;
		$params['address2'] 			= $address2;
		$params['city'] 				= $city;
		$params['province'] 			= $province;
		$params['zip'] 					= $zip;
		$params['phone'] 				= $phone;
		$params['cell'] 				= $cell;
		$params['email'] 				= $email;
		$params['relationship'] 		= $relationship;
		
		if($IdToEdit) {
			$cnObj->contactUpdateById($params, $IdToEdit);
			$ErrMsg 		= '<div class="success">Data updated successfully</div>';
		}
		else {
			$params['entryDate'] 	= date('Y-m-d H:i:s');
			$IdToEdit 				= $cnObj->newContact($params);
			$editid 				= $IdToEdit;
				
			$cData 	= $cnObj->getRecruiterInfoByid($recruiterId);
			$params = array();
			$params['contact'] 		= $cData['contact']+1;
			$cnObj->recruiterupdateById($params, $recruiterId);
			$ErrMsg 				= '<div class="success">Data inserted successfully</div>';
			
			if(!$cData['billing']){
				$_SESSION['ErrMsg']	= '<div class="success">Contact added successfully. Please add billing details.</div>';
				$siteObj->redirectToURL('index.php?pageType=dashboard&dtls=recruiterinfo&dtaction=addbilling&recruiterId='.$recruiterId.'&moduleId=217');
			}
		}
	}
	else
		$ErrMsg = '<div class="error">Fields marked with (*) are mandatory</div>';
}
//-----------------------------------------
elseif(isset($Save) && $SourceForm == 'AddNotification') {
	$rObj     	= new MemberAdmin();

	if($message) {
		$cData = $rObj->getRecruiterInfoByid($recruiterId);
		
		$params = array();
		$params['recruiterId'] 			= $recruiterId;
		$params['msgFrom'] 				= SITE_EMAIL ;
		$params['msgTo']				= $cData['email'];
		$params['subject'] 				= $subject;
		$params['message'] 				= $message;
		
		$params['entryDate'] 	= date('Y-m-d H:i:s');
		$IdToEdit 				= $rObj->newNotification($params);
		
		$to 		= $cData['email'];
		$from		= "From: ".SITE_NAME."<".SITE_EMAIL.">";
								
		sendEmail($to, $from, $subject, $message);

		$ErrMsg 				= '<div class="success">Data inserted successfully</div>';
	}
	else
		$ErrMsg = '<div class="error">Fields marked with (*) are mandatory</div>';
}
//-----------------------------------------
elseif(isset($Save) && $SourceForm == 'AddBilling') {
	$bObj     	= new MemberAdmin();

	if($ccType && $number1 && $number2 && $number3 && $number4 && $month && $year && $cvv) {
		$params = array();
		$params['recruiterId'] 			= $recruiterId ;
		$params['ccType'] 				= $ccType;
		$params['ccNumber'] 			= $number1.$number2.$number3.$number4;
		$params['expiry'] 				= $month."/".$year;
		$params['cvv'] 					= $cvv;
		
		
		if($IdToEdit) {
			$bObj->billingUpdateById($params, $IdToEdit);
			$ErrMsg = '<div class="success">Data updated successfully</div>';
		}
		else {
			$params['entryDate'] 	= date('Y-m-d H:i:s');
			$IdToEdit 				= $bObj->newBilling($params);
			$editid 				= $IdToEdit;
			
			$cData=$bObj->getRecruiterInfoByid($recruiterId);
			$params = array();
			$params['billing'] 		= $cData['billing']+1;
			$bObj->recruiterupdateById($params, $recruiterId);

			$ErrMsg 				= '<div class="success">Data inserted successfully</div>';
		}
	}
	else
		$ErrMsg = '<div class="error">Fields marked with (*) are mandatory</div>';
}
//-----------------------------------------
elseif(isset($Save) && $SourceForm == 'AddNotes') {
	$rObj     	= new MemberAdmin();

	if($subject && $message) {
		$cData = $rObj->getrecruiterInfoByid($recruiterId);

		$params = array();
		$params['recruiterId'] 			= $recruiterId;
		$params['msgFrom'] 				= SITE_EMAIL ;
		$params['msgTo']				= $cData['email'];
		$params['subject'] 				= $subject;
		$params['message'] 				= $message;
		$params['entryDate'] 			= date('Y-m-d H:i:s');
		
		$IdToEdit 			= $rObj->newNotes($params);

		$to 		= $cData['email'];
		$from		= "From: ".SITE_NAME."<".SITE_EMAIL.">";
		sendEmail($to, $from, $subject, $message);

		$ErrMsg 				= '<div class="success">Data inserted successfully</div>';
	}
	else
		$ErrMsg = '<div class="error">Fields marked with (*) are mandatory</div>';
}
//-----------------------------------------
?>
