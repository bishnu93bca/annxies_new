<?php
$obj = new MenuCategory();
$menu = new menu();
$permission_array = explode(',', $_SESSION['PERMISSION']); 
?>
<div class="offmenu"><i class="fa fa-chevron-left"></i></div>
<aside id="navigation" class="mCustomScrollbar">
    <nav>
        <ul>			
			<?php
            if($_SESSION['UTYPE']=="A")
            {
                ?>
                <li <?php if($pageType=='modulemanagement') echo 'class="active"';?>><a href="javascript:void(0);">Modules</a>
                    <ul>
                        <li><a href="index.php?pageType=modulemanagement&dtls=modules" <?php if($dtls=='modules'){ echo 'class="active"';}?>>Install / Uninstall</a></li>                        
                    </ul>
                </li>            
                <li <?php if($pageType=='usermanagement') echo 'class="active"';?>><a href="javascript:void(0);">Administrators</a>
                    <ul>
                        <li>
                            <a href="index.php?pageType=usermanagement" <?php if($pageType=='usermanagement'){ echo 'class="active"';}?>>User</a>
                        </li>				
                    </ul>
                </li>		
                <?php 
            } 
			$menudata = $menu -> get_menu();
			$sub=5;
            foreach($menudata as $md)
			//for($i=0;$i<sizeof($menudata);$i++)
			{
				if($md['parent_id']==0)
				{
					$chk='false';
					foreach($permission_array as $val)
					{
						if($md['menu_id']==$val)
							$chk ='true';
					}
					if($_SESSION['UTYPE']=="A")
						$chk='true';
					if($chk=='true')
					{
						$sub++;

						// Include class files for individual modules.
						//-------------------------------------------
						if($md['menu_id']!='82'){
                            if($md['menu_id']==1)
                            {
                              ?>
                                <li <?php if($pageType==$md['parent_dir']) echo 'class="active"';?>>
                                    <a href="javascript:void(0);"><?php echo $md['menu_name']?></a>
                                    <ul>
                                        <?php	                                                                               
                                        $ExtraQryStr = 'parentId=0 and moduleId=0 and status="Y"';
                                        $fetch_Details = $obj->getCategory($ExtraQryStr,$_SESSION['SITE_ID'],$Link);
                                        if(sizeof($fetch_Details)>0)
                                        {								
                                            for($row=0; $row<sizeof($fetch_Details); $row++)
                                            {
                                                if($fetch_Details[$row]['isContent']=='Y' || $fetch_Details[$row]['isGallery']=='Y')
                                                {
                                                    ?>
                                                    <li>
                                                        <a href="index.php?pageType=content&editid=<?php echo $fetch_Details[$row]['categoryId'];?>" <?php if($pageType=='content' && $editid==$fetch_Details[$row]['categoryId']){ echo 'class="active"';}?> title="<?php echo $fetch_Details[$row]['categoryName'];?>">
                                                            <?php echo $fetch_Details[$row]['categoryName'];?>
                                                        </a>
                                                        <?php										
                                                        $parentMenuId = $fetch_Details[$row]['categoryId'];											
                                                        $menuData = $obj -> getCMSMenuByparentId($parentMenuId,$Link);											
                                                        if($menuData)
                                                        {
                                                            echo '<ul>';												
                                                            for($sm=0;$sm<sizeof($menuData);$sm++)
                                                            {
                                                                if($menuData[$sm]['moduleId']==0)
                                                                {
                                                                    ?>
                                                                    <li><a href="index.php?pageType=content&editid=<?php echo $menuData[$sm]['categoryId'];?>" <?php if($pageType=='content' && $editid==$menuData[$sm]['categoryId']){ echo 'class="active"';}?> title="<?php echo $menuData[$sm]['categoryName'];?>"><?php echo $menuData[$sm]['categoryName'];?></a></li>						
                                                                    <?php
                                                                }
                                                            }												
                                                            echo '</ul>';										
                                                        }										

                                                        if($fetch_Details[$row]['moduleId']!=0)									
                                                        {																			
                                                            $submoduledata = $menu -> get_submenu(1,$fetch_Details[$row]['moduleId']);

                                                            if($submoduledata)
                                                            {
                                                                echo '<ul>';
                                                                for($submod=0;$submod<sizeof($submoduledata);$submod++)
                                                                {
                                                                    echo '<li><a href="index.php?pageType='.$submoduledata[$submod]['parent_dir'].'&dtls='.$submoduledata[$submod]['child_dir'].'&type='.$submoduledata[$submod]['menu_name'].'&moduleId='.$submoduledata[$submod]['menu_id'].'"> >> '.$submoduledata[$submod]['menu_name'].'</a></li>';
                                                                }
                                                                echo '</ul>';
                                                            }
                                                        }
                                                        ?>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        }						
                                        ?>
                                    </ul>
                                </li>				
                                <?php
                            }
                            else
                            {
                                ?>				
                                <li <?php if($pageType==$md['parent_dir']) echo 'class="active"';?>>
                                   	<a href="javascript:void(0);">
                                    <?php
									if(file_exists($MEDIA_FILES_ROOT.'/menu/thumb/'.$md['menu_image']) && $md['menu_image'])
										echo '<img src="'.$MEDIA_FILES_SRC.'/menu/thumb/'.$md['menu_image'].'">';
									echo $md['menu_name'];?></a>
                                    <ul>			
                                        <?php 
                                        for($j=0; $j<sizeof($menudata); $j++)
                                        {
                                            $chk='false';
                                            foreach($permission_array as $val)
                                            {
                                                if($menudata[$j]['menu_id']==$val)
                                                $chk ='true';
                                            }
                                            if($_SESSION['UTYPE']=="A")
                                                $chk='true';
                                            if($menudata[$j]['parent_id']==$md['menu_id'] && $chk=='true')
                                            {
                                                if($md['menu_name']=='Site Page')
                                                {										
                                                    if($menudata[$j]['menu_name']=='Add Page')
                                                    {
                                                        ?>
                                                        <li><a href="index.php?pageType=<?php echo $menudata[$j]['parent_dir'];?>&dtaction=new&moduleId=<?php echo $menudata[$j]['menu_id'];?>" <?php if($_REQUEST['moduleId']==$menudata[$j]['menu_id']){ echo 'class="active"';}?>>
                                                            <?php 
                                                            if(file_exists($MEDIA_FILES_ROOT.'/menu/thumb/'.$menudata[$j]['menu_image']) && $menudata[$j]['menu_image'])
															echo '<img src="'.$MEDIA_FILES_SRC.'/menu/thumb/'.$menudata[$j]['menu_image'].'">';
                                                            echo $menudata[$j]['menu_name'];?></a></li>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <li><a href="index.php?pageType=<?php echo $menudata[$j]['parent_dir']?>&type=<?php echo str_replace(' ','-',$menudata[$j]['menu_name'])?>&moduleId=<?php echo $menudata[$j]['menu_id'];?>" <?php if($_REQUEST['moduleId']==$menudata[$j]['menu_id']){ echo 'class="active"';}?>>
                                                            <?php 
                                                            if(file_exists($MEDIA_FILES_ROOT.'/menu/thumb/'.$menudata[$j]['menu_image']) && $menudata[$j]['menu_image'])
															echo '<img src="'.$MEDIA_FILES_SRC.'/menu/thumb/'.$menudata[$j]['menu_image'].'">';
                                                            echo $menudata[$j]['menu_name']?></a></li>
                                                        <?php
                                                    }													
                                                }	
                                                else
                                                {
                                                    ?>
                                                    <li><a href="index.php?pageType=<?php echo $menudata[$j]['parent_dir'];?>&dtls=<?php echo $menudata[$j]['child_dir'];?>&type=<?php echo strtolower(str_replace(' ','-',$menudata[$j]['menu_name']));?>&moduleId=<?php echo $menudata[$j]['menu_id'];?>" <?php if($_REQUEST['moduleId']==$menudata[$j]['menu_id']){ echo 'class="active"';}?>>
                                                    	<?php
														if(file_exists($MEDIA_FILES_ROOT.'/menu/thumb/'.$menudata[$j]['menu_image']) && $menudata[$j]['menu_image'])
															echo '<img src="'.$MEDIA_FILES_SRC.'/menu/thumb/'.$menudata[$j]['menu_image'].'">';
														
														echo $menudata[$j]['menu_name'];?>
                                                  		
                                                   </a></li>
                                                    <?php
                                                }								
                                            }
                                        }?>
                                    </ul>
                                </li>					
                                <?php				 
                            }
                        }
					}
				}
			}
			?>
        </ul>
    </nav>
</aside><!--end of the navigation-->