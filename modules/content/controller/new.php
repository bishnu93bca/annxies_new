<div id="newContent" style="display:none">
	<form name="modifycontentNew" action="" method="post" enctype="multipart/form-data" >
		<div class="form_holder">
			<div class="description-line">
				<span class="description-line-text">Heading *</span><span ><input type="text" name="contentHeadingNew" value="<?php echo $contentHeadingNew;?>" id="categoryPermalink" maxlength="200" style="width:450px;"  /></span>
				<div style="float:right; margin:0px;">Display Heading
					<select name="displayHeading">
						<option value="Y">Yes</option>
						<option value="N">No</option>
					</select>
				</div>
			</div>			
			<p class="description-line1">Description *</p>
			<p class="description-line1"><?php
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
				$code = $CKEditor->editor("contentDescriptionNew", $contentDescriptionNew);
				echo $code;
				?>
			</p>	
            <p class="description-line1">Upload image (image size should be 1352px * 462px)</p>
            <p class="description-line1">
                <input type="file" class="input2" name="ImageName" /><br />
            </p>
			<?php if($categoryType=='List View') {?>	
            <p class="description-line1"><span class="description-line-text">Swap No</span></p>          
            <p class="description-line1"><span > <input name="contentSwapNoNew" type="text" value="<?php echo $fetch_details[$i]['contentSwapNoNew'];?>" size="3" maxlength="2" /></span></p>
            <?php }?>            
            <?php //include("banner.php");?>
        </div>
        <div class="form_holder">			
            <div class="iconbox">			
                <p  class="description-line1">
                    <span class="save_button-box">
                        <input name="IdToEdit" type="hidden" value="" />
                        <input name="SourceForm" type="hidden" value="NewContentGeneral" />
                        <input name="editid" type="hidden" value="<?php echo $editid;?>" />
                        <input name="menucategoryId" type="hidden" value="<?php echo $editid;?>" />
                        <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
                        <input name="Save" type="submit" class="save_frm" value="Save" />
                        <input name="Cancel" type="button"  onclick="location.href='index.php'" class="cancel_frm" value="Close" />
                        <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                    </span>
                </p>			
            </div>
        </div>		
	</form>
</div>