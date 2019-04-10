<?php
$mObj=new menu();
$menudata= $mObj -> menu_by_id($_REQUEST['moduleId'],$Link);
if($menudata)
{
	$menu_image = $menudata['menu_image'];
	$menu_name = $menudata['menu_name'];
	
	$parentMenuId = $menudata['parent_id'];
	$parentmenudata= $mObj -> menu_by_id($parentMenuId,$Link);
	
	$parent_menu_name = $parentmenudata['menu_name'];
}
$sObj = new SiteMapIgnore();
$skip = $sObj->siteMapIgnoreUrl($siteId,$Link);
?>
<ul id="breadcrumb">
        <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
        <li><a href="#"><?php echo $parent_menu_name;?></a></li>
</ul>
<section id="form">
<?php echo $ErrMsg?>
<form name="modifycontent" action="" method="post">
    <div class="form_holder"> 
        <p class="description-line1">URL *</p>
        <p class="description-line1"><input name="siteUrl" type="text" value="<?php echo $SITE_LOC_PATH;?>" /></p>
        <p class="description-line1">Ignore URL Starting With [ex. <?php echo $SITE_LOC_PATH;?>/xyz/]</p>
        <p class="description-line1">
            <table id="dataTableUrl" style="width:50%">
                <?php 
                if(sizeof($skip)>0)
                {
					for($s=0;$s<sizeof($skip);$s++)
                    {
                        ?>
                        <tr>
                            <td width="2%"><input type="checkbox" name="chkUrl"/></td>
                            <td width="98%"><input type="text" name="skip[]" value="<?php echo $skip[$s]["ignoreUrl"];?>" /></td>
                        </tr>
                        <?php 
                    } 
                }
                else
                {
                    ?>  
                    <tr>
                        <td width="2%"><input type="checkbox" name="chkUrl"/></td>
                        <td width="98%"><input type="text" name="skip[]" value="" /></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <a href="javascript:void(0)" onclick="addRow('dataTableUrl')">Add New</a> | <a href="javascript:void(0)" onclick="deleteRow('dataTableUrl')">Delete</a>
        </p>
    </div>			
    <input name="SourceForm" type="hidden" value="SiteMap" />
    <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
    <input name="Save" type="submit" class="save_frm" value="Site Map" />
    <input name="Cancel" type="button"  onclick="window.location.href='index.php'" class="cancel_frm" value="Close" />				
</form>
</section>