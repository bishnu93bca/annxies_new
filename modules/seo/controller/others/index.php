<?php
$obj = new PageTitle;
$fetch_details = $obj->siteById($_SESSION['SITE_ID']);
$IdToEdit = $fetch_details['siteId'];
$seoData = $fetch_details['seoData'];
$tagManager = $fetch_details['tagManager'];
$googleAnalytics = $fetch_details['googleAnalytics'];
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
<section id="form">
<br class="clear" /><?php echo $ErrMsg?>
    <form name="modifycontent" action="" method="post" enctype="multipart/form-data">
        <div class="form_holder">
            <div style="float:left; width:50%">
                <p class="description-line1">SEO Data</p>
                <p class="description-line1">
                    <textarea style="width:400px;height:100px" name="seoData"><?php echo $seoData;?></textarea>
                </p>
                <p class="description-line1">Tag Manager</p>
                <p class="description-line1">
                    <textarea style="width:400px;height:100px" name="tagManager"><?php echo $tagManager;?></textarea>
                </p>
            </div>
            <div style="float:left; width:50%">
                <p class="description-line1">Google Analytics</p>
                <p class="description-line1">
                    <textarea style="width:400px;height:100px" name="googleAnalytics"><?php echo $googleAnalytics;?></textarea>
                </p>
                <p class="description-line1">Upload sitemap.xml</p>
                <p class="description-line1"><input type="file" name="SiteMapFile"/><br />
                <?php
                if(file_exists('../sitemap.xml'))
                {
                    ?>
                    <p class="description-line1">
                        <?php
                        echo 'File Exists';
                        ?>
                    </p>
                    <?php
                }
                ?> 
                </p>
                <p class="description-line1">Upload robots.txt</p>
                <p class="description-line1"><input type="file" name="RobotFile" /><br />
                <?php
                if(file_exists('../robots.txt'))
                {
                    ?>
                    <p class="description-line1">
                        <?php
                        echo 'File Exists';
                        ?>
                    </p>
                    <?php
                }
                ?> 
                </p>
            </div>
        </div>
        <p  class="description-line1">
            <span class="save_button-box">	
                <input name="IdToEdit" type="hidden" value="<?php echo $IdToEdit;?>" />
                <input name="SourceForm" type="hidden" class="save_button" value="Other" />
                <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
                <input name="Save" type="submit" class="save_frm" value="Save" />
                <input name="Cancel" type="button"  onclick="window.location.href='index.php'" class="cancel_frm" value="Close" />
                <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
            </span>
        </p>
    </form>
</section>