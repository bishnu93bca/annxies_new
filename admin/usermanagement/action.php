<?php
/*************************************************************************************************
Add / Edit Site Information Started
*************************************************************************************************/
if(isset($Save) && $SourceForm == 'SiteInformation')
{
	if($username!='' && $password!='' && $siteName!='' && $siteUrl!='' && $siteEmail!='' && $fullname!='' && $email!='' &&$profilePic!='')
	{			
		$checkhttp = substr($siteUrl,0,7);
		if($checkhttp!='http://')
		{
			$checkwww = substr($siteUrl,0,4);
			if($checkwww!='www.')
			{			
				$checkslash = substr($siteUrl,-1);
				if($checkslash!='/')
				{
					if(trim($password)==trim($conpassword))
					{
                        $sObj = new Site;
                        $uObj = new user;
                        
						if($IdToEdit!='')
						{                           
                            $params = array();
                            $params['siteName']     = $siteName;
                            $params['siteUrl']      = $siteUrl;
                            $params['siteEmail']    = $siteEmail;
                            $params['sitePhone']    = $sitePhone;
                            $CLAUSE = "siteId=".$siteId;
                            $sObj->updateQuery(TBL_SITE, $params, $CLAUSE);							
                            
                            $params = array();
                            $params['password']     = md5(trim($password));
                            $params['orgPassword']  = trim($password);
                            $params['fullname']     = trim($fullname);
                            $params['email']        = trim($email);
                            $params['phone']        = trim($phone);
                            $params['address']      = trim($address);
                            $params['profilePic']   = trim($profilePic);
                            $uObj->userUpdate($params, $IdToEdit);
							
							$_SESSION['ErrMsg'] = '<div class="success">Data Updated Successfully</div>';
                            $sObj->redirectToURL("index.php?pageType=".$pageType);
						}
						else
						{							
							$sel_ContentDetails = $uObj->user_by_username($username);
                                
							if(!$sel_ContentDetails)
							{
                                $params = array();
                                $params['siteName']    = $siteName;
                                $params['siteUrl']     = $siteUrl;
                                $params['siteEmail']   = $siteEmail;
                                $params['sitePhone']   = $sitePhone;
                                $params['profilePic']   = trim($profilePic);
                                $params['status']      = 'Y';
                                $siteId = $sObj->insertQuery(TBL_SITE, $params);
                                
                                $params = array();
                                $params['username']     = $username;
                                $params['password']     = md5(trim($password));
                                $params['orgPassword']  = trim($password);
                                $params['fullname']     = $fullname;
                                $params['email']        = $email;
                                $params['phone']        = $phone;
                                $params['address']      = $address;
                                $params['profilePic']   = trim($profilePic);
                                $params['usertype']     = 'M';
                                $params['siteId']       = $siteId;
                                $params['createDate']   = date('Y-m-d H:i:s');
                                $params['status']       = 'Y';
                                $userId = $sObj->insertQuery(TBL_USER, $params);								
								
								//include("usermanagement/dummydata.php");
								//include("usermanagement/mail.php");				
								
								$_SESSION['ErrMsg'] = '<div class="success">Data Inserted Successfully</div>';
								$step = 2;
							}
							else
								$_SESSION['ErrMsg'] = '<div class="error">'.$username.' Already Exists.</div>';
						}
					}
					else
						$_SESSION['ErrMsg'] = '<div class="error">Confirm Password Missmatched.</div>';	
				}
				else
					$_SESSION['ErrMsg'] = '<div class="error">Site Url Should Not Contain "/".</div>';
			}
			else
				$_SESSION['ErrMsg'] = '<div class="error">Site Url Should Not Contain "www.".</div>';
		}
		else
			$_SESSION['ErrMsg'] = '<div class="error">Site Url Should Not Contain "http://" or "http://www.".</div>';
	}
	else
		$_SESSION['ErrMsg'] = '<div class="error">* Marked Fields Are Mandatory.</div>';
}
/************************************************************************************************
Add / Edit Site Information Ended
*************************************************************************************************/

/************************************************************************************************
Add / Edit Module Permission Started
*************************************************************************************************/
if(isset($Save) && $SourceForm == 'ModulePermission')
{
	$obj = new menu();
	foreach($_REQUEST['permission'] as $val)
		$compactpermission =$compactpermission.$val.',';
    
	foreach($_REQUEST['subpermission'] as $val)
	{
		$mData = $obj -> menu_by_id($val);
		if(!in_array($mData['parent_id'], $_REQUEST['permission']))
			$compactpermission =$compactpermission.$mData['parent_id'].',';
		$compactpermission =$compactpermission.$val.',';
	}
    
	$compactpermission =substr($compactpermission,0,-1);
    
    $uObj = new user;    
    $params = array();
    $params['permission'] = $compactpermission;
    $uObj->userUpdate($params, $userId);
    
	$_SESSION['ErrMsg'] = '<div class="success">Module Permission set successfully</div>';
	$step = 3;
}
/*************************************************************************************************
Add / Edit Module Permission Ended
*************************************************************************************************/
/*************************************************************************************************
Add / Edit Theme Allocation Started
*************************************************************************************************/
if(isset($Save) && $SourceForm == 'ThemeAllocation')
{
	$themeArray = $_REQUEST['allocatedthemeId'];
	$themes ='';			
	if($_REQUEST['allocatedthemeId'])
	{
		for($i=0;$i<sizeof($themeArray);$i++)
		{
			$themes .= $themeArray[$i].'#';
		}
		$themes = substr($themes,0,-1);	
	}
	if(!$themeId && $_REQUEST['allocatedthemeId'])		
		$themeId = $themeArray[0];				
	mysql_query("UPDATE ".TBL_SITE." SET themeId = '".addslashes($themeId)."' WHERE siteId = $siteId")or die(mysql_error());	
	mysql_query("UPDATE ".TBL_USER." SET themes = '".addslashes($themes)."' WHERE id = $userId")or die(mysql_error());
	$_SESSION['ErrMsg'] = '<div class="valid_box">Theme Allocated Successfully</div>';
	?>
	<script language="javascript">
	window.location.href="index.php?pageType=<?php echo $pageType?>";
	</script>	
	<?php
}
/*************************************************************************************************
Add / Edit Theme Allocation Ended
*************************************************************************************************/
?>