<?php
/*************************************************************************************************
Add / Edit Content Section Started
*************************************************************************************************/
if(isset($Save) || isset($SaveNext) && $SourceForm == 'AddPackage')
{
    $obj = new MemberAdmin;
   
    if($name !='' && $price !='' && $contractDesc !='')
    {
        //permalink--------------
        $ENTITY = TBL_PACKAGE;
        $permalink = $name;
        if($IdToEdit)	
            $ExtraQryStr = 'packageId!='.$IdToEdit;	
        else	
            $ExtraQryStr = '1';					
        $permalink = createPermalink($ENTITY, $permalink, $ExtraQryStr);
        //permalink---------------	

        if($IdToEdit!='')
            $sel_ContentDetails = $obj->checkExistencePackage("name = '".addslashes($name)."' and packageId != ".addslashes($IdToEdit));
        else
            $sel_ContentDetails = $obj->checkExistencePackage("name = '".addslashes($name));        
        
        $params = array();
        $params['name']         = $name;
        $params['permalink']    = $permalink;
        $params['price']        = $price;
        $params['smallnote']    = $smallnote;
        $params['description']  = $description;
        $params['contractDesc'] = $contractDesc;
        $params['status']       = $status; 

        if($IdToEdit!='')
        {  
            $obj->packageUpdateById($params, $IdToEdit);
            $editid = $IdToEdit;
            $ErrMsg = '<div class="success">Data Updated Successfully</div>';
        }
        else
        {   
            $params['entryDate']    = date('Y-m-d H:i:s');           
            $editid = $obj->newPackage($params);
            $ErrMsg = '<div class="success">Data Inserted Successfully</div>';	
        }
        
        if($_FILES['image']['name'] && substr($_FILES['image']['type'],0,5)=='image')	
        {	
             $fObj = new FileUpload;
            $targetLocation = $MEDIA_FILES_ROOT."/package"; 
            $TWH[0]         = 70;        // thumb width 
            $TWH[1]         = 70;         // thumb height
            $LWH[0]         = 70;       // large width
            $LWH[1]         = 70;       // large height
            
            $fileName = time();
            if($target_image = $fObj->uploadImage($_FILES['image'], $targetLocation, $fileName, $TWH, $LWH)){
                if($IdToEdit){
                    $fetch_Existing_Lg = $obj->getPackageInfoByid($IdToEdit);	
                    if($fetch_Existing_Lg['image'])
                    { 
                        @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['image']);	
                        @unlink($targetLocation.'/small/'.$fetch_Existing_Lg['image']);	
                        @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['image']);
                        @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['image']);	
                    }
                }
                $params = array();
                $params['image'] = $target_image;
                $obj->packageUpdateById($params, $editid);
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
				
			if($_FILES['image']['name'] && substr($_FILES['image']['type'],0,5)=='image')
			{
				$fileName = time();
				if($target_image=$fObj->uploadImage($_FILES['image'], $targetLocation, $fileName, $TWH, $LWH)){
					//$mcObj = new MenuCategory;
					$fetch_Existing_Lg = $cObj->getContentBycontentID($IdToEdit);
					if($fetch_Existing_Lg['image']){
						@unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['image']);
						@unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['image']);
						@unlink($targetLocation.'/large/'.$fetch_Existing_Lg['image']);
					}
						
					$params = array();
					$params['image'] = $target_image;
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
		if($_FILES['image']['name'] && substr($_FILES['image']['type'],0,5)=='image')
		{
			$fObj = new FileUpload;
			$targetLocation = $MEDIA_FILES_ROOT."/menu";
			$TWH[0]         = 256;        // thumb width
			$TWH[1]         = 138;         // thumb height
			$LWH[0]         = 256;       // large width
			$LWH[1]         = 138;       // large height

			$fileName = time();
			if($target_image=$fObj->uploadImage($_FILES['image'], $targetLocation, $fileName, $TWH, $LWH)){
				$mcObj = new MenuCategory;
				$params = array();
				$params['image'] = $target_image;
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