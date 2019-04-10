<?php
$obj=new Content();
$mdata = $obj->categoryById($editid);
$categoryType = $mdata['categoryType'];
$parentId = $mdata['categoryId'];
$smData = $obj->cmsCategoryByparentId($parentId);	
include("includes/pagebreadcrumb.php");
if($smData)
{
	?>
	<div class="form_holder">
		<div class="button_box">
			<form name="subPage" action="" method="post">
				<strong style="font-weight:bold;">Go to Sub Page under <?php echo $mdata['categoryName'];?></strong> 
				<select name="editid" onchange="subPage.submit()">
					<option value="">Select</option>
					<?php
					for($sm=0;$sm<sizeof($smData);$sm++)
					{
						echo '<option value="'.$smData[$sm]['categoryId'].'">'.$smData[$sm]['categoryName'].'</option>';
					}
					?>
				</select>
			</form>
		</div>
	</div>
	<?php
}
if($mdata['isContent']=='Y')
{
	?>
	<script type="text/javascript">
	function show()
	{
		document.getElementById('newContent').style.display = 'block'; 
	}
	</script>	
	<?php
	if($_SESSION['ErrMsg'])
	{
		echo $_SESSION['ErrMsg'];	
		$_SESSION['ErrMsg']='';
	}
	
    if($contentID)
        include("articleview.php");	
    elseif($categoryType=='List View')
        include("listview.php"); 		// Content List
    else	
        include("articleview.php");	// Content View/Edit		
		
    include("new.php"); // New Content Form
}
//include("gallery.php");
?>