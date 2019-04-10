<?php 
if($_POST){
    if($_POST['ajax']==1)
        include("../../ext_include.php");
    try
    {   
        // Run CSRF check, on POST data, in exception mode, for 10 minutes, in one-time mode.
        // NoCSRF::check('csrf_token', $_POST, true, 60*10, true);
        if($SourceForm =='SignUp'){
			/********************************************************************
			Sign Up Form Action Started
			********************************************************************/
            if($captcha==''){
                $uObj = new MemberView;

                if($fullname!='' && $email!='' && $password!='' && $cnfrm_password!='' && $terms){
                    $gObj = new genl();
                    if($gObj->validate_email($email)) {
                        
                        $exist = $uObj -> getMemberByEmail($email);
                        if(!$exist || ($exist['actionStatus'] == 'expired' && $exist['referId']==0)){
                            if(strlen($password)>=8)
                            {
                                if($gObj->validate_alpha($password)){
                                    if($password==$cnfrm_password){
                                        $approvedKey  			= md5(time().rand());
                                        $params                 = array();
                                        $params['fullname']     = $fullname;
                                        $params['gender']       = $gender;
                                        $params['email']        = $email;
                                        $params['usertype']     = 'Seller';
                                        $params['rgstrType']    = 'NORMAL';

                                        $params['publicId']     = time();
                                        $params['username']     = $email;
                                        $params['password']     = md5($password);
                                        
                                        $params['city']         = $visitedFrom_City;
                                        $params['country']      = $visitedFrom_Country;
                                        $params['ipAddress']    = $visitedFrom_Ip;
                                        
                                        $params['createDate']   = date("Y-m-d H:i:s");
                                        $params['approvedKey']  = $approvedKey;
                                        
                                        $params['status']  		= "N";
                                        $params['lastLogin'] 	= date("Y-m-d H:i:s");

                                        if($exist['actionStatus'] != 'expired'){
                                            $uData = $uObj -> newMember($params);  
                                        }
                                        else{
                                            $params['actionStatus'] = "";
                                            $uObj -> memberUpdateById($params, $exist['id']);
                                        }

                                        /*****Sending mail to approve registration*****/

                                        $msg_details    = $uObj -> getEmailBodyById(27);

                                        $to         = $email;
                                        $from       = "From: ".SITE_NAME."<".SITE_EMAIL.">";
                                        $subject    = $msg_details['emailSubject'];
                                        $msg        = $msg_details['emailBody'];

                                        $arr = array(
                                                "{link}" 		=> $SITE_LOC_PATH . "/login/?APRV_KEY=" . $approvedKey,
                                                "{username}" 	=> $email,
                                                "{password}" 	=> $password,
                                        );

                                        $msg    = strtr($msg,$arr);
                                        
                                        sendEmail($to, $from, $subject, $msg);

                                        /*****End of mail sending*****/

                                        $msg_type 		= 1;
                                        $msg_text 		= "Please check your inbox/spam.";
                                        $redirect_url 	= "";
                                        //echo '<span class="success">Check your email to verify</span>';
                                        //echo 1;
                                    }
                                    else{
                                        $msg_type 		= 0;
                                        $msg_text 		= "Passwords do not match!";
                                        $redirect_url 	= "";
                                        //echo '<span class="error">Passwords do not match!</span>';
                                    }
                                }
                                else{
                                    $msg_type 		= 0;
                                    $msg_text 		= "Password needs 1 capital, 1 non-capital, 1 digit!";
                                    $redirect_url 	= "";
                                    //echo '<span class="error">Use alphanumeric[A-Z,a-z,0-9] password!</span>';
                                }
                            }
                            else{
                                $msg_type 		= 0;
                                $msg_text 		= "Password must be at least 8 characters!";
                                $redirect_url 	= "";
                                //echo '<span class="error">Password must be in 8 charecter!</span>';
                            }
                        }
                        else{
                            $msg_type 		= 0;
                            $msg_text 		= "Email already registered!";
                            $redirect_url 	= "";
                            //echo '<span class="error">Email already registered!</span>';
                        }
                    }
                    else{
                        $msg_type 		= 0;
                        $msg_text 		= "Invalid email address!";
                        $redirect_url 	= "";
                        //echo '<span class="error">Invalid email id!</span>';
                    }
                }
                else{
                    $msg_type 		= 0;
                    $msg_text 		= "All fields are mandatory!";
                    $redirect_url 	= "";
                    //echo '<span class="error">All fields are mandatory!</span>';
                }
                
            }
            else{
            	$msg_type 		= 0;
            	$msg_text 		= "Error: Unauthorised Attempt!";
            	$redirect_url 	= "";
                //echo '<span class="error">Error : Unauthorized Attempt!</span>';
            }
            
            $result_arr = array();
            $result_arr['type']		= $msg_type;
            $result_arr['msg']		= $msg_text;
            $result_arr['redirect']	= $redirect_url;
            echo json_encode($result_arr);
        /********************************************************************
        Sign Up Form Action Ended
        ********************************************************************/
            
        }
        elseif($SourceForm =='SignUpRecruiter'){
			/********************************************************************
			Sign Up Form Action Started
			********************************************************************/
            if($captcha==''){ 
                $uObj = new MemberView;

                if(($companyId!='' || $companyName) && $fullname!='' && $phone!='' && $email!='' && $password!='' && $cnfrm_password!='' && $terms){
                    
                    $gObj = new genl();
                    if($gObj->validate_email($email)) {
                        
                        $exist = $uObj -> getMemberByEmail($email);
                        if(!$exist || ($exist['actionStatus'] == 'expired' && $exist['referId']==0)){
                            if(strlen($password)>=8)
                            {
                                if($gObj->validate_alpha($password)){
                                    if($password==$cnfrm_password){
                                        
                                        if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
                                        {
                                            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.SECRET_KEY.'&response='.$_POST['g-recaptcha-response']);
                                            $responseData = json_decode($verifyResponse);
                                            if($responseData->success)
                                            {  
                                                $approvedKey  			= md5(time().rand());
                                                $params                 = array();
                                                $params['fullname']     = $fullname;
                                                $params['email']        = $email;
                                                $params['phone']        = $phone;
                                                $params['usertype']     = 'Buyer';
                                                $params['rgstrType']    = 'NORMAL';

                                                $params['publicId']     = time();
                                                $params['username']     = $email;
                                                $params['password']     = md5($password);

                                                $params['city']         = $visitedFrom_City;
                                                $params['country']      = $visitedFrom_Country;
                                                $params['ipAddress']    = $visitedFrom_Ip;

                                                $params['createDate']   = date("Y-m-d H:i:s");
                                                $params['approvedKey']  = $approvedKey;

                                                $params['status']  		= "N";
                                                $params['lastLogin'] 	= date("Y-m-d H:i:s");
                                                $params['companyId'] 	= $companyId;

                                                if($exist['actionStatus'] != 'expired'){
                                                    $uData = $uObj -> newMember($params);  
                                                }
                                                else{
                                                    $params['actionStatus'] = "";
                                                    $uObj -> memberUpdateById($params, $exist['id']);
                                                }
                                        
                                                if($companyId==0){
                                                    
                                                    //permalink--------------
                                                    $ENTITY = TBL_COMPANY_TEMP;
                                                    $permalink = $companyName;
                                                        $ExtraQryStr = 1; 
                                                    $permalink = createPermalink($ENTITY, $permalink, $ExtraQryStr);
                                                    //permalink---------------	

                                                    $cmpnObj = new CompanyView;
                                                    
                                                    $params                 = array();
                                                    $params['companyName'] 	= $companyName;
                                                    $params['permalink'] 	= $permalink;
                                                    $params['memberId'] 	= $uData;
                                                    $params['entryDate'] 	= date("Y-m-d H:i:s");

                                                    $cmpId=$cmpnObj->newTempCompanies($params);

                                                    if($cmpId)
                                                    {
                                                        if($_FILES['imgFile']['name']!='')
                                                        { 
                                                            if($_FILES['imgFile']['size']<=2097152) // max 2MB
                                                            {                        
                                                                $extension_lg_array = pathinfo($_FILES['imgFile']['name']);

                                                                if($extension_lg_array['basename'])
                                                                    $extension_lg = strtolower($extension_lg_array['extension']);

                                                                if($extension_lg == 'jpg' || $extension_lg == 'jpeg'){

                                                                    if($_FILES['imgFile']['name']){
                                                                        $fObj           = new FileUpload;

                                                                        $companyLogo    = time();
                                                                        $targetLocation = $MEDIA_FILES_ROOT."/companies";

                                                                        $TWH[0]         = 153;      // thumb width
                                                                        $TWH[1]         = 140;      // thumb height
                                                                        $LWH[0]         = 153;      // large width
                                                                        $LWH[1]         = 140;    
                                                                        $option         = 'all';    // upload, thumbnail, resize, all

                                                                        $companyLogo = $fObj->uploadImage($_FILES['imgFile'], $targetLocation, $companyLogo, $TWH, $LWH, $option);

                                                                        $params = array();
                                                                        $params['photo'] = $companyLogo;
                                                                        $cmpnObj->tempCompanyUpdateById($params, $cmpId);
                                                                    }
                                                                }
                                                                else
                                                                    echo 'error>Company logo should be a .jpg or .jpeg file.';
                                                            }
                                                            else
                                                                echo 'error>Company logo is too large to be uploaded! Your file size should be 2MB max.';
                                                        }
                                                    }


                                                }

                                                /*****Sending mail to approve registration*****/
                                                
                                                
                                                $msg_details    = $uObj -> getEmailBodyById(27);

                                                $to         = $email;
                                                $from       = "From: ".SITE_NAME."<".SITE_EMAIL.">";
                                                $subject    = $msg_details['emailSubject'];
                                                $msg        = $msg_details['emailBody'];

                                                $arr = array(
                                                        "{link}" 		=> $SITE_LOC_PATH . "/login/?APRV_KEY=" . $approvedKey,
                                                        "{username}" 	=> $email,
                                                        "{password}" 	=> $password,
                                                );

                                                $msg    = strtr($msg,$arr);

                                                sendEmail($to, $from, $subject, $msg);

                                                /*****End of mail sending*****/
 
                                                echo 'success>Please check your inbox/spam.';
                                               
                                            }
                                            else
                                                echo 'error>Robot verification failed, please try again!';
                                        }
                                        else
                                            echo 'error>Please click on the reCAPTCHA box!';  
                                    }
                                    else
                                        echo 'error>Passwords do not match!';
                                }
                                else
                                    echo 'error>Password needs 1 capital, 1 non-capital, 1 digit!';
                            }
                            else
                                echo 'error>Password must be at least 8 characters!';
                        }
                        else
                            echo 'error>Email already registered!';
                    }
                    else
                        echo 'error>Invalid email address!';
                }
                else
                    echo 'error>All fields are mandatory!';
            }
            else
                echo 'error>Unauthorised Attempt!';           
        /********************************************************************
        Sign Up Form Action Ended
        ********************************************************************/
            
        }
		elseif($SourceForm =='LogIn'){     
			/********************************************************************
			Log In Form Action Started
			********************************************************************/  

			if(!$_SESSION['FRONT_PROTECT'])
				$_SESSION['FRONT_PROTECT'] = 1;
			else    
				$_SESSION['FRONT_PROTECT']++;
			
			if($_SESSION['FRONT_PROTECT']<10){
				if($captcha == ''){
					$username = trim($username);
					$password = trim($password);
					if($username!='' && $password !='') {
						$gObj = new genl();
						if($gObj->validate_alpha($password)){
							
							$uObj = new MemberView();
							$verify = $uObj -> verifyUser($username, $password);
							if($verify){
								if($verify['status'] == "Y"){
									//Set Cookie Start
									if($remember=='yes'){
										$year = time() + 31536000;
										setcookie('remember_username', $username, $year,'/');
										setcookie('remember_password', $password, $year,'/');
									}
									elseif(!$remember) {
										if(isset($_COOKIE['remember_username']) || isset($_COOKIE['remember_password'])) {
											$past = time() - 100;
											setcookie(remember_username, gone, $past,'/');
											setcookie(remember_password, gone, $past,'/');
										}
									}
									//Set Cookie End

									//User Session Variable Set Start
									
									$_SESSION['FUSERLOGIN']     = 'ok';
									$_SESSION['FUSERID']        = $verify['id'];
									$_SESSION['PUBLICID']       = $verify['publicId'];
									$_SESSION['FUSERTYPE']      = $verify['usertype'];
									$_SESSION['FUSEREMAIL']     = $verify['email'];
									$_SESSION['FUSERPHONE']     = $verify['phone'];
                                    $_SESSION['FUSERNEW_PHONE'] = $verify['new_phone'];
                                    $_SESSION['FUSERNEW_EMAIl'] = $verify['new_email'];
                                    $_SESSION['FUSERWEBSITE']   = $verify['website'];
                                    $_SESSION['FUSERCOMPANY']   = $verify['company'];
                                   
									$_SESSION['FUSERNAME']      = $verify['name'];
									$_SESSION['FUSERSURNAME']   = $verify['surname'];
									$_SESSION['FUSERFULLNAME']  = $verify['name'].' '.$verify['surname'];
									$_SESSION['GENDER']         = $verify['gender'];
									$_SESSION['PROFILEPIC']     = $verify['profilePic'];
                                    $_SESSION['FUSERABOUT']     = $verify['aboutMe'];
									$_SESSION['REG_DATE']  		= $verify['createDate'];
                                    
									$_SESSION['FUSERSURADDRESS']= $verify['address'];
									$_SESSION['FUSERCOUNTRY']  	= $verify['country'];
									$_SESSION['FUSERSTATE']  	= $verify['state'];
									$_SESSION['FUSERCITY']  	= $verify['city'];
									$_SESSION['FUSERZIP']  		= $verify['zip'];
                                    
                                    if($_SESSION['PROFILEPIC'] && file_exists($MEDIA_FILES_ROOT.'/member/thumb/'.$_SESSION['PROFILEPIC']))
                                        $_SESSION['DPURL'] = $MEDIA_FILES_SRC.'/member/thumb/'.$_SESSION['PROFILEPIC'];
                                    else
                                        $_SESSION['DPURL'] = $STYLE_FILES_SRC.'/images/'.strtolower($_SESSION['GENDER']).'.png';

									//User Session Variable Set End

									$params					= array();
									
									$params['ipAddress']    = $_SESSION['visitedFrom_Ip'];
									$params['lastLogin']    = date("Y-m-d H:i:s");
									$updateUser             = $uObj -> memberUpdateById($params, $verify['id']);
									

									$msg_type		= 1;
									$msg_text		= 'Login successful. Redirecting';
									$redirect_url	= $SITE_DASHBOARD_PATH;

									//echo '<span class="success">Log In successfull. redirecting...</span>';
								}
								else {
									/*****Sending mail to approve registration*****/     

									/*****End of mail sending*****/
									$msg_type		= 0;                            
									$redirect_url	= '';
									if($verify['actionStatus']=='expired')
										$msg_text		= 'Account expired! Please signup.';
									else
										$msg_text		= 'Account is not active!';
									//echo '<span class="error">Please check your inbox for approval!</span>';
								}
							}
							else{
								$msg_type		= 0;
								$msg_text		= 'Username or password is incorrect!';
								$redirect_url	= '';
								//echo '<span class="error">Username or password is incorrect!</span>';
							}							
						}
						else{
							$msg_type		= 0;
							$msg_text		= 'Password is incorrect!';
							$redirect_url	= '';
							//echo '<span class="error">Username or password is incorrect!</span>';
						}
					}
					else{
						$msg_type		= 0;
						$msg_text		= 'All fields are mandatory!';
						$redirect_url	= '';
						//echo '<span class="error">All fields are mandetory!</span>';
					}
				}
				else{
					$msg_type		= 0;
					$msg_text		= 'Unauthorised attempt!';
					$redirect_url	= '';
					//echo '<span class="error">Error : Unauthorized attempt!</span>';
				}
			}
			else{
				$msg_type		= 0;
				$msg_text		= 'Maximum login attempts exceeded!';
				$redirect_url	= '';
			}
            
                $result_arr = array();
                $result_arr['type']		= $msg_type;
                $result_arr['msg']		= $msg_text;
                $result_arr['redirect']	= $redirect_url;
                echo  json_encode($result_arr);

            
            

			/********************************************************************
			Log In Form Action Ended
			********************************************************************/
        }
        elseif($SourceForm == 'ForgotPassword'){
        /********************************************************************
        Forgot Password Form Action Started
        ********************************************************************/
            if($captcha==''){
                if($email)
                {
                    $gObj = new genl();
                    if($gObj->validate_email($email))
                    {
                        $uObj = new MemberView;
                        $uData = $uObj -> getMemberByEmail($email);
                        if($uData)
                        {

                        	if($uData['status'] != "N"){
	                        	$passwordKey 			= md5(time().rand());
	                        	$params                 = array();
	                        	$params['passwordKey']  = $passwordKey;
                                
	                        	$userUpdate = $uObj -> memberUpdateById($params, $uData['id']);
	                        	/*****Sending mail for forgot password*****/
	                        	if ($userUpdate){
		                        	$msg_details = $uObj -> getEmailBodyById(3);
		                        	 
		                        	$to      = $email;
		                        	$from    = "From: ".SITE_NAME."<".SITE_EMAIL.">";
		                        	$subject = $msg_details['emailSubject'];
		                        	$msg     = $msg_details['emailBody'];
		                        	 
		                        	$arr = array(
		                        			"{link}" => $SITE_LOC_PATH . "/forgot-password/?PSSW_KEY=".$passwordKey);
		                        	 
		                        	$msg  = strtr($msg,$arr);
		                        	 
		                        	sendEmail($to,$from,$subject,$msg);
	                        	}
	                        	/*****End of mail sending*****/
	                        	
	                        	
	                            /*$to   =  $email;
	                            $from = $from="From: ".SITE_NAME."<".SITE_EMAIL_NOREPLY.">";
	                            $subject  = 'Forgot Password';
	                            $msg  = "Dear User,<br><br>
	                            Here is your login details<br><br>
	                            Username: ".$uData['username']."<br>
	                            Password: ".$uData['orgPassword']."<br><br>
	                            <a href='".$SITE_LOC_PATH."/login/'>Click here to login.</a><br><br>
	                            Regards,<br>".SITE_NAME;
	                            sendEmail($to,$from,$subject,$msg);*/
	                            //echo 1;
	                            
	                            $msg_type		= 1;
	                            $msg_text		= "An email has been sent to your address.";
	                            $redirect_url	= '';
	                        }
	                        else{
	                        	$msg_type		= 0;
	                        	$msg_text		= "Please verify your account first!";
	                        	$redirect_url	= '';
	                           	//echo '<span class="error">The account has not approved!</span>';
	                        }
                        }
                        else{
                        	$msg_type		= 0;
                        	$msg_text		= "No match found for this email!";
                        	$redirect_url	= '';
                            //echo '<span class="error">No match found for this email!</span>';
                        }
                    }
                    else{
                    	$msg_type		= 0;
                    	$msg_text		= "Email address is invalid!";
                    	$redirect_url	= '';
                        //echo '<span class="error">Email ID is invalid!</span>';
                    }
                }
                else{
                	$msg_type		= 0;
                	$msg_text		= "Please enter your email address!";
                	$redirect_url	= '';
                    //echo  '<span class="error">Please enter email!</span>';
                }
            }
            else{
            	$msg_type		= 0;
            	$msg_text		= "Error: Unauthorised attempt!";
            	$redirect_url	= '';
                //echo '<span class="error">Error : Unauthorized attempt!</span>';
            }
            
            $result_arr = array();
            $result_arr['type']		= $msg_type;
            $result_arr['msg']		= $msg_text;
            $result_arr['redirect']	= $redirect_url;
            echo json_encode($result_arr);
        /********************************************************************
        Forgot Password Form Action Ended
        ********************************************************************/
        }        
        elseif($SourceForm == 'ResetPassword'){
        /********************************************************************
       	Forgot Password Form Action Started
        ********************************************************************/
        	if($captcha==''){
        		if($password!='' && $cnfrm_password!='')
        		{
        			if(strlen($password)>=8){
        				$gObj = new genl();
        				if($gObj->validate_alpha($password))
        				{
        					if($password == $cnfrm_password){
        						$uObj             = new MemberView;
        						$checkUserStatus  = $uObj -> checkMemberByPassKey($passwordKey);
                                
        						if ($checkUserStatus == 1){
	        						$params 				= array();
	        						
	        						$params['password']     = md5($password);
	        						$params['passwordKey']  = '';
	        						$updatePassword 		= $uObj -> memberUpdateByPassKey($params, $passwordKey);
	        						//echo 4;
	        						$msg_type		= 1;
	        						$msg_text		= "Password changed successfully.";
	        						$redirect_url	= $SITE_LOC_PATH.'/login/';
        						}
        						else{
        							$msg_type		= 0;
        							$msg_text		= "Password key mismatched!";
        							$redirect_url	= '';
        							//echo '<span class="error">Password key mismatched!</span>';
        						}
        					}
        					else{
        						$msg_type		= 0;
        						$msg_text		= "Passwords do not match!";
        						$redirect_url	= '';
        						//echo '<span class="error">Passwords do not match!</span>';
        					}
        				}
        				else{
        					$msg_type		= 0;
        					$msg_text		= "Use alphanumeric[A-Z,a-z,0-9] password!";
        					$redirect_url	= '';
        					//echo '<span class="error">Use alphanumeric[A-Z,a-z,0-9] password!</span>';
        				}
        			}
        			else{
        				$msg_type		= 0;
        				$msg_text		= "Minimum 8 charecters required!";
        				$redirect_url	= '';
        				//echo '<span class="error">Password must be in 8 charecter!</span>';
        			}
        		}
        		else{
        			$msg_type		= 0;
        			$msg_text		= "All fields are mandetory!";
        			$redirect_url	= '';
        			//echo '<span class="error">All fields are mandetory!</span>';
        		}
        	}
        	else{
        		$msg_type		= 0;
        		$msg_text		= "Error : Unauthorized attempt!";
        		$redirect_url	= '';
        		//echo '<span class="error">Error : Unauthorized attempt!</span>';
        	}
        	
        	$result_arr = array();
        	$result_arr['type']		= $msg_type;
        	$result_arr['msg']		= $msg_text;
        	$result_arr['redirect']	= $redirect_url;
        	echo json_encode($result_arr);
        /********************************************************************
        Forgot Password Form Action Ended
        ********************************************************************/
        }
        elseif($SourceForm == 'ChangePassword'){
            if($_SESSION['FUSERLOGIN']=='ok'){
                if($currpassword && $password && $new_password) {
                    $uObj   = new MemberView;
                    $verify = $uObj -> verifyUser($_SESSION['FUSEREMAIL'], $currpassword);
                    
                    if($verify){
                        $gObj = new genl();
                        if($gObj->validate_alpha($password)) {
                            if($password == $new_password) {

                                $params                  = array();
                                $params['password']      = md5($password);
                                $params['modifiedDate']  = date("Y-m-d H:i:s");
                                $update = $uObj -> memberUpdateById($params, $_SESSION['FUSERID']);

                                if($update){
                                    /*****Sending mail to member *****/
                                    $msg_details    = $uObj -> getEmailBodyById(23);
                                    $fullname       = ($_SESSION['FUSERFULLNAME']) ? $_SESSION['FUSERFULLNAME'] : 'member';


                                    $to 		= $_SESSION['FUSEREMAIL'];
                                    $from 		= "From: ".SITE_NAME."<".SITE_EMAIL.">";
                                    $subject 	= $msg_details['emailSubject'];
                                    $msg 		= $msg_details['emailBody'];

                                    $arr = array(
                                            "{fullname}" 		   => $fullname,
                                            "{site_path}" 		=> $SITE_LOC_PATH,
                                            "{site_email}" 	    => SITE_EMAIL
                                    );
                                    $msg  = strtr($msg,$arr);

                                    sendEmail($to,$from,$subject,$msg);
                                    /*****End of mail sending*****/

                                    echo 'success>Password has been changed successfully';
                                }
                            }
                            else
                                echo 'error>Passwords do not match!';
                        }
                        else
                            echo 'error>Passwords must be between 8 – 15 characters and include at least 1 capital letter, 1 non-capital letter and 1 number!';
                    }
                    else
                        echo 'error>Current password is incorrect.';
                }
                else
                    echo 'error>All fields are mandatory.';
            }
        }
        // elseif($SourceForm == 'updateAccount'){       
        // /********************************************************************
       	// Update Form Action Started
        // ********************************************************************/
        // 	if($captcha==''){
        //         $error = 0;
        //         $uObj = new MemberView;
        //         $gObj = new genl();
        //         if($gObj->validate_email($email)) 
        //         {


        //             $params                 = array();

        //             $params['name']      = $name;
        //             $params['surname']   = $surname;
        //             $params['email']     = $email;
        //             $params['company']   = $company;
        //             $params['phone']     = $phone;
        //             $params['new_phone'] = $new_phone;
        //             $params['new_email'] = $new_email;
        //             $params['profilePic']= $profilePic;
        //             $params['website']   = $website;
        //             $params['country']   = $country;
        //             $params['state']     = $state;
        //             $params['city']      = $city;
        //             $params['zip']       = $zip;

        //             //$params['profilePic'] = $_FILES['profilePic']['name'];
                   

        //             if($_FILES['profilePic']['size']<=2097152)
        //         {
        //             $fObj = new FileUpload;
        //             $targetLocation = UPFLD."/member";
        //             $TWH[0]         = 185;      // thumb width
        //             $TWH[1]         = 185;      // thumb height
        //             $LWH[0]         = 450;      // large width
        //             $LWH[1]         = 450;      // large height
        //             $option         = 'all';    // upload, thumbnail, resize, all

        //             $fileName = time();
        //             if($target_image = $fObj->uploadImage($_FILES['profilePic'], $targetLocation, $fileName, $TWH, $LWH, $option)){
        //                 if($uid){
        //                     $fetch_Existing_Lg = $cObj->getMemberInfoByid($uid);

        //                     if($fetch_Existing_Lg['profilePic'])
        //                     {
        //                         @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['profilePic']);
        //                         @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['profilePic']);
        //                         @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['profilePic']);
        //                     }
        //                 }
        //                 $params = array();
        //                 $params['profilePic'] = $target_image;
        //                 $cObj->memberUpdateById($params, $uid);
        //                 }
        //             }

        //             elseif($password && $newpassword=='' && $retypepassword==''){
                   
        //                 $msg_type       = 0;
        //                 $msg_text       = "Please type new password!";
        //                 $redirect_url   = '';
        //                 $error = 1;
        //             }
        //             elseif($password && $newpassword && $retypepassword=='')
        //             { 
        //                 $msg_type       = 0;
        //                 $msg_text       = "Please retype new password!";
        //                 $redirect_url   = '';
        //                 $error = 1;
        //             }
        //             elseif($password=='' && $newpassword && $retypepassword)
        //             {
        //                 $msg_type       = 0;
        //                 $msg_text       = "Please type old password!";
        //                 $redirect_url   = '';
        //                 $error = 1;
        //             }  
        //             elseif($password=='' && $newpassword && $retypepassword=='')
        //             {
        //                 $msg_type       = 0;
        //                 $msg_text       = "Please type old password!";
        //                 $redirect_url   = '';
        //                 $error = 1;
        //             }  
        //             elseif($password && $newpassword=='' && $retypepassword)
        //             {
        //                 $msg_type       = 0;
        //                 $msg_text       = "Please type new password!";
        //                 $redirect_url   = '';
        //                 $error = 1;
        //             }  
        //             elseif($password=='' && $newpassword=='' && $retypepassword)
        //             {
        //                 $msg_type       = 0;
        //                 $msg_text       = "Please type old and new password!";
        //                 $redirect_url   = '';
        //                 $error = 1;
        //             }                        
        //             elseif($password && $newpassword && $retypepassword)
        //             {
        //                  $verify = $uObj -> verifyUser($_SESSION['FUSEREMAIL'], $password);
        //                  $error = 1;
        //                  if($verify)
        //                  {
        //                     if($gObj->validate_alpha($newpassword)) {
        //                         if($newpassword == $retypepassword) {

        //                             $params['password']      = md5($newpassword);
        //                             $params['modifiedDate']  = date("Y-m-d H:i:s");
        //                             $error = 0;
        //                         }
        //                         else{                                        
        //                             $msg_type       = 0;
        //                             $msg_text       = "Passwords do not match!";
        //                             $redirect_url   = '';
        //                         }
        //                     }
        //                     else{                                                                           
        //                         $msg_type       = 0;
        //                         $msg_text       = "Passwords must be between 8 – 15 characters and include at least 1 capital letter, 1 non-capital letter and 1 number!";
        //                         $redirect_url   = '';
        //                     }
        //                 }
        //                 else{                                                                          
        //                     $msg_type       = 0;
        //                     $msg_text       = "Current password is incorrect";
        //                     $redirect_url   = '';
        //                     $error          = 1;
        //                 }
        //             }

        //             if($error == 0)
        //             {
                        
                  
        //                 $uObj->memberUpdateById($params, $uid);
        //                 $msg_type       = 1;
        //                 $msg_text       = "Successfully Updated.";
        //                 $redirect_url   = $SITE_LOC_PATH.'/dashboard/accounts-settings/';


        //                 $_SESSION['FUSERLOGIN']     = 'ok';
        //                 $_SESSION['FUSERID']        = $uid;
        //                 $_SESSION['FUSERNAME']      = $name;
        //                 $_SESSION['FUSERPHONE']     = $phone;
        //                 $_SESSION['FUSERNEW_PHONE'] = $new_phone;
        //                 $_SESSION['FUSERCOMPANY']   = $company;
        //                 $_SESSION['FUSERWEBSITE']   = $website;
        //                 $_SESSION['FUSERNEW_EMAIl'] = $new_email;
        //                 $_SESSION['PROFILEPIC']     = $profilePic;
        //                 $_SESSION['FUSERSURNAME']   = $surname;
        //                 $_SESSION['FUSERCOUNTRY']   = $country;
        //                 $_SESSION['FUSERSTATE']     = $state;
        //                 $_SESSION['FUSERCITY']      = $city;
        //                 $_SESSION['FUSERZIP']       = $zip;

        //                                }
        //         }
          
        //         else{
        //             $msg_type       = 0;
        //             $msg_text       = "Invalid email address!";
        //             $redirect_url   = "";
        //             $error          = 1;
        //             //echo '<span class="error">Invalid email id!</span>';
        //         }
                
        //     }
        //     else{
        //         $msg_type       = 0;
        //         $msg_text       = "Error : Unauthorized attempt!";
        //         $redirect_url   = '';
        //         $error          = 1;
        //         //echo '<span class="error">Error : Unauthorized attempt!</span>';
        //     }
            
        //     $result_arr = array();
        //     $result_arr['type']     = $msg_type;
        //     $result_arr['msg']      = $msg_text;
        //     $result_arr['redirect'] = $redirect_url;
        //     $result_arr['error']    = $error;
        //     echo json_encode($msg_text);
            
        /********************************************************************
        Forgot Password Form Action Ended
        ********************************************************************/
       // }
      
       elseif($SourceForm == 'updateAccount'){ 
           $uObj = new MemberView;
            $uObj->updateMemberInfo();  
        }

        elseif($SourceForm == 'updateComapny'){     
            $uObj = new MemberView;
            $uObj->sendcompanydata($_SESSION['FUSERID']);            
        }
        elseif($SourceForm == 'addProduct'){ 
            $uObj = new MemberView;
            $uObj->addproduct($userid);       
        }
        elseif($SourceForm == 'editProduct'){
            $uObj = new MemberView;            
            $uObj->addproduct($userid,$id);  
        }
         elseif($SourceForm == 'viewProduct'){
            $uObj = new MemberView;
            $uObj->viewProductShow($userid,$id);            
        }
        elseif($SourceForm == 'deleteProduct'){
            $uObj = new MemberView;
            $uObj->deleteProductByproductId($id);            
        }
        elseif($SourceForm == 'addbook'){
            $uObj = new MemberView;
            $uObj->addbook();            
        }
        elseif($SourceForm == 'userconfirmbook'){
            $uObj = new MemberView;
            $uObj->userconfirmbook($id_booking);            
        }
        elseif($SourceForm == 'setconfirmbook'){ 
            $uObj = new MemberView;
            $uObj->setconfirmbook();            
        }
        elseif($SourceForm == 'editbook'){ 
            $uObj = new MemberView;
            $uObj->editbook($id_booking);            
        }
        elseif($SourceForm == 'updatebook'){ 
            $uObj = new MemberView;
            $uObj->updatebook();            
        }
        elseif($SourceForm == 'checkusr'){ 
            $uObj = new MemberView;
            $uObj->checkusr();            
        }
        elseif($SourceForm == 'adduser'){ 
            $uObj = new MemberView;
            $uObj->adduser();       
        }
        elseif($SourceForm == 'Readoffice'){ 
            $uObj = new MemberView;
            $uObj->readoffice($state_code,$cityOffice);            
        }
        elseif($SourceForm == 'Readofficename'){ 
            $uObj = new MemberView;
            $uObj->readofficename($office_name,$office);            
        }
        elseif($SourceForm == 'Readofficeimg'){ 
            $uObj = new MemberView;
            $uObj->readofficeimg($id_office);            
        }
        elseif($SourceForm == 'getcoordinate'){ 
            $uObj = new MemberView;
            $uObj->getmap($address);            
        }
        elseif($SourceForm == 'signaturecont'){ 
            $uObj = new MemberView;
            $uObj->signaturecont();            
        }
        elseif($SourceForm == 'addAddress'){ 
            $uObj = new MemberView;            
            
            $params = array();
            $params['userId']       = $_SESSION['FUSERID'];
            $params['compId']       = $cid;
            $params['offName']      = $offName;
            $params['phone']        = $phone;
            $params['country']      = $country;
            $params['state']        = $state;
            $params['city']         = $city;
            $params['address']      = $address;
            $params['voiceMail']    = $voiceMail;
            $params['website']      = $website;
            $params['email']        = $email;
            
            if($addId!=''){
                $uObj->addUpdateByaddressId($params, $addId);
                echo '<div class="successmsg">Address updated successfully.</div><div class="clearfix"></div>';
            }
            else{     
                $uObj->newAddress($params);
                echo '<div class="successmsg">Address added successfully.</div><div class="clearfix"></div>';
            }
            
        }
        elseif($SourceForm == 'addSample' || $SourceForm == 'editSample')
        { 
            $uObj = new MemberView;           
                            
            if($editId!='')
                $sel_ContentDetails = $uObj->checkSampleExistence("productName = '".addslashes($sampleName)."' and sampleId != ".$editId." and proCid=".addslashes($proCid));
            else
                $sel_ContentDetails = $uObj->checkSampleExistence("productName = '".addslashes($sampleName)."' and proCid=".addslashes($proCid));
            
            if(sizeof($sel_ContentDetails)<1)
            {  
                //permalink--------------
                if($editId)	
                    $ExtraQryStr = 'sampleId!='.$editId;	
                else
                    $ExtraQryStr = 1;
                $permalink = createPermalink(TBL_SAMPLE, $sampleName, $ExtraQryStr);
                //permalink---------------

                $params = array();
                $params['userId']       = $_SESSION['FUSERID'];
                $params['compId']       = $compId;
                $params['proid']        = $proid;
                $params['proCid']       = $proCid;
                $params['productName']  = $sampleName;
                if($_FILES['proimg']['name']=='')
                $params['productImage'] = $proImg;
                $params['permalink']    = $permalink;
                $params['p_keyword']    = $p_keyword;
                $params['description']  = $description;
                $params['unitType']     = $unitType;
                $params['currency']     = $currency;
                $params['range1']       = $range1;
                $params['range2']       = $range2;
                $params['qty']          = $qty;
                        
                if($editId!=''){
                    $params['updateDate']  = date("Y-m-d H:i:s");
                    $uObj->sampleUpdateBysampleId($params, $editId);
                    
                    if($qtyId){                        
                        $smpleQty               = array();
                        $smpleQty['ct']         = $qty;
                        $smpleQty['inStock']    = $qty;
                        $uObj->sampleQtyUpdateByqtyId($smpleQty, $qtyId);
                    }
                    echo '<div class="successmsg">Sample updated successfully.</div><div class="clearfix"></div>';
                }
                else{     
                    $sampleReqId =  time();
                    $params['totalQty']     = $qty;
                    $params['sampleReqId']  = $sampleReqId;
                    $params['isApproved']   = 'Pending';
                    $params['entryDate']    = date("Y-m-d H:i:s");
                    $addId  = $uObj->newSample($params);
                    $editId = $addId;                    
                    
                    /*$smpleQty               = array();
                    $smpleQty['ct']         = $qty;
                    $smpleQty['inStock']    = $qty;
                    $smpleQty['sampleId']   = $editId;
                    $smpleQty['userId']     = $_SESSION['FUSERID'];
                    $smpleQty['entryDate']  = date("Y-m-d H:i:s");
                    $uObj->newSampleQty($smpleQty); */                  
                    
                    echo '<div class="successmsg">Sample added successfully.</div><div class="clearfix"></div>';
                }


                $ExtraQryStr = "userId=".addslashes($_SESSION['FUSERID'])." AND compId=".$compId;
                $countRow = $uObj->sampleCount($ExtraQryStr);
                if($countRow>0){
                    $param = array();
                    $param['sampleCount'] = $countRow;
                    $uObj -> memberUpdateById($param, $_SESSION['FUSERID']);

                }
            
                if($_FILES['proimg']['name'])
                {
                    $fObj = new FileUpload;
                    $targetLocation = UPFLD."/sample";

                    $TWH[0]         = 309;      // thumb width
                    $TWH[1]         = 205;      // thumb height
                    $LWH[0]         = 640;      // large width
                    $LWH[1]         = 424;      // large height
                    $option         = 'all';    // upload, thumbnail, resize, all       

                    if($_FILES['proimg']['size']<=2097152) // max 2MB
                    {      
                        if($_FILES['proimg']['name'] && substr($_FILES['proimg']['type'],0,5)=='image')
                        {
                            $fileName = time();
                            if($target_image = $fObj->uploadImage($_FILES['proimg'], $targetLocation, $fileName, $TWH, $LWH, $option)){	

                                $pImg = $uObj->sampleById($editId);
                                if($pImg['productImage'])
                                {
                                    @unlink($targetLocation.'/normal/'.$pImg['productImage']);
                                    @unlink($targetLocation.'/thumb/'.$pImg['productImage']);	
                                    @unlink($targetLocation.'/large/'.$pImg['productImage']);
                                }

                                $params = array();
                                $params['productImage']  = $target_image;
                                $uObj->sampleUpdateBysampleId($params, $editId);
                            }
                        }
                    }
                    else{
                        $error = 1;
                        echo '<div class="errormsg">Sample image is too large to be uploaded! Your file size should be 2MB max.</div><div class="clearfix"></div>';
                    }
                }
                
                $attributeIdArray= $_REQUEST['attributeIdArray'];
                        
                if(sizeof($attributeIdArray)>0)
                { 
                    $uObj->deleteAttributeBysampleId($editId);

                    for($i=0;$i<sizeof($attributeIdArray);$i++)
                    {
                        $attributeValueArray = $_REQUEST['attributeValueArray_'.$i];

                        for($j=0;$j<sizeof($attributeValueArray);$j++)
                        {
                            if($attributeValueArray[$j])
                            {
                                $params = array();
                                $params['attributeId']      = $attributeIdArray[$i];
                                $params['sampleId']        = $editId;
                                $params['attributeValue']   = $attributeValueArray[$j];
                                $uObj->newSampleAttribute($params);
                            }
                        }
                    }
                }
                
                if($addId){
                    /*----------Admin Mail------------*/
                    $cnObj          = new Contact;
                    $msg_details    = $cnObj ->  getEmailBodyById(61);

                    $to         = SITE_EMAIL;
                    $from       = "From: ".$_SESSION['FUSERFULLNAME']."<".$_SESSION['FUSEREMAIL'].">";
                    $subject    = $msg_details['emailSubject'];
                    $msg        = $msg_details['emailBody'];

                    $other  = 'Seller '.$_SESSION['FUSERFULLNAME'].', has requested you to procees the sample request having request # - '.$sampleReqId;

                    $arr = array(
                            "{other}" 	            => $other,
                    );

                    $msg    = strtr($msg,$arr);

                    sendEmail($to, $from, $subject, $msg);
                    
                    /*----------Seller Mail------------*/
                    $smsg_details    = $cnObj ->  getEmailBodyById(62);
                    
                    $sto         = $_SESSION['FUSEREMAIL'];
                    $sfrom       = "From: ".SITE_NAME."<".SITE_EMAIL.">";
                    $ssubject    = $smsg_details['emailSubject'];
                    $smsg        = $smsg_details['emailBody'];
                    
                    $sother = 'Thank you for signing up for Annexis Samples and Distribution. You are one step
                            away from sending and managing your samples. Your samples and distribution
                            application is under review by our samples management team, we will calculate the
                            amount of space you will need based on the information you provided. Please allow
                            two days for processing. A samples management team member will call you with a
                            proposal.<br>
                            Your samples and distribution account is under review now.';

                    $sarr = array(
                            "{other}" 	            => $sother,
                    );

                    $smsg    = strtr($smsg,$sarr);

                    sendEmail($sto, $sfrom, $subject, $smsg);
                    
                }	               

            }
            else{
                $error = 1;
                echo '<div class="errormsg">Post already exists!</div>';
            }
        }


      //   elseif($SourceForm == 'saveReplymsz'){
      //       $uObj = new MemberView; 
      //       $params = array();  
      //       $params['userId'] = $_SESSION['FUSERID'];
      //       $params['subject']= $subject;
      //       $params['contactComments'] = $comment;
      //       $params['sellerId'] = $toId;
      //       $params['parentId'] = $contactID;
      //       $params['name'] = $_SESSION['FUSERFULLNAME'];
      //      // print_r($params); 
      //      $uObj->insertReply($params);
      //       // $result_arr = array();
      //       // $result_arr['error']  = 0;
      //       // $result_arr['msg']  = "Message Sent";
      //      // echo json_encode($result_arr);
      //      // echo "Message Sent";

      // }
        /*elseif($SourceForm == 'addQty')
        { 
            $uObj = new MemberView;   
            
            $params                = array();
            $params['sampleReqId'] = time().$_SESSION['FUSERID'];
            $uObj->sampleUpdateBysampleId($params, $sampleId);
            
            $insk        = $uObj->getLastsampleQty($ExtraQryStr);
            $inStock     = $insk['inStock']+$qty;
                
            $smpleQty               = array();
            $smpleQty['ct']         = $qty;
            $smpleQty['userId']     = $_SESSION['FUSERID'];
            $smpleQty['sampleId']   = $sampleId;
            $params['sampleReqId']  = time().$_SESSION['FUSERID'];
            $smpleQty['entryDate']  = date("Y-m-d H:i:s");
            $uObj->newSampleQty($smpleQty);
            
            
            echo '<div class="successmsg">Quantity added successfully.</div><div class="clearfix"></div>';
        }*/
        elseif($SourceForm == 'sampleSend'){ 
            
            $sample = $_REQUEST['sample'];
                        
            $qty    = $_REQUEST['qty'];
            
            if($uname && $uphone && $uemail && $uadd){
                
                $uObj = new MemberView;   
                
                $params = array();
                
                foreach($sample as $key=>$smp){
                    
                    $params['uId']              = $utoId;
                    $params['userId']           = $_SESSION['FUSERID'];
                    $params['uname']            = $uname;
                    $params['uphone']           = $uphone;
                    $params['uemail']           = $uemail;
                    $params['uadd']             = $uadd;
                    $params['sampleId']         = $smp;
                    $params['qty']              = $qty[$key];
                    $params['status']           = 'Pending';
                    $params['shippingRef']      = md5(time());
                    $params['entryDate']        = date("Y-m-d H:i:s");
                    
                    $smpHistry = $uObj->newSampleHistory($params);
                    
                    if($smpHistry){
                        
                        $smpdt      = $uObj->sampleQtyById($smp);
                        $inStock    = $smpdt['totalQty']-$qty[$key];

                        $sampQty = array();
                        $sampQty['sampleId']    = $smp;
                        $sampQty['userId']      = $_SESSION['FUSERID'];
                        $sampQty['dt']          = $qty[$key];
                        $sampQty['inStock']     = $inStock;
                        $sampQty['entryDate']   = date("Y-m-d H:i:s");

                        $uObj->newSampleQty($sampQty);
                        
                        $param                 = array();
                        $param['totalQty']     = $inStock;

                        $uObj->sampleUpdateBysampleId($param, $smp);

                        $to          = 'site-control@eclickapps.com';
                        $from       = "From: ".SITE_NAME."<order@annexis.net>";
                        $subject    = 'New Sample request';	

                        $msg        = "Dear Administrator,<br><br>		
                            A new sample request has been added with the following information.<br><br>		
                            Name        : ".$uname."<br>	
                            Phone       : ".$uphone."<br>	
                            Email       : ".$uemail."<br><br>
                            Address     : ".$uadd."<br><br>				
                            Sample      : ".$smpdt['productName']."<br>			
                            Sample Qty  : ".$qty[$key]."<br>";				
                        
                        $msg        .= "Thanking you,<br>
                        ".SITE_NAME;
                        
                        sendEmail($to,$from,$subject,$msg);
                    }                   
                }
                
                echo '<div class="successmsg">Request has been send to administrator successfully.</div><div class="clearfix"></div>';
                
            }
            else
                echo '<div class="errormsg">All fields are mandatory.</div><div class="clearfix"></div>';
        }
        elseif($SourceForm == 'sampleReqAdmin'){
            
            $cnObj = new Contact();
            $uObj  = new MemberView;   
            
            $sampleData = $cnObj->contactById($cid);
            $sample     = $uObj->sampleByproductId($sampleData['proId']);
            if($sampleData){
                
                if($qty>$sample['totalQty']){
                        echo '<div class="errormsg">Please add more sample to process the sample request.</div>
                            <div class="clearfix"></div>';
                }
                else{
                    $params = array();
                    $params['qty']          = $qty;
                    $params['unitType']     = $unitType;
                    $params['currency']     = $currency;
                    $params['price']        = $price;
                    $params['sendStatus']   = 'Requested to Proceed';
                    //$params['requestId']    = time().$cid;                
                    $cnObj->contactUpdateBycontactId($params, $cid);                      
                    
                    /*-------------------ADMIN---------------------------*/
                    $msg_details    = $cnObj -> getEmailBodyById(55);

                    $to         = SITE_EMAIL;
                    $from       = "From: ".$_SESSION['FUSERFULLNAME']."<".$_SESSION['FUSEREMAIL'].">";
                    $subject    = $msg_details['emailSubject'];            
                    $msg        = $msg_details['emailBody'];

                    $other  = 'Seller '.$_SESSION['FUSERFULLNAME'].', has requested you to procees the sample request having request # - '.$sampleData['requestId'];

                    $arr = array(
                            "{other}" 	            => $other,
                    );
                    $msg    = strtr($msg,$arr);

                    sendEmail($to, $from, $subject, $msg);         


                    echo '<div class="successmsg">Request successfully send to administrator.</div><div class="clearfix"></div>';
                    
                }
                     
            }
        }
        elseif($SourceForm == 'signaturesmcont'){                        
            $uObj = new MemberView;   
            $uObj->signaturesamplecont();
        }
    }
    catch(Exception $e)
    {
        if($ajax==1){

        	$result_arr = array();
        	$result_arr['type']		= 0;
        	$result_arr['msg']		= "Session timed out!";
        	$result_arr['redirect']	= $SITE_LOC_PATH.'/login/';
        	echo json_encode($result_arr);
            //echo '<span class="error">Form ignored!</span>';
        }else
            $ErrMsg = '<p class="error">Session timed out!</p>';
        //$result = $e->getMessage() . ' Form ignored.';
    }
}
?>