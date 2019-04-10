<!-- Codes by Quackit.com -->
<script type="text/javascript">
// Popup window code
function newPopup(url) {
	popupWindow = window.open(url,'popUpWindow','height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
}
</script>
<header>
    <a href="index.php" id="logo">
    <?php
    if(file_exists($MEDIA_FILES_ROOT."/logo/".SITE_LOGO) && SITE_LOGO)
        echo '<img src="'.$MEDIA_FILES_SRC."/logo/".SITE_LOGO.'" alt="'.SITE_NAME.'" title="'.SITE_NAME.'" />';
    else
        echo '<img src="'.$STYLE_FILES_SRC.'/assets/images/logo.png" alt="'.SITE_NAME.'" title="'.SITE_NAME.'" />';
    ?></a>
    <div id="user">
		<span class="responsive_btn" data-click="n">
			<span></span>
			<span></span>
			<span></span>
		</span>
       <div class="user_settings">
            <strong>Welcome, Admin <i class="fa fa-cog"></i></strong>
            <span class="logout">
                <a href="<?php echo $SITE_LOC_PATH;?>" target="_blank" class="site_preview"><i class="fa fa-globe"></i>Visit Website</a>
                <a href="index.php?pageType=accountinformation&dtls=myaccountinfo&moduleId=83" class="password_chng"><i class="fa fa-user"></i>My Account</a>
                <a href="index.php?pageType=accountinformation&dtls=changepassword&moduleId=85" class="password_chng"><i class="fa fa-key"></i>Change Password</a>
                <a href="index.php?pageType=logout" class="logout_btn"><i class="fa fa-sign-out"></i> Logout</a>
            </span>
        </div> 
    </div><!--end of the user-->
</header>

<div class="content">
	<?php include("includes/leftmenu.php");?>
    <section id="main">
    <?php	
	if($pageType)
	{	
		if($dtls!='')
		{			
			//Include Actions files for individual module.
			if(file_exists('../'.MODULE_PATH.'/'.$pageType.'/'.CONTROLLER_PATH.'/'.$dtls.'/action.php')) // Call action file from controller
				$actionname = '../'.MODULE_PATH.'/'.$pageType.'/'.CONTROLLER_PATH.'/'.$dtls.'/action.php';
			elseif(file_exists($pageType.'/'.$dtls.'/action.php')) // Call action file from the admin module
				$actionname = $pageType.'/'.$dtls.'/action.php';
			else
				$actionname = '';
			
            if($_POST && $actionname){
                try
                {
                    // Run CSRF check, on POST data, in exception mode, for 10 minutes, in one-time mode.
                    //NoCSRF::check('csrf_token', $_POST, true, 60*10, true);
                    include($actionname);
                }
                catch(Exception $e)
                {
                    if($ajax==1)
                        echo '<p class="error">Form ignored!</p>';
                    else
                        $ErrMsg = '<p class="error">Form ignored!</p>';
                    //$result = $e->getMessage() . ' Form ignored.';
                }
            }
			//------------------------------------------
            $token = NoCSRF::generate('csrf_token');
			if($dtaction)
			{	
				if(file_exists('../'.MODULE_PATH.'/'.$pageType.'/'.CONTROLLER_PATH.'/'.$dtls.'/'.$dtaction.'.php')) // Call requested file from the module controller
					$pagename = '../'.MODULE_PATH.'/'.$pageType.'/'.CONTROLLER_PATH.'/'.$dtls.'/'.$dtaction.'.php';
				elseif(file_exists($pageType.'/'.$dtls.'/'.$dtaction.'.php')) // Call requested file from the admin module
					$pagename = $pageType.'/'.$dtls.'/'.$dtaction.'.php';
				else
					$pagename = '';
					
				if($pagename)
					include($pagename);
			}
			else
			{	
				if(file_exists('../'.MODULE_PATH.'/'.$pageType.'/'.CONTROLLER_PATH.'/'.$dtls.'/index.php'))
					$pagename = '../'.MODULE_PATH.'/'.$pageType.'/'.CONTROLLER_PATH.'/'.$dtls.'/index.php';
				elseif(file_exists($pageType.'/'.$dtls.'/index.php'))
					$pagename = $pageType.'/'.$dtls.'/index.php';
				else
					$pagename = '';
				
				if($pagename)					
					include($pagename);
			}
		}
		else
		{			
			if(file_exists('../'.MODULE_PATH.'/'.$pageType.'/'.CONTROLLER_PATH.'/action.php'))
				$actionname = '../'.MODULE_PATH.'/'.$pageType.'/'.CONTROLLER_PATH.'/action.php';
			elseif(file_exists($pageType.'/action.php'))
				$actionname = $pageType.'/action.php';
			else
				$actionname = '';
			
			if($_POST && $actionname){
                try
                {
                    // Run CSRF check, on POST data, in exception mode, for 10 minutes, in one-time mode.
                    //NoCSRF::check('csrf_token', $_POST, true, 60*10, true);
				    include($actionname);
                }
                catch(Exception $e)
                {
                    if($ajax==1)
                        echo '<p class="error">Form ignored!</p>';
                    else
                        $ErrMsg = '<p class="error">Form ignored!</p>';
                    //$result = $e->getMessage() . ' Form ignored.';
                }
            }
            
            $token = NoCSRF::generate('csrf_token');
			if($dtaction)
			{
				if(file_exists('../'.MODULE_PATH.'/'.$pageType.'/'.CONTROLLER_PATH.'/'.$dtaction.'.php'))
					$pagename = '../'.MODULE_PATH.'/'.$pageType.'/'.CONTROLLER_PATH.'/'.$dtaction.'.php';	
				elseif(file_exists($pageType.'/'.$dtaction.'.php'))
					$pagename = $pageType.'/'.$dtaction.'.php';	
				else
					$pagename = '';
				
				if($pagename)
					include($pagename);
			}
			else
			{
				if(file_exists('../'.MODULE_PATH.'/'.$pageType.'/'.CONTROLLER_PATH.'/index.php'))
					$pagename = '../'.MODULE_PATH.'/'.$pageType.'/'.CONTROLLER_PATH.'/index.php';
				elseif(file_exists($pageType.'/index.php'))
					$pagename = $pageType.'/index.php';
				else
					$pagename = '';
					
				if($pagename)
					include($pagename);
			}
		}	
	}	
	else
		include("welcome.php");
	
	/*if($menudata['menu_description'])
	{		
		?>		
        <div class="description-line">            
            <img src="images/instruction.png" alt="Help" title="Instruction about this Module" height="25"/>            
            <h2>Instruction: &nbsp;</h2>
            <?php echo $menudata['menu_description'];?>	
        </div>
		<?php	
	}*/
	?>
</section>