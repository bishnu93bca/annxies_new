<?php
if($editid!='')
{
	$obj = new MyAccount();
	$selData = $obj->getAccountDetailsByuserId($editid);
	if($selData)
	{
		$username = $selData['username'];
		$password = $selData['orgPassword'];
		$fullname = $selData['fullname'];
		$email = $selData['email'];
		$address = $selData['address'];
		$phone = $selData['phone'];
		$siteId = $selData['siteId'];
		$siteName = $selData['siteName'];
		$siteUrl = $selData['siteUrl'];
		$siteEmail = $selData['siteEmail'];
		$sitePhone = $selData['sitePhone'];
		$sitePaypalEmail = $selData['sitePaypalEmail'];
		$siteCurrency = $selData['siteCurrency'];
		$sitePaypalSuccessPath = $selData['sitePaypalSuccessPath'];
		$sitePaypalCancelPath = $selData['sitePaypalCancelPath'];
		
		$access_add = $selData['access_add'];
		$access_edit = $selData['access_edit'];
		$access_delete = $selData['access_delete'];
		$themes = $selData['themes'];
		$themeId = $selData['themeId']; 		
		
		$userpermission_array = explode(',',$selData['permission']);		
	}
}
?>
<ul id="breadcrumb">
    <li><a href="#"><?php if($editid) echo 'Edit Module Permission :: '.$username; else echo 'Add User : Module Permission';?> >> STEP - II</a></li>   
</ul>
<?php if($_SESSION['ErrMsg']) { echo $_SESSION['ErrMsg']; unset($_SESSION['ErrMsg']);}
echo $ErrMsg;
?>

<form name="modifycontent" action="" method="post">
    <div class="form_holder">
        
        <?php
        $menu = new menu();
        $sel_Details = $menu ->menu_details_by_parent_id();
        if(sizeof($sel_Details)>0)
        {
            for($i=0;$i<sizeof($sel_Details);$i++)
            {
                ?>
                <fieldset style="border:1px solid #CCCCCC;">
                    <legend>
                        <span class="folder" style="width:10px;">	
                        <?php
                        if($userpermission_array && in_array($sel_Details[$i]['menu_id'],$userpermission_array))
                            $chk ='checked="checked"';
                        else
                            $chk ='';
                        ?>

                        <input type="checkbox" name="permission[]" value="<?php echo $sel_Details[$i]['menu_id'];?>" <?php echo $chk; ?> />
                        <?php echo $sel_Details[$i]['menu_name'];?>
                        </span>
                    </legend>

                    <?php
                    $submenu=$menu -> welcomepage_sub_menu($sel_Details[$i]['menu_id']);								

                    if(sizeof($submenu)>0) 
                    {
                        for($sm=0;$sm<sizeof($submenu);$sm++) 
                        {
                            $chk='';
                            if($userpermission_array && in_array($submenu[$sm]['menu_id'],$userpermission_array))
                                $chk ='checked="checked"';
                            else
                                $chk ='';

                            echo '<div style="width:180px; padding:10px; float:left;"><input type="checkbox" name="subpermission[]" value="'.$submenu[$sm]['menu_id'].'" '.$chk.' />&nbsp;'.$submenu[$sm]['menu_name'].'</div>';					
                        }					
                    }
                    ?>

                </fieldset>
                <br />
                <?php
            }
        }
        ?>		
    </div>
    <div class="iconbox">		
        <p class="description-line1">
            <span class="save_button-box">
                <input name="IdToEdit" type="hidden" value="<?php echo $editid;?>" />
                <input name="siteId" type="hidden" value="<?php echo $siteId;?>" />
                <input name="userId" type="hidden" value="<?php echo $userId;?>" />
                <input name="SourceForm" type="hidden" value="ModulePermission" />				
                <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
                <input name="Save" type="submit" class="save_frm" value="Save" />
                <input name="Cancel" type="button"  onclick="location.href='index.php?pageType=<?php echo $pageType;?>'" class="save_frm" value="Close" />
                <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
            </span>
        </p>
    </div>
</form>