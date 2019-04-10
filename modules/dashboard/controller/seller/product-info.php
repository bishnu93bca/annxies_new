<?php
if($fetch_details['status'] == 'Y')
{
	$conStatus = '<img src="images/active.png" alt="Active" width="15" border="0" title="Click to Inactive"/> Active';
	$cstatus="N";
}
else
{
	$conStatus = '<img src="images/inactive.png" alt="Inactive" width="15" border="0" title="Click to Active"/> Inactive';
	$cstatus="Y";
}	
?>
<div class="basic_info_box userlist">                       
	<div class="user_img">
		<a title="<?php echo $pData['productName'];?>" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=sample&editid=<?php echo $editid;?>&sampleId=<?php echo $sampleId;?>&page=<?php echo $page; ?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&type=<?php echo $type;?>">
            
            <?php
            if(file_exists(UPFLD.'/product/thumb/'.$fetch_details['productImage']) && $fetch_details['productImage'])
            {
                $img='<img src="'.SHWFL.'/product/thumb/'.$fetch_details['productImage'].'" width="50px; class="thumbnail">';
            }
            elseif(file_exists(UPFLD.'/sample/thumb/'.$fetch_details['productImage']) && $fetch_details['productImage'])
            {
                $img='<img src="'.SHWFL.'/sample/thumb/'.$fetch_details['productImage'].'" width="50px; class="thumbnail">';
            } 
            else
                $img='<img src="'.TMP.'/images/noimage.jpg">';
            
            echo $img;
            ?>
		</a>
	</div>
	<div class="user_data_right">
		<div class="user_data">
			<div class="user_basic_info">
                <a title="<?php echo $pData['productName'];?>" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=sample&editid=<?php echo $editid;?>&sampleId=<?php echo $sampleId;?>&page=<?php echo $page; ?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&type=<?php echo $type;?>"><?php echo $fetch_details['fullname'];?><?php echo $fetch_details['productName'];?></a>		
                
				<ul>
                    <li><?php echo 'SKU# '.str_replace(",",", ",$fetch_details['p_keyword']);?></li>
                    <li>
                        <?php 
                         if(strlen(strip_tags($fetch_details['description']))>180)
                            echo substr(strip_tags($fetch_details['description']),0,177).'...'; 
                        else
                            echo strip_tags($fetch_details['description']);                        
                        ?>
                    </li>
				</ul>
			</div>
			<?php if($fetch_details['authenticated']=='Y'){?>
			<div class="user_verification_box">
				<img src="images/verified_tick.png" width="60" title="Authenticated via App">
			</div>
			<?php }?>
			</div>
        <div class="clear"></div>
		</div>        
</div>		