<?php
$obj = new GalleryClass();
$fetch_Details = $obj -> galleryDetailsBymenucategoryId($editid);	
?>
<ul id="breadcrumb">
    <li><a href="#">Photo Management For <?php echo $mdata['categoryName'];?></a></li>
    <li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=newgallery&menucategoryId=<?php echo $editid;?>'">Add Photo</a></div></li>
</ul>
<?php 
if($_SESSION['ErrMsg'])
	echo $_SESSION['ErrMsg'];
?>
<form action="index.php?pageType=<?php echo $pageType?>&dtls=<?php echo $dtls?>" name="galleryForm" method="POST">
	<div class="table">
        <ul class="table_head">
            <li class="sl">SlNo.</li>            
            <li class="t_days">Thumbnail</li>
            <li class="u_name" style="width:50%">Heading</li>
            <li class="last_li"></li>
        </ul>
        <ul class="table_elem">
			<?php
			if(sizeof($fetch_Details)>0)
			{
				$slNo = 1;
				for($i=0;$i<sizeof($fetch_Details);$i++)
				{							
					if($fetch_Details[$i]['status'] == 'Y')
					{
						$conStatus = '<img src="images/active.png" alt="active" border="0" />';
						$status="N";
					}
					else
					{
						$conStatus = '<img src="images/inactive.png" alt="inactive" border="0" />';
						$status="Y";
					}
					$msgId = $fetch_Details[$i]['id'];
					?> 
					<li id="<?php echo 'recordsArray_'.$msgId;?>">
                   		<span class="sl"><?php echo $slNo;?></span>	
                        <span class="t_days"><a href="../uploadedfiles/photo/gallery/large/<?php echo $fetch_Details[$i]['imagepath']; ?>" class="preview" target="_blank"><img src="<?php echo '../uploadedfiles/photo/gallery/thumb/'.$fetch_Details[$i]['imagepath'];?>" border="0" height="40" width="66" /></a></span>					
						<span class="u_name" style="width:50%"><?php echo substr($fetch_Details[$i]['bannername'],0,70);?></span>						
						<span class="last_li">
                            <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=newgallery&editid=<?php echo $fetch_Details[$i]['id'];?>"><img src="images/edit.gif" alt="edit" border="0" /></a>
                            
                            <a href="index.php?pageType=<?php echo $pageType;?>&dtaction=status&stschgto=<?php echo $status?>&editid=<?php echo $editid;?>&id=<?php echo $fetch_Details[$i]['id'];?>&action=gallery&redstr=<?php echo $redirectString;?>"><?php echo $conStatus;?></a>					
                            
                            <a  class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtaction=delete&editid=<?php echo $editid;?>&id=<?php echo $fetch_Details[$i]['id'];?>&action=gallery&redstr=<?php echo $redirectString;?>"><img src="images/delete.png" alt="delete" border="0" /></a>
							<?php /*?><td align="center" valign="middle"><input type="checkbox" id="itemId" name="itemId" value="<?php echo $fetch_Details[$i]['id'];?>" /></td><?php */?>
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
</form>