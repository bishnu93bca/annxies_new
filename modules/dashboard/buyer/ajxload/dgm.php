<?php 
if($dtaction == 'create-group')
    include("group_create.php");
else{
    $fData  = $eObj ->getGroupBypermalink($group, $_SESSION['FUSERID']);
    if($dtaction == 'exit-from-group'){
        if(!$fData['isAdmin']){
            ?>
            <div class="post_form">
                <div class="sp_box inq_box clearfix">	
                    <div class="subheading">
                        Quit From : <?php echo $fData['groupName'];?>
                    </div>
                </div>
                <form id="xgrpfrm" method="post" action="">
                    <ul>
                        <li>
                            <div>
                                Are you sure to quit from <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/group/'.$fData['publicId'].'/';?>"><?php echo $fData['groupName'];?></a>? 
                            </div>  
                        </li> 
                        <li>
                            <div class="btn_pr">
                                <button type="submit" class="btn">
                                    Quit
                                </button>

                                <input type="hidden" name="SourceForm" value="XGrp">

                                <input type="hidden" name="ajax" value="1">
                                <input type="hidden" name="group" value="<?php echo $fData['publicId'];?>">
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
            <?php
        }
        else
            echo 'error>Being an admin, you can\'t leave this group.';
    }
    elseif($fData['isAdmin']){
        if($dtaction == 'delete-group'){
            ?>
            <div class="post_form">
                <div class="sp_box inq_box clearfix">	
                    <div class="subheading">
                        Delete Group : <?php echo $fData['groupName'];?>
                    </div>
                </div>
                <form id="dgrpfrm" method="post" action="">
                    <ul>
                        <li>
                            <div>
                                This action will permanently delete the group and all relevant conevrsation history.
                                <br>
                                Are you sure to delete <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/group/'.$fData['publicId'].'/';?>"><?php echo $fData['groupName'];?></a>? 
                            </div>  
                        </li> 
                        <li>
                            <div class="btn_pr">
                                <button type="submit" class="btn">
                                    Delete
                                </button>

                                <input type="hidden" name="SourceForm" value="DGrp">

                                <input type="hidden" name="ajax" value="1">
                                <input type="hidden" name="group" value="<?php echo $fData['publicId'];?>">
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
            <?php
        }
        else{
            ?>
            <div class="post_form">
                <div class="sp_box inq_box clearfix">	
                    <div class="subheading">
                        <?php 
                        echo $fData['groupName'].' : '; 
                        echo ($dtaction == 'add-group-member')? 'Add Member':'Delete Member';
                        ?>
                    </div>
                </div>
                <?php
                if($dtaction == 'delete-group-member'){
                    $mData = $eObj ->getAnyMemberBypublicId($member);
                    ?>
                    <form id="dgmfrm" method="post" action="">
                        <ul>
                            <li>
                                <div>
                                    Are you sure to delete <a href="<?php echo $SITE_DASHBOARD_PATH.'/profile/'.$mData['publicId'].'/';?>"><?php echo $mData['fullname'];?></a> from <?php echo $fData['groupName'];?>?
                                </div>  
                            </li> 
                            <li>
                                <div class="btn_pr">
                                    <button type="submit" class="btn">
                                        Delete
                                    </button>

                                    <input type="hidden" name="SourceForm" value="DGM">

                                    <input type="hidden" name="ajax" value="1">
                                    <input type="hidden" name="group" value="<?php echo $fData['publicId'];?>">
                                    <input type="hidden" name="member" value="<?php echo $mData['publicId'];?>">
                                </div>
                            </li>
                        </ul>
                    </form>
                    <?php
                }
                else{
                    ?>
                    <form id="agmfrm" method="post" action="">
                        <ul>
                            <li>
                                <div class="pf_right autosuggest">
                                    <div class="selmem"></div>
                                    <input type="text" autocomplete="off" id="srchmem" name="srchtxt" placeholder="Add to Group: " value="">
                                    <div class="autopop"></div>
                                    <input type="hidden" name="ActType" value="SearchAnyFrn">
                                </div>
                            </li> 
                            <li>
                                <div class="btn_pr">
                                    <button type="submit" class="btn">
                                        Done
                                    </button>

                                    <input type="hidden" class="sf" name="SourceForm" value="">

                                    <input type="hidden" name="ajax" value="1">
                                    <input type="hidden" class="ppl" name="people" value="">
                                    <input type="hidden" name="group" value="<?php echo $fData['publicId'];?>">
                                </div>
                            </li>
                        </ul>
                    </form>
                    <?php
                }
                ?>
            </div>
            <?php
        }
    }
    else
        echo 'error>You are not allowed to perform this action.';
}
?>