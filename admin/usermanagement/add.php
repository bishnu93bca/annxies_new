<?php
if($editid!='')
{
	$obj = new MyAccount();
	$selData = $obj->getAccountDetailsByuserId($editid);
	if($selData)
	{
		$username = $selData['username'];
		$password = $selData['orgPassword'];
		$fullname = $selData['fullname'];
		$email = $selData['email'];
		$address = $selData['address'];
		$phone = $selData['phone'];
		$siteId = $selData['siteId'];
		$siteName = $selData['siteName'];
		$siteUrl = $selData['siteUrl'];
		$siteEmail = $selData['siteEmail'];
		$sitePhone = $selData['sitePhone'];
		$sitePaypalEmail = $selData['sitePaypalEmail'];
		$siteCurrency = $selData['siteCurrency'];
		$sitePaypalSuccessPath = $selData['sitePaypalSuccessPath'];
		$sitePaypalCancelPath = $selData['sitePaypalCancelPath'];
		
		$sitePath = $selData['sitePath'];
		$location = $selData['location'];
		$googleAnalytics = $selData['googleAnalytics'];
		$googleVerification = $selData['googleVerification'];
		$metaDistribution = $selData['metaDistribution'];
		$metaClassification = $selData['metaClassification'];
		$metaCopyright = $selData['metaCopyright'];
		$metaLanguage = $selData['metaLanguage'];
		$metaAuthor = $selData['metaAuthor'];
		$metaRobots = $selData['metaRobots'];
		$metaGenerator = $selData['metaGenerator'];
		
		$access_add = $selData['access_add'];
		$access_edit = $selData['access_edit'];
		$access_delete = $selData['access_delete'];
		$themes = $selData['themes'];
		$themeId = $selData['themeId']; 		
		
		$userpermission_array = explode(',',$selData['permission']);		
	}
}
?>
<?php
if($_SESSION['ErrMsg'])
	echo $_SESSION['ErrMsg'];
	
unset($_SESSION['ErrMsg']);

echo $ErrMsg;

if($step==1 || $step=='')
	include("usermanagement/siteinformation.php");
elseif($step==2)
	include("usermanagement/modulepermissions.php");
elseif($step==3)
	include("usermanagement/themeallocation.php");?>
	

