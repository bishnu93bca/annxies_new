<?php
/*************************************************************************************************
Add / Edit Photo Section Started
*************************************************************************************************/
if(isset($BannerSave) && $BannerSave == 'Save')
{
    $obj   = new GalleryClass;

        if($swapno=='')
            $swapno=0;	

        $fObj = new FileUpload; 
        $targetLocation = $MEDIA_FILES_ROOT."/photo/gallery"; 
        $TWH[0]         = 540;       // thumb width   
        $TWH[1]         = 340;        // thumb height
        $LWH[0]         = 540;       // large width
        $LWH[1]         = 340;        // large height 
        $option         = 'all';      // upload, thumbnail, resize, all

        if($IdToEdit!='')
        {           
            $params = array();
            $params['siteId']               = 36;
            $params['bannername']           = $BannerName;
            $params['bannerdescription']    = $BannerDescription;
            $params['galleryCategoryId']    = $galleryCategoryId;               
            $params['swapno']               = $swapno;            
            $obj->galleryUpdateByid($params, $IdToEdit);       

            if($_FILES['ImageName']['name'] && substr($_FILES['ImageName']['type'],0,5)=='image')
            { 
                $fileName = time();                
                if($target_image=$fObj->uploadImage($_FILES['ImageName'], $targetLocation, $fileName, $TWH, $LWH, $option)){			
                    $fetch_Existing_Lg = $obj->galleryByid($IdToEdit);				
                    if($fetch_Existing_Lg['imagepath'])
                    {
                        @unlink($target_path.'/normal/'.$fetch_Existing_Lg['imagepath']);	
                        @unlink($target_path.'/small/'.$fetch_Existing_Lg['imagepath']);	
                        @unlink($target_path.'/thumb/'.$fetch_Existing_Lg['imagepath']);	
                        @unlink($target_path.'/large/'.$fetch_Existing_Lg['imagepath']);					
                    }										
                    $params = array();
                    $params['imagepath'] = $target_image;
                    $obj->galleryUpdateByid($params, $IdToEdit);
                }
            }
            $_SESSION['ErrMsg'] = '<div class="success">Data Updated Successfully</div>';
            $decodedStr = base64_decode($redstr);
            ?>
            <script language="javascript">window.location = 'index.php?<?php echo $decodedStr?>';</script>
            <?php
        }
        else
        {
        	$fetch_ExistImage = $_FILES['imageName'];
        	$fetch_ExistImage=array();
        	for($i=0;$i<count($_FILES['imageName']['name']);$i++)
        	{
	        	foreach ($_FILES['imageName'] as $key => $value)
	        	{
	        		$fetch_ExistImage[$i][$key]=$_FILES['imageName'][$key][$i];
	        	}
        	}
            if($fetch_ExistImage[0]['error']==0)
            {
                for($i=0;$i<sizeof($fetch_ExistImage);$i++)
                {
                    $target_image  = $fetch_ExistImage[$i]['name'];
                    $source        = $fetch_ExistImage[$i];				
                    $fileNameArray = explode('.', $target_image);
                    $fileName      = $fileNameArray[0];
                    if($target_image=$fObj->uploadImage($source, $targetLocation, $fileName, $TWH, $LWH, $option)){
                        $swapno = $swapno+$i;                    	
                        $params = array();
                        $params['siteId']               = 36;
                        $params['bannername']           = $BannerName;
                        $params['bannerdescription']    = $BannerDescription;
                        $params['imagepath']            = $target_image;
                        $params['galleryCategoryId']    = $galleryCategoryId;
                        $params['swapno']               = $swapno;
                        $params['status']               = 'Y';
                        $insId = $obj->newGallery($params);
                    }
                }				
                //$obj->deleteTempGalleryBysessionId($_SESSION['sesId']);						
                $_SESSION['ErrMsg'] = '<div class="success">Data Updated Successfully</div>';						
                ?>
                <script language="javascript">
                window.location.href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&type=<?php echo $type;?>&moduleId=<?php echo $moduleId;?>";
                </script>
                <?php		
            } 
            else
                $ErrMsg = '<div class="error">Upload Image First</div>';
        }
}
/*************************************************************************************************
Add / Edit Photo Section Ended
*************************************************************************************************/
?>
