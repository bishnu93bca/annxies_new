<?php
/*************************************************************************************************
Add / Edit Product Section Started
*************************************************************************************************/
if(isset($Save) && $SourceForm == 'AddProduct')
{	
    $obj = new adminProductClass();
    $catObj = new adminCategory();
    
    if($p_name && $p_category && $p_keyword && $p_bdes && $paymenttype)
    {	      
        //permalink--------------
        $ENTITY = TBL_PRODUCT;
        $permalink = $p_name;
        if($IdToEdit)	
            $ExtraQryStr = 'id!='.$IdToEdit;	
        else
            $ExtraQryStr = 1;
        $permalink = createPermalink($ENTITY, $permalink, $ExtraQryStr);
        //permalink---------------        

        if($swapNo=='')
            $swapNo = 0;

        if($IdToEdit!='')
            $sel_ContentDetails = $obj->checkExistence("p_name = '".addslashes($p_name)."' and p_category=".addslashes($p_category)." and id != ".addslashes($IdToEdit));
        else
            $sel_ContentDetails = $obj->checkExistence("p_name = '".addslashes($p_name)."' and p_category=".addslashes($p_category));

         
        if(sizeof($sel_ContentDetails)<1)
        {	  
            $p_delivertytime    =$p_delivertytime0.' '.$p_delivertytime1;

            $params = array();
            $params['p_category']               = $p_category;
            $params['p_name']                   = $p_name;
            $params['permalink']                = $permalink;
            $params['p_keyword']                = $p_keyword;
            $params['p_subcategory']            = $p_subcategory;
            $params['country']                  = $country;
            $params['p_bdes']                   = $p_bdes;
            $params['p_ddes']                   = $p_ddes;
            $params['p_price']                  = $p_price;
            $params['range1']                   = $range1;
            $params['range2']                   = $range2;
            $params['paymenttype']              = $paymenttype;
            $params['p_min_quanity']            = $p_min_quanity;
            $params['p_quanity_type']           = $p_quanity_type;
            $params['p_capaacity']              = $p_capaacity;
            $params['p_ctype']                  = $p_ctype;
            $params['percapacity']              = $percapacity;
            $params['range12']                  = $range12;
            $params['p_delivertytime']          = $p_delivertytime;
            $params['p_packingdetails']         = $p_packingdetails;
            $params['expiredate']               = $expiredate;
            $params['status']                   = $status;
            $params['lang_status']              = $lang_status;
            $params['viewcount']                = $viewcount;
            $params['groupname']                = $groupname;


            if($IdToEdit!='')
            {    
                $obj->productUpdateByproductId($params, $IdToEdit);
                $ErrMsg = '<div class="success">Data Updated Successfully</div>';
            }
            else
            {            
                $params['entryDate']             = date('Y-m-d H:i:s');
                $IdToEdit = $obj->newProduct($params);
                $IdToEdit = $IdToEdit;

                $ErrMsg = '<div class="success">Data Inserted Successfully</div>';					
            }
            
            $fObj = new FileUpload;
            $targetLocation = $MEDIA_FILES_ROOT."/product"; 

            $TWH[0]         = 309;      // thumb width
            $TWH[1]         = 205;      // thumb height
            $LWH[0]         = 640;      // large width
            $LWH[1]         = 424;      // large height
            $option         = 'all';    // upload, thumbnail, resize, all 
              
            if($_FILES['p_photo']['name'] && substr($_FILES['p_photo']['type'],0,5)=='image')
            {
                $fileName = time();
                if($target_image = $fObj->uploadImage($_FILES['p_photo'], $targetLocation, $fileName, $TWH, $LWH, $option)){	
                    if($IdToEdit){
                        $fetch_Existing_Lg = $obj->productById($IdToEdit);
                        if($fetch_Existing_Lg['p_photo'])
                        {
                            @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['p_photo']);
                            @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['p_photo']);	
                            @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['p_photo']);
                        }
                    }
                    $params = array();
                    $params['p_photo'] = $target_image;
                    $obj->productUpdateByproductId($params, $IdToEdit);
                }
            }
            if($_FILES['photo1']['name'] && substr($_FILES['photo1']['type'],0,5)=='image')
            {
                $fileName = time().'1';
                if($target_image = $fObj->uploadImage($_FILES['photo1'], $targetLocation, $fileName, $TWH, $LWH, $option)){	
                    if($IdToEdit){
                        $fetch_Existing_Lg = $obj->productById($IdToEdit);
                        if($fetch_Existing_Lg['photo1'])
                        {
                            @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['photo1']);
                            @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['photo1']);	
                            @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['photo1']);
                        }
                    }
                    $params = array();
                    $params['photo1'] = $target_image;
                    $obj->productUpdateByproductId($params, $IdToEdit);
                }
            }
            if($_FILES['photo2']['name'] && substr($_FILES['photo2']['type'],0,5)=='image')
            {
                $fileName = time().'2';
                if($target_image = $fObj->uploadImage($_FILES['photo2'], $targetLocation, $fileName, $TWH, $LWH, $option)){	
                    if($IdToEdit){
                        $fetch_Existing_Lg = $obj->productById($IdToEdit);
                        if($fetch_Existing_Lg['photo2'])
                        {
                            @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['photo2']);
                            @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['photo2']);	
                            @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['photo2']);
                        }
                    }
                    $params = array();
                    $params['photo2'] = $target_image;
                    $obj->productUpdateByproductId($params, $IdToEdit);
                }
            }
            if($_FILES['photo3']['name'] && substr($_FILES['photo3']['type'],0,5)=='image')
            {
                $fileName = time().'3';
                if($target_image = $fObj->uploadImage($_FILES['photo3'], $targetLocation, $fileName, $TWH, $LWH, $option)){	
                    if($IdToEdit){
                        $fetch_Existing_Lg = $obj->productById($IdToEdit);
                        if($fetch_Existing_Lg['photo3'])
                        {
                            @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['photo3']);
                            @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['photo3']);	
                            @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['photo3']);
                        }
                    }
                    $params = array();
                    $params['photo3'] = $target_image;
                    $obj->productUpdateByproductId($params, $IdToEdit);
                }
            }
            if($_FILES['photo4']['name'] && substr($_FILES['photo4']['type'],0,5)=='image')
            {
                $fileName = time().'4';
                if($target_image = $fObj->uploadImage($_FILES['photo4'], $targetLocation, $fileName, $TWH, $LWH, $option)){	
                    if($IdToEdit){
                        $fetch_Existing_Lg = $obj->productById($IdToEdit);
                        if($fetch_Existing_Lg['photo4'])
                        {
                            @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['photo4']);
                            @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['photo4']);	
                            @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['photo4']);
                        }
                    }
                    $params = array();
                    $params['photo4'] = $target_image;
                    $obj->productUpdateByproductId($params, $IdToEdit);
                }
            }
            if($_FILES['photo5']['name'] && substr($_FILES['photo5']['type'],0,5)=='image')
            {
                $fileName = time().'5';
                if($target_image = $fObj->uploadImage($_FILES['photo5'], $targetLocation, $fileName, $TWH, $LWH, $option)){	
                    if($IdToEdit){
                        $fetch_Existing_Lg = $obj->productById($IdToEdit);
                        if($fetch_Existing_Lg['photo5'])
                        {
                            @unlink($targetLocation.'/normal/'.$fetch_Existing_Lg['photo5']);
                            @unlink($targetLocation.'/thumb/'.$fetch_Existing_Lg['photo5']);	
                            @unlink($targetLocation.'/large/'.$fetch_Existing_Lg['photo5']);
                        }
                    }
                    $params = array();
                    $params['photo5'] = $target_image;
                    $obj->productUpdateByproductId($params, $IdToEdit);
                }
            }

            $editid = $IdToEdit;
        }
        else
            $ErrMsg = '<div class="error">Product already exists with same category!</div>';
        
    }
    else
        $ErrMsg = '<div class="error">* Marked Fields Are Mandatory</div>';
}
/*************************************************************************************************
Add / Edit Product Section Ended
*************************************************************************************************/
if(isset($Save) && $SourceForm == 'NewContentGeneral')
{  
	if($contentHeadingNew!='')
	{  
		$catObj = new Content;
		if(!$contentSwapNoNew)
			$contentSwapNoNew = 0;
		//permalink--------------
		$ENTITY = TBL_CONTENT;
		$permalink = $contentHeadingNew;
		$ExtraQryStr = 1;
		$permalink = createPermalink($ENTITY, $permalink, $ExtraQryStr);
		//permalink---------------

		$params = array();
		$params['menup_category']           = $menup_category;
		$params['displayHeading']           = $displayHeading;
		$params['contentHeading']           = $contentHeadingNew;
		$params['contentDescription']       = $contentDescriptionNew;
		$params['contentShortDescription']  = $contentShortDescriptionNew;
		$params['permalink']                = $permalink;
		$params['contentSwapNo']            = $contentSwapNoNew;
		$contentID = $catObj->newContent($params);

        $contentHeadingNew          = '';
		$contentDescriptionNew      = '';
		$contentShortDescriptionNew = '';

		$_SESSION['ErrMsg'] = '<div class="success">Data Inserted Successfully</div>';
	}
	else
		$_SESSION['ErrMsg'] = '<div class="error">* Marked Fields Are Mandatory !!</div>';
}
/*------------------------------------------------------------------*/

