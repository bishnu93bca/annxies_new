<?php
if($cData['status'] == 'Y')
{
	$conStatus = '<img src="images/active.png" alt="Active" width="15" border="0" title="Click to Inactive"/> Active';
	$cstatus="N";
}
else
{
	$conStatus = '<img src="images/inactive.png" alt="Inactive" width="15" border="0" title="Click to Active"/> Inactive';
	$cstatus="Y";
}	
$datum_start = date('M d, Y',strtotime($cData['datum_start']));
$datum_end   =date('M d, Y', strtotime("+".$cData['valid']." months", strtotime($cData['datum_start'])));
?>
<div class="basic_info_box userlist">                       
	<div class="user_img">
		<a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $cData['id'];?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>">
			
			<?php
			if($cData['profilePic'] && file_exists($MEDIA_FILES_ROOT_AD.'/member/thumb/'.$cData['profilePic']))
				echo '<img src="'.$MEDIA_FILES_SRC_AD.'/member/thumb/'.$cData['profilePic'].'" height="100" alt="'.$cData['name'].' '.$cData['surname'].'"> ';
			else
				echo '<img src="images/profileImage.png" height="100" alt="'.$cData['name'].' '.$cData['surname'].'"> ';
			?>

			<span class="emp_code" title="Active"><?php echo $cData['publicId'];?></span>
		</a>
	</div>
	<div class="user_data_right">
		<div class="user_data">
			<div class="user_basic_info">
				<a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $cData['id'];?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>"><?php echo $cData['name'].' '.$cData['surname'];?></a>	
				<span>Seller since &nbsp;<?php echo date('jS M, Y', strtotime($cData['createDate']));?></span>
				<span><?php echo strtoupper($cData['plan']).' Membership : '.$cData['valid'].' months ('.$datum_start.' ~ '.$datum_end.')';?></span>
				<ul>
					<li><span class="user_phone"><?php echo $cData['phone'];?></span></li>
					<li><span class="user_email"><?php echo $cData['email'];?></span></li>
				</ul>
			</div>
			<?php if($cData['authenticated']=='Y'){?>
			<div class="user_verification_box">
				<img src="images/verified_tick.png" width="60" title="Authenticated via App">
			</div>
			<?php }?>
			</div>
			<div class="user_basic_menu">    
				<ul class="user_menu">
					<li <?php if($dtaction=='add') echo 'class="active"';?>>
						<a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $cData['id'];?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>">Profile</a>
					</li>
                    <?php 
                    $obj = new adminProductClass();
                    $ExtraQryStr = "1 AND userid=".addslashes($cData['id']);
                    $countRow = $obj->productCount($ExtraQryStr);
                    ?>
					<li <?php if($dtaction=='productlist') echo 'class="active"';?>>
						<a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=productlist&editid=<?php echo $cData['id'];?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>">Products <?php echo ($countRow)? '('.$countRow.')':'';?></a>
					</li>
					<li <?php if($dtaction=='samplelist' || $dtaction=='sample' || $dtaction=='inventory') echo 'class="active"';?>>
						<a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=samplelist&editid=<?php echo $cData['id'];?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>">Samples <?php echo ($cData['sampleCount']>0)? '('.$cData['sampleCount'].')':'';?></a>
					</li>
                    <?php if($cData['plan']!='standard'){ ?>
                        <li <?php if($dtaction=='booking') echo 'class="active"';?>>
                            <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=booking&editid=<?php echo $cData['id'];?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>">Booking</a>
                        </li>
                    <?php }?>
                    <li <?php if($dtaction=='reviews') echo 'class="active"';?>>
                        <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=reviews&editid=<?php echo $cData['id'];?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>">Review <?php echo ($cData['reviewCount']>0)? '('.$cData['reviewCount'].')':'';?></a>
                    </li>
                    <li class="document_list_last"><span>More</span>
						<ul class="document_list">
							
                            <li><a class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $cstatus?>&id=<?php echo $cData['id']?>&redstr=<?php echo $redirectString;?>">Voice Mail</a></li>
                            <li><a class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $cstatus?>&id=<?php echo $cData['id']?>&redstr=<?php echo $redirectString;?>">Email</a></li>
                            <li><a class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $cstatus?>&id=<?php echo $cData['id']?>&redstr=<?php echo $redirectString;?>">Paper</a></li>
                            
                            <li><a class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $cstatus?>&id=<?php echo $cData['id']?>&redstr=<?php echo $redirectString;?>"><?php echo $conStatus;?></a></li>
					
							<!--<li><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=changepassword&recruiterId=<?php echo $cData['id']?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>">Change Password</a></li>-->
							
							
						</ul>
					</li>
                    
				</ul>
			</div>
		</div>        
</div>		