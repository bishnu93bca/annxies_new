<?php
$ExtraQryStr            = 1;
$friendData             = $eObj->getFriendList($_SESSION['FUSERID'], $ExtraQryStr, 0, 30);

if($friendData){
    ?>
    <ul class="col3 clearfix">
        <?php 
        foreach($friendData as $resource){
            
            include("resource.php");
        }?>
    </ul>
    <?php
}
?>