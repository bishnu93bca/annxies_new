<?php
$obj = new PostClass();
$ExtraQryStr=" 1 ";
if($editid!='')
{
	$blogId            = $editid;
	$fetch_details     = $obj->blogById($blogId);		
	$IdToEdit          = $fetch_details['blogId'];
	$postAuthorId      = $fetch_details['postAuthorId'];
	$blogTitle         = $fetch_details['blogTitle'];
	$blogAuthor        = $fetch_details['blogAuthor'];
	$permalink         = $fetch_details['permalink'];
	$blogContent       = $fetch_details['blogContent'];
	$shortDescription  = $fetch_details['shortDescription'];
	$blogImage         = $fetch_details['blogImage'];	
	$blogDate          = $fetch_details['blogDate'];	
	$status            = $fetch_details['status'];	
}
$menu=new menu();
$menudata= $menu -> menu_by_id($moduleId);
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
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
    <?php
    if($editid){        
        ?>
        <li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $moduleId;?>'">Add New</a></div></li>
        <?php
    }
	?>
</ul>
<?php echo $ErrMsg?>
<form name="modifycontent" action="" method="post" enctype="multipart/form-data">
    <div class="form_left">
        <div class="form_holder">            
            <p class="description-line1">Heading *</p>		
            <p class="description-line1"><input name="blogTitle" type="text" class="input2" value="<?php echo $blogTitle;?>" id="categoryPermalink" onblur="validatePermalink('<?php echo $dtls;?>', '<?php echo $editid;?>')" size="70" /></p>

            <p class="description-line1">Author *</p>		
            <p class="description-line1"><input name="blogAuthor" type="text" class="input2" value="<?php echo $blogAuthor;?>" id="categoryPermalink" onblur="validatePermalink('<?php echo $dtls;?>', '<?php echo $editid;?>')" size="70" /></p>
            
            <div class="clear"></div>
            <script>
                $(document).ready(function() {
                    var text_max = 160;
                    var counttext=$('#textarea').val().length;
                    if(counttext > 1)
                    {
                        var datacont=160-counttext;
                        $('#textarea_feedback').html(datacont + ' characters remaining');
                    }
                    else
                        $('#textarea_feedback').html(text_max + ' characters remaining');
                    $('#textarea').keyup(function() {
                        var text_length = $('#textarea').val().length;
                        var text_remaining = text_max - text_length;

                        $('#textarea_feedback').html(text_remaining + ' characters remaining');
                    });
                });
            </script>
            <p class="description-line1">Short Description(Maximum 160 Characters) *</p>
            <p class="description-line1">
            <textarea name="shortDescription" maxlength="160" style="resize: none;" id="textarea"><?php echo $shortDescription;?></textarea>
            <div id="textarea_feedback" style="float: right; color: #E8272E; font-weight: bold;"></div>
            
            <div class="clear"></div>
            <p class="description-line1">Description *</p>
            <p class="description-line1">
                <?php
                $CKEditor = new CKEditor();    
                $CKEditor->returnOutput = true;            
                $CKEditor->basePath = '../ckeditor/';            
                $CKEditor->config['width'] = '100%'; 
                $CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);            
                CKFinder::SetupCKEditor($CKEditor, '../ckfinder/');	
                $code = $CKEditor->editor("blogContent", $blogContent);			
                echo $code;
                ?>
            </p>   
            
        </div>
    </div>
    <div class="status_right">
        <div class="form_holder">
            <p class="description-line1">Status</p>
            <p class="description-line1">
                <select name="status">
                    <option value="Y" <?php if($status=='Y') echo 'selected';?>>Active</option>
                    <option value="N" <?php if($status=='N') echo 'selected';?>>Inactive</option>
                </select>
            </p>
            
            <div class="clear"></div>
            <p class="description-line1">Blog Date </p>		
            
            <p class="description-line1 odd_Event" style="position:relative;"><input id="datepicker" name="blogDate" type="text" class="input2 format-y-m-d divider-dash no-transparency" value="<?php echo ($blogDate)? date('Y-m-d h:i:s',strtotime($blogDate)):'';?>" size="70" style="width: 87%;"/></p>
            
            <div class="clear"></div>
            <p class="description-line1">Upload Image (Image should be 843px*537px)</p>
            <p class="description-line1">
                <input type="file" class="input2" name="ImageName" /><br />
                <?php
                if(file_exists($MEDIA_FILES_ROOT.'/blog/thumb/'.$blogImage) && $blogImage)
                {
                    echo '<img src="'.$MEDIA_FILES_SRC.'/blog/thumb/'.$blogImage.'" height="100" width="100" alt="" />';
                }
                ?>
            </p>
        </div>
    </div>
    <div class="clear"></div> 
    
    <div class="clear"></div>
	<input name="Back" type="button" onclick="history.back(-1);" class="back"  value="Back" />
	<input name="Save" type="submit" class="save_frm"  value="Save" />
    <input name="pageType" type="hidden" value="<?php echo $pageType; ?>" />              
    <input name="moduleId" type="hidden" value="<?php echo $moduleId;?>" />                    
    <input name="dtls" type="hidden" value="<?php echo $dtls;?>" />                    
    <input name="dtaction" type="hidden" value="<?php echo $dtaction;?>" /> 
    <input name="SaveNext" type="submit" class="save_frm"  value="Save & Add New" />
    <input name="Cancel" type="button" onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $moduleId;?>'" class="cancel_frm" value="Close" />
	<input type="hidden" value="AddPost" name="SourceForm" /> 
	<input type="hidden" value="<?php echo $editid;?>" name="IdToEdit" />  
    
</form>