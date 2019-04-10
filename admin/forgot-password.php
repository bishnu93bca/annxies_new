<script>
function ForgotPasswordValidate()
{	
	if(document.formpassword.Email.value=="")
	{
		alert("Please Enter Your Email Address");
		document.formpassword.Email.focus();
		return false;
	}
	
	if(document.formpassword.Email.value!="")
	{
		if((/^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z.]{2,5}$/).exec(document.formpassword.Email.value)==null && document.formpassword.Email.value.length>0)
		{
			alert("Email Address Is Not Valid");
			document.formpassword.Email.focus();
			return false;
		}
	}
}
</script>

<div role="main" id="login_main">
    <div id="welcome" class="forgot_wrap">
        <p>Welcome to Admin</p>
        <div id="login">
            <div>Password Recovery</div>
            <form name="formpassword" method="post" action="" id="formPassReminder">
                <div id="form">
                   	<?php echo $ErrMsg;?>
					<div class="log_field_block">
						<div class="log_field">
							<label for="pwd">Email * </label>
							<input class="input" name="Email" maxlength="50" value=""  />
						</div>
					</div>
                     <div class="guide_text">Enter the email address that you used when you first signed up to our site.</div>
                </div>
   
                 <input name="goto" type="hidden" value="<?php echo $goto?>"/>
                 <input name="SourceForm" type="hidden" value="ForgotPassword" />
                 <input name="Submit" type="submit" class="login_btn" value="Submit" onclick="return ForgotPasswordValidate()" />
                 <a href="index.php" class="forgot_link log_back">Login</a>
            </form>
        </div>
    <!--end of the login--> 
    </div>
    <!--end of the welcome-->     
</div>

