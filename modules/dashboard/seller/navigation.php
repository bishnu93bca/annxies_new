<div class="col-md-3 content_left">
    <a class="btn btn-primary <?php echo (!$dtaction)? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH;?>" role="button">General</a>
    <a class="btn btn-primary <?php echo ($dtaction == 'messages')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/message1/';?>" role="button">Messages<span class="badge"><?php $mescount =$eObj->mesCount($_SESSION['FUSERID']);    
        echo $mescount;?></span></a>
    <?php
    if($planData['plan']=='standard')
    {
        ?>
        <a class="btn btn-primary <?php echo ($dtaction == 'email')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/email/';?>" role="button"> E-mail <span class="badge"><?php echo $eObj->nrunread(2, $_SESSION['FUSERID']);?></span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'products')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/products/';?>" role="button">Products / Service <span class="badge"><?php echo $eObj->nrproduct($_SESSION['FUSERID']);?></span></a>
        <?php
    } else {
        $cmp= $eObj->companyInfobyUserId($_SESSION['FUSERID']);
        ?>
        <a class="btn btn-primary <?php echo ($dtaction == 'voice_mail')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/voice_mail/';?>" role="button">Voice Mail<span class="badge"><?php echo $eObj->nrunread(1, $_SESSION['FUSERID']);?></span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'email')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/email/';?>" role="button"> E-mail <span class="badge"><?php echo $eObj->nrunread(2, $_SESSION['FUSERID']);?></span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'paper')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/paper/';?>" role="button"> Paper <span class="badge"><?php echo $eObj->nrunread(3, $_SESSION['FUSERID']);?></span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'booking')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/booking/';?>" role="button">Booking</a>
        <a class="btn btn-primary <?php echo ($dtaction == 'products')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/products/';?>" role="button">Products / Service <span class="badge"><?php echo $eObj->nrproduct($_SESSION['FUSERID']);?></span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'samples')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/samples/';?>" role="button">Samples <span class="badge"><?php $smplCount=$eObj->smproduct($_SESSION['FUSERID']); echo $smplCount;?></span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'sample-requests')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/sample-requests/';?>" role="button">Sample Requests<span class="badge"><?php $smplRCount=$eObj->smpRequestCount($cmp['id']); echo $smplRCount;?></span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'requirements')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/requirements/';?>" role="button">Requirements <span class="badge">
        <?php $reqm =$eObj->reqCount($cmp['id']);    
        echo $reqm;?></span></a>
        <?php
    }
    
    if($planData['plan']=='silver')
    {
        ?>
        <a class="btn btn-primary <?php echo ($dtaction == 'upgrade-as')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/upgrade-as/';?>" role="button">Sales Representative <span class="badge">Upgrade</span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'upgrade-am')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/upgrade-am/';?>" role="button">Marketing Updates <span class="badge">Upgrade</span></a>
        <!--<a class="btn btn-primary <?php echo ($dtaction == 'upgrade-al')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/upgrade-al/';?>" role="button">Legal Services <span class="badge">Upgrade</span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'upgrade-at')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/upgrade-at/';?>" role="button">Tax Services <span class="badge">Upgrade</span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'upgrade-af')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/upgrade-af/';?>" role="button">Fundrasing Activities <span class="badge">Upgrade</span></a>-->
        <?php
    }
    elseif($planData['plan']=='gold')
    {
        ?>
        <a class="btn btn-primary <?php echo ($dtaction == 'sales')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/sales/';?>" role="button">Sales Representative <span class="badge"><?php echo $eObj->nrunread(4, $_SESSION['FUSERID']);?></span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'upgrade-am')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/upgrade-am/';?>" role="button">Marketing Updates <span class="badge">Upgrade</span></a>
        <!--<a class="btn btn-primary <?php echo ($dtaction == 'upgrade-al')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/upgrade-al/';?>" role="button">Legal Services <span class="badge">Upgrade</span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'upgrade-at')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/upgrade-at/';?>" role="button">Tax Services <span class="badge">Upgrade</span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'upgrade-af')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/upgrade-af/';?>" role="button">Fundrasing Activities <span class="badge">Upgrade</span></a>-->
        <?php
    }
    elseif($planData['plan']=='platinum')
    {
        ?>
        <a class="btn btn-primary <?php echo ($dtaction == 'sales')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/sales/';?>" role="button">Sales Representative <span class="badge"><?php echo $eObj->nrunread(4, $_SESSION['FUSERID']);?></span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'marketing')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/marketing/';?>" role="button">Marketing Updates <span class="badge"><?php echo $eObj->nrunread(5, $_SESSION['FUSERID']);?></span></a>
        <!--<a class="btn btn-primary <?php echo ($dtaction == 'legal')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/legal/';?>" role="button">Legal Services <span class="badge"><?php echo $eObj->nrunread(6, $_SESSION['FUSERID']);?></span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'tax')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/tax/';?>" role="button">Tax Services <span class="badge"><?php echo $eObj->nrunread(7, $_SESSION['FUSERID']);?></span></a>
        <a class="btn btn-primary <?php echo ($dtaction == 'fund')? 'btn-active':'';?>" href="<?php echo $SITE_DASHBOARD_PATH.'/fund/';?>" role="button">Fundrasing Activities <span class="badge"><?php echo $eObj->nrunread(8, $_SESSION['FUSERID']);?></span></a>-->
        <?php
    }
    ?>
</div><!-- left_menu ends --> 