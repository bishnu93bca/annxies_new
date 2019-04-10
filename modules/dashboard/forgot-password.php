<?php
if($_SESSION['FUSERLOGIN']=='ok')
    $siteObj -> redirectToURL($SITE_DASHBOARD_PATH.'/social-media/');
?>
<div class="tag_line">
    <div class="container">
      <div class="row">
        <div class="span12">
          <div class="welcome">
            <h2 style="text-align:center;"> <strong>Forgot Password!</strong></h2>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="main_content_area">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="form_wrap text-center reg_frmwrap">
                    <?php
                    if(isset($_GET["PSSW_KEY"]) && !empty($_GET["PSSW_KEY"])){
                        $uObj = new MemberView;
                        $checkUserStatus = $uObj -> checkMemberByPassKey($_GET["PSSW_KEY"]);

                        if ($checkUserStatus == 1){ ?>
                            <h2 class="form_head">Password must be at least 8 characters and needs 1 capital, 1 non-capital, 1 digit.</h2>
                            <form action="" method="post" id="changepasswordform" autocomplete="off">
                                <div class="loginErrMsg"></div>

                                <ul class="clearfix">
                                    <li>
                                        <label>New Password</label>
                                        <input class="custom_validate passwordfield" name="password" type="password" autocomplete="off">
                                    </li>
                                    <li>
                                        <label>Confirm Password</label>
                                        <input class="custom_validate" name="cnfrm_password" type="password" autocomplete="off">
                                    </li>
                                    <li>
                                        <!--<input type="submit" value="Update Password" class="btn log_btn animate_btn">-->
                                        <button type="submit" class="btn log_btn animate_btn">Update Password</button>
                                        <input type="hidden" name="ajax" value="1">			
                                        <input type="hidden" name="csrf_token" value="<?php echo $token;?>">
                                        <input type="hidden" name="passwordKey" value="<?php echo $_GET['PSSW_KEY'];?>">
                                        <input type="hidden" name="SourceForm" value="ResetPassword">
                                        <input style="visibility: hidden;" type="text" name="captcha" value="">
                                        <input type="hidden" name="goto" value="<?php echo $SITE_LOC_PATH.'/login/';?>">
                                    </li>
                                </ul>
                            </form>
                            <div class="">
                                <h4 class="form_head">Have an account? <a href="<?php echo $SITE_LOC_PATH.'/login/';?>">Log in</a>.</h4>
                            </div>

                        <?php }else{ ?>
                            <h2 class="form_head">Please enter your registered email id</h2>
                            <form action="" method="post" id="forgotpasswordform" autocomplete="off">
                                <div class="loginErrMsg"><?php echo $checkUserStatus;?></div>
                                
                                <ul class="clearfix">
                                    <li>
                                        <label>Email</label>
                                        <input class="custom_validate" name="email" type="text" placeholder="" autocomplete="off">
                                    </li>
                                    <li>
                                        <!--<input type="submit" class="log_btn animate_btn" value="Request Password">-->
                                        <button type="submit" class="btn log_btn animate_btn">Request Password</button>
                                        <input type="hidden" name="ajax" value="1">			
                                        <input type="hidden" name="csrf_token" value="<?php echo $token;?>">
                                        <input type="hidden" name="SourceForm" value="ForgotPassword">
                                        <input class="captchabox" style="visibility:hidden;" type="text" name="captcha" value="">
                                    </li>
                                </ul>
                            </form>

                    <?php }
                    }else{
                        ?>
                        <h2 class="form_head">Please enter your registered email id</h2>
                        <form action="" method="post" id="forgotpasswordform" autocomplete="off">
                            <div class="loginErrMsg"></div>

                            <ul class="clearfix">
                                <li>
                                    <label>Email</label>
                                    <input class="custom_validate" name="email" type="text" placeholder="" autocomplete="off">
                                </li>
                                <li>
                                    <!--<input type="submit" value="Request Password" class="btn log_btn animate_btn">-->
                                    <button type="submit" class="btn log_btn animate_btn">Request Password</button>
                                    <input type="hidden" name="ajax" value="1">			
                                    <input type="hidden" name="csrf_token" value="<?php echo $token;?>">
                                    <input type="hidden" name="SourceForm" value="ForgotPassword">
                                    <input class="captchabox" style="visibility:hidden;" type="text" name="captcha" value="">
                                </li>
                            </ul>
                        </form>
                        <div class="">
                            <h4 class="form_head">Not a member yet? <a href="<?php echo $SITE_LOC_PATH;?>/membership-packages/">Register now</a>.</h4>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div><!-- padding_inner ends -->
        </div>
    </div>
</div>