<?php 
$mObj     = new MemberView();
//$item     = $mObj->getavoffice();
$packsd   = $mObj->packageList(1, 0, 4);
?>
<div class="container_outer">
<div class="container bootstrapCommon">
      <div class="col-sm-12 col-md-12 bkngrt content-right">
        <?php 
        if($dtaction!='contractsign')
        {
            $prvi       ='';
            $standard   ='style="display:none"';                
            if($dtaction)
            {
                $prvi       ='';
                $standard   ='style="display:none"';
                if($dtaction=='standard')
                {
                    $prvi='style="display:none"';
                    $standard='style="display:block"';
                }
            }
            else
            {
                $sel1='checked';
            }
            ?>
            <form id="createaccForm"> 
                    <div class="h-heading">
                                            Choose Your Membership
                                        </div>

                    <?php foreach($packsd as $key=>$memPck) {

                        if($dtaction==$memPck['permalink'])
                            $selCk = 'checked';
                        else
                            $selCk = '';
                
                        if($_GET['src']){
                            if($key==1)
                                $selCk1 = 'checked';
                            else
                                $selCk1 = '';
                        }
                      
                        echo '<div class=" col-sm-3 col-md-3 thumbnail">';
                            echo '<div class="plan_detail">';
                            echo '<img src="'.$STYLE_FILES_SRC.'/images/badge-'.$memPck['permalink'].'.png" class="img-responsive p12 pb0">';
                            echo '<div class="caption">';
                            echo '<p style="height:145px;"> - <b>'.SITE_CURRENCY_SYMBOL.number_format($memPck['price'],2).'per/m</b><br>';
                            echo ($memPck['smallnote'])? '-'.$memPck['smallnote'].'<br>':'';
                            echo '- Promote Your Business in US<br>
                                            - Showcase Your Products / Services<br>';
                            echo '<a  class="badge h-orange" data-toggle="modal" data-target="#'.$memPck['permalink'].'Modal">Read More</a></p>';
                            echo '<div class="radio plan_strip strip_'.$selCk.'">';
                            echo ' <label>
                                        <input type="radio" name="blankRadio" id="blankRadio2" '.$selCk.' '.$selCk1.' value="'.$memPck['permalink'].'"  class="other mbrshp" data-membership="'.$memPck['permalink'].'"> Select <strong>'.$memPck['name'].'</strong> Membership
                                </label>';
                         echo '</div>';   
                            echo '</div></div>';
                        echo '</div>';
                    } 
                    ?>

                </div>
                <div class="col-sm-12 col-md-12 bkngrt content-right">
                    <div class="create-account">
                        <!-- column right -->

                        <!-- Personal data -->
                        <div class="h-box-100 minheight text-center loader" style="display:none">
                            <span>Please wait</span> 
                        </div>

                        <div class="first_screen">

                            <!--- Plan detail start here-->

                                                     <?php if($dtaction=='standard') {?>
                            <div class="h-box-100">
                                <div class="h-heading">
                                    Select your plan
                                </div>
                                <div class="ph15">
                                    <div class="row standard_plan" <?php echo $standard;?>>
                                        <!-- silver -->
                                        <div class="col-sm-12 col-md-12"> 
                                            <input type="radio" name="busdir" checked value="0" disabled> <span class="text-warning">Business directory</span>       
                                        </div>
                                        <!-- end silver -->     
                                        <!-- silver -->
                                        <div class="col-sm-6 col-md-4">
                                            <div class="thumbnail">
                                                <span class="text-warning plan_strip">User Plan</span>
                                                <h1>30</h1>
                                                <h3>days</h3>
                                                <div class="text-center">FREE TRIAL<br>
                                                $99/Yr after Trial Period</div>
                                                <div class="radio">
                                                    <label>
                                                    <input type="radio" name="blankRadioA" id="blankRadio1A" checked value="3" aria-label="..."> Select plan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end silver -->
                                        <!-- gold -->
                                        <div class="col-sm-6 col-md-4">
                                            <div class="thumbnail">
                                                <span class="text-warning plan_strip">User Plan</span>
                                                <h1>12</h1>
                                                <h3>month</h3>
                                                <div class="text-center">
                                                $79/Yr Buy Now</div>              
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="blankRadioA" id="blankRadio2A" value="15" aria-label="..."> Select plan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- end gold -->
                                    </div>
                                </div>
                            </div>
                            <?php } else {?>

                            <div class="h-box-100">
                                <div class="h-heading">
                                    Select your plan
                                </div>
                                <div class="ph15">
                                    <div class="row other_plan"  <?php echo $prvi;?>>
                                        <!-- silver -->
                                        <div class="col-sm-12 col-md-12"> 
                                            <input type="radio" name="busdir" checked value="0" aria-label="..." disabled> <span class="text-warning">Business directory</span>       
                                        </div>
                                        <!-- end silver -->     
                                        <!-- silver -->
                                        <div class="col-sm-6 col-md-4">
                                            <div class="thumbnail">
                                                <span class="text-warning plan_strip">User Plan</span>
                                                <h1>3</h1>
                                                <h3>month</h3>

                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="blankRadioA" id="blankRadio3A" value="3" aria-label="..."> Select plan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- end silver -->
                                        <!-- gold -->
                                        <div class="col-sm-6 col-md-4">
                                            <div class="thumbnail">
                                                <span class="text-warning plan_strip">User Plan</span>
                                                <h1>6</h1>
                                                <h3>month</h3>

                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="blankRadioA" id="blankRadio4A" value="6" aria-label="..."> Select plan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- end gold -->
                                        <!-- platinium -->
                                        <div class="col-sm-6 col-md-4">
                                            <div class="thumbnail">
                                                <span class="text-warning plan_strip">User Plan</span>
                                                <h1>12</h1>
                                                <h3>month</h3>

                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="blankRadioA" id="blankRadio5A" value="12" aria-label="..."> Select plan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end platinium -->
                                    </div>
                                </div>
                            </div>
                            <?php }?>





                            <!--- Plan detail end here-->




                            <?php if($dtaction!='standard') {?>
                            <div class="h-box-100">
                                <div class="prvi" <?php echo $prvi;?>>
                                    <?php 
                                    if($_GET['src'])
                                        $item=$mObj->getOfficeBypermalink($_GET['src']);
                                    else
                                        $item=$mObj->getavoffice();                                                           
                                                             
                                    /*if($_GET['src'])
                                    {
                                        ?>
                                            <div class="page-header">
                                                <h1>Selected office location</h1>
                                                <?php echo $mObj->readofficefromsite($_GET['src']);?>
                                            </div>
                                        <?php
                                    }
                                    else
                                    {*/
                                        ?>   
                                        <!-- column left -->
                                <div class="h-heading">
                                            Available virtual office location
                                        </div>

                                        <div class="ph15">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>State</label>
                                                    <select id="state_office" name="state_office" class="form-control" data-selofc="<?php echo  $item['office_city'];?>">
                                                    <?php echo $mObj->readstate($item['state_code']);?>
                                                    </select>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Virtual office city</label>
                                                    <select id="city_office" name="city_office" class="form-control">
                                                        <?php echo $mObj->readoffice($item['state_code']);?>
                                                    </select>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Virtual office</label>
                                                    <select id="office_name" name="office_name" class="form-control">
                                                        <?php echo $mObj->readofficename($item['office_city']);?>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="thumbnailimg">
                                                        <div id="office_thumb" class="thumbnail">
                                                            <?php if($item['showimg']==0) echo $mObj->readofficeimg(1);?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <?php /* $coor=$mObj->geocode($item['office_address']);
                                                    <input name="coord" id="coord" type="hidden" value="<?php echo $coor['latoff'].','.$coor['longoff'];?>">*/?>
                                                    <div id="map" style="width:100%; height:260px; margin-top:20px;">
                                                        <idv id="loctn">
                                                        <iframe  scrolling="no"  src="https://maps.google.it/maps?q=<?php echo $item['office_address'];?>&output=embed"  width="100%" height="450" frameborder="0" style="border:0"></iframe>   
                                                        </idv>

                                                    </div>
                                                </div>
                                                <!-- col-md-3 --> 
                                            </div><!-- end row -->
                                        </div><!-- end row -->
                                        <?php
                                    //}
                                    ?>
                                </div><!-- end row -->
                            </div>
                            <?php }?>
                            <div class="h-box-100">
                                <div class="h-heading">
                                    Company profile
                                </div>
                                <div class="ph15">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group name">
                                                <label>Name</label>
                                                <input type="text" autocomplete="off" name="name" id="name" class="form-control" placeholder="Name" required>
                                            </div>

                                            <div class="form-group surname">
                                                <label>Surname</label>
                                                <input type="text" autocomplete="off" name="surname" id="surname" class="form-control" placeholder="Surname" required>
                                            </div>

                                            <div class="form-group username">
                                                <label>Username <span class="username_check text-danger"></span></label>
                                                <input type="text" name="username" autocomplete="off" id="username" class="form-control" placeholder="Username" required>
                                            </div>
                                            <div class="form-group phone_ch">
                                                <label>Phone <span class="phone_check text-danger"></span></label>
                                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" required>
                                            </div> 
                                            <div class="form-group email">
                                                <label>e-mail <span class="email_check text-danger"></span></label>
                                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                                            </div>  

                                            <div class="form-group password">
                                                <label>Password<span class="padssword_check text-danger"></span></label>
                                                <input type="password" autocomplete="off" name="password" id="password" class="form-control" placeholder="Password" required>
                                            </div>
                                        </div><!-- end col-md-6 -->

                                        <div class="col-md-6">
                                            <div class="form-group address">
                                                <label>Address <span class=""></span></label>
                                                <input type="text" name="address" autocomplete="off" id="address" class="form-control" placeholder="Address" required>
                                            </div>
                                            <div class="form-group country">
                                                <label>State of origin</label>
                                                <select name="country" id="country" class="form-control">
                                                 
                                                 <option value="IN">
                                                     India
                                                 </option>
                                                 <?php // echo $mObj->readcountry();?>

                                                </select>
                                            </div>
                                            <div class="form-group state">
                                                <label>State <span class=""></span></label>
                                                <input type="text" name="state" autocomplete="off" id="state" class="form-control" placeholder="State" required>
                                            </div>
                                            <div class="form-group city">
                                                <label>City</label>
                                                <input type="text" name="city" autocomplete="off" id="city" class="form-control" placeholder="City" required>
                                            </div>
                                            <div class="form-group zip">
                                                <label>Pin Code</label>
                                                <input type="text" name="zip" autocomplete="off" id="zip" class="form-control" placeholder="Pin Code" required>
                                            </div>       
                                            <div class="form-group company">
                                                <label>Company name <span class="company_check text-danger"></span></label>
                                                <input type="text" name="company" id="company" class="form-control" placeholder="Company" required>
                                            </div>          
                                        </div><!-- end col-md-6 --> 
                                    </div>
                                </div>
                                <!-- End User type -->    
                            </div>

                            <!----Popup------>
                            <?php 
                            foreach($packsd as $memPckmD) {
                                echo '<div class="modal fade" id="'.$memPckmD["permalink"].'Modal" role="dialog" data-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">';

                                        if(file_exists($ROOT_PATH.'/uploadedfiles/package/large/'.$memPckmD['image']) && $memPckmD['image'])
                                            echo '<h2><img src="'.$MEDIA_FILES_SRC.'/package/large/'.$memPckmD['image'].'" alt="'.$memPckmD['name'].'">'.$memPckmD['name'].' Membership-'.SITE_CURRENCY_SYMBOL.number_format($memPckmD['price'],2).'/mo</h2>';

                                         echo ($memPckmD['smallnote'])? '<div class="silder_top"><h4>'.$memPckmD['smallnote'].'</h4></div>':'';

                                        if($memPckmD['description'])
                                            echo $memPckmD['description'];

                                echo '<div class="clr"></div>
                                        <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> ';
                            }
                            ?>
                            <!--------End Popup-------->

    
                            <div class="h-box-100 minheight">
                                <div class="ph15" style="margin-bottom: 0px !important;">
                                    <div class="pull-left">
                                        <a type="button" href=""  onclick="history.back(-1);" class="btn btn-default btn-lg">Back</a>
                                    </div>
                                    <div class="pull-right">
                                        <input type="hidden" name="SourceForm" value="adduser">
                                        <input type="hidden" name="ajax" value="1">
                                        <button type="submit" class="btn btn-primary btn-lg create">Send</button>
                                        <a type="button" href="<?php echo $SITE_LOC_PATH.'/';?>" class="btn btn-default btn-lg">Cancel</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div> <!--end first screen-->
                        <div class="second_screen" style="display:none"></div>
                    </div>
                </div>
            </form>
            <?php
        }
        else{
            $val          = $_GET['validation'];
            $validation   = $mObj->getContractInfo($val);
            if($validation)
            {
                $userData   = $mObj->getMemberById($validation['id_user']);
                $name       = $userData['name'].' '.$userData['surname'];
                
                    $payD   = $mObj->getTempcontract($val);
                    $plan   = $payD['plan'];
                    $mjesec = $payD['mjesec'];

                    $mmData = $mObj->getPackageBypermalink($plan);
                    $fn     = 150;
                    $mc     = $mmData['price'];
                    //$mc     = $_SESSION['pkgArr'][$plan]['price'];
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

                        $benefit    = '<ul class="bullet">
                                            <li>Directory listing with 20 product products or services on Annexis Directory website.</li>
                                            <li>Promote on popular search engines such as Bing, Google, Yahoo etc.</li>
                                            <li>Featured in Annexis Business Directory Newsletter.</li>
                                            <li>Pay-per-click campaigns for promotional based on industry and key word.</li>
                                            <li>Become eligible to be featured on the Annexis Business Directory Magazine.</li>
                                        </ul>';
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

                        $benefit    = '<ul class="bullet">
                                            <li>10  Hours of Live Receptionist.</li>
                                            <li>5  Hours of Office Use – 300 Choice Option throughout the United State (Advance  Booking Required).</li>
                                            <li>Personal Sales Representative Assign - SET UP.</li>
                                            <li>Option  for Add-On Services – The is an option these services are add on and subject to  additional charges base on customer&rsquo;s need.   A separate agreement will be supplied when Add-On service is purchased.</li>
                                        </ul>';
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

                        $benefit    = '<ul class="bullet">
                                            <li>10  Hours of Live Receptionist.</li>
                                            <li>5  Hours of Office Use – 300 Choice Option throughout the United State (Advance  Booking Required).</li>
                                            <li>Personal  Sales Representative Assign - SET UP.</li>
                                            <li>Option  for Add-On Services – The is an option these services are add on and subject to  additional charges base on customer&rsquo;s need.   A separate agreement will be supplied when Add-On service is purchased.</li>
                                        </ul>';
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
                        $benefit = '<ul class="bullet">
                                        <li>30  Hours of Free Live Receptionist / Month.</li>
                                        <li>10  Hours of Office Use / Month - 300 Choice Option throughout the United State  (Advance Booking Required).</li>
                                        <li>Personal  Sale Representative – Set Up.</li>
                                        <li>Free  Consultation and Analysis on ANNEXIS Business Solutions.</li>
                                        <li>Business  Review – Include Marketing &amp; Branding Analysis, Tax and Legal service  options &ldquo;Creating Brand Identity - Brand Positioning -Rebranding Solutions&rdquo;.</li>
                                        <li>Free  Listing of Target Companies for first 8000 companies using ANNEXIS Business  Database.</li>
                                    </ul>';
                    }
                    $totalall=$total+$fn;
                    ?>
                    <div class="col-md-12">
                        <div class="h-box-100 contract_details">
                                <div class="h-heading">Sign Your Contract</div>
                                <div class="row">
                                    <div class="col-sm-6 pb40">
                                        <div class="border_btm comheight">
                                            <div class="con_name">Dear <?php echo $name;?>,</div>
                                            <p>Congratulations on your selection for the <strong><?php echo strtoupper($plan);?></strong> package.</p>
                                            <div class="package_block">
                                                <div class="package_img">
                                                    <?php                
                
                                                    if(file_exists($ROOT_PATH.'/uploadedfiles/package/large/'.$mmData['image']) && $mmData['image'])
                                                        echo '<img src="'.$MEDIA_FILES_SRC.'/package/large/'.$mmData['image'].'" alt="'.$mmData['name'].'">';
                                                    ?>
                                                    
                                                    <span><?php echo strtoupper($plan);?> Membership Package</span> <?php echo $mjesec;?> Month
                                                </div>
                                                <div class="package_text">
                                                    <div class="con_subheading">Package Benefits</div>
                                                    <?php echo $benefit;?>

                                                    <!--<div class="text-right mt15">
                                                        <a href="#" class="btn btn_more">Read More</a>
                                                    </div>-->
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <p>We look forward to serving you and providing all your business needs.</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 pb40">
                                        <div class="border_btm comheight">
                                            <div class="con_heading">Savings</div>
                                            <div class="con_name">30% Savings on Add-On Services:</div>
                                            <p>Option for Add-On Services – The is an option these services are add on and subject to additional charges base on customer’s need. A separate agreement will be supplied when Add-On service is purchased.</p>
                                            <p>Marketing Services (Email Marketing, Direct Mail Marketing, Marketing Material Design, Website Design & Development, Mobile Application Design & Development, Social Media Marketing and Advertising, Packaging and Print Design).</p>
                                            <p>Consulting Services (Business Registration, Legal Consulting Service, Tax Consulting Service, Fundraising Services).</p>
                                            <p>Sales Representative (Dedicated Sales Representative to respond to inquiry over phone, email and in person – hourly charges, travel expenses will apply when dedicated sales representative is working on your behalf) page.</p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6 pt40">
                                        <div class="comheight">
                                            <div class="con_heading">Annexis Agreement for Services</div>
                                            <div class="con_terms">
                                                <div class="border_btm">
                                                    <div class="con_subheading">Terms of Payment</div>
                                                    <p>All statements by ANNEXIS to the Customer shall be paid within 30 days of the date of the statement. If the Customer disputes any portion of the statement, the Customer must bring the dispute to the attention of ANNEXIS in writing within 15 days of the date of the statement. The failure of the Customer to send a written notice of dispute within this time period shall be deemed a waiver by the Customer of the right to dispute any portion of the statement. If the dispute relates to a portion of the statement, the Customer shall be required to make payment of the undisputed balance within the time period set forth above.</p>
                                                    <p>If the Customer fails to make payment of the invoice within the time period set forth above, ANNEXIS shall have the right to suspend or terminate all Services, upon twenty-four (24) hour written or verbal notice.</p>
                                                    <p>Services which are suspended or terminated for nonpayment may be subject to a reconnection charge of $100 and an additional deposit equaling the average invoice amount for the three (3) months prior to suspension and/or termination. The Customer shall be responsible for payment of all Services up to the time of suspension or termination and for payment of a late charge of $15.00 per month on any unpaid overdue balances.</p>
                                                </div>
                                                <div class="border_btm">
                                                    <div class="con_subheading">Illegal Use</div>
                                                    <p>The Customer represents and warrants that the Services will not be used for any illegal purpose. If ANNEXIS becomes aware that the Services are being used for any illegal purpose, ANNEXIS shall have the right to suspend or terminate all Services IMMEDIATELY, without any prior written or oral notice to the Customer. The Customer shall be responsible for payment of all Services up to the time of suspension or termination and ANNEXIS shall have the right to apply the deposit to any unpaid balances.</p>
                                                </div>
                                                <div class="border_btm">
                                                    <div class="con_subheading">Confidentiality</div>
                                                    <p>ANNEXIS shall treat all messages as confidential and shall not intentionally disclose messages to any unauthorized person or organization. However, ANNEXIS shall not be responsible for any inadvertent disclosure and shall have the right to cooperate with all law enforcement agencies or organizations and may disclose to them whatever information is requested pursuant to the performance of their official duties, without prior notice to the Customer of such requests.</p>
                                                </div>
                                                <div class="border_btm">
                                                    <div class="con_subheading">Limitation of Liability</div>
                                                    <p>ANNEXIS shall not be liable for any acts, errors or omissions by it or its employees or agents, except for conduct which is adjudicated to be grossly negligent or intentional. ANNEXIS entire liability to the Customer as to damages for, based upon, or in connection with, either directly or indirectly, Services provided or which should have been provided by ANNEXIS to or on behalf of the Customer shall not exceed the fees and costs payable by the customer to and enforced in accordance with and governed by the laws of the State of Florida.</p>
                                                </div>
                                                <div class="border_btm">
                                                    <div class="con_subheading">Entire Agreement</div>
                                                    <p>This Agreement represents the entire agreement of the parties to This Agreement and supersedes all negotiations, representations, prior discussions or preliminary agreements between the parties. No statements, warranties, or representations of any kind that are not contained in this Agreement shall in any way bind the parties. This Agreement can only be changed or modified by a writing signed by all of the parties to this Agree. ANNEXIS for the payment period in which the conduct giving rise to the claim took place. Notwithstanding the above, in no event shall ANNEXIS or its employees or agents be liable to the Customer for (a) any incidental or consequential damages, including, but not limited to, any lost profits or revenues arising either directly or indirectly from the performance, or failure to perform, any Services; (b) any punitive, exemplary, or multiplied damages; (c) any damages for, based upon, or arising out of any natural disasters, weather conditions, civil disturbances, material shortages, electronic or mechanical failures, or problems with or the interruption of telephone service.</p>
                                                </div>
                                                <div class="border_btm">
                                                    <div class="con_subheading">Indemnification</div>
                                                    <p>The Customer agrees to defend, indemnify and hold ANNEXIS and its employees and agents harmless as against any and all liabilities, losses, damages, injuries, claims, suits, judgments, settlements, awards, costs, charges and expenses, including but not limited to any fees, costs, charges and expenses incurred by ANNEXIS for investigation, defense, and resolution, for, based upon, or arising out of the performance or failure to perform any Services under or pursuant to the Agreement.</p>
                                                </div>
                                                <div class="border_btm">
                                                    <div class="con_subheading">Ownership & Property Rights</div>
                                                    <p>All technologies, software, hardware, operating applications, procedures, scripts, telephone numbers, or other materials of any nature or type prepared, furnished, or utilized by ANNEXIS, shall be considered the sole and exclusive property of ANNEXIS and shall be retained by ANNEXIS upon the termination of this Agreement.</p>
                                                </div>
                                                <div class="border_btm">
                                                    <div class="con_subheading">Reports & Statistical Information</div>
                                                    <p>ANNEXI Smay be requested by the Customer from time to time to furnish reports or statistical information to the Customer regarding aspects of the Services being performed. The cost to prepare and furnish such reports and statistical information is not included within the amount specified above as charges for the Services. Therefore, ANNEXIS will advise the Customer of the cost to be charged for the reports and statistical information and obtain the consent of the Customer before preparing and providing same to the Customer. ANNEXIS does not make any guarantees, warranties, or representations as to the accuracy of the reports and statistical information provided.</p>
                                                </div>
                                                <div class="border_btm">
                                                    <div class="con_subheading">Assignment</div>
                                                    <p>This Agreement is binding on the parties hereto and their respective successors and assigns. Neither the Customer nor ANNEXIS shall assign its rights, duties, or obligations under this Agreement without the written consent of the other party.</p>
                                                </div>
                                                <div class="border_btm">
                                                    <div class="con_subheading">Severability</div>
                                                    <p>No term or provision of this Agreement that is determined by a court of Competent Jurisdiction to be invalid or unenforceable shall affect the validity or enforceability of the remaining terms and provisions of this Agreement. Any term found to be invalid or unenforceable shall be deemed as severable from the remainder of the Agreement.</p>
                                                </div>
                                                <div class="border_btm">
                                                    <div class="con_subheading">Independent Contractor</div>
                                                    <p>Nothing contained in this Agreement shall be construed or interpreted by the parties hereto, or by any third party, as creating a relationship of principal and agent, partnership, joint venture, or any other relationship between ANNEXIS and the Customer, other than that of independent contractors contracting for the provision and acceptance of Services. Each party will be responsible for hiring, supervising and compensating its own employees and for providing benefits toand withholding taxes for such employees.</p>
                                                </div>
                                                <div class="border_btm">
                                                    <div class="con_subheading">Governing Law</div>
                                                    <p>This Agreement shall be deemed to have been executed in the State of Florida and shall be interpreted, construed</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                    <div class="col-sm-6 pt40">
                                        <div class="border_btm comheight">
                                            <div class="con_heading">Sign Your Contract</div>
                                            <p>Programming cannot be started until  fully executed agreement is returned.</p>
                                            <div class="mv30">
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
                                            <div class="sign_box">
                                               <p>In witness whereof, the parties have executed this Agreement  the Date the person signing contract <?php echo date('d');?> of <?php echo date('F');?> <?php echo date('Y');?>.</p>

                                                <div class="row">
                                                    <div class="col-sm-5 sign_left">
                                                        <div class="clearfix"><strong class="mr_5">ANNEXIS Business Solution Services LLC.</strong></div>
                                                        <div class="clearfix"><strong class="sign_title">Name</strong> <span class="sign_val">Jacques Dieuvil</span></div>
                                                        <div class="clearfix"><strong class="sign_title">Title</strong> <span class="sign_val">Business Executive Manager</span></div>
                                                    </div>
                                                    <div class="col-sm-7">
                                                        <div class="clearfix"><strong class="sign_title">Name</strong> <span class="sign_val"><?php echo $name;?></span></div>
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
                                            </div>
                                            <div class="text-center mt30 f12">
                                                <p>If you have any questions, please mail us at <a href="mailto:support@annexis.net" class="orng">support@annexis.net</a> or call us on <span class="orng">(800) 513-4450</span>.</p>
                                                    <p>Thanks again for using <a href="http://www.Annexis.net" class="blu">Annexis.net</a>.</p>
                                                    <p>Please add our email address to your contacts to ensure that you receive all of our emails to your inbox.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                  
                    <?php
                
            }
                                    
            echo '<div class="welcome contReg"><h2> <strong>Your contract was already signed.<br> Please log into the system or call customer service at - '.SITE_PHONE.'</strong> </h2></div>';
            
        }
        ?>        
    </div><!-- end row -->
</div><!-- end container -->
</div>
