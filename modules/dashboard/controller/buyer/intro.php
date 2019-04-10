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
                
				<span>Member since &nbsp;<?php echo date('jS M, Y', strtotime($cData['createDate']));?></span>
				<ul>
                    <li><span class="user_email"><?php echo $cData['email'];?></span></li>
					<?php echo ($cData['phone'])? '<li><span class="user_phone">'.$cData['phone'].'</span></li>':''; ?>
					<?php echo ($cData['lastLogin'])? '<li><span class="user_phone">Last loggedin on '.date('jS M, Y', strtotime($cData['lastLogin'])).'</span></li>':''; ?>
				</ul>
			</div>
            <div class="col-md-6">
               darko
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
                    <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $cData['id'];?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>">Products</a>
                </li>
                <?php 
                $samRow = $cObj->sampleRequestCount($cData['id']);
                ?>
                <li <?php if($dtaction=='add') echo 'class="active"';?>>
                    <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=sample-request&editid=<?php echo $cData['id'];?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>">Directory <?php echo ($samRow>0)? '('.$samRow.')':'';?></a>
                </li>
                <!--<li <?php if($dtaction=='changepassword') echo 'class="active"';?>><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=changepassword&memberId=<?php echo $cData['id']?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>">Change Password</a></li>-->
                
                <li><a class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $cstatus?>&id=<?php echo $cData['id']?>&redstr=<?php echo $redirectString;?>"><?php echo $conStatus;?></a></li>

                <?php /*<li class="document_list_last"><span>Action</span>
                    <ul class="document_list">
                        <li><a class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $cstatus?>&id=<?php echo $cData['id']?>&redstr=<?php echo $redirectString;?>"><?php echo $conStatus;?></a></li>
                        
                    </ul>
                </li>*/?>
            </ul>
        </div>
    </div>        
</div>		