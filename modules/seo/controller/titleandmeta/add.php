<?php
if($editid!='')
{
    $obj = new PageTitle;
	$fetch_details = $obj->titleMetaById($editid);
	$IdToEdit = $fetch_details['titleandMetaId'];
	$pageTitleText = $fetch_details['pageTitleText'];	
	$metaTag = $fetch_details['metaTag'];
	$metaDescription = $fetch_details['metaDescription'];
	$metaRobots = $fetch_details['metaRobots'];
	$titleandMetaUrl = $fetch_details['titleandMetaUrl'];	
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
	<p class="description-line1">Page Title*</p>
	<p class="description-line1"><textarea name="pageTitleText" style="width:98%"><?php echo $pageTitleText;?></textarea></p>
    <p class="description-line1">Meta Keyword</p>
	<p class="description-line1"><textarea name="metaTag" style="width:98%"><?php echo $metaTag;?></textarea></p>
    <p class="description-line1">Meta Description</p>
	<p class="description-line1"><textarea name="metaDescription" style="width:98%"><?php echo $metaDescription;?></textarea></p>
    <p class="description-line1">Url* [ex. /page-name/]</p>
    <p class="description-line1"><textarea name="titleandMetaUrl" style="width:98%"><?php echo $titleandMetaUrl;?></textarea></p>
    <p class="description-line1">Robots </p>
    <p class="description-line1">
        <input type="radio" name="metaRobots" value="index, follow" <?php if($metaRobots=='index, follow' || !$metaRobots) echo 'checked';?> style="width:auto" />index, follow 
        <input type="radio" name="metaRobots" value="no index, no follow" <?php if($metaRobots=='no index, no follow') echo 'checked';?> style="width:auto" />no index, no follow
    </p>
	</div>
	<div class="iconbox">
		<p  class="description-line1">
			<span class="save_button-box">
			<input name="IdToEdit" type="hidden" value="<?php echo $IdToEdit;?>" />			
			<input name="SourceForm" type="hidden" class="save_button" value="AddTitleMeta" />
			<input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
			<input name="Save" type="submit" class="save_frm" value="Save" />
			<input name="Cancel" type="button"  onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $moduleId;?>'" class="cancel_frm" value="Close" />
			<input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
			</span>
		</p>
	</div>
</form>