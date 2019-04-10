<?php
$jData = $eObj->myFavouriteJobs($_SESSION['FUSERID'], 1, 0, 30)
?>
<div class="collegein_list">
    <ul class="ul">
        <?php 
        foreach($jData as $job){
            include("job_item.php");
        }?>
    </ul>
</div>