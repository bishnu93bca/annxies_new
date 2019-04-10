<?php
/*************************************************************************************************
Add / Edit Content Section Started
*************************************************************************************************/
if(isset($Save) && $SourceForm == 'Menu')
{
	if($contentHeading!='' && $contentDescription !='')
	{
		$mObj = new menu();
		$fObj = new FileUpload;
        
        $targetLocation = $MEDIA_FILES_ROOT."/menu"; 
        $TWH[0]         = 20;       // thumb width
        $TWH[1]         = 20;       // thumb height
        $LWH[0]         = 80;       // large width
        $LWH[1]         = 80;       // large height        
        
		if($IdToEdit!='')
			$ExtraString = ' menu_id!='.$IdToEdit;
		else
			$ExtraString = 1;
		
		if(!$displayOrder)
			$displayOrder = 0;
			
		if($parent_id=='')
			$parent_id = 0;
		
		if($price=='')
			$price = 0;
			
		if($type=='')
			$type = 'P';
		
		$sel_ContentDetails = $mObj->checkExistence("menu_name = '".addslashes($contentHeading)."' and parent_id=".$parent_id." and  ".$ExtraString);
            
		if(sizeof($sel_ContentDetails)<1)
		{		
			if($IdToEdit!='')
			{
                $params = array();
                $params['display_order'] = $displayOrder;
                $params['menu_name'] = $contentHeading;
                $params['parent_id'] = $parent_id;
                $params['menu_description'] = $contentDescription;
                $params['type'] = $type;
                $params['price'] = $price;                
				$mObj->moduleUpdateBymoduleId($params, $IdToEdit);
				
                if($_FILES['ImageName']['name'] && substr($_FILES['ImageName']['type'],0,5)=='image')	
                {
                    $fileName = time();                
                    if($target_image=$fObj->uploadImage($_FILES['ImageName'], $targetLocation, $fileName, $TWH, $LWH)){                        
                        $fetch_Existing_Lg = $mObj->menuByid($IdToEdit);
                        if($fetch_Existing_Lg['menu_image'])
                            @unlink($target_path."/".$fetch_Existing_Lg['menu_image']);
                        $params = array();                    
                        $params['menu_image'] = $target_image;                
                        $mObj->moduleUpdateBymoduleId($params, $IdToEdit);
                    }
                }
				$_SESSION['ErrMsg'] = '<div class="success">Data Updated Successfully !!</div>';
				?>
				<script language="javascript">
                window.location.href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&parent_id=<?php echo $parent_id;?>";
                </script>
				<?php
			}
			else
			{
				/*---------------------------------------------------------------------------------------------------------
				Generating Module Path.
				For sub module parent_dir will be the 
				path of parent module and child_dir will be the
				path of sub module				
				---------------------------------------------------------------------------------------------------------*/				
				if($parent_id)
				{
					$mData = $mObj -> getModuleBymoduleId($parent_id);
					$parent_dir=$mData['parent_dir'];
					list($a,$b,$c)=explode(" ",$contentHeading);
					$child_dir=strtolower($a).strtolower($b).strtolower($c);
				}			
				else
				{
					list($a,$b,$c)=explode(" ",$contentHeading);
					$parent_dir=strtolower($a).strtolower($b).strtolower($c);
					$child_dir = '';
				}
				
				/*---------------------------------------------------------------------------------------------------------
				Inserting modules information
				for new modules and or sub modules.
				---------------------------------------------------------------------------------------------------------*/				
				
                $params                     = array();
                $params['display_order']    = $displayOrder;
                $params['menu_name']        = $contentHeading;
                $params['parent_id']        = $parent_id;
                $params['menu_description'] = $contentDescription;
                $params['parent_dir']       = $parent_dir;
                $params['child_dir']        = $child_dir;
                $params['type']             = $type;
                $params['price']            = $price;
                
				$InsertedId                 = $mObj -> newModule($params);
				$ImgInsertionTime           = time();
				
				/*---------------------------------------------------------------------------------------------------------
				Here is the code to upload image 
				for module icon. 
				---------------------------------------------------------------------------------------------------------*/
                if($_FILES['ImageName']['name'] && substr($_FILES['ImageName']['type'],0,5)=='image')	
                {
                    $fileName = time();                
                    if($target_image=$fObj->uploadImage($_FILES['ImageName'], $targetLocation, $fileName, $TWH, $LWH)){                        
                        $params = array();                   
                        $params['menu_image'] = $target_image;                
                        $mObj->moduleUpdateBymoduleId($params, $InsertedId);
                    }
                }
					
				$_SESSION['ErrMsg'] = '<div class="success">Data Inserted Successfully !!</div>';
				
				/*---------------------------------------------------------------------------------------------------------
				Code to give access to user for this module.
				---------------------------------------------------------------------------------------------------------*/
                $mObj->updateUserPermission($_SESSION['UID'], $_SESSION['PERMISSION'].",".$InsertedId);	
				$_SESSION['PERMISSION']=$_SESSION['PERMISSION'].','.$InsertedId;
				
				/*---------------------------------------------------------------------------------------------------------
				Code to upload and install the module. 
				---------------------------------------------------------------------------------------------------------*/	
				/*if($_FILES['zip_file']['name'])	
				{						
					$filename = $_FILES["zip_file"]["name"];
					$source = $_FILES["zip_file"]["tmp_name"];
					$type = $_FILES["zip_file"]["type"];
					
					$name = explode(".", $filename);
					$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
					foreach($accepted_types as $mime_type) 
					{
						if($mime_type == $type) 
						{
							$okay = true;
							break;
						} 
					}
					
					$continue = strtolower($name[1]) == 'zip' ? true : false;
					if(!$continue)
						$ErrMsg = "The file you are trying to upload is not a .zip file. Please try again.";
					
					$target_path = '../'.MODULE_PATH.'/'.$filename;  
					if(move_uploaded_file($source, $target_path)) 
					{
						$zip = new ZipArchive();
						$x = $zip->open($target_path);
						if ($x === true) 
						{
							$zip->extractTo('../'.MODULE_PATH.'/'); 
							$zip->close();
							
							unlink($target_path);
						}
						$_SESSION['ErrMsg'] = '<div class="success">Data Inserted Successfully! '.$filename.' file was uploaded and unpacked.</div>';
						mysql_query("update ".TBL_MODULE." set isInstalled = 'Y' where menu_id = ".$InsertedId."");
					} 
					else 
						$ErrMsg = "There was a problem with the upload. Please try again.";				
				}*/
				?>
				<script language="javascript">
                window.location.href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&parent_id=<?php echo $parent_id;?>";
                </script>
				<?php
			}
		}
		else
			$ErrMsg = '<div class="warning">Menu Already Exists !!</div>';
	}
	else
		$ErrMsg = '<div class="warning">* Marked Fields Are Mandatory</div>';
}
/*************************************************************************************************
Add / Edit Content Section Ended
*************************************************************************************************/
?>