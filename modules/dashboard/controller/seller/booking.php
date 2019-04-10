<script>
$(function(){
    $(".book_status").change(function(){
        var data = $(this).val();
        var result = data.split('#');
        var bid = result[0];
        var bst = result[1];
         $.ajax({
            type: "POST",
            url: '<?php echo $SITE_LOC_PATH.'/modules/dashboard/controller/seller/ajaxaction.php';?>',
            data: {'ajax':'1','bid':bid,'bst':bst},
            success: function(data){
              $('.ErrMsg').html(data);
                 setTimeout(function () {
                    $('.ErrMsg').fadeOut();
                    location.reload(); 
                }, 600);
            }
        
         }); 
    });
});
</script>

<?php
$cObj        = new MemberAdmin;
$planData    = $cObj->get_general_info($editid);

$bookingData = $cObj->monthlyUsage($editid, $planData['plan'], $planData['plan_start'], $planData['plan_end'], $planData['mjesec'], $planData['ofcUse']);

$viewBooking = $cObj->readbooking($editid, $planData['ofcUse'], 0, 50,$pageType, $dtls, $page, $parentId, $moduleId, $type, $redirectString);

$ExtraQryStr=" 1 ";

if($editid){
	$cData    		= $cObj->getMemberInfoByid($editid);
	$id 			= $editid;
	$name 		    = $cData['name'];
	$surname 		= $cData['surname'];
	$email 		    = $cData['email'];
	$country 		= $cData['country'];
	$gender         = $cData['gender'];
	$aboutMe 		= $cData['aboutMe'];
	$phone 			= $cData['phone'];
	//$address 		= $cData['address'];
	$city 			= $cData['city'];
	$state 			= $cData['state'];
	$country 		= $cData['country'];
	$status 		= $cData['status'];
	$profilePic		= $cData['profilePic'];
    $company   		= $cObj->getCompanyInfoByuserid($id);
    $memberShip		= $cObj->getMembershipInfoByuserid($id);
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
        <?php /*if($editid) {?>
        <li>
            <div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $moduleId;?>'">Add New</a></div>
        </li>
        <?php	}*/?>
    </ul>
    <?php echo $ErrMsg;
    if($editid){
        include("intro.php");
    }
    ?>      
    <form name="modifycontent" action="" method="post" enctype="multipart/form-data" class="form-middlegap" style="overflow: hidden;">
            <div class="">
                <div class="form_holder">
                <?php print_r($bookingData);?>
                <div class="ErrMsg"></div>
                <?php print_r($viewBooking);?>
                </div>
            </div>           
            
            <div class="clear"></div>
            <div class="form_holder">
                <input name="page" type="hidden" value="<?php echo $page; ?>" />
                <input name="SourceForm" type="hidden" value="AddBooking" />
                <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
                <!--<input name="Save" type="submit" class="save_frm" value="Save" />-->
                <input name="Cancel" type="button" onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $_REQUEST['moduleId'];?>'" class="save_frm" value="Close" />
            </div>
        </form>

        <br class="clear" />
     