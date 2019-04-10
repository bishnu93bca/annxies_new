<?php
if($editid!='')
{
    $gcObj = new GalleryClass;
    $fetch_details = $gcObj->galleryByid($editid);
	$IdToEdit = $editid;
	$menucategoryId = $fetch_details['menucategoryId'];
	$galleryCategoryId = $fetch_details['galleryCategoryId'];
	$BannerName = $fetch_details['bannername'];
	$BannerDescription = $fetch_details['bannerdescription'];
	$BannerType = $fetch_details['bannertype'];
	$swapno = $fetch_details['swapno'];	
	$ExtraForStr = '&editid='.$editid;
}
else
    $ExtraForStr = '';

$menu=new menu();
$menudata= $menu -> menu_by_id($moduleId);
if($menudata)
{
	$menu_image = $menudata['menu_image'];
	$menu_name = $menudata['menu_name'];	
	$parentMenuId = $menudata['parent_id'];
	$parentmenudata= $menu -> menu_by_id($parentMenuId);	
	$parent_menu_name = $parentmenudata['menu_name'];
}
?>
<ul id="breadcrumb">
	 <li><a href="#"><?php if($editid){ echo "Edit - ";} else { echo "Add - ";} echo $menu_name;?> - <?php echo $parent_menu_name;?></a></li>
</ul>
<section id="form">
<div class="clear"></div>
<?php echo $ErrMsg?>
<form name="modifycontent" action="" method="post" enctype="multipart/form-data">
	<div class="form_holder">	
        <div class="description-line">		
			<span class="description-line-text">
                Heading 
			    <input name="BannerName" type="text" class="input2" value="<?php echo $BannerName;?>"  size="70" maxlength="100" />
			</span>
		</div>
        
		<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />							  
		<p class="description-line-text">
            <?php
            if($editid!='') 
                echo 'Edit Banner (Image should be 540px x 340px) <input type="file" class="input2" name="ImageName" />';
            else
            {
                echo 'Upload Banner (Image should be 540px x 340px and Press Ctrl for Multiple image)';
                echo '<input type="file" class="input2" name="imageName[]" multiple/>';
            }
            ?>
		</p>		
		<p class="description-line-text">
            <?php
            if($editid!='')
            {			
                $target_path_large = '../uploadedfiles/photo/gallery/thumb/'.$fetch_details['imagepath'];			
                if(file_exists($target_path_large))
                {
                    if($type=='home-header')
                    {
                        $LARGE_WIDTH = HEADER_LARGE_WIDTH;
                        $LARGE_HEIGHT = HEADER_LARGE_HEIGHT;

                        $CROP_WIDTH = HEADER_CROP_WIDTH;
                        $CROP_HEIGHT = HEADER_CROP_HEIGHT;
                    }
                    elseif($type=='banner')
                    {
                        $LARGE_WIDTH = BANNER_LARGE_WIDTH;
                        $LARGE_HEIGHT = BANNER_LARGE_HEIGHT;

                        $CROP_WIDTH = BANNER_CROP_WIDTH;
                        $CROP_HEIGHT = BANNER_CROP_HEIGHT;
                    }	
                    elseif($type=='inside-header')
                    {
                        $LARGE_WIDTH = INSIDE_LARGE_WIDTH;
                        $LARGE_HEIGHT = INSIDE_LARGE_HEIGHT;

                        $CROP_WIDTH = INSIDE_CROP_WIDTH;
                        $CROP_HEIGHT = INSIDE_CROP_HEIGHT;
                    }
                    elseif($type=='background')
                    {
                        $LARGE_WIDTH = BACKGROUND_LARGE_WIDTH;
                        $LARGE_HEIGHT = BACKGROUND_LARGE_HEIGHT;

                        $CROP_WIDTH = BACKGROUND_CROP_WIDTH;
                        $CROP_HEIGHT = BACKGROUND_CROP_HEIGHT;
                    }
                    elseif($type=='partners')
                    {
                        $LARGE_WIDTH = PARTNER_LARGE_WIDTH;
                        $LARGE_HEIGHT = PARTNER_LARGE_HEIGHT;

                        $CROP_WIDTH = PARTNER_THUMB_WIDTH;
                        $CROP_HEIGHT = PARTNER_THUMB_HEIGHT;
                    }
                    elseif($type=='social-network')
                    {
                        $LARGE_WIDTH = SOCIAL_NETWORK_WIDTH;
                        $LARGE_HEIGHT = SOCIAL_NETWORK_HEIGHT;

                        $CROP_WIDTH = SOCIAL_NETWORK_WIDTH;
                        $CROP_HEIGHT = SOCIAL_NETWORK_HEIGHT;
                    }
                    echo '<br class="clear"><img src="'.$target_path_large.'" border="0" style="max-width:100%; border:1px solid;" alt="Image"  />';
                    //echo '<div class="clear"></div><a href="'.$SITE_LOC_PATH.'/admin/crop/index.php?img='.$fetch_details['imagepath'].'&w='.$CROP_WIDTH.'&h='.$CROP_HEIGHT.'&iframe=true&width=1800&height=800" rel="prettyPhoto">Edit Thumbnail</a>';			
                }
            }
            ?>
		</p>
        <div class="clear"></div>
	</div>	
	<div class="iconbox">		
		<p  class="description-line1">		
			<span class="save_button-box">			
			<input name="IdToEdit" type="hidden" value="<?php echo $IdToEdit;?>" />
			<input name="galleryCategoryId" type="hidden" value="<?php echo $moduleId;?>" />
			<input name="type" type="hidden" value="<?php echo $type;?>" />
			<input name="BannerBack" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
			<input name="BannerSave" type="submit" class="save_frm" value="Save" />
			<input name="BannerCancel" type="button"  onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&type=<?php echo $type;?>&moduleId=<?php echo $moduleId;?>'" class="cancel_frm" value="Close" />
			<input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
			</span>		
		</p>
	</div>
</form>