if(isset($Update) && $SourceForm == 'ContentGeneral')
{ 
	if($contentHeading!='')
	{ 
		$catObj = new Content;

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
			$params['contentSwapNo']            = $contentSwapNo;
			$catObj->contentUpdateBycontentID($params, $IdToEdit);

			$_SESSION['ErrMsg'] = '<div class="success">Data Updated Successfully</div>';
		}
	}
	else
		$_SESSION['ErrMsg'] = '<div class="error">* Marked Field(s) Are Mandatory !!</div>';
}

/*************************************************************************************************
Add / Edit Product Gallery  Started
*************************************************************************************************/

if(isset($ProductGallerySave) && $ProductGallerySave == 'Save')
{ 
    $fObj = new FileUpload;
	$targetLocation = $MEDIA_FILES_ROOT."/products";
    $TWH[0]         = 309;      // thumb width
    $TWH[1]         = 205;      // thumb height
    $LWH[0]         = 640;      // large width
    $LWH[1]         = 424;      // large height
    $option         = 'all';    // upload, thumbnail, resize, all 

	if($galleryid !='')
	{  
		$obj=new adminProductClass();
		$fetch_ExistImage = $_FILES['imageName'];
        $fetch_ExistImage=array();
		for($i=0;$i<count($_FILES['imageName']['name']);$i++)
		{
			foreach ($_FILES['imageName'] as $key => $value)
			{
				$fetch_ExistImage[$i][$key]=$_FILES['imageName'][$key][$i];
			}
		}

		if($fetch_ExistImage[0]['name'] !='')
		{
			for($i=0;$i<sizeof($fetch_ExistImage);$i++)
			{
				$target_image  = $fetch_ExistImage[$i]['name'];
				$source        = $fetch_ExistImage[$i];
				$fileNameArray = explode('.', $target_image);
				$fileName      = $fileNameArray[0];
                $fileName = time().$i;
				if($target_image=$fObj->uploadImage($source, $targetLocation, $fileName, $TWH, $LWH, $option))
				{
					$swapno = $swapno+$i;
					$params = array();
					$params['id']		    = $galleryid;
					$params['galleryImage']			= $target_image;
					$params['swapno']               = ($swapno)?$swapno:0;
					$params['status']               = 'Y';
       
					$insId = $obj->newGallery($params);
				}
			}
			$ErrMsg = '<div class="success">Image inserted successfully</div>';
		}
		else
			$ErrMsg = '<div class="error">Upload image first</div>';
	}
	else
		$ErrMsg = '<div class="error">* Sorry unable to upload</div>';
}

/*************************************************************************************************
Add / Edit Product Gallery  Ended
*************************************************************************************************/

/*************************************************************************************************
Add / Edit Product Video  Started
*************************************************************************************************/

if(isset($ProductVideoSave) && $ProductVideoSave == 'Save')
{ 
    if($vedioid !='')
	{ 
		$obj=new adminProductClass();
        $params = array();
        $params['id']		    = $vedioid;
        $params['videoLink']			= $videoLink;
        $params['swapno']               = ($swapno)?$swapno:0;
        $params['status']               = 'Y';
      
        $insId = $obj->newVideo($params);
        $ErrMsg = '<div class="success">Data inserted successfully</div>';
    }
    else
        $ErrMsg = '<div class="error">* Marked Fields Are Mandatory</div>';
}
/*************************************************************************************************
Add / Edit Product Video  Ended
*************************************************************************************************/
?>