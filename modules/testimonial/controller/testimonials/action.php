<?php
/*************************************************************************************************
Add / Edit Content Section Started
*************************************************************************************************/
if(isset($Save) || isset($SaveNext) && $SourceForm == 'AddTestimonial')
{
    if($description !='' && $heading !='')
    {
        $fObj = new FileUpload;
        $targetLocation = $MEDIA_FILES_ROOT."/testimonials"; 
        $TWH[0]         = 116;        // thumb width 164px * 153
        $TWH[1]         = 116;         // thumb height
        $LWH[0]         = 116;       // large width
        $LWH[1]         = 116;       // large height

        //permalink--------------
        $ENTITY = TBL_TESTIMONIAL;
        $permalink = $heading;
        if($IdToEdit)	
            $ExtraQryStr = 'testimonialId!='.$IdToEdit;	
        else	
            $ExtraQryStr = '1';					
        $permalink = createPermalink($ENTITY, $permalink, $ExtraQryStr);
        //permalink---------------	

        $obj = new AdminTestimonial;
        
        $params = array();
        $params['heading']      = $heading;
        $params['description']  = $description;
        $params['place']        = $place;
        $params['designation']  = $designation;
        $params['permalink']    = $permalink;
        $params['swapNo']       = ($swapNo)?$swapNo:0;
        $params['status']       = $status;   
        

        if($IdToEdit!='')
        {
            $obj->testimonialUpdateBytestimonialId($params, $IdToEdit);
            $editid = $IdToEdit;
            $ErrMsg = '<div class="success">Data Updated Successfully</div>';
        }
        else
        {   $params['entryDate']    = date('Y-m-d H:i:s');
           
            $editid = $obj->newTestimonial($params);
            $ErrMsg = '<div class="success">Data Inserted Successfully</div>';	
        }

        if($_FILES['imageFile']['name'] && substr($_FILES['imageFile']['type'],0,5)=='image')	
        {				
            $fileName = time();
            if($target_image = $fObj->uploadImage($_FILES['imageFile'], $targetLocation, $fileName, $TWH, $LWH)){
                if($IdToEdit){
                    $fetch_Existing_Lg = $obj->testimonialById($IdToEdit);	
                    if($fetch_Existing_Lg['imageName'])
                    { 
                        @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['imageName']);	
                        @unlink($targetLocation.'/small/'.$fetch_Existing_Lg['imageName']);	
                        @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['imageName']);
                        @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['imageName']);	
                    }
                }
                $params = array();
                $params['imageName'] = $target_image;
                $obj->testimonialUpdateBytestimonialId($params, $editid);
            }
        }
        
        
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