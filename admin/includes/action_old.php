<?php
/*************************************************************************************************
Include Section Started
*************************************************************************************************/
include("../lib/class/admin.class.php");
include("../lib/class/user.class.php");
/*************************************************************************************************
Include Section Ended
*************************************************************************************************/
/*************************************************************************************************
Checking For Login Section Started
*************************************************************************************************/
if(isset($CheckLogin) && $CheckLogin == 'Login')
{
    if(!$_SESSION['PROTECT'])
        $_SESSION['PROTECT'] = 1;
    else    
        $_SESSION['PROTECT']++;
    try
    {
        // Run CSRF check, on POST data, in exception mode, for 10 minutes, in one-time mode.
        NoCSRF::check('csrf_token', $_POST, true, 60*10, true);
        
        if($_SESSION['PROTECT']<10){
            $EnteredUname = trim($LoginName);
            $EnteredPassword = trim($LoginPass);

            if($EnteredUname && $EnteredPassword)
            {
                $EnteredPassword = md5($LoginPass);
                $admin = new admin();
                $sel_UserDetails = $admin->lookup($EnteredUname, $EnteredPassword);
                if($sel_UserDetails!=0)
                {
                    $_SESSION['LOGIN'] = 'YES';
                    $_SESSION['UID'] = $sel_UserDetails['id'];
                    $_SESSION['UNAME'] = $sel_UserDetails['fullname'];
                    $_SESSION['UTYPE'] = $sel_UserDetails['usertype'];
                    $_SESSION['ADD_ACCESS'] = $sel_UserDetails['access_add'];
                    $_SESSION['EDIT_ACCESS'] = $sel_UserDetails['access_edit'];
                    $_SESSION['DELETE_ACCESS'] = $sel_UserDetails['access_delete'];
                    $_SESSION['SITE_ID'] = $sel_UserDetails['siteId'];
                    $_SESSION['PERMISSION'] = $sel_UserDetails['permission'];
                    $fetchSiteDetails = $admin->siteDetailsBysiteId($_SESSION['SITE_ID']);			
                    if($fetchSiteDetails)
                    {			
                        $_SESSION['SITE_URL'] = $fetchSiteDetails['siteUrl'];
                        $_SESSION['SITE_NAME'] = $fetchSiteDetails['siteName'];
                    }
                    if($remember)
                    {
                        setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
                        setcookie("user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
                        setcookie("user_name",$_SESSION['user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
                    }			
                }
                else
                {
                    $_SESSION['LOGIN']='NO';
                    $ErrMsg = '<span class="error" >Invalid entry!</span>';
                }		
            }
            else
                $ErrMsg = '<span class="error">All fields are mandatory!</span>';
        }
        else{
            $ErrMsg = '<span class="error">Maximum login attempts exceeded!</span>';
        }
    }
    catch(Exception $e)
    {
        if($ajax==1)
            echo '<span class="error">Form ignored!</span>';
        else
            $ErrMsg= '<span class="error">Form ignored!</span>';
        //$result = $e->getMessage() . ' Form ignored.';
    }
}
/*************************************************************************************************
Checking For Login Section Ended
*************************************************************************************************/

/*************************************************************************************************
Updating For Menu Section Ended
*************************************************************************************************/

/*************************************************************************************************
Logout Section Started
*************************************************************************************************/
if(isset($pageType) && $pageType == 'logout')
{	
    session_unset();
    session_destroy();
    /* Delete the cookies*******************/
    setcookie("user_id", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
    setcookie("user_name", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
    setcookie("user_key", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
    //---------------------------------------
    $siteObj = new Site;
    $siteObj->redirectToURL($SITE_LOC_PATH.'/admin/');
}
/************************************************************************************************
Logout Section Ended
*************************************************************************************************/

/************************************************************************************************
Forgot Password Action Started
************************************************************************************************/
if(isset($Submit) && $SourceForm=='ForgotPassword')
{
	if($Email!='')
	{
		$sel_UserDetails = mysql_query("select * from ".TBL_USER." where email = '".$Email."' and status = 'Y' and usertype!='A'");
		$fetch_UserDetails = mysql_fetch_array($sel_UserDetails);
		if(mysql_num_rows($sel_UserDetails)>0)
		{
			$to       =  $fetch_UserDetails['email'];
			$subject  = SITE_NAME.' :: Forgot Password';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			//$headers .= 'To: '.$fetch_UserDetails['name'].' <'.$fetch_UserDetails['email'].'>' . "\r\n";
			$headers .= 'From: no-reply';
			$message  = "
			Here is your Login details<br><br>
			User Name: ".$fetch_UserDetails['username']."<br>
			Password: ".$fetch_UserDetails['orgPassword']."<br>";
			@mail($to, $subject, $message, $headers);
			$ErrMsg = '<div class="success" style="width:93%">Password has been sent to your email address</div>';
		}
		else
			$ErrMsg = '<div class="error" style="width:93%">No Match Found For This Email !!</div>';
	}
	else
		$ErrMsg = '<div class="error" style="width:93%">All Fields Are Mandatory</div>';
}
/************************************************************************************************
Forgot Password Action Ended
************************************************************************************************/
?>