<?php
$iData = $eObj->myFavouriteInstitutes($_SESSION['FUSERID'], 1, 0, 30)
?>
<div class="collegein_list">
    <ul class="ul">
        <?php 
        foreach($iData as $institute){
            include("institute_item.php");
        }?>
    </ul>
</div>