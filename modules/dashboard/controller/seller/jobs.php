<?php
$rObj    = new MemberAdmin();
$jObj    = new JobsAdmin;
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

?>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
    <?php if($editid) {?>
    <li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $moduleId;?>'">Add Recruiter</a></div></li>
    <?php }?>
</ul>
<?php

$ExtraQryStr = "recruiterId=$editid ";

if ($srchtxt)
	$_SESSION['srchtxt'] = $srchtxt;
if($_SESSION['srchtxt'])
    $ExtraQryStr .= " and (username='".addslashes($_SESSION['srchtxt'])."' or  fullname='".addslashes($_SESSION['srchtxt'])."' or email='".addslashes($_SESSION['srchtxt'])."')";

if(isset($clear))
{
	$_SESSION['srchtxt'] 	= '';
	$ExtraQryStr 			= "1";
}
if($editid){
	$cData    		= $rObj->getRecruiterInfoByid($editid);
	$id 			= $editid;
	$username 		= $cData['username'];
	$email 			= $cData['email'];
	$fullname 		= $cData['fullname'];
	$city 			= $cData['city'];
	$state 			= $cData['state'];
	$phone 			= $cData['phone'];
	$status 		= $cData['status'];
	$createDate	 	= $cData['createDate'];
	$photo		 	= $cData['profilePic'];
    
    include("intro.php");
}
?>






<form action="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>" name="myForm" method="POST">

	<div class="table">
        
        <ul class="table_head ui-sortable">
            <li class="sl">Sl.</li>
            <li class="t_days" style="width:25%">Job Title</li>
            <li class="u_name" style="width:30%">Company </li>
            <li class="t_present" style="width:25%">Entry Date</li>
            <li class="toggle_select"></li>
        </ul>
        
		 <ul class="table_elem">
            <?php                        
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
            //include($ROOT_PATH."/".MODULE_PATH."/dashboard/controller/jobs/list.php");
            $fetch_Details = $jObj -> getJobsDetails($ExtraQryStr, $start, $limit);

            if(sizeof($fetch_Details)>0)
            {
                $countRow = $jObj->jobsCount($ExtraQryStr);   
                $pages = $p->findPages($countRow, $limit);
                if($page>1)
                    $slNo = (($page - 1)*$limit)+1;
                else
                    $slNo = 1;

                foreach($fetch_Details as $cData)
                {                                               

            ?>
                  <li>
                    <span class="sl"><?php echo $slNo;?></span>
                    <span class="t_days" style="width:25%"><a href="index.php?pageType=organization&dtls=jobs&dtaction=add&editid=<?php echo $cData['id'];?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>"><?php echo $cData['jobTitle'];?></a></span>                      
                    <span class="u_name" style="width:30%"><?php echo $cData['companyName'];?></span>    
                    <span class="t_present" style="width:25%"><?php echo date('jS M, Y', strtotime($cData['entryDate']));?></span>                                                 
                    <span class="last_li">
                    <a href="index.php?pageType=organization&dtls=jobs&dtaction=add&editid=<?php echo $cData['id'];?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>"><img src="images/edit.gif" alt="" width="16" height="16" border="0" /></a>
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
    <input name="Back" type="button" onclick="history.back(-1);" class="back"  value="Back" />
</form>