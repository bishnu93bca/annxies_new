<?php
if($type!='home-header')
	unset($_SESSION['temp']);
?>
</div>
<div class="footer1">
    &copy; <?php echo date('Y');?> by <a href="<?php echo $SITE_LOC_PATH;?>" target="_blank" class="company"><?php echo SITE_NAME;?>.</a> All Rights Reserved.
    <?php echo DEVELOPED_BY;?>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".form_holder a[rel^='prettyPhoto']").prettyPhoto();
	});
</script>
</body>
</html>