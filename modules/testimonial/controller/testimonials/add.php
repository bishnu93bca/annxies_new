<?php
if($editid!='')
{
    $obj = new AdminTestimonial;
	$fetch_details = $obj->testimonialById($editid);
	$IdToEdit = $fetch_details['testimonialId'];
	$heading = $fetch_details['heading'];	
	$description = $fetch_details['description'];
	$place       = $fetch_details['place'];
	$designation = $fetch_details['designation'];
	$imageName = $fetch_details['imageName'];
	$permalink = $fetch_details['permalink'];
	$entryDate = $fetch_details['entryDate'];
	$status = $fetch_details['status'];
	$swapNo = $fetch_details['swapNo'];
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
			
            <p class="description-line1">Name *</p>
            <p class="description-line1"><input type="text" name="heading" value="<?php echo $heading;?>"></p>

            <p class="description-line1">Location </p>
            <p class="description-line1"><input type="text" name="place" value="<?php echo $place;?>"></p>

            <p class="description-line1">Designation</p>
            <p class="description-line1"><textarea name="designation"><?php echo $designation;?></textarea></p>


            <p class="description-line1">Description *</p>
            <p class="description-line1">
                <?php
                // Create class instance.
                $CKEditor = new CKEditor();
                // Do not print the code directly to the browser, return it instead
                $CKEditor->returnOutput = true;
                // Path to CKEditor directory, ideally instead of relative dir, use an absolute path:
                //   $CKEditor->basePath = '/ckeditor/'
                // If not set, CKEditor will try to detect the correct path.
                $CKEditor->basePath = '../ckeditor/';
                // Set global configuration (will be used by all instances of CKEditor).
                $CKEditor->config['width'] = '100%';
                // Change default textarea attributes
                $CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);
                CKFinder::SetupCKEditor($CKEditor, '../ckfinder/');
                // Create first instance.
                $code = $CKEditor->editor("description", $description, $config);
                echo $code;
                ?>
            </p> 
			            
        </div>
    </div>

	
	  <div class="status_right">
		<div class="form_holder">		
			<div class="input_left">
				<p class="description-line1">Status </p>
				<p class="description-line1">
					<select name="status" style="width:auto;">
						<option value="Y" <?php if($status=='Y' || !$status) echo 'selected';?> >Active</option>
						<option value="N" <?php if($status=='N') echo 'selected';?>>Canceled</option>
						<option value="C" <?php if($status=='C') echo 'selected';?>>Complementary</option>
					</select>
				</p>
			</div>			
		</div>
		<div class="form_holder">
            <p class="description-line1">Image (Image size : 116px * 116px)</p>
            <p class="description-line1"><input name="imageFile" type="file" class="input2" size="30" /></p>
            <?php
            if(file_exists($MEDIA_FILES_ROOT.'/testimonials/thumb/'.$imageName) && $imageName)
            {
                ?>
                <p class="description-line1">
                    <img src="<?php echo $MEDIA_FILES_SRC;?>/testimonials/thumb/<?php echo $imageName;?>" alt="<?php echo $heading;?>" />
                </p>
                <br><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&id=<?php echo $IdToEdit;?>&action=Testimonialimage&redstr=<?php echo $redirectString;?>" class="ask delete_image">Delete Image</a>
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
	<input type="hidden" value="AddTestimonial" name="SourceForm" /> 
	<input type="hidden" value="<?php echo $editid;?>" name="IdToEdit" />  
    
</form>