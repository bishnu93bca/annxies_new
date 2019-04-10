<?php
$obj    = new GalleryClass();
$mobj   = new MenuCategory();
if($editid!='')
{
	$fetch_details     = $obj->galleryByid($editid);
	$IdToEdit          = $editid;	
	$menucategoryId    = $fetch_details['menucategoryId'];
	$galleryCategoryId = $fetch_details['galleryCategoryId'];
	$BannerName        = htmlspecialchars($fetch_details['bannername']);
	$BannerDescription = $fetch_details['bannerdescription'];
	$BannerType        = $fetch_details['bannertype'];
	$BannerURL         = $fetch_details['redirecturl'];
	$swapno            = $fetch_details['swapno'];	
	$ExtraForStr       = '&editid='.$editid;
}
else
$ExtraForStr = '';
$menu=new menu();
$parentmenudata= $menu -> menu_by_id(1);
$parent_menu_name = $parentmenudata['menu_name'];
$menu_image = $parentmenudata['menu_image'];
?>
<ul id="breadcrumb">
	<li><?php if($editid!='') echo 'Edit - Photo'; else echo 'Add Photo(s)'; ?> - <?php echo $parent_menu_name;?></li>
</ul>
<?php 
if($_SESSION['rltGalleryMsg'])
{
	echo $_SESSION['rltGalleryMsg'];
	unset($_SESSION['rltGalleryMsg']);	
}
echo $ErrMsg;
?>
<form name="modifycontent" action="" method="post" enctype="multipart/form-data">
	<div class="form_holder">	
		<!--<div class="description-line">		
			<span class="description-line-text">Want to relate with any other existing gallery? -->			
			<?php
			/*$extGalleryMenu = $obj -> getDistinctmenucategoryIdFromGallery($Link);			
			if($extGalleryMenu)
			{				
				echo '<select name="relatedGallerycategoryId">';
				echo '<option value="0">Select</option>';					 
				for($i=0; $i<sizeof($extGalleryMenu); $i++)
				{
					$categoryId =$extGalleryMenu[$i]['menucategoryId'];
					$mData = $mobj->categoryById($categoryId,$Link);						
					$categoryName=$mData['categoryName'];
					$parentId=$mData['parentId'];	
					$pRow=0;
					$parentNameArray='';
					$concatinateName='';															
					while($parentId!=0)
					{
						$name=$mobj -> categoryById($parentId,$Link);
						$parentId=$name['parentId'];
						$parentNameArray[$pRow] =$name['categoryName'];	
						$pRow++;							
					}						
												
					if($parentNameArray!='')
					{
						$parentNameArray=array_reverse($parentNameArray);						
						for($pna=0;$pna<sizeof($parentNameArray);$pna++)
							$concatinateName .=$parentNameArray[$pna].' > ';							
						$categoryName=$concatinateName.$categoryName;									
					}					
					if($extGalleryMenu[$i]['menucategoryId']==$relatedGallerycategoryId)
						$selected = 'selected';
					else
						$selected = '';
					if($menucategoryId!=$extGalleryMenu[$i]['menucategoryId'])
						echo '<option value="'.$extGalleryMenu[$i]['menucategoryId'].'" '.$selected.'>'.$categoryName.'</option>';
				}				
				echo '</select>';
			}
			else
				echo 'No records found.';*/
			?>			
			<!--</span>			
		</div>-->							
		<div class="description-line">		
			<span class="description-line-text">Description [max 100 charecters]*<input name="BannerName" type="text" class="input2" value="<?php echo $BannerName;?>"  size="70" maxlength="100" /></span>		
		</div>		
		<?php /*?><p class="description-line1">Description</p>		
		<p class="description-line1">
        	<textarea name="BannerDescription" style="width:600px;"><?php echo strip_tags($BannerDescription);?></textarea>									
			
		</p><?php */?>
		<!-- <input type="hidden" name="BannerType" value="<?php //echo $dtls?>">-->							  
		<p class="description-line1">Upload Image</p>
		<p class="description-line1">
			<?php 
            if($editid!='') 
                echo '<input type="file" class="input2" name="ImageName" />';
            else
                include("uploadify-multi.php");													
            ?>
		</p>		
		<?php
		if($editid!='')
		{			
			$target_path_large = '../uploadedfiles/photo/gallery/thumb/'.$fetch_details['imagepath'];			
			if(file_exists($target_path_large))
			echo '<p class="description-line1"><a href="../uploadedfiles/photo/gallery/large/'.$fetch_details['imagepath'].'" class="preview"><img src="'.$target_path_large.'" style="max-height:80; max-width:100; border:2px solid #333333;" height="80" alt="Image"  /></a>';
			?>
            <br class="clear">
            <a href="javascript:void(0)" onclick="newPopup('crop/index.php?img=<?php echo $fetch_details['imagepath'];?>&w=101&h=62&imgSrc=<?php echo base64_encode('uploadedfiles/photo/gallery');?>&redstr=<?php echo $redstr;?>')"><img src="images/edit.gif" alt="edit" border="0" />Edit Thumbnail</a>
            <?php
			echo '</p>';	
		}
		?>						
		<input type="hidden" name="GeneralImage" value="Y" />        	
		<?php /*?><p class="description-line1">URL</p>
		<p class="description-line1"><input name="BannerURL" type="text" class="input2" value="<?php echo $BannerURL;?>" /></p>       
        <p class="description-line1">Swap No</p>
		<p class="description-line1"><input name="swapno" type="text" class="input2" id="swapno" value="<?php echo $swapno;?>" style="width:40px;"/></p><?php */?> 
	</div>	
	<div class="iconbox">		
		<p  class="description-line1">		
			<span class="save_button-box">			
                <input name="IdToEdit" type="hidden" value="<?php echo $IdToEdit;?>" />
                <input name="menucategoryId" type="hidden" value="<?php echo $menucategoryId;?>" />
                <input name="BannerBack" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
                <input name="BannerSave" type="submit" class="save_frm"  value="Save" />
                <input name="BannerCancel" type="button"  onclick="window.location.href='index.php'" class="save_frm" value="Close" />	
                <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">		
			</span>			
		</p>
	</div>
</form>