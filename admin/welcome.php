<div class="admnwlc">
    <?php
    $permission_array = explode(',',$_SESSION['PERMISSION']);
    if($_SESSION['UTYPE']=="A")
    {
        ?> 	
        <div class="iconbox-thum-img">	
            <div class="iconwrap">
                <a class="link-text" href="index.php?pageType=modulemanagement&dtls=modules">
                    <img src="images/modules.png" alt="Modules" />
                    <span>Modules</span>
                </a> 
            </div>
        </div>
        <div class="iconbox-thum-img">    
            <div class="iconwrap">
                <a class="link-text" href="index.php?pageType=usermanagement">
                    <img src="images/user.png" alt="User" />
                    <span>User</span>
                </a>
            </div>
        </div>
        <?php
    }
    $menu   = new menu();
    $data   = $menu -> welcomepage_main_menu();
    $cObj   = new MemberAdmin();
    
    for($i=0;$i<sizeof($data);$i++)
    {
        $mm_id      =$data[$i]['menu_id'];
        $mm_name    =$data[$i]['menu_name'];
        $mm_image   =$data[$i]['menu_image'];

        $mm_trim    =substr($mm_name,0,-11);

        $chk        ='false';
        
        foreach($permission_array as $val)
        {
            if($data[$i]['menu_id']==$val)
                $chk ='true';
        }
        if($_SESSION['UTYPE']=="A")
            $chk='true';
        $info = $menu -> welcomepage_sub_menu($mm_id);
        if($data[$i]['menu_id']!='82'){
            if($mm_name!='Page Management' && $chk=='true')
            {
                for($j=0;$j<sizeof($info);$j++)
                {
                    $chk='false';
                    foreach($permission_array as $val)
                    {
                        if($info[$j]['menu_id']==$val)
                            $chk ='true';
                    }
                    if($_SESSION['UTYPE']=="A")
                        $chk='true';

                    if($chk=='true') //check permission
                    {
                        if($info[$j]['menu_id']!=123){
                            ?>		
                            <div class="iconbox-thum-img">
                                <div class="iconwrap">
                                <?php
                                if($mm_name=='Site Page')
                                {
                                    if($info[$j]['menu_name']=='Add Page')
                                    $link = '<a href="index.php?pageType='.$info[$j]['parent_dir'].'&dtls='.$info[$j]['child_dir'].'&dtaction=new&moduleId='.$info[$j]['menu_id'].'"  class="link-text">';
                                    else
                                    {						
                                        $link = '<a href="index.php?pageType='.$info[$j]['parent_dir'].'&dtls='.$info[$j]['child_dir'].'&moduleId='.$info[$j]['menu_id'].'"  class="link-text">';
                                    }
                                }
                                else
                                    $link = '<a class="link-text" href="index.php?pageType='.$info[$j]['parent_dir'].'&dtls='.$info[$j]['child_dir'].'&type='.strtolower(str_replace(' ','-',$info[$j]['menu_name'])).'&moduleId='.$info[$j]['menu_id'].'">';

                                echo $link;



                                if(file_exists($MEDIA_FILES_ROOT.'/menu/large/'.$info[$j]['menu_image']) && $info[$j]['menu_image'])
                                    echo '<img src="'.$MEDIA_FILES_SRC.'/menu/large/'.$info[$j]['menu_image'].'" alt="'.$info[$j]['menu_name'].'" border="0"/>';
                                else					
                                    echo '<img src="images/noiconw.png" alt="'.$info[$j]['menu_name'].'" border="0" />';

                                if($info[$j]['menu_id']==217){ // for member info
                                    echo '<em>'.$cObj->memberCount("usertype='Student'").'</em>';
                                }
                                elseif($info[$j]['menu_id']==229){ // for issue info
                                    echo '<em>'.$cObj->memberCount("usertype='Recruiter'").'</em>';
                                }
                            
                                echo '<span>'.$info[$j]['menu_name'].'</span>';

                                echo '</a>';
                                ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
            }
        }
    }
    ?>		
</div>