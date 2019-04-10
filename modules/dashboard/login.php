<?php
if($dtaction!='samplecontractsign')
{
    if($_SESSION['FUSERLOGIN']=='ok'){
    if(isset($_GET["APRV_KEY"]) && !empty($_GET["APRV_KEY"])){
        session_destroy();
        $uObj = new MemberView();
        $getNewEmail = $uObj -> approveMemberForNewEmail($_GET["APRV_KEY"]);
        if($getNewEmail != 'ok')
            $siteObj -> redirectToURL($SITE_LOC_PATH);
    }
    else
        $siteObj -> redirectToURL($SITE_DASHBOARD_PATH.'/social-media/');
}

    if(isset($_GET["APRV_KEY"]) && !empty($_GET["APRV_KEY"])){
    
    $uObj               = new MemberView;
    $approveUserStatus  = $uObj -> approveMember($_GET["APRV_KEY"]);
    
    if($approveUserStatus){
        $rslt = explode('>',$approveUserStatus);
        ?>
        <script type="text/javascript">
            $(function () {
                misteryMessage('<?php echo $rslt[1];?>','<?php echo $rslt[0];?>');
                setTimeout(function(){
                    $('.message-' + '<?php echo $rslt[0];?>').removeClass('active');
                    $('.overlay_msg').fadeOut();
                },5000);
            });
        </script>
        <?php
    }
}
    ?>

    <div class="tag_line">
        <div class="container">
          <div class="row">
            <div class="span12">
              <div class="welcome">
                <h2 style="text-align:center;"> <strong>Login</strong></h2>
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
                        <h2 class="form_head">Welcome valued member. Please log in.</h2>
                        <form method="post" id="loginform">
                            <ul class="clearfix">
                                <li>
                                    <label>Username</label>
                                    <input type="text" placeholder="" autocomplete="off" name="username" />

                                </li>
                                <li>
                                    <label>Password</label>
                                    <input type="password" placeholder="" autocomplete="off" name="password" />
                                </li>
                                <li>
                                    <!--<input type="submit" value="Login" class="btn submitbtn animate_btn">-->
                                    <input type="submit" name="submit" class="btn submitbtn animate_btn" value="LogIn">

                                </li>
                                <li>
                                    <div class="form_btm">
                                        <label class="checkbox">
                                            <input type="checkbox" name="remember" value="yes" /><em></em>
                                            <span>Remember me</span>
                                        </label>
                                        <div class="help_text"><a href="<?php echo $SITE_LOC_PATH.'/forgot-password/';?>">Forgot password!</a></div>
                                        <div class="clearfix"></div>
                                    </div>
                                </li>
                            </ul>

                            <input type="hidden" name="ajax" value="1">	
                            <input type="hidden" name="csrf_token" value="<?php echo $token;?>">
                            <input type="hidden" name="SourceForm" value="LogIn">
                            <input class="captchabox" style="visibility:hidden;" type="text" name="captcha" value="">
                        </form>
                        <div class="">
                            <h2 class="form_head">Not a member yet? <a href="<?php echo $SITE_LOC_PATH;?>/membership-packages/compare-packages/">Register now</a>.</h2>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
}
else{
    $eObj = new MemberView();	
    $smValid = $eObj->getsampleContractInfo($validation);
    ?>
    <div class="container bootstrapCommon">
        <div class="row">
        <?php
        if($smValid)
        {
            ?>
            <div class="col-md-12">
                <div class="h-box-100 contract_details">
                        <div class="h-heading">Sign Your Contract</div>
                        <div class="row">
                            <div class="col-sm-12 pb40">
                                <div class="border_btm comheight">
                                    <div class="con_name">Dear <?php echo $smValid['name'];?>,</div>
                                    <p>Congratulation your application for samples and distribution have been approved. Based on your product dimensions and weight we have allocated space in the warehouse..</p>
                                </div>
                            </div>
                            
                        </div>
                        <hr>
                        <form name="" id="sampleCont" method="post">
                            <div class="row">
                            <?php
                            $label      = 'Total Charge';
                            $totalall   = $smValid['setUp']+$smValid['shippingCharge']+$smValid['shippingCharge1'];
                            ?>
                            <div class="col-sm-12 pt40">
                                <div class="border_btm comheight">
                                    <div class="con_heading">Charges will be:</div>
                                    <div class="mv30">
                                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                            <tr>
                                                <td>Set up fee</td>
                                                <td>: <?php echo $smValid['setUp'].' '.$smValid['scurrency'];?></td>
                                            </tr>                     
                                            <tr>
                                                <td>Shipping deposit</td>
                                                <td>: <?php echo $smValid['shippingCharge'].' '.$smValid['scurrency'];?></td>
                                            </tr>                     
                                            <tr>
                                                <td>Shipping deposit1</td>
                                                <td>: <?php echo $smValid['shippingCharge1'].' '.$smValid['scurrency'];?></td>
                                            </tr>  
                                            <tr><p>Future shipping fees are deducted from shipping </p>  </tr>
                                                       
                                            <tr>
                                                <td><b><?php echo $label;?></b></td>
                                                <td><b>: <?php echo $totalall.' '.$smValid['scurrency'];?></b></td>
                                            </tr>                     
                                        </table>
                                    </div>
                                    <hr>
                                    <div class="sign_box">
                                        <p>We are looking forward to serving you and providing all your business needs. Your
account activation and set up is in progress and will be completed upon verification of your payment.</p>

                                        <div class="row">
                                            <div class="col-sm-5 sign_left">
                                                <div class="clearfix"><strong class="mr_5">ANNEXIS Business Solution Services LLC.</strong></div>
                                                <div class="clearfix"><strong class="sign_title">Name</strong> <span class="sign_val">Jacques Dieuvil</span></div>
                                                <div class="clearfix"><strong class="sign_title">Title</strong> <span class="sign_val">Business Executive Manager</span></div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="clearfix"><strong class="sign_title">Name</strong> <span class="sign_val"><?php echo $smValid['name'];?></span></div>
                                                <div>
                                                    <strong class="sign_title">Signature </strong>
                                                    <div class="sign_div">
                                                        <div id="signature"></div>
                                                    </div> 
                                                    <div class="text-right" id="clr">
                                                        <a onClick="jQuery('#signature').jSignature('clear')" class="btn btn_more">Clear</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <div class="text-center mt30">
                                        <button type="button" class="btn btn_blu smtcnt">Submit Contract</button>
                                        <input type="hidden" name="ajax" value="1">
                                        <!--<input type="hidden" name="SourceForm" value="sampleContract">
                                        <input type="hidden" name="validation" value="<?php echo $validation;?>">-->
                                    </div>
                                    <div class="text-center mt30 f12">
                                        <p>If you have any questions, please mail us at <a href="mailto:support@annexis.net" class="orng">support@annexis.net</a> or call us on <span class="orng">(800) 513-4450</span>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
            </div>               
            <?php
        }
        else
            echo '<div class="welcome contReg"><h2> <strong>Your contract was already signed.<br> Please log into the system or call customer service at - '.SITE_PHONE.'</strong> </h2></div>';
        ?>
        </div>
    </div>
    <?php
}
?>