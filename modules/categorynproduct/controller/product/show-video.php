<?php
$ShowInOnePage = 'No';
$ExtraQryStr = "1";
$menu=new menu();
$menudata= $menu -> menu_by_id($_REQUEST['moduleId']);
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

    <li><a href="#"><?php echo $menu_name;?><span>→</span></a></li>

    <li><a href="#"><?php echo $parent_menu_name;?><span>→</span></a></li>

    <li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $_REQUEST['moduleId'];?>'">Add New</a></div></li>

</ul>

<?php  echo $ErrMsg;?>
<form name="modifycontent" action="" method="post" enctype="multipart/form-data">
<div class="form_holder">
<input type="hidden" name="vedioproductId" value="<?php echo $id; ?>" />
	<p class="description-line1">Video Link *</p>
	<p class="description-line1">
        <input type="text" name="videoLink">
    </p>
    </div>
		<input name="IdToEdit" type="hidden" class="save_frm"  value="<?php echo $IdToEdit;?>" />
		<input name="BannerBack" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
		<input name="ProductVideoSave" type="submit" class="save_frm" value="Save" />
		<input name="BannerCancel" type="button"  onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $_REQUEST['moduleId'];?>'" class="cancel_frm toast" value="Close" />
<div class="table">
        <ul class="table_head">
            <li class="sl">SlNo.</li>
				<li class="u_name">Videos</li>	
                <li class="last_li"></li>
        </ul>
        <ul class="table_elem">
			<?php
			$obj = new adminProductClass();
			$sel_Details = $obj -> getVideoByproId($id);
			if(sizeof($sel_Details)>0)
			{
				$slNo = 1;	
				for($row=0; $row<sizeof($sel_Details); $row++)
				{		
					if($i%2)
						$class = 'nortxt_even';
					else
						$class = 'nortxt_odd';
					if($sel_Details[$row]['status'] == 'Y')
					{
						$conStatus = '<img src="images/active.png" alt="active" width="15" border="0" />';
						$status="N";
					}
					else
					{
						$conStatus = '<img src="images/inactive.png" alt="inactive" width="15" border="0" />';
						$status="Y";
					}
					?>
					<li id="recordsArray_<?php echo $sel_Details[$row]['videoId'];?>">
					  <span class="sl"><?php echo $slNo;?></span>
					  <span class="u_name"><?php echo $sel_Details[$row]['videoLink'];?></span>
					  <span class="last_li"><a class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&action=proVid&stschgto=<?php echo $status?>&statusaction=yes&productId=<?php echo $id; ?>&id=<?php echo $sel_Details[$row]['videoId'];?>&redstr=<?php echo $redirectString;?>"><?php echo $conStatus;?></a>
					  <a class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&action=proVid&deleteaction=yes&id=<?php echo $sel_Details[$row]['videoId'];?>&redstr=<?php echo $redirectString;?>" class="ask"><img src="images/trash.png" alt="Delete" width="15" border="0" /></a>
					</span> 
                   </li>
					<?php
					$i++;
					$slNo++;
				}
			}
			else
			{
				?>
				 <li style="text-align:center; line-height:40px">
                 		No Record Present
				 </li>		

				<?php

			}

			?>
</form>

				  
