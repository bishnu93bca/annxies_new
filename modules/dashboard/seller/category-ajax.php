<?php
if($categoryId)
{
    $productId = $pid;
    $cObj      = new adminCategory();
    $obj       = new adminProductClass();
    $selData   = $cObj->categoryById($categoryId);
    $cData     = $cObj->getAttributeByCategoryId(1, $categoryId, 0, 50);
        
    if($cData)
    {
        ?>
        <div class="form-group">
            <fieldset class="full_form_group">
                <legend>Category Attributes</legend>
                <div class="">
                    <?php
                    for($row=0; $row<sizeof($cData); $row++)
                    {
                        $attributeData = array();
                        ?>

                        <div class="form-group">
                            <?php
                            echo '<label>'.$cData[$row]['attributeName'].'</label>';
                            if($cData[$row]['attributeType']=='radio' || $cData[$row]['attributeType']=='checkbox')
                            {
                                if($productId)
                                    $attributeData = $obj->getAttributeByproductId("attributeId='".$cData[$row]['attributeId']."'", $productId, 0, 50);
                                $options = explode('@#@', $cData[$row]['attributeOptions']);
                                echo '<div class="col2">';
                                    foreach($options as $val)
                                    {
                                        ?>
                                        <label class="input_check">
                                            <input type="<?php echo $cData[$row]['attributeType'];?>" name="attributeValueArray_<?php echo $row;?>[]" value="<?php echo $val;?>"/><span><?php echo $val;?></span>
                                        </label>
                                        <?php                       
                                    }
                                echo '</div>';
                            }
                            else
                            {
                                if($productId)
                                    $attributeData = $obj->getAttributeByproductId(1, $productId, 0, 50);
                                $arrayKey = searchForId('attributeId', $cData[$row]['attributeId'], $attributeData);
                                ?>
                                <input class="form-control" type="text" value="<?php echo $attributeData[$arrayKey]['attributeValue'];?>" name="attributeValueArray_<?php echo $row;?>[]" />
                                <?php
                            }
                            ?>
                            <input type="hidden" name="attributeIdArray[]" value="<?php echo $cData[$row]['attributeId'];?>" />
                        </div>

                        <?php 
                    }
                    ?> 
                </div>
            </fieldset>
        </div>
        <input name="cattags" type="hidden" class="cattags" value="<?php echo $selData['tags'];?>" />

        <?php	
    }
}
?>