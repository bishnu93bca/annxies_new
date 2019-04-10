<?php
include("includes/pagebreadcrumb.php");
$obj = new MenuCategory();
if(!$parentId)
    $ExtraQryStr = "parentId = 0";
else
    $ExtraQryStr = "parentId = $parentId";

if(isset($SearchForm) && $SearchForm == 'Search' && $searchcat != '-1')
{
	if($search!="Enter Search Text")
	$ExtraQryStr .= " and ".$searchcat." like '%".addslashes($search)."%'";
}
if(isset($status))
{
	if($status != "")
		$ExtraQryStr .= " and status='".$status."'";
}

$menu=new menu();
$menudata= $menu -> menu_by_id($moduleId);
if($menudata)
{
	$menu_image        = $menudata['menu_image'];
	$menu_name         = $menudata['menu_name'];
	$parentMenuId      = $menudata['parent_id'];
	$parentmenudata    = $menu -> menu_by_id($parentMenuId);
	$parent_menu_name  = $parentmenudata['menu_name'];
}
?>
<ul id="breadcrumb">
	<li><a href="#"><?php echo $menu_name;?> <span>→</span> <?php echo $parent_menu_name;?></a></li>
    <?php
	if($_SESSION['UTYPE']=="A") {
	?>
        <li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&parentId=<?php echo $parentId;?>&dtaction=new&moduleId=<?php echo $moduleId;?>'">Add New</a></div></li>
    <?php }?>
</ul>

<?php 
if($_SESSION['ErrMsg'])
{
	echo $_SESSION['ErrMsg'];
	unset($_SESSION['ErrMsg']);
} 
if($_SESSION['UTYPE']!="A")
    $ExtraQryStr .= " and hiddenMenu='N'";

