<?php
//Reset Password --------------------------
if(isset($Save) && $SourceForm == 'ResetPassword')
{
	if($password!='')
	{
		if($email) 
		{
            $obj = new MemberAdmin;
			$sel_Details = $obj->getMemberInfoByid($IdToEdit); 
			if(sizeof($sel_Details)>0)
			{
				$params = array();
                $params['password']     = md5($password);
                $params['ori_password'] = addslashes($password);
                
                $obj->memberUpdateById($params, $IdToEdit);
                
				$_SESSION['ErrMsg'] = '<div class="success">Data Updated Successfully</div>';	
                
                if($sendmail)
				{
					$to = $email;
					$from="From: Administrator<".SITE_EMAIL.">";
					$subject=SITE_NAME." :: Change Password";
					$msg="Dear Member,<br><br>
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
 elseif(isset($Save) || isset($SaveNext) && $SourceForm == 'AddMember'){
	$cObj     	= new MemberAdmin();
	$gObj 		= new genl();
    
        if($fullname && $aboutMe && $phone && $email) {
             if($gObj->validate_email($email)) {

                if($IdToEdit)
                    $ExtraQryStr = 'id!='.$IdToEdit;
                else
                    $ExtraQryStr = 1;

                $exist = $cObj -> checkExistenceByEmail($email, $ExtraQryStr);

                if(!$exist){


                $params = array();
                $params['fullname'] 			= $fullname;
                $params['email']                = $email;
                $params['username']             = $email;
                $params['gender']               = $gender;
                $params['aboutMe'] 				= $aboutMe;
                $params['phone'] 			    = $phone;
                //$params['address'] 			= $address;
                $params['city'] 				= $city;
                $params['state'] 				= $state;
                $params['country'] 			    = $country;
                $params['status'] 				= $status;


                if($IdToEdit){				
                    $cObj->memberUpdateById($params, $IdToEdit);
                    $ErrMsg = '<div class="success">Data updated successfully</div>';
                    $actionDone  = 'U'; // Update
                }
                else{

                    $params['modifiedDate'] = date('Y-m-d H:i:s');
                    $params['createDate']   = date('Y-m-d H:i:s');
                    $IdToEdit 				= $cObj->newMember($params);
                    $editid 				= $IdToEdit;

                    $_SESSION['ErrMsg'] = '<div class="success">Data inserted successfully.</div>';
                    $actionDone  = 'I'; // Insert
                }

                if($_FILES['profilePic']['name'] && substr($_FILES['profilePic']['type'],0,5)=='image')
                {
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
                            $fetch_Existing_Lg = $cObj->getMemberInfoByid($IdToEdit);

                            if($fetch_Existing_Lg['profilePic'])
                            {
                                @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['profilePic']);
                                @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['profilePic']);
                                @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['profilePic']);
                            }
                        }
                        $params = array();
                        $params['profilePic'] = $target_image;
                        $cObj->memberUpdateById($params, $IdToEdit);
                        }
                    }
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
elseif(isset($Save) && $SourceForm=='MemberPassword')
{
	$cObj     	 = new MemberAdmin();
	
	if($NewPassword && $ReNewPassword)
	{
		$cData = $cObj -> getMemberInfoByid($memberId);
		if($NewPassword == $ReNewPassword)
		{
			$params = array();
			$params['password'] = md5($NewPassword);
			$update = $cObj -> memberUpdateById($params, $memberId);
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
?>
