<script type="text/javascript">
function show()
{
	document.getElementById('newContent').style.display = 'block'; 
}
</script>		
<?php
$menu = new menu();
$menudata= $menu -> menu_by_id($moduleId);
if($menudata)
{
	$menu_image = $menudata['menu_image'];
	$menu_name = $menudata['menu_name'];
	$parentMenuId = $menudata['parent_id'];
	$parentmenudata= $menu -> menu_by_id($parentMenuId);
	$parent_menu_name = $parentmenudata['menu_name'];
}
$mobj = new MemberAdmin();
$ExtraQryStr=1;	
/*if($_SESSION['UTYPE']=="A")
{
	?>
	<ul id="breadcrumb">
	    <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
	    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
	    <li><div class="button_box"><a href="javascript:void(0)" onclick="show()">Add Content</a></div></li>
	</ul>
	<?php
}
$obj = new Content();
    include("newcontent.php");

include("listview.php");*/
//include("banner.php");
 
if($_SESSION['ErrMsg'])
{
	echo $_SESSION['ErrMsg'];
	unset($_SESSION['ErrMsg']);
} 
$countRow = $mobj->officeCount($ExtraQryStr);	
?>

<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
    <li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $moduleId;?>'">Add New</a></div></li>
    <li><p>Recouds found: <?php echo $countRow;?></p></li>
</ul>

<?php 
if($_SESSION['ErrMsg'])
{
	echo '<br class="clear" />'.$_SESSION['ErrMsg'];
	unset($_SESSION['ErrMsg']);
}?>

<div class="table">
	<ul class="table_head">
        <li style="width:6%" class="sl">Sl.No.</li>
        <li style="width:30%" class="u_name">Name</li>
        <li style="width:30%" class="t_days">City</li>
        <li class="last_li"></li>
    </ul>
    <ul class="table_elem">
		<?php
        if($countRow)
        {
            /**************************************************************
            Paging Variable Started
            ***************************************************************/
            $p      = new Pager;	
            $limit  = 20;
            $start  = $p->findStart($limit);
            if(!$page)
                $page=1;
            /**************************************************************
            Paging Variable Ended
            ***************************************************************/

            $fetch_Details = $mobj -> getOfficeDetails($ExtraQryStr, $start, $limit);

			 $pages = $p->findPages($countRow, $limit);
                if($page>1)
                    $slNo = (($page - 1)*$limit)+1;
                else
                    $slNo = 1;
            
			for($aa=0;$aa<sizeof($fetch_Details);$aa++)
			{
				if($fetch_Details[$aa]['status'] == 'Y')
				{
					$conStatus = '<img src="images/active.png" alt="Active" width="15" border="0" />';
					$status="N";
				}
				else
				{
					$conStatus = '<img src="images/inactive.png" alt="Inactive" width="15" border="0" />';
					$status="Y";
				}
                ?>
                <li id="recordsArray_<?php echo $fetch_Details[$aa]['id_office'];?>">
                    <span style="width:6%" class="sl"><?php echo $slNo;?></span>
                    <span style="width:30%" class="u_name"><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $fetch_Details[$aa]['id_office'];?>&moduleId=<?php echo $moduleId;?>"><?php echo $fetch_Details[$aa]['office'];?></a></span>
                    <span style="width:30%" class="t_days"><?php echo $fetch_Details[$aa]['office_city'];?></span>			
                    <span class="last_li">
                        <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $fetch_Details[$aa]['id_office'];?>&moduleId=<?php echo $moduleId;?>" title="edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0" /></a>
                        
                        <a  class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $status?>&id=<?php echo $fetch_Details[$aa]['id_office'];?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>" title="status" class="ask"><?php echo $conStatus;?></a>
                        
                        <a class="ask"  href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&id=<?php echo $fetch_Details[$aa]['id_office'];?>&redstr=<?php echo $redirectString;?>" title="delete"><img src="images/delete.png" alt="" width="16" height="16" border="0" /></a>
                    </span>
                </li>
                <?php
            $slNo++;
		}
	}
	else
	{
		?><li style="text-align:center; line-height:30px;">No Record Present</li><?php
	}
	?>
	</ul>
</div>

<?php
if(ceil($countRow/$limit)>1)
{
    echo '<div class="pagination">';
    if($categoryId)
        $pageTypee = $pageType."&dtls=".$dtls."&type=".$type."&moduleId=".$moduleId."&categoryId=".$categoryId;	
    else	
        $pageTypee = $pageType."&dtls=".$dtls."&type=".$type."&moduleId=".$moduleId;	
    echo "<span>Page $_GET[page] Of ".ceil($countRow/$limit).'</span>';
    $pagelist = $p->pageList($_GET['page'], $pages, $pageTypee);
    if(ceil($countRow/$limit)>1)
    {
        echo $pagelist;
    }
    echo '</div>';
}
?>	
