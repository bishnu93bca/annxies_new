
    <?php
    unset($_SESSION['temp']);
    $limit = 999;
    $start = 0;
    $fetch_Details = $obj -> galleryDetailsBygalleryCategoryId($galleryCategoryId, $start, $limit);
    if(sizeof($fetch_Details)>0)
    {
        $slNo = 1;
        for($i=0;$i<sizeof($fetch_Details);$i++)
        {
            $msgID= $fetch_Details[$i]['id'];

            if($fetch_Details[$i]['status'] == 'Y')
            {
                $conStatus = '<img src="images/active.png" alt="active" border="0" />';
                $status="N";
            }
            else
            {
                $conStatus = '<img src="images/inactive.png" alt="inactive" border="0" />';
                $status="Y";
            }
            ?> 
            <div id="<?php echo 'recordsArray_'.$msgID; ?>"  align="left" class="message_box" >			
                <span class="u_name"><a href="../uploadedfiles/photo/gallery/large/<?php echo $fetch_Details[$i]['imagepath']; ?>" class="preview" target="_blank"><img src="../uploadedfiles/photo/gallery/thumb/<?php echo $fetch_Details[$i]['imagepath'];?>" border="0" height="150" width="150" /></a></span>

                <div class="clear"></div>							

                <span class="t_present"><?php echo $fetch_Details[$i]['bannername'];?></span>	

                <span class="last_li">
                    
                <a title="status" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $status?>&galleryCategoryId=<?php echo $galleryCategoryId;?>&id=<?php echo $fetch_Details[$i]['id'];?>&type=<?php echo $type;?>&moduleId=<?php echo $_REQUEST['moduleId'];?>&redstr=<?php echo $redirectString;?>" class="ask"><?php echo $conStatus;?></a>

                <a title="edit"  href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=new&editid=<?php echo $fetch_Details[$i]['id'];?>&type=<?php echo $type;?>&galleryCategoryId=<?php echo $galleryCategoryId;?>&moduleId=<?php echo $_REQUEST['moduleId'];?>&redstr=<?php echo $redirectString;?>" class="ask"><img src="images/edit.gif" alt="edit" border="0" /></a>

                <a title="delete" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&galleryCategoryId=<?php echo $galleryCategoryId;?>&id=<?php echo $fetch_Details[$i]['id'];?>&type=<?php echo $type;?>&redstr=<?php echo $redirectString;?>" class="ask"><img src="images/delete.png" alt="delete" border="0" /></a></span>	

            </div>
            <?php
            $slNo++;

        }
    }
    else
    {
        ?>
        <p class="decription-line1" style="text-align:center; line-height:30px;">No Record Present</p>
        <?php
    }
    ?>