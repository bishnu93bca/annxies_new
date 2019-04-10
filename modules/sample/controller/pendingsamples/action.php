<?php
/*************************************************************************************************
Add / Edit Content Section Started
*************************************************************************************************/
if(isset($Save) && $SourceForm == 'Sample')
{
    $obj    = new MemberAdmin;
    $cnObj  = new Contact;
    if($isApproved)
    {     
        $ExtraQryStr = "sampleId = ".$sampleId." AND userId = ".addslashes($sellerId)." AND proId=".addslashes($productId);   
        $sampleData = $obj->sampleDetail($ExtraQryStr);        
        if($sampleData)
        {     
            $seller     = $obj->getMemberInfoByid($sellerId);
            $sellerMail = $seller['email'];
            $sellerName = $seller['name'].' '.$seller['surname'];
            
            if($isApproved=='Send Sample Contract' && $shippingCharge && $spcurrency && $setUp && $shippingCharge1)
            {     
                $total = $setUp+$shippingCharge+$shippingCharge1;                

                $params = array();  
                $params['isApproved']       = $isApproved;  
                $params['setUp']            = $setUp;  
                $params['shippingCharge']   = $shippingCharge;  
                $params['shippingCharge1']  = $shippingCharge1;  
                $params['scurrency']        = $spcurrency;  
                $obj->sampleUpdateBysampleId($params, $sampleId);

                $tmp_ses                =    uniqid();
                $params                 = array();
                $params['id_user']      = $sampleId;
                $params['tmp_ses']      = $tmp_ses;
                $params['contractFor']  = 'S';
                $obj->newsampleContract($params);

                $contractlnk   =    SITELOC.'/login/samplecontractsign?validation='.$tmp_ses;  

                $to         = $sellerMail;
                //$to         = 'site-control@eclickapps.com';
                $from       = "From: ".SITE_NAME."<".SITE_EMAIL.">";
                $subject    = 'Pay and sign contract';	
                
                $msg        = '<div style="padding-bottom:10px;">Dear '.$sellerName.',</div>
                            <div style="padding-bottom:17px;">Congratulation your application for samples and distribution have been approved. Based on your product dimensions and weight we have allocated space in the
                            warehouse.</div>
                            Charges will be:<br><br>
                            
                            Set up fee '.$setUp.' '.$spcurrency.'<br>
                            Shipping deposit '.$shippingCharge.' '.$spcurrency.'<br>
                            Shipping deposit '.$shippingCharge1.' '.$spcurrency.'<br>
                            Future shipping fees are deducted from shipping<br>
                            Total: '.$total.' '.$spcurrency.'<br>
                            We are looking forward to serving you and providing all your business needs. Your
                            account activation and set up is in progress and will be completed upon verification
                            of your payment.<br>
                            To complete the registration, please sign the contract.<br>
                            <div style="padding:0 0 22px; text-align: center;">
                                <a href="'.$contractlnk.'" style="display: inline-block; height: 40px; line-height: 40px; padding: 0 30px; background: #1BACEB; color: #fff; font-weight: bold; -webkit-border-radius: 20px; border-radius: 20px; text-decoration: none;">Sign Contract</a>
                            </div>
                            <p style="margin:0; padding-bottom:17px;">Thanks,</p>
	                        <p style="margin:0; padding-bottom:0;">Annexis Team</p>
                            ';
               
                sendEmail($to, $from, $subject, $msg);

                $ErrMsg = '<div class="success">Sample contract send Successfully</div>';

            } 
            else
                $ErrMsg = '<div class="error">* Marked Fields Are Mandatory</div>';
            
            if($isApproved=='Send Payment Url' || $isApproved=='Shipping Cost Paid')
            {       
                $params = array();  
                $params['isApproved']       = $isApproved; 
                $obj->sampleUpdateBysampleId($params, $sampleId);  
                
                if($isApproved=='Shipping Cost Paid'){                    
                    
                    $attributeIdArray= $_REQUEST['attributeIdArray']; 
                    $attributes = '';

                    if(sizeof($attributeIdArray)>0)
                    {   
                        $prObj = new adminCategory();
                        for($i=0;$i<sizeof($attributeIdArray);$i++)
                        {
                            $attributeValueArray = $_REQUEST['attributeValueArray_'.$i];

                            $attrName=$prObj->getAttributeById($attributeIdArray[$i]);
                            for($j=0;$j<sizeof($attributeValueArray);$j++)
                            {
                                $attributes .= $attrName['attributeName'].': '.$attributeValueArray[$j].'<br>';

                            }
                        }
                    }
                    
                    $to         = $sellerMail;
                    //$to         = 'site-control@eclickapps.com';
                    $from       = "From: ".SITE_NAME."<".SITE_EMAIL.">";
                    $subject    = 'Sample send';	
                    $msg        = '<div style="padding-bottom:10px;">Dear '.$sellerName.',</div>
                                Thank you for your payment.<br><br>
                                Your account shipping balance is '.$shippingCharge.' '.$spcurrency.', your account have been activated and funded.<br>
                                Below is the list of samples you will need to ship to Annexis samples and
                                distribution.<br><br>
                                Product : '.$productName.'<br>';
                    
                    $msg        .= $attributes;
                    
                    
                    $msg        .= 'Quantity : '.$qty.' '.$unitType.'<br>
                                Price: '.$range1.'~'.$range2.' '.$currency.'<br /><br />
                                
                                Please ship all samples below with tracking to: Annexis Samples and
                                Distribution <br /><br />
                                <p style="margin:0; padding-bottom:17px;">Thanks,</p>
                                <p style="margin:0; padding-bottom:0;">Annexis Team</p>
                                ';//(Show Address)
                    
                    sendEmail($to, $from, $subject, $msg);
                    
                }
                
                
                
                $ErrMsg = '<div class="success">Data Updated Successfully</div>';        
            }
            
            if($isApproved=='Sample Received')
            {
                $params = array();
                $params['totalQty']     = $qty;  
                $params['isApproved']   = $isApproved;  
                $obj->sampleUpdateBysampleId($params, $sampleId);

                $sampQty = array();
                $sampQty['sampleId']    = $sampleId;
                $sampQty['userId']      = $sellerId;
                $sampQty['ct']          = $qty;
                $sampQty['inStock']     = $qty;
                $sampQty['entryDate']   = date("Y-m-d H:i:s");

                $obj->newSampleQty($sampQty);


                $smsg_details    = $cnObj -> getEmailBodyById(60);

                $sto         = 'site-control@eclickapps.com';
                //$sto         = $sellerMail;
                $sfrom       = "From: ".SITE_NAME."<".SITE_NOREPLY.">";
                $ssubject    = $smsg_details['emailSubject'];            
                $smsg        = $smsg_details['emailBody'];

                $sother  = 'Admin has approved your sample having request # - '.$sampleReqId;

                $sarr = array(
                        "{other}" 	            => $sother,
                );
                $smsg    = strtr($smsg,$sarr);

                sendEmail($sto, $sfrom, $ssubject, $smsg);


                $ErrMsg = '<div class="success">Data Updated Successfully</div>';
            }
                     
        }
        else
            $ErrMsg = '<div class="error">Something went wrong!</div>';
    }
    else
        $ErrMsg = '<div class="error">* Marked Fields Are Mandatory</div>';
}
/*************************************************************************************************
Add / Edit Content Section Ended
*************************************************************************************************/

?>
