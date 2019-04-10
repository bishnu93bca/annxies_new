<?php
$mObj    = new MemberAdmin;

$ExtraQryStr=" 1 ";
if($reviewId!='')
{
    $cObj = new Contact;
	$fetch_details     = $cObj->contactById($reviewId);
	$IdToEdit          = $fetch_details['contactID'];
	$name              = $fetch_details['name'];
	$email             = $fetch_details['email'];
	$rating            = $fetch_details['rating'];
	$company           = $fetch_details['company'];
	$phone             = $fetch_details['phone'];
	$contactComments   = $fetch_details['contactComments'];
	$contactEntrydate  = $fetch_details['contactEntrydate'];
}

if($editid){
	$cData    		= $mObj->getMemberInfoByid($editid);
}

$menu=new menu();
$menudata= $menu -> menu_by_id($_REQUEST['moduleId']);
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
        <li><a href="#"><?php echo $menu_name;?><span>→</span></a></li>
        <li><a href="#"><?php echo $parent_menu_name;?></a></li>
        <?php if($editid) {?>
        <li>
            <div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $moduleId;?>'">Add New</a></div>
        </li>
        <?php	}?>
    </ul>
    <?php echo $ErrMsg;
    if($editid){
        include("intro.php");
    }
if($reviewId)
{
    ?>      
        <form name="" action="" method="post" class="form-middlegap" style="overflow: hidden;">
             <div style="width:49.5%; float:left">
                <div class="form_holder">
                    <p  class="description-line1">Date: <?php echo date('M d, Y',strtotime($contactEntrydate));?></p>
                  
                        <p class="description-line1">Name</p>
                        <p class="description-line1"><input name="name" type="text" class="input2" size="30" value="<?php echo $name;?>" /></p>
                        <p class="description-line1">Email ID</p>
                        <p class="description-line1"><input name="email" type="text" class="input2" size="30" value="<?php echo $email;?>" /></p> 
                        <p class="description-line1">Company</p>
                        <p class="description-line1"><input name="date" type="text" class="input2" size="30" value="<?php echo $company;?>" /></p>
                    </div>
                </div>
                <div style="width:49.5%; float:right"> 
                    <div class="form_holder">
                        <p class="description-line1">Rating</p>
                        <p class="description-line1"><input name="date" type="text" class="input2" size="30" value="<?php echo $rating;?>" /></p>
                        <p class="description-line1">Message</p>
                        <p class="description-line1">
                            <textarea name="contactComments" style="height: 105px; width: 96%;"><?php echo $contactComments;?></textarea>
                        </p>
                    </div>
                </div>
           <!-- </div>-->
             <div class="clear"></div>
            <div class="form_holder">
                <input name="IdToEdit" type="hidden" value="<?php echo $IdToEdit;?>" />
                <input type="hidden" name="releted_product" />
                <input name="page" type="hidden" value="<?php echo $page; ?>" />
                <!--<input name="SourceForm" type="hidden" value="AddProduct" />-->
                <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
                <!--<input name="Save" type="submit" class="save_frm" value="Save" />-->
                <input name="Cancel" type="button" onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $_REQUEST['moduleId'];?>'" class="save_frm" value="Close" />
            </div>
        </form>

        <br class="clear" />
        <?php 
}
else{
    ?>
    <div class="table">
            <ul class="table_customer">
                <li style="text-align:center; line-height:30px;">No Record Present</li>
        </ul>
    </div>
    <?php
}
/*if($editid) {
	include("show-gallery.php");	
}*/?>
