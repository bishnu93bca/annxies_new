<?php
if($editid!='')
{
	$sel_details           = $menu-> menu_by_id($editid);
	$IdToEdit              = $sel_details['menu_id'];
	$parent_id             = $sel_details['parent_id'];
	$displayOrder          = $sel_details['display_order'];
	$contentHeading        = $sel_details['menu_name'];
	$contentDescription    = $sel_details['menu_description'];
	$menu_image            = $sel_details['menu_image'];
	$type                  = $sel_details['type'];
	$price                 = $sel_details['price'];	
}
$sel_details = $menu->menu_details_by_parent_id();
?>
<ul id="breadcrumb">
    <li><a href="#"><?php if($editid!='') echo 'Edit - Modules - Module Management'; else echo 'Add - Modules - Module Management'; ?></a></li>
</ul>
<?php echo $ErrMsg;?>
<form name="modifycontent" action="" method="post" enctype="multipart/form-data">
	<div class="form_holder">
	
        <div style="width:300px; float:left">	 
            <p class="description-line1">Module Name *</p>
            <p class="description-line1"><input name="contentHeading" type="text" class="input2" size="30" value="<?php echo $contentHeading;?>" maxlength="100" /></p>		
        </div>		
		<div style="width:300px; float:right">
		
            <p class="description-line1">Parent Module</p>
            <p class="description-line1">	
				<?php 				  
				$data = $menu -> getAllMenu();
				if($data)
				{ 
                    ?>
                    <select name="parent_id">
                        <option value="">--None--</option>
                        <?php 
                        //foreach()
                        for($i=0; $i<sizeof($data); $i++)
                        {
                            $categoryName=$data[$i]['menu_name'];
                            $parentId=$data[$i]['parent_id'];	
                            $pRow=0;
                            $parentNameArray='';
                            $concatinateName='';															
                            while($parentId!=0)
                            {
                                $name=$menu -> menu_by_id($parentId);
                                $parentId=$name['parent_id'];
                                $parentNameArray[$pRow] =$name['menu_name'];	
                                $pRow++;							
                            }								

                            if($parentNameArray!='')
                            {
                                $parentNameArray=array_reverse($parentNameArray);	

                                for($pna=0;$pna<sizeof($parentNameArray);$pna++)
                                    $concatinateName .=$parentNameArray[$pna].' > ';

                                $categoryName=$concatinateName.$categoryName;									
                            }

                            if($editid!='')
                                $parentId = $fetch_details['parent_id'];						
                            ?>
                            <option value="<?php echo $data[$i]['menu_id'];?>" <?php if($parent_id==$data[$i]['menu_id']) echo 'selected';?>>
                                <?php echo $categoryName;?>
                            </option>
                            <?php 
                        }?>
                    </select>
				    <?php 
				}?>			
			</p>		
		</div>
		<div style="width:100%; float:left">        
            <p class="description-line1">Choose a zip file to upload</p>
            <p class="description-line1"><input type="file" name="zip_file" /></p>

            <p class="description-line1">Instruction / Help Text *</p>
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
                // Create first instance.
                $code = $CKEditor->editor("contentDescription", $contentDescription);			
                echo $code;
                ?>
            </p>
		</div>
		<div style="width:300px; float:left">		
            <p class="description-line1">Image</p>
            <p class="description-line1">
                <input type="file" class="input2" name="ImageName" />
                <br />
                <?php 
                if($menu_image && file_exists($MEDIA_FILES_ROOT.'/menu/thumb/'.$menu_image)) 
                    echo '<img src="'.$MEDIA_FILES_SRC.'/menu/thumb/'.$menu_image.'" height="40" width="40" />';
                ?>
            </p>		
		</div>		
		<div style="width:150px; float:left">		
            <p class="description-line1">Swap No</p>
            <p class="description-line1"><input name="displayOrder" type="text" class="input2" id="displayOrder" value="<?php echo $displayOrder;?>" style="width:50px;" size="3" maxlength="3" /></p>		
		</div>                                  
	</div>	
	<div class="iconbox">
		<p  class="description-line1">
			<span class="save_button-box">
				<input name="IdToEdit" type="hidden" value="<?php echo $IdToEdit;?>" />
				<input name="SourceForm" type="hidden" value="Menu" />
				<input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
				<input name="Save" type="submit" class="save_frm" value="Save" />
				<input name="Cancel" type="button"  onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>'" class="cancel_frm toast" value="Close" />
				<input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
			</span>
		</p>
	</div>	
</form>