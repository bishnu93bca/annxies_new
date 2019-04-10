<?php
/*************************************************************************************************
Add / Edit Content Section Started
*************************************************************************************************/
if(isset($Save) && $SourceForm == 'SendSample')
{
    $obj = new MemberAdmin;
    $cnObj = new Contact;
    
    if($qty !='' && $price !='' && $currency !='' && $sendStatus !='')
    {
        //if($sendStatus=='Approved' || $sendStatus=='Shipped')
        
        $expectedDate= date('Y-m-d',strtotime($expectedDate));
        
        $params = array();
        $params['qty']           = $qty;
        $params['unitType']      = $unitType;
        $params['price']         = $price;
        $params['currency']      = $currency;
        $params['sendStatus']    = $sendStatus;
        $params['expectedDate']  = $expectedDate;
        $cnObj->contactUpdateBycontactId($params, $IdToEdit);  
        
        if($sendStatus=='Approved')
        {   
            $seller     = $obj->getMemberInfoByid($sellerId);
            $sellerMail = $seller['email'];
            
            $ExtraQryStr = "sampleId = ".$sampleId." AND userId = ".addslashes($sellerId)." AND proId=".addslashes($productId);   
            
            $sampleData = $obj->sampleDetail($ExtraQryStr);        
            if($sampleData)
            {            
                $totalQty = $sampleData['totalQty']-$qty;
                $params = array();
                $params['totalQty'] = $totalQty;            
                $obj->sampleUpdateBysampleId($params, $sampleId);

                /*$params = array();
                $params['uId']              = $userId;
                $params['userId']           = $sellerId;
                $params['uname']            = $name;
                $params['uphone']           = $phone;
                $params['uemail']           = $email;
                $params['uadd']             = $address;
                $params['sampleId']         = $sampleId;
                $params['qty']              = $qty;
                $params['status']           = 'Approved';
                $params['shippingRef']      = md5(time());
                $params['entryDate']        = date("Y-m-d H:i:s");

                $smpHistry = $obj->newSampleHistory($params);*/

                $sampQty = array();
                $sampQty['sampleId']    = $sampleId;
                $sampQty['userId']      = $sellerId;
                $sampQty['dt']          = $qty;
                $sampQty['inStock']     = $totalQty;
                $sampQty['entryDate']   = date("Y-m-d H:i:s");

                $obj->newSampleQty($sampQty);
                
                /*-------------------ADMIN---------------------------*/
                $msg_details    = $cnObj -> getEmailBodyById(56);

                $to         = SITE_EMAIL;
                $from       = "From: ".SITE_NAME."<".SITE_NOREPLY.">";
                $subject    = $msg_details['emailSubject'];            
                $msg        = $msg_details['emailBody'];

                $other  = 'You have approved sample request # - '.$requestId;

                $arr = array(
                        "{other}" 	            => $other,
                );
                $msg    = strtr($msg,$arr);

                sendEmail($to, $from, $subject, $msg);

                /*-------------------SELLER---------------------------*/
                $smsg_details    = $cnObj -> getEmailBodyById(57);

                $sto         = $sellerMail;
                $sfrom       = "From: ".SITE_NAME."<".SITE_NOREPLY.">";
                $ssubject    = $smsg_details['emailSubject'];            
                $smsg        = $smsg_details['emailBody'];

                $sother  = 'Admin has approved your sample request having request # - '.$requestId;

                $sarr = array(
                        "{other}" 	            => $sother,
                );
                $smsg    = strtr($smsg,$sarr);

                sendEmail($sto, $sfrom, $ssubject, $smsg);

                /*-------------------Buyer---------------------------*/
                $umsg_details    = $cnObj -> getEmailBodyById(58);

                $uto         = $email;
                $ufrom       = "From: ".SITE_NAME."<".SITE_NOREPLY.">";
                $usubject    = $umsg_details['emailSubject'];            
                $umsg        = $umsg_details['emailBody'];

                $uother  = 'Your sample request has been approved and it will be delivered with in '.date('d-m-Y',strtotime($expectedDate));

                $uarr = array(
                        "{name}" 	            => $name,
                        "{other}" 	            => $uother,
                );
                $umsg    = strtr($umsg,$uarr);

                sendEmail($uto, $ufrom, $usubject, $umsg);
            }
            
        }
        
        $ErrMsg = '<div class="success">Data Updated Successfully</div>';  
            
    }
    else
        $ErrMsg = '<div class="error">* Marked Fields Are Mandatory</div>';
}
/*************************************************************************************************
Add / Edit Content Section Ended
*************************************************************************************************/
?>