<?php
/*************************************************************************************************
Add / Edit Content Section Started
*************************************************************************************************/
if(isset($Save) || isset($SaveNext) && $SourceForm == 'AddOffice')
{
    $obj = new MemberAdmin;
    
    $airport = $_REQUEST['airport'];
    $airport = implode('#',$airport);
    
    $hotel = $_REQUEST['hotel'];
    $hotel = implode('#',$hotel);
    
    $restaurant = $_REQUEST['restaurant'];
    $restaurant = implode('#',$restaurant);
    
    if($state_code !='' && $office_city !='')
    {
        //permalink--------------
        $ENTITY = TBL_OFFICE;
        $permalink = $office_city;
        if($IdToEdit)	
            $ExtraQryStr = 'id_office!='.$IdToEdit;	
        else	
            $ExtraQryStr = '1';					
        $permalink = createPermalink($ENTITY, $permalink, $ExtraQryStr);
        //permalink---------------	

        if($IdToEdit!='')
            $sel_ContentDetails = $obj->checkExistenceOffice("office_city = '".addslashes($office_city)."' and state_code=".addslashes($state_code)." and id_office != ".addslashes($IdToEdit));
        else
            $sel_ContentDetails = $obj->checkExistenceOffice("office_city = '".addslashes($office_city)."' and state_code=".addslashes($state_code));        
        
        $params = array();
        $params['state_code']   = $state_code;
        $params['office_city']  = $office_city;
        $params['permalink']    = $permalink;
        $params['office']       = $office;
        $params['airport']      = $airport;
        $params['hotel']        = $hotel;
        $params['restaurant']   = $restaurant;
        $params['description']  = $description;
        $params['status']       = $status; 

        if($IdToEdit!='')
        {  
            $obj->officeUpdateById($params, $IdToEdit);
            $editid = $IdToEdit;
            $ErrMsg = '<div class="success">Data Updated Successfully</div>';
        }
        else
        {   
            $params['entryDate']    = date('Y-m-d H:i:s');           
            $editid = $obj->newOffice($params);
            $ErrMsg = '<div class="success">Data Inserted Successfully</div>';	
        }

        
        // Image Upload
        $newImgUploadArr = $scsImgArr = $errImgArr = array();
        foreach($_FILES['officeImage']['name'] as $sik=>$siv ){
            $newImgUploadArr[$sik]['name']      = $_FILES['officeImage']['name'][$sik];
            $newImgUploadArr[$sik]['type']      = $_FILES['officeImage']['type'][$sik];
            $newImgUploadArr[$sik]['tmp_name']  = $_FILES['officeImage']['tmp_name'][$sik];
            $newImgUploadArr[$sik]['error']     = $_FILES['officeImage']['error'][$sik];
            $newImgUploadArr[$sik]['size']      = $_FILES['officeImage']['size'][$sik];
        }
        foreach($newImgUploadArr as $imgk=>$imgv){
            if($imgv['name'] && substr($imgv['type'],0,5)=='image') {
                $fObj = new FileUpload;
                $targetLocation = $MEDIA_FILES_ROOT."/office"; 
                $TWH[0]         = 354;      // thumb width
                $TWH[1]         = 253;      // thumb height
                $LWH[0]         = 692;      // large width
                $LWH[1]         = 495;      // large height  
                $option         = 'all';    // upload, thumbnail, resize, all 

                $fileName = time().'-'.$imgk;
                $target_image = $fObj->uploadImage($imgv, $targetLocation, $fileName, $TWH, $LWH, $option);
                if($target_image){
                    $scsImgArr[] = $imgv['name'];

                    $params                 = array();
                    $params['officeId']     = $editid;
                    $params['galleryImage'] = $target_image;
                    $params['status']       = 'Y';
                    $insertGal = $obj -> newGallery($params);

                    if($imgk==0 && $insertForImage == 'Y'){
                        $params = array();
                        $params['img_office'] = $target_image;
                        $obj->officeUpdateById($params, $editid);
                    }
                }
                else
                    $errImgArr[] = $imgv['name'];
            }
            else
                $errImgArr[] = $imgv['name'];
        }
        /*if(!empty($scsImgArr)) $imgErrMsg = '<div class="success">'.implode(',',$scsImgArr).' is uploaded successfully</div>';
        if(!empty($errImgArr)) $imgScsMsg = '<div class="error">'.implode(',',$errImgArr).' upload error</div>';*/
        // Image Upload
        
        
        if(isset($SaveNext)){
            ?>
            <script language="javascript">
                window.location = 'index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=<?php echo $dtaction;?>&moduleId=<?php echo $moduleId;?>';
            </script>
            <?php
        } 
    }
    else
        $ErrMsg = '<div class="error">* Marked Fields Are Mandatory</div>';
}
/*************************************************************************************************
Add / Edit Content Section Ended
*************************************************************************************************/
/*************************************************************************************************
 Edit Content Section Started
 *************************************************************************************************/
