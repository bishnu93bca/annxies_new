<?php
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
            $params['contentShortDescription']  = $contentShortDescription;
            $params['displayHeading']           = $displayHeading;
            $params['permalink']                = $permalink;
            $params['fb']                       = $fb;
            $params['tw']                       = $tw;
            $params['linkd']                    = $linkd;
            $params['gp']                       = $gp;
            $params['contentSwapNo']            = $contentSwapNo; 
            $cObj->contentUpdateBycontentID($params, $IdToEdit);

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
        $params['contentShortDescription']  = $contentShortDescriptionNew;
        $params['permalink']                = $permalink;
        $params['fb']                       = $fb;
        $params['tw']                       = $tw;
        $params['linkd']                    = $linkd;
        $params['gp']                       = $gp;
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
