<script type="text/javascript">
function show()
{
	document.getElementById('newContent').style.display = 'block'; 
}
</script>
<?php
$bobj = new PostClass();
		
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

if($srch_str)
    $ExtraQryStr = ' (blogTitle LIKE "%'.$srch_str.'%" or blogContent LIKE "%'.$srch_str.'%")';
else
    $ExtraQryStr = "1";

$countRow = $bobj->postCount($ExtraQryStr);	
?>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?><span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
    <li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $moduleId;?>'">Add New</a></div></li>
    <li><p>Recouds found: <?php echo $countRow;?></p></li>
</ul>

  <form action="" name="myForm" method="POST">
        <div class="form_holder">    
        <div style="width:350px; float:left">	
            <p class="description-line1">Search By Text 
                <input type="text" name="srch_str" placeholder="Search By Text" value="<?php echo $srch_str;?>"style="width:220px;">
            </p>
        </div>		
		<div style="width:150px; float:left">	
			<p class="description-line1">
				<input type="submit"  name="search"  value="Search" class="save_frm" />
			</p>
		</div>
	                
    </div>
    </form>
<div class="table">
	<ul class="table_head">
        <li style="width:6%" class="sl">Sl.No.</li>
        <li style="width:35%" class="u_name">Title</li>
        <li style="width:20%" class="last_li"></li>
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
            
            $fetch_Details = $bobj->getPost($ExtraQryStr, $start, $limit);
        
           $pages = $p->findPages($countRow, $limit);
            if($page>1)
                $slNo = (($page - 1)*$limit)+1;
            else
                $slNo = 1;
            
            for($row=0; $row<sizeof($fetch_Details); $row++)
            {
                $aprvCmtData =  $bobj->getComment('isApproved="N"',$fetch_Details[$row]['blogId'],0,9999);
                $cmtData =  $bobj->getComment('1',$fetch_Details[$row]['blogId'],0,9999);
                
                
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
                ?>
                <li id="recordsArray_<?php echo $fetch_Details[$row]['blogId'];?>">
                    <span style="width:6%" class="sl"><?php echo $slNo;?></span>				  
                    <span style="width:35%" class="u_name">
                        <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $fetch_Details[$row]['blogId'];?>&page=<?php echo $page; ?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>"><?php echo substr(strip_tags($fetch_Details[$row]['blogTitle']),0,70);?></a>
                    </span>	
                    
                    <span class="last_li">
                        <a class="cmnts" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=blogcmnt&editid=<?php echo $fetch_Details[$row]['blogId'];?>&page=<?php echo $page; ?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>" title="comments"><img src="images/cmnts.png" alt="" width="16" height="16" border="0" /><?php if($aprvCmtData) { echo '<em style="color:#FF0000">'.sizeof($aprvCmtData).'</em>/'; }?><?php echo sizeof($cmtData); ?></a>
                        
                        <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $fetch_Details[$row]['blogId'];?>&page=<?php echo $page; ?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>" title="edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0" /></a>
                        <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $status?>&id=<?php echo $fetch_Details[$row]['blogId'];?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>" title="status"><?php echo $conStatus;?></a>
                        <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&id=<?php echo $fetch_Details[$row]['blogId'];?>&redstr=<?php echo $redirectString;?>" class="ask" title="delete"><img src="images/trash.png" alt="trash"  border="0" /></a>            
                    </span>
                </li>
                <?php
                $slNo++;
            }
        }
        else
        {
            ?><li style="text-align: center; line-height: 30px;">No Record Present</li><?php
        }
        ?>
	</ul>
</div>
<?php
if(ceil($countRow/$limit)>1)
{
    echo '<div class="pagination">';
    if($categoryId)
        $pageTypee = $pageType."&dtls=".$dtls."&type=".$type."&moduleId=".$moduleId;	
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