if(isset($Update) && $SourceForm == 'ContentGeneral')
{
	if($contentHeading!='')
	{
		$cObj = new Content;

		if(!$contentSwapNo)
			$contentSwapNo = 0;

		if($IdToEdit!='')
		{
			//permalink--------------
			$ENTITY = TBL_CONTENT;
			$permalink = $contentHeading;
			$ExtraQryStr = 'contentID!='.$IdToEdit;
			$permalink = createPermalink($ENTITY, $permalink, $ExtraQryStr);
			//permalink---------------

			$params = array();
			$params['contentHeading']           = $contentHeading;
			$params['contentDescription']       = $contentDescription;
			$params['homeHeading']       		= $homeHeading;
			$params['contentShortDescription']  = $contentShortDescription;
			$params['displayHeading']           = $displayHeading;
			$params['permalink']                = $permalink;
			$params['contentSwapNo']            = $contentSwapNo;
			$cObj->contentUpdateBycontentID($params, $IdToEdit);
				
				
			//Banner Image ------------------------------------------------------------------------
			$fObj = new FileUpload;
			$targetLocation = $MEDIA_FILES_ROOT."/menu";
			$TWH[0]         = 256;        // thumb width
			$TWH[1]         = 138;         // thumb height
			$LWH[0]         = 256;       // large width
			$LWH[1]         = 138;       // large height
				
			if($_FILES['ImageName']['name'] && substr($_FILES['ImageName']['type'],0,5)=='image')
			{
				$fileName = time();
				if($target_image=$fObj->uploadImage($_FILES['ImageName'], $targetLocation, $fileName, $TWH, $LWH)){
					//$mcObj = new MenuCategory;
					$fetch_Existing_Lg = $cObj->getContentBycontentID($IdToEdit);
					if($fetch_Existing_Lg['ImageName']){
						@unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['ImageName']);
						@unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['ImageName']);
						@unlink($targetLocation.'/large/'.$fetch_Existing_Lg['ImageName']);
					}
						
					$params = array();
					$params['ImageName'] = $target_image;
					//$mcObj->categoryUpdateBycategoryId($params, $categoryId);
					$cObj->contentUpdateBycontentID($params, $IdToEdit);
				}
			}
			//-------------------------------------------------------------------------------------
				
			$_SESSION['ErrMsg'] = '<div class="success">Data Updated Successfully</div>';
		}
	}
	else
		$_SESSION['ErrMsg'] = '<div class="error">* Marked Field(s) Are Mandatory !!</div>';
}
/*************************************************************************************************
 Edit Content Section Ended
 *************************************************************************************************/

/*************************************************************************************************
 Add Content Section Started
 *************************************************************************************************/
if(isset($Save) && $SourceForm == 'NewContentGeneral')
{ 
	if($contentHeadingNew!='')
	{
		$cObj = new Content;
		if(!$contentSwapNoNew)
			$contentSwapNoNew = 0;
		//permalink--------------
		$ENTITY = TBL_CONTENT;
		$permalink = $contentHeadingNew;
		$ExtraQryStr = 1;
		$permalink = createPermalink($ENTITY, $permalink, $ExtraQryStr);
		//permalink---------------
       	$params = array();
		$params['menucategoryId']           = $menucategoryId;
		$params['displayHeading']           = $displayHeading;
		$params['contentHeading']           = $contentHeadingNew;
		$params['contentDescription']       = $contentDescriptionNew;
	    $params['homeHeading']       		= $homeHeading;
		$params['contentShortDescription']  = $contentShortDescriptionNew;
		$params['permalink']                = $permalink;
		$params['contentSwapNo']            = $contentSwapNoNew;
		$contentID = $cObj->newContent($params);

		$contentHeadingNew          = '';
		$contentDescriptionNew      = '';
		$contentShortDescriptionNew = '';

		//Banner Image ---------------------------------------------------------------
		if($_FILES['ImageName']['name'] && substr($_FILES['ImageName']['type'],0,5)=='image')
		{
			$fObj = new FileUpload;
			$targetLocation = $MEDIA_FILES_ROOT."/menu";
			$TWH[0]         = 256;        // thumb width
			$TWH[1]         = 138;         // thumb height
			$LWH[0]         = 256;       // large width
			$LWH[1]         = 138;       // large height

			$fileName = time();
			if($target_image=$fObj->uploadImage($_FILES['ImageName'], $targetLocation, $fileName, $TWH, $LWH)){
				$mcObj = new MenuCategory;
				$params = array();
				$params['ImageName'] = $target_image;
				$cObj->contentUpdateBycontentID($params, $contentID);
			}
		}
		//----------------------------------------------------------------------------

		$_SESSION['ErrMsg'] = '<div class="success">Data Inserted Successfully</div>';
	}
	else
		$_SESSION['ErrMsg'] = '<div class="error">* Marked Fields Are Mandatory !!</div>';
}
/*************************************************************************************************
 Add Content Section Ended
 *************************************************************************************************/
?>