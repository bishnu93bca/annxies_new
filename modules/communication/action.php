<?php
if($_POST){
    if($_POST['ajax']==1)
        include("../../ext_include.php");
    try
    {
        // Run CSRF check, on POST data, in exception mode, for 10 minutes, in one-time mode.
        //NoCSRF::check('csrf_token', $_POST, true, 60*10, true);
        /********************************************************************
        Contact Form Action Started
        ********************************************************************/
        if($_POST['SourceForm'] == 'contactUs')
        {  
            $obj = new Contact;
            if($name!='' && $email!='' && $contactComments!=''){
                $gObj = new genl();
                if($gObj->validate_email($email)) {
                    
                        $uObj   = new MemberView;    
                        $stDet  = $uObj->stateByCode($state_office);
                        $ofcDet = $uObj->readofficenamebyId($office_name);
                    
                        $params                      = array();
                        $params['name']              = $name;
                        $params['email']             = $email;
                        $params['phone']             = $phone;
                        $params['state_office']      = $state_office;
                        $params['city_office']       = $city_office;
                        $params['office_name']       = $office_name;
                        $params['product']           = $productOfIn;
                        $params['contactComments']   = $contactComments;
                        $params['contactEntrydate']  = date("Y-m-d H:i:s");
                        $params['status']  		     = "Y";
                        $params['contactType'] 	     = 'C';

                        $insId = $obj -> newContact($params);
                    
                        if($insId){

                            $to         = SITE_EMAIL;
                           // $to         = 'site-control@eclickapps.com';
                            $from       = "From: ".SITE_NAME." <".SITE_NOREPLY.">";
                            $subject    = SITE_NAME." :: Contact Information";		
                            $message        = "Dear Administrator,<br><br>		
                                A new contact has been added with the following information.<br><br>		
                                Name: ".$name."<br>	
                                Email: ".$email."<br>
                                Phone: ".$phone."<br>
                                Product of interest: ".$productOfIn."<br>
                                Office State: ".$stDet['state']."<br>
                                Office City: ".$ofcDet['office_city']."<br>
                                Office Name: ".$ofcDet['office']."<br>
                                <br>";				
                            $message        .= "Message: ".$contactComments."<br><br><br>";			
                            $message        .= "Thanking you,<br>
                            ".SITE_NAME;                   
                    

                            sendEmail($to, $from, $subject, $message);

                            
                            if($ajax==1)
                                echo 'success>Thank you for your interest. Our representative will contact you soon.';
                            else
                                $ErrMsg = '<p class="success">Thank you for your interest. Our representative will contact you soon.</p>';
                        }
                        else{
                            if($ajax==1)
	                                echo 'error>Error!';
                            else
                                $ErrMsg = '<p class="error">Error!</p>';
                        }
                      
                    }
                    else{
                        if($ajax==1)
                            echo 'error>Invalid email address!';
                        else
                            $ErrMsg = '<p class="error">Invalid email address!</p>';
                    }
                }
                else{
                    if($ajax==1)
                        echo 'error>All Fields are mandatory!';
                    else
                        $ErrMsg = '<p class="error">All fields are mandatory!</p>';
                }
                              
        }
        /********************************************************************
        Contact Form Action Ended
        ********************************************************************/
        /********************************************************************
        Quote Form Action Started
        ********************************************************************/
        if($_POST['SourceForm'] == 'quote')
        {  
            $obj = new Contact;
            if($name!='' && $email!='' && $phone!='' && $product!=''){
                $gObj = new genl();
                if($gObj->validate_email($email)) {
                                     
                        $params                      = array();
                        $params['name']              = $name;
                        $params['email']             = $email;
                        $params['phone']             = $phone;
                        $params['product']           = $product;
                        $params['contactEntrydate']  = date("Y-m-d H:i:s");
                        $params['status']  		     = "Y";
                        $params['contactType'] 	     = 'Q';

                        $insId = $obj -> newContact($params);
                    
                        if($insId){

                            //$to         = SITE_EMAIL;
                            $to         = 'site-control@eclickapps.com';
                            $from       = "From: ".SITE_NAME." <".SITE_NOREPLY.">";
                            $subject    = SITE_NAME." :: Quote Information";		
                            $message        = "Dear Administrator,<br><br>		
                                A new quote has been added with the following information.<br><br>		
                                Name: ".$name."<br>	
                                Email: ".$email."<br>
                                Phone: ".$phone."<br>
                                Product: ".$product."<br>
                                <br><br>";			
                            $message        .= "Thanking you,<br>
                            ".SITE_NAME;                   
                    

                            sendEmail($to, $from, $subject, $message);

                            
                            if($ajax==1)
                                echo 'success>Thank you for your interest. Our representative will contact you soon.';
                            else
                                $ErrMsg = '<p class="success">Thank you for your interest. Our representative will contact you soon.</p>';
                        }
                        else{
                            if($ajax==1)
	                                echo 'error>Error!';
                            else
                                $ErrMsg = '<p class="error">Error!</p>';
                        }
                      
                    }
                    else{
                        if($ajax==1)
                            echo 'error>Invalid email address!';
                        else
                            $ErrMsg = '<p class="error">Invalid email address!</p>';
                    }
                }
                else{
                    if($ajax==1)
                        echo 'error>All Fields are mandatory!';
                    else
                        $ErrMsg = '<p class="error">All fields are mandatory!</p>';
                }
                              
        }
        /********************************************************************
        Quote Form Action Ended
        ********************************************************************/
	}
    catch(Exception $e)
    {
        if($ajax==1)
            echo 'Form ignored!';
        else
            $ErrMsg = '<p class="error">Form ignored!</p>';
    }
}
?>