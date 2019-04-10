<?php
if($editid!='')
{
	$IdToEdit  = $editid;
	$obj       = new MemberAdmin();
	$selData   = $obj -> getMemberInfoByid($IdToEdit);
}
$menu       = new menu();
$menudata   = $menu -> menu_by_id($moduleId);
if($menudata)
{
	$menu_image        = $menudata['menu_image'];
	$menu_name         = $menudata['menu_name'];
	$parentMenuId      = $menudata['parent_id'];
	$parentmenudata    = $menu -> menu_by_id($parentMenuId);
	$parent_menu_name  = $parentmenudata['menu_name'];
}
?>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?><span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?><span>→</span></a></li>
    <li><a href="#"><?php echo $selData['name'];?></a></li>
</ul>
<?php echo $ErrMsg;?>
<form name="modifycontent" action="" method="post" enctype="multipart/form-data">
	<div class="form_holder">
        <p class="description-line1">Email</p>
		<p class="description-line1"><input type="text" name="email" value="<?php echo $selData['email'];?>" readonly="readonly" /></p>
		<p class="description-line1">New Password</p>
		<p class="description-line1"><input type="text" name="password" value="<?php echo $password;?>" /></p>		
		<p class="description-line1"><input type="checkbox" name="sendmail" value="send" /> Send email to user</p>
	</div>	 
    <input name="IdToEdit" type="hidden" value="<?php echo $IdToEdit;?>" />
    <input name="SourceForm" type="hidden" class="savebtn" value="ResetPassword" />		
    <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
    <input name="Save" type="submit" class="save_frm" value="Save" />
    <input name="Cancel" type="button"  onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $moduleId;?>'" class="save_frm" value="Cancel" />
    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
</form>