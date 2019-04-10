<?php
/*************************************************************************************************
Add / Edit Content Section Started
*************************************************************************************************/
if(isset($Save) || isset($SaveNext) && $SourceForm == 'AddPost') {	
	if($blogTitle !='' && $blogAuthor!='' && $blogContent!='' && $shortDescription!=''){
        $obj = new PostClass();
        
        //permalink--------------
		if($IdToEdit)	
			$ExtraQryStr = 'blogId!='.$IdToEdit;	
		else
			$ExtraQryStr = 1;
		$permalink = createPermalink(TBL_BLOG, $blogTitle, $ExtraQryStr);
		//permalink---------------
        
        if($IdToEdit!='')
            $sel_ContentDetails = $obj->checkExistence("blogTitle = '".addslashes($blogTitle)."' and blogId != ".$IdToEdit);
        else
            $sel_ContentDetails = $obj->checkExistence("blogTitle = '".addslashes($blogTitle)."'");
		
		if(sizeof($sel_ContentDetails)<1) {
            
            //echo date('Y-m-d h:i:s',strtotime($blogDate));die;
            
            $params = array();  
            $params['blogAuthor']       = $blogAuthor;
            $params['blogContent']      = $blogContent;
            $params['shortDescription'] = $shortDescription;
            $params['blogTitle']        = $blogTitle;
            $params['permalink']        = $permalink;
            $params['status']           = $status;
            
			if($IdToEdit!='') {
				
                $obj->blogUpdateByblogId($params, $IdToEdit);
				
                $editid = $IdToEdit;
				$ErrMsg = '<div class="success">Data updated successfully</div>';
			} else {
                
                $params['blogDate']         = date('Y-m-d h:i:s',strtotime($blogDate));
                $params['blogType']         = 'P';
                $params['entryDate']        = date("Y-m-d H:i:s");
				$editid = $obj->newPost($params);									
				$ErrMsg = '<div class="success">Data inserted successfully</div>';
			}
            
            if($_FILES['ImageName']['name'] && substr($_FILES['ImageName']['type'],0,5)=='image') {
                $fObj = new FileUpload;
                $targetLocation = $MEDIA_FILES_ROOT."/blog"; 
                $TWH[0]         = 200;      // thumb width
                $TWH[1]         = 150;      // thumb height
                $LWH[0]         = 843;      // large width
                $LWH[1]         = 537;      // large height
                $option         = 'all';    // upload, thumbnail, resize, all 

                $fileName = time();
                if($target_image = $fObj->uploadImage($_FILES['ImageName'], $targetLocation, $fileName, $TWH, $LWH, $option)) {	
                    if($IdToEdit) {
                        $fetch_Existing_Lg = $obj->blogById($IdToEdit);
                        if($fetch_Existing_Lg['blogImage']) {
                            @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['blogImage']);
                            @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['blogImage']);	
                            @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['blogImage']);
                        }
                    }
                    $params = array();
                    $params['blogImage'] = $target_image;
                    $obj->blogUpdateByblogId($params, $editid);
                }
            }
		}
        else
			$ErrMsg = '<div class="error">Post already exists!</div>';
        
         if(isset($SaveNext)){
            ?>
            <script language="javascript">
                window.location = 'index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=<?php echo $dtaction;?>&moduleId=<?php echo $moduleId;?>';
            </script>
            <?php
        } 
        
	} else
		$ErrMsg = '<div class="error">Fields marked with (*) are mandatory!</div>';
}
/*************************************************************************************************
Add / Edit Content Section Ended
*************************************************************************************************/

/********************************************************************
Comment Form Action Started
********************************************************************/
if($_POST['SourceForm'] == 'BlogCommentss')
{    
    if($blogAuthor != '' && $authoremail != '' && $blogContent!='')
    {		
        $gObj = new genl();
        if($gObj->validate_email($authoremail))
        {
            $obj = new CommentClass;
            $params                  = array();
            $params['blogAuthor']    = $blogAuthor;
            $params['blogParent']    = $blogParent;
            $params['authoremail']   = $authoremail;
            $params['blogContent']   = $blogContent;
            $params['blogParent']    = $blogId;
            $params['blogDate']      = date('Y-m-d H:i:s');
            $params['entryDate']     = date('Y-m-d H:i:s');
            $params['status']        = 'Y';
            $params['isApproved']    = 'N';
            $params['blogType']      = 'C';
            $insId = $obj -> newComment($params);

            $blogAuthor     = '';
            $authoremail    = '';
            $blogContent    = '';

            $ErrMsg= '<p class="success">Your comments has been sent to administrator for approval.</p>';
        }
        else{
            $ErrMsg= '<p class="error">Email ID is invalid!</p>';
        }
    }
    else{
        $ErrMsg= '<p class="error">Fields marked with (*) are mandatory!</p>';
    }
}
/*************************************************************************************************
Comment Form Action Ended
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
			$params['homeHeading']       		= $homeHeading;
			$params['contentDescription']       = $contentDescription;
			$params['contentShortDescription']  = $contentShortDescription;
			$params['displayHeading']           = $displayHeading;
			$params['permalink']                = $permalink;
			$params['contentSwapNo']            = $contentSwapNo;
			$cObj->contentUpdateBycontentID($params, $IdToEdit);
				
				
			//Banner Image ------------------------------------------------------------------------
			$fObj = new FileUpload;
			$targetLocation = $MEDIA_FILES_ROOT."/menu";
			$TWH[0]         = 104;        // thumb width
			$TWH[1]         = 70;         // thumb height
			$LWH[0]         = 104;       // large width
			$LWH[1]         = 70;       // large height
				
			
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
		$params['homeHeading']           	= $homeHeading;
		$params['contentDescription']       = $contentDescriptionNew;
		$params['contentShortDescription']  = $contentShortDescriptionNew;
		$params['permalink']                = $permalink;
		$params['contentSwapNo']            = $contentSwapNoNew;
		$contentID = $cObj->newContent($params);

		$contentHeadingNew          = '';
		$contentDescriptionNew      = '';
		$contentShortDescriptionNew = '';

		$_SESSION['ErrMsg'] = '<div class="success">Data Inserted Successfully</div>';
	}
	else
		$_SESSION['ErrMsg'] = '<div class="error">* Marked Fields Are Mandatory !!</div>';
}
/*************************************************************************************************
 Add Content Section Ended
 *************************************************************************************************/
?>
