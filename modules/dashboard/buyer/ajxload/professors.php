<?php
$prData = $eObj->myFavouriteProfessors($_SESSION['FUSERID'], 1, 0, 30)
?>
<div class="image_list">
    <ul class="col4 clearfix">
        <?php 
        foreach($prData as $professor){
            include("professor_item.php");
        }?>
    </ul>
</div>