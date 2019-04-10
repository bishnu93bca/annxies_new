<ul id="breadcrumb">
    <li><a href="#">User <span>→</span></a></li>
    <li><a href="#">User Management</a></li>
    <li><div class="button_box"><a href="javascript:void(0)" onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add'">Add New</a></div></li>
</ul>
<?php
if($_SESSION['ErrMsg'])
{
	echo $_SESSION['ErrMsg'];
	$_SESSION['ErrMsg']='';
}
?>
<form action="" name="myForm" method="POST">
	<div class="table">
        <ul class="table_head">
            <li class="sl">Sl. No.</li>
            <li class="u_name">User</li>
            <li class="t_days">Website</li>
            <li class="last_li"></li>
        </ul>
		<ul class="table_elem">		
			<?php
			$obj = new user();	
			$sel_Details = $obj -> user_details(0, 50);	

			if($sel_Details)
			{
				$slNo = 1;
				foreach($sel_Details as $fetch_Details)
				{
					if($fetch_Details['status'] == 'Y')
					{
						$conStatus = '<img src="images/active.png" alt="active" width="15" border="0" />';
						$status="N";
					}
					else
					{
						$conStatus = '<img src="images/inactive.png" alt="inactive" width="15" border="0" />';
						$status="Y";
					}
					$siteData = $obj -> getSiteBysiteId($fetch_Details['siteId'],$Link);
					?>
					<li>
                        <span class="sl"><?php echo $slNo;?></span>
                        <span class="u_name"><a title="Edit" href="index.php?pageType=<?php echo $pageType;?>&dtaction=add&editid=<?php echo $fetch_Details['id'];?>"><?php echo $fetch_Details['username'];?></a></span>
                        <span class="t_days"><a href="<?php echo $siteData['siteUrl'];?>" target="_blank" title="<?php echo $siteData['siteUrl'];?>"><?php echo $siteData['siteName'];?></a></span>						  
                       
                        <?php /*<span class="sl"><a href="index.php?pageType=<?php echo $pageType;?>&dtaction=themeallocation&editid=<?php echo $fetch_Details['id'];?>&siteId=<?php echo $fetch_Details['siteId'];?>&userId=<?php echo $fetch_Details['id'];?>"><img src="images/edittheme.png" alt="theme" width="16" height="16" border="0" /></a></span>*/?>
                        <span class="last_li">
                            <a href="index.php?pageType=<?php echo $pageType;?>&dtaction=modulepermissions&editid=<?php echo $fetch_Details['id'];?>&siteId=<?php echo $fetch_Details['siteId'];?>&userId=<?php echo $fetch_Details['id'];?>"><img src="images/access.png" alt="access" width="16" height="16" border="0" /></a>
                            <a title="Edit" href="index.php?pageType=<?php echo $pageType;?>&dtaction=add&editid=<?php echo $fetch_Details['id'];?>"><img src="images/edit.gif" alt="" width="16" height="16" border="0" /></a>
                            <a title="Change Status" href="index.php?pageType=<?php echo $pageType;?>&dtaction=status&stschgto=<?php echo $status?>&id=<?php echo $fetch_Details['id'];?>&siteId=<?php echo $fetch_Details['siteId'];?>" class="ask"><?php echo $conStatus;?></a>  
						</span>
					</li>
					<?php
					$slNo++;
				}
			}
			else
			{
				?>
				<li style="text-align:center; line-height:30px;">No Record Present</li>
				<?php
			}
			?>
		</ul>
	</div>	
</form>