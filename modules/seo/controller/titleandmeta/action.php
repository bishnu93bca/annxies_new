<?php
/*************************************************************************************************
Add / Edit Default PageTitle ans MetaTag Section Started
*************************************************************************************************/
if(isset($Save) && $SourceForm == 'TitleMetaAdd')
{
    if($homepageTitleText!='' && $pageTitleText!='')
    {			
        $obj = new PageTitle;

        if($homeIdToEdit!='' && $IdToEdit!='')
        {
            $params = array();
            $params['pageTitleText']    = $pageTitleText;
            $params['metaTag']          = $metaTag;
            $params['metaDescription']  = $metaDescription;
            $params['metaRobots']       = $metaRobots;
            $obj->titleMetaUpdateById($params, $IdToEdit);

            $params = array();
            $params['pageTitleText']    = $homepageTitleText;
            $params['metaTag']          = $homemetaTag;
            $params['metaDescription']  = $homemetaDescription;
            $params['metaRobots']       = $homepagemetaRobots;
            $obj->titleMetaUpdateById($params, $homeIdToEdit);

            $ErrMsg = '<div class="success">Data Updated Successfully</div>';
        }
        else
        {
            $params = array();
            $params['siteId']           = $_SESSION['SITE_ID'];
            $params['titleandMetaUrl']  = "/";
            $params['pageTitleText']    = $homepageTitleText;
            $params['metaTag']          = $homemetaTag;
            $params['metaDescription']  = $homemetaDescription;
            $params['metaRobots']       = $homepagemetaRobots;
            $params['titleandMetaType'] = 'H';
            $obj->newTitleMeta($params);           

            $params = array();
            $params['siteId']           = $_SESSION['SITE_ID'];
            $params['titleandMetaUrl']  = "/";
            $params['pageTitleText']    = $pageTitleText;
            $params['metaTag']          = $metaTag;
            $params['metaDescription']  = $metaDescription;
            $params['metaRobots']       = $metaRobots;
            $params['titleandMetaType'] = 'D';
            $obj->newTitleMeta($params);

            $ErrMsg = '<div class="success">Data Inserted Successfully</div>';
        }
    }
    else
        $ErrMsg = '<div class="error">* Marked Field(s) Are Mandatory</div>';
}
/*************************************************************************************************
Add / Edit Default PageTitle ans MetaTag Section Ended
*************************************************************************************************/
/*************************************************************************************************
Add / Edit PageTitle ans MetaTag Section Started
*************************************************************************************************/
if(isset($Save) && $SourceForm == 'AddTitleMeta')
{
    if($pageTitleText!='' && $titleandMetaUrl!='')
    {
        $obj = new PageTitle;

        if($IdToEdit!='')
        {            
            $params = array();
            $params['pageTitleText']        = $pageTitleText;
            $params['titleandMetaUrl']      = $titleandMetaUrl;
            $params['metaTag']              = $metaTag;
            $params['metaDescription']      = $metaDescription;
            $params['metaRobots']           = $metaRobots;
            $obj->titleMetaUpdateById($params, $IdToEdit);           

            $ErrMsg = '<div class="success">Data Updated Successfully</div>';			
        }
        else
        {            
            $params = array();
            $params['siteId']           = $_SESSION['SITE_ID'];
            $params['titleandMetaUrl']  = $titleandMetaUrl;
            $params['pageTitleText']    = $pageTitleText;
            $params['metaTag']          = $metaTag;
            $params['metaDescription']  = $metaDescription;
            $params['metaRobots']       = $metaRobots;
            $params['titleandMetaType'] = 'O';
            $obj->newTitleMeta($params);            

            $ErrMsg = '<div class="success">Data Inserted Successfully</div>';
        }
        $decodedStr = base64_decode($redstr);	
        ?>
        <script language="javascript">
            window.location = 'index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $moduleId;?>';		
        </script>
        <?php
    }
    else
        $ErrMsg = '<div class="error">* Marked Field(s) Are Mandatory</div>';
}
/*************************************************************************************************
Add / Edit PageTitle ans MetaTag Section Ended
*************************************************************************************************/
/*************************************************************************************************
Add / Edit PageTitle ans MetaTag Section Started
*************************************************************************************************/
if(isset($Save) && $SourceForm == 'Addcanonical')
{
    if($canonicalText!='' && $canonicalUrl!='')
    {
        $obj = new PageTitle;

        if($IdToEdit!='')
        {
            $params = array();
            $params['canonicalText']    = $canonicalText;
            $params['canonicalUrl']     = $canonicalUrl;
            $obj->canonicalUpdateById($params, $IdToEdit);

            $ErrMsg = '<div class="success">Data Updated Successfully</div>';
        }
        else
        {
            $params = array();
            $params['siteId']           = $_SESSION['SITE_ID'];
            $params['canonicalUrl']     = $canonicalUrl;
            $params['canonicalText']    = $canonicalText;            
            $obj->newCanonical($params);

            $ErrMsg = '<div class="success">Data Inserted Successfully</div>';
        }
        $decodedStr = base64_decode($redstr);
        ?>
        <script language="javascript">
            window.location = 'index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $moduleId;?>';		
        </script>
        <?php
    }
    else
        $ErrMsg = '<div class="error">* Marked Field(s) Are Mandatory</div>';
}
/*************************************************************************************************
Add / Edit PageTitle ans MetaTag Section Ended
*************************************************************************************************/
?>
