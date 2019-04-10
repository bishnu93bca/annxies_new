<?php
$menu       = new menu();
$menudata   = $menu -> menu_by_id($moduleId);
if($menudata)
{
	$menu_image        = $menudata['menu_image'];
	$menu_name         = $menudata['menu_name'];	
	$parentMenuId      = $menudata['parent_id'];
	$parentmenudata    = $menu -> menu_by_id($parentMenuId);	
	$parent_menu_name  = $parentmenudata['menu_name'];
}

if($editid){
    $cObj = new Contact;
	$fetch_details     = $cObj->contactById($editid);
	$IdToEdit          = $fetch_details['contactID'];
	$name              = $fetch_details['name'];	
	$email             = $fetch_details['email'];
	$phone             = $fetch_details['phone'];
	$contactComments   = $fetch_details['contactComments'];
	$contactEntrydate  = $fetch_details['contactEntrydate'];
}

?>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
</ul>

<form name="orderfrm" action="" method="post" enctype="multipart/form-data" class="form-middlegap" style="overflow: hidden;">
	<div class="form_left" style="width:49%">
		<div class="form_holder">			

            <p class="description-line1">Name </p>
            <p class="description-line1"><input type="text" name="name" value="<?php echo $name;?>"></p>

            <p class="description-line1">Email </p>
            <p class="description-line1"><input type="text" name="email" value="<?php echo $email;?>"></p>
			<?php if($phone) { ?>
            <p class="description-line1">Phone </p>
            <p class="description-line1"><input type="text" name="phone" value="<?php echo $phone;?>"></p>
            <?php }?>
			
		</div>
	</div>

    <div class="status_right" style="width:49%">
        <div class="form_holder">
            <div class="input_left">
                <p class="description-line1">Message </p>
                <p class="description-line1">
                   <textarea style="width:490px;height:80px;"><?php echo $contactComments;?></textarea>
                </p>
            </div>
        </div> 
    </div>
		
    <br class="clear">
    
    <input name="Back" type="button" onclick="history.back(-1);" class="back"  value="Back" />
    <input name="Cancel" type="button" onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $moduleId;?>'" class="cancel_frm" value="Close" />
    <input type="hidden" value="AddCourse" name="SourceForm" /> 
    <input type="hidden" value="<?php echo $id;?>" name="IdToEdit" /> 

</form>