$fetch_Details = $obj->getCategory($ExtraQryStr);
?>			
<form action="" name="pageForm" method="POST">
	<div class="table">
    	<ul class="table_head">
            <li class="sl">Sl. No.</li>
            <li class="t_days">Menu</li>
            <li class="t_days">SubMenu</li>
            <li class="t_days">Icon</li>
            <li class="t_absent">Is Top Menu?</li>
            <li class="toggle_select">Toggle <input type="checkbox" class="selectall" name="toggle"></li>
        </ul>
		<ul class="table_elem">

			<?php
			if(sizeof($fetch_Details)>0)
			{				
				if($page>1)
					$slNo = (($page - 1)*$limit)+1;
				else
					$slNo = 1;
				
				for($row=0; $row<sizeof($fetch_Details); $row++)
				{
					
					if($fetch_Details[$row]['status'] == 'Y')
					{
						$conStatus = '<img src="images/active.png" alt="Active" width="15" border="0" />';
						$status="N";
					}
					else
					{
						$conStatus = '<img src="images/inactive.png" alt="Inactive" width="15" border="0" />';
						$status="Y";
					}
					
					if($fetch_Details[$row]['isTopMenu'] == 'Y')
					{
						$isTopMenuImg = '<img src="images/t.png" alt="Active" width="15" border="0" />';
						$isTopMenu="N";
					}
					else
					{
						$isTopMenuImg = '<img src="images/t1.png" alt="Inactive" width="15" border="0" />';
						$isTopMenu="Y";
					}
					
					if($fetch_Details[$row]['isContent'] == 'Y')
					{
						$isContentImg = '<img src="images/c.png" alt="Active" width="15" border="0" />';
						$isContent="N";
					}
					else
					{
						$isContentImg = '<img src="images/c1.png" alt="Inactive" width="15" border="0" />';
						$isContent="Y";
					}
					
					if($fetch_Details[$row]['isGallery'] == 'Y')
					{
						$isGalleryImg = '<img src="images/g.png" alt="Active" width="15" border="0" />';
						$isGallery="N";
					}
					else
					{
						$isGalleryImg = '<img src="images/g1.png" alt="Inactive" width="15" border="0" />';
						$isGallery="Y";
					}
					
					if($fetch_Details[$row]['isVideo'] == 'Y')
					{
						$isVideoImg = '<img src="images/v.png" alt="Active" width="15" border="0" />';
						$isVideo="N";
					}
					else
					{
						$isVideoImg = '<img src="images/v1.png" alt="Inactive" width="15" border="0" />';
						$isVideo="Y";
					}
					
					$categoryName=	$fetch_Details[$row]['categoryName'];
					$msgId = $fetch_Details[$row]['categoryId'];
					?>
					<li id="<?php echo 'recordsArray_'.$msgId;?>">
                        <span class="sl"><?php echo $slNo;?></span>								 
                        <span class="t_days"><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=new&editid=<?php echo $fetch_Details[$row]['categoryId'];?>&page=<?php echo $page; ?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&type=<?php echo $type;?>"><?php echo $categoryName;?></a></span>
					  
					  <span class="t_days">
						<?php
						$data = $obj -> sublinksCountById($fetch_Details[$row]['categoryId']);
						if($data>0)					
							echo '<a href="index.php?pageType='.$pageType.'&dtls='.$dtls.'&parentId='.$fetch_Details[$row]['categoryId'].'&moduleId='.$moduleId.'&page='.$page.'" style="text-decoration:none;"><img src="images/showpage.png" alt="Show" title="Show Sub Pages" height="32" width="32" border="0" /><span style="padding-bottom:25px; color:#666699; vertical-align:middle;">['.$data.']</span></a>';
						else
							echo '<a href="index.php?pageType='.$pageType.'&dtls='.$dtls.'&dtaction=new&moduleId='.$moduleId.'&parentId='.$fetch_Details[$row]['categoryId'].'"><img src="images/addpage.png" alt="Add" title="Add Sub Page" height="32" width="32" border="0" /></a>';
						?>
					  </span>
					  
					  <span class="t_days">
						  <?php
                          if(file_exists($MEDIA_FILES_ROOT.'/menu/thumb/'.$fetch_Details[$row]['categoryImage']) && $fetch_Details[$row]['categoryImage'])
                            echo '<img src="'.$MEDIA_FILES_SRC.'/menu/thumb/'.$fetch_Details[$row]['categoryImage'].'" alt="'.$categoryName.'" title="'.$categoryName.'" height="32" width="32"  />';
                          else
                            echo '<img src="images/noicon.png" alt="'.$categoryName.'" title="No Icon" height="32" width="32"  />';
                          ?>
					  </span>
					  	
					  <span class="t_absent"><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&tmchgto=<?php echo $isTopMenu;?>&id=<?php echo $fetch_Details[$row]['categoryId'];?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>"><?php echo $isTopMenuImg;?></a></span>
					  	  							  
					  <span class="last_li">
                          <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $status;?>&id=<?php echo $fetch_Details[$row]['categoryId'];?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>"><?php echo $conStatus;?></a>		  
                          <?php if($_SESSION['UTYPE']=="A" || $parentId!=0) {?>
                          <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=new&editid=<?php echo $fetch_Details[$row]['categoryId'];?>&page=<?php echo $page; ?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&type=<?php echo $type;?>"><img src="images/edit.gif" alt="" width="16" height="16" border="0" /></a>	  
                          <a href="index.php?pageType=<?php echo $pageType;?>&parentId=<?php echo $parentId;?>&dtaction=delete&moduleId=<?php echo $_REQUEST['moduleId'];?>&id=<?php echo $fetch_Details[$row]['categoryId'];?>&parentId=<?php echo $parentId;?>&redstr=<?php echo $redirectString;?>&confirm=ASK" class="ask"><img src="images/delete.png" alt="" width="16" height="16" border="0" /></a>					  
                          <?php }?>
                          <input type="checkbox" class="case" name="selectMulti" value="<?php echo $fetch_Details[$row]['categoryId'];?>" />
					  </span>					
					</li>
					<?php
					$slNo++;
				}
				?>
                <li><span class="last_li">
                    <select name="multiAction" class="multi_action">
                        <option value="">Select</option>
                        <?php if($_SESSION['UTYPE']=="A") {?>
                        <option value="delete">Delete</option>
                        <?php }?>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>                
                </span></li>
                <?php
			}
			else
			{
				?><li style="text-align:center; line-height:30px;">No Record Present</li><?php
			}
			?>						
		</ul>
	</div>			
</form>