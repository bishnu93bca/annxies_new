<?php
$obj = new adminCategory();
if($editid!='')
{
	$c_id                  = $editid;
	$fetch_details         = $obj->categoryById($c_id);	
	$IdToEdit              = $fetch_details['c_id'];
	$parentId              = $fetch_details['parent_id'];
	$category              = $fetch_details['category'];
	$permalink             = $fetch_details['permalink'];
	$cat_image             = $fetch_details['cat_image'];
	$status                = $fetch_details['status'];	
	$showHome              = $fetch_details['showHome'];	
	$mainCategory          = $fetch_details['mainCategory'];	
	$swapNo                = $fetch_details['swapNo'];
}
if($parentId=='')
	$parentId=0;
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
<script>
$(function() {
    $(document).on('change', '.categoryFor', function(){
        var catId = $(this).val();
        var pId   = '<?php echo $parentId;?>';
        $.ajax({
            url: '../modules/categorynproduct/controller/category/subcategory.php',
            type: 'POST',
            data:{'catId':catId,'page':'add','pId':pId},
            cache: false,
            success: function(data){  
                $('.subCategory').html(data);
            }
        });
    });
    $('.categoryFor').trigger('change');
});
</script>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?><span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
    <?php
	if($editid){
		if($parentId)
		{
			?>
			<li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $moduleId;?>&parentId=<?php echo  $parentId;?>'">Add New</a></div></li>
			<?php
		}
		else
		{
			?>
			<li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $moduleId;?>'">Add New</a></div></li>
			<?php
		}
	}
	?> 
</ul>
<?php echo $ErrMsg;?>
<form name="modifycontent" action="" method="post" enctype="multipart/form-data">
	<div class="<?php echo ($parentId)? 'form_left':''?>">
        <?php if($parentId){ ?>
            <div class="form_holder">
            <div class="input_left">
                <p class="description-line1">Category For *</p>
                <p class="description-line1">
					<select name="mainCategory" class="categoryFor" style="width:150px;margin-right:10px;">
                        <option value="">-Select-</option>
                        <?php
                        $parentCat   = $obj->getCategoryByparentId(0);
                        foreach($parentCat as $pCat){
                            if($pCat['c_id']==$mainCategory)
                                $chk = 'selected';
                            else
                                $chk = '';
                            echo '<option value='. $pCat['c_id'].' '.$chk.'>'.$pCat['category'].'</option>';
                        } 
                        ?>
					</select>
                </p>
            </div>
            <div class="input_right">
                <div class="subCategory">
                    <?php include 'subcategory.php';?>
                </div>
             </div>
         </div>
        <?php } ?>
         <div class="form_holder">
            <div class="input_left">
                <p class="description-line1">Category Name *</p>
                <p class="description-line1">
                    <input name="category" type="text" class="input2" value="<?php echo $fetch_details['category'];?>" size="30" maxlength="100" /> 
                </p>
            </div>
        </div>
        <?php 
        if($parentId)
            include("add-attributes.php");
        ?>
    </div>
    <?php if($parentId){ ?>
    <div class="status_right">
		<div class="form_holder">   
            <div class="input_left">
				<p class="description-line1">Status </p>
				<p class="description-line1">
					<select name="status" style="width:auto;">
						<option value="Y" <?php if($status=='Y' || !$status) echo 'selected';?> >Active</option>
						<option value="N" <?php if($status=='N') echo 'selected';?>>Inactive</option>
					</select>
				</p>
			</div>			
		</div>
	</div>
    <div class="status_right">
		<div class="form_holder">   
            <div class="input_left">
				<p class="description-line1">Show on Home page? </p>
				<p class="description-line1">                    
                    <label class="radioLabel">
                        <input name="showHome" value="Y" type="radio" <?php echo ($showHome=='Y')? 'checked':'';?>>
                        <span style="font-size:12">Yes</span>
                    </label>
                    <label class="radioLabel">
                        <input name="showHome" value="N" type="radio" <?php echo ($showHome=='N')? 'checked':'';?>>
                        <span style="font-size:12"> No</span>
                    </label> 
				</p>
			</div>			
		</div>
	</div>
    <?php //if($parentId==0) { ?>
        <div class="status_right">
            <div class="form_holder">
                <p class="description-line1">Category image</p>
                <p class="description-line1">
                    <input type="file" class="input2" name="cat_image" /><br />
                    <?php
                    if(file_exists($MEDIA_FILES_ROOT.'/product/thumb/'.$cat_image) && $cat_image)
                    {
                        echo '<img src="'.$MEDIA_FILES_SRC.'/product/thumb/'.$cat_image.'" height="100" width="100" alt="" />';
                        echo '<br><a href="index.php?pageType='.$pageType.'&dtls='.$dtls.'&dtaction=delete&id='.$IdToEdit.'&action=categoryImg&redstr='.$redirectString.'" class="ask delete_image">Delete Image</a>';
                    }
                    ?>
                </p>
            </div>
        </div>
    <?php //} 
                       }?>
    
    <br class="clear" />
	<div class="form_holder">
		<p  class="description-line1">
			<span class="save_button-box">
				<input name="page" type="hidden" value="<?php echo $page; ?>" />
				<input name="IdToEdit" type="hidden" value="<?php echo $IdToEdit;?>" />
				<input name="SourceForm" type="hidden" class="savebtn" value="AddCategory" />	
				<input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
                <?php if($parentId){ ?>
				    <input name="Save" type="submit" class="save_frm" value="Save" />               
                    <input name="SaveNext" type="submit" class="save_frm"  value="Save & Add New" />
                <?php }?>
				<input name="Cancel" type="button"  onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $moduleId;?>'" class="save_frm" value="Close" />
				<input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
			</span>
		</p>
	</div>    
</form>