<?php 
$cObj    = new MemberAdmin;
$pObj    = new adminProductClass;
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
            <li class="sl" style="width:4%">Sl.</li>
            <li class="sl" style="width:15%">Porduct</li>
            <li class="sl" style="width:10%">Keyword</li>
            <li class="sl" style="width:15%">Description</li>  
            <li class="sl" style="width:10%">Qty</li>  
            <li class="sl" style="width:15%">Price</li>  
            <li class="sl" style="width:15%">Status</li>  
        </ul>
        
		 <ul class="table_elem">
            <?php                             
            $ExtraQryStr = " userId=".addslashes($editid);
            $countRow    = $pObj->sampleCount($ExtraQryStr);	
            if($countRow)
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
                                    
                $fetch_Details = $obj->getSampleByLimit($ExtraQryStr,$start,$limit);	
                
                $pages = $p->findPages($countRow, $limit);
                if($page>1)
                    $slNo = (($page - 1)*$limit)+1;
                else
                    $slNo = 1;

                foreach($fetch_Details as $pData)
                {  
                    if($pData['status'] == 'Y')
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
                        <span class="sl" style="width:4%"><?php echo $slNo;?></span>                         
                        <span class="sl" style="width:15%">
                            <a title="<?php echo $pData['productName'];?>" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=sample&editid=<?php echo $editid;?>&sampleId=<?php echo $pData['sampleId'];?>&page=<?php echo $page; ?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&type=<?php echo $type;?>">
                                <?php 
                                if($pData['productName']){
                                 if(strlen($pData['productName'])>35)
                                    echo substr($pData['productName'],0,33).'...'; 
                                else
                                    echo $pData['productName'];
                                }
                                ?>
                            </a>
                        </span> 
                        <span class="sl" style="width:10%"> <?php echo str_replace(",",", ",$pData['p_keyword']);?></span>
                        <span class="sl" style="width:15%" title="<?php echo $pData['description'];?>">
                        <?php   
                        if($pData['description']){
                         if(strlen(strip_tags($pData['description']))>25)
                            echo substr(strip_tags($pData['description']),0,22).'...'; 
                        else
                            echo strip_tags($pData['description']);
                        }
                        else 
                            echo '-';
                        ?>
                        </span>
                        <span class="sl" style="width:10%"> <?php echo $pData['qty'].' Bags';?></span>
                        <span class="sl" style="width:15%"> <?php                                   
                            echo $pData['range1'].' ~ '.$pData['range2'].' ';echo ($pData['currency'])? $pData['currency'].' ':'USD ';
                       
                            ?>
                        </span>
                        <span class="sl" style="width:15%"><?php echo $pData['isApproved'];?></span>
                        <span class="last_li">
                            <?php if($pData['isApproved']=='Sample Received') {?>    
                                <a title="Inventory" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=inventory&editid=<?php echo $editid;?>&sampleId=<?php echo $pData['sampleId'];?>&page=<?php echo $page; ?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&type=<?php echo $type;?>">
                                    <img src="images/order.png" alt="" width="16" height="16" border="0" />
                                </a>
                            <?php } ?>    
                          <a title="Status" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&action=samstatus&stschgto=<?php echo $status;?>&id=<?php echo $pData['sampleId'];?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>"><?php echo $conStatus;?></a>
                            
                          <a title="View" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=sample&editid=<?php echo $editid;?>&sampleId=<?php echo $pData['sampleId'];?>&page=<?php echo $page; ?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&type=<?php echo $type;?>"><img src="images/view.png" alt="" width="16" height="16" border="0" /></a>	
                            
                          <a title="Delete" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&action=prodelete&id=<?php echo $pData['sampleId'];?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>&confirm=ASK" class="ask"><img src="images/delete.png" alt="" width="16" height="16" border="0" /></a>
                           
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