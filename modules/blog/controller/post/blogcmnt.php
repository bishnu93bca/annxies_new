<style>  
    .cmsts h1 {
        font-size: 20px !important;
        line-height: 24px;
        padding:0 0 5px 0px;
    }
    .cmnt_rslt h3{
        font-size: 13px !important;
    }
    .cmsts h3 {
        font-size: 15px !important;
        padding:0 0 5px 0px;
    }
    .cmnt_rslt > ul {
        width: 100%;
    }
    .cmnt_rslt > ul >li{
        border: 1px dashed #999;
        padding: 18px;
        text-align: justify;
        margin-bottom: 8px;
        position:relative;
    }
    
    .cmnt_rslt > ul > li span {
        bottom: -2px;
        position: absolute;
        right: 1px;
    }
</style>
<?php
$obj = new PostClass();
$menu           = new menu();
$menudata       = $menu -> menu_by_id($moduleId);
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
    <li><a href="#"><?php echo $menu_name;?><span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?><span>→</span></a></li>
    <li><a href="#">View Blog Comments</a></li>
    <li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $moduleId;?>'">Add New Blog</a></div></li>
</ul>
<?php
    $blog_details = $obj->blogById($editid);
    $cmtData =  $obj->getComment('1',$blog_details['blogId'],0,9999);
?>

<div class="form_holder cmsts">
    <h1><?php echo $blog_details['blogTitle'];?></h1>
    <h3><?php echo $blog_details['blogDate'];?></h3>
    <p><?php echo $blog_details['blogContent'];?></p>
</div>

<div class="form_holder">
    <p class="description-line1">Comments</p>
    <div class="cmnt_rslt">
        <ul>
        <?php
        if($cmtData){
            foreach($cmtData as $ck=>$v){
                if($cmtData[$ck]['isApproved'] == 'Y')
                {
                    $conStatus = '<img src="images/active.png" alt="Active" title="Approved" width="15" border="0" />';
                    $isApproved="N";
                }
                else
                {
                    $conStatus = '<img src="images/inactive.png" alt="Inactive" title="Not Approved" width="15" border="0" />';
                    $isApproved="Y";
                }
                ?>
                <li>
                    <div style="float:left; width:18%">
                        <h3>Name : <?php echo $cmtData[$ck]['blogAuthor'];?></h3>
                        <h3>Email : <?php echo $cmtData[$ck]['authoreMail'];?></h3>
                        <h3>Date : <?php echo $cmtData[$ck]['blogDate'];?></h3>
                        <span>
                            <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&isApprovedchgto=<?php echo $isApproved?>&id=<?php echo $cmtData[$ck]['blogId'];?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>"><?php echo $conStatus;?></a>
                            <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&id=<?php echo $cmtData[$ck]['blogId'];?>&redstr=<?php echo $redirectString;?>" class=""><img src="images/trash.png" alt="trash" title="Delete"  border="0" /></a>
                        </span>
                    </div>
                    <div style="float:right; width:81%">
                        <p><?php echo $cmtData[$ck]['blogContent'];?></p>
                    </div>
                </li>
                <?php
            }
        }
        else
            echo '<li>No Comments Yet</li>';
        ?>
        </ul>
    </div>
</div>
<?php echo $ErrMsg;?>
<div class="form_holder">
    <form action="" method="post">
        <div style="float:left; width:49%">
            <p class="description-line1">Name *</p>
            <input type="text" placeholder="Type Name" name="blogAuthor" value="<?php echo SITE_NAME;?>">
            <p class="description-line1">Email *</p>
            <input type="text" placeholder="Type Email" name="authoremail" value="<?php echo SITE_EMAIL;?>">
        </div>
        <div style="float:right; width:49%">
            <p class="description-line1">Message *</p>
            <textarea name="blogContent" style="height:82px"></textarea>
        </div>
        <div style=" width:100%; float:left">
            <p  class="description-line1">		
                <span class="save_button-box">           
                    <input type="hidden" name="SourceForm" value="BlogCommentss" />
                    <input type="hidden" value="<?php echo $blog_details['blogId'];?>" class="buttons" name="blogId" />
                    <input type="hidden" value="<?php echo $blog_details['blogTitle'];?>" class="buttons" name="blogTitle" /><input type="hidden" value="<?php echo $blog_details['blogParent'];?>" class="buttons" name="blogParent" /><input type="hidden" value="<?php echo $blog_details['categoryId'];?>" class="buttons" name="categoryId" />		
                    <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
                    <input name="Save" type="submit" class="save_frm" value="Save" />
                    <input name="Cancel" type="button"  onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $moduleId;?>'" class="save_frm" value="Close" />
                    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                </span>			
            </p>
        </div>
    </form>
</div>
