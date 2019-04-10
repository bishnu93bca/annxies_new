<script type="text/javascript">
$(function(){
    $('.icon_btn_cntr span a').on('click',function(){
        var link = $(this);
        link.parent().parent().parent().parent('li').addClass('point');
        var id          = link.attr('data-id');
        var editid      = link.attr('data-editid');
        var action      = link.attr('data-action');
        var stschgto    = link.attr('data-stschgto');
        var signImage   = link.attr('data-galleryImage');
        $.ajax({
            type: "POST",
            url: '<?php echo $SITE_LOC_PATH.'/modules/dashboard/controller/virtualoffices/ajaxaction.php';?>',
            data: {'id':id,'editid':editid,'action':action,'ajax':'1','stschgto':stschgto,'signImage':signImage},
            success: function(data){
                if(action=='delete'){
                    if(data=='success') link.parent().parent().parent().parent('li').remove();
                }
                else if(action=='status'){
                    link.parent().parent().parent().parent('li').removeClass('point');
                    if(stschgto == 'Y')
                    {
                        var conStatus  = '<img src="images/active.png" alt="Active" width="15" border="0" />';
                        var status     = "N";
                    }
                    else
                    {
                        var conStatus  = '<img src="images/inactive.png" alt="Inactive" width="15" border="0" />';
                        var status     = "Y";
                    }
                    if(data=='success') {
                        link.html(conStatus);
                        link.attr('data-stschgto',status);
                    }
                }
                else if(action=='primary'){
                    if(data=='success'){
                        link.parent().parent().parent().parent('li').removeClass('point');
                    }
                }
            }
        });
    });
    
    $('span.airport').on('click',function(){
        $('ul.airportList').append('<li><p class="description-line1"><input type="text" placeholder="Airport" name="airport[]"><em  class="removeAi">X</em></p></li>');
    });
    $(document).on('click', '.removeAi', function(e){
        $(this).closest('li').remove();
    }); 
    
    $('span.hotel').on('click',function(){
        $('ul.hotelList').append('<li><p class="description-line1"><input type="text" placeholder="Hotel" name="hotel[]"><em  class="removeHl">X</em></p></li>');
    });
    $(document).on('click', '.removeHl', function(e){
        $(this).closest('li').remove();
    });  
    
    $('span.restaurant').on('click',function(){
        $('ul.restaurantList').append('<li><p class="description-line1"><input type="text" placeholder="Restaurant" name="restaurant[]"><em  class="removeRs">X</em></p></li>');
    });
    $(document).on('click', '.removeRs', function(e){
        $(this).closest('li').remove();
    });  
    
    
});
</script>
<?php
$obj = new MemberAdmin;
if($editid!='')
{
	$fetch_details = $obj->getOfficeInfoByid($editid);
	$IdToEdit      = $fetch_details['id_office'];
	$permalink     = $fetch_details['permalink'];
	$state_code    = $fetch_details['state_code'];	
	$office_city   = $fetch_details['office_city'];
    
	$office        = $fetch_details['office'];
	$office_url    = $fetch_details['office_url'];
	$img_office    = $fetch_details['img_office'];
	$airport       = $fetch_details['airport'];
	$hotel         = $fetch_details['hotel'];
	$restaurant    = $fetch_details['restaurant'];
	$entryDate     = $fetch_details['entryDate'];
	$status        = $fetch_details['status'];
	$swapNo        = $fetch_details['swapNo'];
    
    $airport       = explode('#',$airport);
    $hotel         = explode('#',$hotel);
    $restaurant    = explode('#',$restaurant);
    
    $galData = $obj -> getGalleryByofficeId($IdToEdit);
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
            <p class="description-line1">State *</p>
            <p class="description-line1">
                <select name="state_code">
                    <?php 
                    $states = $obj->readstate($state_code);
                    echo $states;
                    ?>
                </select>
            </p>
            
            <p class="description-line1">Office *</p>
            <p class="description-line1"><input type="text" name="office_city" value="<?php echo $office_city;?>"></p>

            <p class="description-line1">Location </p>
            <p class="description-line1"><input type="text" name="office" value="<?php echo $office;?>"></p>
            
            
            <p class="description-line1">Airport<span class="airport addPl">+ Add More</span></p>
            <ul class="airportList addInput">
                <?php
                if($IdToEdit==''){
                    echo '<li><p class="description-line1"><input type="text" placeholder="airport" name="airport[]"></p></li>';
                }
                else{
                    foreach($airport as $ap){
                        echo '<li><p class="description-line1"><input type="text" placeholder="Airport" name="airport[]" value="'.$ap.'"><em  class="removeAi">X</em></p></li>';
                    }
                }
                ?>
            </ul>
            <div class="clear"></div>
            <p class="description-line1">Hotel<span class="hotel addPl">+ Add More</span></p>
            <ul class="hotelList addInput">
                <?php
                if($IdToEdit==''){
                    echo '<li><p class="description-line1"><input type="text" placeholder="Hotel" name="hotel[]"></p></li>';
                }
                else{
                    foreach($hotel as $ht){
                        echo '<li><p class="description-line1"><input type="text" placeholder="Hotel" name="hotel[]" value="'.$ht.'"><em  class="removeHl">X</em></p></li>';
                    }
                }
                ?>
            </ul>
            <div class="clear"></div>
            <p class="description-line1">Restaurant<span class="restaurant addPl">+ Add More</span></p>
            <ul class="restaurantList addInput">
                <?php
                if($IdToEdit==''){
                    echo '<li><p class="description-line1"><input type="text" placeholder="Restaurant" name="restaurant[]"></p></li>';
                }
                else{
                    foreach($restaurant as $rs){
                        echo '<li><p class="description-line1"><input type="text" placeholder="Restaurant" name="restaurant[]" value="'.$rs.'"><em  class="removeRs">X</em></p></li>';
                    }
                }
                ?>
            </ul>
            <?php /*
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
			*/?>            
        </div>
    </div>
	
	  <div class="status_right">
		<div class="form_holder form_right" style="49%">		
			<!--<div class="input_left">-->
				<p class="description-line1">Status </p>
				<p class="description-line1">
					<select name="status" style="width:auto;">
						<option value="Y" <?php if($status=='Y' || !$status) echo 'selected';?> >Active</option>
						<option value="N" <?php if($status=='N') echo 'selected';?>>Canceled</option>
					</select>
				</p>
			<!--</div>	-->		
		</div>
	</div>
    
    <div class="clear"></div>
    <div class="form_holder">
        <p class="description-line1">Upload Image (Image should be 692px*495px)</p>
        <input type="file" class="input2" name="officeImage[]" multiple/><br />
        <div class="multi_img_cntr">
            <ul class="imgUl">
            <?php
            foreach($galData as $gv){    
                if($gv['status'] == 'Y')
                {
                    $conStatus  = '<img src="images/active.png" alt="Active" width="15" border="0" />';
                    $status     = "N";
                }
                else
                {
                    $conStatus  = '<img src="images/inactive.png" alt="Inactive" width="15" border="0" />';
                    $status     = "Y";
                }
                ?>
                <li>
                    <div class="img_cntr">
                        <a href="<?php echo $SITE_LOC_PATH.'/uploadedfiles/office/thumb/'.$gv['galleryImage'];?>" class="preview">
                        <?php echo '<img src="'.$MEDIA_FILES_SRC.'/office/thumb/'.$gv['galleryImage'].'" width="100px"/>';?>
                        </a>
                    </div>  
                    <div class="icon_btn_cntr">
                        <div class="wrapbtn">
                            <span><a  data-galleryImage="<?php echo $gv['galleryImage'];?>" data-editid="<?php echo $IdToEdit;?>" data-action="primary" href="javascript:void(0);"><input <?php if($img_office==$gv['galleryImage']) echo 'checked';?> style="margin-top:6px;" type="radio" name="productsmain"></a></span>
                            <span>
                                <a data-id="<?php echo $gv['galleryId'];?>" data-stschgto="<?php echo $status;?>"   data-action="status" href="javascript:void(0);"><?php echo $conStatus;?></a>
                            </span>
                            <span><a data-editid="<?php echo $IdToEdit;?>" data-id="<?php echo $gv['galleryId'];?>" data-action="delete" href="javascript:void(0);"><img src="images/trash.png"></a></span>
                        </div>
                    </div>
                </li>
                <?php
            }
            ?>    
            </ul>
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
	<input type="hidden" value="AddOffice" name="SourceForm" /> 
	<input type="hidden" value="<?php echo $editid;?>" name="IdToEdit" />  
    
</form>