<?php $mObj = new MenuCategory();?>
<div id="newContent" style="display:none">
	<form name="modifycontentNew" action="" method="post">
		<div class="form_holder">
			<div class="description-line">
				<span class="description-line-text">Heading *</span>
				<span class="description-line-text">
				    <input type="text" name="contentHeadingNew" value="<?php echo $contentHeadingNew;?>" maxlength="200"  />
				</span>				
                <?php 
				$ExtraQryStr = "moduleId=".$parentMenuId;				  
				$data = $mObj -> getCategory($ExtraQryStr,$_SESSION['SITE_ID'],$Link);
				$count = sizeof($data);

				if($count>0)
				{ ?>
                    <div style="float:right; margin:0px;">
                    	<span class="description-line-text">For Page *
                            <select name="menucategoryId">					
                                <?php 
                                for($i=0; $i<sizeof($data); $i++)
                                {
                                    $categoryName=$data[$i]['categoryName'];
                                    $parentId=$data[$i]['parentId'];	
                                    $pRow=0;
                                    $parentNameArray='';
                                    $concatinateName='';															
                                    while($parentId!=0)
                                    {
                                        $name=$mObj -> categoryById($parentId);
                                        $parentId=$name['parentId'];
                                        $parentNameArray[$pRow] =$name['categoryName'];	
                                        $pRow++;							
                                    }								
                                                                
                                    if($parentNameArray!='')
                                    {
                                        $parentNameArray=array_reverse($parentNameArray);	
                                        
                                        for($pna=0;$pna<sizeof($parentNameArray);$pna++)
                                            $concatinateName .=$parentNameArray[$pna].' > ';
                                            
                                        $categoryName=$concatinateName.$categoryName;									
                                    }
                                    
                                    if($editid!='')
                                        $parentId = $fetch_details['parentId'];	
                                        
                                    $menucategoryIds .= $data[$i]['categoryId'].',';					
                                    
                                ?>
                                <option value="<?php echo $data[$i]['categoryId'];?>" <?php if($menucategoryId==$data[$i]['categoryId']) echo 'selected';?>><?php echo $categoryName;?></option>
                                <?php 
                                }
                                $menucategoryIds = substr($menucategoryIds,0,-1);	
                                ?>
                            </select>
                    	</span>
                    </div>
				<?php 
				}?>				
                
                <div style="float:right; margin:0px 5px 0 0;">
                	<span class="description-line-text">Display Heading
					<select name="displayHeading">
						<option value="Y">Yes</option>
						<option value="N">No</option>
					</select></span>
				</div>               
			</div>			
        </div>			
        <div class="iconbox">			
			<p  class="description-line1">
				<span class="save_button-box">
				<input name="IdToEdit" type="hidden" value="" />
				<input name="SourceForm" type="hidden" value="NewContentGeneral" />			
				<input name="Save" type="submit" class="save_frm" value="Save" />
				<input name="Cancel" type="button"  onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $moduleId;?>'" class="cancel_frm" value="Close" />
				<input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
				</span>
			</p>			
		</div>		
	</form>
</div>