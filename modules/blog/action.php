<?php
if($_POST){
    if($_POST['ajax']==1)
    	include("../../ext_include.php");
    try
    {
        // Run CSRF check, on POST data, in exception mode, for 10 minutes, in one-time mode.
        //NoCSRF::check('csrf_token', $_POST, true, 60*10, true);
        /********************************************************************
        Comment Form Action Started
        ********************************************************************/
        if($_POST['SourceForm'] == 'BlogComment')
        { 
        	if($author != '' && $email != '' && $blogContent!='')
            { 
                $gObj = new genl();
                if($gObj->validate_email($email))
                {
                                        	
	                        $obj = new Comment;
	                        $params                  = array();
	                        $params['blogAuthor']    = $author;
	                        $params['authoremail']   = $email;
	                        $params['blogContent']   = $blogContent;
	                        $params['blogParent']    = $blogId;
	                        $params['blogDate']      = date('Y-m-d H:i:s');
	                        $params['status']        = 'Y';
	                        $params['isApproved']    = 'N';
	                        $params['blogType']      = 'C';
	                        $insId = $obj -> newComment($params);
                        
                            if($insId)
                            { 
                                $to         = SITE_EMAIL;
                                 //$to         = 'site-control@eclickapps.com';
                                $from       = "From: ".SITE_NAME." <".SITE_NOREPLY.">";
                                $subject    = SITE_NAME." :: Blog Information";		
                                $msg        = "Dear Administrator,<br><br>		
                                    A new comment has been added with the following information.<br><br>		
                                    Name: ".$author."<br>	
                                    Email: ".$email."<br><br>";				
                                $msg        .= "Message: ".$blogContent."<br><br><br>";			
                                $msg        .= "Thanking you,<br>
                                ".SITE_NAME;
                                
                                sendEmail($to,$from,$subject,$msg);
                                $_SESSION['msg-show'] = 'Y';
                                if($ajax==1)
                                    echo 'success>Thank you for your interest. Your comments has been sent to administrator for approval.';
                                else
                                    $ErrMsg = '<p class="success">Thank you for your interest. Your comments has been sent to administrator for approval.</p>';
                               
	                        }
	                        else
	                        {
	                            if($ajax==1)
	                                echo 'error>Error!';
	                            else
	                                $ErrMsg = '<p class="error">Error!</p>';
	                        }
                   	    
                   
                }	
                else
                {
                    if($ajax==1)
                        echo 'error>Email ID is invalid!';
                    else
                        echo $ErrMsg= '<p class="error">Email ID is invalid!</p>';
                }
            }
            else{
                if($ajax==1)
                    echo 'error>All Fields are mandatory!';
                else
                    echo $ErrMsg= '<p class="error">All fields are mandatory!</p>';
            }
        }
        /*************************************************************************************************
        Comment Form Action Ended
        *************************************************************************************************/
    }
    catch(Exception $e)
    {
        if($ajax==1)
            echo 'Form ignored!';
        else
            $ErrMsg = '<p class="error">Form ignored!</p>';
        //$result = $e->getMessage() . ' Form ignored.';
    }
}
?>
