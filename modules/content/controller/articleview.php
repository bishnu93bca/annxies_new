<?php
if($contentID)
	$fetch_details = $obj->getContentBycontentID($contentID);
else
	$fetch_details = $obj->getContentBymenucategoryId($editid);

$contentHeading     = $fetch_details['contentHeading'];
$contentDescription = $fetch_details['contentDescription'];		
$ImageName          = $fetch_details['ImageName'];		
$vidLink            = $fetch_details['vidLink'];		

$contentShortDescription = $fetch_details['contentShortDescription'];
$menu=new menu();
$parentmenudata= $menu -> menu_by_id(1);
$menu_image = $parentmenudata['menu_image'];
$parent_menu_name = $parentmenudata['menu_name'];	
?>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $categoryParentName;?> <span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
    <li><div class="button_box">
        <?php 
        if(empty($fetch_details)) 
            echo '<a href="javascript:void(0)" onclick="show()">Add Content</a>';
        ?>
        </div>
   </li>
</ul>
<?php 
if($fetch_details)
{	
	$permalink = $fetch_details['permalink'];
	?>	
    <form name="modifycontent" action="" method="post" enctype="multipart/form-data">
        <div class="form_holder">
            <div class="description-line">
                <span class="description-line-text">Heading *</span>
                <span ><input type="text" name="contentHeading" style="width:450px;" value="<?php echo $contentHeading;?>" id="categoryPermalink" maxlength="200"  /></span>
                <div style="float:right; margin:0px;">
                    <span class="description-line-text">Display Heading
                    <select name="displayHeading">
                        <option value="Y" <?php if($fetch_details['displayHeading']=='Y') echo 'selected';?>>Yes</option>
                        <option value="N" <?php if($fetch_details['displayHeading']=='N') echo 'selected';?>>No</option>
                    </select>
                </span>
                </div>
            </div>
            <p class="description-line1">Description *</p>
            <p class="description-line1">
                <?php                        
                $CKEditor = new CKEditor();                        
                $CKEditor->returnOutput = true;                        
                $CKEditor->basePath = '../ckeditor/';                        
                $CKEditor->config['width'] = '100%';                        
                $CKEditor->config['EnterMode'] = 'br';            
                $CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);                        
                CKFinder::SetupCKEditor($CKEditor, '../ckfinder/');           
                $code = $CKEditor->editor("contentDescription", $contentDescription);                        
                echo $code;
                ?>
            </p>  
            <?php if($editid != 21) { ?>
                <p class="description-line1">Upload image (image size should be 1352px * 462px)</p>
                <p class="description-line1">
                    <input type="file" class="input2" name="ImageName" /><br />
                    <?php
                    if(file_exists($MEDIA_FILES_ROOT.'/menu/thumb/'.$ImageName) && $ImageName)
                    {
                        echo '<img src="'.$MEDIA_FILES_SRC.'/menu/thumb/'.$ImageName.'" height="100" width="100" alt="" />';
                    }
                    ?>
                </p>
            <?php } else { ?> 
                
                <p class="description-line1">Video Link </p>
                <p class="description-line1">
                <input name="vidLink" type="text" value="<?php echo $vidLink;?>" size="30" maxlength="100" />
                </p>
            
            <?php } ?>
            
            <?php if($categoryType=='List View') {?>
            <p class="description-line1">
                <span class="description-line-text">Swap No</span></p>
            <p class="description-line1"> 
                <input name="contentSwapNo" type="text" value="<?php echo $fetch_details['contentSwapNo'];?>" size="3" maxlength="2" />
            </p>
             <?php }?>
             <?php //include("banner.php");?>
        </div>	
        <div class="form_holder">	
            <div class="iconbox">
                <span class="save_button-box">
                    <input name="IdToEdit" type="hidden" value="<?php echo $fetch_details['contentID'];?>" />
                    <input name="categoryId" type="hidden" value="<?php echo $editid;?>" />
                    <input name="SourceForm" type="hidden" class="save_button" value="ContentGeneral" />
                    <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
                    <input name="Update" type="submit" class="save_frm" value="Save" />
                    <input name="Cancel" type="button"  onclick="window.location.href='index.php'" class="cancel_frm" value="Close" />
                    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                </span>  
                <?php if($_SESSION['UTYPE']=="A") { ?>
                    <div class="button_box">
                    <?php 
                    if($fetch_details)                        
                        echo '<a href="index.php?pageType='.$pageType.'&editid='.$editid.'&dtaction=delete&id='.$fetch_details['contentID'].'&action=content&redstr='.$redirectString.'" class="ask">Delete Content</a>';
                    ?>
                    </div>	
                    <?php
                }?>		
            </div>		
        </div>
    </form>

	<?php
}?>