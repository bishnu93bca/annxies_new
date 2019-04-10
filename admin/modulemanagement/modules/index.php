<?php
if($parent_id=='')
    $ExtraQryStr = 'parent_id=0';
else
    $ExtraQryStr = 'parent_id='.$parent_id;
?>
<ul id="breadcrumb">
    <li><a href="#">Modules <span>→</span></a></li>
    <li><a href="#">Module Management <span>→</span></a></li>
    <li><div class="button_box"><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&parent_id=<?php echo $parent_id;?>" title="Add New Module">Add New</a></div></li>
</ul>

<?php 
if($_SESSION['ErrMsg'])
{
	echo $_SESSION['ErrMsg'];
	unset($_SESSION['ErrMsg']);	
}?>

<form action="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>" name="myForm" method="POST">
	<div class="table">
        <ul class="table_head">
            <li class="sl">Sl. No.</li>
            <li class="u_name" style="width:20%">Module</li>
            <li  class="sl" style="width:15%;">Is Installed?</li>
            <li class="sl" style="width:15%">Sub Module</li>
            <li class="sl">Icon</li>
            <li class="last_li"></li>
        </ul>
        <ul class="table_elem">		
            <?php						
            $sel_Details = $menu -> menu_details($ExtraQryStr, 0, 50);

            if($sel_Details)
            {
                $dataExists='Yes';
                $slNo = 1;
                foreach($sel_Details as $fetch_Details)
                {
                    if($fetch_Details['status'] == 'Y')
                    {
                        $conStatus = '<img src="images/active.png" alt="active" width="15" border="0" />';
                        $status="N";
                    }
                    else
                    {
                        $conStatus = '<img src="images/inactive.png" alt="inactive" width="15" border="0" />';
                        $status="Y";
                    }
                    ?>
                    <li>
                        <span class="sl"><?php echo $slNo;?></span>
                        <span class="u_name" style="width:20%"><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&parent_id=<?php echo $parent_id;?>&editid=<?php echo $fetch_Details['menu_id'];?>"><?php echo $fetch_Details['menu_name'];?></a></span>
                        <span class="sl" style="width:15%">
                            <?php 
                            if($fetch_Details['isInstalled']=='Y')
                                echo '<p class="installed">Installed</p>';
                            else
                                echo '<p class="notinstalled">Not Installed</p>';?>
                        </span>
                        <span class="sl" style="width:15%"><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&parent_id=<?php echo          $fetch_Details['menu_id'];?>"><img src="images/mainmenu.png" alt="Sub Module" width="15" border="0" /></a>[<?php $count = $menu->submenucount($fetch_Details['menu_id']);  echo $count; ?>]
                        </span>
                        <span class="sl">
                        <?php
                        if(file_exists('../uploadedfiles/menu/thumb/'.$fetch_Details['menu_image']) && $fetch_Details['menu_image'])
                            echo '<img src="../uploadedfiles/menu/thumb/'.$fetch_Details['menu_image'].'" alt="'.$fetch_Details['menu_name'].'" title="'.$fetch_Details['menu_name'].'" style="height:28px;" />';
                        else
                            echo '<img src="images/noicon.png" alt="'.$fetch_Details['menu_name'].'" title="No Icon" style="height:28px;" />';
                        ?>
                        </span>
                        <span class="last_li">                   
                            <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&parent_id=<?php echo $parent_id;?>&editid=<?php echo $fetch_Details['menu_id'];?>"><img src="images/edit.gif" alt="" width="16" height="16" border="0" /></a>
                            <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $status?>&parent_id=<?php echo $parent_id;?>&id=<?php echo $fetch_Details['menu_id'];?>"><?php echo $conStatus;?></a>
                            <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&parent_id=<?php echo $parent_id;?>&id=<?php echo $fetch_Details['menu_id'];?>"><img src="images/delete.png" alt="delete" width="15" border="0" /></a>
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