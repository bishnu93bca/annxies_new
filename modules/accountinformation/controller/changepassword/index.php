<?php
$mObj=new menu();
$menudata= $mObj -> menu_by_id($moduleId);
if($menudata)
{
	$menu_image        = $menudata['menu_image'];
	$menu_name         = $menudata['menu_name'];
	$parentMenuId      = $menudata['parent_id'];
	$parentmenudata    = $mObj -> menu_by_id($parentMenuId);
	$parent_menu_name  = $parentmenudata['menu_name'];
}
?>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
</ul>
<section id="">
<br class="clear">
<?php echo $ErrMsg?>
<form name="modifycontent" action="" method="post">
    <div class="form_holder"> 
    	<div style="border-right:#e8e8e8 1px solid; float:left; width:48%;">  
    		<div class="input_left">
	            <p class="description-line1">Current Password *</p>
	            <p class="description-line1"><input name="CurrPassword" type="password" class="input2" autocomplete="off" /></p> 
            </div>
            <div class="input_right">       
	            <p class="description-line1">New Password *</p>
	            <p class="description-line1"><input name="NewPassword" type="password" class="input2 gen_pass" autocomplete="off" /></p>        
            </div>
            <div class="input_left">
	            <p class="description-line1">Retype New Password *</p>
	            <p class="description-line1"><input name="ReNewPassword" type="password" class="input2 gen_pass" autocomplete="off" /></p>
            </div>  
    	</div>
        <div style="float:left; width:48%; margin-left:20px;">
            <p class="description-line1"><a href="#" class="generate">Generate Password</a></p>
            <div class="new_pass" style="display:none;"><input type="text" name="genpass" class="input2" value=""/><br />Copy the Password and keep it in a secure place.</div>
        </div>
    </div>	
    		
    <input name="SourceForm" type="hidden" value="SitePassword" />
    <input name="Back" type="button" onclick="history.back(-1);" class="back"  value="Back" />
	<input name="Save" type="submit" class="save_frm"  value="Save" />
    <input name="Cancel" type="button"  onclick="window.location.href='index.php'" class="cancel_frm" value="Close" />	
    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">			
</form>
</section>