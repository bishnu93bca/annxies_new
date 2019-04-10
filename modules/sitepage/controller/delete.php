<?php
if($confirm=='ASK')
{
	$pageType= $_REQUEST['pageType'];
	$dtls= $_REQUEST['dtls'];
	$dtaction= $_REQUEST['dtaction'];
	$id= $_REQUEST['id'];
	$page= $_REQUEST['page'];
	$parentId= $_REQUEST['parentId'];
	$redirectString= $_REQUEST['redstr'];
	?>
	<table align="center">
		<tr>
			<td colspan="2"><h4>All the data associated with this menu will also be deleted.<br />Are you sure to delete?</h4></td>
		</tr>
		<tr>
			<td align="center"><a href="index.php?pageType=<?php echo $pageType;?>&parentId=<?php echo $parentId;?>&dtaction=delete&moduleId=<?php echo $moduleId;?>&id=<?php echo $id;?>&parentId=<?php echo $parentId;?>&redstr=<?php echo $redirectString;?>&confirm=YES">Yes</a></td>
			<td align="center"><a href="index.php?pageType=<?php echo $pageType;?>&parentId=<?php echo $parentId;?>&dtaction=delete&moduleId=<?php echo $moduleId;?>&id=<?php echo $id;?>&parentId=<?php echo $parentId;?>&redstr=<?php echo $redirectString;?>&confirm=NO">No</a></td>
		</tr>
	</table>
	<?php
}

if($id!='' && $confirm=='YES')
{
	$obj = new MenuCategory();
	function subPageDelete($pId,$obj)
	{		
		$subData = $obj -> getMenuByparentId($pId);
		
		if($subData)
		{
			for($i=0;$i<sizeof($subData);$i++)
			{
                $obj -> deleteContentBymenucategoryId($subData[$i]['categoryId']);
				$sel_ImgDtls = $obj->galleryBymenucategoryId($subData[$i]['categoryId']);				
                foreach($sel_ImgDtls as $fetch_ImgDtls)
                {					
                    if(is_file($MEDIA_FILES_ROOT.'/photo/gallery/normal/'.$fetch_ImgDtls['imagepath']) && $fetch_ImgDtls['imagepath'])
                        @unlink($MEDI_FILES_ROOT.'/photo/gallery/normal/'.$fetch_ImgDtls['imagepath']);

                    if(is_file($MEDIA_FILES_ROOT.'/photo/gallery/large/'.$fetch_ImgDtls['imagepath']) && $fetch_ImgDtls['imagepath'])
                        @unlink($MEDI_FILES_ROOT.'/photo/gallery/large/'.$fetch_ImgDtls['imagepath']);

                    if(is_file($MEDIA_FILES_ROOT.'/photo/gallery/thumb/'.$fetch_ImgDtls['imagepath']) && $fetch_ImgDtls['imagepath'])
                        @unlink($MEDI_FILES_ROOT.'/photo/gallery/thumb/'.$fetch_ImgDtls['imagepath']);
                    
                    $obj -> deleteGalleryByid($fetch_ImgDtls['id']);
                }		
				
				subPageDelete($subData[$i]['categoryId'],$obj);
                $obj -> deleteMenuBycategoryId($subData[$i]['categoryId']);
			}
		}	
	}
	
	$idToDelete = explode("@", $id);
	
	foreach($idToDelete as $val)
	{
        $obj -> deleteContentBymenucategoryId($val);
        $sel_ImgDtls = $obj->galleryBymenucategoryId($val);

        foreach($sel_ImgDtls as $fetch_ImgDtls)
        {					
            if(is_file($MEDI_FILES_ROOT.'/photo/gallery/normal/'.$fetch_ImgDtls['imagepath']) && $fetch_ImgDtls['imagepath'])
            @unlink($MEDI_FILES_ROOT.'/photo/gallery/normal/'.$fetch_ImgDtls['imagepath']);

            if(is_file($MEDI_FILES_ROOT.'/photo/gallery/large/'.$fetch_ImgDtls['imagepath']) && $fetch_ImgDtls['imagepath'])
            @unlink($MEDI_FILES_ROOT.'/photo/gallery/large/'.$fetch_ImgDtls['imagepath']);

            if(is_file($MEDI_FILES_ROOT.'/photo/gallery/thumb/'.$fetch_ImgDtls['imagepath']) && $fetch_ImgDtls['imagepath'])
            @unlink($MEDI_FILES_ROOT.'/photo/gallery/thumb/'.$fetch_ImgDtls['imagepath']);

            $obj -> deleteGalleryByid($fetch_ImgDtls['id']);
        }				
		
		subPageDelete($val,$obj);			
		
		$obj -> deleteMenuByparentId($val);
        $obj -> deleteMenuBycategoryId($val);
	}

	echo 'Operation Successfull. Please refresh the browser or press F5.';
	
	$decodedStr = base64_decode($redstr);
	?>
	<script language="javascript">		
		window.location = '<?php echo $SITE_LOC_PATH;?>/admin/index.php?pageType=sitepage&type=Pages&moduleId=<?php echo $moduleId;?>&parentId=<?php echo $parentId;?>';
	</script>
	<?php 
}
if($confirm=='NO')
{
	echo 'Operation denied. Please refresh the browser or press F5.';
	?>
    <script language="javascript">		
		window.location = '<?php echo $SITE_LOC_PATH;?>/admin/index.php?pageType=sitepage&type=Pages&moduleId=<?php echo $moduleId;?>&parentId=<?php echo $parentId;?>';
	</script>
    <?php
}

if($action=='banner')
{
	if($id!='')
	{	
        $menuObj = new MenuCategory;
		$fetch_Existing_Lg = $menuObj->categoryById($id);		
		if($fetch_Existing_Lg['imagepath'])
			@unlink($MEDIA_FILES_ROOT.'/menu/normal/'.$fetch_Existing_Lg['imagepath']);			
        $params = array();
        $params['categoryImage'] = '';
        $menuObj->categoryUpdateBycategoryId($params, $id);
	}
    $decodedStr = base64_decode($redstr);
    ?><script language="javascript">window.location = 'index.php?<?php echo $decodedStr?>';</script><?php
}
?>