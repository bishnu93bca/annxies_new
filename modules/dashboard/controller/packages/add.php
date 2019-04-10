
<?php
$obj = new MemberAdmin;
if($editid!='')
{
	$fetch_details = $obj->getPackageInfoByid($editid);
	$IdToEdit      = $fetch_details['packageId'];
	$permalink     = $fetch_details['permalink'];
	$name          = $fetch_details['name'];	
	$smallnote     = $fetch_details['smallnote'];	
	$price         = $fetch_details['price'];
	$description   = $fetch_details['description'];
	$contractDesc = $fetch_details['contractDesc'];
	$image         = $fetch_details['image'];    
	$entryDate     = $fetch_details['entryDate'];
	$status        = $fetch_details['status'];
	$swapNo        = $fetch_details['swapNo'];
    
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
    <?php
    if($editid){        
        ?>
        <li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $moduleId;?>'">Add New</a></div></li>
        <?php
    }
	?>
</ul>
<?php echo $ErrMsg;?>

<form name="orderfrm" action="" method="post" enctype="multipart/form-data" class="form-middlegap" style="overflow: hidden;">
	<div class="form_left">
		<div class="form_holder">
            <div class="input_left" style="width:59%">
                <p class="description-line1">Name *</p>
                <p class="description-line1"><input type="text" name="name" value="<?php echo $name;?>"></p>
            </div>
            <div class="input_right" style="width:20%">
                <p class="description-line1">Price *<?php echo SITE_CURRENCY_SYMBOL;?></p>
                <p class="description-line1"><input type="text" name="price" class="numbersOnly" value="<?php echo $price;?>"></p>
            </div> 
            <div class="clear"></div>
            <p class="description-line1">Small Note</p>
            <p class="description-line1"><textarea name="smallnote" style="width:100%;"><?php echo $smallnote;?></textarea></p>
            
            <div class="clear"></div>
            <p class="description-line1">Description </p>
            <p class="description-line1">
                <?php
                $CKEditor = new CKEditor();
                $CKEditor->returnOutput = true;
                $CKEditor->basePath = '../ckeditor/';
                $CKEditor->config['width'] = '100%';
                $CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);
                CKFinder::SetupCKEditor($CKEditor, '../ckfinder/');
                $code = $CKEditor->editor("description", $description, $config);
                echo $code;
                ?>
            </p> 
            
            <div class="clear"></div>
            <p class="description-line1">Contact Description *</p>
            <p class="description-line1">
                <?php
                $CKEditor = new CKEditor();
                $CKEditor->returnOutput = true;
                $CKEditor->basePath = '../ckeditor/';
                $CKEditor->config['width'] = '100%';
                $CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);
                CKFinder::SetupCKEditor($CKEditor, '../ckfinder/');
                $code = $CKEditor->editor("contractDesc", $contractDesc, $config);
                echo $code;
                ?>
            </p> 
			          
        </div>
    </div>
	
	  <div class="status_right">
		<div class="form_holder">	
            <p class="description-line1">Status </p>
            <p class="description-line1">
                <select name="status" style="width:auto;">
                    <option value="Y" <?php if($status=='Y' || !$status) echo 'selected';?> >Active</option>
                    <option value="N" <?php if($status=='N') echo 'selected';?>>Canceled</option>
                </select>
            </p>
		</div>
          <div class="form_holder">
            <p class="description-line1">Image (Image size : 70px * 70px)</p>
            <p class="description-line1"><input name="image" type="file" class="input2" size="30" /></p>
            <?php
            if(file_exists($MEDIA_FILES_ROOT.'/package/thumb/'.$image) && $image)
            {
                ?>
                <p class="description-line1">
                    <img src="<?php echo $MEDIA_FILES_SRC;?>/package/thumb/<?php echo $image;?>" alt="<?php echo $name;?>" />
                </p>
                <br><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&id=<?php echo $IdToEdit;?>&action=packageImage&redstr=<?php echo $redirectString;?>" class="ask delete_image">Delete Image</a>
                <?php
            }
            ?>
		</div>
	</div>
    
    <div class="clear"></div>
	<input name="Back" type="button" onclick="history.back(-1);" class="back"  value="Back" />
	<input name="Save" type="submit" class="save_frm"  value="Save" />
    <input name="pageType" type="hidden" value="<?php echo $pageType; ?>" />              
    <input name="moduleId" type="hidden" value="<?php echo $moduleId;?>" />                    
    <input name="dtls" type="hidden" value="<?php echo $dtls;?>" />                    
    <input name="dtaction" type="hidden" value="<?php echo $dtaction;?>" /> 
    <input name="SaveNext" type="submit" class="save_frm"  value="Save & Add New" />
    <input name="Cancel" type="button" onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $moduleId;?>'" class="cancel_frm" value="Close" />
	<input type="hidden" value="AddPackage" name="SourceForm" /> 
	<input type="hidden" value="<?php echo $editid;?>" name="IdToEdit" />  
    
</form>
