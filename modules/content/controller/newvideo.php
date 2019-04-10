<?php



$obj=new GalleryClass();



$mobj = new MenuCategory();



//$mData = $mobj->categoryById($menucategoryId,$Link);



if($editid!='')



{



	$sel_details = mysql_query("select * from ".TBL_GALLERY." where id = $editid");



	$fetch_details = mysql_fetch_array($sel_details);



	$IdToEdit = $editid;



	



	$menucategoryId = $fetch_details['menucategoryId'];







	//$relatedGallerycategoryId =$mData['relatedGallerycategoryId'];



	



	$galleryCategoryId = $fetch_details['galleryCategoryId'];



	$BannerName = $fetch_details['bannername'];



	$BannerDescription = $fetch_details['bannerdescription'];



	$BannerType = $fetch_details['bannertype'];



	$BannerURL = $fetch_details['redirecturl'];



	$swapno = $fetch_details['swapno'];	



	$ExtraForStr = '&editid='.$editid;



}



else



$ExtraForStr = '';



$menu=new menu();

$parentmenudata= $menu -> menu_by_id(1,$Link);

$parent_menu_name = $parentmenudata['menu_name'];

$menu_image = $parentmenudata['menu_image'];

?>

<div class="iconbox">

	<span class="description-icon"><img src="../uploadedfiles/menu/<?php echo $menu_image;?>" width="48" height="38" /></span>

	<h2 class="description-text"><?php if($editid!='') echo 'Edit - Audio / Video'; else echo 'Add Audio / Video'; ?> - <?php echo $parent_menu_name;?></h2>

</div>



<form name="modifycontent" action="" method="post" enctype="multipart/form-data">







	<div class="form_holder">



							



		<div class="description-line">



		



			<span class="description-line-text">Heading *<input name="BannerName" type="text" class="input2" value="<?php echo $BannerName;?>"  size="70" maxlength="100" /></span>



			



		</div>



		



		<p class="description-line1">Description</p>



		



		<p class="description-line1">



									



			<?php



			// Create class instance.



			$CKEditor = new CKEditor();



			



			// Do not print the code directly to the browser, return it instead



			$CKEditor->returnOutput = true;



			



			// Path to CKEditor directory, ideally instead of relative dir, use an absolute path:



			//   $CKEditor->basePath = '/ckeditor/'



			// If not set, CKEditor will try to detect the correct path.



			$CKEditor->basePath = '../ckeditor/';



			



			// Set global configuration (will be used by all instances of CKEditor).



			$CKEditor->config['width'] = 650;



			



			// Change default textarea attributes



			$CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);



			



			// Configuration that will be used only by the second editor.



			$config['toolbar'] = array(



				array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike' ),



				array( 'Image', 'Link', 'Unlink', 'Anchor' )



			);



			



			$config['skin'] = 'v2';



			



			// Create first instance.



			$code = $CKEditor->editor("BannerDescription", $BannerDescription, $config);



			



			echo $code;



			?>



		</p>



		



<!--		<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
-->


        <div class="videoUploadBox">



          <?php /*?><p>Upload  File:</p>



          <p><input type="file" class="input2" size="50" name="ImageName" /></p>
<?php */?>


          



          <p>Upload Thumbnail Image:</p>



          <p><input type="file" class="input2" size="50" name="ThumbName" /></p>



          <p>



            <?php



		if($editid!='')



		{



			



			$target_path_large = '../uploadedfiles/photo/gallery/thumb/'.$fetch_details['thumbpath'];



			



			if(file_exists($target_path_large))



			echo '<p>Current Thumbnail Image:</p><p><img src="'.$target_path_large.'" border="0" style="max-height:80; max-width:100;" height="80" alt="Image"  /></p>';



			



		}



		?>



          </p>



          



          <input type="hidden" name="GeneralImage" value="Y" />



          



          <p> Embed URL:</p>



          <p><input name="BannerURL" type="text" class="input2" size="60" value="<?php echo $BannerURL;?>" /></p>



          



          <p>Order No:</p>



          <p><input name="swapno" type="text" class="input2" id="swapno" value="<?php echo $swapno;?>" size="3"/></p>



        </div><!-- end of .videoUploadBox -->







	




</div>


		
<div>


		<p  class="description-line1">



		



			<span class="save_button-box">



			



			<input name="IdToEdit" type="hidden" value="<?php echo $IdToEdit;?>" />



			<input name="menucategoryId" type="hidden" value="<?php echo $menucategoryId;?>" />



			<input name="VideoBack" type="button" onclick="history.back(-1);" class="cancel_frm" value="Back" />



			<input name="VideoSave" type="submit"  value="Save" />



			<input name="VideoCancel" type="button"  onclick="location.href='index.php'" class="cancel_frm" value="Close" />



			



			</span>



			



		</p>



</div>







</form>



