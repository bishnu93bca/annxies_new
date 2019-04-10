<?php 
if($dtaction=='compare-packages')
{
    $mbmObj   = new MemberView();
    $mbm      = $mbmObj->packageList(1, 0, 4);
    ?>
    <div class="container">
        <table class="r-table">      
            <tr>
                <th class="compareTitle">Membership Levels<br>
            </th>
            <?php 
            foreach($mbm as $mplans){ 
                echo '<th class="r-platinum-plus centre">';
                if(file_exists($ROOT_PATH.'/uploadedfiles/package/large/'.$mplans['image']) && $mplans['image']){
                    
                    echo '<div class="member-image"><a href="'.$SITE_LOC_PATH.'/'.$pageType.'/'.$mplans['permalink'].'/"><img src="'.$MEDIA_FILES_SRC.'/package/large/'.$mplans['image'].'" alt="'.$mplans['name'].'"></a></div>';
                }
                    if($mplans['name']=='Standard')
                        $cls="standard-card-text";
                    elseif($mplans['name']=='Silver')
                        $cls="silver-card-text";
                    elseif($mplans['name']=='Gold')
                        $cls="gold-card-text";
                    elseif($mplans['name']=='Platinum')
                        $cls="platinum-card-text";

                    echo '<div class="'.$cls.' pcName">'.$mplans['name'].'</div>';   
                    echo '<div class="card-price pcPrice">'.SITE_CURRENCY_SYMBOL.number_format($mplans['price'],2).'/mo</div>';
                    echo '<a href="'.$SITE_LOC_PATH.'/'.$pageType.'/'.$mplans['permalink'].'/" class="vwbtn" title="View Details">View Details</a>';
                
                    echo ($mplans['smallnote'])? '<div class="smallnote pcNote">'.$mplans['smallnote'].'</div>':'';
                echo '</th>';               
                ?>
                
            <?php }?>
            </tr>
            <tr>
              <td>
                <!--th scope="row">Open plan offices usage</th-->
                <div class="accordion-com" id="accordion2">
                  <div class="accordion-group">
                    <div class="accordion-heading-com-com">
                      <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapsebd">
                        Business Directory

                      </a>
                    </div>
                    <div style="height: 0px;" id="collapsebd" class="accordion-body collapse">
                      <div class="accordion-inner">
                        <ul class="item-list">
                          <li>Directory listing with 20 product products or services on Annexis Directory website</li>
                          <li>Promote on popular search engines such as Bing, Google, Yahoo etc… </li>
                          <li>Featured in Annexis Business Directory Newsletter. </li>
                          <li>Pay-per-click campaigns for promotional based on industry and key word. </li>
                          <li>Become eligible to be featured on the Annexis Business Directory Magazine.</li>
                        </ul>
                      </div>
                    </div>
                    </div>
                  </div>
              </td>
              <td class="r-standard centre">
                <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
              </td>
              <td class="r-Silver centre">
              <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
              <br>
              </td>
              <td class="r-platinum centre">
              <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
              </td>
              <td class="r-platinum-plus centre">
              <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
              </td>
            </tr>
            <tr>
              <td>
                <!--th scope="row">Open plan offices usage</th-->
                <div class="accordion-com" id="accordion2">
                  <div class="accordion-group">
                    <div class="accordion-heading-com-com">
                      <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseZero">
                        Virtual Address

                      </a>
                    </div>
                    <div style="height: 0px;" id="collapseZero" class="accordion-body collapse">
                      <div class="accordion-inner">
                        <ul class="item-list">
                          <li> 	Professional Business US Address</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>  
              </td>
              <td class="r-standard centre">

              </td>
              <td class="r-Silver centre">
              <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
              <br>
              </td>
              <td class="r-platinum centre">
              <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
              </td>
              <td class="r-platinum-plus centre">
              <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
              </td>
            </tr>
            <tr>
            <td>
            <!--th scope="row">Open plan offices usage</th-->
            <div class="accordion" id="accordion2">
            <div class="accordion-group">
            <div class="accordion-heading-com"><a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne"> Mail Handling and Delivery</a> </div>
            <div style="height: 0px;" id="collapseOne" class="accordion-body collapse">
            <div class="accordion-inner">
            <ul class="item-list">
            <li> 	Scan all pages of your mail and email them to you same day received. </li>
            <li> 	Ship mails through a reputable international courier like FEDEX or DHL at a location of your choosing</li>
            </ul>
            </div>
            </div>
            </div>
            </div>
            </td>
            <td class="r-standard centre">

              </td>
            <td class="r-Silver centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            <br>
            </td>
            <td class="r-platinum centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            </td>
            <td class="r-platinum-plus centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            </td>
            </tr>
            <tr>
            <td>
            <!--th scope="row">Open plan offices usage</th-->
            <div class="accordion" id="accordion2">
            <div class="accordion-group">
            <div class="accordion-heading-com"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapsetwo"> Local US Tel. Number</a></div>
            <div style="height: 0px;" id="collapsetwo" class="accordion-body collapse">
            <div class="accordion-inner">
            <ul class="item-list">
            <li>Professional Recorded Voice Over with Menu Instructions 
            Email Notification</li>
            <li> Auto Attendant to professionally greet clients custom audio messages with menu options.  </li>
            <li> Daily report with call lot of incoming, outgoing and missed calls.  </li>
            <li>	Voice mail forwarded to your email. </li>
            </ul>
            </div>
            </div>
            </div>
            </div>
            </td>
            <td class="r-standard centre"></td>
            <td class="r-Silver centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            <br>
            </td>
            <td class="r-platinum centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            </td>
            <td class="r-platinum-plus centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            </td>
            </tr>
            <tr>
            <td>
            <div class="accordion-group">
            <div class="accordion-heading-com"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree"> Choice of Toll Free Number</a> </div>
            <div style="height: 0px;" id="collapseThree" class="accordion-body collapse">
            <div class="accordion-inner">
            <ul class="item-list">
            <ul>
            <li> Recommended if targeting more then local market. </li>
            <li> Give a National to International impression. </li>
            </ul>
            </div>
            </div>
            </div>
            </div>
            </td>
            <td class="r-standard centre">

              </td>
            <td class="r-Silver centre">
            <br>
            </td>
            <td class="r-platinum centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            <br>
            </td>
            <td class="r-platinum-plus centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            </td>
            </tr>
            <tr>
            <td>
            <div class="accordion-group">
            <div class="accordion-heading-com"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFive"> 5 Hours of Office Use / Month </a> </div>
            <div id="collapseFive" class="accordion-body collapse">
            <div class="accordion-inner">  
            <ul class="item-list">
            <li> Personal workspace when you are in town </li>
            <li> Meeting Rooms </li>
            <li> Conference Room </li>
            <li> Video Conference Rooms and Equipment </li>
            <li> High-speed and reliable internet </li>
            </ul>
            </div>
            </div>
            </div>
            </td>
            <td class="r-standard centre">

              </td>
            <td class="r-Silver  centre">
            </td>
            <td class="r-platinum centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            </td>
            <td class="r-platinum-plus centre">
            </td>
            </tr>
            <tr>
            <td>
            <div class="accordion-group">
            <div class="accordion-heading-com"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseNine"> 10 Hours of Office Use / Month</a> </div>
            <div id="collapseNine" class="accordion-body collapse">
            <div class="accordion-inner">  
            <ul class="item-list">
            <li> Personal workspace when you are in town </li>
            <li> Meeting Rooms </li>
            <li> Conference Room </li>
            <li> Video Conference Rooms and Equipment </li>
            <li> High-speed and reliable internet </li>
            </ul>
            </div>
            </div>
            </div>
            </td>
            <td class="r-standard centre">

              </td>
            <td class="r-Silver  centre">
            </td>
            <td class="r-platinum centre">
            </td>
            <td class="r-platinum-plus centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            </td>
            </tr>
            <tr>
            <td>
            <div class="accordion-group">
            <div class="accordion-heading-com"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapsefour">10 Hours of  Live Receptionist / Month</a> </div>
            <div style="height: 0px;" id="collapsefour" class="accordion-body collapse">
            <div class="accordion-inner">
            <ul class="item-list">
            <li> Receive and sign for parcels </li>
            <li> Make the needed arrangement to forward parcel</li>
            <li> Receive correspondences you wish to send to you client by email.</li>
            <li> Print, place in envelop, provide the proper posting and mail to your client on your behalf</li>
            <li> Speak to a potential clients and take messages </li>
            <li> Encourages callers to leave their details with a live person rather than leaving a voicemail message. </li>
            </ul>
            </div>
            </div>
            </div>
            </td>
            <td class="r-standard centre">

              </td>
            <td class="r-Silver centre">
            </td>
            <td class="r-platinum centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            </td>
            <td class="r-platinum-plus centre">
            </td>
            </tr>
            <tr>
            <td>
            <div class="accordion-group">
            <div class="accordion-heading-com"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseEight">30 Hours of Live Receptionist / Month</a> </div>
            <div id="collapseEight" class="accordion-body collapse">
            <div class="accordion-inner">
            <ul class="item-list">
            <li> 	Receive and sign for parcels
            <li> 	Make the needed arrangement to forward parcel
            <li>	Receive correspondences you wish to send to you client by email. </li> 
            <li>	Print, place in envelop, provide the proper posting and mail to your client on your behalf</li>
            <li> 	Speak to a potential clients and take messages</li>
            <li>	Encourages callers to leave their details with a live person rather than leaving a voicemail message.</li>  </ul>
            </div>
            </div>
            </div>
            </td>
            <td class="r-standard centre">

              </td>
            <td class="r-Silver centre">
            </td>
            <td class="r-platinum centre">
            </td>
            <td class="r-platinum-plus centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            </td>
            </tr>
            <tr>
            <td>
            <div class="accordion-group">
            <div class="accordion-heading-com"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTen">Consultation & Analysis on ANNEXIS Business Solutions</a> </div>
            <div id="collapseTen" class="accordion-body collapse">
            <div class="accordion-inner">
            <ul class="item-list">
            <li>Business Review include: 
            <li> Marketing & Branding Analysis</li>  <li> Tax and Legal service </li>  <li>Creating Brand Identity <li> Brand Positioning Rebranding Solutions</li> </ul>
            </div>
            </div>
            </div>
            </td>
            <td class="r-standard centre">

              </td>
            <td class="r-Silver centre">
            </td>
            <td class="r-platinum centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            </td>
            <td class="r-platinum-plus centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            </td>
            </tr>
            <tr>
            <td>
            <div class="accordion-group">
            <div class="accordion-heading-com"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseEleven">30% Savings on Add On Services </a> </div>
            <div id="collapseEleven" class="accordion-body collapse">
            <div class="accordion-inner">
            <ul class="item-list">
            <li> ANNEXIS Business Database 
            <li> 	Nationwide database of US Companies with company addresses, direct emails and contact number of decision maker in companies.</li>
            <li> 	Email Marketing </li>
            <li> 	Email campaign management</li>
            <li> 	Lead generation </li>
            <li> 	Email marketing consulting </li>
            <li> 	Trainings & workshops. </li>
            <li> 	Website Design & Development</li>
            <li> 	Web & Mobile Applications</li>
            <li> 	Search Engine Optimization (SEO) & Online Advertising</li>
            <li> 	Social Media Marketing</li>
            <li> 	Packaging and Print Design</li> </ul>
            </div>
            </div>
            </div>
            </td>
            <td class="r-standard centre">

              </td>
            <td class="r-Silver centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            </td>
            <td class="r-platinum centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            </td>
            <td class="r-platinum-plus centre">
            <img alt="Yes" src="<?php echo $STYLE_FILES_SRC;?>/assets/images/Blackarrow .png">
            </td>
            </tr>
            <?php if($_SESSION['FUSERLOGIN']!='ok'){ ?>
            <th scope="row">
            </th>
            
                <td class="r-standard centre">
                <span class="red_links">
                <a href="<?php echo $SITE_LOC_PATH.'/';?>register/standard/" class="buynowbtn" title="Book Now"><button class="btn btn-small btn-primary">Buy Now</button></a>
                </span>
                </td>
                <td class="r-Silver centre">
                <span class="red_links">
                <a href="<?php echo $SITE_LOC_PATH.'/';?>register/silver/" class="buynowbtn" title="Book Now"><button class="btn btn-small btn-primary">Buy Now</button></a>
                </span>
                </td>
                <td class="r-platinum centre">
                <span class="red_links">
                <a href="<?php echo $SITE_LOC_PATH.'/';?>register/gold/" class="buynowbtn" title="Book Now"><button class="btn btn-small btn-primary">Buy Now</button></a>
                </span>
                </td>
                <td class="r-platinum-plus centre">
                <span class="red_links">
                <a href="<?php echo $SITE_LOC_PATH.'/';?>register/platinum/" class="buynowbtn" title="Book Now"><button class="btn btn-small btn-primary">Buy Now</button></a>
                </span>
                </td>      
                <?php
           }
           ?>
        </table>
    </div>
    <?php
}
else
    include 'packages.php';
?>