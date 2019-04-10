<p class="description-line1">Banner Image <input type="file" name="ImageName" /></p>	

<?php
if($editid)
{
	$mObj = new MenuCategory();
	$mData =$obj->categoryById($editid);
	$categoryImage = $mData['categoryImage'];
	if($categoryImage && file_exists($MEDIA_FILES_ROOT.'/menu/thumb/'.$categoryImage))
	{
		echo '<img src="'.$MEDIA_FILES_SRC.'/menu/thumb/'.$categoryImage.'" style="max-widt:976px;" /><div class="clear"></div>';
		echo '<a href="index.php?pageType='.$pageType.'&dtaction=delete&id='.$editid.'&action=banner&redstr='.$redirectString.'" class="ask">Delete Banner</a>';
	}
}
?>