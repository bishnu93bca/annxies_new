<?php
/************************************************************************
Change Password Section Started
************************************************************************/
if(isset($Save) && $SourceForm=='SitePassword')
{
	$admin=new admin();
	$sel_details = $admin -> getUserByid($_SESSION['UID']);
	$OriginalPassword = $sel_details['password'];
	
	if($CurrPassword!='' && $NewPassword!='')
	{
		if($OriginalPassword == md5($CurrPassword))
		{
			if($NewPassword == $ReNewPassword)
			{				
				if($update = $admin -> updatePasswordByid($NewPassword, $_SESSION['UID']))
					$ErrMsg = '<div class="success">Password Changed Successfully</div>';
				else
					$ErrMsg = '<div class="error">Error! Unable to change password.</div>';			
			}
			else
				$ErrMsg = '<div class="warning">New password does not match!</div>';
		}
		else
			$ErrMsg = '<div class="error">Please enter current password correctly!</div>';
	}
	else
		$ErrMsg = '<div class="error">Fields marked with (*) are mandatory!</div>';
}
/************************************************************************
Change Password Section Ended
************************************************************************/
?>