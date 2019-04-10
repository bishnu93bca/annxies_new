<?php
include("../../include.php");
include("../../lib/includes/dimensions.php");
?>
<html>
	<head>
		<script src="<?php echo $SITE_LOC_PATH;?>/admin/crop/js/jquery.min.js"></script>
		<script src="<?php echo $SITE_LOC_PATH;?>/admin/crop/js/jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="<?php echo $SITE_LOC_PATH;?>/admin/crop/css/jquery.Jcrop.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $SITE_LOC_PATH;?>/admin/crop/css/style.css">
		<script language="Javascript">
			// Remember to invoke within jQuery(window).load(...)
			// If you don't, Jcrop may not initialize properly
			jQuery(window).load(function(){	
				jQuery('#cropbox').Jcrop({
					onChange: showPreview,
					onSelect: showPreview,
					aspectRatio: <?php echo ($_REQUEST['w']/$_REQUEST['h']);?>
				});
			});
			// Our simple event handler, called from onChange and onSelect
			// event handlers, as per the Jcrop invocation above
			function showPreview(coords)
			{ 
				if (parseInt(coords.w) > 0)
				{
					var rx = <?php echo $_REQUEST['w'];?> / coords.w;

					var ry = <?php echo $_REQUEST['w'];?> / coords.h;

					jQuery('#preview').css({
						width: Math.round(rx * 500) + 'px',
						height: Math.round(ry * 370) + 'px',
						marginLeft: '-' + Math.round(rx * coords.x) + 'px',
						marginTop: '-' + Math.round(ry * coords.y) + 'px'
					});					

					jQuery('#cropbox').Jcrop({
						onChange: showCoords,
						onSelect: showCoords
					});
				}
			}			

			function showCoords(c)
			{ 
				jQuery('#x').val(c.x);
				jQuery('#y').val(c.y);
				jQuery('#x2').val(c.x2);
				jQuery('#y2').val(c.y2);
				jQuery('#w').val(c.w);
				jQuery('#h').val(c.h);
			};
		</script>        
	</head>
	<body style="background:none;">
		<div id="outer">
			<div class="jcExample">
				<div class="article">
				<p class="description-line1">Select Area to Create Thumbnail</p>                
                	<?php
					$imgSrc = base64_decode($imgSrc);
					?>	
					<img src="../../<?php echo $imgSrc;?>" id="cropbox" style="border:2px solid #333333;"/>					
					<br />
					<form action="action.php" method="post">
						<input type="hidden" size="4" id="x" name="x" />
						<input type="hidden" size="4" id="y" name="y" />
						<input type="hidden" size="4" id="x2" name="x2" />
						<input type="hidden" size="4" id="y2" name="y2" />
						<input type="hidden" size="4" id="w" name="w" />
						<input type="hidden" size="4" id="h" name="h" />
						<input type="hidden" name="imgName" value="<?php echo $_REQUEST['img'];?>" />                        
                        <input type="hidden" name="imgSrc" value="<?php echo $imgSrc;?>" />
                        <input type="hidden" name="redstr" value="<?php echo $_REQUEST['redstr'];?>" />
						<input type="submit" value="Crop" />
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
