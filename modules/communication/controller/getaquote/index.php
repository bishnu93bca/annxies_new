<script type="text/javascript">
function show()
{
	document.getElementById('newContent').style.display = 'block'; 
}
</script>
<?php
$menu           = new menu();
$menudata       = $menu -> menu_by_id($moduleId);
if($menudata)
{
	$menu_image        = $menudata['menu_image'];
	$menu_name         = $menudata['menu_name'];
	$parentMenuId      = $menudata['parent_id'];
	$parentmenudata    = $menu -> menu_by_id($parentMenuId);
	$parent_menu_name  = $parentmenudata['menu_name'];
}
  $ExtraQryStr = "1";
if($_SESSION['ErrMsg'])
{
	echo $_SESSION['ErrMsg'];
	unset($_SESSION['ErrMsg']);
}?>

<div class="table">
	<ul class="table_head">
        <li class="sl">Sl.No.</li>
        <li class="u_name">Name</li>
        <li class="t_days">Email</li>
        <li class="t_present">Date-Time</li>
    </ul>
    <ul class="table_elem">
		<?php
        $obj = new Contact();
        $ExtraQryStr='contactType="Q"';						
        $sel_Details = $obj -> getContacts($ExtraQryStr);

		if($sel_Details)
		{
			$slNo = 1;
			foreach($sel_Details as $fetch_Details)
			{
				?>
				 <li>
					 <span class="sl"><?php echo $slNo;?></span>
                     <span class="u_name"><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $fetch_Details['contactID'];?>&moduleId=<?php echo $moduleId;?>"><?php echo substr($fetch_Details['name'],0,25);?></a></span>
					 <span class="t_days"><?php echo $fetch_Details['email'];?></span>
					 <span class="t_present"><?php echo $fetch_Details['contactEntrydate'];?></span>					
					 <span class="last_li">
						<a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $fetch_Details['contactID'];?>&moduleId=<?php echo $moduleId;?>"  title="view"><img src="images/view.png" alt="" width="16" height="16" border="0" /></a>
						<a class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&id=<?php echo $fetch_Details['contactID'];?>&redstr=<?php echo $redirectString;?>" title="delete"><img src="images/delete.png" alt="" width="16" height="16" border="0" /></a>
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
