<?php
	$redirectString = base64_encode($_SERVER['QUERY_STRING']);
?>
<select name="ActionTo" id="ActionTo" onChange="deleteAction(this.value,'galleryForm','<?php echo $redirectString;?>','gallery','<?php echo $pageType;?>','<?php echo $dtls;?>');">
	<option value="">Select Option</option>
	<?php if($_SESSION['DELETE_ACCESS'] == 'Yes' || $_SESSION['UNAME'] == 'Super Administrator') { ?>
		<?php if($pageType != 'contentmanagement' || $dtls != 'general') { ?>
			<option value="Delete">Delete</option>
		<?php } ?>
	<?php } ?>
	<option value="Y">Active</option>
	<option value="N">Inactive</option>
	<option value="CheckAll">Check All</option>
	<option value="UncheckAll">Uncheck All</option>
</select>
