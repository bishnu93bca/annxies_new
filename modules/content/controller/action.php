<?php
/*************************************************************************************************
 Edit Content Section Started
*************************************************************************************************/
if(isset($Update) && $SourceForm == 'ContentGeneral')
{
    if($contentHeading!='' && $contentDescription !='')
    {	
        $cmsObj = new Content;

        //permalink--------------
        $ENTITY = TBL_CONTENT;
        $permalink = $contentHeading;
        if($IdToEdit)	
            $ExtraQryStr = 'contentID!='.$IdToEdit.' and categoryId='.$categoryId;	
        else	
            $ExtraQryStr = 'categoryId='.$categoryId;
        $permalink = createPermalink($ENTITY, $permalink, $ExtraQryStr);
        //permalink---------------

        $ExtraString = "contentHeading = '".addslashes($contentHeading)."'";
        if($IdToEdit!='')
            $ExtraString = "and contentID!=".$IdToEdit;
        else
            $ExtraString = 1;
        
        $sel_ContentDetails = $cmsObj -> checkExistence($ExtraString);

        if(sizeof($sel_ContentDetails)<1)
        {
            if(!$contentSwapNo)
                $contentSwapNo = 0;

            if($IdToEdit!='')
            {                
                $params = array();
                $params['contentHeading']           = $contentHeading;
                $params['contentDescription']       = $contentDescription;
                $params['contentShortDescription']  = $contentShortDescription;
                $params['displayHeading']           = $displayHeading;
                $params['permalink']                = $permalink;
                $params['vidLink']                  = ($vidLink)? $vidLink:'';
                $params['contentSwapNo']            = $contentSwapNo;
                $cmsObj->contentUpdateBycontentID($params, $IdToEdit);

                $_SESSION['ErrMsg'] = '<div class="success">Data Updated Successfully</div>';						
            }

            //Banner Image ------------------------------------------------------------------------            

            if($_FILES['ImageName']['name'] && substr($_FILES['ImageName']['type'],0,5)=='image')	
            {
                $fObj = new FileUpload;
                $targetLocation = $MEDIA_FILES_ROOT."/menu"; 
                $TWH[0]         = 450;        // thumb width
                $TWH[1]         = 154;         // thumb height
                $LWH[0]         = 1352;       // large width
                $LWH[1]         = 462;       // large height
                
                $fileName = time();                
                if($target_image=$fObj->uploadImage($_FILES['ImageName'], $targetLocation, $fileName, $TWH, $LWH)){			
                   
                    $fetch_Existing_Lg = $cmsObj->getContentBycontentID($IdToEdit);				
                    if($fetch_Existing_Lg['ImageName']){
                        @unlink($target_path.'/menu/normal/'.$fetch_Existing_Lg['ImageName']);	
                        @unlink($target_path.'/menu/large/'.$fetch_Existing_Lg['ImageName']);	
                        @unlink($target_path.'/menu/thumb/'.$fetch_Existing_Lg['ImageName']);
                    }

                    $params = array();
                    $params['ImageName'] = $target_image;
                    $cmsObj->contentUpdateBycontentID($params, $IdToEdit);
                }
            }
            //-------------------------------------------------------------------------------------
        }
        else
            $_SESSION['ErrMsg'] = '<div class="warning">Heading Already Exists !!</div>';
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
    //permalink--------------
    $ENTITY = TBL_CONTENT;
    $permalink = $contentHeading;
    if($IdToEdit)	
        $ExtraQryStr = 'contentID!='.$IdToEdit.' and categoryId='.$categoryId;	
    else	
        $ExtraQryStr = 'contentID='.$contentID;	
    $permalink = createPermalink($ENTITY, $permalink, $ExtraQryStr);
    //permalink---------------

    if($contentHeadingNew!='' && $contentDescriptionNew !='')
    {
        $cmsObj = new Content;
        $sel_ContentDetails = $cmsObj -> checkExistence("contentHeading = '".addslashes($contentHeadingNew)."'");

        if(sizeof($sel_ContentDetails)<1)
        {
            if(!$contentSwapNoNew)
                $contentSwapNoNew = 0;	

            $params = array();
            $params['menucategoryId']           = $menucategoryId;
            $params['displayHeading']           = $displayHeading;
            $params['contentHeading']           = $contentHeadingNew;
            $params['contentDescription']       = $contentDescriptionNew;
            $params['contentShortDescription']  = $contentShortDescriptionNew;
            $params['permalink']                = $permalink;
            $params['contentSwapNo']            = $contentSwapNoNew;
            $insId = $cmsObj->newContent($params);

            $contentHeadingNew='';
            $contentDescriptionNew ='';
            $contentShortDescriptionNew ='';

            //Banner Image ---------------------------------------------------------------
            if($_FILES['ImageName']['name'] && substr($_FILES['ImageName']['type'],0,5)=='image')	
            {
                $fObj = new FileUpload;
                $targetLocation = $MEDIA_FILES_ROOT."/menu"; 
                $TWH[0]         = 450;        // thumb width
                $TWH[1]         = 154;         // thumb height
                $LWH[0]         = 1352;       // large width
                $LWH[1]         = 462;       // large height

                $fileName = time();                
                if($target_image=$fObj->uploadImage($_FILES['ImageName'], $targetLocation, $fileName, $TWH, $LWH)){			
                  
                    @unlink($target_path.'/menu/normal/'.$fetch_Existing_Lg['ImageName']);	
                    @unlink($target_path.'/menu/large/'.$fetch_Existing_Lg['ImageName']);	
                    @unlink($target_path.'/menu/thumb/'.$fetch_Existing_Lg['ImageName']);
                    
                    $params = array();
                    $params['ImageName'] = $target_image;
                    $cmsObj->contentUpdateBycontentID($params, $insId);
                }                
            }	
            //----------------------------------------------------------------------------			
            $_SESSION['ErrMsg'] = '<div class="success">Data Inserted Successfully</div>';		
        }
        else
            $_SESSION['ErrMsg'] = '<div class="warning">Heading Already Exists !!</div>';
    }
    else
        $_SESSION['ErrMsg'] = '<div class="error">* Marked Fields Are Mandatory !!</div>';
}
/*************************************************************************************************
Add Content Section Ended
*************************************************************************************************/
?>