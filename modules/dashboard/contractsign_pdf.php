<?php 
$val          = $_GET['validation'];
if($val)
{
    $mObj     = new MemberView();
    $validation   = $mObj->getContractInfo($val);
    
    if($dtls=='signsamplepdf'){
        ?>
        <body style="width: 720px; margin: auto;">
            <div class="container" style="width: 100%;">
                <div class="row">
                </div>
            </div>            
        </body>
        <?php
    }
    else
    {
        ?>
        <body style="width: 720px; margin: auto;">
            <!-------------- CONTENT --------------------->
            <!-- Begin page content -->
            <div class="container" style="width: 100%;">
                <div class="row">
                    <?php
                    $img_path   = $validation['img'];                    
                    $userData   = $mObj->getMemberById($validation['id_user']);
                    $name       = $userData['name'].' '.$userData['surname'];

                    $payD   = $mObj->getTempcontract($val);
                    $plan   = $payD['plan'];
                    $mjesec = $payD['mjesec'];

                    $mmData = $mObj->getPackageBypermalink($plan);
                    $fn     = 150;
                    $mc     = $mmData['price'];
                    $total  = $mc*$mjesec;

                    if($plan == 'standard')
                    {
                        $fn  = $mc = 0;

                        $ch1 ='';
                        $ch2 ='';
                        $ch3 ='';
                        $ch4 ='checked';
                        $dis1='disabled';
                        $dis2='disabled';                        

                        $helpflag   =0;

                        $benefit    = '<tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">Directory listing with 20 product products or services on Annexis Directory website.</td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">Promote on popular search engines such as Bing, Google, Yahoo etc.</td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">Featured in Annexis Business Directory Newsletter.</td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">Pay-per-click campaigns for promotional based on industry and key word.</td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">Become eligible to be featured on the Annexis Business Directory Magazine.</td>
                                        </tr>';
                    }	
                    elseif($plan=='silver')
                    {
                        $ch1='checked';
                        $ch2='';
                        $ch3='';
                        $ch4='';
                        $dis1='disabled';
                        $dis2='disabled';


                        $helpflag=0;

                        $benefit    = '<tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">10  Hours of Live Receptionist.</td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">5  Hours of Office Use – 300 Choice Option throughout the United State (Advance  Booking Required).</td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">Personal Sales Representative Assign - SET UP.</td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">Option  for Add-On Services – The is an option these services are add on and subject to  additional charges base on customer&rsquo;s need.   A separate agreement will be supplied when Add-On service is purchased.</td>
                                        </tr>';
                    }
                    elseif($plan=='gold')
                    {
                        $ch1='';
                        $ch2='checked';
                        $ch3='';
                        $ch4='';
                        $dis1='';
                        $dis2='disabled';

                        $helpflag=1;	

                        $benefit    = '<tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">10  Hours of Live Receptionist.</td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">5  Hours of Office Use – 300 Choice Option throughout the United State (Advance  Booking Required).</td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">Personal  Sales Representative Assign - SET UP.</td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">Option  for Add-On Services – The is an option these services are add on and subject to  additional charges base on customer&rsquo;s need.   A separate agreement will be supplied when Add-On service is purchased.</td>
                                        </tr>';
                    }
                    elseif($plan=='platinum')
                    {
                        $ch1='';
                        $ch2='';
                        $ch4='';
                        $ch3='checked';	
                        $dis1='disabled';
                        $dis2='';	

                        $helpflag=2;	
                        $benefit = '<tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">30  Hours of Free Live Receptionist / Month.</td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">10  Hours of Office Use / Month - 300 Choice Option throughout the United State  (Advance Booking Required).</td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">Personal  Sale Representative – Set Up.</td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">Free  Consultation and Analysis on ANNEXIS Business Solutions.</td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">Business  Review – Include Marketing &amp; Branding Analysis, Tax and Legal service  options &ldquo;Creating Brand Identity - Brand Positioning -Rebranding Solutions&rdquo;.</td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px; vertical-align:top; padding-top:4px;"><img src="'.$STYLE_FILES_SRC.'/assets/images/bullet.png" width="6" height="10" alt="bullet" style="display:block;"></td>
                                            <td style="vertical-align:top; padding:0 0 10px;">Free  Listing of Target Companies for first 8000 companies using ANNEXIS Business  Database.</td>
                                        </tr>';
                    }
                    ?>
                    <table width="100%" style="background:#fff; border:none; border-collapse:collapse; margin:0 auto;">
                    <tr>
                        <td style="padding:35px 25px 20px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#686767;">
                        <table style="width:100%; border:none; border-collapse:collapse;">
                        <tr>
                            <td style="text-align:center;"><img src="<?php echo $STYLE_FILES_SRC;?>/assets/images/logo.png" width="256" height="61" alt=""></td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top;">
                                <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800; line-height: normal">Welcome to Annexis</div>
                                <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div>

                                <div style="padding:0 0 11px; font-size:18px; color:#3289ae;">Dear <?php echo $name;?>,</div>

                                <div style="padding:0 0 30px;">Congratulations on your selection for the <strong><?php echo strtoupper($plan);?></strong> package.</div>                                
                            </td>
                        </tr>

                        <tr>
                            <td style="vertical-align:top;">
                                <table style="width:100%; border:none; border-collapse:collapse;">
                                    <tr>
                                        <td style="vertical-align:top; width:247px; text-align:center; padding-top:3px;">
                                            <img src="<?php echo $STYLE_FILES_SRC;?>/assets/images/box-top.png" width="247" height="14" alt="top" style="display:block;">
                                            <div style="border-left:3px solid #dedddd; border-right:3px solid #dedddd;">
                                                <div style="padding:15px 0;">
                                                    <img src="<?php echo $STYLE_FILES_SRC;?>/assets/images/circle1.png" width="70" height="70" alt="circle">
                                                </div>
                                                <div style="font-size:24px; color:#3289ae; font-weight:bold; padding-bottom:3px;"><?php echo strtoupper($plan);?> Membership Package</div>
                                                <div style="font-size:16px; color:#2c2c2c; font-weight:bold; padding-bottom:15px;"><?php echo $mjesec;?> Month</div>
                                            </div>
                                            <img src="<?php echo $STYLE_FILES_SRC;?>/assets/images/box-bottom.png" width="247" height="14" alt="bottom" style="display:block;">
                                        </td>

                                        <td style="vertical-align:top; padding-left:20px;">
                                            <div style="font-size:18px; font-weight:bold; color:#000; padding-bottom:16px;">Package Benefits</div>
                                            <table style="width:100%; border:none; border-collapse:collapse;">
                                                <?php echo $benefit;?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                          <td style="vertical-align:top;">
                                <div style="text-align:right; padding:12px 0 38px;"><a href="<?php echo $SITE_LOC_PATH.'/membership-packages/compare-packages/';?>" style="display: inline-block; height: 40px; line-height: 40px; padding: 0 25px; background: #FF7800; color: #fff; font-weight: bold; -webkit-border-radius: 20px; border-radius: 20px; text-decoration: none;">Read More</a></div>
                                <div>We look forward to serving you and providing all your business needs.</div>

                                <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800;  line-height: normal">Savings</div>
                                <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div>

                            <div style="padding:0 0 11px; font-size:16px; color:#3289ae; font-weight:bold;">30% Savings on Add-On Services:</div>
                                <div style="padding-bottom:23px;line-height:18px;">Option for Add-On Services – The is an option these services are add on and subject to additional charges base on customer’s need. A separate agreement will be supplied when Add-On service is purchased.</div>
                                <div style="padding-bottom:23px;line-height:18px;">Marketing Services (Email Marketing, Direct Mail Marketing, Marketing Material Design, Website Design & Development, Mobile Application Design & Development, Social Media Marketing and Advertising, Packaging and Print Design)</div>
                                <div style="padding-bottom:23px;line-height:18px;">Consulting Services (Business Registration, Legal Consulting Service, Tax Consulting Service, Fundraising Services)</div>
                            <div style="line-height:18px;">Sales Representative (Dedicated Sales Representative to respond to inquiry over phone, email and in person – hourly charges, travel expenses will apply when dedicated sales representative is working on your behalf) page</div>

                                <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800; line-height: normal">Terms of Payment</div>
                                <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div>

                                <div style="padding-bottom:23px;line-height:18px;">All statements by ANNEXIS to the Customer shall be paid within 30 days of the date of the statement. If the Customer disputes any portion of the statement, the Customer must bring the dispute to the attention of ANNEXIS in writing within 15 days of the date of the statement. The failure of the Customer to send a written notice of dispute within this time period shall be deemed a waiver by the Customer of the right to dispute any portion of the statement. If the dispute relates to a portion of the statement, the Customer shall be required to make payment of the undisputed balance within the time period set forth above.</div>

                                <div style="padding-bottom:23px;line-height:18px;">If the Customer fails to make payment of the invoice within the time period set forth above, ANNEXIS shall have the right to suspend or terminate all Services, upon twenty-four (24) hour written or verbal notice.</div>
                            <div>Services which are suspended or terminated for nonpayment may be subject to a reconnection charge of $100 and an additional deposit equaling the average invoice amount for the three (3) months prior to suspension and/or termination. The Customer shall be responsible for payment of all Services up to the time of suspension or termination and for payment of a late charge of $15.00 per month on any unpaid overdue balances.</div>

                                <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800; line-height: normal">Illegal Use</div>
                                <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div>

                                <div style="line-height:18px;">The Customer represents and warrants that the Services will not be used for any illegal purpose. If ANNEXIS becomes aware that the Services are being used for any illegal purpose, ANNEXIS shall have the right to suspend or terminate all Services IMMEDIATELY, without any prior written or oral notice to the Customer. The Customer shall be responsible for payment of all Services up to the time of suspension or termination and ANNEXIS shall have the right to apply the deposit to any unpaid balances.</div>

                                <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800; line-height: normal">Confidentiality</div>
                                <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div>

                                <div style="line-height:18px;">ANNEXIS shall treat all messages as confidential and shall not intentionally disclose messages to any unauthorized person or organization. However, ANNEXIS shall not be responsible for any inadvertent disclosure and shall have the right to cooperate with all law enforcement agencies or organizations and may disclose to them whatever information is requested pursuant to the performance of their official duties, without prior notice to the Customer of such requests.</div>

                                <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800; line-height: normal">Limitation of Liability</div>
                                <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div>

                                <div style="line-height:18px;">ANNEXIS shall not be liable for any acts, errors or omissions by it or its employees or agents, except for conduct which is adjudicated to be grossly negligent or intentional. ANNEXIS entire liability to the Customer as to damages for, based upon, or in connection with, either directly or indirectly, Services provided or which should have been provided by ANNEXIS to or on behalf of the Customer shall not exceed the fees and costs payable by the customer to and enforced in
accordance with and governed by the laws of the State of Florida.</div>

                                <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800; line-height: normal">Entire Agreement</div>
                                <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div>

                                <div style="line-height:18px;">This Agreement represents the entire agreement of the parties to This Agreement and supersedes all negotiations, representations, prior discussions or preliminary agreements between the parties. No statements, warranties, or representations of any kind that are not contained in this Agreement shall in any way bind the parties. This Agreement can only be changed or modified
by a writing signed by all of the parties to this Agree. ANNEXIS for the payment period in which
the conduct giving rise to the claim took place. Notwithstanding the above, in no event shall ANNEXIS or its employees or agents be liable to the Customer for (a) any incidental or consequential damages, including, but not limited to, any lost profits or revenues arising either directly or indirectly from the performance, or failure to perform, any Services; (b) any punitive, exemplary, or multiplied damages; (c) any damages for, based upon, or arising out of any natural disasters, weather conditions, civil disturbances, material shortages, electronic or mechanical failures, or problems with or the interruption of telephone service.</div>

                                <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800; line-height: normal">Indemnification</div>
                                <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div>

                                <div style="line-height:18px;">The Customer agrees to defend, indemnify and hold ANNEXIS and its employees and agents harmless as against any and all liabilities, losses, damages, injuries, claims, suits, judgments, settlements, awards, costs, charges and expenses, including but not limited to any fees, costs, charges and expenses incurred by ANNEXIS for investigation, defense, and resolution, for, based upon, or arising out of the performance or failure to perform any Services under or pursuant to the Agreement.</div>


                                <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800; line-height: normal">Ownership & Property Rights</div>
                                <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div>

                                <div style="line-height:18px;">All technologies, software, hardware, operating applications, procedures, scripts, telephone numbers, or other materials of any nature or type prepared, furnished, or utilized by ANNEXIS, shall be considered the sole and exclusive property of ANNEXIS and shall be retained by ANNEXIS upon the termination of this Agreement.</div>

                                 <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800;">Reports & Statistical Information</div>
                                <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div>

                                <div style="line-height:18px;">ANNEXIS may be requested by the Customer from time to time to furnish reports or statistical information to the Customer regarding aspects of the Services being performed. The cost to prepare and furnish such reports and statistical information is not included within the amount specified above as charges for the Services. Therefore, ANNEXIS will advise the Customer of the cost to be charged for the reports and statistical information and obtain the consent of the Customer
before preparing and providing same to the Customer. ANNEXIS does not make any guarantees, warranties, or representations as to the accuracy of the reports and statistical information provided.</div>

                               <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800; line-height: normal">Assignment</div>
                               <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div> 

                                <div style="line-height:18px;">This Agreement is binding on the parties hereto and their respective successors and assigns. Neither the Customer nor ANNEXIS shall assign its rights, duties, or obligations under this Agreement without the written consent of the other party.</div>

                               <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800; line-height: normal">Severability</div>
                               <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div> 

                               <div style="line-height:18px;">No term or provision of this Agreement that is determined by a court of Competent Jurisdiction to be invalid or unenforceable shall affect the validity or enforceability of the remaining terms and provisions of this Agreement. Any term found to be invalid or unenforceable shall be deemed as severable from the remainder of the Agreement.</div>


                               <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800; line-height: normal">Independent Contractor</div>
                               <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div> 

                               <div style="line-height:18px;">Nothing contained in this Agreement shall be construed or interpreted by the parties hereto, or by any third party, as creating a relationship of principal and agent, partnership, joint venture, or any other relationship between ANNEXIS and the Customer, other than that of independent contractors contracting for the provision and acceptance of Services. Each party will be responsible for hiring, supervising and compensating its own employees and for providing benefits toand withholding taxes for such employees.</div>

                               <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800; line-height: normal">Governing Law</div>
                               <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div> 

                                <div style="line-height:18px;">This Agreement shall be deemed to have been executed in the State of Florida and shall be interpreted, construed.</div>
                                <?php
                                if($plan=='standard')
                                {
                                    $label = 'Total Charge (1ST 3  MONTHS)';
                                    $totalall='<b>FREE</b>';
                                }
                                else
                                {
                                    $label      = 'Total Charge';
                                    $totalall   = '<b>'.$totalall.'</b> (Monthly Base x '.$mjesec.' + Registration Fee)';
                                }
                                ?>
                               <div style="padding:25px 0 11px; margin-top:25px; font-size:26px; border-top:2px solid #b7b6b5;  border-bottom:3px solid #ff7800; line-height: normal">Signed Contract</div>

                               <div style="border-top:1px solid #e4e4e4; border-bottom:1px solid #c5c5c4; margin-bottom:16px; line-height:0; font-size:0;">&nbsp;</div>
                                <p style="margin: 0; width: 100%;">Programming cannot be started until  fully executed agreement is returned.</p>
                                <div class="mv30" style="margin-top: 23px; margin-bottom: 23px;">
                                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                        <tr>
                                            <td>Programming &amp; Training Charge</td>
                                            <td>: <?php echo '$'.$fn;?></td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Base Rate</td>
                                            <td>: <?php echo '$'.$mc;?></td>
                                        </tr> 
                                        <tr>
                                            <td><b><?php echo $label;?></b></td>
                                            <td>: <?php echo $totalall;?></td>
                                        </tr>                     
                                    </table>
                                </div>
                                <hr>
                                <div class="sign_box" style="margin-top: 23px; margin-bottom: 23px;">
                                   <p style="margin: 0; width: 100%;">In witness whereof, the parties have executed this Agreement  the Date the person signing contract <?php echo date('d');?> of <?php echo date('F');?> <?php echo date('Y');?>.</p>

                                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                        <tr>
                                            <td valign="top">
                                                <div class="sign_left" style="padding-right: 15px;">
                                                    <div class="clearfix"><strong class="mr_5">ANNEXIS Business Solution Services LLC.</strong></div>
                                                    <div class="clearfix"><strong class="sign_title">Name</strong> <span class="sign_val">Jacques Dieuvil</span></div>
                                                    <div class="clearfix"><strong class="sign_title">Title</strong> <span class="sign_val">Business Executive Manager</span></div>
                                                </div>
                                            </td>
                                            <td valign="top">
                                                <div class="" style="padding-left: 15px;">
                                                    <div class="clearfix"><strong class="sign_title">Name</strong> <span class="sign_val"><?php echo $name;?></span></div>
                                                    <div>
                                                        <strong class="sign_title">Signature </strong>
                                                        <div class="sign_div">
                                                            <img src="<?php echo SHWFL.'/contract/'.$img_path;?>"  style="width:280px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>                    
                                    </table>
                                </div>
                                <div class="clearfix"></div>
                                <div class="text-center f12">
                                    <p style="margin: 0; width: 100%;">If you have any questions, please mail us at <a href="mailto:support@annexis.net" class="orng">support@annexis.net</a> or call us on <span class="orng">(800) 513-4450</span>.</p>
                                    <!--<p>Thanks again for using <a href="http://www.Annexis.net" class="blu">Annexis.net</a>.</p>
                                    <p>Please add our email address to your contacts to ensure that you receive all of our emails to your inbox.</p>-->
                                </div>

                               <div style="border-top:2px solid #c5c5c4; padding:16px 0; text-align:center;">
                                    <img src="<?php echo $STYLE_FILES_SRC;?>/assets/images/logo.png" width="134" alt="logo">
                               </div>
                               <div style="border-bottom:1px solid #c5c5c4; padding-bottom:10px; text-align:center; color:#3b3b3b;">110 SE 6th Street Suite 1700 Ft. Lauderdale, Florida 33301</div>
                                <div style="text-align:center; padding:9px 0; border-bottom:1px solid #c5c5c4;">
                                    <span style="border-right:1px solid #a4a4a4; padding:0 7px 0 0; color:#3b3b3b; margin-right:5px;">W: <a href="http://www.annexis.net" style="text-decoration:none; color:#1baceb;">www.annexis.net</a></span>
                                    <span style="border-right:1px solid #a4a4a4; padding:0 7px 0 0; color:#3b3b3b; margin-right:5px;">E: <a href="mailto:info@annexis.net" style="text-decoration:none; color:#1baceb;">info@annexis.net</a></span>
                                    <span style="color:#3b3b3b;">T: <span style="color:#1baceb;">1 800.816.9554/+91-9818-11-9692</span></span>
                                </div>
                          </td>
                        </tr>
                    </table>
                        </td>
                    </tr>
                    </table>
                </div>
            </div>
        </body>
        <?php
    }
}
?>