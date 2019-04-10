<?php
if(!empty($galCatId))
	$moduleId = $galCatId;
	
if(!empty($moduleId))
	$galleryCategoryId=$moduleId;
else
	$galleryCategoryId=0;

$obj = new GalleryClass();
$last_msg_id=$_GET['last_msg_id'];
$action=$_GET['action'];

if($action <> "get")
{
    $menu=new menu();
    $menudata= $menu -> menu_by_id($moduleId);
    if($menudata)
    {
        $menu_image = $menudata['menu_image'];
        $menu_name = $menudata['menu_name'];
        $parentMenuId = $menudata['parent_id'];
        $parentmenudata= $menu -> menu_by_id($parentMenuId);

        $parent_menu_name = $parentmenudata['menu_name'];
    }
    ?>
    <ul id="breadcrumb">
        <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
        <li><a href="#"><?php echo $parent_menu_name;?></a></li>
        <li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=new&galleryCategoryId=<?php echo $galleryCategoryId;?>&type=<?php echo $type;?>&moduleId=<?php echo $_REQUEST['moduleId'];?>'">Add Photos</a></div></li>
    </ul>

    <?php 
    if($_SESSION['ErrMsg'])
    {
        echo $_SESSION['ErrMsg'];
        unset($_SESSION['ErrMsg']);
    } 
    $_SESSION['PAGE'] = $pageType;
    $obj = new GalleryClass();
    ?>
    <script type="text/javascript" src="js/jquery-1.2.6.pack.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            function last_msg_funtion() 
            {		   
               var ID=$(".message_box:last").attr("id");
                $('div#last_msg_loader').html('<img src="images/loader.gif">');
                $.post("photomanagement/index.php?action=get&last_msg_id="+ID+"&galleryCategoryId="+<?php echo $moduleId;?>,

                function(data){
                    if (data != "") {
                    $(".message_box:last").after(data);			
                    }
                    $('div#last_msg_loader').empty();
                });
            };  

            $(window).scroll(function(){
                if  ($(window).scrollTop() == $(document).height() - $(window).height()){
                   last_msg_funtion();
                }
            }); 

        });
    </script>
    <form action="index.php?pageType=<?php echo $pageType?>&dtls=<?php echo $dtls?>" name="myForm" method="POST" >
        <div class="clear"></div>
        <div id="header_banner">	
            <?php include("load_first.php");?>	
        </div>
        <!--<div id="last_msg_loader"><h2 class="description-text">please scroll down to view more</h2></div>-->
    <?php
}
else
	include('load_second.php');
?>	

