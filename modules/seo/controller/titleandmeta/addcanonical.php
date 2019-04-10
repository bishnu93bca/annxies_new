<?php
if($editid!='')
{
    $obj = new PageTitle;
	$fetch_details = $obj->canonicalById($editid);
	$IdToEdit = $fetch_details['canonicalId'];
	$canonicalText = $fetch_details['canonicalText'];	
	$canonicalUrl = $fetch_details['canonicalUrl'];	
}
$menu=new menu();
$menudata= $menu -> menu_by_id($moduleId);
if($menudata)
{
	$menu_image = $menudata['menu_image'];
	$menu_name = $menudata['menu_name'];
	$parentMenuId = $menudata['parent_id'];
	$parentmenudata= $menu -> menu_by_id($parentMenuId);
	$parent_menu_name = $parentmenudata['menu_name'];
}
?>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
</ul>
<?php echo $ErrMsg?>
<form name="modifycontent" action="" method="post">
	<div class="form_holder">
        <p class="description-line1">Canonical Text*</p>
        <p class="description-line1"><textarea name="canonicalText" style="width:98%"><?php echo $canonicalText;?></textarea></p>
        <p class="description-line1">Url* [ex. /page-name/]</p>
        <p class="description-line1"><textarea name="canonicalUrl" style="width:98%"><?php echo $canonicalUrl;?></textarea></p>
	</div>
	<div class="iconbox">
		<p  class="description-line1">
			<span class="save_button-box">
			<input name="IdToEdit" type="hidden" value="<?php echo $IdToEdit;?>" />			
			<input name="SourceForm" type="hidden" class="save_button" value="Addcanonical" />
			<input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
			<input name="Save" type="submit" class="save_frm" value="Save" />
			<input name="Cancel" type="button"  onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $moduleId;?>'" class="cancel_frm" value="Close" />
			<input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
			</span>
		</p>
	</div>
</form>
