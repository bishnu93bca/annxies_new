<?php   
$error  = 0;
$post    = $eObj->memberPostBypermalink($_SESSION['FUSERID'], $track);
if(!$post){
    $error = 1;
    $ErrMsg = 'error>You are not allowed to perform this action.';

    $pData      = $eObj->getPostBypermalink($track); 
    if($pData){
        $parentId   = $pData['parentId'];
        
        while($parentId){
            $pData      = $eObj->getPostById($parentId);
            $parentId   = $pData['parentId'];
        }

        if($pData['memberId'] == $_SESSION['FUSERID']){
            $error  = 0;
            $ErrMsg = '';
            $actOn = 'comment';
        }   
    }
}
else{
    if($post['parentId'])
        $actOn = 'comment';
    else
        $actOn = 'post';
}
if(!$error) {
    if($dtaction == 'delete-post')
        $subHeading = 'Delete';
    else
        $subHeading = 'Edit';
    ?>
    <div class="post_form">
        <div class="sp_box inq_box clearfix">	
            <div class="subheading"><?php echo $subHeading;?> Post</div>
        </div>
        <form id="edtpstfrm" method="post" action="">
            <ul>
                <li>
                    <div>
                        <?php if($dtaction == 'edit-post') {?>
                        <textarea name="post" class="emojiable-option"><?php echo $post['post'];?></textarea>
                        <?php } else {?>
                        Are you sure you want to delete this <?php echo $actOn;?>?
                        <?php }?>
                    </div>  
                </li> 
                <li>
                    <div class="btn_pr">
                        <button type="submit" class="btn">
                            <?php echo ($subHeading=='Delete')? $subHeading:'Save';?>
                        </button>
                        <?php if($dtaction == 'delete-post') {?>
                        <input type="hidden" name="SourceForm" value="DeletePost">
                        <?php } else {?>
                        <input type="hidden" name="SourceForm" value="EditPost">
                        <?php }?>
                        
                        <input type="hidden" name="ajax" value="1">
                        <input type="hidden" name="permalink" value="<?php echo $track;?>">
                    </div>
                </li>
            </ul>
        </form>
            
    </div>
    <?php
}
else
    echo $ErrMsg;
?>