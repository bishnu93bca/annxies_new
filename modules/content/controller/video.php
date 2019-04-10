<?php
$obj = new GalleryClass();
$fetch_Details = $obj -> videoDetailsBymenucategoryId($editid,$Link);	
?>
<ul id="breadcrumb">
    <li><img src="../uploadedfiles/menu/1294422174.png" width="48" height="38" /></li>
    <li><a href="#">Video Management For <?php echo $mdata['categoryName'];?></a></li>
    <li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=newvideo&menucategoryId=<?php echo $editid;?>'">Add Video</a></div></li>
</ul>
<?php 
if($_SESSION['ErrMsg'])
	echo $_SESSION['ErrMsg'];
?>
<form action="index.php?pageType=<?php echo $pageType?>&dtls=<?php echo $dtls?>" name="videoForm" method="POST">
<div class="table" style="overflow:scroll;">
        <ul class="table_head">
            <li class="sl">SlNo.</li>
            <li class="u_name">Heading</li>
            <li class="t_days">Thumbnail</li>
            <li>Swap</li>
            <li class="last_li"></li>
        </ul>

        <?php
            if(sizeof($fetch_Details)>0)
                include("contentmanagement/videopageaction.php");
        ?>
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
					?> 
					<li>
                   		<span class="sl"><?php echo $slNo;?></span>
						
						
						<span class="u_name"><?php echo $fetch_Details[$i]['bannername'];?></span>		
						
						<span class="t_days"><a href="../uploadedfiles/photo/gallery/thumb/<?php echo $fetch_Details[$i]['thumbpath']; ?>" class="preview" target="_blank"><img src="<?php echo '../uploadedfiles/photo/gallery/thumb/'.$fetch_Details[$i]['thumbpath'];?>" border="0" height="30" width="60" /></a></span>
                        
                        <span><a href="index.php?pageType=<?php echo $pageType;?>&dtaction=swap&editid=<?php echo $editid;?>&id=<?php echo $fetch_Details[$i]['id'];?>&swapNo=<?php echo $fetch_Details[$i]['swapno'];?>&action=up"><img src="images/up.png" border="0" alt="up" /></a><a href="index.php?pageType=<?php echo $pageType;?>&dtaction=swap&editid=<?php echo $editid;?>&id=<?php echo $fetch_Details[$i]['id'];?>&action=down&swapNo=<?php echo $fetch_Details[$i]['swapno'];?>"><img src="images/down.png" border="0" alt="down"  /></a></span>
						
						<span class="last_li">
                        	<a class="ask" href="index.php?pageType=<?php echo $pageType;?>&&dtaction=status&stschgto=<?php echo $status?>&editid=<?php echo $editid;?>&id=<?php echo $fetch_Details[$i]['id'];?>&action=gallery&redstr=<?php echo $redirectString;?>"><?php echo $conStatus;?></a>
						
							<a  href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=newvideo&editid=<?php echo $fetch_Details[$i]['id'];?>"><img src="images/edit.gif" alt="edit" border="0" /></a>
						
							<a  class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtaction=delete&editid=<?php echo $editid;?>&id=<?php echo $fetch_Details[$i]['id'];?>&action=gallery&redstr=<?php echo $redirectString;?>"><img src="images/delete.png" alt="delete" border="0" /></a>
						
						
                        </span>
					
					</li>
					<?php
					$slNo++;
				}
			}
			else
			{
			?>
				<li style="text-align:center; line-height:30px;">
                  No Record Present
                </li>
			<?php
			}
			?>
		</ul>
         		
 </div>	
</form>
