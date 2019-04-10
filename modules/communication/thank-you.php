<?php
if($_SESSION['msg-show']=='Y')
{
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="thank_u text-center">
                <h2 class="heading">
                    <span class="hbox">
                        <span>Thank you</span> for your interest.
                    </span>
                </h2>
				<i class="fa fa-check"></i>
				<p class="grn">Your comment has been posted successfully.</p>
			</div>
		</div>
	</div>
	<?php 
    $_SESSION['msg-show']='';
}
else
    $siteObj->redirectToURL($SITE_LOC_PATH);
?>