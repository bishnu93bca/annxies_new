<?php 
$obj     = new adminProductClass();
$cobj    = new adminCategory();
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
            <li class="sl" style="width:15%">Porduct</li>
            <li class="sl" style="width:15%">Category</li>
            <li class="sl" style="width:15%">Keyword</li>
            <li class="sl" style="width:25%">Description</li>  
        </ul>
        
		 <ul class="table_elem">
            <?php                             
            $ExtraQryStr .= " AND userid=".addslashes($editid);
            $countRow = $obj->productCount($ExtraQryStr);	
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
                                    
                $fetch_Details = $obj->getProductByLimit($ExtraQryStr,$start,$limit);	
                
                $pages = $p->findPages($countRow, $limit);
                if($page>1)
                    $slNo = (($page - 1)*$limit)+1;
                else
                    $slNo = 1;

                foreach($fetch_Details as $pData)
                {  
                    if($pData['status'] == '1')
					{
						$conStatus = '<img src="images/active.png" alt="Active" width="15" border="0" />';
						$status="0";
					}
					else
					{
						$conStatus = '<img src="images/inactive.png" alt="Inactive" width="15" border="0" />';
						$status="1";
					}
                    
                    ?>
                    <li>
                        <span class="sl" style="width:5%"><?php echo $slNo;?></span>                         
                        <span class="sl" style="width:15%">
                            <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=product&editid=<?php echo $editid;?>&proId=<?php echo $pData['id'];?>&page=<?php echo $page; ?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&type=<?php echo $type;?>">
                                <?php 
                                if($pData['p_name']){
                                 if(strlen($pData['p_name'])>25)
                                    echo substr($pData['p_name'],0,23).'...'; 
                                else
                                    echo $pData['p_name'];
                                }
                                ?>
                            </a>
                        </span> 
                        <?php $cName = $cobj->categoryById($pData['p_category']);?>
                        <span class="sl" style="width:15%">
                            <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=product&editid=<?php echo $editid;?>&proId=<?php echo $pData['id'];?>&page=<?php echo $page; ?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&type=<?php echo $type;?>">
                            <?php echo ($cName['category'])? $cName['category']:'-';?>
                            </a>
                        </span>
                        <span class="sl" style="width:15%">
                            <?php                      
                            if($pData['p_keyword']){
                             if(strlen(strip_tags($pData['p_keyword']))>18)
                                echo substr(strip_tags($pData['p_keyword']),0,15).'...'; 
                            else
                                echo strip_tags($pData['p_keyword']);
                            }
                            else 
                                echo '-';            
                            ?>
                        </span>
                        <span class="sl" style="width:30%">
                        <?php   
                        if($pData['p_bdes']){
                         if(strlen(strip_tags($pData['p_bdes']))>48)
                            echo substr(strip_tags($pData['p_bdes']),0,45).'...'; 
                        else
                            echo strip_tags($pData['p_bdes']);
                        }
                        else 
                            echo '-';
                        ?></span>
                        <span class="last_li">
                          <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&action=prostatus&stschgto=<?php echo $status;?>&id=<?php echo $pData['id'];?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>"><?php echo $conStatus;?></a>
                            
                          <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=product&editid=<?php echo $editid;?>&proId=<?php echo $pData['id'];?>&page=<?php echo $page; ?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&type=<?php echo $type;?>"><img src="images/view.png" alt="" width="16" height="16" border="0" /></a>	
                            
                          <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&action=prodelete&id=<?php echo $pData['id'];?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>&confirm=ASK" class="ask"><img src="images/delete.png" alt="" width="16" height="16" border="0" /></a>
                           
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