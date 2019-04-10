<script src="js/main.js" type="text/javascript"></script>
<style>
#preview{
	position:absolute;
	border:1px solid #ccc;
	background:#333;
	padding:5px;
	display:none;
	color:#fff;
	}
</style>
<!--hover large image-->
<?php
include('../../include.php');
require_once("class/gallery.class.php");?>

	<?php	
	error_reporting(0);	
	$obj = new GalleryClass();
	$last_msg_id=$_GET['last_msg_id'];
	$galleryCategoryId=$_GET['galleryCategoryId'];	
	$limit = 5;
	$fetch_Details = $obj -> onScrollGalleryDetailsBygalleryCategoryId($galleryCategoryId,$last_msg_id,$limit,$Link);
	$last_msg_id="";
	if($_SESSION['temp'])
		$slNo = $_SESSION['temp']; 
	else
		$slNo = $limit + 1; 
	for($i=0;$i<sizeof($fetch_Details);$i++)
	{
			
		
		$msgID= $fetch_Details[$i]['id'];
	
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
		<div id="<?php echo 'recordsArray_'.$msgID; ?>"  align="left" class="message_box" >
			<li>
			
				<span class="sl"><?php echo $slNo;?></span>
				
                <?php 
				if(substr($_SESSION['SITE_URL'],0,7)=='http://')
					$siteurl = $_SESSION['SITE_URL'];
				else
					$siteurl = 'http://'.$_SESSION['SITE_URL'];		
				?>
                	
				<span class="u_name"><a href="../uploadedfiles/photo/gallery/large/<?php echo $fetch_Details[$i]['imagepath'];?>" class="preview" target="_blank"><img src="../uploadedfiles/photo/gallery/thumb/<?php echo $fetch_Details[$i]['imagepath'];?>" border="0" height="30" width="60" /></a></span>							
				
				<span class="t_days"><?php echo strip_tags($fetch_Details[$i]['bannerdescription']);?></span>
				
				<span class="t_present"><?php echo $fetch_Details[$i]['bannername'];?></span>
				
				<span class="last_li"><a class="ask" href="index.php?pageType=<?php echo $_SESSION['PAGE'];?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $status?>&galleryCategoryId=<?php echo $galleryCategoryId;?>&id=<?php echo $fetch_Details[$i]['id'];?>&type=<?php echo $type;?>&moduleId=<?php echo $galleryCategoryId;?>&redstr=<?php echo $redirectString;?>"><?php echo $conStatus;?></a>
				
				<a class="ask"  href="index.php?pageType=<?php echo $_SESSION['PAGE'];?>&dtls=<?php echo $dtls;?>&dtaction=new&editid=<?php echo $fetch_Details[$i]['id'];?>&type=<?php echo $type;?>&galleryCategoryId=<?php echo $galleryCategoryId;?>&moduleId=<?php echo $galleryCategoryId;?>&redstr=<?php echo $redirectString;?>"><img src="images/edit.gif" alt="edit" border="0" /></a>
				
				<a  class="ask" href="index.php?pageType=<?php echo $_SESSION['PAGE'];?>&dtls=<?php echo $dtls;?>&dtaction=delete&galleryCategoryId=<?php echo $galleryCategoryId;?>&id=<?php echo $fetch_Details[$i]['id'];?>&type=<?php echo $type;?>&redstr=<?php echo $redirectString;?>"><img src="images/trash.png" alt="delete" border="0" /></a></span>
				
			</li>
		</div>
		<?php
		$slNo++;
		$_SESSION['temp'] = $slNo;
	}
	?>
  