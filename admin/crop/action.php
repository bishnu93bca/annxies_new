<?php
include("../../include.php");
include("../../lib/includes/dimensions.php");

$src = '../../'.$imgSrc.'/large/'.$_POST['imgName'];
$dst_sml = '../../'.$imgSrc.'/small/'.$_POST['imgName'];
$dst_thb = '../../'.$imgSrc.'/thumb/'.$_POST['imgName'];

if($_POST['w']>0)
{

	$cropped = resizeThumbnailImage($dst_sml, $src, $_POST['w'] , $_POST['h'],$_POST['x'],$_POST['y'],1);
	@unlink('../../'.$imgSrc.'/thumb/'.$_POST['imgName']);
	$ImageCreate = create_resize($dst_sml, '../../'.$imgSrc.'/thumb/', $_POST['imgName'], GALLERY_THUMB_WIDTH, GALLERY_THUMB_HEIGHT);
	@unlink('../../'.$imgSrc.'/small/'.$_POST['imgName']);
	
	// If not a POST request, display page below:
}
?>
<div style="text-align:center" >
<img src="<?php echo $dst_thb;?>" alt="Thumbnail" style="border:2px solid #333333;" /><br /><br />

<input type="button" onclick="history.back(-1);" value="Crop Again"/>

<input type="button" onclick="window.close()" value="Close"/><br />

Close this page and press CTRL+F5 to view the cropped image.

</div>