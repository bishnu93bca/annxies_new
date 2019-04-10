<?php
if($_SESSION['msg-show']=='Y')
{
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="thank_u text-center">
				<h1 class="up_c wm f26 heading">Thank you for your interest.</h1>
				<i class="fa fa-check"></i>
				<p class="grn">Your comments has been sent to administrator for approval.</p>
			</div>
		</div>
	</div>
	<?php 
    $_SESSION['msg-show']='';
}
else
    $siteObj->redirectToURL($SITE_LOC_PATH);
?>