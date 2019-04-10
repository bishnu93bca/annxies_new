<?php
$menu       = new menu();
$cObj     	= new MemberAdmin();
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
	$cData    		= $cObj->getMemberInfoByid($editid);
	$id 			= $editid;
	$name 		    = $cData['name'];
	$surname 		= $cData['surname'];
	$email 		    = $cData['email'];
	$gender         = $cData['gender'];
	$aboutMe 		= $cData['aboutMe'];
	$phone 			= $cData['phone'];
	//$address 		= $cData['address'];
	$city 			= $cData['city'];
	$state 			= $cData['state'];
	$country 		= $cData['country'];
	$status 		= $cData['status'];
	$profilePic		= $cData['profilePic'];
}

?>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
    <?php if($editid) {?>
    <li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $moduleId;?>'">Add Member</a></div></li>
    <?php }?>
</ul>
<?php echo $ErrMsg;
if($editid)
	include("intro.php");
?>

<form name="orderfrm" action="" method="post" enctype="multipart/form-data" class="form-middlegap" style="overflow: hidden;">
	<div class="form_left">
		<div class="form_holder">
            
				<div class="input_left">
				<p class="description-line1">Name *</p>
				<p class="description-line1"><input type="text" name="name" value="<?php echo $name;?>"></p>
			    </div>

			    <!--<div class="input_right">
                    <p class="description-line1">Surname *</p>
                    <p class="description-line1"><input type="text" name="surname" value="<?php echo $surname;?>"></p>
			    </div>-->
			    <div class="input_right">
                    <p class="description-line1">Username *</p>
                    <p class="description-line1"><input type="text" name="email" value="<?php echo $email;?>"></p>
			    </div>
			    <div class="input_left">
				    <p class="description-line1">Phone *</p>
				    <p class="description-line1"><input type="text" name="phone" value="<?php echo $phone;?>"></p>	
                </div>
			    <div class="input_right">
				    <p class="description-line1">Email *</p>
				    <p class="description-line1"><input type="text" name="email" value="<?php echo $email;?>"></p>	
                </div>
			
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
        <?php /*
		<div class="form_holder">
			<div class="input_left">
				<p class="description-line1">Upload Photo</p>
				<p class="description-line1"><input type="file" name="profilePic"></p>
				<?php
				if($profilePic && file_exists($MEDIA_FILES_ROOT.'/member/thumb/'.$profilePic)){
					echo '<p class="description-line1"><img src="'.$MEDIA_FILES_SRC.'/member/thumb/'.$profilePic.'" ></p>';
				    ?>	
                    <a class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&id=<?php echo $cData['id']?>&redstr=<?php echo $redirectString;?>">Delete image</a>
                    <?php
                }
                ?>
		    </div>	
		</div>
        */?>
		
	</div>
    <div class="clear"></div>
	<input name="Back" type="button" onclick="history.back(-1);" class="back"  value="Back" />
	<!--<input name="Save" type="submit" class="save_frm"  value="Save" />-->
    <input name="pageType" type="hidden" value="<?php echo $pageType; ?>" />              
    <input name="moduleId" type="hidden" value="<?php echo $moduleId;?>" />                    
    <input name="dtls" type="hidden" value="<?php echo $dtls;?>" />                    
    <input name="dtaction" type="hidden" value="<?php echo $dtaction;?>" /> 
    <!--<input name="SaveNext" type="submit" class="save_frm"  value="Save & Add New" />-->
    <input name="Cancel" type="button" onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $moduleId;?>'" class="cancel_frm" value="Close" />
	<input type="hidden" value="AddMember" name="SourceForm" /> 
	<input type="hidden" value="<?php echo $id;?>" name="IdToEdit" />  
</form>