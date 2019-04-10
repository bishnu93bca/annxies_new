<div class="fav_details">
    <?php 
    $jData = $eObj->myAppliedJobs($_SESSION['FUSERID'], 1, 0, 30);
    if($jData){
    ?>
    <div class="searchp_list">
        <ul class="ul">
            <?php 
            foreach($jData as $job){
                include('ajxload/job_item.php');
            }
            ?>
        </ul>
    </div>
    
    <?php } else echo 'No application found.';?>
</div>