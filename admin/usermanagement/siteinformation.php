<ul id="breadcrumb">
	<li>
		<?php if($editid) echo 'Edit User :: '.$username; else echo 'Add User';?> >> STEP - I
	</li>
</ul>
<form name="modifycontent" action="" method="post">
    <div class="form_holder"> 
        <div id="information">
            <div style="border-right:#e8e8e8 1px solid; float:left; width:48%;">	
                <ul style=" width:100%;">
                    <li  class="subHeadiing">Login information</li>
                    <li><p>User Id * </p><span><input type="text" name="username" class="property-input" value="<?php echo $username;?>" maxlength="50"  /></span></li>
                    <li><p>Password *</p><span><input type="password" name="password" class="property-input gen_pass" value="<?php echo $password;?>" maxlength="50"  /></span></li>
                    <li><p>Confirm Password *</p><span><input type="password" class="property-input gen_pass" name="conpassword" value="<?php echo $conpassword;?>" maxlength="50"  /></span></li>
                </ul>
            </div>
            <div style="float:left; width:48%; margin-left:20px;">
                <p class="description-line1"><a href="#" class="generate">Generate Password</a></p>
                <div class="new_pass" style="display:none;"><input type="text" name="genpass" class="input2" value=""/><br />Copy the Password and keep it in a secure place.</div>
            </div>
        </div>
    </div>
    <div style="width:49%; float:left;">
        <div class="form_holder">         		
            <ul style=" width:100%;">
                <li  class="subHeadiing">Personal information</li>
                <li>
                      <p>Name * </p>
                      <span><input name="fullname" type="test" class="property-input" value="<?php echo $fullname;?>" maxlength="50" /></span>
                </li>
                <li>
                      <p>Email * </p>
                      <span><input name="email" type="text" class="property-input" value="<?php echo $email;?>" maxlength="50"/></span>
                </li>
                <li>
                      <p>Phone</p>
                      <span><input name="phone" type="text" class="property-input" value="<?php echo $phone;?>"/></span>
                </li>
                <li>
                      <p>Address</p>
                      <span ><textarea class="property-input" name="address" rows="3"><?php echo $address;?></textarea></span>
                </li>
            </ul>		
        </div>
    </div>
    <div style="width:49%; float:right;">
        <div class="form_holder">         		
            <ul style=" width:100%;">
                <li  class="subHeadiing">Site information</li>
                <li>
                      <p> Site Name * </p>
                      <span><input name="siteName" type="text" class="property-input" value="<?php echo $siteName;?>"/></span>
                </li>
                <li>
                      <p> Site Url *</p>
                      <span><input name="siteUrl" type="text" class="property-input" value="<?php echo $siteUrl;?>" /> <strong>[Ex. domain.com or subdomain.domain.com]</strong></span>
                </li>

                <li>
                      <p> Site Email *</p>
                      <span><input name="siteEmail" type="text" class="property-input" value="<?php echo $siteEmail;?>" /></span>								
                </li>
                <li>
                      <p> Site Phone</p>
                      <span><input name="sitePhone" type="text" class="property-input" value="<?php echo $sitePhone;?>"/></span>				
                </li>
            </ul>
        </div>
    </div>
    
    <br class="clear">
    <div class="form_holder"> 				
        <p class="description-line1">
            <span class="save_button-box">
                <input name="IdToEdit" type="hidden" value="<?php echo $editid;?>" />
                <input name="siteId" type="hidden" value="<?php echo $siteId;?>" />
                <input name="SourceForm" type="hidden" value="SiteInformation" />				
                <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
                <input name="Save" type="submit" class="save_frm" value="Save" />
                <input name="Cancel" type="button"  onclick="window.location.href='index.php?pageType=<?php echo $pageType;?>'" class="cancel_frm" value="Close" />
                <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
            </span>
        </p>
    </div>
</form>