<?php
/***********************************************************************************************
Add / Edit Category Section Started
*************************************************************************************************/
if(isset($Save) || isset($SaveNext) && $SourceForm == 'AddCategory')
{
    $obj = new adminCategory();
    if($mainCategory !='' && $category !='')
    {
        if($swapNo=='')
            $swapNo=0;
        
        $var  = ($parentId)?$parentId:$mainCategory;
       
        if($IdToEdit!='')
            $sel_ContentDetails = $obj->checkExistence("category = '".addslashes($category)."' and parent_id=".$var." and c_id != ".$IdToEdit." mainCategory=".$mainCategory);
        else
            $sel_ContentDetails = $obj->checkExistence("category = '".addslashes($category)."' and parent_id=".$var." and mainCategory=".$mainCategory);

        if(sizeof($sel_ContentDetails)<1)
        {	
            //permalink--------------
            $ENTITY = TBL_PRODUCT_CATEGORY;
            $permalink = $category;
            if($IdToEdit)	
                $ExtraQryStr = 'c_id!='.$IdToEdit.' and parent_id='.$var.' mainCategory='.$mainCategory;	
            else	
                $ExtraQryStr = 'parent_id='.$var.' and mainCategory='.$mainCategory;
            $permalink = createPermalink($ENTITY, $permalink, $ExtraQryStr);
            //permalink---------------
                
            //categoryUrl -------------            	
            $categoryUrl = $permalink;            
            if($var){
                $cparentId = $var;	            
                while($cparentId)
                {
                    $cData = $obj -> categoryById($cparentId);	
                    $cparentId   = $cData['parent_id'];	
                    $categoryUrl = $cData['permalink'].'/'.$categoryUrl;
                }
            }
            $categoryUrl = '/'.$categoryUrl.'/';
            //------------------------
            
            $params = array();
            $params['category']             = $category;
            $params['permalink']            = $permalink;
            $params['parent_id']            = $parentId;
            $params['status']               = $status;
            $params['showHome']             = $showHome;
            $params['categoryUrl']          = $categoryUrl;
            $params['mainCategory']         = $mainCategory;
            $params['parent_id']            = $var;
            
            if($IdToEdit!='')
            {		
                $obj->categoryUpdateBycategoryId($params, $IdToEdit);

                $ErrMsg = '<div class="success">Data Updated Successfully</div>';
                $editid = $IdToEdit;
            }
            else
            {            
                $params['entryDate']            = date('Y-m-d H:i:s');
                $editid= $obj->newCategory($params);
                $ErrMsg = '<div class="success">Data Inserted Successfully</div>';
            }
            
            if($_FILES['cat_image']['name'] && substr($_FILES['cat_image']['type'],0,5)=='image')
            {
                $fObj = new FileUpload;
                $targetLocation = $MEDIA_FILES_ROOT."/product"; 
                $TWH[0]         = 297;      // thumb width
                $TWH[1]         = 267;      // thumb height
                $LWH[0]         = 542;      // large width
                $LWH[1]         = 488;      // large height   270px*373px
                $option         = 'all';    // upload, thumbnail, resize, all 

                $fileName = time();
                if($target_image = $fObj->uploadImage($_FILES['cat_image'], $targetLocation, $fileName, $TWH, $LWH, $option)){	
                    if($IdToEdit){
                        $fetch_Existing_Lg = $obj->categoryById($IdToEdit);
                        if($fetch_Existing_Lg['cat_image'])
                        {
                            @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['cat_image']);
                            @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['cat_image']);	
                            @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['cat_image']);
                        }
                    }
                    $params = array();
                    $params['cat_image'] = $target_image;
                    $obj->categoryUpdateBycategoryId($params, $editid);
                }
            }
            
            $attributeNameArray     = $_REQUEST['attributeNameArray'];
            $attributeType          = $_REQUEST['attributeType'];
            $attributeOptions[]     = $_REQUEST['attributeOptions'];
            
            if($_REQUEST['attributeIdArray'])
            {
                $attributeIdArray = $_REQUEST['attributeIdArray'];
                for($i=0;$i<sizeof($attributeIdArray);$i++)
                {
                    if($attributeIdArray[$i])
                    {
                        if($allattributeId)
                            $allattributeId = $allattributeId.','.$attributeIdArray[$i];
                        else
                            $allattributeId = $attributeIdArray[$i];
                    }
                }
            }

            if(sizeof($attributeNameArray)>0)
            {
                if($attributeIdArray){
                    $ExtraQryStr = " attributeId not in (".$allattributeId.") ";
                    $obj->deleteAttributeBycategoryId($editid, $ExtraQryStr);
                }

                $performedIdArray = array();
                for($i=0;$i<sizeof($attributeNameArray);$i++)
                {
                    if($attributeNameArray[$i])
                    {
                        $options = array();
                        for($o=0; $o<sizeof($attributeOptions[0][$i]); $o++ )
                        {
                            if($attributeOptions[0][$i][$o]!='')
                                $options[] = $attributeOptions[0][$i][$o];	
                        }

                        $options = implode('@#@', $options);
                        if($attributeIdArray[$i] && !in_array($attributeIdArray[$i], $performedIdArray))
                        {                    
                            $params = array();
                            $params['attributeName']    = $attributeNameArray[$i];
                            $params['attributeType']    = $attributeType[$i];
                            $params['attributeOptions'] = $options;                    
                            $obj->categoryAttributeUpdateBycategoryIdattributeId($params, $editid, $attributeIdArray[$i]);                  

                            $performedIdArray[] = $attributeIdArray[$i];
                        }
                        else
                        {                    
                            $params = array();
                            $params['categoryId']           = $editid;
                            $params['attributeName']        = $attributeNameArray[$i];
                            $params['attributeType']        = $attributeType[$i];
                            $params['attributeOptions']     = $options;                    
                            $performedIdArray[]             = $obj->newAttribute($params);
                        }
                    }
                }
            }
            
        }
        else
            $ErrMsg = '<div class="error">Category Already Exists !!</div>';
        
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
Add / Edit Product Attribute Section Started
*************************************************************************************************/
if(isset($Save) && $SourceForm == 'AddCategoryAttribute')
{		
    $attributeNameArray     = $_REQUEST['attributeNameArray'];
    $attributeType          = $_REQUEST['attributeType'];
    $attributeOptions[]     = $_REQUEST['attributeOptions'];	

    if($_REQUEST['attributeIdArray'])
    {
        $attributeIdArray = $_REQUEST['attributeIdArray'];
        for($i=0;$i<sizeof($attributeIdArray);$i++)
        {
            if($attributeIdArray[$i])
            {
                if($allattributeId)
                    $allattributeId = $allattributeId.','.$attributeIdArray[$i];
                else
                    $allattributeId = $attributeIdArray[$i];
            }
        }
    }

    $obj = new adminCategory();

    if(sizeof($attributeNameArray)>0)
    {
        if($attributeIdArray){
            $ExtraQryStr = " attributeId not in (".$allattributeId.") ";
            $obj->deleteAttributeBycategoryId($categoryId, $ExtraQryStr);
        }

        $performedIdArray = array();
        for($i=0;$i<sizeof($attributeNameArray);$i++)
        {
            if($attributeNameArray[$i])
            {
                $options = array();
                for($o=0; $o<sizeof($attributeOptions[0][$i]); $o++ )
                {
                    if($attributeOptions[0][$i][$o]!='')
                        $options[] = $attributeOptions[0][$i][$o];	
                }

                $options = implode('@#@', $options);
                if($attributeIdArray[$i] && !in_array($attributeIdArray[$i], $performedIdArray))
                {                    
                    $params = array();
                    $params['attributeName']    = $attributeNameArray[$i];
                    $params['attributeType']    = $attributeType[$i];
                    $params['attributeOptions'] = $options;                    
                    $obj->categoryAttributeUpdateBycategoryIdattributeId($params, $categoryId, $attributeIdArray[$i]);                  

                    $performedIdArray[] = $attributeIdArray[$i];
                }
                else
                {                    
                    $params = array();
                    $params['categoryId']           = $categoryId;
                    $params['attributeName']        = $attributeNameArray[$i];
                    $params['attributeType']        = $attributeType[$i];
                    $params['attributeOptions']     = $options;                    
                    $performedIdArray[]             = $obj->newAttribute($params);
                }
            }
        }
        $ErrMsg = '<div class="success">Data Inserted Successfully</div>';	
    }
    else
        $ErrMsg = '<div class="error">* Marked Fields Are Mandatory</div>';
}
/*************************************************************************************************
Add / Edit Product Attribute  Ended
*************************************************************************************************/
?>