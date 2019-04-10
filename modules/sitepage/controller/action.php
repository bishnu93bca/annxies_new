<?php
/*************************************************************************************************
Add / Edit Content Section Started
*************************************************************************************************/
if(isset($Save) || isset($SaveNext) && $SourceForm == 'AddCategory')
{
    $obj = new MenuCategory();
    if($categoryName !='' && $modulePackageId!='' && $siteId!='')
    {	
        $fObj = new FileUpload;
        $targetLocation = $MEDIA_FILES_ROOT."/menu"; 
        $TWH[0]         = 802;       // thumb width
        $TWH[1]         = 185;       // thumb height
        $LWH[0]         = 802;       // large width
        $LWH[1]         = 185;       // large height

        //permalink--------------
        if(!$permalink)
            $permalink = $heading;	
        else
            $permalink = str_replace('-',' ',$permalink);	
        //$permalink = $categoryName;
        if($IdToEdit)	
            $ExtraQryStr = 'categoryId!='.$IdToEdit.' and parentId='.$parentId;	
        else	
            $ExtraQryStr = 'parentId='.$parentId;					
        $permalink = createPermalink(TBL_MENU_CATEGORY, $permalink, $ExtraQryStr);
        //permalink---------------	

        if($parentId=='')
            $parentId=0;
        
        if(!$hiddenMenu)
            $hiddenMenu = 'N';

        $sideBar ='';
            $side_Bar=$_POST['sideBar'];

        if(sizeof($side_Bar)>0)
            for($i=0;$i<sizeof($side_Bar);$i++)
                if($i==(sizeof($side_Bar)-1))			
                    $sideBar .= $side_Bar[$i];
                else
                    $sideBar .= $side_Bar[$i].'#';

        if($IdToEdit!='')
            $sel_ContentDetails = $obj->checkExistence("categoryName = '".addslashes($categoryName)."' and parentId=".$parentId." and categoryId != ".$IdToEdit);
        else
            $sel_ContentDetails = $obj->checkExistence("categoryName = '".addslashes($categoryName)."' and parentId=".$parentId);

        if(sizeof($sel_ContentDetails)<1)
        {					
            if($IdToEdit!='')
            {                
                $params = array();
                $params['siteId']       = $ssiteId;
                $params['parentId']     = $parentId;
                $params['moduleId']     = $modulePackageId;
                $params['categoryName'] = $categoryName;
                $params['categoryUrl']  = $categoryUrl;
                $params['categoryType'] = $categoryType;
                $params['isTopMenu']    = $isTopMenu;
                $params['isFooterMenu'] = $isFooterMenu;
                $params['permalink']    = $permalink;
                $params['sideBar']      = $sideBar;
                $params['hiddenMenu']   = $hiddenMenu;
                $obj->categoryUpdateBycategoryId($params, $IdToEdit);

                $_SESSION['ErrMsg'] = '<div class="success">Data Updated Successfully</div>';				

                if($_FILES['ImageName']['name'] && substr($_FILES['ImageName']['type'],0,5)=='image')	
                {
                    $fileName = time();                
                    if($target_image=$fObj->uploadImage($_FILES['ImageName'], $targetLocation, $fileName, $TWH, $LWH)){			
                        $fetch_Existing_Lg = $obj->categoryById($IdToEdit);					
                        if($fetch_Existing_Lg['categoryImage'])
                        {
                            @unlink($MEDIA_FILES_ROOT.'/menu/normal/'.$fetch_Existing_Lg['categoryImage']);
                            @unlink($MEDIA_FILES_ROOT.'/menu/thumb/'.$fetch_Existing_Lg['categoryImage']);
                            @unlink($MEDIA_FILES_ROOT.'/menu/normal/'.$fetch_Existing_Lg['categoryImage']);	
                        }

                        $params = array();
                        $params['categoryImage'] = $target_image;
                        $obj->categoryUpdateBycategoryId($params, $IdToEdit);
                    }
                }   
                if(isset($SaveNext)){
                    ?>
                    <script language="javascript">
                        window.location = 'index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=<?php echo $dtaction;?>&moduleId=<?php echo $moduleId;?>';
                    </script>
                    <?php
                } 
                else
                {
                    ?>

                    <script language="javascript">
                    window.location = 'index.php?pageType=<?php echo $pageType;?>&type=<?php echo $type;?>&moduleId=<?php echo $moduleId;?>';
                    </script>
                    <?php
                }
            }
            else
            {
                $params = array();
                $params['parentId']     = $parentId; 
                $params['moduleId']     = $modulePackageId; 
                $params['categoryName'] = $categoryName; 
                $params['categoryUrl']  = $categoryUrl; 
                $params['categoryType'] = $categoryType; 
                $params['isTopMenu']    = $isTopMenu; 
                $params['isFooterMenu'] = $isFooterMenu; 
                $params['permalink']    = $permalink; 
                $params['sideBar']      = $sideBar;                 
                $params['hiddenMenu']   = $hiddenMenu;                 
                $insId= $obj->newCategory($params);	

                $_SESSION['ErrMsg'] = '<div class="success">Data Inserted Successfully</div>';
                if($_FILES['ImageName']['name'] && substr($_FILES['ImageName']['type'],0,5)=='image')	
                {
                    $fileName = time();                
                    if($target_image=$fObj->uploadImage($_FILES['ImageName'], $targetLocation, $fileName, $TWH, $LWH)){			
                         $params = array();
                        $params['categoryImage'] = $target_image;
                        $obj->categoryUpdateBycategoryId($params, $insId);
                    }
                }
                if(isset($SaveNext)){
                    ?>
                    <script language="javascript">
                        window.location = 'index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=<?php echo $dtaction;?>&moduleId=<?php echo $moduleId;?>';
                    </script>
                    <?php
                } 
                else
                {
                    ?>

                    <script language="javascript">
                    window.location = 'index.php?pageType=<?php echo $pageType;?>&type=<?php echo $type;?>&moduleId=<?php echo $moduleId;?>';
                    </script>
                    <?php
                }
            }
        }
        else
            $ErrMsg = '<div class="error">Category Already Exists !!</div>';	
    }
    else
        $ErrMsg = '<div class="error">* Marked Fields Are Mandatory</div>';
}
/*************************************************************************************************
Add / Edit Content Section Ended
*************************************************************************************************/
?>