<?php 
$fetch_details = $obj->getContentListBymenucategoryIds($menucategoryIds);
echo $_SESSION['ErrMsg'];
unset($_SESSION['ErrMsg']);
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
                <span class="u_name"><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&contentID=<?php echo $fetch_details[$row]['contentID'];?>&moduleId=<?php echo $moduleId; ?>&dtaction=articleview&redstr=<?php echo $redirectString;?>"><?php echo $fetch_details[$row]['contentHeading'];?></a></span>	
                <span class="t_days">
                <?php echo substr(strip_tags($fetch_details[$row]['contentDescription']),0,40); if(strlen(strip_tags($fetch_details[$row]['contentDescription']))>40) echo '...';?>
                </span>
                <span class="t_present">&nbsp;</span>						 						  
                <span class="last_li">
                <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&contentID=<?php echo $fetch_details[$row]['contentID'];?>&moduleId=<?php echo $moduleId; ?>&dtaction=articleview&redstr=<?php echo $redirectString;?>" title="edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0" /></a>
                
                <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $status?>&id=<?php echo $fetch_details[$row]['contentID'];?>&moduleId=<?php echo $moduleId; ?>&action=content&redstr=<?php echo $redirectString;?>" title="status"><?php echo $conStatus;?></a>
                <?php if($_SESSION['UTYPE']=="A") { ?>
                <a class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&id=<?php echo $fetch_details[$row]['contentID'];?>&action=content&moduleId=<?php echo $moduleId; ?>&redstr=<?php echo $redirectString;?>" title="delete"><img src="images/delete.png" alt="" width="16" height="16" border="0" /></a></span>
            	<?php }?>
            </li>
			<?php
            $i++;
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