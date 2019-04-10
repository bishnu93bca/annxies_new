<?php
$obj = new MyAccount();
$selData = $obj->getAccountDetailsByuserId($_SESSION['UID']);
if($selData)
{
	$fullname              = $selData['fullname'];
	$siteName              = $selData['siteName'];
	$siteEmail             = $selData['siteEmail'];
	$siteNoreply           = $selData['siteNoreply'];
	$sitePhone             = $selData['sitePhone'];
	$siteMobile            = $selData['siteMobile'];
	$location              = $selData['location'];
	$sitePaypalEmail       = $selData['sitePaypalEmail'];
	$siteCurrency          = $selData['siteCurrency'];
	$sitePaypalSuccessPath = $selData['sitePaypalSuccessPath'];	
	$sitePaypalCancelPath  = $selData['sitePaypalCancelPath'];
}
$mObj=new menu();
$menudata= $mObj -> menu_by_id($moduleId);
if($menudata)
{
	$menu_image        = $menudata['menu_image'];
	$menu_name         = $menudata['menu_name'];
	$parentMenuId      = $menudata['parent_id'];
	$parentmenudata    = $mObj -> menu_by_id($parentMenuId);
	$parent_menu_name  = $parentmenudata['menu_name'];
}
?>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
</ul>
<?php if($ErrMsg) echo $ErrMsg;?>

<form name="modifycontent" action="" method="post">
    <div class="width49_left" style="width:49%; float:left;">
        <div class="form_holder">
            <fieldset>
                <legend>Site Settings</legend>
                <p class="description-line1">Site Name *</p>
                <p class="description-line1"><input name="siteName" type="text" class="property-input" value="<?php echo $siteName;?>"/></p>
                <p class="description-line1">Site Email * (Contact, inquiry or order related mails will be received in this email)</p>
                <p class="description-line1"><input name="siteEmail" type="text" class="property-input" value="<?php echo $siteEmail;?>" /></p>
                <p class="description-line1">No-Reply Email * </p>
                <p class="description-line1"><input name="siteNoreply" type="text" class="property-input" value="<?php echo $siteNoreply;?>" /></p>
                <p class="description-line1"> Site Phone *</p>
                <p class="description-line1"><input name="sitePhone" type="text" class="property-input" value="<?php echo $sitePhone;?>"/></p>
                <p class="description-line1"> Site Mobile </p>
                <p class="description-line1"><input name="siteMobile" type="text" class="property-input" value="<?php echo $siteMobile;?>"/></p>
                <p class="description-line1"> Location </p>
                <p class="description-line1">
                    <textarea name="location"><?php echo $location;?></textarea>
                </p>
                <p class="description-line1">Admin Name *</p>
                <p class="description-line1"><input name="fullname" type="text" class="property-input" value="<?php echo $fullname;?>"/></p>
            </fieldset>
        </div>
    </div>
    <br class="clear">
    <div class="form_holder">	
        <p class="description-line1">   
            <input name="SourceForm" type="hidden" value="MyAccount" />
            <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
            <input name="Save" type="submit" class="save_frm" value="Save" />
            <input name="Cancel" type="button"  onclick="window.location.href='index.php'" class="cancel_frm" value="Close" />
            <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
        </p>
    </div>
</form>