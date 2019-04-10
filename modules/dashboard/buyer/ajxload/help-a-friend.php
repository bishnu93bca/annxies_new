<?php
$ExtraQryStr = 1;
$pData       = $eObj->getFPost($_SESSION['FUSERID'], $ExtraQryStr, 0, 30);
?>
<div class="social_body_bg">
    <div class="question_wrap">
        <?php
        if($pData){
            $sl = 0;
            foreach($pData as $record){
                include("post.php");
                $sl++;
            }
        }
        else
           echo 'No question yet.'; 
        ?>
    </div>
</div>