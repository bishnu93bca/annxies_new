<?php 
$fetch_details = $obj->getContentListBymenucategoryIds($editid);
if($pageType=='content')
{
	$menu=new menu();
	$parentmenudata= $menu -> menu_by_id(1);
	$parent_menu_name = $parentmenudata['menu_name'];
	$menu_image = $parentmenudata['menu_image'];
	?>
    <ul id="breadcrumb">
        <li><a href="#"><?php echo $categoryParentName;?><span>→</span></a></li>
        <li><a href="#"><?php echo $parent_menu_name;?></a></li>
        <li><div class="button_box"><a href="javascript:void(0)" onclick="show()">Add Content</a></div></li>
    </ul>
    <?php
}
else
{
	?>
    <ul id="breadcrumb">
        <li><div class="button_box"><a href="javascript:void(0)" onclick="show()">Add Content</a></div></li>
    </ul>
    <?php	
}
?>
<div class="table">
    <ul class="table_head">
        <li class="sl">Sl. No.</li>
        <li class="u_name">Heading</li>
        <li class="t_days">Description</li>
          <li class="t_present">&nbsp;</li>
        <li class="last_li"></li>
    </ul>
    <ul class="table_elem">				
        <?php
        if(sizeof($fetch_details)>0)
        {
            if($page>1)
                $slNo = (($page - 1)*$limit)+1;
            else
                $slNo = 1;

            $i=1;
            for($row=0;$row<sizeof($fetch_details);$row++)
            {

                if($fetch_details[$row]['contentStatus'] == 'Y')
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
                <li>
                    <span class="sl"><?php echo $slNo;?></span>						 
                    <span class="u_name"><?php echo $fetch_details[$row]['contentHeading'];?></span>	
                    <span class="t_days">
                    <?php echo substr(strip_tags($fetch_details[$row]['contentDescription']),0,40).'...';?>
                    </span>
                    <span class="t_present">&nbsp;</span>						 						  
                    <span class="last_li">
                    <a class="ask" href="index.php?pageType=<?php echo $pageType;?>&editid=<?php echo $editid;?>&dtaction=status&stschgto=<?php echo $status?>&id=<?php echo $fetch_details[$row]['contentID'];?>&page=<?php echo $page; ?>&action=content&redstr=<?php echo $redirectString;?>"><?php echo $conStatus;?></a>
                    <a href="index.php?pageType=<?php echo $pageType;?>&editid=<?php echo $editid;?>&contentID=<?php echo $fetch_details[$row]['contentID'];?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>"><img src="images/edit.gif" alt="" width="16" height="16" border="0" /></a>
                    <a class="ask" href="index.php?pageType=<?php echo $pageType;?>&editid=<?php echo $editid;?>&dtaction=delete&id=<?php echo $fetch_details[$row]['contentID'];?>&action=content&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>"><img src="images/delete.png" alt="" width="16" height="16" border="0" /></a></span>
                </li>
                <?php
                $i++;
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