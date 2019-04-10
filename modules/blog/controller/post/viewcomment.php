<?php
$ShowInOnePage = 'No';

$obj = new PostClass();
/**************************************************************
Paging Variable Started
***************************************************************/
/*$p = new Pager;	
if(empty($_SESSION['pageLimit']))
	$_SESSION['pageLimit'] = VALUE_PER_PAGE;

if(!empty($pageLimit)) {
	$_SESSION['pageLimit']=$pageLimit;}

$limit=$_SESSION['pageLimit'];

$start = $p->findStart($limit);
if(!$page)
$page=1;*/

/**************************************************************
Paging Variable Ended
***************************************************************/
$ExtraQryStr = "1";

$objpost = new PostClass();
$select_Details = $objpost -> article_details($ExtraQryStr,$_SESSION['SITE_ID'],$Link);

$menu=new menu();
$menudata= $menu -> menu_by_id($_REQUEST['moduleId'],$Link);
if($menudata)
{
	$menu_image = $menudata['menu_image'];
	$menu_name = $menudata['menu_name'];
	
	$parentMenuId = $menudata['parent_id'];
	$parentmenudata= $menu -> menu_by_id($parentMenuId,$Link);
	
	$parent_menu_name = $parentmenudata['menu_name'];
}

?>
<script language="javascript">
function article()
{
	var article = document.getElementById("articlename").options[document.getElementById("articlename").selectedIndex].value;
	if(article!='')
	{
		window.location = 'index.php?pageType=<?php echo $pageType;?>&dtls=post&dtaction=viewcomment&moduleId=<?php echo $_REQUEST['moduleId'];?>&editid='+article;
	}
	else
	{
		window.location = 'index.php?pageType=<?php echo $pageType;?>&dtls=comment&moduleId=113';
	}
}
</script>
<div class="iconbox">
	<span style="float:left; width:48px; margin:0px 15px 0px 0px;"><?php if($menu_image!=''){?><img src="../uploadedfiles/menu/<?php echo $menu_image;?>" height="39" /><?php } else {?><img src="../uploadedfiles/menu/defaultmenu.png" height="39" /><?php } ?></span>
	<h2 style="float:left; margin:0px; padding:10px 0px 0px 0px; font-size:14px; color:#0066FF;"><?php echo $menu_name;?> - <?php echo $parent_menu_name;?></h2>
	<div class="button_box">
	<select id="articlename" name="articlename" onchange="article();">
		<option value="" selected="selected">All</option>
		<?php 
		if(mysql_num_rows($select_Details)>0)
		{
			while($article_Details = mysql_fetch_array($select_Details))
			{
				$blogId = $article_Details['blogId'];
		?>
		<option value="<?php echo $article_Details['blogId'];?>" <?php if($editid==$blogId){?> selected="selected"<?php } ?>><?php echo $article_Details['blogTitle'];?></option>
		<?php } }?>
	</select>
	</div>
</div>
<?php 
if($_SESSION['ErrMsg'])
{
	echo $_SESSION['ErrMsg'];
	unset($_SESSION['ErrMsg']);
} ?>
<form action="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>" name="myForm" method="POST">
	 <div class="iconbox">
		<table id="rounded-corner">
		<thead>
			<tr>
				<th scope="col" class="rounded-company">Sl No.</th>				
				<th scope="col" class="rounded">Title</th>
				<th scope="col" class="rounded">Description</th>
				<th scope="col" class="rounded-q4">Edit</th>
				<th scope="col" class="rounded">Status</th>
				<th scope="col" class="rounded-q4">Delete</th>
				<th scope="col" class="rounded-q4">Select</th>
			</tr>
		</thead>
		<tfoot>
			<tr>				
				<td colspan="11" class="rounded-foot-right" style="text-align:right">
					<?php
					$fetch_Details = $obj->getComment($ExtraQryStr,$_SESSION['SITE_ID'],$Link,$_REQUEST['editid']);
					if(sizeof($fetch_Details)>0)
						include("includes/pageaction.php");
					?>
				</td>
			</tr>
		</tfoot>
		<tbody>	
			<?php			
			//$count = $obj -> postCount($ExtraQryStr,$siteId,$Link);
			
			
			if(sizeof($fetch_Details)>0)
			{
				if($page>1)
				$slNo = (($page - 1)*$limit)+1;
				else
				$slNo = 1;
				
				$i=1;
				for($row=0; $row<sizeof($fetch_Details); $row++)
				{
					if($i%2)
					$class = 'nortxt_even';
					else
					$class = 'nortxt_odd';
					
					if($fetch_Details[$row]['status'] == 'Y')
					{
						$conStatus = '<span class="success"><img src="images/active.png" alt="Active" width="15" border="0" /></span>';
						$status="N";
					}
					else
					{
						$conStatus = '<span class="warning"><img src="images/inactive.png" alt="Inactive" width="15" border="0" /></span>';
						$status="Y";
					}							
					?>
					<tr>
					  <td><?php echo $slNo;?></td>					  
					  <td><?php echo $fetch_Details[$row]['blogTitle'];?></td>
					  <td><?php echo strip_tags(substr($fetch_Details[$row]['blogContent'],0,200));?></td>
					  <td align="center" valign="middle"><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $fetch_Details[$row]['blogId'];?>&page=<?php echo $page; ?>"><img src="images/edit.gif" alt="" width="16" height="16" border="0" /></a></td>
					   <td align="center"><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $status?>&id=<?php echo $fetch_Details[$row]['blogId'];?>&page=<?php echo $page; ?>"><?php echo $conStatus;?></a></td>
					  <td align="center" valign="middle"><a href="index.php?pageType=<?php echo $pageType;?>&amp;dtls=<?php echo $dtls;?>&amp;dtaction=delete&amp;id=<?php echo $fetch_Details[$row]['blogId'];?>" class="ask"><img src="images/trash.png" alt="trash"  border="0" /></a></td>
					  <td align="center" valign="middle"><input type="checkbox" id="deleteid" name="deleteid" value="<?php echo $fetch_Details[$row]['blogId'];?>" /></td>
					  
					</tr>
					<?php
					$i++;
					$slNo++;
				}
			}
			else
			{
				?>
				<tr>
				  <td align="center" valign="middle" colspan="10">No Record Present</td>
				</tr>
				<?php
			}
			?>
		</tbody>			
		</table>		
	</div>		
</form>