<?php
if($_POST['ajax'])
	include("../../../../ext_include.php");
if($categoryId)
{
	$cObj = new adminCategory();
	$obj  = new adminProductClass();
	$cData = $cObj->getAttributeByCategoryId(1, $categoryId, 0, 50);
	if($cData)
	{
		$class = "input_left";
		for($row=0; $row<sizeof($cData); $row++)
		{
			$attributeData = array();
            ?>
			<div class="<?php echo $class;?>">
				<p class="description-line1"><?php echo $cData[$row]['attributeName'];?></p>
				<?php
                if($cData[$row]['attributeType']=='radio' || $cData[$row]['attributeType']=='checkbox')
                {
                	if($productId)
                        $attributeData = $obj->getAttributeBysampleId("attributeId='".$cData[$row]['attributeId']."'", $productId, 0, 50);
                    $options = explode('@#@', $cData[$row]['attributeOptions']);
                    echo '<ul style="width:100%;">';
                    foreach($options as $val)
                    {
                        ?>
                        <li style="width:50%; float:left;">
                        <input type="<?php echo $cData[$row]['attributeType'];?>" name="attributeValueArray_<?php echo $row;?>[]" value="<?php echo $val;?>" <?php if($editid && in_array_r($val, $attributeData)) echo 'checked';?> readonly/><?php echo $val;?> 
                        </li>
                        <?php
                    }
                    echo '</ul>';
                }
                else
                {
                	if($productId)
                        $attributeData = $obj->getAttributeBysampleId(1, $productId, 0, 50);
                    
                    $arrayKey = searchForId('attributeId', $cData[$row]['attributeId'], $attributeData);
                    ?><p class="description-line1">
                    <input type="text" value="<?php echo $attributeData[$arrayKey]['attributeValue'];?>" name="attributeValueArray_<?php echo $row;?>[]" readonly/></p>
                    <?php
                }
                ?>
                <input type="hidden" name="attributeIdArray[]" value="<?php echo $cData[$row]['attributeId'];?>" />
			</div>
			<?php 
			if($class=="input_left")
				$class = "input_right";
			else
			{
				$class = "input_left";
				echo '<br class="clear" />';
			}
		}
			
		?><input name="cattags" type="hidden" class="cattags" value="<?php echo $selData['tags'];?>" /></p>

        <?php	
	}
}
?>          