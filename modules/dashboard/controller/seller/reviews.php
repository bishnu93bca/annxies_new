<?php 
$cObj    = new MemberAdmin;
$menu    = new menu;
$menudata= $menu -> menu_by_id($moduleId);
if($menudata)
{
	$menu_image        = $menudata['menu_image'];
	$menu_name         = $menudata['menu_name'];
	$parentMenuId      = $menudata['parent_id'];
	$parentmenudata    = $menu -> menu_by_id($parentMenuId);
	$parent_menu_name  = $parentmenudata['menu_name'];
}

$ExtraQryStr 			= "1";
?>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>    
    <!--<li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add-quizconfig&moduleId=<?php echo $moduleId;?>&courseId=<?php echo $editid;?>'">Add Exam Type</a></div></li>-->
</ul>
<?php

if(isset($clear))
{
	$_SESSION['srchtxt'] 	= '';
	$ExtraQryStr 			= "1";
}
if($editid){
	$cData    		= $cObj->getMemberInfoByid($editid); 
    include("intro.php");
}
?>

<form action="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>" name="myForm" method="POST">
	<div class="table">        
        <ul class="table_head ui-sortable">
            <li class="sl" style="width:5%">Sl.</li>
            <li class="sl" style="width:15%">Name</li>
            <li class="sl" style="width:15%">Email</li>
            <li class="sl" style="width:15%">Company</li>  
            <li class="sl" style="width:15%">Rating</li> 
            <li class="sl" style="width:15%">Date-Time</li>   
        </ul>
        
		 <ul class="table_elem">
            <?php                
            $obj = new Contact();
            $ExtraQryStr =' contactType="R"';						
            $fetch_Details  = $obj -> getContacts($ExtraQryStr);
            if($fetch_Details)
            { 
                /**************************************************************
                Paging Variable Started
                ***************************************************************/
                $p = new Pager;	
                $limit=20;
                $start = $p->findStart($limit);
                if(!$page)
                    $page=1;
                /**************************************************************
                Paging Variable Ended
                ***************************************************************/
                                    
                $pages = $p->findPages($countRow, $limit);
                if($page>1)
                    $slNo = (($page - 1)*$limit)+1;
                else
                    $slNo = 1;

                foreach($fetch_Details as $rvData)
                {  
                    if($rvData['status'] == 'Y')
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
                        <span class="sl" style="width:5%"><?php echo $slNo;?></span>                         
                        <span class="sl" style="width:15%">
                            <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=review&editid=<?php echo $editid;?>&reviewId=<?php echo $rvData['contactID'];?>&page=<?php echo $page; ?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&type=<?php echo $type;?>">
                                <?php echo $rvData['name'];?>
                            </a>
                        </span> 
                        <span class="sl" style="width:15%">
                            <?php echo $rvData['email'];?>
                        </span>
                        <span class="sl" style="width:15%"><?php echo $rvData['company'];?></span>
                        <span class="sl" style="width:15%"><?php echo $rvData['rating'];?></span>
                        <span class="sl" style="width:15%"> <?php echo date('M d, Y',strtotime($rvData['contactEntrydate']));?></span>
                        <span class="last_li">
                          <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&action=review&stschgto=<?php echo $status;?>&id=<?php echo $rvData['contactID'];?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>"><?php echo $conStatus;?></a>
                            
                          <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=review&editid=<?php echo $editid;?>&reviewId=<?php echo $rvData['contactID'];?>&page=<?php echo $page; ?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&type=<?php echo $type;?>"><img src="images/view.png" alt="" width="16" height="16" border="0" /></a>	
                            
                          <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&action=review&id=<?php echo $rvData['contactID'];?>&c_id=<?php echo $rvData['c_id'];?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>&confirm=ASK" class="ask"><img src="images/delete.png" alt="" width="16" height="16" border="0" /></a>
                           
                        </span>	
                    </li>
                    <?php
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
	<?php if(ceil($countRow/$limit)>1) {?>
    <div class="pagination">
        <?php	
        $pageTypee =  $pageType."&dtls=".$dtls."&type=".$type."&dtaction=".$dtaction."&editid=".$editid."&moduleId=".$moduleId;	
        echo "<p>Page $_GET[page] Of ".ceil($countRow/$limit).'</p>';
        $pagelist = $p->pageList($_GET['page'], $pages, $pageTypee);
        if(ceil($countRow/$limit)>1)
            echo $pagelist;
        ?>
    </div>
    <?php }?>	
    <br class="clear">
    
    <input name="Back" type="button" onclick="history.back(-1);" class="back"  value="Back" />
</form>