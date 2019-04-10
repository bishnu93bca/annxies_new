<?php
/************************************************************************
Change Password Section Started
************************************************************************/
if(isset($Save) && $SourceForm=='MyAccount')
{
	if($siteName!='' && $siteEmail!='' && $siteNoreply!='' && $sitePhone!='' && $fullname!='')
	{
        $uObj   = new user;
        $params = array();
        $params['fullname'] = $fullname;
        $uObj->userUpdate($params, $_SESSION['UID']);
        
        $sObj   = new Site;
        $params = array();
        $params['siteName']                 = $siteName;
        $params['siteEmail']                = $siteEmail;
        $params['siteNoreply']              = $siteNoreply;
        $params['sitePhone']                = $sitePhone;
        $params['siteMobile']               = $siteMobile;
        $params['location']                 = $location;
        $params['siteCurrency']             = $siteCurrency;
        $params['sitePaypalEmail']          = $sitePaypalEmail;
        $params['sitePaypalSuccessPath']    = $sitePaypalSuccessPath;
        $params['sitePaypalCancelPath']     = $sitePaypalCancelPath;        
        $CLAUSE = "siteId=".$_SESSION['SITE_ID'];
        $sObj->updateQuery(TBL_SITE, $params, $CLAUSE);

		$ErrMsg = '<div class="success">Data Updated Successfully</div>';
	}
	else
		$ErrMsg = '<div class="error">* Marked Field(s) Are Mandatory !!</div>';
}
/************************************************************************
Change Password Section Ended
************************************************************************/
?>